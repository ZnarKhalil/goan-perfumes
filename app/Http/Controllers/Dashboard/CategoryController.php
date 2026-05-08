<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Dashboard\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    private const LOCALES = ['de', 'ar', 'en'];

    private const TRANSLATABLE_FIELDS = [
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];

    public function index(): Response
    {
        $categories = Category::query()
            ->with(['translations', 'parent.translations'])
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
                'image_url' => $category->image_path
                    ? Storage::url($category->image_path)
                    : null,
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
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $parentId = $this->normalizeParentId($data['parent_id'] ?? null);

        $category = DB::transaction(function () use ($data, $request, $parentId) {
            $category = new Category([
                'slug' => $data['slug'] ?? '',
                'parent_id' => $parentId,
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool) $data['is_active'],
                'image_path' => null,
            ]);

            if (empty($data['slug'])) {
                $category->setSlugSource($data['translations']['de']['name']);
            }

            $category->save();

            $this->syncTranslations($category, $data['translations'] ?? []);

            if ($request->hasFile('image')) {
                $category->image_path = $request->file('image')->store(
                    'categories/banners',
                    'public',
                );
                $category->save();
            }

            return $category;
        });

        return to_route('dashboard.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Kategorie angelegt.']);
    }

    public function edit(Category $category): Response
    {
        $category->load('translations');

        return Inertia::render('dashboard/categories/edit', [
            'category' => [
                'id' => $category->id,
                'slug' => $category->slug,
                'parent_id' => $category->parent_id,
                'sort_order' => $category->sort_order,
                'is_active' => $category->is_active,
                'image_url' => $category->image_path
                    ? Storage::url($category->image_path)
                    : null,
                'translations' => $this->translationsAsTabs($category),
                'name' => $category->translate('de', 'name') ?? $category->slug,
            ],
            'parents' => $this->parentOptions($category->id),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $parentId = $this->normalizeParentId($data['parent_id'] ?? null);

        DB::transaction(function () use ($category, $data, $request, $parentId) {
            $category->fill([
                'parent_id' => $parentId,
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool) $data['is_active'],
            ]);

            if (! empty($data['slug'])) {
                $category->slug = $data['slug'];
            } elseif (empty($category->slug)) {
                $category->setSlugSource($data['translations']['de']['name']);
            }

            $category->save();

            $this->syncTranslations($category, $data['translations'] ?? []);

            if ($request->boolean('remove_image') && $category->image_path) {
                Storage::disk('public')->delete($category->image_path);
                $category->image_path = null;
                $category->save();
            }

            if ($request->hasFile('image')) {
                if ($category->image_path) {
                    Storage::disk('public')->delete($category->image_path);
                }
                $category->image_path = $request->file('image')->store(
                    'categories/banners',
                    'public',
                );
                $category->save();
            }
        });

        return to_route('dashboard.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Kategorie gespeichert.']);
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        $category->translations()->delete();
        $category->delete();

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
     * @param  array<string, array<string, ?string>>  $translations
     */
    private function syncTranslations(Category $category, array $translations): void
    {
        foreach (self::LOCALES as $locale) {
            $payload = $translations[$locale] ?? [];
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $value = $payload[$field] ?? null;
                if ($value === null || $value === '') {
                    if ($category->translations()
                        ->where('locale', $locale)
                        ->where('field', $field)
                        ->exists()
                    ) {
                        $category->translations()
                            ->where('locale', $locale)
                            ->where('field', $field)
                            ->delete();
                    }

                    continue;
                }

                $category->setTranslation($locale, $field, $value);
            }
        }
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function translationsAsTabs(Category $category): array
    {
        $shape = [];
        foreach (self::LOCALES as $locale) {
            $shape[$locale] = [];
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $shape[$locale][$field] = $category->translate($locale, $field) ?? '';
            }
        }

        return $shape;
    }
}
