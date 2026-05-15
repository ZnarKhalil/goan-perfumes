<?php

use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/kontakt', ContactController::class)->name('contact');
Route::get('/produkt/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/{slug}', [CategoryController::class, 'show'])
    ->whereIn('slug', [
        'luxusparfums',
        'nischenparfums',
        'designerparfums',
        'arabische-parfums',
        'damenparfums',
        'herrenparfums',
        'unisex-parfums',
    ])
    ->name('categories.show');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/dashboard.php';
