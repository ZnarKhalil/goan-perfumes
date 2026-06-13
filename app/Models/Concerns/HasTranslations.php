<?php

namespace App\Models\Concerns;

use App\Models\Translation;
use App\Support\PublicLocale;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTranslations
{
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function translate(string $locale, string $field, ?string $fallbackLocale = null): ?string
    {
        $value = $this->resolveTranslation($locale, $field);

        if ($value !== null) {
            return $value;
        }

        if ($fallbackLocale !== null && $fallbackLocale !== $locale) {
            return $this->resolveTranslation($fallbackLocale, $field);
        }

        return null;
    }

    public function setTranslation(string $locale, string $field, string $value): Translation
    {
        $translation = $this->translations()->updateOrCreate(
            ['locale' => $locale, 'field' => $field],
            ['value' => $value],
        );

        if ($this->relationLoaded('translations')) {
            $this->setRelation(
                'translations',
                $this->translations
                    ->reject(fn (Translation $t) => $t->locale === $locale && $t->field === $field)
                    ->push($translation)
                    ->values(),
            );
        }

        return $translation;
    }

    /**
     * Sync the given translated fields for every public locale: filled values
     * are upserted, blank values delete the stored translation.
     *
     * @param  array<string, array<string, mixed>>  $translationsByLocale
     * @param  array<int, string>  $fields
     */
    public function syncTranslations(array $translationsByLocale, array $fields): void
    {
        foreach (PublicLocale::codes() as $locale) {
            $payload = $translationsByLocale[$locale] ?? [];

            foreach ($fields as $field) {
                $value = $payload[$field] ?? null;

                if ($value === null || $value === '') {
                    $this->translations()
                        ->where('locale', $locale)
                        ->where('field', $field)
                        ->delete();

                    continue;
                }

                $this->setTranslation($locale, $field, (string) $value);
            }
        }
    }

    private function resolveTranslation(string $locale, string $field): ?string
    {
        if ($this->relationLoaded('translations')) {
            return $this->translations
                ->firstWhere(fn (Translation $t) => $t->locale === $locale && $t->field === $field)
                ?->value;
        }

        return $this->translations()
            ->where('locale', $locale)
            ->where('field', $field)
            ->value('value');
    }
}
