# Phase 4 — Public frontend (German first)

**Goal**: replace the starter public welcome screen with the German public Goan Perfume site from `docs/PROJECT.md` section 2 and Phase 4. Start with page design and database-shaped dummy data, then wire the routes/controllers after the UI contracts are clear. AR/EN rendering, RTL, `hreflang`, sitemap, image resizing, and deep SEO polish are Phase 5/6 work.

## What already exists from earlier phases

- **Models and queries**: Category, Attribute, AttributeValue, Product, ProductVariant, Media, PageSection, Promotion, and Setting models are complete. `HasTranslations` can read German content via `translate('de', ...)`; `Promotion::active()` filters active promo windows.
- **Admin content entry**: Phase 3 lets admins create categories, attributes/values, products with variants and media, promotions, fixed page sections, and site settings.
- **Media plumbing**: uploaded product media, category banners, promotion backgrounds, page-section hero images, and the site logo are stored on the public disk and exposed through `Storage::url(...)`.
- **Image cache expectation**: public image URLs should stay stable when the stored path/name does not change, so browser/CDN cache remains valid. Only changed/replaced uploads should produce a new URL/path.
- **Routes today**: `/` still renders the starter `welcome` page. Dashboard/user settings routes are already separated and must stay untouched.
- **Public language scope**: German only in Phase 4. Use German translations (`locale = de`) and fall back to slugs or empty strings when data is missing. Do not add a locale switcher implementation yet.

---

## Approach decisions

1. **Design-first workflow**. Build the public pages first with dummy data shaped like the eventual Inertia props. This lets us validate layout, component boundaries, filter UX, product-card needs, and page contracts before writing the backend routes/controllers.

2. **Dummy data location**. Keep Phase 4 dummy data local to the public frontend layer, preferably in `resources/js/lib/public-dummy-data.ts`, typed with the same TypeScript types the pages will receive from controllers later. Delete or stop importing it when controllers are wired.

3. **Prop-shape first**. Define TypeScript types for public props before backend work:
    - navigation categories
    - contact/settings payload
    - product cards
    - product detail
    - filter groups
    - page sections
    - promotions
      These shapes become the controller response contract.

4. **Public page sandbox before routes**. During the design pass, pages may be previewed through temporary Inertia/static references or by swapping `/` to a dummy-driven page only. Do not finalize public route structure until the design/data contracts are reviewed.

5. **Public route ownership after design approval**. After designs are accepted, replace `Route::inertia('/', 'welcome', ...)` with controller-backed public Inertia routes. Public controllers live in `app/Http/Controllers/Public/`, pages in `resources/js/pages/public/`, and reusable public UI in `resources/js/components/public/`.

6. **Category route strategy after design approval**. The seven category slugs from the spec are first-class routes by slug: `/luxusparfums`, `/nischenparfums`, `/designerparfums`, `/arabische-parfums`, `/damenparfums`, `/herrenparfums`, `/unisex-parfums`. Use one `CategoryController@show(string $slug)` behind explicit route definitions or a constrained route list. Do not use a broad catch-all that could steal `/dashboard`, `/login`, `/kontakt`, or `/preise`.

7. **German translation reads**. Controllers shape props with `translate('de', field)` and never expose raw Eloquent models directly. Any missing translation falls back to slug/code. AR/EN values are ignored until Phase 5.

8. **Filtering contract**. Query string uses attribute codes as keys, with comma-separated value slugs:
    - `/damenparfums?familie=blumig,fruchtig&stimmung=frisch&noten=rose`
    - OR within the same group (`familie` can match any selected family).
    - AND across groups (a product must match selected family AND selected mood AND selected notes).
    - Selected filters are reflected in the UI and can be shared via URL.

9. **Pagination contract**. Category pages use Laravel pagination and preserve query strings. Product grid target is 4 columns on desktop and 2 columns on mobile.

10. **Prices**. Price ranges are computed from active variants using `withMin('variants', 'price')` / `withMax('variants', 'price')` and formatted as German EUR strings (`10,00 €` or `10,00 € – 55,00 €`).

11. **Hero behavior**. Homepage hero uses active promotions ordered by `sort_order`; if multiple are active, render a slow carousel client-side. If none are active, fall back to `page_sections.hero` image/content.

12. **Cart icon**. Keep the decorative cart icon from the reference/navigation, but it must not imply checkout. It can be disabled or point nowhere.

13. **No browser-only logic for data correctness**. Filtering, pagination, and product/category lookup happen server-side after the backend is wired. React handles UI interactions and URL navigation only.

14. **Testing scope**. Add Feature tests for route rendering and payload correctness after backend wiring. Browser tests are optional later; Phase 4 minimum is server-side Inertia assertions plus query behavior tests.

15. **Image caching**. Do not append volatile cache-busting query strings or timestamps to image URLs. Use the stored image path/name as the cache key. If an admin replaces an image, the upload flow should already store a new path/name; that new URL naturally invalidates the old cached asset.

---

## Tasks (in order)

### 1. Public prop types and dummy data ✅

- [x] Create `resources/js/types/public.ts` or equivalent public frontend type definitions:
    - `PublicCategoryNavItem`
    - `PublicContactSettings`
    - `PublicProductCard`
    - `PublicProductDetail`
    - `PublicFilterGroup`
    - `PublicPromotion`
    - `PublicPageSections`
    - page prop types for home/category/product/pricing/contact.
- [x] Create `resources/js/lib/public-dummy-data.ts` with realistic German dummy data that mirrors the database:
    - 7 category nav items with the documented slugs
    - filter groups for Art, Familie, Stimmung, Noten
    - 8–12 products with variants, price ranges, brands, images, categories, and attribute values
    - product detail gallery and variant data
    - active promotions plus fallback hero payload
    - about and why-us page section content
    - settings/contact payload
- [x] Use placeholder image URLs or existing public/storage-safe URLs without adding new binary assets unless explicitly needed.
- [x] Keep dummy image URLs stable across renders to match the final caching behavior.
- [x] Keep dummy data isolated so it can be removed cleanly once controllers provide real props.

### 2. Public visual system and layout ✅

- [x] Create `resources/js/layouts/public-layout.tsx`.
- [x] Create shared public styling conventions:
    - restrained perfume showcase palette
    - image-led hierarchy
    - stable content width
    - responsive spacing
    - consistent buttons, chips, and card typography
- [x] Create `resources/js/components/public/site-header.tsx`:
    - hamburger button
    - centered logo or text logo from settings
    - decorative cart icon
- [x] Create `resources/js/components/public/site-drawer.tsx`:
    - menu links: Luxusparfums, Nischenparfums, Designerparfums, Arabische Parfums, Preis, Kontakt
    - drawer title `القائمه`
- [x] Create `resources/js/components/public/floating-contact-sidebar.tsx`:
    - WhatsApp
    - email
    - phone
    - TikTok
    - Instagram
    - Facebook
    - hide links whose setting is empty
- [x] Create `resources/js/components/public/product-card.tsx`.
- [x] Create `resources/js/components/public/product-grid.tsx`.
- [x] Create `resources/js/components/public/price.tsx` or `resources/js/lib/public-format.ts` for EUR formatting.

### 3. Homepage design with dummy data

- [x] Create `resources/js/pages/public/home.tsx`.
- [x] Render through `PublicLayout`.
- [x] Render promo hero:
    - active promotions carousel when promotions exist
    - fallback hero from `page_sections.hero` when no active promotions exist
- [x] Render **Luxus-Highlights** using dummy featured products, max 4.
- [x] Render **Über uns** from dummy `page_sections.about`.
- [x] Render **Warum wir** from dummy `page_sections.why_us` bullet points.
- [x] Link product cards to `/produkt/{slug}`.
- [x] Add empty-state variants that look intentional when admin content is missing.
- [x] Validate desktop and mobile layout before backend wiring.

### 4. Category page design with dummy data

- [x] Create `resources/js/pages/public/category.tsx`.
- [x] Render category header banner with overlaid German category name.
- [x] Render dynamic filter groups from dummy active/filterable attributes.
- [x] Render selected filter chips and clear/remove controls.
- [x] Reflect intended query-string shape in link generation:
    - OR within selected values for one attribute group
    - AND across selected attribute groups
- [x] Render product grid:
    - 4 columns desktop
    - 2 columns mobile
    - primary image
    - German product name
    - brand
    - price range
- [x] Render pagination UI and German result count copy.
- [x] Mobile filter behavior: inline filter section above products for v1, matching `docs/PROJECT.md` section 2.
- [x] Confirm from this design whether the accepted routes are enough or if additional helper routes are needed.

### 5. Product detail page design with dummy data

- [x] Create `resources/js/pages/public/product.tsx`.
- [x] Render gallery from sorted media, primary first.
- [x] Render German name, brand, short description, full description.
- [x] Render variant selector and price for selected variant.
- [x] Render attribute badges grouped by Familie, Stimmung, Noten, and Art where available.
- [x] Render back-to-category link.
- [x] Render contact CTA using WhatsApp/phone/email settings.
- [x] Confirm the final product prop shape after seeing the design.

### 6. Pricing and contact page designs with dummy data

- [x] Create `resources/js/pages/public/pricing.tsx`.
- [x] Design `/preise` as a German pricing/catalog overview page:
    - grouped links to active categories
    - clear contact CTA for exact availability/pricing via WhatsApp/phone/email
    - no cart, checkout, or payment wording
- [x] Create `resources/js/pages/public/contact.tsx`.
- [x] Design `/kontakt` with settings-driven contact methods:
    - WhatsApp
    - email
    - phone
    - Instagram
    - TikTok
    - Facebook
- [x] No contact form.
- [x] Empty settings should not render dead links.

### 7. Design verification before backend wiring

- [x] Run `npm run build` to verify TypeScript and Vite can compile the dummy-driven public pages.
- [x] Check desktop and mobile layouts for:
    - homepage
    - category page
    - product detail
    - pricing page
    - contact page
- [x] Check that product cards have stable image aspect ratios and no layout shift.
- [x] Check that page/component code does not add changing cache-buster query params to image URLs.
- [x] Check that text does not overflow on cards, filter chips, buttons, or hero CTAs.
- [x] Review the final prop shapes and update this task file if routes/controllers need adjustment.

### 8. Public routing and controllers

- [x] Replace the starter `/` route with `Public\HomeController`.
- [x] Add public routes:
    - `/`
    - `/luxusparfums`
    - `/nischenparfums`
    - `/designerparfums`
    - `/arabische-parfums`
    - `/damenparfums`
    - `/herrenparfums`
    - `/unisex-parfums`
    - `/preise`
    - `/kontakt`
    - `/produkt/{slug}`
- [x] Add controllers in `app/Http/Controllers/Public/`:
    - `HomeController`
    - `CategoryController`
    - `ProductController`
    - `PricingController`
    - `ContactController`
- [x] Regenerate Wayfinder routes after adding routes.
- [x] Remove or stop importing dummy data from production page rendering.

### 9. Public data transformers

- [x] Add lightweight presenter/transformer methods or private controller mappers for:
    - public navigation categories
    - product cards
    - product detail payloads
    - attribute filter groups
    - settings contact payload
    - page sections
    - promotions
- [x] Keep these mappings array-based and explicit so Inertia props remain stable.
- [x] Match the TypeScript prop shapes proven by the dummy-data designs.
- [x] Include only needed columns/relations to avoid N+1 queries.
- [x] Use `Storage::url(...)` for public image URLs and nullable URLs when no image exists.
- [x] Keep public image URLs stable when the stored path/name is unchanged.
- [x] Do not append request-time timestamps, random values, or build hashes to image URLs.
- [x] Rely on changed storage paths/names from replacement uploads to invalidate cached images.

### 10. Wire homepage to real data

- [x] Query active promotions via `Promotion::active()->orderBy('sort_order')`.
- [x] Fallback to `page_sections.hero` when no active promotions exist.
- [x] Query featured active products, max 4.
- [x] Query `page_sections.about` and `page_sections.why_us`.
- [x] Keep empty states from the design pass for missing admin content.

### 11. Wire category pages to real data

- [x] Load category by slug and return 404 for inactive/missing categories.
- [x] Load active/filterable attributes and values.
- [x] Apply filter query:
    - OR within selected values for one attribute group
    - AND across selected attribute groups
    - products must belong to the current category and be active
- [x] Preserve query string through pagination links.
- [x] Return product cards using real primary media and variant price ranges.
- [x] Return German result count copy data.

### 12. Wire product detail to real data

- [x] Load active product by slug; return 404 if missing/inactive.
- [x] Return sorted media, primary first.
- [x] Return variants sorted by sort order/id.
- [x] Return attribute badges grouped by Attribute code/name.
- [x] Return back-to-category link using the first active category or a referring category query parameter if present.
- [x] Return contact CTA settings.

### 13. Wire pricing and contact pages to real data

- [x] Pricing page returns active category links and contact payload.
- [x] Contact page returns settings values.
- [x] Empty settings do not render dead links.

### 14. Feature tests

- [x] `HomeControllerTest`:
    - homepage renders
    - active promotions are passed to hero
    - fallback hero is used when no promotions are active
    - featured products are limited to active/featured products
    - page sections are included
- [x] `CategoryControllerTest`:
    - each configured category route renders
    - inactive/missing category returns 404
    - product grid only includes active products in the category
    - filter OR within group works
    - filter AND across groups works
    - query string selections are preserved in pagination payload
- [x] `ProductControllerTest`:
    - active product detail renders
    - inactive/missing product returns 404
    - media, variants, and attribute badges are present
- [x] `ContactControllerTest`:
    - contact page renders settings values
    - empty settings hide links
- [x] `PricingControllerTest`:
    - pricing page renders with active category links and contact payload.

### 15. Final verification

- [x] `php artisan route:list --path=dashboard` confirms public routes did not disturb dashboard routes.
- [x] `php artisan route:list --except-vendor` confirms public routes exist.
- [x] `php artisan test --compact tests/Feature/Public` passes.
- [x] `npm run build` passes.
- [x] `vendor/bin/pint --dirty --format agent` clean.
- [x] `composer ci:check` green.
- [x] Manual smoke check URLs:
    - `/`
    - `/luxusparfums`
    - `/damenparfums?familie=blumig&noten=rose`
    - `/produkt/{existing-product-slug}`
    - `/preise`
    - `/kontakt`

### 16. Bookkeeping

- [x] Tick boxes in this file as work lands.
- [x] Append a Phase 4 line to `PROGRESS.md` summarizing what shipped and any carry-overs.

---

## Out of scope for Phase 4

- AR/EN locale switching and Arabic RTL layout (Phase 5).
- `hreflang`, sitemap, robots, Open Graph, and Lighthouse targets (Phase 6).
- Image resizing/responsive generated variants (Phase 6).
- Checkout, cart, payment, stock, orders, or ecommerce workflows.
- Public search bar/autocomplete unless explicitly added later.
- Browser/visual regression testing unless separately requested.
