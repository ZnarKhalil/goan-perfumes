<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeValueSeeder extends Seeder
{
    /**
     * Values per attribute code, ordered as in section 3 of docs/PROJECT.md.
     *
     * @var array<string, list<array{de: string, en: string, ar: string}>>
     */
    private const VALUES = [
        'art' => [
            ['de' => 'Luxus', 'en' => 'Luxury', 'ar' => 'فاخر'],
            ['de' => 'Nische', 'en' => 'Niche', 'ar' => 'نيش'],
            ['de' => 'Designer', 'en' => 'Designer', 'ar' => 'مصمم'],
            ['de' => 'Arabisch', 'en' => 'Arabic', 'ar' => 'عربي'],
        ],
        'familie' => [
            ['de' => 'Orientalisch', 'en' => 'Oriental', 'ar' => 'شرقي'],
            ['de' => 'Blumig', 'en' => 'Floral', 'ar' => 'زهري'],
            ['de' => 'Zitrisch', 'en' => 'Citrus', 'ar' => 'حمضي'],
            ['de' => 'Holzig', 'en' => 'Woody', 'ar' => 'خشبي'],
            ['de' => 'Gourmand', 'en' => 'Gourmand', 'ar' => 'غورماند'],
            ['de' => 'Aromatisch', 'en' => 'Aromatic', 'ar' => 'عطري'],
            ['de' => 'Aquatisch', 'en' => 'Aquatic', 'ar' => 'مائي'],
            ['de' => 'Ledrig', 'en' => 'Leather', 'ar' => 'جلدي'],
            ['de' => 'Fruchtig', 'en' => 'Fruity', 'ar' => 'فاكهي'],
            ['de' => 'Chypre', 'en' => 'Chypre', 'ar' => 'شيبر'],
        ],
        'stimmung' => [
            ['de' => 'Frisch', 'en' => 'Fresh', 'ar' => 'منعش'],
            ['de' => 'Warm', 'en' => 'Warm', 'ar' => 'دافئ'],
            ['de' => 'Elegant', 'en' => 'Elegant', 'ar' => 'أنيق'],
            ['de' => 'Pudrig', 'en' => 'Powdery', 'ar' => 'بودري'],
            ['de' => 'Sinnlich', 'en' => 'Sensual', 'ar' => 'حسي'],
            ['de' => 'Dunkel', 'en' => 'Dark', 'ar' => 'داكن'],
            ['de' => 'Sportlich', 'en' => 'Sporty', 'ar' => 'رياضي'],
            ['de' => 'Klassisch', 'en' => 'Classic', 'ar' => 'كلاسيكي'],
            ['de' => 'Modern', 'en' => 'Modern', 'ar' => 'عصري'],
        ],
        'noten' => [
            ['de' => 'Zitrone', 'en' => 'Lemon', 'ar' => 'ليمون'],
            ['de' => 'Bergamotte', 'en' => 'Bergamot', 'ar' => 'برغموت'],
            ['de' => 'Mandarine', 'en' => 'Mandarin', 'ar' => 'مندرين'],
            ['de' => 'Minze', 'en' => 'Mint', 'ar' => 'نعناع'],
            ['de' => 'Grüner Tee', 'en' => 'Green Tea', 'ar' => 'شاي أخضر'],
            ['de' => 'Meeresnoten', 'en' => 'Marine Notes', 'ar' => 'نوتات بحرية'],
            ['de' => 'Neroli', 'en' => 'Neroli', 'ar' => 'نيرولي'],
            ['de' => 'Maiglöckchen', 'en' => 'Lily of the Valley', 'ar' => 'زنبق الوادي'],
            ['de' => 'Orangenblüte', 'en' => 'Orange Blossom', 'ar' => 'زهر البرتقال'],
            ['de' => 'Jasmin', 'en' => 'Jasmine', 'ar' => 'ياسمين'],
            ['de' => 'Rose', 'en' => 'Rose', 'ar' => 'ورد'],
            ['de' => 'Iris', 'en' => 'Iris', 'ar' => 'سوسن'],
            ['de' => 'Tuberose', 'en' => 'Tuberose', 'ar' => 'مسك الروم'],
            ['de' => 'Apfel', 'en' => 'Apple', 'ar' => 'تفاح'],
            ['de' => 'Pfirsich', 'en' => 'Peach', 'ar' => 'خوخ'],
            ['de' => 'Kirsche', 'en' => 'Cherry', 'ar' => 'كرز'],
            ['de' => 'Feige', 'en' => 'Fig', 'ar' => 'تين'],
            ['de' => 'Lavendel', 'en' => 'Lavender', 'ar' => 'لافندر'],
            ['de' => 'Eichenmoos', 'en' => 'Oakmoss', 'ar' => 'طحلب السنديان'],
            ['de' => 'Vetiver', 'en' => 'Vetiver', 'ar' => 'فيتيفر'],
            ['de' => 'Rosa Pfeffer', 'en' => 'Pink Pepper', 'ar' => 'فلفل وردي'],
            ['de' => 'Ingwer', 'en' => 'Ginger', 'ar' => 'زنجبيل'],
            ['de' => 'Kardamom', 'en' => 'Cardamom', 'ar' => 'هيل'],
            ['de' => 'Zimt', 'en' => 'Cinnamon', 'ar' => 'قرفة'],
            ['de' => 'Safran', 'en' => 'Saffron', 'ar' => 'زعفران'],
            ['de' => 'Zedernholz', 'en' => 'Cedarwood', 'ar' => 'خشب الأرز'],
            ['de' => 'Sandelholz', 'en' => 'Sandalwood', 'ar' => 'خشب الصندل'],
            ['de' => 'Patchouli', 'en' => 'Patchouli', 'ar' => 'باتشولي'],
            ['de' => 'Oud', 'en' => 'Oud', 'ar' => 'عود'],
            ['de' => 'Tabak', 'en' => 'Tobacco', 'ar' => 'تبغ'],
            ['de' => 'Leder', 'en' => 'Leather', 'ar' => 'جلد'],
            ['de' => 'Weihrauch', 'en' => 'Incense', 'ar' => 'لبان'],
            ['de' => 'Kaffee', 'en' => 'Coffee', 'ar' => 'قهوة'],
            ['de' => 'Karamell', 'en' => 'Caramel', 'ar' => 'كراميل'],
            ['de' => 'Schokolade', 'en' => 'Chocolate', 'ar' => 'شوكولاتة'],
            ['de' => 'Vanille', 'en' => 'Vanilla', 'ar' => 'فانيليا'],
            ['de' => 'Tonkabohne', 'en' => 'Tonka Bean', 'ar' => 'حبوب التونكا'],
            ['de' => 'Amber', 'en' => 'Amber', 'ar' => 'عنبر'],
            ['de' => 'Moschus', 'en' => 'Musk', 'ar' => 'مسك'],
            ['de' => 'Benzoe', 'en' => 'Benzoin', 'ar' => 'بنزوين'],
            ['de' => 'Labdanum', 'en' => 'Labdanum', 'ar' => 'لادن'],
            ['de' => 'Aldehyde', 'en' => 'Aldehydes', 'ar' => 'ألدهيدات'],
            ['de' => 'Pistazie', 'en' => 'Pistachio', 'ar' => 'فستق'],
            ['de' => 'Mandel', 'en' => 'Almond', 'ar' => 'لوز'],
            ['de' => 'Ambroxan', 'en' => 'Ambroxan', 'ar' => 'أمبروكسان'],
            ['de' => 'Mango', 'en' => 'Mango', 'ar' => 'مانجو'],
            ['de' => 'Rum', 'en' => 'Rum', 'ar' => 'روم'],
            ['de' => 'Kokosnuss', 'en' => 'Coconut', 'ar' => 'جوز الهند'],
            ['de' => 'Himbeere', 'en' => 'Raspberry', 'ar' => 'توت العليق'],
            ['de' => 'Ananas', 'en' => 'Pineapple', 'ar' => 'أناناس'],
            ['de' => 'Aquatische', 'en' => 'Aquatic', 'ar' => 'مائي'],
        ],
    ];

    public function run(): void
    {
        $attributes = Attribute::query()->whereIn('code', array_keys(self::VALUES))->get()->keyBy('code');

        foreach (self::VALUES as $code => $names) {
            $attribute = $attributes[$code] ?? null;

            if ($attribute === null) {
                throw new \RuntimeException("Attribute '{$code}' must be seeded before its values.");
            }

            foreach ($names as $index => $translations) {
                $slug = Str::slug($translations['de'], '-', 'de');

                $value = AttributeValue::query()->updateOrCreate(
                    ['attribute_id' => $attribute->id, 'slug' => $slug],
                    ['sort_order' => $index, 'is_active' => true],
                );

                foreach ($translations as $locale => $name) {
                    $value->setTranslation($locale, 'name', $name);
                }
            }
        }
    }
}
