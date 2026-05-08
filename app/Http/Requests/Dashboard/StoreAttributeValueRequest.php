<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
use App\Models\Attribute;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttributeValueRequest extends FormRequest
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
        $attribute = $this->route('attribute');

        return array_merge(
            [
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('attribute_values', 'slug')
                        ->where('attribute_id', $attribute instanceof Attribute ? $attribute->id : null),
                ],
                'sort_order' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['required', 'boolean'],
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
