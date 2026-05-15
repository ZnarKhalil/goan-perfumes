<?php

use App\Models\Promotion;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    Storage::fake('public');

    $active = Promotion::factory()->create([
        'slug' => 'active-promo',
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
        'discount_percent' => 15,
        'background_image_path' => 'promotions/backgrounds/active.jpg',
    ]);
    $active->setTranslation('de', 'title', 'Aktive Aktion');
    Storage::disk('public')->put($active->background_image_path, 'fake');

    $upcoming = Promotion::factory()->upcoming()->create([
        'slug' => 'upcoming-promo',
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
            ->where('promotions.0.discount_percent', 15)
            ->where('promotions.1.status', 'upcoming'),
        );
});

test('admin can create a promotion with translations and background image', function () {
    Storage::fake('public');

    $this->actingAs($this->admin)
        ->post('/dashboard/promotions', [
            'slug' => '',
            'background_image' => UploadedFile::fake()->image('hero.jpg', 1600, 900),
            'background_color' => '#1a1530',
            'link_url' => '/nischenparfums',
            'promo_code' => 'NISCHE10',
            'discount_percent' => 10,
            'starts_at' => now()->subHour()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'sort_order' => 3,
            'is_active' => true,
            'translations' => [
                'de' => [
                    'badge' => 'Nur heute',
                    'title' => 'Nischenaktion',
                    'subtitle' => 'Spare auf ausgewählte Düfte.',
                    'cta_text' => 'Jetzt ansehen',
                ],
                'ar' => ['title' => 'عرض العطور النادرة'],
                'en' => ['title' => 'Niche offer'],
            ],
        ])
        ->assertRedirect('/dashboard/promotions');

    $promotion = Promotion::query()->sole();

    expect($promotion->slug)->toBe('nischenaktion');
    expect($promotion->background_color)->toBe('#1a1530');
    expect($promotion->link_url)->toBe('/nischenparfums');
    expect($promotion->promo_code)->toBe('NISCHE10');
    expect($promotion->discount_percent)->toBe(10);
    expect($promotion->sort_order)->toBe(3);
    expect($promotion->translate('de', 'title'))->toBe('Nischenaktion');
    expect($promotion->translate('ar', 'title'))->toBe('عرض العطور النادرة');
    expect(Promotion::active()->pluck('id'))->toContain($promotion->id);
    Storage::disk('public')->assertExists($promotion->background_image_path);
});

test('store rejects missing German title and invalid date range', function () {
    $this->actingAs($this->admin)
        ->post('/dashboard/promotions', [
            'slug' => 'bad',
            'discount_percent' => 120,
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
            'discount_percent',
            'ends_at',
        ]);

    expect(Promotion::count())->toBe(0);
});

test('admin can update a promotion and replace its background image', function () {
    Storage::fake('public');

    $promotion = Promotion::factory()->create([
        'slug' => 'old',
        'background_image_path' => UploadedFile::fake()
            ->image('old.jpg')
            ->store('promotions/backgrounds', 'public'),
    ]);
    $promotion->setTranslation('de', 'title', 'Alt');
    $promotion->setTranslation('en', 'title', 'Old');
    $oldPath = $promotion->background_image_path;

    $this->actingAs($this->admin)
        ->post("/dashboard/promotions/{$promotion->id}", [
            '_method' => 'PUT',
            'slug' => 'neu',
            'background_image' => UploadedFile::fake()->image('new.jpg', 1600, 900),
            'background_color' => '#ffffff',
            'link_url' => '/kontakt',
            'promo_code' => '',
            'discount_percent' => '',
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

    expect($promotion->slug)->toBe('neu');
    expect($promotion->background_color)->toBe('#ffffff');
    expect($promotion->link_url)->toBe('/kontakt');
    expect($promotion->promo_code)->toBeNull();
    expect($promotion->discount_percent)->toBeNull();
    expect($promotion->is_active)->toBeFalse();
    expect($promotion->sort_order)->toBe(8);
    expect($promotion->translate('de', 'title'))->toBe('Neu');
    expect($promotion->translate('en', 'title'))->toBeNull();
    expect($promotion->background_image_path)->not->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($promotion->background_image_path);
});

test('admin can remove a promotion background image', function () {
    Storage::fake('public');

    $promotion = Promotion::factory()->create([
        'background_image_path' => UploadedFile::fake()
            ->image('old.jpg')
            ->store('promotions/backgrounds', 'public'),
    ]);
    $promotion->setTranslation('de', 'title', 'Alt');
    $oldPath = $promotion->background_image_path;

    $this->actingAs($this->admin)
        ->put("/dashboard/promotions/{$promotion->id}", [
            'slug' => $promotion->slug,
            'remove_background_image' => true,
            'background_color' => '',
            'link_url' => '',
            'promo_code' => '',
            'discount_percent' => '',
            'starts_at' => '',
            'ends_at' => '',
            'sort_order' => 0,
            'is_active' => true,
            'translations' => [
                'de' => ['title' => 'Alt'],
                'ar' => ['title' => ''],
                'en' => ['title' => ''],
            ],
        ])
        ->assertRedirect('/dashboard/promotions');

    expect($promotion->refresh()->background_image_path)->toBeNull();
    Storage::disk('public')->assertMissing($oldPath);
});

test('admin can delete a promotion and clean up translations and background image', function () {
    Storage::fake('public');

    $promotion = Promotion::factory()->create([
        'background_image_path' => UploadedFile::fake()
            ->image('delete.jpg')
            ->store('promotions/backgrounds', 'public'),
    ]);
    $promotion->setTranslation('de', 'title', 'Delete');
    $path = $promotion->background_image_path;

    $this->actingAs($this->admin)
        ->delete("/dashboard/promotions/{$promotion->id}")
        ->assertRedirect('/dashboard/promotions');

    expect(Promotion::find($promotion->id))->toBeNull();
    expect(Translation::query()
        ->where('translatable_type', Promotion::class)
        ->where('translatable_id', $promotion->id)
        ->count(),
    )->toBe(0);
    Storage::disk('public')->assertMissing($path);
});
