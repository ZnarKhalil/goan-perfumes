<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $products = PerfumeCatalog::products();

        Product::query()
            ->whereNotIn('slug', collect($products)->pluck('slug')->all())
            ->with(['translations', 'media.translations'])
            ->each(fn (Product $product) => $this->deleteProduct($product));

        $categories = Category::query()
            ->whereIn('slug', $this->categorySlugs($products))
            ->get()
            ->keyBy('slug');

        $attributeValues = AttributeValue::query()
            ->with('attribute')
            ->get()
            ->keyBy(fn (AttributeValue $value) => "{$value->attribute->code}.{$value->slug}");

        foreach ($products as $index => $productData) {
            $product = Product::query()->updateOrCreate(
                ['slug' => $productData['slug']],
                [
                    'brand' => null,
                    'is_active' => true,
                    'is_featured' => $index < 4,
                ],
            );

            $this->syncTranslations($product, $productData['translations']);

            $product->categories()->sync(
                $categories
                    ->filter(fn (Category $category): bool => in_array($category->slug, $productData['categories'], true))
                    ->pluck('id'),
            );

            $product->attributeValues()->sync($this->attributeValueIds($attributeValues, $productData['attributes']));

            $this->seedVariants($product, $productData['variants']);
            $this->deleteMedia($product);
        }
    }

    /**
     * @param  list<array{categories: list<string>}>  $products
     * @return list<string>
     */
    private function categorySlugs(array $products): array
    {
        return collect($products)
            ->flatMap(fn (array $product): array => $product['categories'])
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, AttributeValue>  $attributeValues
     * @param  array<string, list<string>>  $attributes
     * @return list<int>
     */
    private function attributeValueIds($attributeValues, array $attributes): array
    {
        $ids = [];

        foreach ($attributes as $code => $slugs) {
            foreach ($slugs as $slug) {
                $value = $attributeValues["{$code}.{$slug}"] ?? null;

                if ($value === null) {
                    throw new RuntimeException("Attribute value '{$code}.{$slug}' must be seeded before products.");
                }

                $ids[] = $value->id;
            }
        }

        return $ids;
    }

    /**
     * @param  list<array{size_ml: int, price: string, compare_at_price: string|null, is_default: bool}>  $variants
     */
    private function seedVariants(Product $product, array $variants): void
    {
        $seededSizes = [];

        foreach ($variants as $variant) {
            $seededSizes[] = $variant['size_ml'];

            ProductVariant::query()->updateOrCreate(
                ['product_id' => $product->id, 'size_ml' => $variant['size_ml']],
                [
                    'price' => $variant['price'],
                    'compare_at_price' => $variant['compare_at_price'],
                    'is_default' => $variant['is_default'],
                    'is_active' => true,
                ],
            );
        }

        $product->variants()
            ->whereNotIn('size_ml', $seededSizes)
            ->delete();
    }

    /**
     * @param  array<string, array{name: string, short_description: string, description: string}>  $translations
     */
    private function syncTranslations(Product $product, array $translations): void
    {
        $allowed = [];

        foreach ($translations as $locale => $fields) {
            foreach (['name', 'short_description', 'description'] as $field) {
                if ($fields[$field] === '') {
                    continue;
                }

                $product->setTranslation($locale, $field, $fields[$field]);
                $allowed[] = "{$locale}.{$field}";
            }

            $name = $fields['name'];
            $excerpt = $fields['short_description'] ?: $fields['description'];

            if ($name !== '') {
                $product->setTranslation($locale, 'meta_title', $name);
                $allowed[] = "{$locale}.meta_title";
            }

            if ($excerpt !== '') {
                $product->setTranslation(
                    $locale,
                    'meta_description',
                    Str::limit(Str::squish(strip_tags($excerpt)), 160, ''),
                );
                $allowed[] = "{$locale}.meta_description";
            }
        }

        $product->translations()
            ->whereNotIn('locale', array_keys($translations))
            ->delete();

        $product->translations()
            ->get()
            ->reject(fn (Translation $translation): bool => in_array("{$translation->locale}.{$translation->field}", $allowed, true))
            ->each->delete();
    }

    private function deleteProduct(Product $product): void
    {
        $this->deleteMedia($product);
        $product->translations()->delete();
        $product->delete();
    }

    private function deleteMedia(Product $product): void
    {
        $product->media()
            ->with('translations')
            ->get()
            ->each(function (Media $media): void {
                $media->translations()->delete();
                $media->delete();
            });
    }
}
