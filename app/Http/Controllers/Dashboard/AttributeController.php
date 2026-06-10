<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreAttributeRequest;
use App\Http\Requests\Dashboard\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Support\PublicLocale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AttributeController extends Controller
{
    public function index(): Response
    {
        $attributes = Attribute::query()
            ->with('translations')
            ->withCount('values')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Attribute $attribute) => [
                'id' => $attribute->id,
                'code' => $attribute->code,
                'name' => $attribute->translate('de', 'name') ?? $attribute->code,
                'sort_order' => $attribute->sort_order,
                'is_filterable' => $attribute->is_filterable,
                'is_multiple' => $attribute->is_multiple,
                'values_count' => $attribute->values_count,
            ])
            ->values();

        return Inertia::render('dashboard/attributes/index', [
            'attributes' => $attributes,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('dashboard/attributes/create', [
            'next_sort_order' => $this->nextSortOrder(),
        ]);
    }

    public function store(StoreAttributeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $attribute = Attribute::query()->create([
                'code' => $data['code'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_filterable' => (bool) $data['is_filterable'],
                'is_multiple' => (bool) $data['is_multiple'],
            ]);

            $attribute->syncTranslations($data['translations'] ?? [], ['name']);
        });

        return to_route('dashboard.attributes.index')
            ->with('toast', ['type' => 'success', 'message' => 'Attribut angelegt.']);
    }

    public function edit(Attribute $attribute): Response
    {
        $attribute->load([
            'translations',
            'values' => fn ($query) => $query
                ->with('translations')
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return Inertia::render('dashboard/attributes/edit', [
            'attribute' => [
                'id' => $attribute->id,
                'code' => $attribute->code,
                'sort_order' => $attribute->sort_order,
                'is_filterable' => $attribute->is_filterable,
                'is_multiple' => $attribute->is_multiple,
                'translations' => $this->translationsAsTabs($attribute),
                'name' => $attribute->translate('de', 'name') ?? $attribute->code,
                'values' => $attribute->values
                    ->map(fn (AttributeValue $value) => [
                        'id' => $value->id,
                        'slug' => $value->slug,
                        'name' => $value->translate('de', 'name') ?? $value->slug,
                        'sort_order' => $value->sort_order,
                        'is_active' => $value->is_active,
                        'translations' => $this->translationsAsTabs($value),
                    ])
                    ->values(),
            ],
        ]);
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($attribute, $data) {
            $attribute->update([
                'code' => $data['code'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_filterable' => (bool) $data['is_filterable'],
                'is_multiple' => (bool) $data['is_multiple'],
            ]);

            $attribute->syncTranslations($data['translations'] ?? [], ['name']);
        });

        return to_route('dashboard.attributes.edit', $attribute)
            ->with('toast', ['type' => 'success', 'message' => 'Attribut gespeichert.']);
    }

    public function destroy(Attribute $attribute): RedirectResponse
    {
        DB::transaction(function () use ($attribute) {
            $attribute->load('values.translations');

            foreach ($attribute->values as $value) {
                $value->translations()->delete();
            }

            $attribute->translations()->delete();
            $attribute->delete();
        });

        return to_route('dashboard.attributes.index')
            ->with('toast', ['type' => 'success', 'message' => 'Attribut gelöscht.']);
    }

    /**
     * The next free sort order, suggested as the default when creating an
     * attribute so the unique rule is not tripped on the common case.
     */
    private function nextSortOrder(): int
    {
        $max = Attribute::query()->max('sort_order');

        return $max === null ? 0 : ((int) $max + 1);
    }

    /**
     * @return array<string, array{name: string}>
     */
    private function translationsAsTabs(Attribute|AttributeValue $model): array
    {
        $shape = [];

        foreach (PublicLocale::codes() as $locale) {
            $shape[$locale] = [
                'name' => $model->translate($locale, 'name') ?? '',
            ];
        }

        return $shape;
    }
}
