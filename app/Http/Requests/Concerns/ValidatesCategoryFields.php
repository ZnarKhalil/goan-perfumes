<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ValidatesCategoryFields
{
    use ValidatesTranslatedFields;

    /**
     * Slugs and SEO meta are derived on the server from the German name and
     * description; they are never accepted from the request.
     *
     * @param  array<int, int>  $forbiddenParentIds
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function categoryRules(array $forbiddenParentIds = []): array
    {
        return array_merge(
            [
                'parent_id' => [
                    'nullable',
                    'integer',
                    'exists:categories,id',
                    Rule::notIn($forbiddenParentIds),
                ],
                'sort_order' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['required', 'boolean'],
                'image' => ['nullable', 'image', 'max:5120'],
                'remove_image' => ['nullable', 'boolean'],
            ],
            $this->translationRules(
                requiredLocale: 'de',
                requiredOn: ['name'],
                fields: ['name', 'description'],
                lengths: [
                    'name' => 255,
                    'description' => 5000,
                ],
            ),
        );
    }
}
