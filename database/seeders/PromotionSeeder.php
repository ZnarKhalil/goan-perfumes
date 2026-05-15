<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->promotions() as $index => $promotion) {
            $model = Promotion::query()->updateOrCreate(
                ['slug' => $promotion['slug']],
                [
                    'background_image_path' => $promotion['background_image_path'],
                    'background_color' => $promotion['background_color'],
                    'link_url' => $promotion['link_url'],
                    'promo_code' => $promotion['promo_code'],
                    'discount_percent' => $promotion['discount_percent'],
                    'starts_at' => now()->subDay(),
                    'ends_at' => now()->addMonths(3),
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );

            foreach ($promotion['translations'] as $field => $value) {
                $model->setTranslation('de', $field, $value);
            }
        }
    }

    /**
     * @return list<array{slug: string, background_image_path: string, background_color: string, link_url: string, promo_code: string, discount_percent: int, translations: array<string, string>}>
     */
    private function promotions(): array
    {
        return [
            [
                'slug' => 'luxury-week',
                'background_image_path' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=2200&q=85',
                'background_color' => '#171412',
                'link_url' => '/luxusparfums',
                'promo_code' => 'GOAN15',
                'discount_percent' => 15,
                'translations' => [
                    'title' => 'Luxury Week',
                    'subtitle' => 'Ausgewaehlte Luxus- und Nischenduefte mit persoenlicher Beratung.',
                    'badge' => 'Aktuelle Aktion',
                    'cta_text' => 'Highlights ansehen',
                ],
            ],
            [
                'slug' => 'oud-discovery',
                'background_image_path' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?auto=format&fit=crop&w=2200&q=85',
                'background_color' => '#2b2118',
                'link_url' => '/arabische-parfums',
                'promo_code' => 'OUD10',
                'discount_percent' => 10,
                'translations' => [
                    'title' => 'Oud Discovery',
                    'subtitle' => 'Warme Oud-, Amber- und Safranprofile fuer intensive Abende.',
                    'badge' => 'Arabische Parfums',
                    'cta_text' => 'Oud entdecken',
                ],
            ],
        ];
    }
}
