<?php

namespace Database\Seeders;

use App\Models\PageSection;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = $this->sections();
        $keys = collect($sections)->pluck('key')->all();

        PageSection::query()
            ->whereNotIn('key', $keys)
            ->with('translations')
            ->each(function (PageSection $section): void {
                $section->translations()->delete();
                $section->delete();
            });

        foreach ($sections as $section) {
            $model = PageSection::query()->updateOrCreate(
                ['key' => $section['key']],
                [
                    'type' => $section['type'],
                    'payload' => $section['payload'],
                    'sort_order' => $section['sort_order'],
                    'is_active' => $section['is_active'],
                ],
            );

            $this->syncTranslations($model, $section['translations']);
        }
    }

    /**
     * @return array<int, array{key: string, type: string, payload: array<string, mixed>, sort_order: int, is_active: bool, translations: array<string, array<string, string>>}>
     */
    private function sections(): array
    {
        $whyUsBullets = [
            'de' => [
                'Kuratiert nach Duftfamilie, Stimmung und Noten, damit die Auswahl schnell eingrenzbar bleibt.',
                'Klare Größen und Preise pro Duft, ohne versteckte Schritte oder anonymen Checkout.',
                'Direkte Beratung per WhatsApp, Telefon oder E-Mail für Auswahl, Verfügbarkeit und Reservierung.',
                'Mehrsprachige Inhalte für Deutsch, Englisch und Arabisch direkt aus der gepflegten Kollektion.',
            ],
            'en' => [
                'Curated by fragrance family, mood, and notes so the right direction is easy to narrow down.',
                'Clear sizes and prices for each scent, without hidden steps or anonymous checkout.',
                'Direct advice by WhatsApp, phone, or email for selection, availability, and reservation.',
                'German, English, and Arabic content served from the maintained collection.',
            ],
            'ar' => [
                'تنسيق حسب عائلة العطر والمزاج والنوتات لتسهيل تضييق الاختيار بسرعة.',
                'أحجام وأسعار واضحة لكل عطر من دون خطوات مخفية أو دفع مجهول.',
                'استشارة مباشرة عبر واتساب أو الهاتف أو البريد للاختيار والتوفر والحجز.',
                'محتوى بالألمانية والإنجليزية والعربية من المجموعة المعتمدة.',
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
                        'title' => 'Parfums gezielt entdecken, persönlich beraten lassen.',
                        'body' => 'Goan Perfume bringt die aktuelle Duftkollektion in klare Kategorien: Damen, Herren, Unisex und Luxus. Vergleiche Noten, Größen und Preise online und frage deinen Favoriten direkt an.',
                        'cta_text' => 'Kollektion ansehen',
                    ],
                    'en' => [
                        'title' => 'Discover fragrances clearly, then get personal advice.',
                        'body' => 'Goan Perfume organizes the current collection into women, men, unisex, and luxury categories. Compare notes, sizes, and prices online, then ask directly about your favorite.',
                        'cta_text' => 'View collection',
                    ],
                    'ar' => [
                        'title' => 'اكتشف العطور بوضوح واحصل على استشارة مباشرة.',
                        'body' => 'ينظم Goan Perfume المجموعة الحالية ضمن فئات نسائية ورجالية ويونيسكس وفاخرة. قارن النوتات والأحجام والأسعار أونلاين ثم اسأل مباشرة عن عطرك المفضل.',
                        'cta_text' => 'عرض المجموعة',
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
                        'title' => 'Eine gepflegte Duftliste statt unübersichtlicher Produktpflege.',
                        'body' => 'Die Kollektion wird aus einer festen Produktbasis gespeist und im Shop sauber nach Kategorien, Duftfamilien, Stimmungen und Noten strukturiert. So bleiben lokale Tests, erste Produktionsseeds und spätere Aktualisierungen konsistent.',
                    ],
                    'en' => [
                        'title' => 'A maintained fragrance list instead of scattered product entry.',
                        'body' => 'The collection is fed from a fixed product source and presented by category, fragrance family, mood, and notes. Local tests, first production seeds, and future updates stay consistent.',
                    ],
                    'ar' => [
                        'title' => 'قائمة عطور منظّمة بدل إدخال منتجات متفرق.',
                        'body' => 'تعتمد المجموعة على مصدر منتجات ثابت وتُعرض حسب الفئة وعائلة العطر والمزاج والنوتات. لذلك تبقى الاختبارات المحلية وأول Seed للإنتاج والتحديثات اللاحقة متناسقة.',
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
                        'title' => 'Warum die Auswahl leichter wird.',
                        'bullet_points' => json_encode($whyUsBullets['de'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                    'en' => [
                        'title' => 'Why choosing gets easier.',
                        'bullet_points' => json_encode($whyUsBullets['en'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                    'ar' => [
                        'title' => 'لماذا يصبح الاختيار أسهل.',
                        'bullet_points' => json_encode($whyUsBullets['ar'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ],
                ],
            ],
        ];
    }

    /**
     * @param  array<string, array<string, string>>  $translations
     */
    private function syncTranslations(PageSection $section, array $translations): void
    {
        $allowed = [];

        foreach ($translations as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value === '') {
                    continue;
                }

                $section->setTranslation($locale, $field, $value);
                $allowed[] = "{$locale}.{$field}";
            }
        }

        $section->translations()
            ->get()
            ->reject(fn (Translation $translation): bool => in_array("{$translation->locale}.{$translation->field}", $allowed, true))
            ->each->delete();
    }
}
