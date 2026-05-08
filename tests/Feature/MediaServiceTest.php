<?php

use App\Models\Media;
use App\Models\Product;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('media service creates uploaded media rows with metadata and translations', function () {
    Storage::fake('public');

    $product = Product::factory()->create();
    $service = new MediaService;

    $service->syncFromRequest(
        model: $product,
        uploads: [
            UploadedFile::fake()->image('front.jpg'),
            UploadedFile::fake()->image('side.webp'),
        ],
        meta: [
            'new' => [
                [
                    'sort_order' => 1,
                    'is_primary' => false,
                    'alt_text' => ['de' => 'Vorderseite', 'en' => 'Front'],
                ],
                [
                    'sort_order' => 0,
                    'is_primary' => true,
                    'alt_text' => ['de' => 'Seite'],
                ],
            ],
        ],
    );

    $media = $product->media()->orderBy('sort_order')->get();

    expect($media)->toHaveCount(2);
    expect($media[0]->is_primary)->toBeTrue();
    expect($media[0]->alt_text)->toBe('Seite');
    expect($media[1]->is_primary)->toBeFalse();
    expect($media[1]->translate('de', 'alt_text'))->toBe('Vorderseite');
    expect($media[1]->translate('en', 'alt_text'))->toBe('Front');

    Storage::disk('public')->assertExists($media[0]->path);
    Storage::disk('public')->assertExists($media[1]->path);
    expect($media[0]->path)->toStartWith("media/products/{$product->id}/");
});

test('media service updates existing rows deletes removed rows and preserves files', function () {
    Storage::fake('public');

    $product = Product::factory()->create();
    $keepPath = UploadedFile::fake()
        ->image('keep.jpg')
        ->store('media/products/'.$product->id, 'public');
    $removePath = UploadedFile::fake()
        ->image('remove.jpg')
        ->store('media/products/'.$product->id, 'public');

    $keep = $product->media()->create([
        'path' => $keepPath,
        'sort_order' => 0,
        'is_primary' => true,
        'alt_text' => 'Alt',
    ]);
    $keep->setTranslation('de', 'alt_text', 'Alt');

    $remove = $product->media()->create([
        'path' => $removePath,
        'sort_order' => 1,
        'is_primary' => false,
    ]);
    $remove->setTranslation('de', 'alt_text', 'Weg');

    (new MediaService)->syncFromRequest(
        model: $product,
        uploads: [],
        meta: [
            'existing' => [
                [
                    'id' => $keep->id,
                    'sort_order' => 5,
                    'is_primary' => false,
                    'alt_text' => ['de' => 'Neu', 'ar' => 'جديد', 'en' => ''],
                ],
            ],
            'removed' => [$remove->id],
        ],
    );

    $keep->refresh();

    expect($product->media()->count())->toBe(1);
    expect($keep->sort_order)->toBe(5);
    expect($keep->is_primary)->toBeTrue();
    expect($keep->alt_text)->toBe('Neu');
    expect($keep->translate('de', 'alt_text'))->toBe('Neu');
    expect($keep->translate('ar', 'alt_text'))->toBe('جديد');
    expect($keep->translate('en', 'alt_text'))->toBeNull();
    expect(Media::find($remove->id))->toBeNull();

    Storage::disk('public')->assertExists($keepPath);
    Storage::disk('public')->assertMissing($removePath);
});

test('media service keeps only the first requested primary media item', function () {
    Storage::fake('public');

    $product = Product::factory()->create();

    (new MediaService)->syncFromRequest(
        model: $product,
        uploads: [
            UploadedFile::fake()->image('one.jpg'),
            UploadedFile::fake()->image('two.jpg'),
        ],
        meta: [
            'new' => [
                ['sort_order' => 0, 'is_primary' => true],
                ['sort_order' => 1, 'is_primary' => true],
            ],
        ],
    );

    expect($product->media()->where('is_primary', true)->count())->toBe(1);
    expect($product->media()->orderBy('sort_order')->first()->is_primary)->toBeTrue();
});

test('media service rejects unsaved models', function () {
    $product = Product::factory()->make();

    (new MediaService)->syncFromRequest($product, [], []);
})->throws(InvalidArgumentException::class);
