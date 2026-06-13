<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class StorageUrl
{
    /**
     * Resolve a stored path to a public URL. Absolute URLs pass through
     * unchanged; blank paths resolve to null. URLs served by the app itself
     * are returned host-relative so they (and any cache holding them) stay
     * valid regardless of the host the app is accessed through.
     */
    public static function for(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $url = Storage::url($path);
        $appUrl = rtrim((string) config('app.url'), '/');

        if ($appUrl !== '' && Str::startsWith($url, $appUrl.'/')) {
            return Str::after($url, $appUrl);
        }

        return $url;
    }
}
