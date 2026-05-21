<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * @var list<array{code: string, translations: array{de: string, en: string, ar: string}, is_multiple: bool}>
     */
    private const ATTRIBUTES = [
        ['code' => 'art', 'translations' => ['de' => 'Art', 'en' => 'Type', 'ar' => 'النوع'], 'is_multiple' => false],
        ['code' => 'familie', 'translations' => ['de' => 'Duftfamilie', 'en' => 'Fragrance Family', 'ar' => 'عائلة العطر'], 'is_multiple' => true],
        ['code' => 'stimmung', 'translations' => ['de' => 'Duftstimmung', 'en' => 'Fragrance Mood', 'ar' => 'مزاج العطر'], 'is_multiple' => true],
        ['code' => 'noten', 'translations' => ['de' => 'Duftnoten', 'en' => 'Fragrance Notes', 'ar' => 'نوتات العطر'], 'is_multiple' => true],
    ];

    public function run(): void
    {
        foreach (self::ATTRIBUTES as $index => $attribute) {
            $model = Attribute::query()->updateOrCreate(
                ['code' => $attribute['code']],
                [
                    'sort_order' => $index,
                    'is_filterable' => true,
                    'is_multiple' => $attribute['is_multiple'],
                ],
            );

            foreach ($attribute['translations'] as $locale => $name) {
                $model->setTranslation($locale, 'name', $name);
            }
        }
    }
}
