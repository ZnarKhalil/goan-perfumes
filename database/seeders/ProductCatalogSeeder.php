<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()
            ->whereIn('slug', $this->categorySlugs())
            ->get()
            ->keyBy('slug');

        $attributeValues = AttributeValue::query()
            ->with('attribute')
            ->get()
            ->keyBy(fn (AttributeValue $value) => "{$value->attribute->code}.{$value->slug}");

        $overrides = $this->localeOverrides();

        foreach ($this->products() as $productData) {
            $product = Product::query()->updateOrCreate(
                ['slug' => $productData['slug']],
                [
                    'brand' => $productData['brand'],
                    'is_active' => true,
                    'is_featured' => $productData['is_featured'],
                ],
            );

            // Every product gets its German content, plus English and Arabic
            // overrides where provided. Meta is always derived from the name
            // and short description per locale (admins never edit it).
            $perLocale = [
                'de' => [
                    'name' => $productData['name'],
                    'short_description' => $productData['short_description'],
                    'description' => $productData['description'],
                ],
                'en' => $overrides[$productData['slug']]['en'] ?? [],
                'ar' => $overrides[$productData['slug']]['ar'] ?? [],
            ];

            foreach ($perLocale as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    if ($value === null || $value === '') {
                        continue;
                    }

                    $product->setTranslation($locale, $field, $value);
                }

                $name = $fields['name'] ?? null;
                $excerpt = $fields['short_description'] ?? $fields['description'] ?? null;

                if ($name !== null && $name !== '') {
                    $product->setTranslation($locale, 'meta_title', $name);
                }

                if ($excerpt !== null && $excerpt !== '') {
                    $product->setTranslation(
                        $locale,
                        'meta_description',
                        Str::limit(Str::squish(strip_tags($excerpt)), 160, ''),
                    );
                }
            }

            $product->categories()->sync(
                $categories
                    ->filter(fn (Category $category): bool => in_array($category->slug, $productData['categories'], true))
                    ->pluck('id'),
            );
            $product->attributeValues()->sync($this->attributeValueIds($attributeValues, $productData['attributes']));

            $this->seedVariants($product, $productData['variants']);
            $this->seedMedia($product, $productData['image_url']);
        }
    }

    /**
     * English and Arabic translations for product name and short description,
     * keyed by slug. The German `name` and `description` already live inside
     * products(); only deltas live here to keep the catalog readable.
     *
     * @return array<string, array{en: array{name: string, short_description: string}, ar: array{name: string, short_description: string}}>
     */
    private function localeOverrides(): array
    {
        return [
            'amber-noir-intense' => [
                'en' => ['name' => 'Amber Noir Intense', 'short_description' => 'Dark amber, vanilla, and oud with a soft smoky touch.'],
                'ar' => ['name' => 'أمبر نوار إنتنس', 'short_description' => 'عنبر غامق وفانيليا وعود بلمسة دخانية ناعمة.'],
            ],
            'rose-oud-velvet' => [
                'en' => ['name' => 'Rose Oud Velvet', 'short_description' => 'Velvety rose meets oud, saffron, and amber.'],
                'ar' => ['name' => 'روز عود فيلفت', 'short_description' => 'وردة مخملية تلتقي بالعود والزعفران والعنبر.'],
            ],
            'citrus-marine' => [
                'en' => ['name' => 'Citrus Marine', 'short_description' => 'Fresh bergamot, marine notes, and neroli.'],
                'ar' => ['name' => 'سيتروس مارين', 'short_description' => 'برغموت منعش ونوتات بحرية وزهر النارنج.'],
            ],
            'iris-musk-powder' => [
                'en' => ['name' => 'Iris Musk Powder', 'short_description' => 'Powdery iris with musk, tonka bean, and soft woods.'],
                'ar' => ['name' => 'إيريس مسك باودر', 'short_description' => 'إيريس بودري مع مسك وحبوب التونكا وخشب ناعم.'],
            ],
            'cedar-leather-club' => [
                'en' => ['name' => 'Cedar Leather Club', 'short_description' => 'Leather, cedarwood, and tobacco in masculine balance.'],
                'ar' => ['name' => 'سيدر ليذر كلوب', 'short_description' => 'جلد وخشب الأرز وتبغ بتوازن رجولي.'],
            ],
            'vanilla-tonka-gold' => [
                'en' => ['name' => 'Vanilla Tonka Gold', 'short_description' => 'Creamy vanilla, tonka bean, caramel, and benzoin.'],
                'ar' => ['name' => 'فانيلا تونكا غولد', 'short_description' => 'فانيليا كريمية وحبوب التونكا وكراميل وبنزوين.'],
            ],
            'bergamot-vetiver' => [
                'en' => ['name' => 'Bergamot Vetiver', 'short_description' => 'Citrus freshness with vetiver, green tea, and musk.'],
                'ar' => ['name' => 'برغموت فيتيفر', 'short_description' => 'انتعاش حمضي مع فيتيفر وشاي أخضر ومسك.'],
            ],
            'jasmine-fig-silk' => [
                'en' => ['name' => 'Jasmine Fig Silk', 'short_description' => 'Jasmine, fig, and sandalwood with a silky texture.'],
                'ar' => ['name' => 'جاسمين فيغ سيلك', 'short_description' => 'ياسمين وتين وخشب الصندل بقوام حريري.'],
            ],
            'coffee-cardamom' => [
                'en' => ['name' => 'Coffee Cardamom', 'short_description' => 'Coffee, cardamom, and dark chocolate with amber.'],
                'ar' => ['name' => 'كوفي كاردامون', 'short_description' => 'قهوة وهيل وشوكولاتة داكنة مع عنبر.'],
            ],
            'cherry-labdanum' => [
                'en' => ['name' => 'Cherry Labdanum', 'short_description' => 'Cherry, labdanum, and patchouli with dark sweetness.'],
                'ar' => ['name' => 'تشيري لادنوم', 'short_description' => 'كرز ولادن وباتشولي بحلاوة داكنة.'],
            ],
            'mint-neroli-sport' => [
                'en' => ['name' => 'Mint Neroli Sport', 'short_description' => 'Mint, neroli, and lemon for very clear freshness.'],
                'ar' => ['name' => 'مينت نيرولي سبورت', 'short_description' => 'نعناع وزهر النارنج وليمون بانتعاش صافٍ.'],
            ],
            'saffron-amber-royal' => [
                'en' => ['name' => 'Saffron Amber Royal', 'short_description' => 'Saffron, amber, oud, and cinnamon with regal warmth.'],
                'ar' => ['name' => 'سفرون أمبر رويال', 'short_description' => 'زعفران وعنبر وعود وقرفة بدفء ملكي.'],
            ],
        ];
    }

    /**
     * @return list<string>
     */
    private function categorySlugs(): array
    {
        return collect($this->products())
            ->flatMap(fn (array $product): array => $product['categories'])
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, AttributeValue>  $attributeValues
     * @param  array<string, list<string>>  $attributes
     * @return list<int>
     */
    private function attributeValueIds($attributeValues, array $attributes): array
    {
        $ids = [];

        foreach ($attributes as $code => $slugs) {
            foreach ($slugs as $slug) {
                $value = $attributeValues["{$code}.{$slug}"] ?? null;

                if ($value === null) {
                    throw new \RuntimeException("Attribute value '{$code}.{$slug}' must be seeded before products.");
                }

                $ids[] = $value->id;
            }
        }

        return $ids;
    }

    /**
     * @param  list<array{size_ml: int, price: string, compare_at_price?: string|null, is_default?: bool}>  $variants
     */
    private function seedVariants(Product $product, array $variants): void
    {
        foreach ($variants as $variant) {
            ProductVariant::query()->updateOrCreate(
                ['product_id' => $product->id, 'size_ml' => $variant['size_ml']],
                [
                    'price' => $variant['price'],
                    'compare_at_price' => $variant['compare_at_price'] ?? null,
                    'is_default' => $variant['is_default'] ?? false,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedMedia(Product $product, string $imageUrl): void
    {
        $product->media()->updateOrCreate(
            ['sort_order' => 0],
            [
                'path' => $imageUrl,
                'alt_text' => $product->translate('de', 'name') ?? $product->slug,
                'is_primary' => true,
            ],
        );
    }

    /**
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     brand: string,
     *     short_description: string,
     *     description: string,
     *     categories: list<string>,
     *     attributes: array<string, list<string>>,
     *     variants: list<array{size_ml: int, price: string, compare_at_price?: string|null, is_default?: bool}>,
     *     image_url: string,
     *     is_featured: bool
     * }>
     */
    private function products(): array
    {
        return [
            [
                'slug' => 'amber-noir-intense',
                'name' => 'Amber Noir Intense',
                'brand' => 'Goan Prive',
                'short_description' => 'Dunkler Amber, Vanille und Oud mit weicher Rauchigkeit.',
                'description' => 'Amber Noir Intense ist ein dichter Abendduft mit warmem Amber, cremiger Vanille, Oud und einem Hauch Weihrauch. Ideal fuer Kunden, die lange Haltbarkeit und starke Praesenz suchen.',
                'categories' => ['luxusparfums', 'arabische-parfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['orientalisch', 'holzig'],
                    'stimmung' => ['warm', 'sinnlich', 'dunkel'],
                    'noten' => ['amber', 'vanille', 'oud', 'weihrauch'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '49.90'],
                    ['size_ml' => 50, 'price' => '79.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '139.90', 'compare_at_price' => '159.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'slug' => 'rose-oud-velvet',
                'name' => 'Rose Oud Velvet',
                'brand' => 'Maison Al Noor',
                'short_description' => 'Samtige Rose trifft Oud, Safran und Amber.',
                'description' => 'Rose Oud Velvet kombiniert florale Tiefe mit arabischer Waerme. Safran und Amber geben dem Duft Volumen, waehrend Oud fuer einen eleganten, dunklen Abschluss sorgt.',
                'categories' => ['arabische-parfums', 'damenparfums', 'luxusparfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['blumig', 'orientalisch'],
                    'stimmung' => ['elegant', 'sinnlich', 'warm'],
                    'noten' => ['rose', 'oud', 'safran', 'amber'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '44.90'],
                    ['size_ml' => 50, 'price' => '69.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '119.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'slug' => 'citrus-marine',
                'name' => 'Citrus Marine',
                'brand' => 'Atelier Coast',
                'short_description' => 'Frische Bergamotte, Meeresnoten und Neroli.',
                'description' => 'Citrus Marine ist ein sauberer Tagesduft mit spritziger Bergamotte, transparenten Meeresnoten und einem leichten Neroli-Akkord. Besonders passend fuer warme Tage und Office.',
                'categories' => ['herrenparfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['designer'],
                    'familie' => ['zitrisch', 'aquatisch'],
                    'stimmung' => ['frisch', 'sportlich', 'modern'],
                    'noten' => ['bergamotte', 'meeresnoten', 'neroli', 'moschus'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '29.90'],
                    ['size_ml' => 50, 'price' => '45.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '79.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'slug' => 'iris-musk-powder',
                'name' => 'Iris Musk Powder',
                'brand' => 'Velvet Room',
                'short_description' => 'Pudrige Iris mit Moschus, Tonkabohne und sanftem Holz.',
                'description' => 'Iris Musk Powder wirkt gepflegt, leise und sehr elegant. Iris, Moschus und Tonkabohne bilden ein pudrig-cremiges Profil mit sauberem Sandelholz im Fond.',
                'categories' => ['damenparfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['blumig', 'holzig'],
                    'stimmung' => ['pudrig', 'elegant', 'klassisch'],
                    'noten' => ['iris', 'moschus', 'tonkabohne', 'sandelholz'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '39.90'],
                    ['size_ml' => 50, 'price' => '64.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '109.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59d32?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => true,
            ],
            [
                'slug' => 'cedar-leather-club',
                'name' => 'Cedar Leather Club',
                'brand' => 'Nocturne',
                'short_description' => 'Leder, Zedernholz und Tabak in maskuliner Balance.',
                'description' => 'Cedar Leather Club ist ein trockener, selbstbewusster Duft mit Leder, Zedernholz, Tabak und einem Hauch rosa Pfeffer. Klare Wahl fuer den Abend.',
                'categories' => ['herrenparfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['ledrig', 'holzig'],
                    'stimmung' => ['dunkel', 'klassisch', 'warm'],
                    'noten' => ['leder', 'zedernholz', 'tabak', 'rosa-pfeffer'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '42.90'],
                    ['size_ml' => 50, 'price' => '67.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '118.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1619994403073-2cec844b8e63?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'vanilla-tonka-gold',
                'name' => 'Vanilla Tonka Gold',
                'brand' => 'Goan Gourmand',
                'short_description' => 'Cremige Vanille, Tonkabohne, Karamell und Benzoe.',
                'description' => 'Vanilla Tonka Gold ist warm, gourmand und komfortabel. Karamell und Tonkabohne geben dem Duft Suessigkeit, Benzoe sorgt fuer einen weichen Harzton.',
                'categories' => ['luxusparfums', 'damenparfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['designer'],
                    'familie' => ['gourmand', 'orientalisch'],
                    'stimmung' => ['warm', 'sinnlich'],
                    'noten' => ['vanille', 'tonkabohne', 'karamell', 'benzoe'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '34.90'],
                    ['size_ml' => 50, 'price' => '54.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '94.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'bergamot-vetiver',
                'name' => 'Bergamot Vetiver',
                'brand' => 'Atelier Coast',
                'short_description' => 'Zitrische Frische mit Vetiver, gruenem Tee und Moschus.',
                'description' => 'Bergamot Vetiver bleibt hell, gepflegt und trocken. Gruener Tee und Bergamotte starten frisch, Vetiver und Moschus halten den Duft ruhig und erwachsen.',
                'categories' => ['herrenparfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['designer'],
                    'familie' => ['zitrisch', 'aromatisch'],
                    'stimmung' => ['frisch', 'elegant', 'modern'],
                    'noten' => ['bergamotte', 'gruener-tee', 'vetiver', 'moschus'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '27.90'],
                    ['size_ml' => 50, 'price' => '43.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '74.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1600612253971-422e7f7faeb6?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'jasmine-fig-silk',
                'name' => 'Jasmine Fig Silk',
                'brand' => 'Velvet Room',
                'short_description' => 'Jasmin, Feige und Sandelholz mit seidiger Textur.',
                'description' => 'Jasmine Fig Silk verbindet helle Blueten mit milchiger Feige und weichem Sandelholz. Ein femininer, moderner Duft mit sanfter Projektion.',
                'categories' => ['damenparfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['blumig', 'fruchtig'],
                    'stimmung' => ['elegant', 'modern', 'sinnlich'],
                    'noten' => ['jasmin', 'feige', 'sandelholz', 'moschus'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '38.90'],
                    ['size_ml' => 50, 'price' => '61.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '104.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'coffee-cardamom',
                'name' => 'Coffee Cardamom',
                'brand' => 'Nocturne',
                'short_description' => 'Kaffee, Kardamom und dunkle Schokolade mit Amber.',
                'description' => 'Coffee Cardamom ist ein markanter Gourmand mit wuerzigem Auftakt. Kaffee, Kardamom und Schokolade treffen auf warmen Amber.',
                'categories' => ['herrenparfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['gourmand', 'aromatisch'],
                    'stimmung' => ['dunkel', 'warm', 'modern'],
                    'noten' => ['kaffee', 'kardamom', 'schokolade', 'amber'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '41.90'],
                    ['size_ml' => 50, 'price' => '65.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '112.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1590736704728-f4730bb30770?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'cherry-labdanum',
                'name' => 'Cherry Labdanum',
                'brand' => 'Goan Prive',
                'short_description' => 'Kirsche, Labdanum und Patchouli mit dunkler Suessigkeit.',
                'description' => 'Cherry Labdanum ist fruchtig, harzig und auffaellig. Kirsche und Labdanum geben eine dunkle Suessigkeit, Patchouli und Amber stabilisieren den Fond.',
                'categories' => ['luxusparfums', 'damenparfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['fruchtig', 'chypre'],
                    'stimmung' => ['sinnlich', 'dunkel'],
                    'noten' => ['kirsche', 'labdanum', 'patchouli', 'amber'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '46.90'],
                    ['size_ml' => 50, 'price' => '72.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '129.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'mint-neroli-sport',
                'name' => 'Mint Neroli Sport',
                'brand' => 'Atelier Coast',
                'short_description' => 'Minze, Neroli und Zitrone fuer sehr klare Frische.',
                'description' => 'Mint Neroli Sport ist hell, aktiv und unkompliziert. Minze und Zitrone starten kuehl, Neroli und Moschus machen den Duft sauber tragbar.',
                'categories' => ['herrenparfums'],
                'attributes' => [
                    'art' => ['designer'],
                    'familie' => ['zitrisch', 'aromatisch'],
                    'stimmung' => ['frisch', 'sportlich'],
                    'noten' => ['minze', 'neroli', 'zitrone', 'moschus'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '24.90'],
                    ['size_ml' => 50, 'price' => '39.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '69.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1595425964071-2c1ec90c8a7d?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
            [
                'slug' => 'saffron-amber-royal',
                'name' => 'Saffron Amber Royal',
                'brand' => 'Maison Al Noor',
                'short_description' => 'Safran, Amber, Oud und Zimt mit koeniglicher Waerme.',
                'description' => 'Saffron Amber Royal ist eine intensive arabische Komposition. Safran und Zimt leuchten im Auftakt, Oud und Amber geben Tiefe und lange Haltbarkeit.',
                'categories' => ['arabische-parfums', 'luxusparfums', 'unisex-parfums'],
                'attributes' => [
                    'art' => ['nische'],
                    'familie' => ['orientalisch', 'holzig'],
                    'stimmung' => ['warm', 'elegant', 'sinnlich'],
                    'noten' => ['safran', 'amber', 'oud', 'zimt'],
                ],
                'variants' => [
                    ['size_ml' => 30, 'price' => '52.90'],
                    ['size_ml' => 50, 'price' => '84.90', 'is_default' => true],
                    ['size_ml' => 100, 'price' => '149.90'],
                ],
                'image_url' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?auto=format&fit=crop&w=1200&q=80',
                'is_featured' => false,
            ],
        ];
    }
}
