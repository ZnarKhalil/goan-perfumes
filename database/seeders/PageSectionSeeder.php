<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->sections() as $section) {
            PageSection::query()->updateOrCreate(
                ['key' => $section['key']],
                [
                    'type' => $section['type'],
                    'payload' => $section['payload'],
                    'sort_order' => $section['sort_order'],
                    'is_active' => $section['is_active'],
                ],
            );
        }
    }

    /**
     * @return array<int, array{key: string, type: string, payload: array<string, mixed>, sort_order: int, is_active: bool}>
     */
    private function sections(): array
    {
        return [
            [
                'key' => 'hero',
                'type' => 'image',
                'payload' => ['image_path' => null],
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'key' => 'about',
                'type' => 'text',
                'payload' => [],
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'key' => 'why_us',
                'type' => 'text',
                'payload' => [],
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'key' => 'featured_products',
                'type' => 'product_list',
                'payload' => ['product_ids' => []],
                'sort_order' => 30,
                'is_active' => true,
            ],
        ];
    }
}
