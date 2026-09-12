<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotion;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

test('pagination is indexable while filters and tracking parameters are handled separately', function (string $query, string $canonicalQuery, ?string $robots) {
    $category = Category::factory()->create(['slug' => 'perfumes', 'is_active' => true]);
    Product::factory()->count(13)->create(['is_active' => true])->each(fn (Product $product) => $product->categories()->attach($category));

    $this->get('/de/perfumes'.$query)->assertOk()->assertInertia(fn (Assert $page) => $page
        ->where('meta.canonical', url('/de/perfumes').$canonicalQuery)
        ->where('meta.alternates.en', url('/en/perfumes').$canonicalQuery)
        ->where('meta.robots', $robots));
})->with([
    ['?page=2', '?page=2', null],
    ['?page=2&utm_source=chatgpt.com&gclid=abc', '?page=2', null],
    ['?page=1&utm_campaign=test', '', null],
    ['?fbclid=abc', '', null],
    ['?familie=blumig&page=2&utm_source=test', '', 'noindex, follow'],
]);

test('offers contain only displayed variants and exact prices without stock assumptions', function () {
    $product = Product::factory()->create(['is_active' => true]);
    $product->setTranslation('de', 'name', 'D6');
    ProductVariant::factory()->for($product)->create(['size_ml' => 30, 'price' => '15.00', 'is_active' => true]);
    ProductVariant::factory()->for($product)->default()->create(['size_ml' => 50, 'price' => '20.00', 'compare_at_price' => '25.00', 'is_active' => true]);
    ProductVariant::factory()->for($product)->create(['size_ml' => 100, 'price' => '35.00', 'is_active' => false]);

    $this->get('/de/produkt/'.$product->slug)->assertOk()->assertInertia(fn (Assert $page) => $page
        ->has('product.variants', 2)
        ->has('meta.structured_data.0.offers', 2)
        ->where('meta.structured_data.0.offers.0.name', 'D6 – 30 ml')
        ->where('meta.structured_data.0.offers.0.price', '15.00')
        ->where('meta.structured_data.0.offers.1.price', '20.00')
        ->where('meta.structured_data.0.offers.1.priceCurrency', 'EUR')
        ->missing('meta.structured_data.0.offers.0.availability')
        ->missing('meta.structured_data.0.aggregateRating')
        ->missing('meta.structured_data.0.review'));
});

test('code titles and visible introductions use localized category and actual notes', function (string $locale, string $categoryName, string $noteName, string $with) {
    $category = Category::factory()->create();
    $category->setTranslation($locale, 'name', $categoryName);
    $product = Product::factory()->create(['is_active' => true]);
    $product->setTranslation('de', 'name', 'D6');
    $product->categories()->attach($category);
    $attribute = Attribute::factory()->create(['code' => 'noten']);
    $note = AttributeValue::factory()->for($attribute)->create(['is_active' => true]);
    $note->setTranslation($locale, 'name', $noteName);
    $product->attributeValues()->attach($note);
    $expected = "D6 – {$categoryName} {$with} {$noteName}";

    $this->get("/{$locale}/produkt/{$product->slug}")->assertOk()->assertInertia(fn (Assert $page) => $page
        ->where('meta.title', $expected)
        ->where('product.name', 'D6')
        ->where('product.short_description', $expected));
})->with([
    ['de', 'Damenparfums', 'Rose', 'mit'],
    ['en', "Women's perfumes", 'Rose', 'with'],
    ['ar', 'عطور نسائية', 'ورد', 'بنفحات'],
]);

test('category introductions preserve authored text and add practical guidance', function () {
    $category = Category::factory()->create(['is_active' => true]);
    $category->setTranslation('de', 'name', 'Damenparfums');
    $category->setTranslation('de', 'description', 'Zeitlose Eleganz.');

    $this->get('/de/'.$category->slug)->assertOk()->assertInertia(fn (Assert $page) => $page
        ->where('category.description', fn (string $text): bool => str_starts_with($text, 'Zeitlose Eleganz.') && str_contains($text, 'Duftfamilie und Noten') && str_contains($text, 'Verfügbarkeit')));
});

test('authored product metadata and introductions remain intact', function () {
    $product = Product::factory()->create(['is_active' => true]);
    $product->setTranslation('de', 'name', 'D6');
    $product->setTranslation('de', 'meta_title', 'D6 – Ein floraler Duft');
    $product->setTranslation('de', 'short_description', 'Ein Bouquet aus Rose und Jasmin.');

    $this->get('/de/produkt/'.$product->slug)->assertOk()->assertInertia(fn (Assert $page) => $page
        ->where('meta.title', 'D6 – Ein floraler Duft')
        ->where('product.short_description', 'Ein Bouquet aus Rose und Jasmin.'));
});

function homepageSitemapDate(TestCase $test): string
{
    $xml = simplexml_load_string($test->get('/sitemap.xml')->assertOk()->getContent());
    $xml->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    return (string) $xml->xpath('//s:url[s:loc="'.url('/de').'"]/s:lastmod')[0];
}

test('homepage lastmod follows edits and deletions even when sitemap is cached', function () {
    $this->travelTo(now()->setDate(2026, 1, 1)->startOfDay());
    $section = PageSection::query()->create(['key' => 'hero', 'type' => 'hero', 'is_active' => true, 'payload' => []]);
    $section->setTranslation('de', 'title', 'Original');
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());

    $this->travel(1)->minutes();
    $section->setTranslation('de', 'title', 'Updated');
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());

    $previousDate = homepageSitemapDate($this);
    $this->travel(1)->minutes();
    $section->setTranslation('de', 'title', 'Updated');
    expect(homepageSitemapDate($this))->toBe($previousDate);

    $section->syncTranslations(['de' => ['title' => '']], ['title']);
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());

    $this->travel(1)->minutes();
    $promotion = Promotion::factory()->create();
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());

    $this->travel(1)->minutes();
    $promotion->delete();
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());
});

test('scheduled promotion boundaries refresh sitemap freshness', function () {
    $this->travelTo(now()->setDate(2026, 1, 1)->startOfDay());
    Promotion::factory()->create(['starts_at' => now()->addMinutes(5), 'ends_at' => now()->addMinutes(10)]);
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());

    $this->travel(5)->minutes();
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());

    $this->travel(5)->minutes();
    expect(homepageSitemapDate($this))->toBe(now()->toIso8601String());
});
