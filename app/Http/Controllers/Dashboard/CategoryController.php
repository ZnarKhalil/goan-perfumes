<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Dashboard\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Media;
use App\Services\MediaService;
use App\Support\PublicCategoryNavigation;
use App\Support\PublicLocale;
use App\Support\StorageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    private const TRANSLATABLE_FIELDS = [
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];

    public function __construct(private readonly MediaService $mediaService) {}

    public function index(): Response
    {
        $categories = Category::query()
            ->with(['translations', 'parent.translations', 'primaryMedia'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Category $category) => [
                'id' => $category->id,
                'slug' => $category->slug,
                'name' => $category->translate('de', 'name') ?? $category->slug,
                'parent_name' => $category->parent?->translate('de', 'name'),
                'sort_order' => $category->sort_order,
                'is_active' => $category->is_active,
                'image_url' => StorageUrl::for($category->primaryMedia?->path),
            ])
            ->values();

        return Inertia::render('dashboard/categories/index', [
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('dashboard/categories/create', [
            'parents' => $this->parentOptions(),
            'next_sort_order' => $this->nextSortOrder(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $parentId = $this->normalizeParentId($data['parent_id'] ?? null);

        DB::transaction(function () use ($data, $parentId, $request): void {
            $category = new Category([
                'slug' => '',
                'parent_id' => $parentId,
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool) $data['is_active'],
            ]);

            $category->setSlugSource($data['translations']['de']['name']);

            $category->save();

            $this->syncTranslations($category, $data['translations'] ?? []);
            $this->mediaService->syncFromRequest(
                $category,
                $request->file('media_uploads', []),
                $data['media_meta'] ?? [],
            );
        });

        PublicCategoryNavigation::flush();

        return to_route('dashboard.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Kategorie angelegt.']);
    }

    public function edit(Category $category): Response
    {
        $category->load([
            'translations',
            'media' => fn ($query) => $query
                ->with('translations')
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return Inertia::render('dashboard/categories/edit', [
            'category' => [
                'id' => $category->id,
                'slug' => $category->slug,
                'parent_id' => $category->parent_id,
                'sort_order' => $category->sort_order,
                'is_active' => $category->is_active,
                'translations' => $this->translationsAsTabs($category),
                'name' => $category->translate('de', 'name') ?? $category->slug,
                'media' => $category->media
                    ->map(fn (Media $media) => [
                        'id' => $media->id,
                        'url' => StorageUrl::for($media->path),
                        'sort_order' => $media->sort_order,
                        'is_primary' => $media->is_primary,
                        'alt_text' => $media->translate('de', 'alt_text') ?? $media->alt_text ?? '',
                        'alt_text_translations' => [
                            'de' => $media->translate('de', 'alt_text') ?? '',
                            'ar' => $media->translate('ar', 'alt_text') ?? '',
                            'en' => $media->translate('en', 'alt_text') ?? '',
                        ],
                    ])
                    ->values()
                    ->all(),
            ],
            'parents' => $this->parentOptions($category->id),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $parentId = $this->normalizeParentId($data['parent_id'] ?? null);

        DB::transaction(function () use ($category, $data, $parentId, $request): void {
            $category->fill([
                'parent_id' => $parentId,
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool) $data['is_active'],
            ]);

            $category->save();

            $this->syncTranslations($category, $data['translations'] ?? []);
            $this->mediaService->syncFromRequest(
                $category,
                $request->file('media_uploads', []),
                $data['media_meta'] ?? [],
            );
        });

        PublicCategoryNavigation::flush();

        return to_route('dashboard.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Kategorie gespeichert.']);
    }

    public function destroy(Category $category): RedirectResponse
    {
        DB::transaction(function () use ($category): void {
            $category->load('media.translations');
            $mediaPaths = $category->media->pluck('path')->all();

            foreach ($category->media as $media) {
                $media->translations()->delete();
                $media->delete();
            }

            $category->translations()->delete();
            $category->delete();

            DB::afterCommit(fn () => Storage::disk('public')->delete($mediaPaths));
        });

        PublicCategoryNavigation::flush();

        return to_route('dashboard.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Kategorie gelöscht.']);
    }

    /**
     * Reject parents that would create a cycle. Drop options pointing to the
     * given $excludeId or any of its descendants.
     *
     * @return array<int, array{id: int, name: string}>
     */
    private function parentOptions(?int $excludeId = null): array
    {
        $excluded = $excludeId === null
            ? []
            : $this->collectDescendantIds($excludeId);

        return Category::query()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->reject(fn (Category $c) => in_array($c->id, $excluded, true))
            ->map(fn (Category $c) => [
                'id' => $c->id,
                'name' => $c->translate('de', 'name') ?? $c->slug,
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<int, int>
     */
    private function collectDescendantIds(int $rootId): array
    {
        $ids = [$rootId];
        $frontier = [$rootId];

        while ($frontier !== []) {
            $children = Category::query()
                ->whereIn('parent_id', $frontier)
                ->pluck('id')
                ->all();

            $frontier = array_values(array_diff($children, $ids));
            $ids = array_merge($ids, $frontier);
        }

        return $ids;
    }

    private function normalizeParentId(int|string|null $value): ?int
    {
        if ($value === null || $value === '' || $value === 'none') {
            return null;
        }

        return (int) $value;
    }

    /**
     * The next free sort order, suggested as the default when creating a
     * category so the unique rule is not tripped on the common case.
     */
    private function nextSortOrder(): int
    {
        $max = Category::query()->max('sort_order');

        return $max === null ? 0 : ((int) $max + 1);
    }

    /**
     * @param  array<string, array<string, ?string>>  $translations
     */
    private function syncTranslations(Category $category, array $translations): void
    {
        $payloads = [];
        foreach (PublicLocale::codes() as $locale) {
            $payloads[$locale] = $this->withDerivedSeoTranslations($translations[$locale] ?? []);
        }

        $category->syncTranslations($payloads, self::TRANSLATABLE_FIELDS);
    }

    /**
     * Derive SEO meta from the editable content. Meta title follows the
     * category name; meta description is a trimmed plain-text excerpt of the
     * description. These are never accepted from the request.
     *
     * @param  array<string, ?string>  $payload
     * @return array<string, ?string>
     */
    private function withDerivedSeoTranslations(array $payload): array
    {
        $name = $payload['name'] ?? null;
        $description = $payload['description'] ?? null;

        return [
            ...$payload,
            'meta_title' => filled($name) ? $name : null,
            'meta_description' => filled($description)
                ? Str::limit(Str::squish(strip_tags((string) $description)), 500, '')
                : null,
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function translationsAsTabs(Category $category): array
    {
        $shape = [];
        foreach (PublicLocale::codes() as $locale) {
            $shape[$locale] = [];
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $shape[$locale][$field] = $category->translate($locale, $field) ?? '';
            }
        }

        return $shape;
    }
}
