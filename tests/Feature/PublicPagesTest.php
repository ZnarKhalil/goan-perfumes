<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotion;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\AttributeSeeder;
use Database\Seeders\AttributeValueSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DatabaseSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('home renders public props from stored content', function () {
    $imageUrl = 'https://images.example.test/amber.jpg';
    $category = publicCategory('luxusparfums', 'Luxusparfums');
    $product = publicProduct('amber-noir-intense', 'Amber Noir Intense', $category, featured: true);
    $product->media()->create([
        'path' => $imageUrl,
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    PageSection::query()->create([
        'key' => 'hero',
        'type' => 'hero',
        'payload' => ['image_path' => 'page-sections/hero.jpg'],
        'sort_order' => 0,
        'is_active' => true,
    ])->setTranslation('de', 'title', 'Goan Perfume');
    Promotion::factory()->create()->setTranslation('de', 'title', 'Aktion');

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->has('navigation', 1)
            ->where('navigation.0.slug', 'luxusparfums')
            ->has('promotions', 1)
            ->where('promotions.0.title', 'Aktion')
            ->where('page_sections.hero.title', 'Goan Perfume')
            ->has('featured_products', 1)
            ->where('featured_products.0.name', 'Amber Noir Intense')
            ->where('featured_products.0.image_url', $imageUrl),
        );
});

test('public navigation uses all active root database categories for the current locale', function () {
    $first = publicCategory('first-category', 'Erste Kategorie');
    $first->update(['sort_order' => 20]);
    $first->setTranslation('en', 'name', 'First Category');

    $second = publicCategory('second-category', 'Zweite Kategorie');
    $second->update(['sort_order' => 10]);
    $second->setTranslation('en', 'name', 'Second Category');

    publicCategory('inactive-category', 'Inaktive Kategorie')->update(['is_active' => false]);
    Category::factory()->for($second, 'parent')->create(['slug' => 'child-category']);

    $this->get('/en')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('navigation', 2)
            ->where('navigation.0.slug', 'second-category')
            ->where('navigation.0.name', 'Second Category')
            ->where('navigation.0.href', '/en/second-category')
            ->where('navigation.1.slug', 'first-category')
            ->where('navigation.1.name', 'First Category'),
        );
});

test('cached navigation links are host-relative so they survive a host change', function () {
    publicCategory('luxusparfums', 'Luxusparfums');

    // Warm the navigation cache from a request on one host, then assert the
    // cached href still works when the app is served from a different host
    // (e.g. `php artisan serve --host=0.0.0.0`).
    $this->get('/de')->assertOk();

    $this->get('http://192.168.0.10:8000/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('navigation.0.href', '/de/luxusparfums'),
        );
});

test('public navigation cache is flushed after dashboard category updates', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $category = publicCategory('old-category', 'Alte Kategorie');

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('navigation.0.name', 'Alte Kategorie'),
        );

    $this->actingAs($admin)
        ->put("/dashboard/categories/{$category->id}", [
            'parent_id' => null,
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Neue Kategorie', 'description' => 'Beschreibung'],
                'en' => ['name' => '', 'description' => ''],
                'ar' => ['name' => '', 'description' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/categories');

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('navigation.0.name', 'Neue Kategorie'),
        );
});

test('public pages expose server-generated SEO meta in their props', function () {
    $category = publicCategory('herrenparfums', 'Herrenparfums');
    $category->setTranslation('de', 'meta_title', 'Herrenparfums');
    $category->setTranslation('de', 'meta_description', 'Markante Düfte für ihn.');
    $product = publicProduct('iris-musk', 'Iris Musk', $category);
    $product->setTranslation('de', 'meta_title', 'Iris Musk');
    $product->setTranslation('de', 'meta_description', 'Kühle Iris.');

    // Home emits an empty title so the client-side Inertia title callback
    // falls back to the brand name alone (no "Goan Perfume - Goan Perfume").
    $this->get('/de')
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.title', '')
            ->where('meta.description', fn (string $value) => $value !== ''),
        );

    // Inner pages emit just the page name; the brand suffix is appended on
    // the client.
    $this->get('/de/herrenparfums')
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.title', 'Herrenparfums')
            ->where('meta.description', 'Markante Düfte für ihn.'),
        );

    $this->get('/de/produkt/iris-musk')
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.title', 'Iris Musk')
            ->where('meta.description', 'Kühle Iris.'),
        );

    $this->get('/de/kontakt')
        ->assertInertia(fn (Assert $page) => $page
            ->where('meta.title', 'Kontakt')
            ->where('meta.description', fn (string $value) => str_contains($value, 'Duftberatung')),
        );
});

test('home exposes the hero eyebrow from the page section payload', function () {
    PageSection::query()->create([
        'key' => 'hero',
        'type' => 'hero',
        'payload' => ['eyebrow' => 'Maison Goan'],
        'sort_order' => 0,
        'is_active' => true,
    ])->setTranslation('de', 'title', 'Goan Perfume');

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->where('page_sections.hero.eyebrow', 'Maison Goan'),
        );
});

test('home hero eyebrow is null when it is not configured', function () {
    PageSection::query()->create([
        'key' => 'hero',
        'type' => 'hero',
        'payload' => [],
        'sort_order' => 0,
        'is_active' => true,
    ])->setTranslation('de', 'title', 'Goan Perfume');

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->where('page_sections.hero.eyebrow', null),
        );
});

test('home falls back to hero section when there are no active promotions', function () {
    PageSection::query()->create([
        'key' => 'hero',
        'type' => 'hero',
        'payload' => [
            'image_path' => 'page-sections/fallback.jpg',
            'video_path' => 'page-sections/fallback.mp4',
        ],
        'sort_order' => 0,
        'is_active' => true,
    ])->setTranslation('de', 'title', 'Fallback Hero');
    Promotion::factory()->disabled()->create()
        ->setTranslation('de', 'title', 'Inaktiv');

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->has('promotions', 0)
            ->where('page_sections.hero.title', 'Fallback Hero')
            ->where('page_sections.hero.image_url', '/storage/page-sections/fallback.jpg')
            ->where('page_sections.hero.video_url', '/storage/page-sections/fallback.mp4'),
        );
});

test('category page renders filters products and pagination', function () {
    $category = publicCategory('damenparfums', 'Damenparfums');
    $product = publicProduct('rose-oud', 'Rose Oud', $category);
    $attribute = Attribute::factory()->multiple()->create(['code' => 'familie']);
    $attribute->setTranslation('de', 'name', 'Familie');
    $value = AttributeValue::factory()->for($attribute)->create(['slug' => 'blumig']);
    $value->setTranslation('de', 'name', 'Blumig');
    $product->attributeValues()->attach($value);

    $this->get('/de/damenparfums?familie=blumig')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('category.slug', 'damenparfums')
            ->where('locale.switcher_urls.ar', fn (string $href) => str_contains($href, '/ar/damenparfums?familie=blumig'))
            ->where('filters.0.values.0.selected', true)
            ->where('selected_filters.familie.0', 'blumig')
            ->has('products', 1)
            ->where('products.0.slug', 'rose-oud')
            ->where('pagination.total', 1),
        );
});

test('category pagination links use href and products are sorted by catalog number', function () {
    $category = publicCategory('damenparfums', 'Damenparfums');

    collect(['LU1', 'D12', 'D1', 'D2', 'D10', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'D11', 'LU2'])
        ->each(fn (string $name) => publicProduct(strtolower($name), $name, $category));

    $this->get('/de/damenparfums')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->has('products', 12)
            ->where('products.0.name', 'D1')
            ->where('products.1.name', 'D2')
            ->where('products.9.name', 'D10')
            ->where('products.11.name', 'D12')
            ->where('pagination.last_page', 2)
            ->where('pagination.links.2.href', fn (string $href) => str_contains($href, '/de/damenparfums?page=2')),
        );

    $this->get('/de/damenparfums?page=2')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->has('products', 2)
            ->where('products.0.name', 'LU1')
            ->where('products.1.name', 'LU2'),
        );
});

test('category filters use OR within a group and AND across groups', function () {
    $category = publicCategory('damenparfums', 'Damenparfums');
    $familie = Attribute::factory()->multiple()->create(['code' => 'familie']);
    $familie->setTranslation('de', 'name', 'Familie');
    $stimmung = Attribute::factory()->multiple()->create(['code' => 'stimmung']);
    $stimmung->setTranslation('de', 'name', 'Stimmung');
    $blumig = AttributeValue::factory()->for($familie)->create(['slug' => 'blumig']);
    $fruchtig = AttributeValue::factory()->for($familie)->create(['slug' => 'fruchtig']);
    $frisch = AttributeValue::factory()->for($stimmung)->create(['slug' => 'frisch']);

    $rose = publicProduct('rose-oud', 'Rose Oud', $category);
    $rose->attributeValues()->attach([$blumig->id, $frisch->id]);
    $citrus = publicProduct('citrus-musk', 'Citrus Musk', $category);
    $citrus->attributeValues()->attach([$fruchtig->id, $frisch->id]);
    $missingMood = publicProduct('soft-rose', 'Soft Rose', $category);
    $missingMood->attributeValues()->attach($blumig);

    $this->get('/de/damenparfums?familie=blumig,fruchtig&stimmung=frisch')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('selected_filters.familie.0', 'blumig')
            ->where('selected_filters.familie.1', 'fruchtig')
            ->where('selected_filters.stimmung.0', 'frisch')
            ->has('products', 2)
            ->where('products.0.slug', 'citrus-musk')
            ->where('products.1.slug', 'rose-oud')
            ->where('pagination.total', 2),
        );
});

test('public payloads use active locale with German fallback', function () {
    $category = publicCategory('damenparfums', 'Damenparfums');
    $category->setTranslation('en', 'name', 'Women Perfumes');
    $product = publicProduct('rose-oud', 'Rose Oud', $category);
    $product->setTranslation('en', 'name', 'Rose Oud EN');
    $product->setTranslation('en', 'short_description', 'Short EN');
    $product->media()->create([
        'path' => 'media/products/rose.jpg',
        'alt_text' => 'Rose Oud DE alt',
        'sort_order' => 0,
        'is_primary' => true,
    ])->setTranslation('en', 'alt_text', 'Rose Oud EN alt');
    $attribute = Attribute::factory()->multiple()->create(['code' => 'familie']);
    $attribute->setTranslation('de', 'name', 'Familie');
    $attribute->setTranslation('en', 'name', 'Family');
    $value = AttributeValue::factory()->for($attribute)->create(['slug' => 'blumig']);
    $value->setTranslation('de', 'name', 'Blumig');
    $product->attributeValues()->attach($value);

    $this->get('/en/damenparfums?familie=blumig')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('locale.current', 'en')
            ->where('category.name', 'Women Perfumes')
            ->where('category.description', 'Damenparfums Beschreibung')
            ->where('filters.0.name', 'Family')
            ->where('filters.0.values.0.name', 'Blumig')
            ->where('filters.0.values.0.href', fn (string $href) => str_contains($href, '/en/damenparfums'))
            ->where('products.0.name', 'Rose Oud EN')
            ->where('products.0.image_alt', 'Rose Oud EN alt')
            ->where('products.0.href', fn (string $href) => str_contains($href, '/en/produkt/rose-oud')),
        );

    $this->get('/en/produkt/rose-oud')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/product')
            ->where('product.name', 'Rose Oud EN')
            ->where('product.short_description', 'Short EN')
            ->where('product.media.0.alt', 'Rose Oud EN alt')
            ->where('product.attribute_groups.0.name', 'Family')
            ->where('product.attribute_groups.0.values.0.name', 'Blumig'),
        );
});

test('seeded public navigation and filters use catalog names in every locale', function () {
    $this->seed([
        CategorySeeder::class,
        AttributeSeeder::class,
        AttributeValueSeeder::class,
    ]);

    $this->get('/en/damenparfums')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('navigation.0.name', 'Damenparfums')
            ->where('category.name', 'Damenparfums')
            ->where('filters.0.name', 'Art')
            ->where('filters.0.values.0.name', 'Designer'),
        );

    $this->get('/ar/damenparfums')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('locale.dir', 'rtl')
            ->where('navigation.0.name', 'Damenparfums')
            ->where('category.name', 'Damenparfums')
            ->where('filters.0.name', 'Art')
            ->where('filters.0.values.0.name', 'Designer'),
        );
});

test('inactive category returns not found', function () {
    publicCategory('herrenparfums', 'Herrenparfums')->update(['is_active' => false]);

    $this->get('/de/herrenparfums')->assertNotFound();
});

test('product detail page renders media variants attributes and contact settings', function () {
    Setting::put('whatsapp_number', '+49 170 1234567');
    $category = publicCategory('nischenparfums', 'Nischenparfums');
    $product = publicProduct('iris-musk', 'Iris Musk', $category);
    $product->setTranslation('de', 'short_description', 'Kurz');
    $product->setTranslation('de', 'description', 'Lang');
    $product->media()->create([
        'path' => 'media/products/iris.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    $attribute = Attribute::factory()->multiple()->create(['code' => 'noten']);
    $attribute->setTranslation('de', 'name', 'Noten');
    $value = AttributeValue::factory()->for($attribute)->create(['slug' => 'iris']);
    $value->setTranslation('de', 'name', 'Iris');
    $product->attributeValues()->attach($value);

    $this->get('/de/produkt/iris-musk')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/product')
            ->where('contact.whatsapp_url', 'https://wa.me/491701234567')
            ->where('product.name', 'Iris Musk')
            ->has('product.media', 1)
            ->has('product.variants', 1)
            ->where('product.attribute_groups.0.name', 'Noten')
            ->where('product.primary_category.slug', 'nischenparfums'),
        );
});

test('inactive product returns not found', function () {
    $category = publicCategory('nischenparfums', 'Nischenparfums');
    publicProduct('iris-musk', 'Iris Musk', $category)->update(['is_active' => false]);

    $this->get('/de/produkt/iris-musk')->assertNotFound();
});

test('contact page renders public layout props', function () {
    Setting::put('email', 'kontakt@example.test');
    publicCategory('arabische-parfums', 'Arabische Parfums');

    $this->get('/de/kontakt')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/contact')
            ->where('contact.email', 'kontakt@example.test')
            ->has('navigation', 1),
        );
});

test('empty contact settings are returned as null urls', function () {
    $this->get('/de/kontakt')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/contact')
            ->where('contact.whatsapp_url', null)
            ->where('contact.email_url', null)
            ->where('contact.phone_url', null)
            ->where('contact.instagram_url', null)
            ->where('contact.tiktok_url', null)
            ->where('contact.facebook_url', null),
        );
});

test('database seeder provides complete public demo content', function () {
    $this->seed(DatabaseSeeder::class);

    $this->get('/de')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->has('navigation', 4)
            ->has('promotions', 0)
            ->has('featured_products', 4)
            ->where('contact.whatsapp_url', 'https://wa.me/491701234567')
            ->where('page_sections.hero.title', 'Parfums gezielt entdecken, persönlich beraten lassen.')
            ->where('page_sections.hero.cta_text', 'Kollektion ansehen')
            ->where('page_sections.hero.image_url', null)
            ->where('page_sections.hero.video_url', null),
        );

    $this->get('/de/luxusparfums')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('category.image_url', null)
            ->has('products', 12)
            ->where('pagination.total', 15)
            ->has('filters', 4),
        );
});

function publicCategory(string $slug, string $name): Category
{
    $category = Category::factory()->create(['slug' => $slug]);
    $category->setTranslation('de', 'name', $name);
    $category->setTranslation('de', 'description', "{$name} Beschreibung");

    return $category;
}

function publicProduct(
    string $slug,
    string $name,
    Category $category,
    bool $featured = false,
): Product {
    $product = Product::factory()->create([
        'slug' => $slug,
        'is_featured' => $featured,
        'is_active' => true,
    ]);
    $product->setTranslation('de', 'name', $name);
    $product->categories()->attach($category);
    ProductVariant::factory()->for($product)->default()->create([
        'size_ml' => 50,
        'price' => '59.90',
    ]);

    return $product;
}
