<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * @var list<array{slug: string, name: string, description: string, image_path: string}>
     */
    private const CATEGORIES = [
        [
            'slug' => 'luxusparfums',
            'name' => 'Luxusparfums',
            'description' => 'Opulente Duftsignaturen mit Tiefe, langer Haltbarkeit und hochwertiger Sillage.',
            'image_path' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'nischenparfums',
            'name' => 'Nischenparfums',
            'description' => 'Ausdrucksstarke Kompositionen abseits klassischer Duftregale.',
            'image_path' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'designerparfums',
            'name' => 'Designerparfums',
            'description' => 'Bekannte Duftprofile mit moderner Eleganz fuer Alltag, Office und Abend.',
            'image_path' => 'https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'arabische-parfums',
            'name' => 'Arabische Parfums',
            'description' => 'Warme Amber-, Oud- und Gewuerzakkorde mit intensiver Praesenz.',
            'image_path' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'damenparfums',
            'name' => 'Damenparfums',
            'description' => 'Florale, pudrige und fruchtige Duftbilder von dezent bis sinnlich.',
            'image_path' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59d32?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'herrenparfums',
            'name' => 'Herrenparfums',
            'description' => 'Holzige, aromatische und frische Profile fuer klare Kontur.',
            'image_path' => 'https://images.unsplash.com/photo-1619994403073-2cec844b8e63?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'unisex-parfums',
            'name' => 'Unisex-Parfums',
            'description' => 'Ausgewogene Duftcharaktere ohne starre Grenzen.',
            'image_path' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=1400&q=80',
        ],
    ];

    public function run(): void
    {
        foreach (self::CATEGORIES as $index => $category) {
            $model = Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'sort_order' => $index,
                    'is_active' => true,
                    'image_path' => $category['image_path'],
                ],
            );

            $model->setTranslation('de', 'name', $category['name']);
            $model->setTranslation('de', 'description', $category['description']);
        }
    }
}
