<?php

namespace App\Http\Requests\Dashboard\Concerns;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
use App\Models\Promotion;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ValidatesPromotionFields
{
    use ValidatesTranslatedFields;

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function promotionRules(ValidationRule|array|string $slugRule): array
    {
        return array_merge(
            [
                'slug' => $slugRule,
                'background_image' => ['nullable', 'image', 'max:5120'],
                'remove_background_image' => ['nullable', 'boolean'],
                'background_color' => ['nullable', 'string', 'max:20'],
                'link_url' => ['nullable', 'string', 'max:2048'],
                'promo_code' => ['nullable', 'string', 'max:100'],
                'discount_percent' => ['nullable', 'integer', 'min:1', 'max:100'],
                'starts_at' => ['nullable', 'date'],
                'ends_at' => ['nullable', 'date', 'after:starts_at'],
                'sort_order' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['required', 'boolean'],
            ],
            $this->translationRules(
                requiredLocale: 'de',
                requiredOn: ['title'],
                fields: ['badge', 'title', 'subtitle', 'cta_text'],
                lengths: [
                    'badge' => 120,
                    'title' => 255,
                    'subtitle' => 500,
                    'cta_text' => 120,
                ],
            ),
        );
    }

    protected function slugUniqueRule(?Promotion $promotion = null): array
    {
        $rule = Rule::unique('promotions', 'slug');

        if ($promotion instanceof Promotion) {
            $rule->ignore($promotion->id);
        }

        return ['nullable', 'string', 'max:255', $rule];
    }
}
