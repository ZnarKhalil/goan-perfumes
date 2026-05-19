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

            foreach ($promotion['translations'] as $field => $value) {
                $model->setTranslation('de', $field, $value);
            }
        }
    }

    /**
     * @return list<array{translations: array<string, string>}>
     */
    private function promotions(): array
    {
        return [
            [
                'translations' => [
                    'title' => 'Luxury Week',
                    'subtitle' => 'Ausgewaehlte Luxus- und Nischenduefte mit persoenlicher Beratung.',
                    'badge' => 'Aktuelle Aktion',
                    'cta_text' => 'Highlights ansehen',
                ],
            ],
            [
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
