# Phase 2 — Models & business logic ✅

**Goal**: real Eloquent models for everything in section 4, two reusable traits (`HasTranslations` + `HasSlug`), the `Promotion::active()` scope, and feature tests covering the section-6 filter query and the promotion scope.

## What already exists from earlier phases

- `App\Models\User` — full Fortify model.
- `App\Models\Product` — `#[Fillable]` + casts only, no relationships.
- `App\Models\ProductVariant` — `#[Fillable]` + casts only, no relationships.

Phase 1 seeders already write `App\Models\Category|Attribute|AttributeValue` as the literal `translatable_type` strings, so Phase 2 models will line up with the existing data without any migration backfill.

---

## Approach decisions (please confirm before I execute)

1. **`HasSlug` API**. The slug needs to be generated *before* the entity is first saved (the column is `NOT NULL` and unique), but the German name lives in `translations` rows that are written *after* the entity. My proposal: a transient setter `$model->setSlugSource('Damenparfums')` that the caller (admin controller in Phase 3, tests now) invokes before `save()`. The trait hooks into `saving`, sees the source, runs `Str::slug($source, '-', 'de')` (gives correct ä/ö/ü/ß handling), and resolves collisions with `-2`/`-3`/… by querying the same model's table. This is explicit and test-friendly. The alternative (have the trait dig into `HasTranslations`'s in-memory pending translations) couples the two traits and makes ordering subtle. **Confirm or override.**
2. **`HasTranslations` API**. `translations()` morphMany; `$model->translate($locale, $field, $fallback = null)` returning `?string`; `$model->setTranslation($locale, $field, $value)` for write paths. Reads work off the loaded relation when present (so eager-loading is meaningful). **Confirm.**
3. **No morph map**. Phase 1 wrote literal FQNs (`App\Models\Category` etc.) into `translations.translatable_type`. The Phase 2 models will use Eloquent's default `getMorphClass()`, which also returns the FQN — so the existing rows will resolve correctly without introducing a `Relation::morphMap`. If you'd rather use a short alias map (`'category'`, `'product'`, …), say so and I'll set that up plus migrate the existing rows. **Confirm "no map" or override.**
4. **Trait location**. `app/Models/Concerns/HasTranslations.php` and `app/Models/Concerns/HasSlug.php` (Laravel-conventional). **Confirm.**
5. **Refactor Phase 1 seeders** ✅ (per your call). After the models + traits land, rewrite `CategorySeeder` / `AttributeSeeder` / `AttributeValueSeeder` to construct entities through their models and call `setTranslation('de', 'name', …)` from `HasTranslations`. Keeps idempotency via `firstOrCreate`/`updateOrCreate`. Side-benefit: this exercises both new traits as part of `migrate:fresh --seed`.
6. **Test DB**. Feature tests still run against in-memory SQLite. The Phase-2 tests don't hit `jsonb` or anything Postgres-specific, so this is fine. Phase 3/4 may want a Postgres test DB later — flagging only.

---

## Tasks (in order)

### 1. Traits

- [x] `app/Models/Concerns/HasTranslations.php`:
  - `translations(): MorphMany` to `Translation::class`.
  - `translate(string $locale, string $field, ?string $fallback = null): ?string` — prefers the in-memory loaded relation if present, otherwise queries; falls back to the given locale if missing.
  - `setTranslation(string $locale, string $field, string $value): void` — `updateOrCreate` against `(locale, field)`.
- [x] `app/Models/Concerns/HasSlug.php`:
  - Transient `protected ?string $slugSource = null;` + `setSlugSource(string): static` (chainable).
  - `bootHasSlug()` registers a `saving` hook: if `slug` is empty and `$slugSource` is set, generates `Str::slug($source, '-', 'de')`, then resolves collisions by appending `-2`, `-3`, … against the same table (excluding the current row when updating).
  - Used by `Product`, `Category`, `AttributeValue` (these have a `slug` column).

### 2. Translation + Media models

- [x] `App\Models\Translation` — `morphTo('translatable')`, `#[Fillable(['translatable_type','translatable_id','locale','field','value'])]`. No further behavior.
- [x] `App\Models\Media` — `morphTo('mediable')`, `#[Fillable(['mediable_type','mediable_id','path','alt_text','sort_order','is_primary'])]`, casts `is_primary`/`sort_order`. `scopePrimary($q)` filters `is_primary = true`. Uses `HasTranslations` (alt_text is translatable per the spec, even if we don't seed AR/EN now).

### 3. Domain models

- [x] `App\Models\Category`:
  - `HasTranslations`, `HasSlug`, `HasFactory` (factory comes Phase 3 — leave the trait alone for now).
  - `parent(): BelongsTo` self, `children(): HasMany` self.
  - `products(): BelongsToMany` via `category_product`.
  - `media(): MorphMany` and `translations(): MorphMany` (latter from trait).
- [x] `App\Models\Attribute`:
  - `HasTranslations`. (No slug column — uses `code`.)
  - `values(): HasMany` to `AttributeValue::class`.
- [x] `App\Models\AttributeValue`:
  - `HasTranslations`, `HasSlug`.
  - `attribute(): BelongsTo`.
  - `products(): BelongsToMany` via `product_attribute_value`.
- [x] `App\Models\Product` (extend the existing minimal model):
  - Add `HasTranslations`, `HasSlug`.
  - `categories(): BelongsToMany` via `category_product`.
  - `attributeValues(): BelongsToMany` via `product_attribute_value`.
  - `variants(): HasMany` to `ProductVariant::class`.
  - `media(): MorphMany`.
  - `primaryMedia(): MorphOne` filtered to `is_primary = true` (handy for product-card render in Phase 4).
- [x] `App\Models\ProductVariant` (extend existing): add `product(): BelongsTo`. (This unblocks `for($p)` in factories — fixing the Phase 1 carry-over.)
- [x] `App\Models\PageSection`:
  - `HasTranslations`.
  - `#[Fillable(['key','type','payload','sort_order','is_active'])]`, casts `payload` to `array`, `is_active` to bool.
- [x] `App\Models\Promotion`:
  - `HasTranslations`, `HasSlug`.
  - Casts `starts_at`/`ends_at` to `datetime`, booleans/integers as appropriate.
  - `scopeActive(Builder $q): Builder` per the spec query: `is_active = true AND (starts_at IS NULL OR starts_at <= now()) AND (ends_at IS NULL OR ends_at > now())`. **Default ordering is the caller's responsibility** (the helper in section 4.8 adds `orderBy('sort_order')` outside the scope; keeping the scope a pure filter is more composable).
- [x] `App\Models\Setting`:
  - `protected $primaryKey = 'key'; public $incrementing = false; protected $keyType = 'string';`
  - `const CREATED_AT = null;` (table only has `updated_at`).
  - `#[Fillable(['key','value'])]`.
  - Static helpers `Setting::get(string $key, $default = null)` and `Setting::put(string $key, string $value)` for ergonomic key/value access (Phase 4 consumes these for the contact sidebar; building them now keeps the model self-contained).

### 4. Factories (extend Phase 1 set so tests can build the graph)

We need just enough factories for the Phase-2 tests to construct the section-6 example.

- [x] `CategoryFactory` — `slug` from a fake unique slug + suffix. (No factory-level translation yet; tests that need a name will create it via `setTranslation`.)
- [x] `AttributeFactory` — `code` unique, `is_multiple` parameterized via state (`single()`, `multiple()`).
- [x] `AttributeValueFactory` — `attribute_id` via `Attribute::factory()`, unique slug per attribute.
- [x] `PromotionFactory` — `slug` unique, `is_active = true`, all dates null. States: `expired()`, `upcoming()`, `disabled()`, `withWindow(starts, ends)`.
- [x] (Existing `ProductFactory`/`ProductVariantFactory` are reused.)

### 5. Feature tests

- [x] `tests/Feature/FilterQueryTest.php`:
  - Replicates the section-6 example. Builds: a `damenparfums` category, attribute values (`blumig`, `frisch`, `rose`), and four products — one matching all three values + category, plus three near-misses (missing one value each, or in a different category). Asserts the section-6 query returns exactly the matching product.
  - Also asserts the count assertion `'=', 3` is what enforces the AND across values (a product with only 2 of the 3 isn't returned).
  - Includes one assertion using `withMin('variants', 'price')` ordering to mirror the spec query end-to-end.
- [x] `tests/Feature/PromotionScopeTest.php`:
  - 5 cases: active/no window, active/within window, active/before window (starts_at in future), active/expired (ends_at in past), inactive flag. Asserts `Promotion::active()->pluck('id')` matches the expected subset.
- [x] `tests/Unit/HasSlugTest.php`:
  - Saving with no `slugSource` and an existing `slug` keeps the slug.
  - Saving with `slugSource = 'Damenparfums'` and empty slug → `damenparfums`.
  - Saving a second entity with the same source → `damenparfums-2`; third → `damenparfums-3`.
  - `Maiglöckchen` → `maigloeckchen` (umlaut transliteration check).
  - Updating an existing row with the same source as itself doesn't append `-2` (excludes self in collision check).
- [x] `tests/Unit/HasTranslationsTest.php`:
  - `setTranslation()` writes a row; `translate()` reads it.
  - `translate('en', 'name', fallback: 'de')` returns the `de` value when `en` is missing.
  - Eager-loaded `translations` relation is preferred over a fresh query.

### 6. Verification

- [x] `php artisan migrate:fresh --seed` — clean (model-based seeders run via `HasTranslations::setTranslation`).
- [x] `php artisan test --compact` — **58/58 pass**, 161 assertions (41 prior + 17 new across `FilterQueryTest`, `PromotionScopeTest`, `HasSlugTest`, `HasTranslationsTest`).
- [x] `vendor/bin/pint --dirty --format agent` — clean.
- [x] Tinker probe: `Category::with('translations')->where('slug','arabische-parfums')->first()->translate('de','name')` → `Arabische Parfums`. Phase-1 morph rows resolve through Phase-2 models without a backfill.

### 7. Bookkeeping

- [x] Tick boxes in this file as I go; if a step needs splitting/changing, edit this file rather than silently deviate.
- [x] Append a Phase 2 line to `PROGRESS.md`.

---

---

## Side adjustments worth noting

- **Pivot table name**: `belongsToMany(AttributeValue::class)` defaulted to `attribute_value_product` (alphabetized), but our migration is `product_attribute_value`. Pinned the table name explicitly on both `Product::attributeValues()` and `AttributeValue::products()`. The `category_product` pivot happens to align with Eloquent's default and didn't need it.
- **Trait tests in Feature/**: `HasSlugTest` and `HasTranslationsTest` need a real DB. Pest's `RefreshDatabase` is wired to the `Feature/` suite only, so the `make:test --unit` files were moved into `tests/Feature/` instead of adding the trait per-file.

## Out of scope for Phase 2 (deferred)

- Admin CRUD (Phase 3).
- Public site rendering (Phase 4).
- AR/EN translations (Phase 5).
- SEO / meta-title rendering (Phase 6).
- Slug source from in-memory translations: keeping the explicit `setSlugSource()` API for now; if Phase 3 reveals it's awkward in the controller, we can add a convenience integration with `HasTranslations` then.
