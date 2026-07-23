<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdatePageSectionRequest;
use App\Models\PageSection;
use App\Support\ImageUpload;
use App\Support\PublicLocale;
use App\Support\StorageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;
use Throwable;

class PageSectionController extends Controller
{
    private const TRANSLATABLE_FIELDS = [
        'title',
        'body',
        'cta_text',
        'bullet_points',
    ];

    private const LABELS = [
        'hero' => 'Hero',
        'about' => 'Über uns',
        'why_us' => 'Warum GOAN',
    ];

    public function index(): Response
    {
        $sections = PageSection::query()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (PageSection $section) => [
                'id' => $section->id,
                'key' => $section->key,
                'label' => $this->labelFor($section),
                'type' => $section->type,
                'sort_order' => $section->sort_order,
                'is_active' => $section->is_active,
                'title' => $section->translate('de', 'title') ?? $this->labelFor($section),
                'summary' => $this->summaryFor($section),
            ])
            ->values();

        return Inertia::render('dashboard/page-sections/index', [
            'sections' => $sections,
        ]);
    }

    public function edit(PageSection $pageSection): Response
    {
        $pageSection->load('translations');

        return Inertia::render('dashboard/page-sections/edit', [
            'section' => [
                'id' => $pageSection->id,
                'key' => $pageSection->key,
                'label' => $this->labelFor($pageSection),
                'type' => $pageSection->type,
                'payload' => $pageSection->payload ?? [],
                'image_url' => $this->imageUrlFor($pageSection),
                'video_url' => $this->videoUrlFor($pageSection),
                'sort_order' => $pageSection->sort_order,
                'is_active' => $pageSection->is_active,
                'translations' => $this->translationsAsTabs($pageSection),
            ],
        ]);
    }

    public function update(UpdatePageSectionRequest $request, PageSection $pageSection): RedirectResponse
    {
        $data = $request->validated();
        $newImagePath = null;
        $newVideoPath = null;

        try {
            if ($pageSection->key === 'hero' && $request->hasFile('hero_image')) {
                $newImagePath = ImageUpload::storePublicImageAsWebp(
                    $request->file('hero_image'),
                    'page-sections/hero',
                    'goan-perfume-hero',
                );
            }

            if ($pageSection->key === 'hero' && $request->hasFile('hero_video')) {
                $storedPath = $request->file('hero_video')->store('page-sections/hero', 'public');

                if (! is_string($storedPath)) {
                    throw new RuntimeException('The uploaded hero video could not be stored.');
                }

                $newVideoPath = $storedPath;
            }

            DB::transaction(function () use ($pageSection, $data, $request, $newImagePath, $newVideoPath): void {
                $payload = $pageSection->payload ?? [];
                $pathsToDelete = [];

                if ($pageSection->key === 'hero' && $request->boolean('remove_hero_image')) {
                    $pathsToDelete[] = $payload['image_path'] ?? null;
                    $payload['image_path'] = null;
                }

                if ($pageSection->key === 'hero' && $request->boolean('remove_hero_video')) {
                    $pathsToDelete[] = $payload['video_path'] ?? null;
                    $payload['video_path'] = null;
                }

                if ($newImagePath !== null) {
                    $pathsToDelete[] = $payload['image_path'] ?? null;
                    $pathsToDelete[] = $payload['video_path'] ?? null;
                    $payload['image_path'] = $newImagePath;
                    $payload['video_path'] = null;
                }

                if ($newVideoPath !== null) {
                    $pathsToDelete[] = $payload['video_path'] ?? null;
                    $pathsToDelete[] = $payload['image_path'] ?? null;
                    $payload['video_path'] = $newVideoPath;
                    $payload['image_path'] = null;
                }

                $pageSection->update([
                    'payload' => $payload,
                    'sort_order' => $data['sort_order'],
                    'is_active' => (bool) $data['is_active'],
                ]);

                $this->syncTranslations($pageSection, $data['translations'] ?? []);
                $this->deleteFilesAfterCommit($pathsToDelete);
            });
        } catch (Throwable $exception) {
            $this->deleteStoredFilesWithoutMasking([$newImagePath, $newVideoPath]);

            throw $exception;
        }

        return to_route('dashboard.page-sections.index')
            ->with('toast', ['type' => 'success', 'message' => 'Seiten-Inhalt gespeichert.']);
    }

    private function labelFor(PageSection $section): string
    {
        return self::LABELS[$section->key] ?? $section->key;
    }

    private function summaryFor(PageSection $section): string
    {
        if ($section->key === 'hero') {
            $hasImage = (bool) ($section->payload['image_path'] ?? null);
            $hasVideo = (bool) ($section->payload['video_path'] ?? null);

            return match (true) {
                $hasVideo => 'Video hinterlegt',
                $hasImage => 'Bild hinterlegt',
                default => 'Kein Medium hinterlegt',
            };
        }

        if ($section->key === 'why_us') {
            $count = count(PageSection::decodeBulletPoints($section->translate('de', 'bullet_points')));

            return $count > 0 ? "{$count} Punkte hinterlegt" : 'Noch keine Punkte';
        }

        return $section->translate('de', 'body') ? 'Text hinterlegt' : 'Noch kein Text';
    }

    /**
     * @param  array<int, mixed>  $paths
     */
    private function deleteFilesAfterCommit(array $paths): void
    {
        $paths = collect($paths)
            ->filter(fn (mixed $path): bool => is_string($path) && $path !== '')
            ->unique()
            ->values()
            ->all();

        if ($paths !== []) {
            DB::afterCommit(fn () => Storage::disk('public')->delete($paths));
        }
    }

    /**
     * @param  array<int, ?string>  $paths
     */
    private function deleteStoredFilesWithoutMasking(array $paths): void
    {
        try {
            Storage::disk('public')->delete(array_values(array_filter($paths)));
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private function imageUrlFor(PageSection $section): ?string
    {
        return StorageUrl::for($section->payload['image_path'] ?? null);
    }

    private function videoUrlFor(PageSection $section): ?string
    {
        return StorageUrl::for($section->payload['video_path'] ?? null);
    }

    /**
     * @param  array<string, array<string, mixed>>  $translations
     */
    private function syncTranslations(PageSection $section, array $translations): void
    {
        $payloads = [];
        foreach (PublicLocale::codes() as $locale) {
            $payload = $translations[$locale] ?? [];
            $payload['bullet_points'] = PageSection::encodeBulletPoints($payload['bullet_points'] ?? null);
            $payloads[$locale] = $payload;
        }

        $section->syncTranslations($payloads, self::TRANSLATABLE_FIELDS);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function translationsAsTabs(PageSection $section): array
    {
        $shape = [];

        foreach (PublicLocale::codes() as $locale) {
            $shape[$locale] = [];

            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $value = $section->translate($locale, $field);

                $shape[$locale][$field] = $field === 'bullet_points'
                    ? PageSection::decodeBulletPoints($value)
                    : ($value ?? '');
            }
        }

        return $shape;
    }
}
