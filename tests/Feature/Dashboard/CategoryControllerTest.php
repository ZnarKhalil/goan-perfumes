<?php

use App\Models\Category;
use App\Models\Media;
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

test('admin can create a category with translations', function () {
    $response = $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'slug' => '',
            'parent_id' => null,
            'sort_order' => 5,
            'is_active' => true,
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
});

test('admin can create a category with an image', function () {
    Storage::fake('public');

    $response = $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'sort_order' => 5,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Maiglöckchen', 'description' => 'Frühlingshaft.'],
                'ar' => ['name' => 'زنبق الوادي'],
                'en' => ['name' => 'Lily of the valley'],
            ],
            'media_uploads' => [
                UploadedFile::fake()->image('category.jpg', 1200, 900),
            ],
            'media_meta' => [
                'new' => [
                    [
                        'sort_order' => 0,
                        'is_primary' => true,
                    ],
                ],
            ],
        ]);

    $response->assertRedirect('/dashboard/categories');

    $category = Category::query()->sole();
    $media = $category->media()->sole();

    expect($media->is_primary)->toBeTrue();
    expect($media->sort_order)->toBe(0);
    expect($media->path)->toStartWith("media/categories/{$category->id}/")
        ->toEndWith('.webp');
    expect($media->translate('de', 'alt_text'))->toBe('Kategorie Maiglöckchen');
    expect($media->translate('en', 'alt_text'))->toBe('Lily of the valley perfume category');

    Storage::disk('public')->assertExists($media->path);
});

test('store rejects a sort order already used by another category', function () {
    Category::factory()->create(['slug' => 'existing', 'sort_order' => 3]);

    $this->actingAs($this->admin)
        ->post('/dashboard/categories', [
            'sort_order' => 3,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Neu'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertSessionHasErrors('sort_order');

    expect(Category::count())->toBe(1);
});

test('a category can be updated while keeping its own sort order', function () {
    $category = Category::factory()->create(['slug' => 'kat', 'sort_order' => 4]);
    $category->setTranslation('de', 'name', 'Kategorie');

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$category->id}", [
            'parent_id' => 'none',
            'sort_order' => 4,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Kategorie neu'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/categories')
        ->assertSessionHasNoErrors();

    expect($category->refresh()->sort_order)->toBe(4);
    expect($category->translate('de', 'name'))->toBe('Kategorie neu');
});

test('create page suggests the next free sort order', function () {
    Category::factory()->create(['slug' => 'a', 'sort_order' => 0]);
    Category::factory()->create(['slug' => 'b', 'sort_order' => 5]);

    $this->actingAs($this->admin)
        ->get('/dashboard/categories/create')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/categories/create')
            ->where('next_sort_order', 6),
        );
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
    Category::factory()->create(['slug' => 'sommer', 'sort_order' => 1]);

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

test('admin can update an existing category', function () {
    $category = Category::factory()->create(['slug' => 'old-slug']);
    $category->setTranslation('de', 'name', 'Alt');

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$category->id}", [
            'slug' => 'neu',
            'parent_id' => null,
            'sort_order' => 9,
            'is_active' => false,
            'translations' => [
                'de' => ['name' => 'Neu'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/categories');

    $category->refresh();

    expect($category->slug)->toBe('old-slug');
    expect($category->is_active)->toBeFalse();
    expect($category->sort_order)->toBe(9);
    expect($category->translate('de', 'name'))->toBe('Neu');
});

test('edit exposes existing category media', function () {
    $category = Category::factory()->create(['slug' => 'kat']);
    $category->setTranslation('de', 'name', 'Kategorie');
    $media = $category->media()->create([
        'path' => 'media/categories/1/cover.webp',
        'sort_order' => 0,
        'is_primary' => true,
    ]);

    $this->actingAs($this->admin)
        ->get("/dashboard/categories/{$category->id}/edit")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/categories/edit')
            ->where('category.media.0.id', $media->id)
            ->where('category.media.0.is_primary', true),
        );
});

test('admin can replace a category image', function () {
    Storage::fake('public');

    $category = Category::factory()->create(['slug' => 'kat']);
    $category->setTranslation('de', 'name', 'Kategorie');
    $oldMedia = $category->media()->create([
        'path' => 'media/categories/1/old.webp',
        'sort_order' => 0,
        'is_primary' => true,
    ]);
    Storage::disk('public')->put($oldMedia->path, 'old');

    $this->actingAs($this->admin)
        ->post("/dashboard/categories/{$category->id}", [
            '_method' => 'PUT',
            'parent_id' => null,
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Kategorie neu'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'media_uploads' => [
                UploadedFile::fake()->image('new.jpg', 1200, 900),
            ],
            'media_meta' => [
                'new' => [
                    [
                        'sort_order' => 0,
                        'is_primary' => true,
                    ],
                ],
                'removed' => [$oldMedia->id],
            ],
        ])
        ->assertRedirect('/dashboard/categories')
        ->assertSessionHasNoErrors();

    expect(Media::find($oldMedia->id))->toBeNull();
    expect($category->refresh()->media)->toHaveCount(1);
    expect($category->media()->primary()->sole()->translate('de', 'alt_text'))->toBe('Kategorie Kategorie neu');

    Storage::disk('public')->assertMissing($oldMedia->path);
    Storage::disk('public')->assertExists($category->media()->primary()->sole()->path);
});

test('update rejects media rows owned by another category', function () {
    $category = Category::factory()->create(['slug' => 'kat']);
    $category->setTranslation('de', 'name', 'Kategorie');
    $otherCategory = Category::factory()->create(['slug' => 'other', 'sort_order' => 1]);
    $otherMedia = $otherCategory->media()->create([
        'path' => 'media/categories/2/other.webp',
        'sort_order' => 0,
        'is_primary' => true,
    ]);

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$category->id}", [
            'parent_id' => null,
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Kategorie'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
            'media_meta' => [
                'existing' => [
                    [
                        'id' => $otherMedia->id,
                        'sort_order' => 0,
                        'is_primary' => true,
                    ],
                ],
            ],
        ])
        ->assertSessionHasErrors('media_meta');
});

test('update accepts the "none" parent sentinel sent by the form', function () {
    $root = Category::factory()->create(['slug' => 'root', 'parent_id' => null, 'sort_order' => 0]);
    $category = Category::factory()->create(['slug' => 'kind', 'parent_id' => $root->id, 'sort_order' => 1]);
    $category->setTranslation('de', 'name', 'Kind');

    $this->actingAs($this->admin)
        ->put("/dashboard/categories/{$category->id}", [
            'parent_id' => 'none',
            'sort_order' => 1,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Kind'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/categories')
        ->assertSessionHasNoErrors();

    expect($category->refresh()->parent_id)->toBeNull();
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

test('admin can delete a category and its translations are cleaned up', function () {
    $category = Category::factory()->create(['slug' => 'goes-away']);
    $category->setTranslation('de', 'name', 'Vergänglich');

    $this->actingAs($this->admin)
        ->delete("/dashboard/categories/{$category->id}")
        ->assertRedirect('/dashboard/categories');

    expect(Category::find($category->id))->toBeNull();
    expect(Translation::query()
        ->where('translatable_type', Category::class)
        ->where('translatable_id', $category->id)
        ->count(),
    )->toBe(0);
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
    $root = Category::factory()->create(['slug' => 'root', 'sort_order' => 0]);
    $root->setTranslation('de', 'name', 'Root');

    $child = Category::factory()->create(['slug' => 'child', 'parent_id' => $root->id, 'sort_order' => 1]);
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
