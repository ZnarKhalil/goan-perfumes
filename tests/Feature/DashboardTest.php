<?php

use App\Models\User;
use App\Services\GoogleAnalyticsService;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('non-admin users are redirected away from the dashboard', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertRedirect('/');
});

test('admin users can visit the dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    mockDashboardAnalytics();

    $response = $this->get(route('dashboard'));
    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('dashboard')
            ->where('filters.range', 30)
            ->where('analytics.property_id', '542125730')
            ->where('analytics.summary.active_users', 12)
            ->where('analytics.summary_comparison.active_users.change_percent', 20)
            ->where('analytics.previous_period.start', '2026-04-30')
            ->where('analytics.daily.0.page_views', 18)
            ->where('analytics.landing_pages.0.path', '/de')
            ->where('analytics.top_pages.0.title', 'Startseite'),
        );
});

test('seeded admin uses the configured strong password', function () {
    config(['auth.admin_password' => 'Correct-Horse-Battery-Staple!48']);

    $this->seed(AdminUserSeeder::class);

    $admin = User::query()->where('email', 'admin@goanperfume.de')->sole();

    expect($admin->is_admin)->toBeTrue()
        ->and(Hash::check('Correct-Horse-Battery-Staple!48', $admin->password))->toBeTrue()
        ->and(Hash::check('password', $admin->password))->toBeFalse();
});

test('shared auth user only exposes whitelisted fields', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    mockDashboardAnalytics();

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('auth.user.id', $admin->id)
            ->where('auth.user.name', $admin->name)
            ->where('auth.user.email', $admin->email)
            ->has('auth.user.email_verified_at')
            ->missing('auth.user.password')
            ->missing('auth.user.is_admin')
            ->missing('auth.user.two_factor_secret')
            ->missing('auth.user.two_factor_recovery_codes')
            ->missing('auth.user.remember_token')
            ->missing('auth.user.created_at')
            ->missing('auth.user.updated_at'),
        );
});

test('dashboard accepts supported analytics range filters', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    mockDashboardAnalytics(rangeDays: 7);

    $this->get(route('dashboard', ['range' => 7]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('filters.range', 7)
            ->where('analytics.range_days', 7),
        );
});

test('dashboard falls back to thirty analytics days for unsupported ranges', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    mockDashboardAnalytics();

    $this->get(route('dashboard', ['range' => 365]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('filters.range', 30)
            ->where('analytics.range_days', 30),
        );
});

test('dedicated dashboard analytics page is not registered', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get('/dashboard/analytics')
        ->assertNotFound();
});

function mockDashboardAnalytics(int $rangeDays = 30): void
{
    $mock = Mockery::mock(GoogleAnalyticsService::class);
    $mock->shouldReceive('dashboard')
        ->once()
        ->with($rangeDays)
        ->andReturn(dashboardAnalyticsPayload(rangeDays: $rangeDays));

    app()->instance(GoogleAnalyticsService::class, $mock);
}

function dashboardAnalyticsPayload(int $rangeDays = 30): array
{
    return [
        'range_days' => $rangeDays,
        'property_id' => '542125730',
        'configured' => true,
        'status' => 'ready',
        'message' => null,
        'current_period' => [
            'start' => '2026-05-31',
            'end' => '2026-06-30',
        ],
        'previous_period' => [
            'start' => '2026-04-30',
            'end' => '2026-05-30',
        ],
        'summary' => [
            'active_users' => 12,
            'sessions' => 18,
            'page_views' => 42,
            'engagement_rate' => 64.5,
        ],
        'summary_comparison' => [
            'active_users' => [
                'previous' => 10.0,
                'change_value' => 2.0,
                'change_percent' => 20.0,
            ],
            'sessions' => [
                'previous' => 15.0,
                'change_value' => 3.0,
                'change_percent' => 20.0,
            ],
            'page_views' => [
                'previous' => 35.0,
                'change_value' => 7.0,
                'change_percent' => 20.0,
            ],
            'engagement_rate' => [
                'previous' => 60.0,
                'change_value' => 4.5,
                'change_percent' => 7.5,
            ],
        ],
        'realtime' => [
            'active_users' => 2,
        ],
        'daily' => [
            ['date' => '2026-06-15', 'active_users' => 4, 'page_views' => 18],
            ['date' => '2026-06-16', 'active_users' => 6, 'page_views' => 24],
        ],
        'top_pages' => [
            [
                'title' => 'Startseite',
                'url' => '/de',
                'views' => 20,
                'title_count' => 1,
                'is_suspicious' => false,
            ],
        ],
        'top_product_pages' => [
            [
                'title' => 'Produkt',
                'url' => '/de/produkt/test',
                'views' => 10,
                'title_count' => 1,
                'is_suspicious' => false,
            ],
        ],
        'landing_pages' => [
            [
                'path' => '/de',
                'sessions' => 14,
                'views' => 28,
                'engaged_sessions' => 9,
                'engagement_rate' => 64.3,
                'is_suspicious' => false,
            ],
        ],
        'top_sources' => [
            [
                'source' => 'Google',
                'medium' => 'Organisch',
                'raw_source_medium' => 'google / organic',
                'sessions' => 12,
                'views' => 16,
                'engaged_sessions' => 8,
                'engagement_rate' => 66.7,
            ],
        ],
        'top_countries' => [
            ['country' => 'Germany', 'views' => 30],
        ],
        'devices' => [
            ['device' => 'mobile', 'sessions' => 12],
        ],
    ];
}
