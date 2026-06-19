<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ImpressumController;
use App\Http\Controllers\Public\PrivacyPolicyController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\SitemapController;
use App\Support\PublicLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/dashboard.php';

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', fn () => response(
    implode("\n", [
        'User-agent: *',
        'Disallow: /dashboard',
        'Disallow: /settings',
        'Disallow: /two-factor-challenge',
        'Disallow: /user/confirm-password',
        'Allow: /build/',
        'Allow: /storage/',
        'Sitemap: '.route('sitemap'),
        '',
    ]),
    200,
    ['Content-Type' => 'text/plain; charset=UTF-8'],
));

Route::prefix('{locale}')
    ->whereIn('locale', PublicLocale::codes())
    ->middleware('public.locale')
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/kontakt', ContactController::class)->name('contact');
        Route::get('/impressum', ImpressumController::class)->name('impressum');
        Route::get('/datenschutz', PrivacyPolicyController::class)->name('privacy');
        Route::get('/produkt/{slug}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{slug}', [CategoryController::class, 'show'])->name('categories.show');
    });

Route::get('/', fn (Request $request) => redirect()->route('home', [
    ...$request->query(),
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
]));
Route::get('/kontakt', fn (Request $request) => redirect()->route('contact', [
    ...$request->query(),
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
]));
Route::get('/impressum', fn (Request $request) => redirect()->route('impressum', [
    ...$request->query(),
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
]));
Route::get('/datenschutz', fn (Request $request) => redirect()->route('privacy', [
    ...$request->query(),
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
]));
Route::get('/produkt/{slug}', fn (Request $request, string $slug) => redirect()->route('products.show', [
    ...$request->query(),
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
    'slug' => $slug,
]));
Route::get('/{slug}', fn (Request $request, string $slug) => redirect()->route('categories.show', [
    ...$request->query(),
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
    'slug' => $slug,
]));
