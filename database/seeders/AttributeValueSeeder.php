<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use RuntimeException;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $values = PerfumeCatalog::attributeValues();
        $attributes = Attribute::query()->whereIn('code', array_keys($values))->get()->keyBy('code');

        foreach ($values as $code => $names) {
            $attribute = $attributes[$code] ?? null;

            if ($attribute === null) {
                throw new RuntimeException("Attribute '{$code}' must be seeded before its values.");
            }

            $seededSlugs = collect($names)->pluck('slug')->all();

            $attribute->values()
                ->whereNotIn('slug', $seededSlugs)
                ->with('translations')
                ->each(fn (AttributeValue $value) => $this->deleteValue($value));

            foreach ($names as $index => $valueData) {
                $slug = $valueData['slug'];

                $value = AttributeValue::query()->updateOrCreate(
                    ['attribute_id' => $attribute->id, 'slug' => $slug],
                    ['sort_order' => $index, 'is_active' => true],
                );

                foreach (['de', 'en', 'ar'] as $locale) {
                    $value->setTranslation($locale, 'name', $valueData['name']);
                }

                $value->translations()
                    ->whereNotIn('field', ['name'])
                    ->delete();
            }
        }
    }

    private function deleteValue(AttributeValue $value): void
    {
        $value->translations()->delete();
        $value->delete();
    }
}
