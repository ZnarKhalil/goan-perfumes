# SEO Improvement Plan

This document outlines practical SEO improvements for Goan Perfume. The site is a multilingual Laravel/Inertia product showcase for perfumes, with public catalogue pages and a private admin dashboard.

The goal is to help search engines crawl, index, understand, and present the public website more effectively, while keeping private/auth/admin surfaces out of search results.

## Current SEO Priorities

### 1. Improve Crawlability And Renderability

The public website is powered by Inertia and React. Search engines can process JavaScript, but relying only on client-side rendering can make crawling, previews, and indexing less predictable.

Recommended actions:

- Add server-side rendering or prerendering for public pages.
- Prioritize these pages:
  - Home pages: `/de`, `/en`, `/ar`
  - Category pages
  - Product pages
  - Contact page
  - Impressum
  - Privacy policy
- Keep admin, auth, settings, and error pages outside SEO targets.

Expected benefit:

- Better crawl reliability.
- Better initial HTML for search engines and social previews.
- Improved perceived performance and possible Core Web Vitals gains.

Acceptance criteria:

- Public pages return meaningful HTML before JavaScript hydration.
- Product names, category names, descriptions, and internal links are visible in the initial HTML.
- Auth/admin/error pages are not indexed.

## 2. Add A Dynamic XML Sitemap

Create a sitemap that lists all important public URLs.

Include:

- Localized home pages.
- Active category pages.
- Active product pages.
- Contact, Impressum, and privacy pages.

Exclude:

- `/login`
- `/dashboard`
- `/settings`
- Two-factor and password confirmation pages.
- Error pages.
- Inactive products and categories.
- Low-value filtered URL combinations.

Recommended structure:

- `/sitemap.xml` for the sitemap index or single sitemap.
- Add last modified dates where available.
- Regenerate when products, categories, or localized content changes.

Acceptance criteria:

- Sitemap validates as XML.
- Only canonical public URLs are included.
- Sitemap is referenced in `robots.txt`.
- Sitemap is submitted in Google Search Console.

## 3. Add Canonical URLs

Canonical URLs help prevent duplicate indexing when pages can be reached with query strings, redirects, filters, or alternate paths.

Recommended actions:

- Add a canonical tag to every public page.
- Canonicalize product pages to their clean localized product URL.
- Canonicalize category pages to their clean localized category URL unless a filtered URL is intentionally indexable.
- Avoid canonical URLs pointing to redirects.

Examples:

```html
<link rel="canonical" href="https://example.com/de/produkt/iris-musk">
```

Acceptance criteria:

- Every public page has exactly one canonical URL.
- Canonical URL matches the preferred localized URL.
- Filtered pages have a defined canonical strategy.

## 4. Add Hreflang For Localized Pages

The site supports German, English, and Arabic. Search engines should understand which pages are alternate language versions of each other.

Recommended actions:

- Add `hreflang` links for `de`, `en`, and `ar` on localized pages.
- Add an `x-default` URL, likely pointing to the German default or locale selector behavior.
- Ensure every alternate page links back to every other alternate page.

Example:

```html
<link rel="alternate" hreflang="de" href="https://example.com/de/produkt/iris-musk">
<link rel="alternate" hreflang="en" href="https://example.com/en/produkt/iris-musk">
<link rel="alternate" hreflang="ar" href="https://example.com/ar/produkt/iris-musk">
<link rel="alternate" hreflang="x-default" href="https://example.com/de/produkt/iris-musk">
```

Acceptance criteria:

- Each localized public page has complete reciprocal hreflang tags.
- URLs return `200`, not redirects.
- Arabic pages keep correct `dir="rtl"` and language metadata.

## 5. Improve Page Titles And Meta Descriptions

Titles and descriptions should be unique, concise, and aligned with search intent.

Recommended title patterns:

- Home: `Goan Perfume | Luxury Perfumes In Germany`
- Category: `{Category Name} | Goan Perfume`
- Product: `{Product Name} | {Brand} | Goan Perfume`
- Contact: `Contact Goan Perfume | Perfume Advice In Germany`

Recommended meta description patterns:

- Home: Describe the shop, perfume catalogue, and direct contact purchase flow.
- Category: Describe the scent/category type and who it is for.
- Product: Mention brand, scent family, size/price if available, and contact/order flow.
- Contact: Mention WhatsApp, phone, email, and fragrance advice.

Acceptance criteria:

- Every public page has a unique title.
- Every public page has a unique meta description.
- Titles stay roughly under 60 characters where possible.
- Descriptions stay roughly under 155 to 160 characters where possible.

## 6. Add Structured Data

Structured data helps search engines understand products, business identity, breadcrumbs, and local context.

### Product Schema

Add `Product` JSON-LD on product pages.

Useful fields:

- `name`
- `image`
- `description`
- `brand`
- `category`
- `offers`, if price and availability are reliable
- `url`

Acceptance criteria:

- Product structured data validates in Google's Rich Results Test.
- Only visible and accurate product information is included.
- Price and availability are not added unless they are reliable.

### LocalBusiness Or Store Schema

Add business structured data on the home page and contact page.

Useful fields:

- Business name.
- URL.
- Logo.
- Phone.
- Email.
- Address, if public and accurate.
- Opening hours, if available.
- Social profiles via `sameAs`.

Acceptance criteria:

- Business structured data matches visible contact/legal information.
- No fake reviews, ratings, or claims are included.

### Breadcrumb Schema

Add breadcrumb JSON-LD to category and product pages.

Examples:

- Home > Category
- Home > Category > Product

Acceptance criteria:

- Breadcrumbs reflect the visible or logical site hierarchy.
- Breadcrumb URLs are canonical URLs.

## 7. Strengthen Product Page Content

Product pages should target long-tail perfume search intent, not only display product cards.

Recommended product details:

- Brand.
- Product name.
- Size or volume.
- Price or price-on-request status.
- Scent family.
- Top, middle, and base notes.
- Occasion or season.
- Longevity and sillage, only if accurate.
- Gender positioning if relevant.
- Short purchase/contact instruction.
- Related products or categories.

Acceptance criteria:

- Product pages have enough unique content to stand alone in search.
- Product descriptions are not duplicated across many products.
- Content avoids unsupported claims.

## 8. Strengthen Category Landing Pages

Category pages should be useful landing pages, not just grids.

Recommended content:

- A short localized intro paragraph.
- Explanation of the category or scent family.
- Suggested use cases.
- Internal links to related categories.
- Clear contact or advice CTA.

Examples of category content angles:

- Luxury perfumes.
- Women's perfumes.
- Men's perfumes.
- Oriental perfumes.
- Gift fragrances.

Acceptance criteria:

- Each category has unique localized copy.
- Category copy appears before or near the product grid.
- Internal links help users and search engines discover related pages.

## 9. Add Editorial Content

Editorial pages can capture informational search intent and link users into the catalogue.

Recommended topics:

- How to choose a perfume.
- Arabic perfumes in Germany.
- Luxury perfume gift ideas.
- Eau de parfum vs extrait de parfum.
- Best evening perfumes.
- How perfume notes work.
- How to make perfume last longer.

Acceptance criteria:

- Articles link to relevant products and categories.
- Articles answer real user questions.
- Content is localized at least in German first, then English and Arabic where useful.

## 10. Optimize Images

Perfume websites rely heavily on visuals, so image SEO and performance matter.

Recommended actions:

- Use descriptive image filenames for newly uploaded product images.
- Add meaningful alt text for product images.
- Keep decorative images empty-alt where appropriate.
- Generate responsive image sizes.
- Prefer WebP or AVIF for public images.
- Add width and height attributes where possible.
- Lazy-load below-the-fold images.
- Prioritize the hero/LCP image.

Acceptance criteria:

- Product images have descriptive alt text.
- Decorative images do not create noisy screen reader output.
- Largest public images are compressed and responsive.
- Lighthouse does not report major image sizing issues.

## 11. Define Filter And Pagination SEO Rules

Filtered category URLs can create many duplicate or thin pages.

Recommended strategy:

- Keep most filtered URLs crawlable for users but canonicalized to the base category.
- Only index filtered pages when they represent meaningful demand.
- Avoid generating sitemap entries for arbitrary filter combinations.
- Keep pagination crawlable where useful.

Potential indexable filter examples:

- `/de/luxusparfums?duftfamilie=orientalisch`
- `/de/damenparfums?duftfamilie=blumig`

Acceptance criteria:

- Filter URLs have a documented canonical strategy.
- Sitemap excludes low-value filter combinations.
- Important filtered landing pages have unique copy if indexed.

## 12. Improve Internal Linking

Internal links help users and search engines understand page relationships.

Recommended actions:

- Link from home sections to key categories.
- Link from categories to related categories.
- Link from products to their categories.
- Link from editorial articles to relevant products and categories.
- Add breadcrumbs or visible contextual navigation where useful.

Acceptance criteria:

- Important product and category pages are reachable within a few clicks from the home page.
- No public product page is orphaned.
- Anchor text is descriptive.

## 13. Local SEO And Trust Signals

Goan Perfume appears to serve customers through direct contact channels. Local trust signals can improve search confidence and conversions.

Recommended actions:

- Keep business name, phone, email, and address consistent across the site.
- Create or optimize Google Business Profile if applicable.
- Add social profile links consistently.
- Add clear contact options on product and category pages.
- Include service area or shop location if relevant.
- Align website contact details with Impressum details.

Acceptance criteria:

- Contact details are consistent across home, contact, footer, and Impressum.
- Google Business Profile points to the canonical website.
- LocalBusiness structured data matches visible business details.

## 14. Robots And Indexing Controls

Recommended robots strategy:

- Allow public pages and public assets.
- Disallow or noindex private surfaces.
- Ensure error pages are not indexed.
- Ensure login and admin routes are not indexed.

Suggested noindex targets:

- `/login`
- `/dashboard`
- `/settings`
- `/two-factor-challenge`
- `/user/confirm-password`
- Error pages.

Acceptance criteria:

- `robots.txt` references the sitemap.
- Private pages are protected and not indexable.
- Public CSS, JS, and image assets are crawlable.

## 15. Core Web Vitals And Performance

Recommended actions:

- Measure home, category, and product pages with Lighthouse/PageSpeed Insights.
- Optimize LCP image/video on the home page.
- Avoid loading admin-only JavaScript on public pages where possible.
- Keep fonts efficient and preloaded where useful.
- Reduce layout shift from images and product cards.
- Test mobile performance first.

Acceptance criteria:

- Public pages pass or approach Core Web Vitals thresholds.
- LCP element is optimized.
- CLS remains low.
- Public pages avoid unnecessary dashboard/admin code.

## 16. Search Console And Analytics

Recommended setup:

- Verify the domain in Google Search Console.
- Submit sitemap.
- Monitor indexed pages.
- Monitor canonical and hreflang issues.
- Monitor 404s and redirects.
- Connect Google Analytics reporting where consent allows.

Key reports to review monthly:

- Queries by page.
- Pages with impressions but low CTR.
- Crawled but not indexed pages.
- Duplicate without user-selected canonical.
- Core Web Vitals.
- Mobile usability.

Acceptance criteria:

- Search Console is configured before launch or before SEO rollout.
- Sitemap is submitted and processed.
- SEO issues are reviewed on a recurring schedule.

## Suggested Implementation Phases

### Phase 1: Technical Foundation

- Add sitemap.
- Add canonical tags.
- Add hreflang tags.
- Add robots/noindex strategy.
- Confirm public pages render crawlable content.

### Phase 2: Structured Data

- Add Product JSON-LD.
- Add LocalBusiness or Store JSON-LD.
- Add Breadcrumb JSON-LD.
- Validate with Rich Results Test.

### Phase 3: Content Improvements

- Improve product page content.
- Improve category intros.
- Add internal links.
- Add German editorial content first.

### Phase 4: Performance

- Optimize images.
- Review JS bundle splitting.
- Improve LCP and CLS.
- Re-test mobile performance.

### Phase 5: Monitoring

- Set up Search Console.
- Submit sitemap.
- Track indexing, CTR, and errors.
- Iterate based on real query data.

## Reference Sources

- Google SEO Starter Guide: https://developers.google.com/search/docs/fundamentals/seo-starter-guide
- Google JavaScript SEO Basics: https://developers.google.com/search/docs/crawling-indexing/javascript/javascript-seo-basics
- Google Localized Versions / Hreflang: https://developers.google.com/search/docs/specialty/international/localized-versions
- Google Product Structured Data: https://developers.google.com/search/docs/appearance/structured-data/product
- Google Search Console: https://search.google.com/search-console
