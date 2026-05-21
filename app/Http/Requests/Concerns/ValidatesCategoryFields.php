<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ValidatesCategoryFields
{
    use ValidatesTranslatedFields;

    /**
     * The category form sends the string "none" (or an empty value) when no
     * parent is selected. Normalize it to null so the `nullable` rule applies
     * before `integer` is evaluated.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('parent_id')) {
            $parentId = $this->input('parent_id');

            if ($parentId === 'none' || $parentId === '') {
                $this->merge(['parent_id' => null]);
            }
        }
    }

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
     * Slugs and SEO meta are derived on the server from the German name and
     * description; they are never accepted from the request.
     *
     * @param  array<int, int>  $forbiddenParentIds
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function categoryRules(array $forbiddenParentIds = [], ?int $ignoreCategoryId = null): array
    {
        return array_merge(
            [
                'parent_id' => [
                    'nullable',
                    'integer',
                    'exists:categories,id',
                    Rule::notIn($forbiddenParentIds),
                ],
                'sort_order' => [
                    'nullable',
                    'integer',
                    'min:0',
                    Rule::unique('categories', 'sort_order')->ignore($ignoreCategoryId),
                ],
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
