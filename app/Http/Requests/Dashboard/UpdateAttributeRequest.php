<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeRequest extends FormRequest
{
    use ValidatesTranslatedFields;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            [
                'code' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9_-]+$/',
                    Rule::unique('attributes', 'code')->ignore($this->route('attribute')),
                ],
                'sort_order' => ['nullable', 'integer', 'min:0'],
                'is_filterable' => ['required', 'boolean'],
                'is_multiple' => ['required', 'boolean'],
            ],
            $this->translationRules(
                requiredLocale: 'de',
                requiredOn: ['name'],
                fields: ['name'],
                lengths: ['name' => 255],
            ),
        );
    }
}
