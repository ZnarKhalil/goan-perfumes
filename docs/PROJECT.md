# Goan Perfume — Project Specification

## 1. Project Overview

A **product showcase website** for **Goan Perfume**, a German-based perfume shop. This is **not an e-commerce platform** — there is no checkout, cart, payment, or order processing in the current scope. The goal is to display the catalog with rich filtering so customers can discover perfumes, then contact the shop directly (WhatsApp, phone, email).

- **Shop name**: Goan Perfume
- **Domain**: [https://goanperfume.de/](https://goanperfume.de/)

### Stack

- **Backend & Dashboard**: Laravel with the **React Starter Kit** (Inertia.js + React for the admin panel).
- **Frontend (public site)**: React, served from the **same Laravel project** — not a separate SPA repo.
- **Database**: **PostgreSQL**.
- **Public site languages**: German (primary), Arabic, English — full trilingual support with RTL handling for Arabic.
- **Admin dashboard language**: **German only.** No translation layer in the admin UI. Admin users manage the trilingual content of the public site, but the admin interface itself is single-language.

### Primary User Roles

- **Visitor** — browses catalog, filters products, views product detail pages, switches language (DE/AR/EN). Contacts the shop directly via WhatsApp/phone/email links from the floating sidebar.
- **Admin** — manages products, variants, categories, filter attributes, translations of public content, homepage content, **promotions/offers**, and site settings via a dashboard. Admin UI is in German only.

---

## 2. Site Structure

### Public-Facing Pages

| Route | Purpose |
|---|---|
| `/` | Homepage — hero banner (auto-displays active promotions, otherwise default image), "Luxus-Highlights" featured products, "Über uns" (about), "Warum wir" (why us bullets) |
| `/luxusparfums` | Category listing page (Luxusparfums) |
| `/nischenparfums` | Category listing page (Nischenparfums) |
| `/designerparfums` | Category listing page (Designerparfums) |
| `/arabische-parfums` | Category listing page (Arabische Parfums) |
| `/damenparfums` | Category listing page (Damenparfums) |
| `/herrenparfums` | Category listing page (Herrenparfums) |
| `/unisex-parfums` | Category listing page (Unisex-Parfums) |
| `/preise` | Pricing page |
| `/kontakt` | Contact info page (WhatsApp, phone, email, social links — no form) |
| `/produkt/{slug}` | Product detail page |

### Navigation & Layout (from references)

- **Top navbar**: hamburger menu (left), centered logo, cart icon (decorative for now — no e-commerce).
- **Side menu (drawer)**: Luxusparfums, Nischenparfums, Designerparfums, Arabische Parfums, Preis, Kontakt. Title at top: "القائمه" (Arabic for "menu").
- **Floating sidebar (right edge)**: WhatsApp, email, phone, TikTok, Instagram, Facebook quick-contact buttons.
- **Language switcher**: flag icons (UK / DE / SA or similar) — visible on every page.
- **Mobile filter behavior**: filters appear inline above the product grid (no off-canvas drawer required for v1).

### Category Pages

Each category page shows:
1. A header banner with the category name overlaid.
2. A **Filter** section directly below the header with **Familie**, **Stimmung**, and **Noten** filter chips. Selected filters apply with AND logic across attribute groups, OR logic within a group.
3. A grid of products (4 columns desktop, 2 columns mobile based on the references).
4. Pagination ("Ergebnisse 1 – 25 von 168 werden angezeigt" style).

---

## 3. Filter Definitions

Filters are **fully dynamic** (admin-editable from the dashboard), but seeded with the values below.

### Art (single-select per product)
- Nische
- Designer

### Familie (multi-select per product)
- Orientalisch, Blumig, Zitrisch, Holzig, Gourmand, Aromatisch, Aquatisch, Ledrig, Fruchtig, Chypre

### Stimmung (multi-select per product)
- Frisch, Warm, Elegant, Pudrig, Sinnlich, Dunkel, Sportlich, Klassisch, Modern

### Noten (multi-select per product)
Zitrone, Bergamotte, Mandarine, Minze, Grüner Tee, Meeresnoten, Neroli, Maiglöckchen, Orangenblüte, Jasmin, Rose, Iris, Tuberose, Apfel, Pfirsich, Kirsche, Feige, Lavendel, Eichenmoos, Vetiver, Rosa Pfeffer, Ingwer, Kardamom, Zimt, Safran, Zedernholz, Sandelholz, Patchouli, Oud, Tabak, Leder, Weihrauch, Kaffee, Karamell, Schokolade, Vanille, Tonkabohne, Amber, Moschus, Benzoe, Labdanum, Aldehyde

---

## 4. Database Schema

### Design Decisions

1. **Dynamic filters via EAV-lite pattern.** Two tables — `attributes` (groups) and `attribute_values` (options) — instead of hardcoded tables per filter group. Admin can add new Noten or even a whole new filter group without migrations.
2. **Categories are separate from filters.** A perfume *belongs to* "Damen" (category) but is *filtered by* "Blumig" (attribute value). Categories drive menu and URLs; attributes drive the filter UI.
3. **Variants are first-class.** Prices, SKUs, and stock live on `product_variants` (e.g., 30ml / 50ml / 100ml each with own price). Product card price ranges are computed from variants.
4. **Translations in a polymorphic table.** Trilingual content (DE/AR/EN) on the public site only. Admin dashboard reads/writes the German fields directly; AR/EN are managed as translations.
5. **No e-commerce.** No `orders`, `carts`, `payments`, `shipments`, `reviews`, `contact_messages` tables. Customers contact the shop directly via WhatsApp/phone/email links.
6. **PostgreSQL specifics.** Use `jsonb` (not `json`) for the `payload` column on `page_sections` — it supports indexing and faster querying. Use `timestamptz` for all timestamps so timezones are handled correctly. Foreign keys should use `ON DELETE CASCADE` on pivot tables and `ON DELETE SET NULL` on `categories.parent_id`.

### 4.1. Categories

Drives the menu and category landing pages.

```
categories
─ id                  bigint, PK
─ slug                varchar, unique         (luxusparfums, damenparfums, …)
─ parent_id           bigint, nullable, FK → categories.id
─ sort_order          int, default 0
─ is_active           bool, default true
─ image_path          varchar, nullable       (banner image)
─ created_at, updated_at
```

Translatable fields: `name`, `description`, `meta_title`, `meta_description` — stored in `translations`.

**Seed values**: Luxusparfums, Nischenparfums, Designerparfums, Arabische Parfums, Damenparfums, Herrenparfums, Unisex-Parfums.

> **Note on overlap with Art filter.** "Nischenparfums" and "Designerparfums" appear both as categories (in the menu) and as values of the "Art" filter. Treat them as **categories** for navigation and **also** as Art attribute values for filtering — a product can independently belong to the Damenparfums category *and* have Art=Nische. This is intentional and reflects how the menu is organized in the references.

### 4.2. Attributes & Attribute Values (dynamic filters)

```
attributes
─ id                  bigint, PK
─ code                varchar, unique         (art, familie, stimmung, noten)
─ sort_order          int, default 0
─ is_filterable       bool, default true      (show in sidebar filter UI?)
─ is_multiple         bool                    (can a product have multiple values?)
─ created_at, updated_at
```

Translatable fields: `name` (e.g., "Art" / "النوع" / "Type").

`is_multiple` flag: `false` for Art (one per product), `true` for Familie/Stimmung/Noten.

```
attribute_values
─ id                  bigint, PK
─ attribute_id        bigint, FK → attributes.id, indexed
─ slug                varchar                 (blumig, zitrisch, rose, oud…)
─ sort_order          int, default 0
─ is_active           bool, default true
─ created_at, updated_at
─ UNIQUE (attribute_id, slug)
```

Translatable fields: `name` — the display label.

### 4.3. Products & Variants

```
products
─ id                  bigint, PK
─ slug                varchar, unique
─ sku_base            varchar, nullable       (e.g., "D1", "D2")
─ brand               varchar, nullable
─ is_active           bool, default true
─ is_featured         bool, default false     (homepage "Luxus-Highlights" row)
─ created_at, updated_at
```

Translatable fields: `name`, `short_description`, `description`, `meta_title`, `meta_description`.

> **Gender / Arabic / Luxury are handled via categories**, not as columns on `products`. A perfume that is a luxury Damen Arabic perfume gets three rows in `category_product` — Damenparfums + Luxusparfums + Arabische Parfums.

```
product_variants
─ id                  bigint, PK
─ product_id          bigint, FK → products.id, indexed
─ sku                 varchar, unique         (e.g., "D1-30ML")
─ size_ml             smallint                (30, 50, 100, …)
─ price               decimal(10,2)
─ compare_at_price    decimal(10,2), nullable (for "was/now" pricing)
─ stock_quantity      int, default 0
─ is_default          bool, default false     (which variant shows by default)
─ is_active           bool, default true
─ created_at, updated_at
```

Index on `product_id, is_active` for fast variant lookups.

### 4.4. Pivot Tables

```
category_product
─ category_id         bigint, FK → categories.id
─ product_id          bigint, FK → products.id
─ PRIMARY KEY (category_id, product_id)
```

```
product_attribute_value
─ product_id          bigint, FK → products.id
─ attribute_value_id  bigint, FK → attribute_values.id
─ PRIMARY KEY (product_id, attribute_value_id)
─ INDEX (attribute_value_id, product_id)   ← for reverse lookup in filters
```

This single pivot table handles **all** filter relationships (Art, Familie, Stimmung, Noten) because each `attribute_value` already knows which `attribute` it belongs to.

### 4.5. Media

Polymorphic for flexibility (products, categories, page sections all use it).

```
media
─ id                  bigint, PK
─ mediable_type       varchar                 (App\Models\Product, …)
─ mediable_id         bigint
─ path                varchar                 (storage path or URL)
─ alt_text            varchar, nullable       (translatable via translations)
─ sort_order          int, default 0
─ is_primary          bool, default false     (one per product = card image)
─ created_at, updated_at
─ INDEX (mediable_type, mediable_id)
```

### 4.6. Translations

Single polymorphic table for all translatable content on the public site. Admin dashboard is German-only; the German values are stored here under `locale = 'de'`.

```
translations
─ id                  bigint, PK
─ translatable_type   varchar                 (App\Models\Product, App\Models\AttributeValue, …)
─ translatable_id     bigint
─ locale              varchar(5)              (de, ar, en)
─ field               varchar                 (name, description, short_description, meta_title, …)
─ value               text
─ created_at, updated_at
─ UNIQUE (translatable_type, translatable_id, locale, field)
─ INDEX (translatable_type, translatable_id, locale)
```

Usage: `$product->translate('de', 'name')`. Suggested package: [`spatie/laravel-translatable`](https://github.com/spatie/laravel-translatable) (JSON column variant) or [`astrotomic/laravel-translatable`](https://github.com/Astrotomic/laravel-translatable) (separate table — closer to this schema).

> **Implementation note for the admin UI**: Since the dashboard is German-only, the German fields can be edited directly in the main form. AR and EN fields appear as additional input groups on the same form (clearly labeled with the language) but the surrounding labels, buttons, and navigation of the dashboard itself are all in German.

### 4.7. Page Sections (homepage editable content)

```
page_sections
─ id                  bigint, PK
─ key                 varchar, unique         (hero, about, why_us, featured_products)
─ type                varchar                 (text, image, html, product_list)
─ payload             json                    (flexible content per type)
─ sort_order          int, default 0
─ is_active           bool, default true
─ created_at, updated_at
```

Translatable fields (where applicable): `title`, `body`, `bullet_points` — stored in `translations`.

Example payloads:
- `hero` → `{ "image_path": "...", "cta_text": "..." }`
- `why_us` → `{ "items": ["Höchste Qualität garantiert.", "Lange Haltbarkeit über 8 Std.", "Bester Preis, große Wirkung"] }` (these become translatable per-locale)
- `featured_products` → `{ "product_ids": [1, 5, 12] }`

### 4.8. Promotions (offers / hero banner)

Drives the homepage hero. The admin creates a promotion; it auto-publishes when `starts_at` hits and auto-removes when `ends_at` passes. If multiple promotions are active, the hero rotates between them as a slow carousel. If none are active, the hero falls back to a default image stored in `page_sections` (key `hero`).

```
promotions
─ id                    bigint, PK
─ slug                  varchar, unique         (admin reference, e.g., "10-percent-niche-nov")
─ background_image_path varchar, nullable       (hero background image)
─ background_color      varchar, nullable       (fallback if no image, e.g., "#1a1530")
─ link_url              varchar, nullable       (internal route or external URL for the CTA)
─ promo_code            varchar, nullable       (e.g., "NISCHE10" — display only)
─ discount_percent      smallint, nullable      (display only — e.g., 10)
─ starts_at             timestamp, nullable     (null = active immediately)
─ ends_at               timestamp, nullable     (null = no expiry)
─ sort_order            int, default 0          (carousel ordering when multiple active)
─ is_active             bool, default true      (manual on/off override)
─ created_at, updated_at
─ INDEX (is_active, starts_at, ends_at)
```

Translatable fields: `badge_text` (e.g., "LIMITIERTES ANGEBOT"), `title` (e.g., "10% Rabatt auf Nischenparfums"), `subtitle` (e.g., "Nur bis 15. November"), `cta_text` (e.g., "Jetzt entdecken").

> **Active-promotion query**: `Promotion::where('is_active', true)->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>', now()))->orderBy('sort_order')->get()`

### 4.9. Settings (key-value)

```
settings
─ key                 varchar, PK
─ value               text                    (string or JSON-encoded)
─ updated_at
```

Stores: `whatsapp_number`, `email`, `phone`, `instagram_url`, `tiktok_url`, `facebook_url`, `default_locale`, `logo_path`, etc.

### 4.10. Users

Standard Laravel `users` table from the React Starter Kit. Add an `is_admin` boolean (or use a `role` enum / Spatie permissions if you prefer). Only admins can access the dashboard.

```
users
─ id, name, email, email_verified_at, password, remember_token,
─ is_admin            bool, default false
─ created_at, updated_at
```

---

## 5. ERD Reference

```
categories ──┐
             ├── category_product ── products ──┬── product_variants
             │                          │       ├── media (morph)
             │                          │       └── translations (morph)
             │                          │
attributes ──┴── attribute_values ── product_attribute_value
                       │
                       └── translations (morph)

page_sections ── translations (morph)
promotions ── translations (morph)
settings
users
```

---

## 6. Example Filter Query

*"Damenparfums that are Blumig + Frisch + contain Rose, sorted by price ascending"*:

```php
Product::query()
    ->whereHas('categories', fn($q) => $q->where('slug', 'damenparfums'))
    ->whereHas('attributeValues', fn($q) =>
        $q->whereIn('slug', ['blumig', 'frisch', 'rose']),
        '=', 3
    )
    ->with(['variants' => fn($q) => $q->where('is_active', true), 'primaryMedia'])
    ->withMin('variants', 'price')
    ->orderBy('variants_min_price')
    ->paginate(25);
```

The `'=', 3` enforces AND across the three filter values (all must match).

---

## 7. Build Phases

The build is split into seven phases. Each phase has a clear deliverable, acceptance criteria that define "done," and dependencies on prior phases. **Tasks are not pre-written here** — when starting a phase, Claude Code should read this section, generate a task list specific to that phase based on what was actually built in prior phases, save it as `PHASE_N_TASKS.md` at the project root, then execute. Update `PROGRESS.md` as phases complete.

> **Why no upfront task lists?** Pre-written tasks go stale as the build progresses — decisions in phase 2 affect what phase 4 needs to do. Generating tasks at the start of each phase keeps them accurate and lets the agent use what was learned along the way.

### Phase 0 — Project bootstrap

**Deliverable**: A running Laravel project with the React Starter Kit, PostgreSQL connected, and the dashboard accessible at `/dashboard`.

**Acceptance criteria**:
- Laravel app installed with React Starter Kit (Inertia + React).
- PostgreSQL configured in `.env`; `php artisan migrate` runs cleanly.
- `php artisan storage:link` executed.
- `is_admin` column added to `users` migration; one seeded admin user exists.
- Admin middleware protects `/dashboard` routes; non-admins are redirected.
- README updated with local setup instructions (PHP/Node versions, install commands).

### Phase 1 — Schema & seed data

**Deliverable**: All tables from section 4 created, with attributes/attribute_values/categories seeded with the values from section 3.

**Acceptance criteria**:
- Migrations exist for: `categories`, `attributes`, `attribute_values`, `products`, `product_variants`, `category_product`, `product_attribute_value`, `media`, `translations`, `page_sections`, `promotions`, `settings`.
- All foreign keys, indexes, and unique constraints from section 4 are in place.
- `jsonb` used for `page_sections.payload`; `timestamptz` used throughout.
- Seeders populate: 7 categories, 4 attributes (art, familie, stimmung, noten), and all attribute values from section 3 — each with German translations seeded into the `translations` table.
- A factory exists for `Product` and `ProductVariant` to make local testing easy.
- `php artisan migrate:fresh --seed` produces a working DB with no errors.

### Phase 2 — Models & business logic

**Deliverable**: Eloquent models with all relationships, the slug-generation observer, and the active-promotion query helper.

**Acceptance criteria**:
- Models created: `Product`, `Category`, `Attribute`, `AttributeValue`, `ProductVariant`, `Media`, `Translation`, `PageSection`, `Promotion`, `Setting`, `User`.
- Relationships defined per the ERD (section 5).
- A `HasTranslations` trait or equivalent provides `$model->translate($locale, $field)`.
- A `HasSlug` trait auto-generates slugs from the German `name` field on save, with umlaut transliteration (ä→ae, ö→oe, ü→ue, ß→ss) and collision suffixes (`-2`, `-3`).
- `Promotion::active()` scope returns only currently-active promotions (within `starts_at`/`ends_at` window and `is_active = true`).
- Feature tests cover the filter query example from section 6 and the active-promotion scope.

### Phase 3 — Admin dashboard (German-only)

**Deliverable**: Full CRUD UI in the dashboard for all admin-managed entities.

**Acceptance criteria**:
- Dashboard pages (Inertia + React, German UI labels):
  - Products list, create, edit (with variant inline editor, attribute multi-select, image upload, DE/AR/EN translation tabs for translatable fields).
  - Categories list, create, edit.
  - Attributes & attribute values management.
  - Page sections editor (hero, about, why_us, featured_products) with translation tabs.
  - Promotions list, create, edit (with date pickers, image upload, translation tabs).
  - Settings page (key-value form for WhatsApp, email, social links, etc.).
- Image uploads stored to `storage/app/public/media/` and recorded in the `media` table.
- Form validation on both the client (React) and server (FormRequest classes).
- All admin UI text is in German. Translation tabs only affect content shown on the public site.

### Phase 4 — Public frontend (German first)

**Deliverable**: Public-facing site fully functional in German. AR/EN come in phase 5.

**Acceptance criteria**:
- Routes implemented per section 2: `/`, `/luxusparfums`, `/nischenparfums`, `/designerparfums`, `/arabische-parfums`, `/damenparfums`, `/herrenparfums`, `/unisex-parfums`, `/preise`, `/kontakt`, `/produkt/{slug}`.
- Homepage renders: nav, promo hero (rotating carousel of active promotions, fallback to default hero image), Luxus-Highlights featured products, Über uns, Warum wir.
- Category pages render: header banner, filter UI (inline on desktop, off-canvas drawer button on mobile), paginated product grid (4 cols desktop / 2 cols mobile), price range on cards (`10,00 € – 55,00 €`).
- Filter logic: AND across attribute groups, OR within a group. Selected filters reflected in the URL query string so they're shareable.
- Product detail page shows: gallery, name, description, variant selector with price, attribute badges (Familie/Stimmung/Noten), back-to-category link.
- Floating contact sidebar (WhatsApp, email, phone, social) on every page, pulling values from `settings`.
- `/kontakt` page lists contact methods (no form).
- Mobile responsive throughout.

### Phase 5 — Internationalization (AR + EN)

**Deliverable**: Full trilingual public site with proper RTL handling for Arabic.

**Acceptance criteria**:
- Locale switcher visible on every page (flag icons), stores choice in a cookie or session.
- All translatable content (products, categories, attribute values, page sections, promotions) renders in the active locale, falling back to German if a translation is missing.
- URL strategy decided and implemented (e.g., `/de/...`, `/ar/...`, `/en/...` prefix or single-domain with locale cookie — pick what works best with the starter kit's routing).
- Arabic locale switches the document to `dir="rtl"`; layout mirrors correctly (filter drawer slides in from the left, product card icons swap sides, navigation aligns right).
- A locale-aware date/number formatter is used for prices (`10,00 €` for DE, `€10.00` for EN, Arabic numerals optional for AR).
- Admin can save translations for all listed entities from the dashboard's translation tabs.

### Phase 6 — SEO, performance, polish

**Deliverable**: Production-ready site.

**Acceptance criteria**:
- `<title>`, meta description, and Open Graph tags pulled from each entity's translatable `meta_title` / `meta_description` / primary image.
- `hreflang` tags on every page linking to the other locale versions.
- `sitemap.xml` generated dynamically including all products, categories, and the homepage.
- `robots.txt` excludes `/dashboard` and `/login`.
- Images served at appropriate sizes (Laravel's image manipulation library or a simple resize on upload).
- Lighthouse score ≥90 for Performance, Accessibility, Best Practices, SEO on the homepage and a category page.
- 404 page styled to match the site.
- Favicon and PWA manifest in place.

### Phase 7 — Deployment

**Deliverable**: Site live at [https://goanperfume.de/](https://goanperfume.de/).

**Acceptance criteria**:
- Production environment configured (PHP, PostgreSQL, web server, HTTPS).
- `.env.production` set with real values (DB credentials, mailer, app URL, app key).
- Asset build pipeline runs (`npm run build`) and assets are served correctly.
- Database migrations and seeders run in production; one admin account exists.
- Storage symlink created on the production server.
- Domain points to the server; HTTPS works; HTTP redirects to HTTPS.
- A backup strategy is in place for the database and `storage/app/public/`.

---

## 7a. How Claude Code should work through phases

1. **At the start of each phase**, read this `PROJECT.md` (especially the relevant phase's acceptance criteria) plus any earlier `PHASE_N_TASKS.md` files to understand what was built.
2. **Generate** a `PHASE_N_TASKS.md` file with concrete, ordered tasks needed to satisfy that phase's acceptance criteria. Include rough effort estimates if helpful.
3. **Confirm** the task list with the human before executing if the phase is large or has ambiguous parts.
4. **Execute** tasks in order, checking each off in the file as it completes.
5. **Update** `PROGRESS.md` (a top-level file with one line per completed phase + date + any notes) when the phase is done and all acceptance criteria pass.
6. **Do not** start the next phase without explicit confirmation from the human — phases are also natural review checkpoints.

---

## 8. Resolved Decisions

These were initially open and are now finalized:

- **Variant display on product cards**: **Price range** — show the min and max active variant prices (e.g., `10,00 € – 55,00 €`). When all variants have the same price, show a single price. Compute via `Product::withMin('variants', 'price')->withMax('variants', 'price')` to keep it efficient.
- **Filter UX on mobile**: **Collapsible / off-canvas drawer**. Below the category banner, render a single "Filter" button that opens a slide-in drawer (right edge for LTR, left edge for RTL/Arabic). The drawer contains the Familie, Stimmung, and Noten groups with chip-style toggles. On desktop, filters render inline above the product grid as in the references.
- **Image storage**: **Local Laravel storage** (`storage/app/public`). Use `php artisan storage:link` for public access. Store relative paths in `media.path` and resolve with `Storage::url()`. Migration to S3 later requires only an `.env` change since the code uses the storage facade.
- **Admin auth**: Simple **`is_admin` boolean** on the `users` table. Protect dashboard routes with a middleware that checks `auth()->user()?->is_admin`. No roles/permissions package — keep it simple.
- **Slug generation**: **Auto-generated** from the German `name` field on model save. Use Laravel's `Str::slug()` with German transliteration (ä→ae, ö→oe, ü→ue, ß→ss). Implement via a model observer or a `boot()` method on `Product`, `Category`, and `AttributeValue`. The slug should only auto-generate when empty so admins can override it manually if needed. Ensure uniqueness by appending `-2`, `-3`, etc. on collisions.
