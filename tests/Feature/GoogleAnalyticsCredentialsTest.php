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
    Cache::forget('google-analytics.dashboard.v3.30');

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
        ->and(Cache::has('google-analytics.dashboard.v3.30'))->toBeFalse();

    Exceptions::assertReported(
        fn (RuntimeException $exception): bool => $exception->getMessage() === 'GA down',
    );
});

test('a successful dashboard read is cached', function () {
    $analytics = fakeAnalytics();
    $analytics->shouldReceive('get')->andReturn(collect());
    $analytics->shouldReceive('getRealtime')->andReturn(collect());
    $analytics->shouldReceive('fetchTopCountries')->andReturn(collect());

    $result = app(GoogleAnalyticsService::class)->dashboard(30);

    expect($result['status'])->toBe('ready')
        ->and(Cache::has('google-analytics.dashboard.v3.30'))->toBeTrue();
});

test('dashboard includes google analytics comparison and quality reports', function () {
    CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-06-30 12:00:00'));

    $analytics = fakeAnalytics();
    $summaryCalls = 0;

    $analytics->shouldReceive('get')
        ->andReturnUsing(function (
            Period $period,
            array $metrics,
            array $dimensions = [],
        ) use (&$summaryCalls): Collection {
            if ($metrics === ['activeUsers', 'sessions', 'screenPageViews', 'engagementRate']) {
                $summaryCalls++;

                return collect([
                    $summaryCalls === 1
                        ? ['activeUsers' => 20, 'sessions' => 30, 'screenPageViews' => 60, 'engagementRate' => 0.5]
                        : ['activeUsers' => 10, 'sessions' => 15, 'screenPageViews' => 30, 'engagementRate' => 0.25],
                ]);
            }

            if ($dimensions === ['pageTitle', 'pagePathPlusQueryString']) {
                return collect([
                    ['pageTitle' => 'Rose Oud', 'pagePathPlusQueryString' => '/de/produkt/rose-oud', 'screenPageViews' => 8],
                    ['pageTitle' => 'Rose Oud kaufen', 'pagePathPlusQueryString' => '/de/produkt/rose-oud', 'screenPageViews' => 4],
                    ['pageTitle' => 'Startseite', 'pagePathPlusQueryString' => 'goanperfume.de/de', 'screenPageViews' => 60],
                    ['pageTitle' => 'Arabische Parfums', 'pagePathPlusQueryString' => '/de/arabische-parfums?page=2%3Fpage%3D2', 'screenPageViews' => 13],
                ]);
            }

            if ($dimensions === ['landingPagePlusQueryString']) {
                return collect([
                    [
                        'landingPagePlusQueryString' => '/de',
                        'sessions' => 18,
                        'screenPageViews' => 44,
                        'engagedSessions' => 12,
                        'engagementRate' => 0.667,
                    ],
                    [
                        'landingPagePlusQueryString' => '/de/arabische-parfums?page=2%3Fpage%3D2',
                        'sessions' => 5,
                        'screenPageViews' => 13,
                        'engagedSessions' => 2,
                        'engagementRate' => 0.4,
                    ],
                ]);
            }

            if ($dimensions === ['sessionSourceMedium']) {
                return collect([
                    [
                        'sessionSourceMedium' => 'ig / social',
                        'sessions' => 14,
                        'screenPageViews' => 32,
                        'engagedSessions' => 9,
                        'engagementRate' => 0.643,
                    ],
                ]);
            }

            if ($dimensions === ['deviceCategory']) {
                return collect([
                    ['deviceCategory' => 'mobile', 'sessions' => 20],
                ]);
            }

            if ($dimensions === ['date']) {
                return collect([
                    ['date' => '20260615', 'activeUsers' => 4, 'screenPageViews' => 9],
                ]);
            }

            return collect();
        });
    $analytics->shouldReceive('getRealtime')->andReturn(collect([['activeUsers' => 3]]));
    $analytics->shouldReceive('fetchTopCountries')->andReturn(collect([
        ['country' => 'Germany', 'screenPageViews' => 44],
    ]));

    $result = app(GoogleAnalyticsService::class)->dashboard(30);

    expect($result['current_period'])->toBe(['start' => '2026-05-31', 'end' => '2026-06-30'])
        ->and($result['previous_period'])->toBe(['start' => '2026-04-30', 'end' => '2026-05-30'])
        ->and($result['summary_comparison']['active_users']['change_percent'])->toBe(100.0)
        ->and($result['summary_comparison']['engagement_rate']['change_value'])->toBe(25.0)
        ->and($result['landing_pages'][0])->toMatchArray([
            'path' => '/de',
            'sessions' => 18,
            'views' => 44,
            'engaged_sessions' => 12,
            'engagement_rate' => 66.7,
            'is_suspicious' => false,
        ])
        ->and($result['landing_pages'][1]['is_suspicious'])->toBeTrue()
        ->and($result['top_sources'][0])->toMatchArray([
            'source' => 'Instagram',
            'medium' => 'Social',
            'raw_source_medium' => 'ig / social',
            'sessions' => 14,
            'views' => 32,
            'engaged_sessions' => 9,
            'engagement_rate' => 64.3,
        ])
        ->and($result['top_pages'][0])->toMatchArray([
            'title' => 'Startseite',
            'url' => '/de',
            'views' => 60,
            'title_count' => 1,
            'is_suspicious' => false,
        ])
        ->and($result['top_pages'][1]['is_suspicious'])->toBeTrue()
        ->and($result['top_product_pages'])->toHaveCount(1)
        ->and($result['top_product_pages'][0])->toMatchArray([
            'title' => 'Rose Oud',
            'url' => '/de/produkt/rose-oud',
            'views' => 12,
            'title_count' => 2,
            'is_suspicious' => false,
        ]);

    CarbonImmutable::setTestNow();
});

test('a failing realtime call does not blank the rest of the dashboard', function () {
    Analytics::shouldReceive('getRealtime')
        ->once()
        ->andThrow(new RuntimeException('realtime unavailable'));

    $realtime = (new ReflectionMethod(GoogleAnalyticsService::class, 'realtime'))
        ->invoke(app(GoogleAnalyticsService::class));

    expect($realtime)->toBe(['active_users' => 0]);
});
