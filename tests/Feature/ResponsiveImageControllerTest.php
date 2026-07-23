<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('public storage images are resized and cached as webp', function () {
    Storage::fake('public');
    $sourcePath = UploadedFile::fake()
        ->image('hero.jpg', 1200, 675)
        ->store('page-sections/hero', 'public');

    $response = $this->get("/media/480/{$sourcePath}")
        ->assertOk()
        ->assertHeader('Content-Type', 'image/webp')
        ->assertHeader('Cache-Control', 'immutable, max-age=31536000, public');

    $cachePath = 'responsive-images/'.sha1($sourcePath).'-480.webp';
    $dimensions = getimagesizefromstring(
        Storage::disk('public')->get($cachePath),
    );

    expect($dimensions)->not->toBeFalse()
        ->and($dimensions[0])->toBe(480)
        ->and($dimensions[1])->toBe(270);

    Storage::disk('public')->assertExists(
        $cachePath,
    );
});

test('responsive image route rejects unsupported widths and unsafe paths', function () {
    Storage::fake('public');

    $this->get('/media/999/page-sections/hero.jpg')->assertNotFound();
    $this->get('/media/480/../private.jpg')->assertNotFound();
    $this->get('/media/480/missing.jpg')->assertNotFound();
});
