<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Concerns\ValidatesTranslatedFields;
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
     * The slug is derived on the server from the German name and is never
     * accepted from the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            [
                'sort_order' => [
                    'nullable',
                    'integer',
                    'min:0',
                    Rule::unique('attribute_values', 'sort_order')
                        ->where('attribute_id', $this->route('attribute')?->id),
                ],
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

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sort_order.unique' => 'Diese Reihenfolge ist innerhalb dieses Attributs bereits vergeben. Bitte wähle eine andere.',
        ];
    }
}
