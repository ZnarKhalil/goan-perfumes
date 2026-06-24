<?php

use App\Models\Category;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Cache;
use Inertia\Testing\AssertableInertia as Assert;

test('sitemap lists localized public urls for active content only', function () {
    Cache::forget('public.sitemap.xml');

    $absolute = fn (string $path): string => url($path);

    $activeCategory = Category::factory()->create([
        'slug' => 'luxusparfums',
        'is_active' => true,
    ]);
    Category::factory()->create([
        'slug' => 'inaktiv',
        'is_active' => false,
    ]);
    $activeProduct = Product::factory()->create([
        'slug' => 'iris-musk',
        'is_active' => true,
    ]);
    Product::factory()->create([
        'slug' => 'archiv',
        'is_active' => false,
    ]);

    $response = $this->get('/sitemap.xml');

    $response
        ->assertOk()
        ->assertHeader('content-type', 'application/xml; charset=UTF-8');

    $xml = simplexml_load_string($response->getContent());
    expect($xml)->not->toBeFalse();

    $xml->registerXPathNamespace('sitemap', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $xml->registerXPathNamespace('xhtml', 'http://www.w3.org/1999/xhtml');

    $locations = collect($xml->xpath('//sitemap:url'))
        ->map(fn (SimpleXMLElement $url): string => (string) $url->loc)
        ->all();

    expect($locations)
        ->toContain($absolute('/de'))
        ->toContain($absolute('/en'))
        ->toContain($absolute('/ar'))
        ->toContain($absolute('/de/kontakt'))
        ->toContain($absolute('/de/impressum'))
        ->toContain($absolute('/de/datenschutz'))
        ->toContain($absolute('/de/agb'))
        ->toContain($absolute('/de/luxusparfums'))
        ->toContain($absolute('/en/luxusparfums'))
        ->toContain($absolute('/ar/luxusparfums'))
        ->toContain($absolute('/de/produkt/iris-musk'))
        ->toContain($absolute('/en/produkt/iris-musk'))
        ->toContain($absolute('/ar/produkt/iris-musk'))
        ->not->toContain($absolute('/de/inaktiv'))
        ->not->toContain($absolute('/de/produkt/archiv'));
    expect(collect($locations)->every(fn (string $location): bool => ! str_contains($location, '?')))->toBeTrue();

    $categoryUrl = collect($xml->xpath('//sitemap:url'))
        ->first(fn (SimpleXMLElement $url): bool => (string) $url->loc === $absolute('/de/luxusparfums'));
    $productUrl = collect($xml->xpath('//sitemap:url'))
        ->first(fn (SimpleXMLElement $url): bool => (string) $url->loc === $absolute('/de/produkt/iris-musk'));
    $homeUrl = collect($xml->xpath('//sitemap:url'))
        ->first(fn (SimpleXMLElement $url): bool => (string) $url->loc === $absolute('/de'));
    $categoryAlternates = collect($categoryUrl->xpath('xhtml:link'))
        ->mapWithKeys(fn (SimpleXMLElement $link): array => [
            (string) $link['hreflang'] => (string) $link['href'],
        ]);

    expect((string) $categoryUrl->lastmod)->toBe($activeCategory->updated_at->toDateString());
    expect((string) $productUrl->lastmod)->toBe($activeProduct->updated_at->toDateString());
    expect((string) $homeUrl->lastmod)->not->toBe('')
        ->and($categoryAlternates->all())->toMatchArray([
            'de' => $absolute('/de/luxusparfums'),
            'en' => $absolute('/en/luxusparfums'),
            'ar' => $absolute('/ar/luxusparfums'),
            'x-default' => $absolute('/de/luxusparfums'),
        ]);
});

test('robots file references the sitemap', function () {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertSee('Disallow: /dashboard', false)
        ->assertSee('Disallow: /settings', false)
        ->assertSee('Disallow: /login', false)
        ->assertSee('Disallow: /two-factor-challenge', false)
        ->assertSee('Disallow: /user/confirm-password', false)
        ->assertSee('Allow: /build/', false)
        ->assertSee('Allow: /storage/', false)
        ->assertSee('Sitemap: '.url('/sitemap.xml'), false);
});

test('public pages expose clean canonical urls in their props', function () {
    $absolute = fn (string $path): string => url($path);

    $category = Category::factory()->create([
        'slug' => 'damenparfums',
        'is_active' => true,
    ]);
    $category->setTranslation('de', 'name', 'Damenparfums');
    $category->setTranslation('de', 'description', 'Damenparfums Beschreibung');
    $product = Product::factory()->create([
        'slug' => 'rose-oud',
        'is_active' => true,
    ]);
    $product->setTranslation('de', 'name', 'Rose Oud');
    $product->categories()->attach($category);
    ProductVariant::factory()->for($product)->default()->create();

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.canonical', $absolute('/de'))
            ->where('meta.robots', null)
            ->where('meta.alternates.de', $absolute('/de'))
            ->where('meta.alternates.en', $absolute('/en'))
            ->where('meta.alternates.ar', $absolute('/ar'))
            ->where('meta.alternates.x-default', $absolute('/de'))
        );

    $this->get('/de/damenparfums?familie=blumig&page=2')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.canonical', $absolute('/de/damenparfums'))
            ->where('meta.robots', 'noindex, follow')
            ->where('meta.alternates.de', $absolute('/de/damenparfums'))
            ->where('meta.alternates.en', $absolute('/en/damenparfums'))
            ->where('meta.alternates.ar', $absolute('/ar/damenparfums'))
            ->where('meta.alternates.x-default', $absolute('/de/damenparfums'))
        );

    $this->get('/de/produkt/rose-oud?utm_source=test')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.canonical', $absolute('/de/produkt/rose-oud'))
            ->where('meta.alternates.de', $absolute('/de/produkt/rose-oud'))
            ->where('meta.alternates.en', $absolute('/en/produkt/rose-oud'))
            ->where('meta.alternates.ar', $absolute('/ar/produkt/rose-oud'))
            ->where('meta.alternates.x-default', $absolute('/de/produkt/rose-oud'))
        );

    $this->get('/de/kontakt')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.canonical', $absolute('/de/kontakt'))
            ->where('meta.alternates.de', $absolute('/de/kontakt'))
            ->where('meta.alternates.en', $absolute('/en/kontakt'))
            ->where('meta.alternates.ar', $absolute('/ar/kontakt'))
            ->where('meta.alternates.x-default', $absolute('/de/kontakt'))
        );
});

test('public initial html includes canonical and hreflang fallback before hydration', function () {
    $this->get('/de')
        ->assertOk()
        ->assertSee('<link data-inertia="canonical" rel="canonical" href="'.url('/de').'">', false)
        ->assertSee('<link data-inertia="alternate-de" rel="alternate" hreflang="de" href="'.url('/de').'">', false)
        ->assertSee('<link data-inertia="alternate-en" rel="alternate" hreflang="en" href="'.url('/en').'">', false)
        ->assertSee('<link data-inertia="alternate-ar" rel="alternate" hreflang="ar" href="'.url('/ar').'">', false)
        ->assertSee('<link data-inertia="alternate-x-default" rel="alternate" hreflang="x-default" href="'.url('/de').'">', false);
});

test('public initial html includes title description and social meta fallback before hydration', function () {
    $product = Product::factory()->create([
        'slug' => 'rose-oud',
        'is_active' => true,
    ]);
    $product->setTranslation('de', 'name', 'Rose Oud');
    $product->setTranslation('de', 'meta_title', 'Rose Oud');
    $product->setTranslation('de', 'meta_description', 'Floraler Oud Duft aus der Goan Perfume Kollektion.');
    $product->media()->create([
        'path' => 'media/products/rose-oud.webp',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    ProductVariant::factory()->for($product)->default()->create();

    $this->get('/de/produkt/rose-oud')
        ->assertOk()
        ->assertSee('<title>Rose Oud - Goan Perfume</title>', false)
        ->assertSee('<meta data-inertia="description" name="description" content="Floraler Oud Duft aus der Goan Perfume Kollektion.">', false)
        ->assertSee('<meta data-inertia="og-title" property="og:title" content="Rose Oud - Goan Perfume">', false)
        ->assertSee('<meta data-inertia="og-description" property="og:description" content="Floraler Oud Duft aus der Goan Perfume Kollektion.">', false)
        ->assertSee('<meta data-inertia="og-url" property="og:url" content="'.url('/de/produkt/rose-oud').'">', false)
        ->assertSee('<meta data-inertia="og-type" property="og:type" content="product">', false)
        ->assertSee('<meta data-inertia="og-locale" property="og:locale" content="de_DE">', false)
        ->assertSee('<meta data-inertia="twitter-card" name="twitter:card" content="summary_large_image">', false)
        ->assertSee('<meta data-inertia="og-image" property="og:image" content="'.url('/storage/media/products/rose-oud.webp').'">', false)
        ->assertSee('<meta data-inertia="twitter-image" name="twitter:image" content="'.url('/storage/media/products/rose-oud.webp').'">', false);
});

test('public initial html includes lcp image preload fallback before hydration', function () {
    PageSection::query()->create([
        'key' => 'hero',
        'type' => 'hero',
        'payload' => ['image_path' => 'page-sections/hero.webp'],
        'sort_order' => 0,
        'is_active' => true,
    ]);

    $this->get('/de')
        ->assertOk()
        ->assertSee('<link data-inertia="preload-image" rel="preload" as="image" href="/storage/page-sections/hero.webp" fetchpriority="high">', false);
});

test('public non arabic initial html does not preload unrelated font families', function () {
    $this->get('/de')
        ->assertOk()
        ->assertSee('fraunces-', false)
        ->assertSee('manrope-', false)
        ->assertDontSee('instrument-sans-', false)
        ->assertDontSee('noto-kufi-arabic-', false);
});

test('public initial html includes robots fallback for category query pages before hydration', function () {
    Category::factory()->create([
        'slug' => 'damenparfums',
        'is_active' => true,
    ]);

    $this->get('/de/damenparfums?familie=blumig')
        ->assertOk()
        ->assertSee('<link data-inertia="canonical" rel="canonical" href="'.url('/de/damenparfums').'">', false)
        ->assertSee('<meta data-inertia="robots" name="robots" content="noindex, follow">', false);
});

test('public meta falls back cleanly when translated seo fields are blank or missing', function () {
    $category = Category::factory()->create([
        'slug' => 'nullable-category',
        'is_active' => true,
    ]);
    $category->setTranslation('de', 'meta_title', '');
    $category->setTranslation('de', 'meta_description', '');
    $category->setTranslation('de', 'description', '');

    $this->get('/de/nullable-category')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.title', 'nullable-category')
            ->where('meta.description', fn (string $value): bool => str_contains($value, 'nullable-category'))
            ->where('meta.canonical', url('/de/nullable-category'))
            ->where('meta.alternates.x-default', url('/de/nullable-category'))
        );
});

test('category pages expose breadcrumb structured data', function () {
    $category = Category::factory()->create([
        'slug' => 'damenparfums',
        'is_active' => true,
    ]);
    $category->setTranslation('de', 'name', 'Damenparfums');

    $this->get('/de/damenparfums')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.structured_data', function (mixed $structuredData): bool {
                $structuredData = collect($structuredData)->all();

                expect($structuredData)->toHaveCount(1);

                $breadcrumb = $structuredData[0];
                expect($breadcrumb['@context'])->toBe('https://schema.org')
                    ->and($breadcrumb['@type'])->toBe('BreadcrumbList')
                    ->and($breadcrumb['itemListElement'])->toHaveCount(2)
                    ->and($breadcrumb['itemListElement'][0]['name'])->toBe('Goan Perfume')
                    ->and($breadcrumb['itemListElement'][0]['item'])->toBe(url('/de'))
                    ->and($breadcrumb['itemListElement'][1]['position'])->toBe(2)
                    ->and($breadcrumb['itemListElement'][1]['name'])->toBe('Damenparfums')
                    ->and($breadcrumb['itemListElement'][1]['item'])->toBe(url('/de/damenparfums'));

                return true;
            })
        );
});

test('product pages expose product and breadcrumb structured data without unreliable offers', function () {
    $category = Category::factory()->create([
        'slug' => 'damenparfums',
        'is_active' => true,
    ]);
    $category->setTranslation('de', 'name', 'Damenparfums');
    $product = Product::factory()->create([
        'slug' => 'rose-oud',
        'brand' => 'Maison Goan',
        'is_active' => true,
    ]);
    $product->setTranslation('de', 'name', 'Rose Oud');
    $product->setTranslation('de', 'short_description', 'Floraler Oud Duft');
    $product->categories()->attach($category);
    $product->media()->create([
        'path' => 'media/products/rose-oud.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    ProductVariant::factory()->for($product)->default()->create();

    $this->get('/de/produkt/rose-oud')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.structured_data', function (mixed $structuredData): bool {
                $structuredData = collect($structuredData)->all();

                expect($structuredData)->toHaveCount(2);

                $productSchema = $structuredData[0];
                expect($productSchema['@context'])->toBe('https://schema.org')
                    ->and($productSchema['@type'])->toBe('Product')
                    ->and($productSchema['name'])->toBe('Rose Oud')
                    ->and($productSchema['description'])->toBe('Floraler Oud Duft')
                    ->and($productSchema['brand']['name'])->toBe('Maison Goan')
                    ->and($productSchema['category'])->toBe('Damenparfums')
                    ->and($productSchema['url'])->toBe(url('/de/produkt/rose-oud'))
                    ->and($productSchema['image'][0])->toBe(url('/storage/media/products/rose-oud.jpg'));
                expect($productSchema)->not->toHaveKey('offers');

                $breadcrumb = $structuredData[1];
                expect($breadcrumb['@type'])->toBe('BreadcrumbList')
                    ->and($breadcrumb['itemListElement'])->toHaveCount(3)
                    ->and($breadcrumb['itemListElement'][0]['item'])->toBe(url('/de'))
                    ->and($breadcrumb['itemListElement'][1]['item'])->toBe(url('/de/damenparfums'))
                    ->and($breadcrumb['itemListElement'][2]['name'])->toBe('Rose Oud')
                    ->and($breadcrumb['itemListElement'][2]['item'])->toBe(url('/de/produkt/rose-oud'));

                return true;
            })
        );
});

test('public initial html includes structured data fallback before hydration', function () {
    $category = Category::factory()->create([
        'slug' => 'damenparfums',
        'is_active' => true,
    ]);
    $category->setTranslation('de', 'name', 'Damenparfums');
    $product = Product::factory()->create([
        'slug' => 'rose-oud',
        'brand' => 'Maison Goan',
        'is_active' => true,
    ]);
    $product->setTranslation('de', 'name', 'Rose Oud');
    $product->setTranslation('de', 'short_description', 'Floraler Oud Duft');
    $product->categories()->attach($category);
    ProductVariant::factory()->for($product)->default()->create();

    $this->get('/de/produkt/rose-oud')
        ->assertOk()
        ->assertSee('<script data-inertia="structured-data-0" type="application/ld+json">', false)
        ->assertSee('"@type":"Product"', false)
        ->assertSee('"name":"Rose Oud"', false)
        ->assertSee('"@type":"BreadcrumbList"', false)
        ->assertDontSee('"offers"', false);
});
