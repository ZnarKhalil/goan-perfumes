<?php

namespace App\Support;

use App\Models\Category;

final class CategoryFallbackImages
{
    private const Images = [
        'damenparfums' => '/images/category-fallbacks/damenparfums.webp',
        'herrenparfums' => '/images/category-fallbacks/herrenparfums.webp',
        'luxusparfums' => '/images/category-fallbacks/luxusparfums.webp',
        'unisex-parfums' => '/images/category-fallbacks/unisex-parfums.webp',
    ];

    public static function urlFor(?Category $category): ?string
    {
        if ($category === null) {
            return null;
        }

        $url = self::Images[$category->slug] ?? null;

        if ($url === null || ! file_exists(public_path(ltrim($url, '/')))) {
            return null;
        }

        return $url;
    }
}
