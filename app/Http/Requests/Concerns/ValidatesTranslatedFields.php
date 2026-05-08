<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;

trait ValidatesTranslatedFields
{
    /**
     * Build validation rules for a `translations.{locale}.{field}` payload.
     *
     * Fields listed in $requiredOn must be filled in $requiredLocale; everything
     * else (other fields on the required locale, or any field on other locales)
     * is nullable. All values are bound by the per-field length in $lengths.
     *
     * @param  array<int, string>  $requiredOn
     * @param  array<int, string>  $fields
     * @param  array<string, int>  $lengths
     * @param  array<int, string>  $locales
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function translationRules(
        string $requiredLocale,
        array $requiredOn,
        array $fields,
        array $lengths,
        array $locales = ['de', 'ar', 'en'],
    ): array {
        $rules = ['translations' => ['array']];

        foreach ($locales as $locale) {
            $rules["translations.{$locale}"] = ['array'];
            foreach ($fields as $field) {
                $required = $locale === $requiredLocale && in_array($field, $requiredOn, true);
                $rules["translations.{$locale}.{$field}"] = [
                    $required ? 'required' : 'nullable',
                    'string',
                    'max:'.($lengths[$field] ?? 255),
                ];
            }
        }

        return $rules;
    }
}
