<?php

use App\Models\Promotion;
use App\Models\Translation;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('non-admin users are redirected away from the promotions dashboard', function () {
    $regular = User::factory()->create();

    $this->actingAs($regular)
        ->get('/dashboard/promotions')
        ->assertRedirect('/');
});

test('admin can list promotions with German title and status', function () {
    $active = Promotion::factory()->create([
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
    ]);
    $active->setTranslation('de', 'title', 'Aktive Aktion');

    $upcoming = Promotion::factory()->upcoming()->create([
        'sort_order' => 1,
    ]);
    $upcoming->setTranslation('de', 'title', 'Geplant');

    $this->actingAs($this->admin)
        ->get('/dashboard/promotions')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/promotions/index')
            ->has('promotions', 2)
            ->where('promotions.0.title', 'Aktive Aktion')
            ->where('promotions.0.status', 'active')
            ->where('promotions.1.status', 'upcoming'),
        );
});

test('admin can create a text-only promotion with translations', function () {
    $this->actingAs($this->admin)
        ->post('/dashboard/promotions', [
            'starts_at' => now()->subHour()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'sort_order' => 3,
            'is_active' => true,
            'translations' => [
                'de' => [
                    'badge' => 'Nur heute',
                    'title' => 'Nischenaktion',
                    'subtitle' => 'Entdecke ausgewählte Düfte.',
                    'cta_text' => 'Jetzt ansehen',
                ],
                'ar' => ['title' => 'عرض العطور النادرة'],
                'en' => ['title' => 'Niche offer'],
            ],
        ])
        ->assertRedirect('/dashboard/promotions');

    $promotion = Promotion::query()->sole();

    expect($promotion->sort_order)->toBe(3);
    expect($promotion->translate('de', 'title'))->toBe('Nischenaktion');
    expect($promotion->translate('ar', 'title'))->toBe('عرض العطور النادرة');
    expect(Promotion::active()->pluck('id'))->toContain($promotion->id);
});

test('store rejects missing German title and invalid date range', function () {
    $this->actingAs($this->admin)
        ->post('/dashboard/promotions', [
            'starts_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'ends_at' => now()->subDay()->format('Y-m-d H:i:s'),
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['title' => ''],
                'ar' => ['title' => 'X'],
                'en' => ['title' => 'X'],
            ],
        ])
        ->assertSessionHasErrors([
            'translations.de.title',
            'ends_at',
        ]);

    expect(Promotion::count())->toBe(0);
});

test('admin can update a text-only promotion', function () {
    $promotion = Promotion::factory()->create();
    $promotion->setTranslation('de', 'title', 'Alt');
    $promotion->setTranslation('en', 'title', 'Old');

    $this->actingAs($this->admin)
        ->post("/dashboard/promotions/{$promotion->id}", [
            '_method' => 'PUT',
            'starts_at' => '',
            'ends_at' => '',
            'sort_order' => 8,
            'is_active' => false,
            'translations' => [
                'de' => [
                    'badge' => '',
                    'title' => 'Neu',
                    'subtitle' => 'Neue Beschreibung',
                    'cta_text' => '',
                ],
                'ar' => ['title' => ''],
                'en' => ['title' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/promotions');

    $promotion->refresh();

    expect($promotion->is_active)->toBeFalse();
    expect($promotion->sort_order)->toBe(8);
    expect($promotion->translate('de', 'title'))->toBe('Neu');
    expect($promotion->translate('en', 'title'))->toBeNull();
});

test('admin can delete a promotion and clean up translations', function () {
    $promotion = Promotion::factory()->create();
    $promotion->setTranslation('de', 'title', 'Delete');

    $this->actingAs($this->admin)
        ->delete("/dashboard/promotions/{$promotion->id}")
        ->assertRedirect('/dashboard/promotions');

    expect(Promotion::find($promotion->id))->toBeNull();
    expect(Translation::query()
        ->where('translatable_type', Promotion::class)
        ->where('translatable_id', $promotion->id)
        ->count(),
    )->toBe(0);
});
