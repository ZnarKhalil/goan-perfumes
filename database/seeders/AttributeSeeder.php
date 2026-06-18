<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = PerfumeCatalog::attributes();
        $codes = collect($attributes)->pluck('code')->all();
        $translations = PerfumeCatalog::attributeTranslations();

        Attribute::query()
            ->whereNotIn('code', $codes)
            ->with('values.translations', 'translations')
            ->each(fn (Attribute $attribute) => $this->deleteAttribute($attribute));

        foreach ($attributes as $index => $attribute) {
            $model = Attribute::query()->updateOrCreate(
                ['code' => $attribute['code']],
                [
                    'sort_order' => $index,
                    'is_filterable' => true,
                    'is_multiple' => $attribute['is_multiple'],
                ],
            );

            $names = PerfumeCatalog::localized(
                $attribute['name'],
                $translations[$attribute['code']] ?? [],
            );

            foreach ($names as $locale => $name) {
                $model->setTranslation($locale, 'name', $name);
            }

            $model->translations()
                ->whereNotIn('field', ['name'])
                ->delete();
        }
    }

    private function deleteAttribute(Attribute $attribute): void
    {
        $attribute->values->each(function (AttributeValue $value): void {
            $value->translations()->delete();
            $value->delete();
        });

        $attribute->translations()->delete();
        $attribute->delete();
    }
}
