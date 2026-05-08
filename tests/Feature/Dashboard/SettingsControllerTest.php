<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('non-admin users are redirected away from the site settings dashboard', function () {
    $regular = User::factory()->create();

    $this->actingAs($regular)
        ->get('/dashboard/settings/site')
        ->assertRedirect('/');
});

test('admin can edit site settings with current values', function () {
    Setting::put('email', 'kontakt@goanperfume.de');
    Setting::put('phone', '+49 30 123456');
    Setting::put('default_locale', 'de');
    Setting::put('logo_path', 'branding/logo.png');

    $this->actingAs($this->admin)
        ->get('/dashboard/settings/site')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('dashboard/settings/site')
            ->where('settings.email', 'kontakt@goanperfume.de')
            ->where('settings.phone', '+49 30 123456')
            ->where('settings.default_locale', 'de')
            ->where('settings.logo_path', 'branding/logo.png')
            ->where('settings.logo_url', '/storage/branding/logo.png'),
        );
});

test('admin can update every typed setting and upload a logo', function () {
    Storage::fake('public');

    $this->actingAs($this->admin)
        ->post('/dashboard/settings/site', [
            '_method' => 'PUT',
            'whatsapp_number' => '+49 170 123456',
            'email' => 'kontakt@goanperfume.de',
            'phone' => '+49 30 654321',
            'instagram_url' => 'https://instagram.com/goanperfume',
            'tiktok_url' => 'https://tiktok.com/@goanperfume',
            'facebook_url' => 'https://facebook.com/goanperfume',
            'default_locale' => 'de',
            'logo' => UploadedFile::fake()->image('logo.png', 512, 512),
        ])
        ->assertRedirect('/dashboard/settings/site');

    expect(Setting::get('whatsapp_number'))->toBe('+49 170 123456');
    expect(Setting::get('email'))->toBe('kontakt@goanperfume.de');
    expect(Setting::get('phone'))->toBe('+49 30 654321');
    expect(Setting::get('instagram_url'))->toBe('https://instagram.com/goanperfume');
    expect(Setting::get('tiktok_url'))->toBe('https://tiktok.com/@goanperfume');
    expect(Setting::get('facebook_url'))->toBe('https://facebook.com/goanperfume');
    expect(Setting::get('default_locale'))->toBe('de');
    expect(Setting::get('logo_path'))->toStartWith('branding/');
    Storage::disk('public')->assertExists(Setting::get('logo_path'));
});

test('admin can replace and remove the logo', function () {
    Storage::fake('public');

    $oldPath = UploadedFile::fake()
        ->image('old.png')
        ->store('branding', 'public');
    Setting::put('logo_path', $oldPath);

    $this->actingAs($this->admin)
        ->post('/dashboard/settings/site', [
            '_method' => 'PUT',
            'whatsapp_number' => '',
            'email' => '',
            'phone' => '',
            'instagram_url' => '',
            'tiktok_url' => '',
            'facebook_url' => '',
            'default_locale' => 'en',
            'logo' => UploadedFile::fake()->image('new.png', 512, 512),
        ])
        ->assertRedirect('/dashboard/settings/site');

    $newPath = Setting::get('logo_path');

    expect($newPath)->not->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($newPath);

    $this->actingAs($this->admin)
        ->put('/dashboard/settings/site', [
            'whatsapp_number' => '',
            'email' => '',
            'phone' => '',
            'instagram_url' => '',
            'tiktok_url' => '',
            'facebook_url' => '',
            'default_locale' => 'de',
            'remove_logo' => true,
        ])
        ->assertRedirect('/dashboard/settings/site');

    expect(Setting::get('logo_path'))->toBe('');
    Storage::disk('public')->assertMissing($newPath);
});

test('settings validation rejects invalid urls email and locale', function () {
    $this->actingAs($this->admin)
        ->put('/dashboard/settings/site', [
            'whatsapp_number' => '',
            'email' => 'not-an-email',
            'phone' => '',
            'instagram_url' => 'instagram',
            'tiktok_url' => 'tiktok',
            'facebook_url' => 'facebook',
            'default_locale' => 'fr',
        ])
        ->assertSessionHasErrors([
            'email',
            'instagram_url',
            'tiktok_url',
            'facebook_url',
            'default_locale',
        ]);
});
