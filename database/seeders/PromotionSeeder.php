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
                ['sort_order' => $index],
                [
                    'starts_at' => now()->subDay(),
                    'ends_at' => now()->addMonths(3),
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );

            foreach ($promotion['translations'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $model->setTranslation($locale, $field, $value);
                }
            }
        }
    }

    /**
     * @return list<array{translations: array<string, array<string, string>>}>
     */
    private function promotions(): array
    {
        return [
            [
                'translations' => [
                    'de' => [
                        'title' => 'Luxury Week',
                        'subtitle' => 'Ausgewählte Luxus- und Nischendüfte mit persönlicher Beratung.',
                        'badge' => 'Aktuelle Aktion',
                        'cta_text' => 'Highlights ansehen',
                    ],
                    'en' => [
                        'title' => 'Luxury Week',
                        'subtitle' => 'Selected luxury and niche fragrances with personal advice.',
                        'badge' => 'Current campaign',
                        'cta_text' => 'View highlights',
                    ],
                    'ar' => [
                        'title' => 'أسبوع الفخامة',
                        'subtitle' => 'عطور فاخرة ونيش مختارة مع استشارة شخصية.',
                        'badge' => 'العرض الحالي',
                        'cta_text' => 'عرض المختارات',
                    ],
                ],
            ],
            [
                'translations' => [
                    'de' => [
                        'title' => 'Oud Discovery',
                        'subtitle' => 'Warme Oud-, Amber- und Safranprofile für intensive Abende.',
                        'badge' => 'Arabische Parfums',
                        'cta_text' => 'Oud entdecken',
                    ],
                    'en' => [
                        'title' => 'Oud Discovery',
                        'subtitle' => 'Warm oud, amber, and saffron profiles for intense evenings.',
                        'badge' => 'Arabian perfumes',
                        'cta_text' => 'Discover oud',
                    ],
                    'ar' => [
                        'title' => 'اكتشف العود',
                        'subtitle' => 'عود وعنبر وزعفران بدفء مناسب للسهرات.',
                        'badge' => 'عطور عربية',
                        'cta_text' => 'اكتشف العود',
                    ],
                ],
            ],
        ];
    }
}
