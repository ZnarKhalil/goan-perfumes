# Phase 5 — Internationalization (AR + EN)

**Goal**: make the public Goan Perfume site fully trilingual in German, English, and Arabic, with Arabic RTL rendering. Phase 5 localizes public routing, content reads, UI copy, locale switching, and price formatting. Phase 6 still owns SEO polish such as `hreflang`, sitemap, Open Graph, Lighthouse targets, image resizing, and the styled 404 page.

## What already exists from earlier phases

- **Translation storage**: `translations` stores translatable fields by `locale` and `field`; `HasTranslations::translate($locale, $field, $fallbackLocale)` already supports locale fallback.
- **Admin translation entry**: Dashboard forms already expose DE/AR/EN translation tabs for products, categories, attributes/values, media alt text, page sections, and promotions.
- **Public frontend**: Phase 4 shipped controller-backed Inertia pages for home, category, product detail, and contact.
- **Current limitation**: `App\Http\Controllers\Public\PublicController` uses hard-coded `de` reads and public React pages contain hard-coded German UI copy.
- **Current route shape**: unprefixed public URLs exist (`/`, `/kontakt`, `/produkt/{slug}`, `/{categorySlug}`), with constrained category slugs.
- **Future SEO**: Phase 6 requires locale-specific `hreflang`, so Phase 5 should make each public page addressable per locale.

---

## Approach decisions

1. **Canonical public URL strategy**. Use locale-prefixed canonical routes:
    - `/de`, `/ar`, `/en`
    - `/de/kontakt`, `/ar/kontakt`, `/en/kontakt`
    - `/de/produkt/{slug}`, `/ar/produkt/{slug}`, `/en/produkt/{slug}`
    - `/de/{categorySlug}`, `/ar/{categorySlug}`, `/en/{categorySlug}`

2. **Legacy redirects**. Keep Phase 4 unprefixed public URLs as redirects to the active cookie locale, falling back to `/de`. These redirects preserve existing local links and manual smoke URLs. Do not add or preserve `/preise`.

3. **Stable slugs in Phase 5**. Keep product/category/attribute-value slugs locale-neutral and unchanged. Do not implement translated slugs yet; content and UI copy localize, not route slugs.

4. **Locale source of truth**. Route prefix is authoritative for the current request. Locale switcher writes a cookie for future unprefixed redirects, but prefixed URLs should work even without cookies.

5. **Supported locale contract**. Supported locales are `de`, `en`, and `ar`. Arabic uses `dir="rtl"`; German and English use `dir="ltr"`.

6. **Controller translation reads**. Public controllers should read `$this->locale()` and fall back to German when the active locale translation is missing. Slugs/codes remain the final fallback.

7. **UI copy location**. Put public frontend copy in a small typed client-side dictionary, for example `resources/js/lib/public-i18n.ts`. Avoid mixing locale conditionals across every component.

8. **Localized route generation**. Generate all public links through locale-aware backend route helpers or locale-aware frontend helpers. Do not hard-code `/kontakt`, `/luxusparfums`, or `/produkt/...` in React after this phase.

9. **RTL implementation**. Prefer logical Tailwind/CSS classes and data attributes where practical. Use targeted `rtl:` variants or conditional classes only where layout genuinely needs mirroring.

10. **Price formatting**. Format prices with `Intl.NumberFormat` using `de-DE`, `en-DE` or `en-US` style English formatting, and `ar-DE` or `ar` for Arabic. EUR remains the currency.

11. **Admin scope**. Admin UI may remain German, but all existing DE/AR/EN translation tabs must continue to save and read correctly.

12. **SEO boundary**. Do not implement `hreflang`, sitemap, Open Graph, Lighthouse tuning, image resizing, or a custom 404 in Phase 5 unless needed to avoid breaking the localized routing.

---

## Tasks (in order)

### 1. Locale contract and helpers

- [ ] Add a central supported-locale definition for public routes:
    - `de` label Deutsch, flag/icon metadata, `dir = ltr`, formatter locale `de-DE`
    - `en` label English, flag/icon metadata, `dir = ltr`, formatter locale `en-DE` or approved equivalent
    - `ar` label العربية, flag/icon metadata, `dir = rtl`, formatter locale `ar`
- [ ] Add a small locale value object/helper or config-backed helper for:
    - validating route locale
    - returning default locale `de`
    - returning direction for a locale
    - returning formatter locale for prices
    - normalizing unsupported cookie/session values back to `de`
- [ ] Add tests for supported locale validation and fallback behavior.

### 2. Locale middleware and shared Inertia props

- [ ] Add middleware for public localized routes that:
    - reads `{locale}` from the route
    - validates it against supported locales
    - calls `app()->setLocale($locale)`
    - stores the locale in a cookie or session for legacy redirects
- [ ] Share locale props with public Inertia pages:
    - current locale
    - direction
    - supported locale list
    - locale switcher URLs for the current page
    - formatter locale
- [ ] Update `resources/js/types/public.ts` with public locale prop types.
- [ ] Ensure dashboard/auth/settings Inertia pages are not forced into public locale behavior.

### 3. Public route localization

- [ ] Move canonical public routes under `/{locale}` with a route constraint for `de|en|ar`.
- [ ] Keep route names stable or introduce clear locale-aware names, then update all route generation.
- [ ] Add legacy redirects for:
    - `/`
    - `/kontakt`
    - `/produkt/{slug}`
    - each configured category slug
- [ ] Redirect legacy routes to the cookie/session locale, falling back to German.
- [ ] Confirm dashboard, auth, and settings routes remain unprefixed and unaffected.
- [ ] Regenerate Wayfinder routes after route changes.

### 4. Public controller locale reads

- [ ] Replace hard-coded `PublicController::LOCALE = 'de'` reads with the active request locale.
- [ ] Update mappings for:
    - navigation categories
    - product cards
    - product detail payloads
    - media alt text
    - attribute filter groups and values
    - page sections
    - promotions
- [ ] Use German fallback for all translatable content when the active locale is missing.
- [ ] Keep slug/code fallback only after active locale and German fallback are both missing.
- [ ] Generate product, category, and contact URLs with the active locale prefix.
- [ ] Preserve category filter query strings when generating localized filter links.

### 5. Locale switcher UI

- [ ] Add a public locale switcher component visible on every public page.
- [ ] Use flag icons or compact locale icons with accessible labels.
- [ ] Place the switcher in `SiteHeader` for desktop and in `SiteDrawer` for mobile.
- [ ] Switcher links must preserve the current page equivalent:
    - home to home
    - category to same category
    - product detail to same product
    - contact to same page
    - preserve current category filter query strings
- [ ] Switching locales writes the locale cookie/session.
- [ ] The active locale should be visually clear without relying on color alone.

### 6. Public UI copy localization

- [ ] Create a typed public copy dictionary for DE/EN/AR.
- [ ] Replace hard-coded German public text in:
    - `public-layout.tsx`
    - `site-header.tsx`
    - `site-drawer.tsx`
    - `floating-contact-sidebar.tsx`
    - `product-card.tsx` / `product-grid.tsx`
    - `home.tsx`
    - `category.tsx`
    - `product.tsx`
    - `contact.tsx`
- [ ] Localize empty states, ARIA labels, button labels, result-count copy, pagination labels, contact CTAs, footer text, and page titles.
- [ ] Keep admin UI text German unless a public page component is shared with admin.
- [ ] Remove assumptions that German labels like `Preis`, `Kontakt`, `Zurücksetzen`, or `Preis auf Anfrage` are globally valid.

### 7. RTL layout pass for Arabic

- [ ] Set the document/root public wrapper to `dir="rtl"` for Arabic and `dir="ltr"` for DE/EN.
- [ ] Confirm text alignment mirrors correctly in:
    - header
    - drawer
    - homepage hero
    - category filters and selected chips
    - product cards
    - product detail gallery and CTA section
    - contact page
    - floating contact sidebar
- [ ] Make the mobile filter drawer / menu drawer open from the mirrored side for Arabic.
- [ ] Swap left/right icons or spacing where directionality changes meaning.
- [ ] Ensure Latin brand names and prices remain readable inside Arabic layouts.
- [ ] Avoid layout overlap or clipped text on Arabic labels.

### 8. Locale-aware price and number formatting

- [ ] Replace `resources/js/lib/public-format.ts` German-only formatter with a locale-aware API.
- [ ] Format product card ranges, variant prices, and compare-at prices using the active formatter locale.
- [ ] Provide localized fallback text for missing prices.
- [ ] Confirm examples:
    - German: `10,00 €`
    - English: `€10.00` or approved English EUR format
    - Arabic: Arabic-locale EUR formatting; Arabic numerals are optional
- [ ] Add focused tests or TypeScript-level usage checks where practical.

### 9. Admin translation coverage audit

- [ ] Verify dashboard forms still save DE/AR/EN translations for:
    - categories
    - attributes
    - attribute values
    - products
    - media alt text
    - page sections
    - promotions
- [ ] Add or update feature tests only where current coverage does not prove AR/EN translation persistence.
- [ ] Ensure seeders include enough EN/AR demo content for public smoke testing.
- [ ] Keep German fallback behavior visible by intentionally leaving at least one seeded non-critical AR/EN field missing.

### 10. Public i18n feature tests

- [ ] Home page tests:
    - `/de` renders German content
    - `/en` renders English content when translations exist
    - `/ar` renders Arabic content and locale props include `dir = rtl`
    - missing EN/AR content falls back to German
- [ ] Category page tests:
    - localized category route renders
    - filter query strings are preserved
    - filter labels use active locale with German fallback
- [ ] Product detail tests:
    - localized product route renders translated name/description/media alt text
    - inactive/missing product still returns 404 under localized routes
- [ ] Contact tests:
    - localized route renders
    - contact payload remains settings-driven and empty settings stay hidden
- [ ] Locale redirect tests:
    - unprefixed legacy URLs redirect to cookie locale
    - invalid or missing cookie falls back to `/de`
- [ ] Route isolation tests:
    - dashboard/settings/auth routes are not captured by public locale/category routes.

### 11. Frontend verification

- [ ] Run `npm run build`.
- [ ] Check desktop and mobile layouts for:
    - `/de`
    - `/en`
    - `/ar`
    - `/ar/damenparfums?familie=blumig&noten=rose`
    - `/ar/produkt/{existing-product-slug}`
    - `/en/kontakt`
- [ ] Check that Arabic text does not overflow buttons, chips, cards, drawers, hero CTAs, or pagination.
- [ ] Check that no public links point to unprefixed canonical URLs except intentional legacy redirects.
- [ ] Check browser console logs for public pages.

### 12. Final verification

- [ ] `php artisan route:list --path=dashboard` confirms public route changes did not disturb dashboard routes.
- [ ] `php artisan route:list --except-vendor` confirms localized public routes and legacy redirects exist.
- [ ] `php artisan test --compact tests/Feature/PublicPagesTest.php` passes.
- [ ] Run any new locale-specific feature test files.
- [ ] `npm run build` passes.
- [ ] `vendor/bin/pint --dirty --format agent` clean.
- [ ] `composer ci:check` green.

### 13. Bookkeeping

- [ ] Tick boxes in this file as work lands.
- [ ] Append a Phase 5 line to `PROGRESS.md` summarizing what shipped and any carry-overs.

---

## Out of scope for Phase 5

- Translated slugs and per-locale category/product slugs.
- `hreflang`, sitemap, robots, Open Graph, and deep SEO metadata (Phase 6).
- Image resizing/responsive generated variants (Phase 6).
- Checkout, cart, payment, stock, orders, or ecommerce workflows.
- Public search bar/autocomplete unless explicitly added later.
- Rewriting the German admin dashboard UI into EN/AR.
