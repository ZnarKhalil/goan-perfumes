# Phase 3 — Admin dashboard (German-only)

**Goal**: full CRUD UI inside `/dashboard` for every admin-managed entity from sections 4.1–4.9 (Categories, Attributes, Attribute Values, Products + Variants, Page Sections, Promotions, Settings), with image uploads landing in `media/`, FormRequest validation server-side, Inertia `useForm` validation client-side, and DE/AR/EN translation tabs only on translatable fields. Surrounding admin UI is German-only.

## What already exists from earlier phases

- **Models & traits** (Phase 2): every entity has its model, relationships, `HasTranslations` (`translate`/`setTranslation`), `HasSlug` (`setSlugSource`), `Promotion::scopeActive`, `Setting::get/put`. Pivot names already pinned.
- **Auth & shell**: Fortify in place; `EnsureUserIsAdmin` middleware aliased `admin`; `routes/web.php` already wraps the dashboard route in `['auth','verified','admin']`. Inertia v3 + React 19 + Tailwind v4 + Wayfinder are wired. Sidebar layout (`AppSidebar`/`NavMain`) renders one item ("Dashboard") today.
- **Settings sub-routes**: `routes/settings.php` follows the Fortify-style `Settings/` controllers + `resources/js/pages/settings/*.tsx` pattern — useful template for nested resource pages.
- **Public storage**: `php artisan storage:link` is done (Phase 0). Uploads to `storage/app/public/...` are reachable via `Storage::url(...)`.
- **Seed data**: 7 categories, 4 attributes, 63 attribute values, 74 DE translation rows. No products/promotions yet — admin UI will be the way they enter the system.

---

## Approach decisions (please confirm before I execute)

1. **Routing layout**. One namespaced group, all under `/dashboard`, all behind `['auth','verified','admin']`:
   ```
   /dashboard                       → existing overview
   /dashboard/products              Route::resource('products', …)
   /dashboard/categories            Route::resource('categories', …)
   /dashboard/attributes            Route::resource('attributes', …)
     /dashboard/attributes/{attribute}/values   nested resource for AttributeValue
   /dashboard/promotions            Route::resource('promotions', …)
   /dashboard/page-sections         index + edit + update only (4 fixed records)
   /dashboard/settings/site         single edit + update view (NOT under /settings/* — that namespace is owned by the user-account Fortify pages)
   ```
   Routes live in a new `routes/dashboard.php` required from `web.php`, controllers in `app/Http/Controllers/Dashboard/`, FormRequests in `app/Http/Requests/Dashboard/`. **Confirm or override.**

2. **Attribute values: nested route, flat UI**. Backend is nested (`/dashboard/attributes/{attribute}/values/{value}`) so the parent attribute is implicit and FormRequests can validate `(attribute_id, slug)` uniqueness in scope. Frontend renders the values table inline on the attribute edit page (one combined screen per attribute), so admins don't navigate twice. **Confirm.**

3. **Page Sections: edit-only, fixed set**. The four keys (`hero`, `about`, `why_us`, `featured_products`) are seeded once (need to add a `PageSectionSeeder` — currently absent) and the admin UI exposes only `index` + `edit` + `update`. Each `type` gets a custom payload editor:
   - `hero`: image upload + cta text (translatable).
   - `about`: title + body (translatable rich-ish textarea — plain textarea for now, mark as upgradable to a WYSIWYG later).
   - `why_us`: title + repeating bullet list (translatable per-bullet).
   - `featured_products`: multi-select of products (sortable list of product IDs).
   No create/delete from the UI. **Confirm.**

4. **Settings: typed form, known keys**. Single edit form for the keys named in §4.9: `whatsapp_number`, `email`, `phone`, `instagram_url`, `tiktok_url`, `facebook_url`, `default_locale`, `logo_path`. Each has its own typed input (URL, email, file for logo, select for locale). The underlying storage is still the generic key-value `settings` table via `Setting::put()`. No generic "add a new key" UI. **Confirm.**

5. **Image upload UX**. One reusable React component `<MediaUploader>`:
   - Multi-image dropzone (drag-drop + click-to-pick), thumbnails, drag-to-reorder for `sort_order`, "Als Hauptbild" toggle for `is_primary`, alt-text input per image (DE/AR/EN tabs).
   - Upload happens as part of the parent form submit (multipart), not via a separate endpoint — keeps validation transactional.
   - Server side: a `StoresMedia` controller trait (or service class — leaning service, `MediaService::syncFromRequest($model, array $files, array $meta)`) handles persisting files to `storage/app/public/media/{type}/{id}/`, recording `media` rows, deleting removed ones, updating sort/primary.
   - Promotions and PageSections.hero use a single-image variant of the same component (no reorder/primary toggle).
   **Confirm — particularly the "submit as multipart with the parent form" choice over a separate upload endpoint.**

6. **Translation tabs UX**. Reusable `<TranslationTabs locales={['de','ar','en']} fields={[...]} />`. The DE tab has `required` markers; AR/EN are optional and fall back to DE. The component just renders the inputs and binds them to a nested `translations.{locale}.{field}` shape on the form data. The controller flattens that into `setTranslation()` calls per locale/field. **Confirm shape.**

7. **Slug field UX**. Editable text input that auto-fills from the DE name on first input (debounced 300ms) and stops auto-filling once the admin has manually edited it. Server still runs `HasSlug::setSlugSource()` as a safety net if the field is empty. This matches the Phase 2 design decision: "auto-generate when empty so admins can override". **Confirm.**

8. **Validation strategy**. Each resource gets a single `StoreXRequest` and `UpdateXRequest` (or one shared request class with `is_creating()` switch — going with two for clarity). Inertia returns 422 → `useForm`'s `errors` exposes them per-field, including the nested `translations.de.name` paths. **Confirm two-class-per-resource.**

9. **Wayfinder TS bindings**. Each new controller gets imported in the React layer via `@/actions/Dashboard/...`. No hardcoded URLs. `npm run build` (which we just baked into `composer ci:check`) will fail if a controller method is referenced before generation, so the dev loop is: write controller → `php artisan wayfinder:generate` → consume in React. **Confirm — also: should I add a `composer ci:check` pre-step to run wayfinder:generate, or trust the Vite plugin that's already wired?**

10. **Test coverage** (Phase 2 set the floor at 58 passing). For each resource controller, one Feature test covering: index renders, store creates + writes translations + uploads media (using `Storage::fake()`), update mutates incl. removing media, delete cascades. One ability test asserting non-admins are blocked. Skipping React component-level tests (no Pest 4 browser tests yet — happy to add later if you want). **Confirm scope.**

11. **Sidebar / nav extension**. Update `AppSidebar` `mainNavItems` to add: Produkte, Kategorien, Attribute, Aktionen, Seiten-Inhalt, Einstellungen (each pointing to its index). Icons from `lucide-react`. **Confirm German labels are these.**

12. **No background jobs / queues**. Image processing (resize, thumbnail) is **out of scope** — files store as uploaded. §6 Phase will revisit. **Confirm.**

---

## Tasks (in order)

### 1. Routing & controller skeleton

- [x] `routes/dashboard.php` (Categories only this step; rest added per resource step). Required from `web.php`.
- [ ] `app/Http/Controllers/Dashboard/` directory with: `ProductController`, ~~`CategoryController`~~ ✅, `AttributeController`, `AttributeValueController`, `PromotionController`, `PageSectionController`, `SettingsController`.
- [x] CategoryController `index`/`create`/`edit` return `Inertia::render('dashboard/categories/...')` with documented payload shape.
- [x] Wayfinder regen step (`php artisan wayfinder:generate`) emits `@/actions/App/Http/Controllers/Dashboard/...` and `@/routes/dashboard/...`.

### 2. FormRequests

- [ ] `Store{X}Request` + `Update{X}Request` for: Product, ~~Category~~ ✅, Attribute, AttributeValue, Promotion, PageSection, Settings.
- [x] Shared traits in `app/Http/Requests/Concerns/`: `ValidatesTranslatedFields` (locale × field rule generator) and `ValidatesCategoryFields`. Authorization gated on `auth()->user()?->is_admin`.
- [x] DE name required; other DE fields + all AR/EN fields nullable. Slug uniqueness scoped (Store: unique; Update: ignore self).

### 3. Reusable React building blocks

- [x] `resources/js/components/dashboard/translation-tabs.tsx` — DE/AR/EN tabs, binds `translations[locale][field]`.
- [x] `resources/js/components/dashboard/media-uploader.tsx` — multi/single mode, drag-reorder via `@dnd-kit/*`, primary toggle, alt-text per item.
- [x] `resources/js/components/dashboard/data-table.tsx` — minimal table wrapper with column config + actions slot.
- [x] `resources/js/components/dashboard/slug-field.tsx` — debounced auto-fill from the DE name, untouched-flag tracking via ref.
- [ ] `resources/js/components/dashboard/variant-row-editor.tsx` — deferred to Step 3.3 (Products).
- [x] `resources/js/components/ui/tabs.tsx` — shadcn Tabs primitive (Radix wrapper).
- [x] Dependencies installed: `@dnd-kit/core`, `@dnd-kit/sortable`, `@dnd-kit/utilities`, `@radix-ui/react-tabs`.

### 4. Sidebar navigation

- [x] `AppSidebar` → `mainNavItems` extended with **Kategorien** in this step. Other entries land in their respective resource steps.
- [ ] Group separator above "Einstellungen" if the list feels cluttered (re-evaluate after all resources land).

### 5. Resource: Categories (smallest — good first integration) ✅

- [x] `dashboard/categories/index.tsx` — table with banner thumbnail, DE name, parent, sort, active badge, edit/delete buttons.
- [x] `dashboard/categories/{create,edit}.tsx` — form with TranslationTabs (name/desc/meta), parent select (excludes self + descendants on edit), sort, active checkbox, banner upload (MediaUploader single + remove flag).
- [x] Controller + requests wired; **9 Feature tests** cover index render, store w/ banner + translations, missing-DE-name rejection, duplicate-slug rejection, update + banner replacement, translation deletion when blanked, destroy + banner cleanup, descendant exclusion in parent select. **67/67** Pest tests, **220** assertions.
- [x] **Side note**: `UserFactory::admin()` state added (was needed for tests). Phase 0 middleware redirects non-admins to `/` (302) instead of 403 — test asserts the actual behavior.
- [x] **Side note**: trait `ValidatesTranslatedFields` was originally over-eager (required *all* fields on the required locale). Refactored to take an explicit `requiredOn:` list — only `name` is required.

### 6. Resource: Attributes (with inline AttributeValues editor)

- [ ] `dashboard/attributes/index.tsx` — table; create/edit/delete.
- [ ] `dashboard/attributes/edit.tsx` — main form (code, sort, is_filterable, is_multiple, name translations) **plus** a nested values editor using `data-table` + a side panel for create/edit-value (so admins don't navigate away). Posts to the nested `attributes.values.*` routes.
- [ ] AttributeValueController + requests; tests including nested-route auth + uniqueness scoping per attribute.

### 7. Resource: Products (the big one)

- [ ] `dashboard/products/index.tsx` — table with primary image thumbnail, name DE, brand, category list, price range (`withMin/withMax variants.price`), is_active, is_featured, edit/delete.
- [ ] `dashboard/products/{create,edit}.tsx` — form with: slug, brand, is_active, is_featured, name/short/description/meta translations (TranslationTabs), categories multi-select, attribute_values grouped multi-select per attribute (respecting `is_multiple`), variants editor (variant-row-editor), media (multi MediaUploader).
- [ ] Controller persists in a transaction: product → translations → categories sync → attribute_values sync → variants upsert (delete missing) → media sync.
- [ ] Tests cover: create with full graph, update reordering variants/media, attribute-value AND/OR validation surfaces, media file persistence via `Storage::fake('public')`.

### 8. Resource: Promotions

- [ ] `dashboard/promotions/index.tsx` — table with active/upcoming/expired badge (uses `Promotion::scopeActive` + date comparison in PHP), edit/delete.
- [ ] `dashboard/promotions/{create,edit}.tsx` — form with: slug, background_image (MediaUploader single — *or* `background_image_path` typed text? leaning MediaUploader since the spec says "background image upload"), background_color picker, link_url, promo_code, discount_percent, starts_at/ends_at (HTML5 `datetime-local` for now — flag-only on a real date picker), sort, is_active, badge/title/subtitle/cta translations.
- [ ] Controller + tests, including `scopeActive` round-trip after create.

### 9. Resource: Page Sections (edit-only)

- [ ] `database/seeders/PageSectionSeeder.php` — idempotent seeding of the four keys with empty payloads (run on every `migrate:fresh --seed`); add to `DatabaseSeeder`.
- [ ] `dashboard/page-sections/index.tsx` — list of the four sections, status badges, edit links.
- [ ] `dashboard/page-sections/edit.tsx` — `switch` on `type` selecting the right payload editor (decision #3). Translations via TranslationTabs.
- [ ] Controller + request; test that each type's payload survives a round-trip.

### 10. Resource: Settings

- [ ] `dashboard/settings/site.tsx` — typed form per decision #4.
- [ ] `SettingsController@edit/update` reads/writes via `Setting::get`/`Setting::put`. Logo file upload writes to `storage/app/public/branding/` and stores the relative path in `logo_path`.
- [ ] Test covering each key round-trip.

### 11. Media service + reusable file plumbing

- [ ] `app/Services/MediaService.php` with `syncFromRequest(Model $model, array $uploads, array $meta, string $disk = 'public')`. Handles: storing new files under `media/{type}/{id}/{ulid}.{ext}`, deleting removed ones, updating `sort_order`/`is_primary`/`alt_text` (incl. translations), preserving existing rows when only meta changes.
- [ ] Pulled from controllers; tested via `MediaServiceTest` with `Storage::fake()`.

### 12. Layout & DX

- [ ] German UI strings: extract to `resources/js/lib/de.ts` (small constant map) so the per-page `Head title` and labels read from one place — eases a future `useTranslate` introduction without scattered changes.
- [ ] All dashboard pages set `<Head title="… · Goan Perfume Admin">`.
- [ ] Each page sets `Page.layout = AppSidebarLayout` with breadcrumbs.

### 13. Verification

- [ ] `php artisan migrate:fresh --seed` clean (now includes `PageSectionSeeder`).
- [ ] `composer ci:check` green: ESLint + Prettier + tsc + `npm run build` + Pint check + Pest. Targeting **roughly 75–85 tests** (58 baseline + ~20 new feature/service tests).
- [ ] Manual click-through: create a category → attribute value → product (with two variants, two images, three categories) → set as featured → flip is_active → delete; log in and out as the admin to make sure the middleware still gates everything.
- [ ] `vendor/bin/pint --dirty --format agent` clean.

### 14. Bookkeeping

- [ ] Tick boxes in this file as work lands; if a step needs re-shaping, edit the file rather than silently deviate (Phase 2 convention).
- [ ] Append a Phase 3 line to `PROGRESS.md` summarizing what shipped + any carry-overs.

---

## Out of scope for Phase 3 (deferred)

- Public site rendering (Phase 4).
- AR/EN content authored beyond what the admin types — i.e., no auto-translation, no bulk import.
- Image resizing / responsive variants (Phase 6).
- WYSIWYG editor for descriptions — plain textarea for now.
- Activity log / audit trail — not in spec.
- A real date-time picker component (using native `datetime-local` for now).
- Sortable bulk actions on tables.
- Dashboard-level search / filtering on the resource indexes (a simple per-column input is in scope for Products, but full faceted search is not).

---

## Open questions for you

Listed inline above as **Confirm** — items #1–#12. The biggest commitments are:
- Whether to nest AttributeValues (#2),
- The single-form multipart approach for media (#5),
- Adding `@dnd-kit` as a dependency for drag-reorder (#3 task 2),
- Page Sections being edit-only with a fixed seeder (#3),
- Test scope at the Feature level only — no browser tests yet (#10).

Once you've signed off (or redirected) on those, I'll start at task 1.
