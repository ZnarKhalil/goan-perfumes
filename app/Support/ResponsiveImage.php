<?php

namespace App\Support;

use Illuminate\Support\Str;

final class ResponsiveImage
{
    public static function url(?string $storageUrl, int $width): ?string
    {
        if ($storageUrl === null || ! Str::startsWith($storageUrl, '/storage/')) {
            return $storageUrl;
        }

        $path = Str::after($storageUrl, '/storage/');
        $encodedPath = collect(explode('/', $path))
            ->map(fn (string $segment): string => rawurlencode($segment))
            ->implode('/');

        return "/media/{$width}/{$encodedPath}";
    }
}
