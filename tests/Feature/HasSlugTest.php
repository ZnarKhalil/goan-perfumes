<?php

use App\Models\Category;

test('saving with an explicit slug keeps the explicit value', function () {
    $category = new Category(['slug' => 'manual-slug', 'sort_order' => 0, 'is_active' => true]);
    $category->setSlugSource('Damenparfums');
    $category->save();

    expect($category->slug)->toBe('manual-slug');
});

test('empty slug with a source generates the German slug', function () {
    $category = new Category(['sort_order' => 0, 'is_active' => true]);
    $category->setSlugSource('Damenparfums');
    $category->save();

    expect($category->slug)->toBe('damenparfums');
});

test('umlauts are transliterated for German slugs', function () {
    $category = new Category(['sort_order' => 0, 'is_active' => true]);
    $category->setSlugSource('Maiglöckchen für Männer');
    $category->save();

    expect($category->slug)->toBe('maigloeckchen-fuer-maenner');
});

test('collisions append numeric suffixes', function () {
    $a = new Category(['sort_order' => 0, 'is_active' => true]);
    $a->setSlugSource('Damenparfums')->save();

    $b = new Category(['sort_order' => 0, 'is_active' => true]);
    $b->setSlugSource('Damenparfums')->save();

    $c = new Category(['sort_order' => 0, 'is_active' => true]);
    $c->setSlugSource('Damenparfums')->save();

    expect([$a->slug, $b->slug, $c->slug])->toBe([
        'damenparfums',
        'damenparfums-2',
        'damenparfums-3',
    ]);
});

test('updating a row with the same source as itself does not append a suffix', function () {
    $category = new Category(['sort_order' => 0, 'is_active' => true]);
    $category->setSlugSource('Herrenparfums')->save();

    expect($category->slug)->toBe('herrenparfums');

    // Force a re-save with the same source (e.g. an admin re-submits the form).
    $category->slug = null;
    $category->setSlugSource('Herrenparfums')->save();

    expect($category->fresh()->slug)->toBe('herrenparfums');
});
