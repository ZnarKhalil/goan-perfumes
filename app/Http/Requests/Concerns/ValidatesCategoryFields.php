<?php

namespace App\Http\Requests\Concerns;

use App\Models\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
                'media_uploads' => ['nullable', 'array'],
                'media_uploads.*' => ['image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
                'media_meta' => ['nullable', 'array'],
                'media_meta.existing' => ['nullable', 'array'],
                'media_meta.existing.*.id' => ['required', 'integer', 'exists:media,id'],
                'media_meta.existing.*.sort_order' => ['nullable', 'integer', 'min:0'],
                'media_meta.existing.*.is_primary' => ['nullable', 'boolean'],
                'media_meta.new' => ['nullable', 'array'],
                'media_meta.new.*.sort_order' => ['nullable', 'integer', 'min:0'],
                'media_meta.new.*.is_primary' => ['nullable', 'boolean'],
                'media_meta.removed' => ['nullable', 'array'],
                'media_meta.removed.*' => ['integer'],
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

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $this->validateMediaOwnership($validator);
            },
        ];
    }

    private function validateMediaOwnership(Validator $validator): void
    {
        $category = $this->route('category');

        if (! $category instanceof Category) {
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

        $ownedCount = $category->media()
            ->whereKey($ids)
            ->count();

        if ($ownedCount !== $ids->count()) {
            $validator->errors()->add('media_meta', 'Mindestens ein Bild gehört nicht zu dieser Kategorie.');
        }
    }
}
