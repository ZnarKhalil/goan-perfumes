<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Set on the model (transiently) by callers before save when the slug
     * should be auto-generated from a German name. Cleared after the slug is
     * resolved so a re-save doesn't re-derive it.
     */
    protected ?string $slugSource = null;

    public function setSlugSource(string $source): static
    {
        $this->slugSource = $source;

        return $this;
    }

    public static function bootHasSlug(): void
    {
        static::saving(function (Model $model): void {
            if (! empty($model->slug)) {
                return;
            }

            if (empty($model->slugSource)) {
                return;
            }

            $model->slug = static::generateUniqueSlug($model->slugSource, $model);
            $model->slugSource = null;
        });
    }

    private static function generateUniqueSlug(string $source, Model $model): string
    {
        $base = Str::slug($source, '-', 'de');

        if ($base === '') {
            $base = 'item';
        }

        $slug = $base;
        $suffix = 2;

        while (static::slugExists($slug, $model)) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    private static function slugExists(string $slug, Model $model): bool
    {
        $query = static::query()->where('slug', $slug);

        if ($model->exists) {
            $query->whereKeyNot($model->getKey());
        }

        return $query->exists();
    }
}
