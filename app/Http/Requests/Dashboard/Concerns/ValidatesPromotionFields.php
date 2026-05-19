<?php

namespace App\Http\Requests\Dashboard\Concerns;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
use Illuminate\Contracts\Validation\ValidationRule;

trait ValidatesPromotionFields
{
    use ValidatesTranslatedFields;

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function promotionRules(): array
    {
        return array_merge(
            [
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
}
