<?php

use App\Models\Category;

test('setTranslation writes a row that translate can read back', function () {
    $category = Category::factory()->create();

    $category->setTranslation('de', 'name', 'Damenparfums');

    expect($category->fresh()->translate('de', 'name'))->toBe('Damenparfums');
});

test('translate falls back to another locale when the requested one is missing', function () {
    $category = Category::factory()->create();
    $category->setTranslation('de', 'name', 'Damenparfums');

    expect($category->translate('en', 'name', fallbackLocale: 'de'))->toBe('Damenparfums');
});

test('translate returns null when neither locale has a value', function () {
    $category = Category::factory()->create();

    expect($category->translate('en', 'name', fallbackLocale: 'de'))->toBeNull();
});

test('translate prefers the eager-loaded relation over a fresh query', function () {
    $category = Category::factory()->create();
    $category->setTranslation('de', 'name', 'Damenparfums');

    $loaded = Category::with('translations')->find($category->id);

    expect($loaded->translate('de', 'name'))->toBe('Damenparfums');
    expect($loaded->relationLoaded('translations'))->toBeTrue();
});

test('setTranslation refreshes the loaded relation when present', function () {
    $category = Category::factory()->create();
    $category->load('translations');

    expect($category->translations)->toHaveCount(0);

    $category->setTranslation('de', 'name', 'Damenparfums');

    expect($category->translations)->toHaveCount(1);
    expect($category->translate('de', 'name'))->toBe('Damenparfums');
});
