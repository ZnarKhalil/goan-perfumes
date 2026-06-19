<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class ImageUpload
{
    public static function storePublicImageAsWebp(
        UploadedFile $upload,
        string $directory,
        string $basename,
        string $disk = 'public',
    ): string {
        $filename = self::filename($basename, 'webp');
        $path = trim($directory, '/').'/'.$filename;

        if (self::storeWebp($upload, $path, $disk)) {
            return $path;
        }

        $extension = $upload->extension() ?: $upload->guessExtension() ?: 'jpg';
        $fallbackPath = trim($directory, '/').'/'.self::filename($basename, $extension);

        return $upload->storeAs(trim($directory, '/'), basename($fallbackPath), $disk);
    }

    private static function storeWebp(UploadedFile $upload, string $path, string $disk): bool
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            return false;
        }

        $image = @imagecreatefromstring($upload->get());

        if ($image === false) {
            return false;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $temporary = tempnam(sys_get_temp_dir(), 'goan-webp-');

        if ($temporary === false) {
            imagedestroy($image);

            return false;
        }

        $encoded = imagewebp($image, $temporary, 82);
        imagedestroy($image);

        if (! $encoded) {
            @unlink($temporary);

            return false;
        }

        Storage::disk($disk)->put($path, file_get_contents($temporary));
        @unlink($temporary);

        return true;
    }

    private static function filename(string $basename, string $extension): string
    {
        $name = Str::slug($basename);

        if ($name === '') {
            $name = 'image';
        }

        return Str::limit($name, 90, '').'-'.Str::lower(Str::ulid()->toBase32()).'.'.$extension;
    }
}
