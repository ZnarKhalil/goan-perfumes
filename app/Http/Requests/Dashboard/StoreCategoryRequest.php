<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Concerns\ValidatesCategoryFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            slugRule: ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')],
        );
    }
}
