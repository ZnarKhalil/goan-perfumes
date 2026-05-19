<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Concerns\ValidatesCategoryFields;
use App\Models\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    use ValidatesCategoryFields;

    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->categoryRules(
            forbiddenParentIds: $this->forbiddenParentIds(),
        );
    }

    /**
     * @return array<int, int>
     */
    private function forbiddenParentIds(): array
    {
        $category = $this->route('category');

        if (! $category instanceof Category) {
            return [];
        }

        $ids = [$category->id];
        $frontier = [$category->id];

        while ($frontier !== []) {
            $children = Category::query()
                ->whereIn('parent_id', $frontier)
                ->pluck('id')
                ->all();

            $frontier = array_values(array_diff($children, $ids));
            $ids = array_merge($ids, $frontier);
        }

        return $ids;
    }
}
