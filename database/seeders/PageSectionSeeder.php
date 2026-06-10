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

            foreach ($section['translations'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $model->setTranslation($locale, $field, $value);
                }
            }
        }
    }

    /**
     * @return array<int, array{key: string, type: string, payload: array<string, mixed>, sort_order: int, is_active: bool, translations: array<string, array<string, string>>}>
     */
    private function sections(): array
    {
        $whyUsBullets = [
            'de' => [
                'Klare Kategorien für schnelle Orientierung nach Anlass, Duftfamilie und Stil.',
                'Mehrere Größen pro Produkt mit transparenten Preisen für einfache Auswahl.',
                'Direkte Beratung per WhatsApp, Telefon oder E-Mail statt anonymem Checkout.',
                'Regelmäßig kuratierte Aktionen für neue Duftentdeckungen.',
            ],
            'en' => [
                'Clear categories for quick orientation by occasion, fragrance family, and style.',
                'Multiple sizes per product with transparent prices for an easy choice.',
                'Direct advice via WhatsApp, phone, or email instead of an anonymous checkout.',
                'Regularly curated campaigns for new fragrance discoveries.',
            ],
            'ar' => [
                'فئات واضحة للتوجّه السريع حسب المناسبة وعائلة العطر والأسلوب.',
                'أحجام متعدّدة لكل منتج بأسعار شفافة لاختيار سهل.',
                'استشارة مباشرة عبر واتساب أو الهاتف أو البريد بدل دفع مجهول.',
                'عروض مختارة بانتظام لاكتشافات عطرية جديدة.',
            ],
        ];

        return [
            [
                'key' => 'hero',
                'type' => 'image',
                'payload' => [],
                'sort_order' => 0,
                'is_active' => true,
                'translations' => [
                    'de' => [
                        'title' => 'Goan Perfume',
                        'body' => 'Feine Duftauswahl mit Luxus-, Nischen- und arabischen Parfums. Online entdecken, direkt beraten lassen.',
                        'cta_text' => 'Kollektion entdecken',
                    ],
                    'en' => [
                        'title' => 'Goan Perfume',
                        'body' => 'A refined selection of luxury, niche, and Arabian fragrances. Browse online, get personal advice.',
                        'cta_text' => 'Explore the collection',
                    ],
                    'ar' => [
                        'title' => 'Goan Perfume',
                        'body' => 'مجموعة عطور فاخرة ونيش وعربية مختارة. تصفّح أونلاين واحصل على استشارة مباشرة.',
                        'cta_text' => 'استكشف المجموعة',
                    ],
                ],
            ],
            [
                'key' => 'about',
                'type' => 'text',
                'payload' => [],
                'sort_order' => 10,
                'is_active' => true,
                'translations' => [
                    'de' => [
                        'title' => 'Duftberatung mit kuratierter Auswahl.',
                        'body' => 'Goan Perfume verbindet bekannte Designerprofile, seltenere Nischenrichtungen und intensive arabische Dufttraditionen. Jede Auswahl ist für direkte Beratung, Preisvergleich und schnelle Anfrage vorbereitet.',
                    ],
                    'en' => [
                        'title' => 'Fragrance advice with a curated selection.',
                        'body' => 'Goan Perfume combines well-known designer profiles, rarer niche directions, and intense Arabian scent traditions. Every choice is prepared for direct advice, price comparison, and quick inquiry.',
                    ],
                    'ar' => [
                        'title' => 'استشارة عطرية مع مجموعة مختارة.',
                        'body' => 'يجمع Goan Perfume بين عطور المصممين الشهيرة، واتجاهات نيش أقل شيوعاً، والتقاليد العطرية العربية المكثّفة. كل اختيار جاهز للاستشارة المباشرة ومقارنة الأسعار والاستفسار السريع.',
                    ],
                ],
            ],
            [
                'key' => 'why_us',
                'type' => 'text',
                'payload' => [],
                'sort_order' => 20,
                'is_active' => true,
                'translations' => [
                    'de' => [
                        'title' => 'Warum Kunden bei Goan Perfume anfragen.',
                        'bullet_points' => json_encode($whyUsBullets['de'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                    'en' => [
                        'title' => 'Why customers reach out to Goan Perfume.',
                        'bullet_points' => json_encode($whyUsBullets['en'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                    'ar' => [
                        'title' => 'لماذا يتواصل العملاء مع Goan Perfume.',
                        'bullet_points' => json_encode($whyUsBullets['ar'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                ],
            ],
        ];
    }
}
