<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

test('settings are read from the cache instead of the database', function () {
    Setting::put('email', 'kontakt@example.test');

    expect(Setting::get('email'))->toBe('kontakt@example.test');

    DB::table('settings')->where('key', 'email')->update(['value' => 'stale@example.test']);

    expect(Setting::get('email'))->toBe('kontakt@example.test');

    Setting::flushCache();

    expect(Setting::get('email'))->toBe('stale@example.test');
});

test('saving a setting refreshes the cached values', function () {
    Setting::put('phone', '+49 30 111111');
    expect(Setting::get('phone'))->toBe('+49 30 111111');

    Setting::put('phone', '+49 30 222222');
    expect(Setting::get('phone'))->toBe('+49 30 222222');
});

test('missing settings fall back to the default', function () {
    expect(Setting::get('does_not_exist'))->toBeNull();
    expect(Setting::get('does_not_exist', 'fallback'))->toBe('fallback');
});
