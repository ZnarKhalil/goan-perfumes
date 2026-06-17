<?php

use App\Models\User;
use App\Services\GoogleAnalyticsService;
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
            ->where('analytics.daily.0.page_views', 18)
            ->where('analytics.top_pages.0.title', 'Startseite'),
        );
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
        'summary' => [
            'active_users' => 12,
            'sessions' => 18,
            'page_views' => 42,
            'engagement_rate' => 64.5,
        ],
        'realtime' => [
            'active_users' => 2,
        ],
        'daily' => [
            ['date' => '2026-06-15', 'active_users' => 4, 'page_views' => 18],
            ['date' => '2026-06-16', 'active_users' => 6, 'page_views' => 24],
        ],
        'top_pages' => [
            ['title' => 'Startseite', 'url' => 'https://goanperfume.de/de', 'views' => 20],
        ],
        'top_product_pages' => [
            ['title' => 'Produkt', 'url' => '/de/produkt/test', 'views' => 10],
        ],
        'top_sources' => [
            ['source' => 'google / organic', 'views' => 16],
        ],
        'top_countries' => [
            ['country' => 'Germany', 'views' => 30],
        ],
        'devices' => [
            ['device' => 'mobile', 'sessions' => 12],
        ],
    ];
}
