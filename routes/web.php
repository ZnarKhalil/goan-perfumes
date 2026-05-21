<?php

use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController;
use App\Support\PublicLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('{locale}')
    ->whereIn('locale', PublicLocale::codes())
    ->middleware('public.locale')
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/kontakt', ContactController::class)->name('contact');
        Route::get('/produkt/{slug}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{slug}', [CategoryController::class, 'show'])->name('categories.show');
    });

Route::get('/', fn (Request $request) => redirect()->route('home', [
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
    ...$request->query(),
]));
Route::get('/kontakt', fn (Request $request) => redirect()->route('contact', [
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
    ...$request->query(),
]));
Route::get('/produkt/{slug}', fn (Request $request, string $slug) => redirect()->route('products.show', [
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
    'slug' => $slug,
    ...$request->query(),
]));
Route::get('/{slug}', fn (Request $request, string $slug) => redirect()->route('categories.show', [
    'locale' => PublicLocale::normalize($request->cookie(PublicLocale::CookieName)),
    'slug' => $slug,
    ...$request->query(),
]));

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/dashboard.php';
