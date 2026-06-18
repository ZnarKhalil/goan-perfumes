<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('non-admin users are redirected away from the products dashboard', function () {
    $regular = User::factory()->create();

    $this->actingAs($regular)
        ->get('/dashboard/products')
        ->assertRedirect('/');
});

test('admin can list products with German names categories image and price range', function () {
    Storage::fake('public');

    $category = Category::factory()->create(['slug' => 'damenparfums']);
    $category->setTranslation('de', 'name', 'Damenparfums');

    $product = Product::factory()->create(['brand' => 'Dior', 'is_featured' => true]);
    $product->setTranslation('de', 'name', 'Rose Oud');
    $product->categories()->attach($category);
    ProductVariant::factory()->for($product)->create(['price' => '49.90', 'is_default' => true]);
    ProductVariant::factory()->for($product)->create(['price' => '79.90']);
    $media = $product->media()->create([
        'path' => 'media/products/1/cover.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    Storage::disk('public')->put($media->path, 'fake');

    $this->actingAs($this->admin)
        ->get('/dashboard/products')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/products/index')
            ->has('products', 1)
            ->where('products.0.name', 'Rose Oud')
            ->where('products.0.brand', 'Dior')
            ->where('products.0.categories.0', 'Damenparfums')
            ->where('products.0.min_price', '49.90')
            ->where('products.0.max_price', '79.90')
            ->where('products.0.is_featured', true)
            ->where('pagination.total', 1)
            ->where('pagination.per_page', 25),
        );
});

test('the product index is paginated', function () {
    Product::factory()->count(26)->create();

    $this->actingAs($this->admin)
        ->get('/dashboard/products')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products', 25)
            ->where('pagination.total', 26)
            ->where('pagination.last_page', 2),
        );

    $this->actingAs($this->admin)
        ->get('/dashboard/products?page=2')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products', 1)
            ->where('pagination.current_page', 2),
        );
});

test('the product index exposes filters and category options', function () {
    Category::factory()->create()->setTranslation('de', 'name', 'Damenparfums');

    $this->actingAs($this->admin)
        ->get('/dashboard/products')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('filters.name', '')
            ->where('filters.brand', '')
            ->where('filters.category', null)
            ->where('filters.status', null)
            ->where('filters.featured', null)
            ->where('filters.sort', 'created')
            ->where('filters.direction', 'desc')
            ->has('categories', 1)
            ->where('categories.0.name', 'Damenparfums'),
        );
});

test('the product index filters by German name', function () {
    Product::factory()->create()->setTranslation('de', 'name', 'Rose Oud');
    Product::factory()->create()->setTranslation('de', 'name', 'Citrus Splash');

    $this->actingAs($this->admin)
        ->get('/dashboard/products?name=rose')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products', 1)
            ->where('products.0.name', 'Rose Oud'),
        );
});

test('the product index filters by brand', function () {
    Product::factory()->create(['brand' => 'Dior']);
    Product::factory()->create(['brand' => 'Chanel']);

    $this->actingAs($this->admin)
        ->get('/dashboard/products?brand=dio')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products', 1)
            ->where('products.0.brand', 'Dior'),
        );
});

test('the product index filters by category', function () {
    $category = Category::factory()->create();
    $matching = Product::factory()->create();
    $matching->categories()->attach($category);
    Product::factory()->create();

    $this->actingAs($this->admin)
        ->get("/dashboard/products?category={$category->id}")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products', 1)
            ->where('products.0.id', $matching->id),
        );
});

test('the product index filters by status and highlight', function () {
    Product::factory()->create(['is_active' => true, 'is_featured' => false]);
    Product::factory()->create(['is_active' => false, 'is_featured' => false]);
    Product::factory()->featured()->create(['is_active' => true]);

    $this->actingAs($this->admin)
        ->get('/dashboard/products?status=inactive')
        ->assertInertia(fn ($page) => $page
            ->has('products', 1)
            ->where('products.0.is_active', false),
        );

    $this->actingAs($this->admin)
        ->get('/dashboard/products?featured=yes')
        ->assertInertia(fn ($page) => $page
            ->has('products', 1)
            ->where('products.0.is_featured', true),
        );
});

test('the product index sorts by German name', function () {
    Product::factory()->create()->setTranslation('de', 'name', 'Zephyr');
    Product::factory()->create()->setTranslation('de', 'name', 'Amber');

    $this->actingAs($this->admin)
        ->get('/dashboard/products?sort=name&direction=asc')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('products.0.name', 'Amber')
            ->where('products.1.name', 'Zephyr'),
        );

    $this->actingAs($this->admin)
        ->get('/dashboard/products?sort=name&direction=desc')
        ->assertInertia(fn ($page) => $page
            ->where('products.0.name', 'Zephyr')
            ->where('products.1.name', 'Amber'),
        );
});

test('the product index sorts by price', function () {
    $cheap = Product::factory()->create();
    ProductVariant::factory()->for($cheap)->create(['price' => '10.00', 'is_default' => true]);
    $pricey = Product::factory()->create();
    ProductVariant::factory()->for($pricey)->create(['price' => '90.00', 'is_default' => true]);

    $this->actingAs($this->admin)
        ->get('/dashboard/products?sort=price&direction=asc')
        ->assertInertia(fn ($page) => $page
            ->where('products.0.id', $cheap->id)
            ->where('products.1.id', $pricey->id),
        );
});

test('admin can create a product with translations categories attributes variants and media', function () {
    Storage::fake('public');

    $categories = Category::factory()->count(2)->create();
    $art = Attribute::factory()->single()->create(['code' => 'art']);
    $familie = Attribute::factory()->multiple()->create(['code' => 'familie']);
    $nische = AttributeValue::factory()->for($art)->create(['slug' => 'nische']);
    $blumig = AttributeValue::factory()->for($familie)->create(['slug' => 'blumig']);
    $zitrisch = AttributeValue::factory()->for($familie)->create(['slug' => 'zitrisch']);

    $response = $this->actingAs($this->admin)
        ->post('/dashboard/products', [
            'slug' => 'manual-slug-should-be-ignored',
            'brand' => 'Maison Test',
            'is_active' => true,
            'is_featured' => true,
            'translations' => [
                'de' => [
                    'name' => 'Sommer Oud',
                    'short_description' => 'Kurz',
                    'description' => 'Lang',
                ],
                'ar' => ['name' => 'عود الصيف', 'short_description' => 'قصير'],
                'en' => ['name' => 'Summer Oud', 'description' => 'Long English description'],
            ],
            'categories' => $categories->pluck('id')->all(),
            'attribute_values' => [$nische->id, $blumig->id, $zitrisch->id],
            'variants' => [
                [
                    'size_ml' => 50,
                    'price' => '59.90',
                    'compare_at_price' => '79.90',
                    'is_default' => true,
                    'is_active' => true,
                ],
                [
                    'size_ml' => 100,
                    'price' => '99.90',
                    'compare_at_price' => null,
                    'is_default' => false,
                    'is_active' => true,
                ],
            ],
            'media_uploads' => [
                UploadedFile::fake()->image('front.jpg', 800, 800),
                UploadedFile::fake()->image('box.jpg', 800, 800),
            ],
            'media_meta' => [
                'new' => [
                    [
                        'sort_order' => 0,
                        'is_primary' => true,
                        'alt_text' => ['de' => 'Flakon vorne'],
                    ],
                    [
                        'sort_order' => 1,
                        'is_primary' => false,
                        'alt_text' => ['de' => 'Verpackung'],
                    ],
                ],
            ],
        ]);

    $response->assertRedirect('/dashboard/products');

    $product = Product::query()->sole();

    expect($product->slug)->toBe('sommer-oud');
    expect($product->brand)->toBe('Maison Test');
    expect($product->is_featured)->toBeTrue();
    expect($product->translate('de', 'name'))->toBe('Sommer Oud');
    expect($product->translate('de', 'meta_title'))->toBe('Sommer Oud');
    expect($product->translate('de', 'meta_description'))->toBe('Kurz');
    expect($product->translate('en', 'name'))->toBe('Summer Oud');
    expect($product->translate('en', 'meta_title'))->toBe('Summer Oud');
    expect($product->translate('en', 'meta_description'))->toBe('Long English description');
    expect($product->translate('ar', 'meta_title'))->toBe('عود الصيف');
    expect($product->translate('ar', 'meta_description'))->toBe('قصير');
    expect($product->categories()->pluck('categories.id')->sort()->values()->all())
        ->toBe($categories->pluck('id')->sort()->values()->all());
    expect($product->attributeValues()->pluck('attribute_values.id')->sort()->values()->all())
        ->toBe(collect([$nische->id, $blumig->id, $zitrisch->id])->sort()->values()->all());
    expect($product->variants)->toHaveCount(2);
    expect($product->variants()->where('is_default', true)->sole()->size_ml)->toBe(50);
    expect($product->media)->toHaveCount(2);
    expect($product->media()->primary()->sole()->translate('de', 'alt_text'))->toBe('Flakon vorne');

    $product->media->each(fn (Media $media) => Storage::disk('public')->assertExists($media->path));
});

test('store rejects multiple values for a single-select attribute and missing default variant', function () {
    $category = Category::factory()->create();
    $art = Attribute::factory()->single()->create(['code' => 'art']);
    $nische = AttributeValue::factory()->for($art)->create(['slug' => 'nische']);
    $designer = AttributeValue::factory()->for($art)->create(['slug' => 'designer']);

    $this->actingAs($this->admin)
        ->post('/dashboard/products', [
            'slug' => 'invalid',
            'brand' => null,
            'is_active' => true,
            'is_featured' => false,
            'translations' => [
                'de' => ['name' => 'Invalid'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'categories' => [$category->id],
            'attribute_values' => [$nische->id, $designer->id],
            'variants' => [
                [
                    'size_ml' => 50,
                    'price' => '50.00',
                    'compare_at_price' => null,
                    'is_default' => false,
                    'is_active' => true,
                ],
            ],
        ])
        ->assertSessionHasErrors(['attribute_values', 'variants']);

    expect(Product::count())->toBe(0);
});

test('create and edit expose remaining homepage highlight slots', function () {
    Product::factory()->count(3)->featured()->create();
    $featured = Product::factory()->featured()->create();
    $featured->setTranslation('de', 'name', 'Featured');

    $this->actingAs($this->admin)
        ->get('/dashboard/products/create')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('highlightSlots.max', 4)
            ->where('highlightSlots.used', 4)
            ->where('highlightSlots.remaining', 0),
        );

    $this->actingAs($this->admin)
        ->get("/dashboard/products/{$featured->id}/edit")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('highlightSlots.max', 4)
            ->where('highlightSlots.used', 3)
            ->where('highlightSlots.remaining', 1),
        );
});

test('store rejects a fifth homepage highlight', function () {
    Product::factory()->count(4)->featured()->create();
    $category = Category::factory()->create();

    $this->actingAs($this->admin)
        ->post('/dashboard/products', [
            'slug' => '',
            'brand' => null,
            'is_active' => true,
            'is_featured' => true,
            'translations' => [
                'de' => ['name' => 'Too Many Highlights'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'categories' => [$category->id],
            'attribute_values' => [],
            'variants' => [
                [
                    'size_ml' => 50,
                    'price' => '50.00',
                    'compare_at_price' => null,
                    'is_default' => true,
                    'is_active' => true,
                ],
            ],
        ])
        ->assertSessionHasErrors('is_featured');

    expect(Product::where('is_featured', true)->count())->toBe(4);
});

test('update rejects exceeding the homepage highlight limit', function () {
    Product::factory()->count(4)->featured()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create(['slug' => 'normal']);
    $variant = ProductVariant::factory()->for($product)->create([
        'size_ml' => 50,
        'price' => '50.00',
        'is_default' => true,
    ]);

    $this->actingAs($this->admin)
        ->put("/dashboard/products/{$product->id}", [
            'brand' => null,
            'is_active' => true,
            'is_featured' => true,
            'translations' => [
                'de' => ['name' => 'Normal'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'categories' => [$category->id],
            'attribute_values' => [],
            'variants' => [
                [
                    'id' => $variant->id,
                    'size_ml' => 50,
                    'price' => '50.00',
                    'compare_at_price' => null,
                    'is_default' => true,
                    'is_active' => true,
                ],
            ],
        ])
        ->assertSessionHasErrors('is_featured');

    expect($product->refresh()->is_featured)->toBeFalse();
    expect(Product::where('is_featured', true)->count())->toBe(4);
});

test('admin can update an existing homepage highlight with new media', function () {
    Storage::fake('public');

    Product::factory()->count(3)->featured()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->featured()->create(['slug' => 'featured']);
    $product->setTranslation('de', 'name', 'Featured');
    $product->categories()->attach($category);
    $variant = ProductVariant::factory()->for($product)->create([
        'size_ml' => 50,
        'price' => '50.00',
        'is_default' => true,
    ]);

    $this->actingAs($this->admin)
        ->post("/dashboard/products/{$product->id}", [
            '_method' => 'PUT',
            'brand' => 'Goan',
            'is_active' => true,
            'is_featured' => true,
            'translations' => [
                'de' => ['name' => 'Featured', 'short_description' => '', 'description' => ''],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'categories' => [$category->id],
            'attribute_values' => [],
            'variants' => [
                [
                    'id' => $variant->id,
                    'size_ml' => 50,
                    'price' => '50.00',
                    'compare_at_price' => null,
                    'is_default' => true,
                    'is_active' => true,
                ],
            ],
            'media_uploads' => [
                UploadedFile::fake()->image('front.jpg', 1600, 2000),
            ],
            'media_meta' => [
                'new' => [
                    [
                        'sort_order' => 0,
                        'is_primary' => true,
                        'alt_text' => ['de' => 'Front'],
                    ],
                ],
            ],
        ])
        ->assertRedirect('/dashboard/products');

    expect($product->refresh()->is_featured)->toBeTrue();
    expect(Product::where('is_featured', true)->count())->toBe(4);
    expect($product->media()->primary()->sole()->translate('de', 'alt_text'))->toBe('Front');

    Storage::disk('public')->assertExists($product->media()->primary()->sole()->path);
});

test('admin can update product graph variants and media', function () {
    Storage::fake('public');

    $keepCategory = Category::factory()->create();
    $removeCategory = Category::factory()->create();
    $newCategory = Category::factory()->create();
    $familie = Attribute::factory()->multiple()->create(['code' => 'familie']);
    $oldValue = AttributeValue::factory()->for($familie)->create(['slug' => 'old']);
    $newValue = AttributeValue::factory()->for($familie)->create(['slug' => 'new']);

    $product = Product::factory()->create(['slug' => 'old', 'brand' => 'Old']);
    $product->setTranslation('de', 'name', 'Alt');
    $product->setTranslation('de', 'meta_title', 'Alter SEO Titel');
    $product->setTranslation('de', 'meta_description', 'Alte SEO Beschreibung');
    $product->categories()->attach([$keepCategory->id, $removeCategory->id]);
    $product->attributeValues()->attach($oldValue);
    $oldVariant = ProductVariant::factory()->for($product)->create([
        'size_ml' => 30,
        'price' => '39.90',
        'is_default' => true,
    ]);
    ProductVariant::factory()->for($product)->create(['size_ml' => 100, 'price' => '99.90']);
    $keptMedia = $product->media()->create([
        'path' => 'media/products/1/keep.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    $removedMedia = $product->media()->create([
        'path' => 'media/products/1/remove.jpg',
        'sort_order' => 1,
        'is_primary' => false,
    ]);
    Storage::disk('public')->put($keptMedia->path, 'keep');
    Storage::disk('public')->put($removedMedia->path, 'remove');

    $this->actingAs($this->admin)
        ->post("/dashboard/products/{$product->id}", [
            '_method' => 'PUT',
            'slug' => 'manual-slug-should-be-ignored',
            'brand' => 'Neu',
            'is_active' => true,
            'is_featured' => false,
            'translations' => [
                'de' => [
                    'name' => 'Neu',
                    'short_description' => '',
                    'description' => 'Neue ausführliche Beschreibung',
                ],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'categories' => [$keepCategory->id, $newCategory->id],
            'attribute_values' => [$newValue->id],
            'variants' => [
                [
                    'id' => $oldVariant->id,
                    'size_ml' => 50,
                    'price' => '55.00',
                    'compare_at_price' => null,
                    'is_default' => false,
                    'is_active' => true,
                ],
                [
                    'size_ml' => 100,
                    'price' => '95.00',
                    'compare_at_price' => '110.00',
                    'is_default' => true,
                    'is_active' => true,
                ],
            ],
            'media_uploads' => [
                UploadedFile::fake()->image('new.jpg', 800, 800),
            ],
            'media_meta' => [
                'existing' => [
                    [
                        'id' => $keptMedia->id,
                        'sort_order' => 1,
                        'is_primary' => false,
                        'alt_text' => ['de' => 'Behalten'],
                    ],
                ],
                'new' => [
                    [
                        'sort_order' => 0,
                        'is_primary' => true,
                        'alt_text' => ['de' => 'Neu'],
                    ],
                ],
                'removed' => [$removedMedia->id],
            ],
        ])
        ->assertRedirect('/dashboard/products');

    $product->refresh();

    expect($product->slug)->toBe('old');
    expect($product->brand)->toBe('Neu');
    expect($product->translate('de', 'name'))->toBe('Neu');
    expect($product->translate('de', 'meta_title'))->toBe('Neu');
    expect($product->translate('de', 'meta_description'))->toBe('Neue ausführliche Beschreibung');
    expect($product->categories()->pluck('categories.id')->sort()->values()->all())
        ->toBe(collect([$keepCategory->id, $newCategory->id])->sort()->values()->all());
    expect($product->attributeValues()->pluck('attribute_values.id')->all())->toBe([$newValue->id]);
    expect($product->variants)->toHaveCount(2);
    expect($oldVariant->refresh()->size_ml)->toBe(50);
    expect($product->variants()->where('is_default', true)->sole()->price)->toBe('95.00');
    expect(Media::find($removedMedia->id))->toBeNull();
    Storage::disk('public')->assertMissing($removedMedia->path);
    expect($keptMedia->refresh()->sort_order)->toBe(1);
    expect($product->media()->primary()->sole()->translate('de', 'alt_text'))->toBe('Neu');
});

test('admin can delete a product and clean up media translations variants and pivots', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $attributeValue = AttributeValue::factory()->create();
    $product = Product::factory()->create();
    $product->setTranslation('de', 'name', 'Delete me');
    $product->categories()->attach($category);
    $product->attributeValues()->attach($attributeValue);
    ProductVariant::factory()->for($product)->create(['is_default' => true]);
    $media = $product->media()->create([
        'path' => 'media/products/1/delete.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    $media->setTranslation('de', 'alt_text', 'Delete');
    Storage::disk('public')->put($media->path, 'delete');

    $this->actingAs($this->admin)
        ->delete("/dashboard/products/{$product->id}")
        ->assertRedirect('/dashboard/products');

    expect(Product::find($product->id))->toBeNull();
    expect(ProductVariant::query()->where('product_id', $product->id)->count())->toBe(0);
    expect(Translation::query()
        ->whereIn('translatable_type', [Product::class, Media::class])
        ->count(),
    )->toBe(0);
    Storage::disk('public')->assertMissing($media->path);
});
