<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Translation;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('non-admin users are redirected away from the attributes dashboard', function () {
    $regular = User::factory()->create();

    $this->actingAs($regular)
        ->get('/dashboard/attributes')
        ->assertRedirect('/');
});

test('admin can list attributes with German names and value counts', function () {
    $attribute = Attribute::factory()->create(['code' => 'familie']);
    $attribute->setTranslation('de', 'name', 'Familie');
    AttributeValue::factory()->for($attribute)->create();
    AttributeValue::factory()->for($attribute)->create();

    $this->actingAs($this->admin)
        ->get('/dashboard/attributes')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/attributes/index')
            ->has('attributes', 1)
            ->where('attributes.0.name', 'Familie')
            ->where('attributes.0.code', 'familie')
            ->where('attributes.0.values_count', 2),
        );
});

test('admin can create an attribute with translations', function () {
    $this->actingAs($this->admin)
        ->post('/dashboard/attributes', [
            'code' => 'duftfamilie',
            'sort_order' => 3,
            'is_filterable' => true,
            'is_multiple' => true,
            'translations' => [
                'de' => ['name' => 'Duftfamilie'],
                'ar' => ['name' => 'العائلة'],
                'en' => ['name' => 'Family'],
            ],
        ])
        ->assertRedirect('/dashboard/attributes');

    $attribute = Attribute::query()->sole();

    expect($attribute->code)->toBe('duftfamilie');
    expect($attribute->sort_order)->toBe(3);
    expect($attribute->is_filterable)->toBeTrue();
    expect($attribute->is_multiple)->toBeTrue();
    expect($attribute->translate('de', 'name'))->toBe('Duftfamilie');
    expect($attribute->translate('ar', 'name'))->toBe('العائلة');
    expect($attribute->translate('en', 'name'))->toBe('Family');
});

test('store rejects duplicate attribute code and missing German name', function () {
    Attribute::factory()->create(['code' => 'familie', 'sort_order' => 5]);

    $this->actingAs($this->admin)
        ->post('/dashboard/attributes', [
            'code' => 'familie',
            'sort_order' => 0,
            'is_filterable' => true,
            'is_multiple' => true,
            'translations' => [
                'de' => ['name' => ''],
                'ar' => ['name' => 'X'],
                'en' => ['name' => 'X'],
            ],
        ])
        ->assertSessionHasErrors(['code', 'translations.de.name']);
});

test('store rejects an attribute sort order already used by another attribute', function () {
    Attribute::factory()->create(['code' => 'familie', 'sort_order' => 2]);

    $this->actingAs($this->admin)
        ->post('/dashboard/attributes', [
            'code' => 'noten',
            'sort_order' => 2,
            'is_filterable' => true,
            'is_multiple' => true,
            'translations' => [
                'de' => ['name' => 'Noten'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertSessionHasErrors('sort_order');

    expect(Attribute::count())->toBe(1);
});

test('an attribute keeps its own sort order on update while another attribute exists', function () {
    Attribute::factory()->create(['code' => 'familie', 'sort_order' => 0]);
    $noten = Attribute::factory()->create(['code' => 'noten', 'sort_order' => 1]);
    $noten->setTranslation('de', 'name', 'Noten');

    $this->actingAs($this->admin)
        ->put("/dashboard/attributes/{$noten->id}", [
            'code' => 'noten',
            'sort_order' => 1,
            'is_filterable' => true,
            'is_multiple' => true,
            'translations' => [
                'de' => ['name' => 'Duftnoten'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect("/dashboard/attributes/{$noten->id}/edit")
        ->assertSessionHasNoErrors();

    expect($noten->refresh()->sort_order)->toBe(1);
});

test('create attribute page suggests the next free sort order', function () {
    Attribute::factory()->create(['code' => 'familie', 'sort_order' => 0]);
    Attribute::factory()->create(['code' => 'noten', 'sort_order' => 4]);

    $this->actingAs($this->admin)
        ->get('/dashboard/attributes/create')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/attributes/create')
            ->where('next_sort_order', 5),
        );
});

test('attribute value sort order is unique within an attribute but allowed across attributes', function () {
    $familie = Attribute::factory()->create(['code' => 'familie']);
    $noten = Attribute::factory()->create(['code' => 'noten']);
    AttributeValue::factory()->for($familie)->create(['slug' => 'blumig', 'sort_order' => 0]);

    // Same attribute, same sort order -> rejected.
    $this->actingAs($this->admin)
        ->post("/dashboard/attributes/{$familie->id}/values", [
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Holzig'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertSessionHasErrors('sort_order');

    // Different attribute, same sort order -> allowed.
    $this->actingAs($this->admin)
        ->post("/dashboard/attributes/{$noten->id}/values", [
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Oud'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect("/dashboard/attributes/{$noten->id}/edit")
        ->assertSessionHasNoErrors();

    expect(AttributeValue::query()->where('attribute_id', $noten->id)->count())->toBe(1);
});

test('admin can edit an attribute with its values', function () {
    $attribute = Attribute::factory()->create(['code' => 'noten']);
    $attribute->setTranslation('de', 'name', 'Noten');

    $value = AttributeValue::factory()->for($attribute)->create(['slug' => 'rose']);
    $value->setTranslation('de', 'name', 'Rose');

    $this->actingAs($this->admin)
        ->get("/dashboard/attributes/{$attribute->id}/edit")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/attributes/edit')
            ->where('attribute.name', 'Noten')
            ->where('attribute.values.0.name', 'Rose')
            ->where('attribute.values.0.slug', 'rose')
            ->where('attribute.value_search', '')
            ->where('attribute.values_pagination.total', 1)
            ->where('attribute.values_pagination.per_page', 10),
        );
});

test('the attribute values table is paginated', function () {
    $attribute = Attribute::factory()->create();

    AttributeValue::factory()->for($attribute)->count(11)->create();

    $this->actingAs($this->admin)
        ->get("/dashboard/attributes/{$attribute->id}/edit")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('attribute.values', 10)
            ->where('attribute.values_pagination.total', 11)
            ->where('attribute.values_pagination.last_page', 2),
        );

    $this->actingAs($this->admin)
        ->get("/dashboard/attributes/{$attribute->id}/edit?page=2")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('attribute.values', 1)
            ->where('attribute.values_pagination.current_page', 2),
        );
});

test('the attribute values table can be searched by name', function () {
    $attribute = Attribute::factory()->create();

    $rose = AttributeValue::factory()->for($attribute)->create(['slug' => 'rose']);
    $rose->setTranslation('de', 'name', 'Rose');
    $oud = AttributeValue::factory()->for($attribute)->create(['slug' => 'oud']);
    $oud->setTranslation('de', 'name', 'Oud');

    $this->actingAs($this->admin)
        ->get("/dashboard/attributes/{$attribute->id}/edit?value_search=ros")
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('attribute.values', 1)
            ->where('attribute.values.0.name', 'Rose')
            ->where('attribute.value_search', 'ros'),
        );
});

test('admin can update an attribute and clear optional translations', function () {
    $attribute = Attribute::factory()->create(['code' => 'mood']);
    $attribute->setTranslation('de', 'name', 'Mood');
    $attribute->setTranslation('en', 'name', 'Mood');

    $this->actingAs($this->admin)
        ->put("/dashboard/attributes/{$attribute->id}", [
            'code' => 'stimmung',
            'sort_order' => 8,
            'is_filterable' => false,
            'is_multiple' => true,
            'translations' => [
                'de' => ['name' => 'Stimmung'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect("/dashboard/attributes/{$attribute->id}/edit");

    $attribute->refresh();

    expect($attribute->code)->toBe('stimmung');
    expect($attribute->sort_order)->toBe(8);
    expect($attribute->is_filterable)->toBeFalse();
    expect($attribute->translate('de', 'name'))->toBe('Stimmung');
    expect($attribute->translate('en', 'name'))->toBeNull();
});

test('value slugs are generated from the German name and deduped per attribute', function () {
    $familie = Attribute::factory()->create(['code' => 'familie']);
    $noten = Attribute::factory()->create(['code' => 'noten']);
    AttributeValue::factory()->for($noten)->create(['slug' => 'rose']);

    $this->actingAs($this->admin)
        ->post("/dashboard/attributes/{$familie->id}/values", [
            'sort_order' => 4,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Rose'],
                'ar' => ['name' => ''],
                'en' => ['name' => 'Rose'],
            ],
        ])
        ->assertRedirect("/dashboard/attributes/{$familie->id}/edit");

    $value = AttributeValue::query()
        ->where('attribute_id', $familie->id)
        ->sole();

    expect($value->slug)->toBe('rose');
    expect($value->sort_order)->toBe(4);
    expect($value->translate('de', 'name'))->toBe('Rose');

    // A second value with the same German name is auto-deduped within the
    // attribute (a manual slug is never accepted).
    $this->actingAs($this->admin)
        ->post("/dashboard/attributes/{$familie->id}/values", [
            'slug' => 'rose',
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Rose'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertRedirect("/dashboard/attributes/{$familie->id}/edit");

    expect(AttributeValue::query()
        ->where('attribute_id', $familie->id)
        ->orderBy('id')
        ->pluck('slug')
        ->all(),
    )->toBe(['rose', 'rose-2']);
});

test('generated value slugs are scoped to their attribute', function () {
    $familie = Attribute::factory()->create(['code' => 'familie']);
    $noten = Attribute::factory()->create(['code' => 'noten']);

    foreach ([$familie, $noten] as $attribute) {
        $this->actingAs($this->admin)
            ->post("/dashboard/attributes/{$attribute->id}/values", [
                'slug' => '',
                'sort_order' => 0,
                'is_active' => true,
                'translations' => [
                    'de' => ['name' => 'Rose'],
                    'ar' => ['name' => ''],
                    'en' => ['name' => ''],
                ],
            ])
            ->assertRedirect("/dashboard/attributes/{$attribute->id}/edit");
    }

    expect(AttributeValue::query()
        ->whereIn('attribute_id', [$familie->id, $noten->id])
        ->pluck('slug')
        ->all(),
    )->toBe(['rose', 'rose']);
});

test('admin can update an attribute value and nested ownership is enforced', function () {
    $familie = Attribute::factory()->create(['code' => 'familie']);
    $noten = Attribute::factory()->create(['code' => 'noten']);
    $value = AttributeValue::factory()->for($familie)->create(['slug' => 'blumig']);
    $value->setTranslation('de', 'name', 'Blumig');

    $this->actingAs($this->admin)
        ->put("/dashboard/attributes/{$familie->id}/values/{$value->id}", [
            'slug' => 'floral',
            'sort_order' => 7,
            'is_active' => false,
            'translations' => [
                'de' => ['name' => 'Floral'],
                'ar' => ['name' => ''],
                'en' => ['name' => 'Floral'],
            ],
        ])
        ->assertRedirect("/dashboard/attributes/{$familie->id}/edit");

    $value->refresh();

    expect($value->slug)->toBe('floral');
    expect($value->sort_order)->toBe(7);
    expect($value->is_active)->toBeFalse();
    expect($value->translate('de', 'name'))->toBe('Floral');

    $this->actingAs($this->admin)
        ->put("/dashboard/attributes/{$noten->id}/values/{$value->id}", [
            'slug' => 'bad-parent',
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['name' => 'Wrong'],
                'ar' => ['name' => ''],
                'en' => ['name' => ''],
            ],
        ])
        ->assertNotFound();
});

test('admin can delete an attribute value and its translations', function () {
    $attribute = Attribute::factory()->create(['code' => 'noten']);
    $value = AttributeValue::factory()->for($attribute)->create(['slug' => 'oud']);
    $value->setTranslation('de', 'name', 'Oud');

    $this->actingAs($this->admin)
        ->delete("/dashboard/attributes/{$attribute->id}/values/{$value->id}")
        ->assertRedirect("/dashboard/attributes/{$attribute->id}/edit");

    expect(AttributeValue::find($value->id))->toBeNull();
    expect(Translation::query()
        ->where('translatable_type', AttributeValue::class)
        ->where('translatable_id', $value->id)
        ->count(),
    )->toBe(0);
});

test('admin can delete an attribute and clean up value translations', function () {
    $attribute = Attribute::factory()->create(['code' => 'noten']);
    $attribute->setTranslation('de', 'name', 'Noten');

    $value = AttributeValue::factory()->for($attribute)->create(['slug' => 'oud']);
    $value->setTranslation('de', 'name', 'Oud');

    $this->actingAs($this->admin)
        ->delete("/dashboard/attributes/{$attribute->id}")
        ->assertRedirect('/dashboard/attributes');

    expect(Attribute::find($attribute->id))->toBeNull();
    expect(AttributeValue::find($value->id))->toBeNull();
    expect(Translation::query()
        ->whereIn('translatable_type', [Attribute::class, AttributeValue::class])
        ->count(),
    )->toBe(0);
});
