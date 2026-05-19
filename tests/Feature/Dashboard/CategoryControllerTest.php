<?php

use App\Models\Category;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('non-admin users are redirected away from the categories dashboard', function () {
    $regular = User::factory()->create();

    $this->actingAs($regular)
        ->get('/dashboard/categories')
        ->assertRedirect('/');
});

test('admin can list categories with their German names', function () {
    $category = Category::factory()->create(['slug' => 'damenparfums']);
    $category->setTranslation('de', 'name', 'Damenparfums');

    $this->actingAs($this->admin)
        ->get('/dashboard/categories')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/categories/index')
            ->has('categories', 1)
            ->where('categories.0.name', 'Damenparfums')
            ->where('categories.0.slug', 'damenparfums'),
        );
});

test('category show route is not registered', function () {
    $category = Category::factory()->create();

    $this->actingAs($this->admin)
        ->get("/dashboard/categories/{$category->id}")
        ->assertMethodNotAllowed();
});

test('admin can create a category with translations and a banner image', function () {
    Storage::fake('public');

    $banner = UploadedFile::fake()->image('banner.jpg', 800, 200);

    $response = $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'slug' => '',
            'parent_id' => null,
            'sort_order' => 5,
            'is_active' => true,
            'image' => $banner,
            'translations' => [
                'de' => ['name' => 'Maiglöckchen', 'description' => 'Frühlingshaft.'],
                'ar' => ['name' => 'زنبق الوادي'],
                'en' => ['name' => 'Lily of the valley'],
            ],
        ]);

    $response->assertRedirect('/dashboard/categories');

    $category = Category::query()->sole();

    expect($category->slug)->toBe('maigloeckchen');
    expect($category->sort_order)->toBe(5);
    expect($category->is_active)->toBeTrue();
    expect($category->translate('de', 'name'))->toBe('Maiglöckchen');
    expect($category->translate('ar', 'name'))->toBe('زنبق الوادي');
    expect($category->translate('en', 'name'))->toBe('Lily of the valley');
    expect($category->translate('de', 'description'))->toBe('Frühlingshaft.');
    expect($category->image_path)->not->toBeNull();
    Storage::disk('public')->assertExists($category->image_path);
});

test('store rejects a request without a German name', function () {
    $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'slug' => 'foo',
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => ''],
                'ar' => ['name' => 'X'],
                'en' => ['name' => 'X'],
            ],
        ])
        ->assertSessionHasErrors('translations.de.name');

    expect(Category::count())->toBe(0);
});

test('category slug is generated from the German name and deduped', function () {
    Category::factory()->create(['slug' => 'sommer']);

    $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'slug' => 'manual-slug-should-be-ignored',
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Sommer'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/categories');

    $category = Category::query()->where('slug', '!=', 'sommer')->sole();

    expect($category->slug)->toBe('sommer-2');
});

test('category SEO meta is derived from the name and description', function () {
    $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => [
                    'name' => 'Herrenparfums',
                    'description' => "  Markante  Düfte\nfür  ihn.  ",
                ],
                'ar' => ['name' => 'عطور رجالية'],
                'en' => ['name' => 'Men perfumes', 'description' => 'Bold scents.'],
            ],
        ])
        ->assertRedirect('/dashboard/categories');

    $category = Category::query()->sole();

    expect($category->translate('de', 'meta_title'))->toBe('Herrenparfums');
    expect($category->translate('de', 'meta_description'))->toBe('Markante Düfte für ihn.');
    expect($category->translate('en', 'meta_title'))->toBe('Men perfumes');
    expect($category->translate('en', 'meta_description'))->toBe('Bold scents.');
    expect($category->translate('ar', 'meta_title'))->toBe('عطور رجالية');
});

test('admin can update an existing category and replace its banner', function () {
    Storage::fake('public');

    $category = Category::factory()->create(['slug' => 'old-slug']);
    $category->setTranslation('de', 'name', 'Alt');
    $category->image_path = UploadedFile::fake()
        ->image('old.jpg')
        ->store('categories/banners', 'public');
    $category->save();
    $oldPath = $category->image_path;

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$category->id}", [
            'slug' => 'neu',
            'parent_id' => null,
            'sort_order' => 9,
            'is_active' => false,
            'image' => UploadedFile::fake()->image('new.jpg', 800, 200),
            'translations' => [
                'de' => ['name' => 'Neu'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/categories');

    $category->refresh();

    expect($category->slug)->toBe('neu');
    expect($category->is_active)->toBeFalse();
    expect($category->sort_order)->toBe(9);
    expect($category->translate('de', 'name'))->toBe('Neu');
    expect($category->image_path)->not->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($category->image_path);
});

test('clearing a translation removes its row', function () {
    $category = Category::factory()->create(['slug' => 'kat']);
    $category->setTranslation('de', 'name', 'Kategorie');
    $category->setTranslation('en', 'name', 'Category');

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$category->id}", [
            'slug' => 'kat',
            'parent_id' => null,
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Kategorie'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect();

    expect($category->refresh()->translate('en', 'name'))->toBeNull();
    expect($category->translate('de', 'name'))->toBe('Kategorie');
});

test('admin can delete a category and its translations + banner are cleaned up', function () {
    Storage::fake('public');

    $category = Category::factory()->create(['slug' => 'goes-away']);
    $category->setTranslation('de', 'name', 'Vergänglich');
    $category->image_path = UploadedFile::fake()
        ->image('x.jpg')
        ->store('categories/banners', 'public');
    $category->save();
    $path = $category->image_path;

    $this->actingAs($this->admin)
        ->delete("/dashboard/categories/{$category->id}")
        ->assertRedirect('/dashboard/categories');

    expect(Category::find($category->id))->toBeNull();
    expect(Translation::query()
        ->where('translatable_type', Category::class)
        ->where('translatable_id', $category->id)
        ->count(),
    )->toBe(0);
    Storage::disk('public')->assertMissing($path);
});

test('parent select on edit excludes the current category and its descendants', function () {
    $root = Category::factory()->create(['slug' => 'root']);
    $root->setTranslation('de', 'name', 'Root');

    $child = Category::factory()->create(['slug' => 'child', 'parent_id' => $root->id]);
    $child->setTranslation('de', 'name', 'Kind');

    $grandchild = Category::factory()->create(['slug' => 'grand', 'parent_id' => $child->id]);
    $grandchild->setTranslation('de', 'name', 'Enkel');

    $this->actingAs($this->admin)
        ->get("/dashboard/categories/{$root->id}/edit")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/categories/edit')
            ->where('parents', function ($parents) use ($root, $child, $grandchild) {
                $ids = collect($parents)->pluck('id')->all();

                return ! in_array($root->id, $ids, true)
                    && ! in_array($child->id, $ids, true)
                    && ! in_array($grandchild->id, $ids, true);
            }),
        );
});

test('update rejects parent values that would create a category cycle', function () {
    $root = Category::factory()->create(['slug' => 'root']);
    $root->setTranslation('de', 'name', 'Root');

    $child = Category::factory()->create(['slug' => 'child', 'parent_id' => $root->id]);
    $child->setTranslation('de', 'name', 'Kind');

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$root->id}", [
            'slug' => 'root',
            'parent_id' => $child->id,
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Root'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertSessionHasErrors('parent_id');

    expect($root->refresh()->parent_id)->toBeNull();
});
