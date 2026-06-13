<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdatePageSectionRequest;
use App\Models\PageSection;
use App\Support\PublicLocale;
use App\Support\StorageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

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

        DB::transaction(function () use ($pageSection, $data, $request): void {
            $payload = $pageSection->payload ?? [];

            if ($pageSection->key === 'hero' && $request->boolean('remove_hero_image')) {
                $this->deleteHeroImage($payload);
                $payload['image_path'] = null;
            }

            if ($pageSection->key === 'hero' && $request->boolean('remove_hero_video')) {
                $this->deleteHeroVideo($payload);
                $payload['video_path'] = null;
            }

            if ($pageSection->key === 'hero' && $request->hasFile('hero_image')) {
                // The hero shows an image or a video, never both.
                $this->deleteHeroImage($payload);
                $this->deleteHeroVideo($payload);
                $payload['video_path'] = null;
                $payload['image_path'] = $request
                    ->file('hero_image')
                    ->store('page-sections/hero', 'public');
            }

            if ($pageSection->key === 'hero' && $request->hasFile('hero_video')) {
                // The hero shows an image or a video, never both.
                $this->deleteHeroVideo($payload);
                $this->deleteHeroImage($payload);
                $payload['image_path'] = null;
                $payload['video_path'] = $request
                    ->file('hero_video')
                    ->store('page-sections/hero', 'public');
            }

            $pageSection->update([
                'payload' => $payload,
                'sort_order' => $data['sort_order'],
                'is_active' => (bool) $data['is_active'],
            ]);

            $this->syncTranslations($pageSection, $data['translations'] ?? []);
        });

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
     * @param  array<string, mixed>  $payload
     */
    private function deleteHeroImage(array $payload): void
    {
        $this->deleteFileAfterCommit($payload['image_path'] ?? null);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function deleteHeroVideo(array $payload): void
    {
        $this->deleteFileAfterCommit($payload['video_path'] ?? null);
    }

    /**
     * Remove the file only once the surrounding transaction has committed so
     * a rollback never leaves a payload pointing at a deleted file.
     */
    private function deleteFileAfterCommit(?string $path): void
    {
        if (! empty($path)) {
            DB::afterCommit(fn () => Storage::disk('public')->delete($path));
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
