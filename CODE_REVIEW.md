# Code Review Report — Goan Perfumes

**Date:** 2026-06-10 · **Branch:** `improve/all`
**Health check:** ✅ 153 tests pass (1075 assertions, 7 skipped) · ✅ `tsc --noEmit` clean · ✅ ESLint clean

Overall the codebase is in good shape: consistent conventions, Form Requests with ownership/after-validation checks everywhere, eager loading is used consistently, transactions wrap multi-step writes, and test coverage of the dashboard CRUD and auth flows is solid. The items below are ordered by impact.

---

## 1. Functional issues / likely bugs

### ✅ 1.1 `featured_products` page section is editable but never rendered (HIGH) — DONE
The dashboard lets admins curate a `featured_products` section with a `payload.product_ids` list (`PageSectionController`, `UpdatePageSectionRequest`, `PageSectionSeeder`), but the public home page ignores it entirely — `HomeController` renders featured products from the `Product.is_featured` flag, and `PublicController::pageSections()` only fetches `hero`, `about`, `why_us`. Two competing mechanisms exist for the same feature; an admin curating that section sees no effect.
**Fixed 2026-06-10:** kept the `is_featured` flag as the single mechanism. Removed the `featured_products` section via migration (`remove_featured_products_page_section`), dropped it from the seeder, and stripped the section's handling from `PageSectionController`, `UpdatePageSectionRequest`, and the React page-section form.

### ✅ 1.2 Product slugs regenerate on every rename — old URLs break (HIGH) — DONE
`ProductController::update()` sets `$product->slug = ''` and re-derives the slug from the German name on every save. Renaming a product silently changes its public URL with no redirect from the old slug, breaking shared links, search-engine listings, and WhatsApp messages already sent to customers. Same pattern exists in `CategoryController`.
**Fixed 2026-06-10:** slugs are now generated once on create and stay stable on update — the regeneration lines were removed from `ProductController::update()` and `CategoryController::update()`; tests assert the slug no longer changes on rename.

### ✅ 1.3 File deletes inside DB transactions can desync storage and DB (MEDIUM) — DONE
`ProductController::destroy()`, `MediaService::deleteRemoved()` (called from store/update transactions), and the hero image/video deletes in `PageSectionController::update()` call `Storage::delete()` inside `DB::transaction()`. If the transaction rolls back after the delete, the DB row survives but the file is gone (broken image). The reverse risk also exists: media rows created, then a later step throws, leaving orphaned uploaded files.
**Fixed 2026-06-10:** all in-transaction file deletes (media service, product destroy, hero image/video, category banners) now run via `DB::afterCommit()`; `MediaService` also deletes freshly stored uploads when the sync throws, and `SettingsController` persists the new logo path before deleting the old file. Covered by new rollback/commit tests in `MediaServiceTest`.

### ✅ 1.4 Featured-limit check is racy (LOW) — DONE
`validateFeaturedLimit()` counts featured products at validation time, outside the write transaction. Two concurrent saves can both pass and exceed the limit of 4. With a single admin this is mostly theoretical — note it, don't necessarily fix it.
**Fixed 2026-06-10:** the check moved from the form request into the store/update transactions (`ProductController::assertFeaturedSlotAvailable()`) using a `lockForUpdate()` count, which also removed the duplicated `MAX_FEATURED_PRODUCTS` constant. Covered by store + update limit tests.

---

## 2. Security

### ✅ 2.1 Full `User` model shared with every Inertia page (MEDIUM) — DONE
`HandleInertiaRequests::share()` passes `$request->user()` directly. Hidden attributes (`password`, 2FA secrets) are stripped, but `id`, `email`, `is_admin`, `email_verified_at`, and timestamps are serialized into the page props of **every** page, including public ones, for any logged-in user.
**Fixed 2026-06-10:** the shared `auth.user` is now `$request->user()?->only(['id', 'name', 'email', 'email_verified_at'])`; the TS `User` type was trimmed to match and a test asserts no other fields leak.

### ✅ 2.2 SVG logo upload allowed (LOW) — DONE
`UpdateSettingsRequest` accepts `svg` for the site logo. SVGs can carry embedded scripts; the file is served from the public disk. Risk is low (admin-only upload, rendered via `<img>` which doesn't execute scripts), but if the logo URL is ever opened directly it executes in your origin.
**Fixed 2026-06-10:** `svg` removed from the logo mimes list; a test asserts SVG uploads are rejected.

### 2.3 Things that are already good (no action)
- All dashboard routes behind `auth + verified + admin`, plus `authorize()` re-checks `is_admin` in every Form Request — defense in depth. ✔
- Ownership validation for variants/media prevents IDOR. ✔
- Upload validation covers type and size everywhere. ✔
- Registration/password-reset disabled for this admin-only setup; login throttling and 2FA enabled via Fortify. ✔
- `DB::prohibitDestructiveCommands()` and strong production password defaults in `AppServiceProvider`. ✔

---

## 3. Performance

### ✅ 3.1 `Setting::get()` issues one query per call (MEDIUM) — DONE
Every public page calls `contactSettings()` (6 settings) plus `logoUrl()` — 7 separate `settings` queries per request, and the dashboard settings page issues 8 more. The category navigation is already cached forever; settings are not cached at all.
**Fixed 2026-06-10:** all settings are now loaded from a single forever-cached map (`Cache::rememberForever('settings:all')`), flushed automatically on save/delete and via `Setting::flushCache()`; covered by `SettingTest`.

### ✅ 3.2 Duplicate attribute queries on category pages (LOW) — DONE
`CategoryController::show()` calls `selectedFilters()` (plucks filterable attribute codes) and then `filterGroups()` (loads the same attributes again with values/translations). One query could feed both.
**Fixed 2026-06-10:** `PublicController::filterableAttributes()` loads the filterable attributes (with values and translations) once per request; `selectedFilters()` and `filterGroups()` both read from it.

### ✅ 3.3 Unpaginated admin lists (LOW — scale risk) — DONE
`Dashboard\ProductController::index()` and `PageSectionController::productOptions()` load **all** products with translations, categories, and media. Fine for the current catalog size, but page sections' product picker and the product index will degrade together as the catalog grows. Consider pagination/search on the index and an async-search picker before the catalog reaches hundreds of products.
**Fixed 2026-06-10:** the dashboard product index is paginated (25 per page) with pagination controls in the React page; `PageSectionController::productOptions()` was already removed together with the `featured_products` section (finding 1.1).

### ✅ 3.4 Enable strict mode in development (LOW) — DONE
`Model::shouldBeStrict(! app()->isProduction())` in `AppServiceProvider::boot()` would catch lazy-loading (N+1) and discarded-attribute mistakes early. The codebase eager-loads well today; this keeps it that way.
**Fixed 2026-06-10:** strict mode is enabled outside production. It immediately caught one gap — `UserFactory` didn't set `is_admin`, so in-memory factory users lacked the attribute — which is now part of the factory definition.

### ✅ 3.5 `HasTranslations::setTranslation()` reloads the whole relation per call (LOW) — DONE
When the `translations` relation is loaded, each `setTranslation()` re-fetches **all** translations (`$this->translations()->getResults()`). `syncTranslations()` calls it in a loop (3 locales × 5 fields), so saving a product with loaded translations can trigger ~15 full reloads. Push/replace the single model in the loaded collection instead, or unset the relation once and reload after the loop.
**Fixed 2026-06-10:** the loaded collection is now patched in place (reject the old entry, push the updated one); a query-count test asserts no extra select is issued.

---

## 4. Code duplication / maintainability

| Duplication | Locations | Suggestion |
|---|---|---|
| `LOCALES = ['de', 'ar', 'en']` | `Dashboard\ProductController`, `PageSectionController`, `MediaService` (+ implicit in `PublicLocale`) | Single source: `PublicLocale::codes()` |
| `MAX_FEATURED_PRODUCTS = 4` | `Dashboard\ProductController`, `ValidatesProductFields` | One shared constant (e.g. on `Product`) |
| `storageUrl()` helper | `PublicController`, `PublicCategoryNavigation` | Extract to a small support class/helper |
| `decodeBulletPoints()` | `PublicController`, `PageSectionController` | Same — or cast `bullet_points` via a value object |
| Translation sync loop (delete-empty / set) | `Dashboard\ProductController::syncTranslations()`, `PageSectionController::syncTranslations()`, `MediaService::syncAltTextTranslations()` | Add `syncTranslations(array $byLocale, array $fields)` to the `HasTranslations` trait |
| `decimal()` formatting | `Dashboard\ProductController`, `PublicController` | Shared formatter (or cast prices with `decimal:2`) |

Also worth considering (optional, only if the team agrees): the dashboard controllers shape large response arrays inline. Extracting Eloquent API Resources (or dedicated presenter classes) would shrink controllers like `Dashboard\ProductController` (405 lines) considerably. The current pattern is at least consistent.

---

## 5. i18n / SEO gaps

- **German-only fallback meta:** `PublicController::meta()` hardcodes a German default description, and `ContactController` hardcodes a German title/description — these are served for `ar` and `en` pages too. Move them to `lang/` files keyed by locale.
- **Toast messages hardcoded in German** in all dashboard controllers ("Produkt angelegt." etc.). Fine if the dashboard is intentionally German-only; otherwise move to lang files.
- **`EnsureUserIsAdmin`** flashes a German error message; same consideration.
- No sitemap or `hreflang` alternates are emitted for the three locales — worth adding for a public storefront with localized URLs.

---

## 6. Testing

- Coverage of dashboard CRUD, auth, locale handling, filters, slugs, translations, and media service is good.
- `tests/Unit/ExampleTest.php` and `tests/Feature/ExampleTest.php` are starter-kit placeholders — replace or remove (needs approval before deleting).
- Missing coverage worth adding:
  - Public product detail page edge cases (inactive product 404s, inactive variants hidden).
  - `Setting`-driven contact links (WhatsApp URL digit-stripping, mailto/tel formatting).
  - A regression test for whichever direction you choose on finding **1.1** (featured products source of truth) and **1.2** (slug stability).
- Consider `LazilyRefreshDatabase` in `tests/Pest.php` for faster runs as the suite grows (suite is currently fast at ~1.6s, so optional).

---

## 7. Housekeeping

- `composer.json` still says `"name": "laravel/react-starter-kit"` with the skeleton description — rename to the actual project.
- `tests/Pest.php` contains the unused placeholder `function something() {}` and the example `toBeOne` expectation — remove.
- `HandleInertiaRequests::version()` only calls `parent::version()` — the override can be deleted.
- `Setting` model: `public const CREATED_AT = null;` but the table has `updated_at` only via `updateOrCreate`; verify the migration matches (cosmetic).
- The four root-level redirect routes in `routes/web.php` repeat the same cookie-normalize-redirect closure — a single catch-all `Route::get('/{path?}')->where('path', '.*')` redirect (or a tiny controller) would remove the duplication.

---

## Suggested priority order

1. ~~Decide and fix the featured-products source of truth (**1.1**)~~ ✅ Fixed 2026-06-10 — kept the `is_featured` flag; removed the unused `featured_products` page section (migration, seeder, dashboard UI).
2. ~~Stop regenerating slugs on rename, or add slug-history redirects (**1.2**)~~ ✅ Fixed 2026-06-10 — slugs are now generated once on create and stay stable on update.
3. ~~Whitelist shared auth user fields (**2.1**)~~ ✅ Fixed 2026-06-10 — only `id`, `name`, `email`, `email_verified_at` are shared.
4. ~~Cache/batch settings reads (**3.1**)~~ ✅ Fixed 2026-06-10 — settings are cached forever and flushed on save/delete.
5. ~~Move file deletes out of transactions (**1.3**)~~ ✅ Fixed 2026-06-10 — deferred via `DB::afterCommit()`, with upload cleanup on failure.
6. Deduplicate locales/constants/helpers (**§4**)
7. i18n the public meta fallbacks (**§5**)
8. Housekeeping (**§7**)
