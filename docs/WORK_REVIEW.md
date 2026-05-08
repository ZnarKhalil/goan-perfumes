# Work Review — Goan Perfume

Date: 2026-05-08

This review compares the current implementation against `docs/PROJECT.md`, `PHASE_0_TASKS.md`, `PHASE_1_TASKS.md`, `PHASE_2_TASKS.md`, and `PHASE_3_TASKS.md`.

## Executive Summary

The project is directionally sound. Phases 0–2 establish the right foundation for a non-ecommerce perfume showcase: PostgreSQL, admin-only dashboard access, storage, the full schema, custom polymorphic translations, dynamic filters, domain models, slug/translation traits, promotion scoping, and filter-query tests.

Phase 3 has started with a sensible first slice: dashboard routing, Categories CRUD, shared form components, and Category feature tests. The work matches the stated admin goal: German-only interface, DE/AR/EN content fields, server-side FormRequest validation, Inertia forms, Wayfinder route usage, and file upload handling.

The biggest remaining risk is scope management in Phase 3. Products, media sync, attributes/values, promotions, page sections, and settings will add most of the complexity. The next work should prioritize reusable service boundaries and validation consistency before the Product CRUD screen grows too large.

## Current State

### Phase 0 — Bootstrap

Status: complete.

Strong points:
- PostgreSQL is connected and verified.
- `is_admin` plus `EnsureUserIsAdmin` protects `/dashboard`.
- Admin seed user is idempotent.
- Storage symlink is in place, which unblocks public media URLs.
- Feature tests cover guest, non-admin, and admin dashboard access.

Feedback:
- The non-admin redirect behavior is documented and tested. Keep that behavior consistent across all dashboard subroutes unless there is a deliberate move to `403`.

### Phase 1 — Schema & Seeds

Status: complete, including later SKU/stock scope cleanup.

Strong points:
- Schema follows the project description well: categories are separate from filters, attributes use an EAV-lite pattern, variants hold prices, and translations are polymorphic.
- PostgreSQL-specific choices are respected: `jsonb` for `page_sections.payload` and timezone-aware timestamps.
- Seeders are idempotent and provide the expected 7 categories, 4 attributes, 63 attribute values, and 74 German translation rows.
- Dropping SKU and stock fields aligns the implementation with the clarified “showcase, not ecommerce” scope.

Feedback:
- Good decision not to add ecommerce tables or inventory behavior.
- Keep product variants focused on display price/size only. Future admin copy should avoid terms like stock, SKU, checkout, order, cart, or payment unless scope changes.

### Phase 2 — Models & Business Logic

Status: complete.

Strong points:
- Models and relationships match the schema and support the later public catalog query.
- `HasTranslations` and `HasSlug` are small, explicit, and testable.
- No morph map is a pragmatic choice because seeded rows use FQNs already.
- `Promotion::active()` correctly models the active-window behavior needed by the homepage hero.
- Filter-query tests verify the important AND-across-groups / OR-within-group behavior foundation.

Feedback:
- The explicit `setSlugSource()` API is appropriate for this project because German names live in translation rows. Keep using this pattern in Phase 3 controllers.
- The Product CRUD implementation should preserve the existing relationship names and pivot table choices; do not introduce alternate pivot abstractions.

### Phase 3 — Admin Dashboard

Status: in progress. Categories and shared dashboard components are implemented; remaining resources are not yet implemented.

Landed work:
- `routes/dashboard.php` is required from `routes/web.php`.
- Category dashboard CRUD exists under `/dashboard/categories`.
- Category FormRequests validate slug uniqueness, German name requirement, upload size/type, and parent category constraints.
- Category create/edit screens use translation tabs, a slug field, parent select, active toggle, sort order, and banner upload.
- Shared components exist for translation tabs, media upload, data table, slug field, and tabs UI.
- Sidebar now exposes “Kategorien”.
- Category feature tests cover admin access, listing, create, update, deletion, image cleanup, translation cleanup, parent selection, no `show` route, and cycle prevention.

Recent fixes applied:
- Removed the unused Category `show` route.
- Added server-side category-cycle validation, not just UI exclusion.
- Made required markers in translation tabs match actual validation.
- Fixed multi-image object URL cleanup in `MediaUploader`.

Verification:
- `php artisan test --compact tests/Feature/Dashboard/CategoryControllerTest.php` passes.
- `npm run build` passes.
- `composer ci:check` passes with 69 tests and 224 assertions.

## Alignment With Project Description

Aligned:
- The app remains a product showcase, not ecommerce.
- Admin UI is German-only.
- Public content fields are trilingual via translations.
- Categories, attributes, products, variants, media, page sections, promotions, and settings are represented in the schema.
- Dynamic filters are modeled correctly for the future public listing pages.
- Image upload direction is compatible with `storage/app/public` and `Storage::url()`.

Partially aligned:
- Category admin is implemented, but the rest of Phase 3 CRUD is still pending.
- `MediaUploader` has multi-image UI support, but the backend `MediaService` is still pending.
- Translation tabs handle DE/AR/EN fields, but reusable per-resource field requirements should stay explicit.
- Sidebar has only Dashboard + Kategorien for now; full Phase 3 nav remains pending.

Not started yet:
- Attribute + AttributeValue admin.
- Product + variant admin.
- Promotion admin.
- Page section seeder and edit-only admin.
- Site settings admin.
- Reusable backend media sync service.
- Public site rendering.

## Main Risks

### 1. Product CRUD Complexity

Products will combine translations, slugging, categories, grouped attribute values, variants, and multi-image media. This is the highest-risk Phase 3 resource.

Recommendation:
- Build `MediaService` before Product CRUD.
- Build `variant-row-editor.tsx` before the Product form.
- Keep ProductController transactional from the start.
- Add tests for full graph create/update before doing UI polish.

### 2. Validation Drift Between UI and Server

The translation required-marker issue is already fixed, but this class of bug can recur as more resources land.

Recommendation:
- For every shared form component, pass explicit validation intent as props.
- In tests, include at least one negative validation case per resource.

### 3. Media Model vs `categories.image_path`

The spec has both `categories.image_path` and a polymorphic `media` table. The current Category slice stores the banner in `categories.image_path`, which matches section 4.1. Products should use `media`, and promotions/page sections may use direct path columns/payloads depending on their schema.

Recommendation:
- Do not force Categories into `media` unless the spec changes.
- Use `MediaService` for Products and any future polymorphic media use.
- Use direct path handling for fields that are direct path columns, unless there is a clear reason to normalize.

### 4. Phase 3 Task File Is Slightly Stale

The task file still says Category tests are 9 and full suite is 67. Current verification is 11 Category tests and 69 total tests after the review fixes.

Recommendation:
- Update `PHASE_3_TASKS.md` and `PROGRESS.md` when the Category slice is committed.

### 5. Ignored Wayfinder Output

`resources/js/actions`, `resources/js/routes`, and `resources/js/wayfinder` are ignored. This is fine because Vite generates them during build, and `npm run build`/`composer ci:check` prove this currently works.

Recommendation:
- Keep relying on the Vite Wayfinder plugin, but continue running build before finalizing any route-consuming frontend work.

## Recommendations For Next Work

1. Finish Phase 3 in dependency order:
   - Attributes + AttributeValues
   - MediaService
   - Product variants editor
   - Products
   - Promotions
   - Page Sections
   - Settings

2. For AttributeValues:
   - Keep nested backend routes.
   - Validate slug uniqueness scoped to the parent attribute.
   - Add tests proving the same slug can exist under different attributes but not under the same one.

3. For Products:
   - Persist inside one DB transaction.
   - Validate selected attribute values against their declared attribute groups.
   - Enforce single-select behavior for `art`.
   - Ensure at least one active variant exists if a product is active.
   - Ensure only one default variant per product.

4. For Page Sections:
   - Add the fixed `PageSectionSeeder` before building the UI.
   - Keep the UI edit-only as planned.

5. For Settings:
   - Use a typed form with known keys, not a generic key/value editor.
   - Keep contact/social settings aligned with the public floating sidebar requirements.

6. For tests:
   - Continue using focused Feature tests per resource.
   - Run `composer ci:check` before finalizing each Phase 3 slice.
   - Add one full Product graph test once Product CRUD lands.

## Quality Notes

Good patterns to keep:
- Small FormRequest classes with shared validation concerns.
- Explicit German-only admin labels.
- Inertia `useForm` with dotted validation error paths.
- Wayfinder route helpers instead of hardcoded frontend URLs.
- Storage fakes in upload tests.
- Transactional writes for multi-step persistence.

Patterns to avoid:
- Querying translations one-by-one in large index pages without eager loading.
- Moving product/category/filter semantics into hardcoded columns.
- Adding ecommerce language or tables.
- Letting UI-only constraints stand without matching server validation.
- Growing controllers with repeated media/translation/variant sync logic.

## Conclusion

The completed foundation is solid and consistent with the project spec. The Category dashboard slice is a good proof of the Phase 3 architecture after the recent fixes. The next priority should be completing Attributes and backend media plumbing before tackling Products, because Products depend on both and will otherwise become the place where too many unresolved decisions accumulate.
