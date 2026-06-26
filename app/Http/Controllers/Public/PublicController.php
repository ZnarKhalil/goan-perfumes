<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Media;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Setting;
use App\Support\CategoryFallbackImages;
use App\Support\Price;
use App\Support\PublicCategoryNavigation;
use App\Support\PublicLocale;
use App\Support\StorageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class PublicController extends Controller
{
    /** @var EloquentCollection<int, Attribute>|null */
    private ?EloquentCollection $filterableAttributes = null;

    protected function layoutProps(): array
    {
        return [
            'navigation' => $this->navigation(),
            'contact' => $this->contactSettings(),
            'logo_url' => $this->logoUrl(),
        ];
    }

    protected function navigation(): array
    {
        return PublicCategoryNavigation::forLocale($this->locale());
    }

    protected function categoryNavItem(Category $category): array
    {
        return [
            'id' => $category->id,
            'slug' => $category->slug,
            'name' => $this->translation($category, 'name') ?? $category->slug,
            'href' => route('categories.show', [
                'locale' => $this->locale(),
                'slug' => $category->slug,
            ]),
            'image_url' => CategoryFallbackImages::urlFor($category),
        ];
    }

    protected function contactSettings(): array
    {
        $whatsappNumber = $this->setting('whatsapp_number');
        $email = $this->setting('email');
        $phone = $this->setting('phone');

        return [
            'whatsapp_number' => $whatsappNumber,
            'whatsapp_url' => $this->whatsappUrl($whatsappNumber),
            'email' => $email,
            'email_url' => $email ? "mailto:{$email}" : null,
            'phone' => $phone,
            'phone_url' => $phone ? 'tel:'.preg_replace('/[^\d+]/', '', $phone) : null,
            'instagram_url' => $this->setting('instagram_url'),
            'tiktok_url' => $this->setting('tiktok_url'),
            'facebook_url' => $this->setting('facebook_url'),
        ];
    }

    protected function productCard(Product $product, ?Category $fallbackCategory = null): array
    {
        /** @var Media|null $primaryMedia */
        $primaryMedia = $product->primaryMedia;
        $name = $this->translation($product, 'name') ?? $product->slug;
        $categoryFallbackImageUrl = $primaryMedia === null
            ? $this->categoryFallbackImageUrl($fallbackCategory ?? $product->categories->first())
            : null;

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'href' => route('products.show', [
                'locale' => $this->locale(),
                'slug' => $product->slug,
            ]),
            'name' => $name,
            'brand' => $product->brand,
            'image_url' => StorageUrl::for($primaryMedia?->path) ?? $categoryFallbackImageUrl,
            'image_alt' => $primaryMedia ? ($this->translation($primaryMedia, 'alt_text') ?? $primaryMedia->alt_text ?? $name) : $name,
            'min_price' => Price::decimal($product->variants_min_price),
            'max_price' => Price::decimal($product->variants_max_price),
            'categories' => $product->categories
                ->map(fn (Category $category) => $this->categoryNavItem($category))
                ->values()
                ->all(),
            'is_featured' => $product->is_featured,
        ];
    }

    protected function categoryFallbackImageUrl(?Category $category): ?string
    {
        return CategoryFallbackImages::urlFor($category);
    }

    protected function productCardQuery(): Builder
    {
        return Product::query()
            ->select('products.*')
            ->with(['translations', 'categories.translations', 'categories.primaryMedia', 'primaryMedia.translations'])
            ->withMin(['variants as variants_min_price' => fn (Builder $query) => $query->where('is_active', true)], 'price')
            ->withMax(['variants as variants_max_price' => fn (Builder $query) => $query->where('is_active', true)], 'price')
            ->where('is_active', true);
    }

    protected function orderByPublicCatalogName(Builder $query): Builder
    {
        $locale = $this->locale();
        $nameExpression = 'lower(coalesce(product_locale_names.value, product_default_names.value, products.slug))';

        $query
            ->leftJoin('translations as product_locale_names', function (JoinClause $join) use ($locale): void {
                $join
                    ->on('product_locale_names.translatable_id', '=', 'products.id')
                    ->where('product_locale_names.translatable_type', Product::class)
                    ->where('product_locale_names.locale', $locale)
                    ->where('product_locale_names.field', 'name');
            })
            ->leftJoin('translations as product_default_names', function (JoinClause $join): void {
                $join
                    ->on('product_default_names.translatable_id', '=', 'products.id')
                    ->where('product_default_names.translatable_type', Product::class)
                    ->where('product_default_names.locale', PublicLocale::Default)
                    ->where('product_default_names.field', 'name');
            })
            ->orderByRaw("case when {$nameExpression} like 'l%' then 1 else 0 end");

        if (DB::connection()->getDriverName() === 'pgsql') {
            return $query
                ->orderByRaw("regexp_replace({$nameExpression}, '[0-9].*$', '')")
                ->orderByRaw("nullif(regexp_replace({$nameExpression}, '[^0-9]', '', 'g'), '')::integer asc nulls last")
                ->orderByRaw($nameExpression)
                ->orderBy('products.id');
        }

        $sqliteCatalogNumberExpression = "case when {$nameExpression} glob 'lu[0-9]*' then cast(substr({$nameExpression}, 3) as integer) when {$nameExpression} glob '[a-z][0-9]*' then cast(substr({$nameExpression}, 2) as integer) else null end";

        return $query
            ->orderByRaw("case when {$nameExpression} glob 'lu[0-9]*' then 'lu' when {$nameExpression} glob '[a-z][0-9]*' then substr({$nameExpression}, 1, 1) else {$nameExpression} end")
            ->orderByRaw("case when {$sqliteCatalogNumberExpression} is null then 1 else 0 end")
            ->orderByRaw($sqliteCatalogNumberExpression)
            ->orderByRaw($nameExpression)
            ->orderBy('products.id');
    }

    protected function pageSections(): array
    {
        $sections = PageSection::query()
            ->with('translations')
            ->whereIn('key', ['hero', 'about', 'why_us'])
            ->where('is_active', true)
            ->get()
            ->keyBy('key');

        return [
            'hero' => $this->heroSection($sections->get('hero')),
            'about' => $this->textSection($sections->get('about'), 'Über Goan Perfume'),
            'why_us' => $this->bulletSection($sections->get('why_us'), 'Warum wir'),
        ];
    }

    protected function promotions(): array
    {
        return Promotion::query()
            ->active()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Promotion $promotion) => [
                'id' => $promotion->id,
                'title' => $this->translation($promotion, 'title') ?? '',
                'subtitle' => $this->translation($promotion, 'subtitle') ?? '',
                'badge' => $this->translation($promotion, 'badge'),
                'cta_text' => $this->translation($promotion, 'cta_text'),
            ])
            ->values()
            ->all();
    }

    protected function filterGroups(array $selectedFilters, string $categorySlug): array
    {
        return $this->filterableAttributes()
            ->map(fn (Attribute $attribute) => [
                'id' => $attribute->id,
                'code' => $attribute->code,
                'name' => $this->translation($attribute, 'name') ?? $attribute->code,
                'is_multiple' => $attribute->is_multiple,
                'values' => $attribute->values
                    ->map(fn (AttributeValue $value) => [
                        'id' => $value->id,
                        'slug' => $value->slug,
                        'name' => $this->translation($value, 'name') ?? $value->slug,
                        'selected' => in_array($value->slug, $selectedFilters[$attribute->code] ?? [], true),
                        'href' => $this->filterHref($categorySlug, $selectedFilters, $attribute, $value),
                    ])
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }

    protected function selectedFilters(array $query): array
    {
        $validCodes = $this->filterableAttributes()->pluck('code')->all();

        return collect($query)
            ->only($validCodes)
            ->map(fn (mixed $value) => collect(explode(',', (string) $value))
                ->map(fn (string $slug) => trim($slug))
                ->filter()
                ->unique()
                ->values()
                ->all())
            ->filter(fn (array $values) => $values !== [])
            ->all();
    }

    /**
     * The filterable attributes with their active values, loaded once per
     * request and shared between selectedFilters() and filterGroups().
     *
     * @return EloquentCollection<int, Attribute>
     */
    protected function filterableAttributes(): EloquentCollection
    {
        return $this->filterableAttributes ??= Attribute::query()
            ->with([
                'translations',
                'values' => fn ($query) => $query
                    ->with('translations')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id'),
            ])
            ->where('is_filterable', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    protected function applyFilters(Builder $query, array $selectedFilters): Builder
    {
        foreach ($selectedFilters as $attributeCode => $valueSlugs) {
            foreach ($valueSlugs as $valueSlug) {
                $query->whereHas('attributeValues', fn (Builder $attributeValueQuery) => $attributeValueQuery
                    ->where('slug', $valueSlug)
                    ->whereHas('attribute', fn (Builder $attributeQuery) => $attributeQuery->where('code', $attributeCode)));
            }
        }

        return $query;
    }

    private const SITE_NAME = 'Goan Perfume';

    /**
     * Build the SEO meta block sent to the client. Titles are bare page names
     * — the client-side Inertia title callback (resources/js/app.tsx) appends
     * the brand suffix. Descriptions are squished plain text capped at 160
     * chars. Meta is always generated on the server and never editable by
     * admins.
     *
     * @param  array<string, string>  $alternates
     * @param  array<int, array<string, mixed>>  $structuredData
     * @return array{title: string, description: string, canonical: string, alternates: array<string, string>, structured_data: array<int, array<string, mixed>>, robots: string|null, preload_image_url: string|null, image_url: string|null, og_type: string, og_locale: string}
     */
    protected function meta(
        ?string $title,
        ?string $description,
        ?string $canonical = null,
        array $alternates = [],
        array $structuredData = [],
        ?string $robots = null,
        ?string $preloadImageUrl = null,
        ?string $imageUrl = null,
        string $ogType = 'website',
    ): array {
        $title = $this->cleanMetaText($title) ?? '';

        // For the home page we emit an empty title so the Inertia callback
        // falls back to the brand name alone instead of producing
        // "Goan Perfume - Goan Perfume".
        if ($title === self::SITE_NAME) {
            $title = '';
        }

        $description = $this->cleanMetaText($description)
            ?? $this->defaultMetaDescription();

        return [
            'title' => $title,
            'description' => Str::limit($description, 160, ''),
            'canonical' => $canonical ?? url()->current(),
            'alternates' => $alternates,
            'structured_data' => $structuredData,
            'robots' => $robots,
            'preload_image_url' => $preloadImageUrl,
            'image_url' => $this->absolutePublicUrl($imageUrl ?? $preloadImageUrl),
            'og_type' => $ogType,
            'og_locale' => str_replace('-', '_', PublicLocale::formatterLocale($this->locale())),
        ];
    }

    /**
     * Derive a page's meta from a model's server-generated SEO translations,
     * falling back to its name/description translations.
     *
     * @param  array<string, string>  $alternates
     * @param  array<int, array<string, mixed>>  $structuredData
     * @return array{title: string, description: string, canonical: string, alternates: array<string, string>, structured_data: array<int, array<string, mixed>>, robots: string|null, preload_image_url: string|null, image_url: string|null, og_type: string, og_locale: string}
     */
    protected function modelMeta(
        object $model,
        ?string $descriptionField = 'description',
        ?string $canonical = null,
        array $alternates = [],
        array $structuredData = [],
        ?string $robots = null,
        ?string $preloadImageUrl = null,
        ?string $imageUrl = null,
        string $ogType = 'website',
    ): array {
        $title = $this->cleanMetaText($this->translation($model, 'meta_title'))
            ?? $this->cleanMetaText($this->translation($model, 'name'))
            ?? $this->modelSlug($model);

        $description = $this->cleanMetaText($this->translation($model, 'meta_description'))
            ?? ($descriptionField !== null
                ? $this->cleanMetaText($this->translation($model, $descriptionField))
                : null)
            ?? $this->modelFallbackDescription($title);

        return $this->meta($title, $description, $canonical, $alternates, $structuredData, $robots, $preloadImageUrl, $imageUrl, $ogType);
    }

    /**
     * @param  array<int, array<string, mixed>>  $structuredData
     * @return array{title: string, description: string, canonical: string, alternates: array<string, string>, structured_data: array<int, array<string, mixed>>, robots: string|null, preload_image_url: string|null, image_url: string|null, og_type: string, og_locale: string}
     */
    protected function localizedMeta(
        ?string $title,
        ?string $description,
        string $routeName,
        array $parameters = [],
        array $structuredData = [],
        ?string $robots = null,
        ?string $preloadImageUrl = null,
        ?string $imageUrl = null,
        string $ogType = 'website',
    ): array {
        $urls = $this->localizedRouteUrls($routeName, $parameters);

        return $this->meta(
            $title,
            $description,
            $urls[$this->locale()] ?? url()->current(),
            $urls,
            $structuredData,
            $robots,
            $preloadImageUrl,
            $imageUrl,
            $ogType,
        );
    }

    /**
     * @return array<int, array{id: int, slug: string, name: string, href: string}>
     */
    protected function relatedCategoryNavItems(Category $category, int $limit = 4): array
    {
        return collect($this->navigation())
            ->reject(fn (array $item): bool => $item['slug'] === $category->slug)
            ->take($limit)
            ->values()
            ->all();
    }

    /**
     * @return array<string, string>
     */
    protected function localizedRouteUrls(string $name, array $parameters = []): array
    {
        $urls = collect(PublicLocale::codes())
            ->mapWithKeys(fn (string $locale): array => [
                $locale => route($name, [
                    'locale' => $locale,
                    ...$parameters,
                ]),
            ])
            ->all();

        return [
            ...$urls,
            'x-default' => route($name, [
                'locale' => PublicLocale::Default,
                ...$parameters,
            ]),
        ];
    }

    /**
     * @param  array<int, array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    protected function breadcrumbStructuredData(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)
                ->values()
                ->map(fn (array $item, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $this->cleanMetaText($item['name']) ?? self::SITE_NAME,
                    'item' => $this->absolutePublicUrl($item['url']),
                ])
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function productStructuredData(Product $product, string $canonical): array
    {
        $name = $this->cleanMetaText($this->translation($product, 'name')) ?? $product->slug;
        $description = $this->cleanMetaText($this->translation($product, 'short_description'))
            ?? $this->cleanMetaText($this->translation($product, 'description'))
            ?? $this->modelFallbackDescription($name);
        $primaryCategory = $product->categories->first();
        $brand = $this->cleanMetaText($product->brand);
        $images = $product->media
            ->map(fn (Media $media): ?string => $this->absolutePublicUrl(StorageUrl::for($media->path)))
            ->filter()
            ->values()
            ->all();

        return $this->compactStructuredData([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $name,
            'image' => $images,
            'description' => $description,
            'brand' => $brand ? [
                '@type' => 'Brand',
                'name' => $brand,
            ] : null,
            'category' => $primaryCategory
                ? ($this->cleanMetaText($this->translation($primaryCategory, 'name')) ?? $primaryCategory->slug)
                : null,
            'url' => $canonical,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function compactStructuredData(array $data): array
    {
        return collect($data)
            ->map(function (mixed $value): mixed {
                if (is_array($value)) {
                    return $this->compactStructuredData($value);
                }

                return is_string($value) ? $this->cleanMetaText($value) : $value;
            })
            ->reject(fn (mixed $value): bool => $value === null || $value === '' || $value === [])
            ->all();
    }

    protected function absolutePublicUrl(?string $url): ?string
    {
        if ($url === null || $url === '') {
            return null;
        }

        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        return url($url);
    }

    private function cleanMetaText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = Str::squish(strip_tags($value));

        return $value === '' ? null : $value;
    }

    private function defaultMetaDescription(): string
    {
        return match ($this->locale()) {
            'en' => 'Discover luxury, niche, and Arabic perfumes at Goan Perfume in Kelheim, curated with personal fragrance advice.',
            'ar' => 'اكتشف عطوراً فاخرة ونادرة وعربية لدى Goan Perfume في كيلهايم مع استشارة عطرية شخصية.',
            default => 'Entdecken Sie Luxus-, Nischen- und arabische Parfums bei Goan Perfume in Kelheim mit persönlicher Duftberatung.',
        };
    }

    private function modelFallbackDescription(?string $title): string
    {
        $name = $title !== null && $title !== '' ? $title : self::SITE_NAME;

        return match ($this->locale()) {
            'en' => "Discover {$name} at Goan Perfume: curated fragrances with personal advice in Kelheim.",
            'ar' => "اكتشف {$name} لدى Goan Perfume: عطور مختارة مع استشارة شخصية في كيلهايم.",
            default => "Entdecken Sie {$name} bei Goan Perfume: kuratierte Parfums mit persönlicher Beratung in Kelheim.",
        };
    }

    private function modelSlug(object $model): ?string
    {
        if (! method_exists($model, 'getAttribute')) {
            return null;
        }

        $slug = $model->getAttribute('slug');

        return is_string($slug) ? $slug : null;
    }

    protected function setting(string $key): ?string
    {
        $value = Setting::get($key, '');

        return $value === '' ? null : $value;
    }

    protected function logoUrl(): ?string
    {
        return StorageUrl::for($this->setting('logo_path'));
    }

    protected function locale(): string
    {
        return PublicLocale::normalize(request()->attributes->get('public_locale'));
    }

    protected function translation(object $model, string $field): ?string
    {
        if (! method_exists($model, 'translate')) {
            return null;
        }

        return $model->translate($this->locale(), $field, PublicLocale::Default);
    }

    private function heroSection(?PageSection $section): array
    {
        return [
            'eyebrow' => $section ? ($this->translation($section, 'eyebrow') ?? ($section->payload['eyebrow'] ?? null)) : null,
            'title' => $section ? ($this->translation($section, 'title') ?? 'Goan Perfume') : 'Goan Perfume',
            'body' => $section ? ($this->translation($section, 'body') ?? '') : '',
            'cta_text' => $section ? $this->translation($section, 'cta_text') : null,
            'image_url' => StorageUrl::for($section?->payload['image_path'] ?? null),
            'video_url' => StorageUrl::for($section?->payload['video_path'] ?? null),
        ];
    }

    private function textSection(?PageSection $section, string $fallbackTitle): array
    {
        return [
            'title' => $section ? ($this->translation($section, 'title') ?? $fallbackTitle) : $fallbackTitle,
            'body' => $section ? ($this->translation($section, 'body') ?? '') : '',
        ];
    }

    private function bulletSection(?PageSection $section, string $fallbackTitle): array
    {
        return [
            'title' => $section ? ($this->translation($section, 'title') ?? $fallbackTitle) : $fallbackTitle,
            'items' => PageSection::decodeBulletPoints($section ? $this->translation($section, 'bullet_points') : null),
        ];
    }

    private function whatsappUrl(?string $number): ?string
    {
        if (! $number) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $number);

        return $digits ? "https://wa.me/{$digits}" : null;
    }

    private function filterHref(
        string $categorySlug,
        array $selectedFilters,
        Attribute $attribute,
        AttributeValue $value,
    ): string {
        $next = collect($selectedFilters)
            ->map(fn (array $values) => array_values($values))
            ->all();
        $current = $next[$attribute->code] ?? [];
        $isSelected = in_array($value->slug, $current, true);

        $next[$attribute->code] = $isSelected
            ? array_values(array_filter($current, fn (string $slug) => $slug !== $value->slug))
            : ($attribute->is_multiple ? array_values(array_unique([...$current, $value->slug])) : [$value->slug]);

        if ($next[$attribute->code] === []) {
            unset($next[$attribute->code]);
        }

        $query = collect($next)
            ->filter(fn (array $values) => $values !== [])
            ->map(fn (array $values) => implode(',', $values))
            ->all();

        return route('categories.show', [
            'locale' => $this->locale(),
            'slug' => $categorySlug,
            ...$query,
        ]);
    }
}
