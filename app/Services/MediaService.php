<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Product;
use App\Support\ImageUpload;
use App\Support\PublicLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

class MediaService
{
    /**
     * Sync uploaded and existing media rows for a saved model.
     *
     * Expected $meta shape:
     * [
     *   'existing' => [
     *     ['id' => 1, 'sort_order' => 0, 'is_primary' => true],
     *   ],
     *   'new' => [
     *     ['sort_order' => 1, 'is_primary' => false],
     *   ],
     *   'removed' => [2, 3],
     * ]
     *
     * @param  array<int, UploadedFile>  $uploads
     * @param  array{existing?: array<int, array<string, mixed>>, new?: array<int, array<string, mixed>>, removed?: array<int, int|string>}  $meta
     */
    public function syncFromRequest(
        Model $model,
        array $uploads,
        array $meta,
        string $disk = 'public',
    ): void {
        if (! method_exists($model, 'media')) {
            throw new InvalidArgumentException('The given model must define a media() relationship.');
        }

        if (! $model->exists) {
            throw new InvalidArgumentException('Media can only be synced for saved models.');
        }

        $removedIds = $this->normalizeIds($meta['removed'] ?? []);
        $this->deleteRemoved($model, $removedIds, $disk);

        $primaryAssigned = false;
        $storedPaths = [];

        try {
            foreach ($meta['existing'] ?? [] as $item) {
                $media = $model->media()
                    ->whereKey($item['id'] ?? null)
                    ->first();

                if (! $media instanceof Media) {
                    continue;
                }

                $isPrimary = $this->boolean($item['is_primary'] ?? false) && ! $primaryAssigned;
                $primaryAssigned = $primaryAssigned || $isPrimary;

                $media->update([
                    'sort_order' => (int) ($item['sort_order'] ?? $media->sort_order),
                    'is_primary' => $isPrimary,
                    'alt_text' => $this->altTextFor($model, $item['alt_text'] ?? null),
                ]);

                $this->syncAltTextTranslations($media, $model, $item['alt_text'] ?? []);
            }

            foreach ($uploads as $index => $upload) {
                $item = $meta['new'][$index] ?? [];
                $isPrimary = $this->boolean($item['is_primary'] ?? false) && ! $primaryAssigned;
                $primaryAssigned = $primaryAssigned || $isPrimary;

                $path = $this->storeUpload($model, $upload, $disk, $item, $index);
                $storedPaths[] = $path;

                $media = $model->media()->create([
                    'path' => $path,
                    'sort_order' => (int) ($item['sort_order'] ?? $index),
                    'is_primary' => $isPrimary,
                    'alt_text' => $this->altTextFor($model, $item['alt_text'] ?? null),
                ]);

                $this->syncAltTextTranslations($media, $model, $item['alt_text'] ?? []);
            }

            $this->ensurePrimary($model);
        } catch (Throwable $exception) {
            // The surrounding transaction rolls the rows back; remove the
            // files stored in this call so they don't linger as orphans.
            Storage::disk($disk)->delete($storedPaths);

            throw $exception;
        }
    }

    /**
     * @param  array<int, int|string>  $ids
     * @return array<int, int>
     */
    private function normalizeIds(array $ids): array
    {
        return collect($ids)
            ->filter(fn (int|string $id) => $id !== '')
            ->map(fn (int|string $id) => (int) $id)
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  array<int, int>  $removedIds
     */
    private function deleteRemoved(Model $model, array $removedIds, string $disk): void
    {
        if ($removedIds === []) {
            return;
        }

        $model->media()
            ->whereKey($removedIds)
            ->get()
            ->each(function (Media $media) use ($disk): void {
                $media->translations()->delete();
                $media->delete();

                // Only remove the file once the surrounding transaction has
                // committed; a rollback must not leave rows without files.
                DB::afterCommit(fn () => Storage::disk($disk)->delete($media->path));
            });
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function storeUpload(Model $model, UploadedFile $upload, string $disk, array $item = [], int $index = 0): string
    {
        if ($model instanceof Product) {
            return ImageUpload::storePublicImageAsWebp(
                $upload,
                $this->directoryFor($model),
                $this->descriptiveProductImageName($model, $item, $index),
                $disk,
            );
        }

        $extension = $upload->extension() ?: $upload->guessExtension() ?: 'bin';

        return $upload->storeAs(
            $this->directoryFor($model),
            Str::ulid()->toBase32().'.'.$extension,
            $disk,
        );
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function descriptiveProductImageName(Product $product, array $item, int $index): string
    {
        return collect([
            $product->slug,
            $this->generatedProductAltText($product, PublicLocale::Default),
            (string) ($index + 1),
        ])
            ->filter(fn (?string $part): bool => filled($part))
            ->implode(' ');
    }

    private function directoryFor(Model $model): string
    {
        return 'media/'
            .Str::of(class_basename($model))->kebab()->plural()
            .'/'.$model->getKey();
    }

    /**
     * @param  mixed  $value
     */
    private function boolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param  mixed  $altText
     */
    private function altTextFallback($altText): ?string
    {
        if (! is_array($altText)) {
            return filled($altText) ? (string) $altText : null;
        }

        foreach (PublicLocale::codes() as $locale) {
            if (filled($altText[$locale] ?? null)) {
                return (string) $altText[$locale];
            }
        }

        return null;
    }

    /**
     * @param  mixed  $altText
     */
    private function altTextFor(Model $model, $altText): ?string
    {
        if ($model instanceof Product) {
            return $this->generatedProductAltText($model, PublicLocale::Default);
        }

        return $this->altTextFallback($altText);
    }

    /**
     * @param  mixed  $altText
     */
    private function syncAltTextTranslations(Media $media, Model $model, $altText): void
    {
        if ($model instanceof Product) {
            $media->syncTranslations($this->generatedProductAltTextPayloads($model), ['alt_text']);

            return;
        }

        if (! is_array($altText)) {
            if (filled($altText)) {
                $media->setTranslation('de', 'alt_text', (string) $altText);
            }

            return;
        }

        $payloads = collect($altText)
            ->map(fn (mixed $value) => ['alt_text' => $value])
            ->all();

        $media->syncTranslations($payloads, ['alt_text']);
    }

    /**
     * @return array<string, array{alt_text: string}>
     */
    private function generatedProductAltTextPayloads(Product $product): array
    {
        return collect(PublicLocale::codes())
            ->mapWithKeys(fn (string $locale): array => [
                $locale => ['alt_text' => $this->generatedProductAltText($product, $locale)],
            ])
            ->all();
    }

    private function generatedProductAltText(Product $product, string $locale): string
    {
        $name = $product->translate($locale, 'name', PublicLocale::Default) ?? $product->slug;
        $brand = filled($product->brand) ? (string) $product->brand : null;

        $text = match ($locale) {
            'en' => $brand ? "{$name} perfume by {$brand}" : "{$name} perfume",
            'ar' => $brand ? "عطر {$name} من {$brand}" : "عطر {$name}",
            default => $brand ? "{$name} Parfum von {$brand}" : "{$name} Parfum",
        };

        return Str::limit(Str::squish(strip_tags($text)), 255, '');
    }

    private function ensurePrimary(Model $model): void
    {
        $media = $model->media()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($media->isEmpty()) {
            return;
        }

        if ($media->contains(fn (Media $item) => $item->is_primary)) {
            return;
        }

        $media->first()?->update(['is_primary' => true]);
    }
}
