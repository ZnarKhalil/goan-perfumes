<?php

namespace App\Support;

use App\Models\Category;

final class CategoryFallbackImages
{
    public static function urlFor(?Category $category): ?string
    {
        if ($category === null) {
            return null;
        }

        $media = $category->relationLoaded('primaryMedia')
            ? $category->primaryMedia
            : $category->primaryMedia()->first();

        return StorageUrl::for($media?->path);
    }
}
