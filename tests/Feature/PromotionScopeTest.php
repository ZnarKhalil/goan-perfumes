<?php

use App\Models\Promotion;

test('active scope returns only currently-active promotions', function () {
    $alwaysOn = Promotion::factory()->create(['slug' => 'always-on']);
    $withinWindow = Promotion::factory()->create([
        'slug' => 'within-window',
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
    ]);

    Promotion::factory()->upcoming()->create(['slug' => 'upcoming']);
    Promotion::factory()->expired()->create(['slug' => 'expired']);
    Promotion::factory()->disabled()->create(['slug' => 'disabled']);

    $activeIds = Promotion::active()->pluck('id')->all();

    expect($activeIds)->toHaveCount(2);
    expect($activeIds)->toContain($alwaysOn->id);
    expect($activeIds)->toContain($withinWindow->id);
});

test('a promotion that just started is active', function () {
    $promo = Promotion::factory()->create([
        'starts_at' => now()->subSecond(),
        'ends_at' => now()->addHour(),
    ]);

    expect(Promotion::active()->pluck('id'))->toContain($promo->id);
});

test('a promotion that just ended is not active', function () {
    $promo = Promotion::factory()->create([
        'starts_at' => now()->subHour(),
        'ends_at' => now()->subSecond(),
    ]);

    expect(Promotion::active()->pluck('id'))->not->toContain($promo->id);
});

test('the manual is_active flag overrides the time window', function () {
    $promo = Promotion::factory()->disabled()->create([
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
    ]);

    expect(Promotion::active()->pluck('id'))->not->toContain($promo->id);
});
