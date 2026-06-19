<?php

use App\Models\Media;
use App\Models\Product;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

test('media service creates product media rows with generated alt text', function () {
    Storage::fake('public');

    $product = Product::factory()->create(['brand' => 'Maison Test']);
    $product->setTranslation('de', 'name', 'Sommer Oud');
    $product->setTranslation('en', 'name', 'Summer Oud');
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
                ],
                [
                    'sort_order' => 0,
                    'is_primary' => true,
                ],
            ],
        ],
    );

    $media = $product->media()->orderBy('sort_order')->get();

    expect($media)->toHaveCount(2);
    expect($media[0]->is_primary)->toBeTrue();
    expect($media[0]->alt_text)->toBe('Sommer Oud Parfum von Maison Test');
    expect($media[0]->translate('de', 'alt_text'))->toBe('Sommer Oud Parfum von Maison Test');
    expect($media[0]->translate('en', 'alt_text'))->toBe('Summer Oud perfume by Maison Test');
    expect($media[0]->translate('ar', 'alt_text'))->toBe('عطر Sommer Oud من Maison Test');
    expect($media[1]->is_primary)->toBeFalse();

    Storage::disk('public')->assertExists($media[0]->path);
    Storage::disk('public')->assertExists($media[1]->path);
    expect($media[0]->path)->toStartWith("media/products/{$product->id}/");
    expect($media[0]->path)
        ->toContain($product->slug)
        ->toContain('sommer-oud-parfum-von-maison-test')
        ->toEndWith('.webp');
});

test('media service updates existing rows deletes removed rows and preserves files', function () {
    Storage::fake('public');

    $product = Product::factory()->create(['brand' => 'Creed']);
    $product->setTranslation('de', 'name', 'Sommer Oud');
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
                ],
            ],
            'removed' => [$remove->id],
        ],
    );

    $keep->refresh();

    expect($product->media()->count())->toBe(1);
    expect($keep->sort_order)->toBe(5);
    expect($keep->is_primary)->toBeTrue();
    expect($keep->alt_text)->toBe('Sommer Oud Parfum von Creed');
    expect($keep->translate('de', 'alt_text'))->toBe('Sommer Oud Parfum von Creed');
    expect($keep->translate('ar', 'alt_text'))->toBe('عطر Sommer Oud من Creed');
    expect($keep->translate('en', 'alt_text'))->toBe('Sommer Oud perfume by Creed');
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

test('removed media files are kept when the surrounding transaction rolls back', function () {
    Storage::fake('public');

    $product = Product::factory()->create();
    $path = UploadedFile::fake()
        ->image('keep.jpg')
        ->store('media/products/'.$product->id, 'public');
    $media = $product->media()->create([
        'path' => $path,
        'sort_order' => 0,
        'is_primary' => true,
    ]);

    try {
        DB::transaction(function () use ($product, $media): void {
            (new MediaService)->syncFromRequest(
                model: $product,
                uploads: [],
                meta: ['removed' => [$media->id]],
            );

            throw new RuntimeException('boom');
        });
    } catch (RuntimeException) {
        // Expected: the transaction rolled back.
    }

    expect(Media::query()->whereKey($media->id)->exists())->toBeTrue();
    Storage::disk('public')->assertExists($path);
});

test('removed media files are deleted once the transaction commits', function () {
    Storage::fake('public');

    $product = Product::factory()->create();
    $path = UploadedFile::fake()
        ->image('gone.jpg')
        ->store('media/products/'.$product->id, 'public');
    $media = $product->media()->create([
        'path' => $path,
        'sort_order' => 0,
        'is_primary' => true,
    ]);

    DB::transaction(function () use ($product, $media): void {
        (new MediaService)->syncFromRequest(
            model: $product,
            uploads: [],
            meta: ['removed' => [$media->id]],
        );
    });

    expect(Media::query()->whereKey($media->id)->exists())->toBeFalse();
    Storage::disk('public')->assertMissing($path);
});
