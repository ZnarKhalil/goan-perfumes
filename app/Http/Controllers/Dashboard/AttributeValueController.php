<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreAttributeValueRequest;
use App\Http\Requests\Dashboard\UpdateAttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    public function store(StoreAttributeValueRequest $request, Attribute $attribute): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($attribute, $data) {
            $value = new AttributeValue([
                'slug' => '',
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool) $data['is_active'],
            ]);

            $value->attribute()->associate($attribute);

            $value->slug = $this->generateScopedSlug(
                $attribute,
                $data['translations']['de']['name'],
            );

            $value->save();
            $value->syncTranslations($data['translations'] ?? [], ['name']);
        });

        return to_route('dashboard.attributes.edit', $attribute)
            ->with('toast', ['type' => 'success', 'message' => 'Wert angelegt.']);
    }

    public function update(
        UpdateAttributeValueRequest $request,
        Attribute $attribute,
        AttributeValue $value,
    ): RedirectResponse {
        abort_unless($value->attribute_id === $attribute->id, 404);

        $data = $request->validated();

        DB::transaction(function () use ($attribute, $value, $data) {
            $value->fill([
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool) $data['is_active'],
            ]);

            $value->slug = $this->generateScopedSlug(
                $attribute,
                $data['translations']['de']['name'],
                $value,
            );

            $value->save();
            $value->syncTranslations($data['translations'] ?? [], ['name']);
        });

        return to_route('dashboard.attributes.edit', $attribute)
            ->with('toast', ['type' => 'success', 'message' => 'Wert gespeichert.']);
    }

    public function destroy(Attribute $attribute, AttributeValue $value): RedirectResponse
    {
        abort_unless($value->attribute_id === $attribute->id, 404);

        DB::transaction(function () use ($value) {
            $value->translations()->delete();
            $value->delete();
        });

        return to_route('dashboard.attributes.edit', $attribute)
            ->with('toast', ['type' => 'success', 'message' => 'Wert gelöscht.']);
    }

    private function generateScopedSlug(
        Attribute $attribute,
        string $source,
        ?AttributeValue $ignore = null,
    ): string {
        $base = Str::slug($source, '-', 'de');

        if ($base === '') {
            $base = 'wert';
        }

        $slug = $base;
        $suffix = 2;

        while (
            $attribute->values()
                ->where('slug', $slug)
                ->when($ignore !== null, fn ($query) => $query->whereKeyNot($ignore->getKey()))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
