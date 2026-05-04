<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * @var list<array{code: string, name: string, is_multiple: bool}>
     */
    private const ATTRIBUTES = [
        ['code' => 'art', 'name' => 'Art', 'is_multiple' => false],
        ['code' => 'familie', 'name' => 'Familie', 'is_multiple' => true],
        ['code' => 'stimmung', 'name' => 'Stimmung', 'is_multiple' => true],
        ['code' => 'noten', 'name' => 'Noten', 'is_multiple' => true],
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

            $model->setTranslation('de', 'name', $attribute['name']);
        }
    }
}
