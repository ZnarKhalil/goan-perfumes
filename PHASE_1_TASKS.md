# Phase 1 — Schema & seed data ✅

**Goal**: every table from section 4 of `docs/PROJECT.md` exists in Postgres with the right FKs, indexes, and uniques; categories + attributes + attribute_values are seeded with their German translations; `Product` and `ProductVariant` factories exist; `migrate:fresh --seed` runs cleanly.

## Approach decisions (confirmed)

1. ✅ Custom polymorphic `translations` table — no spatie/astrotomic package.
2. ✅ Explicit `timestampsTz()` / `timestampTz('starts_at')` per migration.
3. ✅ Translatable name columns are not in the entity tables; only `slug`/`code` etc. live there.
4. ✅ Minimal `Product` and `ProductVariant` models with `#[Fillable]` and `casts()` only — relationships/traits are Phase 2.
5. ✅ SQLite test DB caveat noted; nothing trips it in this phase.

---

## Completed

### 1. Migrations (12, sequential timestamps so FK order is correct)

- [x] `2026_05_03_153130_create_categories_table` — `slug` unique, self-FK `parent_id` nullable `nullOnDelete()`, `image_path` nullable, `timestampsTz`.
- [x] `2026_05_03_153131_create_attributes_table` — `code` unique, `is_filterable` default true, `is_multiple`.
- [x] `2026_05_03_153132_create_attribute_values_table` — FK `attribute_id` `cascadeOnDelete`, **UNIQUE (attribute_id, slug)**.
- [x] `2026_05_03_153133_create_products_table` — `slug` unique, `sku_base`/`brand` nullable, `is_active`/`is_featured`.
- [x] `2026_05_03_153134_create_product_variants_table` — FK `product_id` `cascadeOnDelete`, `sku` unique, `size_ml` smallInteger, decimals, **INDEX (product_id, is_active)**.
- [x] `2026_05_03_153135_create_category_product_table` — pivot, **PK (category_id, product_id)**, both FKs `cascadeOnDelete`, no timestamps.
- [x] `2026_05_03_153136_create_product_attribute_value_table` — pivot, **PK (product_id, attribute_value_id)**, **INDEX (attribute_value_id, product_id)**, no timestamps.
- [x] `2026_05_03_153137_create_media_table` — polymorphic, **INDEX (mediable_type, mediable_id)**.
- [x] `2026_05_03_153138_create_translations_table` — polymorphic, **UNIQUE `translations_unique` (type, id, locale, field)**, **INDEX `translations_lookup_idx` (type, id, locale)**.
- [x] `2026_05_03_153139_create_page_sections_table` — `payload` `jsonb`, `key` unique.
- [x] `2026_05_03_153140_create_promotions_table` — `starts_at`/`ends_at` `timestampTz`, **INDEX (is_active, starts_at, ends_at)**.
- [x] `2026_05_03_153141_create_settings_table` — `key` PK, `value` text, single `updated_at` (no `created_at` per spec).

### 2. Models

- [x] `App\Models\Product` — `#[Fillable]` for the 5 columns, casts `is_active`/`is_featured` to bool. Follows the `User`-model attribute style.
- [x] `App\Models\ProductVariant` — `#[Fillable]` for the 8 columns, casts decimals/booleans/integers.

### 3. Factories

- [x] `ProductFactory` — fake unique 2-word slug + 5-char suffix, `sku_base = P-XXXXXX`, random luxury brand. States: `featured()`, `inactive()`.
- [x] `ProductVariantFactory` — `sku = V-XXXXXXXX-{size}ML`, size 30/50/100, price 19.99–199.99, `Product::factory()` for the FK. States: `default()`, `size(int)`.

### 4. Seeders (all idempotent via `updateOrInsert`)

- [x] `CategorySeeder` — 7 categories with their German `name` translations.
- [x] `AttributeSeeder` — 4 attributes (art is_multiple=false; familie/stimmung/noten true) with German `name` translations.
- [x] `AttributeValueSeeder` — 63 values across the 4 attributes; slugs via `Str::slug($name, '-', 'de')` so umlauts transliterate (e.g. `Maiglöckchen → maigloeckchen`, `Grüner Tee → gruener-tee`); each gets its German `name` translation.
- [x] `DatabaseSeeder::run()` calls them in dependency order after `AdminUserSeeder`.

### 5. Verification

- [x] `php artisan migrate:fresh --seed` — clean.
- [x] DB shape verified:
  - `categories` = 7
  - `attributes` = 4 with `is_multiple` `(art=0, familie=1, stimmung=1, noten=1)`
  - `attribute_values`: art=2, familie=10, stimmung=9, noten=42
  - `translations` (locale=de, field=name) = **74** (= 7 + 4 + 63)
  - Per type: Category=7, Attribute=4, AttributeValue=63
  - Spot-checked round-trip: `arabische-parfums` → "Arabische Parfums", `gruener-tee` → "Grüner Tee".
- [x] Postgres column types via `psql \d`:
  - `page_sections.payload` = `jsonb`
  - All `created_at` / `updated_at` / `starts_at` / `ends_at` = `timestamp(0) with time zone`
  - Indexes present: `translations_lookup_idx`, `translations_unique`, `promotions_is_active_starts_at_ends_at_index`, etc.
- [x] Factory smoke test (tinker): `Product::factory()->create()` + `ProductVariant::factory()->default()->size(50)->create(['product_id' => $p->id])` returns valid records with correct casts. `for($p)` won't work yet — Phase 2 will add the `product()` relationship.
- [x] `php artisan test --compact` — 41/41 pass (RefreshDatabase runs migrations against in-memory SQLite; `jsonb` and `timestampsTz` fall back gracefully).
- [x] `vendor/bin/pint --dirty --format agent` — clean.

### 6. Bookkeeping

- [x] All boxes ticked in this file.
- [x] `PROGRESS.md` updated.

---

## Carry-over notes for later phases

- `for()`/`hasMany`/`belongsTo` on `Product`/`ProductVariant` is intentionally absent — Phase 2 adds it alongside `Category`, `Attribute`, `AttributeValue`, `Media`, `Translation`, `PageSection`, `Promotion`, `Setting` models.
- Translation rows are written under literal `App\Models\Category` / `App\Models\Attribute` / `App\Models\AttributeValue` strings. If Phase 2 introduces a morph map, those values will need to be aligned (e.g. update both the seeder and any existing rows).
- All slug generation in seeders uses `Str::slug($name, '-', 'de')` directly. Phase 2's `HasSlug` trait should produce the same slugs so re-running seeders after adopting the trait stays consistent.
