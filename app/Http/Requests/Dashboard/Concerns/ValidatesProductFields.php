<?php

namespace App\Http\Requests\Dashboard\Concerns;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

trait ValidatesProductFields
{
    use ValidatesTranslatedFields;

    private const MAX_FEATURED_PRODUCTS = 4;

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function productRules(ValidationRule|array|string $slugRule): array
    {
        return array_merge(
            [
                'slug' => $slugRule,
                'brand' => ['nullable', 'string', 'max:255'],
                'is_active' => ['required', 'boolean'],
                'is_featured' => ['required', 'boolean'],
                'categories' => ['required', 'array', 'min:1'],
                'categories.*' => ['integer', 'exists:categories,id'],
                'attribute_values' => ['nullable', 'array'],
                'attribute_values.*' => ['integer', 'exists:attribute_values,id'],
                'variants' => ['required', 'array', 'min:1'],
                'variants.*.id' => ['nullable', 'integer', 'exists:product_variants,id'],
                'variants.*.size_ml' => ['required', 'integer', 'min:1', 'max:1000'],
                'variants.*.price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
                'variants.*.compare_at_price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
                'variants.*.is_default' => ['required', 'boolean'],
                'variants.*.is_active' => ['required', 'boolean'],
                'media_uploads' => ['nullable', 'array'],
                'media_uploads.*' => ['image', 'max:5120'],
                'media_meta' => ['nullable', 'array'],
                'media_meta.existing' => ['nullable', 'array'],
                'media_meta.existing.*.id' => ['required', 'integer', 'exists:media,id'],
                'media_meta.existing.*.sort_order' => ['nullable', 'integer', 'min:0'],
                'media_meta.existing.*.is_primary' => ['nullable', 'boolean'],
                'media_meta.existing.*.alt_text' => ['nullable', 'array'],
                'media_meta.new' => ['nullable', 'array'],
                'media_meta.new.*.sort_order' => ['nullable', 'integer', 'min:0'],
                'media_meta.new.*.is_primary' => ['nullable', 'boolean'],
                'media_meta.new.*.alt_text' => ['nullable', 'array'],
                'media_meta.removed' => ['nullable', 'array'],
                'media_meta.removed.*' => ['integer'],
            ],
            $this->translationRules(
                requiredLocale: 'de',
                requiredOn: ['name'],
                fields: ['name', 'short_description', 'description', 'meta_title', 'meta_description'],
                lengths: [
                    'name' => 255,
                    'short_description' => 1000,
                    'description' => 8000,
                    'meta_title' => 255,
                    'meta_description' => 500,
                ],
            ),
        );
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $this->validateDefaultVariant($validator);
                $this->validateActiveVariant($validator);
                $this->validateSingleSelectAttributeValues($validator);
                $this->validateVariantOwnership($validator);
                $this->validateMediaOwnership($validator);
                $this->validateFeaturedLimit($validator);
            },
        ];
    }

    protected function slugUniqueRule(?Product $product = null): array
    {
        $rule = Rule::unique('products', 'slug');

        if ($product instanceof Product) {
            $rule->ignore($product->id);
        }

        return ['nullable', 'string', 'max:255', $rule];
    }

    private function validateDefaultVariant(Validator $validator): void
    {
        $defaultCount = collect($this->input('variants', []))
            ->filter(fn (array $variant) => filter_var($variant['is_default'] ?? false, FILTER_VALIDATE_BOOLEAN))
            ->count();

        if ($defaultCount !== 1) {
            $validator->errors()->add('variants', 'Genau eine Variante muss als Standard markiert sein.');
        }
    }

    private function validateActiveVariant(Validator $validator): void
    {
        if (! filter_var($this->input('is_active'), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        $hasActiveVariant = collect($this->input('variants', []))
            ->contains(fn (array $variant) => filter_var($variant['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN));

        if (! $hasActiveVariant) {
            $validator->errors()->add('variants', 'Aktive Produkte benötigen mindestens eine aktive Variante.');
        }
    }

    private function validateSingleSelectAttributeValues(Validator $validator): void
    {
        $ids = collect($this->input('attribute_values', []))
            ->filter()
            ->map(fn (mixed $id) => (int) $id)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return;
        }

        AttributeValue::query()
            ->with('attribute')
            ->whereIn('id', $ids)
            ->get()
            ->groupBy('attribute_id')
            ->each(function ($values) use ($validator): void {
                $attribute = $values->first()?->attribute;

                if ($attribute !== null && ! $attribute->is_multiple && $values->count() > 1) {
                    $name = $attribute->translate('de', 'name') ?? $attribute->code;
                    $validator->errors()->add('attribute_values', "Für {$name} darf nur ein Wert ausgewählt werden.");
                }
            });
    }

    private function validateVariantOwnership(Validator $validator): void
    {
        $product = $this->route('product');

        if (! $product instanceof Product) {
            return;
        }

        $ids = collect($this->input('variants', []))
            ->pluck('id')
            ->filter()
            ->map(fn (mixed $id) => (int) $id)
            ->values();

        if ($ids->isEmpty()) {
            return;
        }

        $ownedCount = ProductVariant::query()
            ->where('product_id', $product->id)
            ->whereKey($ids)
            ->count();

        if ($ownedCount !== $ids->count()) {
            $validator->errors()->add('variants', 'Mindestens eine Variante gehört nicht zu diesem Produkt.');
        }
    }

    private function validateMediaOwnership(Validator $validator): void
    {
        $product = $this->route('product');

        if (! $product instanceof Product) {
            return;
        }

        $ids = collect($this->input('media_meta.existing', []))
            ->pluck('id')
            ->merge($this->input('media_meta.removed', []))
            ->filter()
            ->map(fn (mixed $id) => (int) $id)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return;
        }

        $ownedCount = $product->media()
            ->whereKey($ids)
            ->count();

        if ($ownedCount !== $ids->count()) {
            $validator->errors()->add('media_meta', 'Mindestens ein Bild gehört nicht zu diesem Produkt.');
        }
    }

    private function validateFeaturedLimit(Validator $validator): void
    {
        if (! filter_var($this->input('is_featured'), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        $product = $this->route('product');
        $featuredCount = Product::query()
            ->where('is_featured', true)
            ->when(
                $product instanceof Product,
                fn ($query) => $query->whereKeyNot($product->id),
            )
            ->count();

        if ($featuredCount >= self::MAX_FEATURED_PRODUCTS) {
            $validator->errors()->add(
                'is_featured',
                'Es sind bereits 4 Highlights ausgewählt. Entferne zuerst ein Highlight, um ein neues hinzuzufügen.',
            );
        }
    }
}
