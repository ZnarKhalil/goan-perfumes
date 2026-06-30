<?php

use App\Services\GoogleAnalyticsService;
use Carbon\CarbonImmutable;
use Illuminate\Cache\ArrayStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Exceptions;
use Mockery\MockInterface;
use Spatie\Analytics\AnalyticsClient;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

function fakeAnalytics(): MockInterface
{
    config([
        'analytics.property_id' => '542125730',
        // Any readable existing file satisfies the configured check.
        'analytics.service_account_credentials_json' => base_path('composer.json'),
    ]);

    // Bind the mock as the facade root so the real Google client is never
    // built from the (deliberately invalid) credentials path above.
    $analytics = Mockery::mock(Spatie\Analytics\Analytics::class);
    app()->instance('laravel-analytics', $analytics);

    return $analytics;
}

test('google analytics service account credentials are ignored by git', function () {
    $gitignore = file_get_contents(base_path('.gitignore'));

    expect($gitignore)->toContain('/storage/app/analytics/*.json');
});

test('google analytics client uses the configured cache store', function () {
    config([
        'analytics.property_id' => '542125730',
        'analytics.service_account_credentials_json' => [
            'type' => 'service_account',
            'project_id' => 'goan-perfume',
            'private_key_id' => 'testing',
            'private_key' => "-----BEGIN PRIVATE KEY-----\ntesting\n-----END PRIVATE KEY-----\n",
            'client_email' => 'goan-perfume-analytics-reader@example.iam.gserviceaccount.com',
        ],
        'analytics.cache.store' => 'array',
    ]);

    app()->forgetInstance(AnalyticsClient::class);

    $client = app(AnalyticsClient::class);
    $cache = (new ReflectionProperty($client, 'cache'))->getValue($client);

    expect($cache->getStore())->toBeInstanceOf(ArrayStore::class);
});

test('the realtime range is valid regardless of the current minute', function () {
    // At minute :56, the previous implementation produced
    // endMinutesAgo = 56 > startMinutesAgo = 29, which the Realtime API
    // rejects with INVALID_ARGUMENT and blanked the whole dashboard.
    CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-06-24 10:56:00'));

    $captured = null;

    Analytics::shouldReceive('getRealtime')
        ->once()
        ->andReturnUsing(function (Period $period) use (&$captured): Collection {
            $captured = $period;

            return collect([['activeUsers' => 7]]);
        });

    $realtime = (new ReflectionMethod(GoogleAnalyticsService::class, 'realtime'))
        ->invoke(app(GoogleAnalyticsService::class));

    $range = $captured->toMinuteRange();

    expect($range->getEndMinutesAgo())->toBeLessThanOrEqual($range->getStartMinutesAgo())
        ->and($range->getStartMinutesAgo())->toBe(29)
        ->and($range->getEndMinutesAgo())->toBe(0)
        ->and($realtime)->toBe(['active_users' => 7]);

    CarbonImmutable::setTestNow();
});

test('a failed dashboard read is not cached', function () {
    $analytics = fakeAnalytics();
    $analytics->shouldReceive('get')->andThrow(new RuntimeException('GA down'));

    Exceptions::fake();

    $result = app(GoogleAnalyticsService::class)->dashboard(30);

    expect($result['status'])->toBe('unavailable')
        ->and(Cache::has('google-analytics.dashboard.30'))->toBeFalse();

    Exceptions::assertReported(
        fn (RuntimeException $exception): bool => $exception->getMessage() === 'GA down',
    );
});

test('a successful dashboard read is cached', function () {
    $analytics = fakeAnalytics();
    $analytics->shouldReceive('get')->andReturn(collect());
    $analytics->shouldReceive('getRealtime')->andReturn(collect());
    $analytics->shouldReceive('fetchMostVisitedPages')->andReturn(collect());
    $analytics->shouldReceive('fetchTopCountries')->andReturn(collect());

    $result = app(GoogleAnalyticsService::class)->dashboard(30);

    expect($result['status'])->toBe('ready')
        ->and(Cache::has('google-analytics.dashboard.30'))->toBeTrue();
});

test('a failing realtime call does not blank the rest of the dashboard', function () {
    Analytics::shouldReceive('getRealtime')
        ->once()
        ->andThrow(new RuntimeException('realtime unavailable'));

    $realtime = (new ReflectionMethod(GoogleAnalyticsService::class, 'realtime'))
        ->invoke(app(GoogleAnalyticsService::class));

    expect($realtime)->toBe(['active_users' => 0]);
});
