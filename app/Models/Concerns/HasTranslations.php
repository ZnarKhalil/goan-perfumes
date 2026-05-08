<?php

namespace App\Models\Concerns;

use App\Models\Translation;
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
                $this->translations()->getResults(),
            );
        }

        return $translation;
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
