<?php

use App\Models\Attribute;
use Database\Seeders\AttributeSeeder;

test('the art attribute is seeded as multi-select so products can have several types', function () {
    $this->seed(AttributeSeeder::class);

    expect(Attribute::query()->where('code', 'art')->value('is_multiple'))->toBeTrue();
});

test('every seeded attribute allows multiple values', function () {
    $this->seed(AttributeSeeder::class);

    $singleSelect = Attribute::query()->where('is_multiple', false)->pluck('code');

    expect($singleSelect)->toBeEmpty();
});
