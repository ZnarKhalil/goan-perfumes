<?php

namespace App\Http\Controllers\Public;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Support\Price;
use App\Support\StorageUrl;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends PublicController
{
    public function show(string $locale, string $slug): Response
    {
        $product = Product::query()
            ->with([
                'translations',
                'categories.translations',
                'categories.primaryMedia',
                'media' => fn ($query) => $query
                    ->with('translations')
                    ->orderByDesc('is_primary')
                    ->orderBy('sort_order')
                    ->orderBy('id'),
                'variants' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('size_ml')
                    ->orderBy('id'),
                'attributeValues' => fn ($query) => $query
                    ->with(['translations', 'attribute.translations'])
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id'),
            ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        $canonical = route('products.show', [
            'locale' => $this->locale(),
            'slug' => $product->slug,
        ]);
        $primaryCategory = $product->categories->first();
        $primaryMedia = $product->media->firstWhere('is_primary', true) ?? $product->media->first();
        $preloadImageUrl = StorageUrl::for($primaryMedia?->path)
            ?? $this->categoryFallbackImageUrl($primaryCategory);

        return Inertia::render('public/product', [
            ...$this->layoutProps(),
            'meta' => $this->modelMeta(
                $product,
                'short_description',
                $canonical,
                $this->localizedRouteUrls('products.show', ['slug' => $product->slug]),
                [
                    $this->productStructuredData($product, $canonical),
                    $this->breadcrumbStructuredData([
                        [
                            'name' => 'Goan Perfume',
                            'url' => route('home', ['locale' => $this->locale()]),
                        ],
                        ...($primaryCategory ? [[
                            'name' => $this->translation($primaryCategory, 'name') ?? $primaryCategory->slug,
                            'url' => route('categories.show', [
                                'locale' => $this->locale(),
                                'slug' => $primaryCategory->slug,
                            ]),
                        ]] : []),
                        [
                            'name' => $this->translation($product, 'name') ?? $product->slug,
                            'url' => $canonical,
                        ],
                    ]),
                ],
                preloadImageUrl: $preloadImageUrl,
                ogType: 'product',
            ),
            'product' => $this->productDetail($product),
        ]);
    }

    private function productDetail(Product $product): array
    {
        $name = $this->translation($product, 'name') ?? $product->slug;
        $primaryCategory = $product->categories->first();
        $media = $product->media
            ->map(fn (Media $media) => [
                'id' => $media->id,
                'url' => StorageUrl::for($media->path),
                'alt' => $this->translation($media, 'alt_text') ?? $media->alt_text ?? $name,
                'is_primary' => $media->is_primary,
            ])
            ->values()
            ->all();

        if ($media === [] && ($fallbackImageUrl = $this->categoryFallbackImageUrl($primaryCategory)) !== null) {
            $media[] = [
                'id' => 0,
                'url' => $fallbackImageUrl,
                'alt' => $name,
                'is_primary' => true,
            ];
        }

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $name,
            'brand' => $product->brand,
            'short_description' => $this->translation($product, 'short_description') ?? '',
            'description' => $this->translation($product, 'description') ?? '',
            'media' => $media,
            'variants' => $product->variants
                ->map(fn (ProductVariant $variant) => [
                    'id' => $variant->id,
                    'size' => "{$variant->size_ml} ml",
                    'price' => Price::decimal($variant->price),
                    'compare_at_price' => Price::decimal($variant->compare_at_price),
                    'is_default' => $variant->is_default,
                ])
                ->values()
                ->all(),
            'attribute_groups' => $this->attributeGroups($product),
            'categories' => $product->categories
                ->map(fn (Category $category) => $this->categoryNavItem($category))
                ->values()
                ->all(),
            'primary_category' => $primaryCategory
                ? $this->categoryNavItem($primaryCategory)
                : null,
        ];
    }

    private function attributeGroups(Product $product): array
    {
        return $product->attributeValues
            ->groupBy(fn (AttributeValue $value) => $value->attribute_id)
            ->map(function ($values) {
                /** @var AttributeValue $first */
                $first = $values->first();
                /** @var Attribute $attribute */
                $attribute = $first->attribute;

                return [
                    'code' => $attribute->code,
                    'name' => $this->translation($attribute, 'name') ?? $attribute->code,
                    'values' => $values
                        ->map(fn (AttributeValue $value) => [
                            'id' => $value->id,
                            'group_code' => $attribute->code,
                            'group_name' => $this->translation($attribute, 'name') ?? $attribute->code,
                            'slug' => $value->slug,
                            'name' => $this->translation($value, 'name') ?? $value->slug,
                        ])
                        ->values()
                        ->all(),
                ];
            })
            ->values()
            ->all();
    }
}
