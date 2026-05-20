<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * @var list<array{slug: string, translations: array{de: array{name: string, description: string}, en: array{name: string, description: string}, ar: array{name: string, description: string}}, image_path: string}>
     */
    private const CATEGORIES = [
        [
            'slug' => 'luxusparfums',
            'translations' => [
                'de' => [
                    'name' => 'Luxusparfums',
                    'description' => 'Opulente Duftsignaturen mit Tiefe, langer Haltbarkeit und hochwertiger Sillage.',
                ],
                'en' => [
                    'name' => 'Luxury Perfumes',
                    'description' => 'Opulent scent signatures with depth, long wear, and refined sillage.',
                ],
                'ar' => [
                    'name' => 'عطور فاخرة',
                    'description' => 'تواقيع عطرية فخمة بعمق وثبات طويل وانتشار راق.',
                ],
            ],
            'image_path' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'nischenparfums',
            'translations' => [
                'de' => [
                    'name' => 'Nischenparfums',
                    'description' => 'Ausdrucksstarke Kompositionen abseits klassischer Duftregale.',
                ],
                'en' => [
                    'name' => 'Niche Perfumes',
                    'description' => 'Expressive compositions beyond the classic fragrance shelf.',
                ],
                'ar' => [
                    'name' => 'عطور نيش',
                    'description' => 'تركيبات معبرة بعيدة عن رفوف العطور التقليدية.',
                ],
            ],
            'image_path' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'designerparfums',
            'translations' => [
                'de' => [
                    'name' => 'Designerparfums',
                    'description' => 'Bekannte Duftprofile mit moderner Eleganz fuer Alltag, Office und Abend.',
                ],
                'en' => [
                    'name' => 'Designer Perfumes',
                    'description' => 'Recognizable scent profiles with modern elegance for daily wear, office, and evening.',
                ],
                'ar' => [
                    'name' => 'عطور مصممين',
                    'description' => 'روائح معروفة بأناقة عصرية للاستخدام اليومي والعمل والمساء.',
                ],
            ],
            'image_path' => 'https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'arabische-parfums',
            'translations' => [
                'de' => [
                    'name' => 'Arabische Parfums',
                    'description' => 'Warme Amber-, Oud- und Gewuerzakkorde mit intensiver Praesenz.',
                ],
                'en' => [
                    'name' => 'Arabic Perfumes',
                    'description' => 'Warm amber, oud, and spice accords with intense presence.',
                ],
                'ar' => [
                    'name' => 'عطور عربية',
                    'description' => 'اتفاقات دافئة من العنبر والعود والتوابل بحضور قوي.',
                ],
            ],
            'image_path' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'damenparfums',
            'translations' => [
                'de' => [
                    'name' => 'Damenparfums',
                    'description' => 'Florale, pudrige und fruchtige Duftbilder von dezent bis sinnlich.',
                ],
                'en' => [
                    'name' => "Women's Perfumes",
                    'description' => 'Floral, powdery, and fruity scent profiles from subtle to sensual.',
                ],
                'ar' => [
                    'name' => 'عطور نسائية',
                    'description' => 'روائح زهرية وبودرية وفاكهية من الهادئ إلى الحسي.',
                ],
            ],
            'image_path' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'herrenparfums',
            'translations' => [
                'de' => [
                    'name' => 'Herrenparfums',
                    'description' => 'Holzige, aromatische und frische Profile fuer klare Kontur.',
                ],
                'en' => [
                    'name' => "Men's Perfumes",
                    'description' => 'Woody, aromatic, and fresh profiles with a clear outline.',
                ],
                'ar' => [
                    'name' => 'عطور رجالية',
                    'description' => 'روائح خشبية وعطرية ومنعشة بطابع واضح.',
                ],
            ],
            'image_path' => 'https://images.unsplash.com/photo-1619994403073-2cec844b8e63?auto=format&fit=crop&w=1400&q=80',
        ],
        [
            'slug' => 'unisex-parfums',
            'translations' => [
                'de' => [
                    'name' => 'Unisex-Parfums',
                    'description' => 'Ausgewogene Duftcharaktere ohne starre Grenzen.',
                ],
                'en' => [
                    'name' => 'Unisex Perfumes',
                    'description' => 'Balanced scent characters without rigid boundaries.',
                ],
                'ar' => [
                    'name' => 'عطور للجنسين',
                    'description' => 'شخصيات عطرية متوازنة بلا حدود صارمة.',
                ],
            ],
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

            foreach ($category['translations'] as $locale => $translation) {
                $model->setTranslation($locale, 'name', $translation['name']);
                $model->setTranslation($locale, 'description', $translation['description']);
                $model->setTranslation($locale, 'meta_title', $translation['name']);
                $model->setTranslation(
                    $locale,
                    'meta_description',
                    Str::limit(Str::squish($translation['description']), 160, ''),
                );
            }
        }
    }
}
