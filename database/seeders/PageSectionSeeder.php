<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->sections() as $section) {
            $model = PageSection::query()->updateOrCreate(
                ['key' => $section['key']],
                [
                    'type' => $section['type'],
                    'payload' => $section['payload'],
                    'sort_order' => $section['sort_order'],
                    'is_active' => $section['is_active'],
                ],
            );

            foreach ($section['translations'] as $field => $value) {
                $model->setTranslation('de', $field, $value);
            }
        }
    }

    /**
     * @return array<int, array{key: string, type: string, payload: array<string, mixed>, sort_order: int, is_active: bool, translations: array<string, string>}>
     */
    private function sections(): array
    {
        return [
            [
                'key' => 'hero',
                'type' => 'image',
                'payload' => [
                    'image_path' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=2200&q=85',
                ],
                'sort_order' => 0,
                'is_active' => true,
                'translations' => [
                    'title' => 'Goan Perfume',
                    'body' => 'Feine Duftauswahl mit Luxus-, Nischen- und arabischen Parfums. Online entdecken, direkt beraten lassen.',
                    'cta_text' => 'Kollektion entdecken',
                ],
            ],
            [
                'key' => 'about',
                'type' => 'text',
                'payload' => [],
                'sort_order' => 10,
                'is_active' => true,
                'translations' => [
                    'title' => 'Duftberatung mit kuratierter Auswahl.',
                    'body' => 'Goan Perfume verbindet bekannte Designerprofile, seltenere Nischenrichtungen und intensive arabische Dufttraditionen. Jede Auswahl ist fuer direkte Beratung, Preisvergleich und schnelle Anfrage vorbereitet.',
                ],
            ],
            [
                'key' => 'why_us',
                'type' => 'text',
                'payload' => [],
                'sort_order' => 20,
                'is_active' => true,
                'translations' => [
                    'title' => 'Warum Kunden bei Goan Perfume anfragen.',
                    'bullet_points' => json_encode([
                        'Klare Kategorien fuer schnelle Orientierung nach Anlass, Duftfamilie und Stil.',
                        'Mehrere Groessen pro Produkt mit transparenten Preisen fuer einfache Auswahl.',
                        'Direkte Beratung per WhatsApp, Telefon oder E-Mail statt anonymem Checkout.',
                        'Regelmaessig kuratierte Aktionen fuer neue Duftentdeckungen.',
                    ], JSON_THROW_ON_ERROR),
                ],
            ],
            [
                'key' => 'featured_products',
                'type' => 'product_list',
                'payload' => ['product_ids' => []],
                'sort_order' => 30,
                'is_active' => true,
                'translations' => [],
            ],
        ];
    }
}
