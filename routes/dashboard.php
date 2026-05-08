<?php

use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\AttributeValueController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PageSectionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\PromotionController;
use App\Http\Controllers\Dashboard\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('attributes', AttributeController::class)->except('show');
    Route::resource('attributes.values', AttributeValueController::class)
        ->only(['store', 'update', 'destroy']);
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('promotions', PromotionController::class)->except('show');
    Route::resource('page-sections', PageSectionController::class)->only(['index', 'edit', 'update']);
    Route::get('settings/site', [SettingsController::class, 'edit'])->name('settings.site.edit');
    Route::put('settings/site', [SettingsController::class, 'update'])->name('settings.site.update');
});
