<?php

use App\Models\PageSection;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\PageSectionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('non-admin users are redirected away from the page sections dashboard', function () {
    $regular = User::factory()->create();

    $this->actingAs($regular)
        ->get('/dashboard/page-sections')
        ->assertRedirect('/');
});

test('page section seeder creates the fixed sections idempotently', function () {
    $this->seed(PageSectionSeeder::class);
    $this->seed(PageSectionSeeder::class);

    expect(PageSection::query()->count())->toBe(4);
    expect(PageSection::query()->pluck('key')->all())->toEqualCanonicalizing([
        'hero',
        'about',
        'why_us',
        'featured_products',
    ]);
});

test('admin can list page sections with status badges data', function () {
    $this->seed(PageSectionSeeder::class);

    PageSection::query()->where('key', 'hero')->firstOrFail()
        ->setTranslation('de', 'title', 'Start Hero');

    $this->actingAs($this->admin)
        ->get('/dashboard/page-sections')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/page-sections/index')
            ->has('sections', 4)
            ->where('sections.0.key', 'hero')
            ->where('sections.0.title', 'Start Hero')
            ->where('sections.0.is_active', true),
        );
});

test('admin can update hero content and image', function () {
    Storage::fake('public');

    $section = PageSection::query()->create([
        'key' => 'hero',
        'type' => 'image',
        'payload' => [
            'image_path' => UploadedFile::fake()
                ->image('old.jpg')
                ->store('page-sections/hero', 'public'),
        ],
        'sort_order' => 0,
        'is_active' => true,
    ]);
    $oldPath = $section->payload['image_path'];

    $this->actingAs($this->admin)
        ->post("/dashboard/page-sections/{$section->id}", [
            '_method' => 'PUT',
            'hero_image' => UploadedFile::fake()->image('hero.jpg', 1600, 900),
            'sort_order' => 2,
            'is_active' => true,
            'translations' => [
                'de' => [
                    'title' => 'GOAN Parfums',
                    'body' => 'Ausgewählte Nischendüfte.',
                    'cta_text' => 'Jetzt entdecken',
                ],
                'ar' => ['title' => 'غوان'],
                'en' => ['title' => 'GOAN Perfumes'],
            ],
        ])
        ->assertRedirect('/dashboard/page-sections');

    $section->refresh();

    expect($section->sort_order)->toBe(2);
    expect($section->translate('de', 'title'))->toBe('GOAN Parfums');
    expect($section->translate('de', 'cta_text'))->toBe('Jetzt entdecken');
    expect($section->payload['image_path'])->not->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($section->payload['image_path']);
});

test('admin can update about title and body', function () {
    $section = PageSection::query()->create([
        'key' => 'about',
        'type' => 'text',
        'payload' => [],
        'sort_order' => 10,
        'is_active' => true,
    ]);

    $this->actingAs($this->admin)
        ->put("/dashboard/page-sections/{$section->id}", [
            'sort_order' => 11,
            'is_active' => false,
            'translations' => [
                'de' => [
                    'title' => 'Über GOAN',
                    'body' => 'Beratung, Duftauswahl und Service.',
                ],
                'ar' => [
                    'title' => 'عن غوان',
                    'body' => 'نص عربي',
                ],
                'en' => [
                    'title' => 'About GOAN',
                    'body' => 'English text.',
                ],
            ],
        ])
        ->assertRedirect('/dashboard/page-sections');

    $section->refresh();

    expect($section->is_active)->toBeFalse();
    expect($section->sort_order)->toBe(11);
    expect($section->translate('de', 'title'))->toBe('Über GOAN');
    expect($section->translate('en', 'body'))->toBe('English text.');
});

test('admin can update why us bullet points and read them back', function () {
    $section = PageSection::query()->create([
        'key' => 'why_us',
        'type' => 'text',
        'payload' => [],
        'sort_order' => 20,
        'is_active' => true,
    ]);

    $this->actingAs($this->admin)
        ->put("/dashboard/page-sections/{$section->id}", [
            'sort_order' => 20,
            'is_active' => true,
            'translations' => [
                'de' => [
                    'title' => 'Warum GOAN',
                    'bullet_points' => [
                        'Kuratiertes Sortiment',
                        'Persönliche Beratung',
                    ],
                ],
                'ar' => ['title' => '', 'bullet_points' => []],
                'en' => ['title' => '', 'bullet_points' => []],
            ],
        ])
        ->assertRedirect('/dashboard/page-sections');

    $this->actingAs($this->admin)
        ->get("/dashboard/page-sections/{$section->id}/edit")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/page-sections/edit')
            ->where('section.translations.de.title', 'Warum GOAN')
            ->where('section.translations.de.bullet_points.0', 'Kuratiertes Sortiment')
            ->where('section.translations.de.bullet_points.1', 'Persönliche Beratung'),
        );
});

test('admin can update featured product ids in order', function () {
    $products = Product::factory()->count(3)->create();
    $products->each(fn (Product $product, int $index) => $product
        ->setTranslation('de', 'name', "Produkt {$index}"));

    $section = PageSection::query()->create([
        'key' => 'featured_products',
        'type' => 'product_list',
        'payload' => ['product_ids' => []],
        'sort_order' => 30,
        'is_active' => true,
    ]);

    $this->actingAs($this->admin)
        ->put("/dashboard/page-sections/{$section->id}", [
            'sort_order' => 30,
            'is_active' => true,
            'payload' => [
                'product_ids' => [
                    $products[2]->id,
                    $products[0]->id,
                ],
            ],
            'translations' => [
                'de' => ['title' => 'Highlights'],
                'ar' => ['title' => ''],
                'en' => ['title' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/page-sections');

    expect($section->refresh()->payload['product_ids'])->toBe([
        $products[2]->id,
        $products[0]->id,
    ]);
});

test('featured products reject missing product ids', function () {
    $section = PageSection::query()->create([
        'key' => 'featured_products',
        'type' => 'product_list',
        'payload' => ['product_ids' => []],
        'sort_order' => 30,
        'is_active' => true,
    ]);

    $this->actingAs($this->admin)
        ->put("/dashboard/page-sections/{$section->id}", [
            'sort_order' => 30,
            'is_active' => true,
            'payload' => ['product_ids' => [999999]],
            'translations' => [
                'de' => ['title' => 'Highlights'],
                'ar' => ['title' => ''],
                'en' => ['title' => ''],
            ],
        ])
        ->assertSessionHasErrors('payload.product_ids.0');
});
