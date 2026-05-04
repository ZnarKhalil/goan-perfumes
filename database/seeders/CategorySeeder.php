<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * @var list<array{slug: string, name: string}>
     */
    private const CATEGORIES = [
        ['slug' => 'luxusparfums', 'name' => 'Luxusparfums'],
        ['slug' => 'nischenparfums', 'name' => 'Nischenparfums'],
        ['slug' => 'designerparfums', 'name' => 'Designerparfums'],
        ['slug' => 'arabische-parfums', 'name' => 'Arabische Parfums'],
        ['slug' => 'damenparfums', 'name' => 'Damenparfums'],
        ['slug' => 'herrenparfums', 'name' => 'Herrenparfums'],
        ['slug' => 'unisex-parfums', 'name' => 'Unisex-Parfums'],
    ];

    public function run(): void
    {
        foreach (self::CATEGORIES as $index => $category) {
            $model = Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );

            $model->setTranslation('de', 'name', $category['name']);
        }
    }
}
