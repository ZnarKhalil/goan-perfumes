<?php

use App\Services\GoogleAnalyticsService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

test('google analytics service account credentials are ignored by git', function () {
    $gitignore = file_get_contents(base_path('.gitignore'));

    expect($gitignore)->toContain('/storage/app/analytics/*.json');
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

test('a failing realtime call does not blank the rest of the dashboard', function () {
    Analytics::shouldReceive('getRealtime')
        ->once()
        ->andThrow(new RuntimeException('realtime unavailable'));

    $realtime = (new ReflectionMethod(GoogleAnalyticsService::class, 'realtime'))
        ->invoke(app(GoogleAnalyticsService::class));

    expect($realtime)->toBe(['active_users' => 0]);
});
