<?php

namespace App\Models;

use App\Support\PublicCategoryNavigation;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['translatable_type', 'translatable_id', 'locale', 'field', 'value'])]
class Translation extends Model
{
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::saved(function (Translation $translation): void {
            self::flushCategoryNavigationCache($translation);
        });

        static::deleted(function (Translation $translation): void {
            self::flushCategoryNavigationCache($translation);
        });
    }

    private static function flushCategoryNavigationCache(Translation $translation): void
    {
        if ($translation->translatable_type === Category::class) {
            PublicCategoryNavigation::flush();
        }
    }
}
