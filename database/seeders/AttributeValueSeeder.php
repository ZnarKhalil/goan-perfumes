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
     * @var array<string, list<string>>
     */
    private const VALUES = [
        'art' => ['Nische', 'Designer'],
        'familie' => [
            'Orientalisch', 'Blumig', 'Zitrisch', 'Holzig', 'Gourmand',
            'Aromatisch', 'Aquatisch', 'Ledrig', 'Fruchtig', 'Chypre',
        ],
        'stimmung' => [
            'Frisch', 'Warm', 'Elegant', 'Pudrig', 'Sinnlich',
            'Dunkel', 'Sportlich', 'Klassisch', 'Modern',
        ],
        'noten' => [
            'Zitrone', 'Bergamotte', 'Mandarine', 'Minze', 'Grüner Tee',
            'Meeresnoten', 'Neroli', 'Maiglöckchen', 'Orangenblüte', 'Jasmin',
            'Rose', 'Iris', 'Tuberose', 'Apfel', 'Pfirsich',
            'Kirsche', 'Feige', 'Lavendel', 'Eichenmoos', 'Vetiver',
            'Rosa Pfeffer', 'Ingwer', 'Kardamom', 'Zimt', 'Safran',
            'Zedernholz', 'Sandelholz', 'Patchouli', 'Oud', 'Tabak',
            'Leder', 'Weihrauch', 'Kaffee', 'Karamell', 'Schokolade',
            'Vanille', 'Tonkabohne', 'Amber', 'Moschus', 'Benzoe',
            'Labdanum', 'Aldehyde',
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

            foreach ($names as $index => $name) {
                $slug = Str::slug($name, '-', 'de');

                $value = AttributeValue::query()->updateOrCreate(
                    ['attribute_id' => $attribute->id, 'slug' => $slug],
                    ['sort_order' => $index, 'is_active' => true],
                );

                $value->setTranslation('de', 'name', $name);
            }
        }
    }
}
