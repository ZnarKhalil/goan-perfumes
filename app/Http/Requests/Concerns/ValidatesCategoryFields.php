<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ValidatesCategoryFields
{
    use ValidatesTranslatedFields;

    /**
     * @param  array<int, ValidationRule|array<mixed>|string>  $slugRule
     * @param  array<int, int>  $forbiddenParentIds
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function categoryRules(array $slugRule, array $forbiddenParentIds = []): array
    {
        return array_merge(
            [
                'slug' => $slugRule,
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
                fields: ['name', 'description', 'meta_title', 'meta_description'],
                lengths: [
                    'name' => 255,
                    'description' => 5000,
                    'meta_title' => 255,
                    'meta_description' => 500,
                ],
            ),
        );
    }
}
