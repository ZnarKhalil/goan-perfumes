<?php

namespace App\Http\Requests\Dashboard\Concerns;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ValidatesPromotionFields
{
    use ValidatesTranslatedFields;

    /**
     * German error messages for the rules that aren't self-explanatory.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sort_order.unique' => 'Diese Reihenfolge ist bereits vergeben. Bitte wähle eine andere.',
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function promotionRules(?int $ignorePromotionId = null): array
    {
        return array_merge(
            [
                'starts_at' => ['nullable', 'date'],
                'ends_at' => ['nullable', 'date', 'after:starts_at'],
                'sort_order' => [
                    'nullable',
                    'integer',
                    'min:0',
                    Rule::unique('promotions', 'sort_order')->ignore($ignorePromotionId),
                ],
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
