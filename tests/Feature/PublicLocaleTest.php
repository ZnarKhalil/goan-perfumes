<?php

use App\Models\User;
use App\Support\PublicLocale;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

test('public locale contract exposes supported locales', function () {
    expect(PublicLocale::codes())->toBe(['de', 'en', 'ar'])
        ->and(PublicLocale::normalize('en'))->toBe('en')
        ->and(PublicLocale::normalize('fr'))->toBe('de')
        ->and(PublicLocale::direction('ar'))->toBe('rtl')
        ->and(PublicLocale::direction('de'))->toBe('ltr')
        ->and(PublicLocale::formatterLocale('en'))->toBe('en-DE')
        ->and(PublicLocale::formatterLocale('bogus'))->toBe('de-DE');
});

test('public pages share default German locale props', function () {
    $this->get('/de')
        ->assertOk()
        ->assertCookie(PublicLocale::CookieName, 'de')
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/home')
            ->where('locale.current', 'de')
            ->where('locale.dir', 'ltr')
            ->where('locale.formatter_locale', 'de-DE')
            ->has('locale.supported', 3)
            ->where('locale.supported.2.code', 'ar')
            ->where('locale.supported.2.dir', 'rtl')
            ->where('locale.switcher_urls.de', config('app.url').'/de')
            ->where('locale.switcher_urls.en', config('app.url').'/en')
            ->where('locale.switcher_urls.ar', config('app.url').'/ar'),
        );
});

test('localized routes are authoritative over cookie locale', function () {
    $this->withCookie(PublicLocale::CookieName, 'ar')
        ->get('/en/kontakt')
        ->assertOk()
        ->assertCookie(PublicLocale::CookieName, 'en')
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/contact')
            ->where('locale.current', 'en')
            ->where('locale.dir', 'ltr')
            ->where('locale.formatter_locale', 'en-DE'),
        );
});

test('public locale middleware validates route locale parameters', function () {
    Route::middleware('public.locale')->get('/_locale-test/{locale}', fn () => app()->getLocale());

    $this->get('/_locale-test/en')
        ->assertOk()
        ->assertSee('en');

    $this->get('/_locale-test/fr')->assertNotFound();
});

test('public locale middleware normalizes unsupported cookie locale', function () {
    $this->withCookie(PublicLocale::CookieName, 'fr')
        ->get('/de/kontakt')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/contact')
            ->where('locale.current', 'de')
            ->where('locale.dir', 'ltr'),
        );
});

test('legacy public routes redirect to the cookie locale with German fallback', function () {
    $this->withCookie(PublicLocale::CookieName, 'ar')
        ->get('/kontakt')
        ->assertRedirect(route('contact', ['locale' => 'ar']));

    $this->withCookie(PublicLocale::CookieName, 'fr')
        ->get('/produkt/iris-musk')
        ->assertRedirect(route('products.show', [
            'locale' => 'de',
            'slug' => 'iris-musk',
        ]));

    $this->get('/damenparfums')
        ->assertRedirect(route('categories.show', [
            'locale' => 'de',
            'slug' => 'damenparfums',
        ]));

    $this->get('/damenparfums?familie=blumig')
        ->assertRedirect(route('categories.show', [
            'locale' => 'de',
            'slug' => 'damenparfums',
            'familie' => 'blumig',
        ]));
});

test('dashboard pages do not receive public locale props', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->withCookie(PublicLocale::CookieName, 'ar')
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('dashboard')
            ->missing('locale'),
        );
});
