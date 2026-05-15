<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotion;
use App\Models\Setting;
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
    Promotion::factory()->create(['slug' => 'aktion'])->setTranslation('de', 'title', 'Aktion');

    $this->get('/')
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

test('home falls back to hero section when there are no active promotions', function () {
    PageSection::query()->create([
        'key' => 'hero',
        'type' => 'hero',
        'payload' => ['image_path' => 'page-sections/fallback.jpg'],
        'sort_order' => 0,
        'is_active' => true,
    ])->setTranslation('de', 'title', 'Fallback Hero');
    Promotion::factory()->disabled()->create(['slug' => 'inaktiv'])
        ->setTranslation('de', 'title', 'Inaktiv');

    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->has('promotions', 0)
            ->where('page_sections.hero.title', 'Fallback Hero')
            ->where('page_sections.hero.image_url', '/storage/page-sections/fallback.jpg'),
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

    $this->get('/damenparfums?familie=blumig')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('category.slug', 'damenparfums')
            ->where('filters.0.values.0.selected', true)
            ->where('selected_filters.familie.0', 'blumig')
            ->has('products', 1)
            ->where('products.0.slug', 'rose-oud')
            ->where('pagination.total', 1),
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

    $this->get('/damenparfums?familie=blumig,fruchtig&stimmung=frisch')
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

test('inactive category returns not found', function () {
    publicCategory('herrenparfums', 'Herrenparfums')->update(['is_active' => false]);

    $this->get('/herrenparfums')->assertNotFound();
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

    $this->get('/produkt/iris-musk')
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

    $this->get('/produkt/iris-musk')->assertNotFound();
});

test('pricing and contact pages render public layout props', function () {
    Setting::put('email', 'kontakt@example.test');
    publicCategory('arabische-parfums', 'Arabische Parfums');

    $this->get('/preise')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/pricing')
            ->has('categories', 1)
            ->where('categories.0.slug', 'arabische-parfums')
            ->where('contact.email_url', 'mailto:kontakt@example.test'),
        );

    $this->get('/kontakt')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/contact')
            ->where('contact.email', 'kontakt@example.test')
            ->has('navigation', 1),
        );
});

test('empty contact settings are returned as null urls', function () {
    $this->get('/kontakt')
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

    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->has('navigation', 7)
            ->has('promotions', 2)
            ->has('featured_products', 4)
            ->where('contact.whatsapp_url', 'https://wa.me/491701234567')
            ->where('page_sections.hero.image_url', fn (string $url) => str_starts_with($url, 'https://images.unsplash.com/')),
        );

    $this->get('/luxusparfums')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/category')
            ->where('category.image_url', fn (string $url) => str_starts_with($url, 'https://images.unsplash.com/'))
            ->has('products', 5)
            ->where('pagination.total', 5)
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
