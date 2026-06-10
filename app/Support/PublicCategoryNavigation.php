<?php

namespace App\Support;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

final class PublicCategoryNavigation
{
    private const CacheKeyPrefix = 'public-category-navigation';

    /**
     * @return array<int, array{id: int, slug: string, name: string, href: string, image_url: ?string}>
     */
    public static function forLocale(string $locale): array
    {
        $locale = PublicLocale::normalize($locale);

        return Cache::rememberForever(self::cacheKey($locale), fn (): array => Category::query()
            ->with('translations')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Category $category): array => self::item($category, $locale))
            ->values()
            ->all());
    }

    public static function flush(): void
    {
        foreach (PublicLocale::codes() as $locale) {
            Cache::forget(self::cacheKey($locale));
        }
    }

    private static function cacheKey(string $locale): string
    {
        return self::CacheKeyPrefix.':'.$locale;
    }

    /**
     * @return array{id: int, slug: string, name: string, href: string, image_url: ?string}
     */
    private static function item(Category $category, string $locale): array
    {
        return [
            'id' => $category->id,
            'slug' => $category->slug,
            'name' => $category->translate($locale, 'name', PublicLocale::Default) ?? $category->slug,
            'href' => route('categories.show', [
                'locale' => $locale,
                'slug' => $category->slug,
            ]),
            'image_url' => StorageUrl::for($category->image_path),
        ];
    }
}
