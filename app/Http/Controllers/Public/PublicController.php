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
use App\Support\PublicLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class PublicController extends Controller
{
    protected const CATEGORY_SLUGS = [
        'luxusparfums',
        'nischenparfums',
        'designerparfums',
        'arabische-parfums',
        'damenparfums',
        'herrenparfums',
        'unisex-parfums',
    ];

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
        return Category::query()
            ->with('translations')
            ->whereIn('slug', self::CATEGORY_SLUGS)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Category $category) => $this->categoryNavItem($category))
            ->values()
            ->all();
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
            'image_url' => $this->storageUrl($category->image_path),
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

    protected function productCard(Product $product): array
    {
        /** @var Media|null $primaryMedia */
        $primaryMedia = $product->primaryMedia;
        $name = $this->translation($product, 'name') ?? $product->slug;

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'href' => route('products.show', [
                'locale' => $this->locale(),
                'slug' => $product->slug,
            ]),
            'name' => $name,
            'brand' => $product->brand,
            'image_url' => $this->storageUrl($primaryMedia?->path),
            'image_alt' => $primaryMedia ? ($this->translation($primaryMedia, 'alt_text') ?? $primaryMedia->alt_text ?? $name) : $name,
            'min_price' => $this->decimal($product->variants_min_price),
            'max_price' => $this->decimal($product->variants_max_price),
            'categories' => $product->categories
                ->map(fn (Category $category) => $this->categoryNavItem($category))
                ->values()
                ->all(),
            'is_featured' => $product->is_featured,
        ];
    }

    protected function productCardQuery(): Builder
    {
        return Product::query()
            ->with(['translations', 'categories.translations', 'primaryMedia.translations'])
            ->withMin(['variants as variants_min_price' => fn (Builder $query) => $query->where('is_active', true)], 'price')
            ->withMax(['variants as variants_max_price' => fn (Builder $query) => $query->where('is_active', true)], 'price')
            ->where('is_active', true);
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
        return Attribute::query()
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
            ->get()
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
        $validCodes = Attribute::query()
            ->where('is_filterable', true)
            ->pluck('code')
            ->all();

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

    protected function applyFilters(Builder $query, array $selectedFilters): Builder
    {
        foreach ($selectedFilters as $attributeCode => $valueSlugs) {
            $query->whereHas('attributeValues', fn (Builder $attributeValueQuery) => $attributeValueQuery
                ->whereIn('slug', $valueSlugs)
                ->whereHas('attribute', fn (Builder $attributeQuery) => $attributeQuery->where('code', $attributeCode)));
        }

        return $query;
    }

    protected function storageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::url($path);
    }

    protected function decimal(mixed $value): ?string
    {
        return $value === null ? null : number_format((float) $value, 2, '.', '');
    }

    private const SITE_NAME = 'Goan Perfume';

    /**
     * Build the SEO meta block sent to the client. Titles get the brand
     * suffix; descriptions are squished plain text capped at 160 chars.
     * Meta is always generated on the server and never editable by admins.
     *
     * @return array{title: string, description: string}
     */
    protected function meta(?string $title, ?string $description): array
    {
        $title = trim((string) $title);
        $fullTitle = $title === '' || $title === self::SITE_NAME
            ? self::SITE_NAME
            : "{$title} – ".self::SITE_NAME;

        $description = Str::squish(strip_tags((string) $description));

        if ($description === '') {
            $description = 'Ausgewählte Luxus-, Nischen- und arabische Parfums, kuratiert von '.self::SITE_NAME.'.';
        }

        return [
            'title' => $fullTitle,
            'description' => Str::limit($description, 160, ''),
        ];
    }

    /**
     * Derive a page's meta from a model's server-generated SEO translations,
     * falling back to its name/description translations.
     *
     * @return array{title: string, description: string}
     */
    protected function modelMeta(object $model, ?string $descriptionField = 'description'): array
    {
        $title = $this->translation($model, 'meta_title')
            ?? $this->translation($model, 'name');

        $description = $this->translation($model, 'meta_description')
            ?? ($descriptionField !== null ? $this->translation($model, $descriptionField) : null);

        return $this->meta($title, $description);
    }

    protected function setting(string $key): ?string
    {
        $value = Setting::get($key, '');

        return $value === '' ? null : $value;
    }

    protected function logoUrl(): ?string
    {
        return $this->storageUrl($this->setting('logo_path'));
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
            'image_url' => $this->storageUrl($section?->payload['image_path'] ?? null),
            'video_url' => $this->storageUrl($section?->payload['video_path'] ?? null),
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
            'items' => $this->decodeBulletPoints($section ? $this->translation($section, 'bullet_points') : null),
        ];
    }

    /**
     * @return array<int, string>
     */
    private function decodeBulletPoints(?string $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded)
            ? array_values(array_filter($decoded, is_string(...)))
            : [];
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
