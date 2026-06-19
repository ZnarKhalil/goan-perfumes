<?php

use App\Services\GoogleAnalyticsService;

test('google analytics service account credentials are ignored by git', function () {
    $gitignore = file_get_contents(base_path('.gitignore'));

    expect($gitignore)->toContain('/storage/app/analytics/*.json');
});

test('google analytics dashboard uses a valid realtime range', function () {
    $reflection = new ReflectionClass(GoogleAnalyticsService::class);

    expect($reflection->getConstant('RealtimeLookbackMinutes'))->toBe(29);
});
