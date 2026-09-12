<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
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

test('responsive images reject aliases without creating additional cached files', function (string $directory) {
    Storage::fake('public');
    $sourcePath = UploadedFile::fake()->image('hero.jpg', 100, 100)->store('page-sections/hero', 'public');
    $filename = basename($sourcePath);

    $this->get("/media/80/{$sourcePath}")->assertOk();
    $this->get("/media/80/{$directory}/{$filename}")->assertNotFound();

    expect(Storage::disk('public')->allFiles('responsive-images'))
        ->toBe(['responsive-images/'.sha1($sourcePath).'-80.webp']);
})->with(['page-sections//hero', 'page-sections/./hero', 'page-sections/hero/.']);

test('responsive images do not generate a variant while another request holds its lock', function () {
    Storage::fake('public');
    $sourcePath = UploadedFile::fake()->image('hero.jpg', 100, 100)->store('page-sections/hero', 'public');
    $cachePath = 'responsive-images/'.sha1($sourcePath).'-80.webp';
    $lock = Cache::lock('responsive-image:'.$cachePath, 120);
    expect($lock->get())->toBeTrue();

    try {
        $this->get("/media/80/{$sourcePath}")->assertServiceUnavailable()->assertHeader('Retry-After', '1');
        Storage::disk('public')->assertMissing($cachePath);
    } finally {
        $lock->release();
    }

    $this->get("/media/80/{$sourcePath}")->assertOk();
    expect($lock->get())->toBeTrue();

    try {
        $this->get("/media/80/{$sourcePath}")->assertOk();
    } finally {
        $lock->release();
    }
});
