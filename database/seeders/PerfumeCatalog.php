<?php

namespace Database\Seeders;

final class PerfumeCatalog
{
    /**
     * @return list<array{slug: string, translations: array<string, array{name: string, short_description: string, description: string}>, categories: list<string>, attributes: array<string, list<string>>, variants: list<array{size_ml: int, price: string, compare_at_price: string|null, is_default: bool}>}>
     */
    public static function products(): array
    {
        return [
            0 => [
                'slug' => 'd1',
                'translations' => [
                    'de' => [
                        'name' => 'D1',
                        'short_description' => '',
                        'description' => 'Ein kühner Damenduft, der pure Verführung und Weiblichkeit verkörpert. Startet mit intensivem Honig und bleibt warm und langanhaltend.',
                    ],
                    'en' => [
                        'name' => 'D1',
                        'short_description' => '',
                        'description' => 'A bold women\'s fragrance embodying pure seduction and femininity. Opens with intense honey and settles into a long-lasting warm trail.',
                    ],
                    'ar' => [
                        'name' => 'D1',
                        'short_description' => '',
                        'description' => 'عطر نسائي جريء ومثير يجسد الأنوثة الصاخبة والجاذبية. يفتتح بحلاوة العسل المكثفة وينتهي بلمسة ترابية دافئة تدوم طويلاً.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'blutorange',
                        1 => 'gardenie',
                        2 => 'honig',
                        3 => 'patchouli',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            1 => [
                'slug' => 'd2',
                'translations' => [
                    'de' => [
                        'name' => 'D2',
                        'short_description' => '',
                        'description' => 'Eine außergewöhnliche Komposition, die die Süße von Baiser mit einer maritimen Salznote vereint, während ein reines florales Herz dem Duft eine einzigartige, moderne Note verleiht.',
                    ],
                    'en' => [
                        'name' => 'D2',
                        'short_description' => '',
                        'description' => 'An extraordinary blend combining the sweetness of delicate meringue with a touch of sea salt, while a pure floral heart gives the fragrance a unique, modern character.',
                    ],
                    'ar' => [
                        'name' => 'D2',
                        'short_description' => '',
                        'description' => 'مزيج استثنائي يجمع بين حلاوة حلوى المارينج الهشة ولمسة الملح البحرية، مع قلب زهري نقي يمنح العطر طابعاً عصرياً فريداً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'baiser',
                        1 => 'lilie',
                        2 => 'salz',
                        3 => 'weisse-blueten',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            2 => [
                'slug' => 'd3',
                'translations' => [
                    'de' => [
                        'name' => 'D3',
                        'short_description' => '',
                        'description' => 'Eine fesselnde Komposition aus spritziger Zitrusfrucht, süßer Himbeere und edlen weißen Blüten, abgerundet durch eine warme Basis aus Honig und Patschuli',
                    ],
                    'en' => [
                        'name' => 'D3',
                        'short_description' => '',
                        'description' => 'A captivating blend combining vibrant citrus, sweet raspberry, and elegant white florals, finished with a warm, deep base of honey and patchouli.',
                    ],
                    'ar' => [
                        'name' => 'D3',
                        'short_description' => '',
                        'description' => 'مزيج آسر يمزج بين انتعاش الحمضيات، حلاوة التوت والزهور البيضاء، مع قاعدة عميقة من العسل والباتشولي',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'exklusiv',
                        2 => 'selbstbewusst',
                    ],
                    'noten' => [
                        0 => 'bitterorange',
                        1 => 'himbeere',
                        2 => 'honig',
                        3 => 'jasmin-sambac',
                        4 => 'neroli',
                        5 => 'orangenbluete',
                        6 => 'patchouli',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            3 => [
                'slug' => 'd4',
                'translations' => [
                    'de' => [
                        'name' => 'D4',
                        'short_description' => '',
                        'description' => 'A perfect balance between vibrant mandarin and aquatic jasmine, enhanced by a seductive touch of salted vanilla and amber.',
                    ],
                    'en' => [
                        'name' => 'D4',
                        'short_description' => '',
                        'description' => 'Ein perfektes Gleichgewicht zwischen spritziger Mandarine und Wasserjasmin, veredelt durch eine verführerische Note aus gesalzener Vanille und Ambra.',
                    ],
                    'ar' => [
                        'name' => 'D4',
                        'short_description' => '',
                        'description' => 'توازن مثالي بين انتعاش المندرين والياسمين المائي مع لمسة دافئة ومغرية من الفانيليا المملحة والأمبرة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'charismatisch',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'gesalzene-vanille',
                        2 => 'gruene-mandarine',
                        3 => 'kaschmirholz',
                        4 => 'wasserjasmin',
                        5 => 'zieringwer',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            4 => [
                'slug' => 'd5',
                'translations' => [
                    'de' => [
                        'name' => 'D5',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse Komposition aus süßem Karamell und Vanille, vereint mit einem frischen Blütenherz und warmen, moosig-moschusartigen Akzenten.',
                    ],
                    'en' => [
                        'name' => 'D5',
                        'short_description' => '',
                        'description' => 'A luxurious blend combining sweet caramel and vanilla with a fresh floral heart and warm, musky-mossy undertones.',
                    ],
                    'ar' => [
                        'name' => 'D5',
                        'short_description' => '',
                        'description' => 'توليفة فاخرة تجمع بين حلاوة الكراميل والفانيليا مع قلب زهري منعش ولمسات خشبية ومسكية دافئة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'professionell',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'birne',
                        1 => 'bourbon-vanille-absolue',
                        2 => 'jasmin',
                        3 => 'karamell',
                        4 => 'lavendel',
                        5 => 'madagassische-mandarine',
                        6 => 'madagassischer-ylang-ylang',
                        7 => 'moosige-noten',
                        8 => 'moschus',
                        9 => 'rosenoxid',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            5 => [
                'slug' => 'd6',
                'translations' => [
                    'de' => [
                        'name' => 'D6',
                        'short_description' => '',
                        'description' => 'Ein üppiges, höchst feminines Blütenbouquet, das die Schönheit von Rose und Jasmin in vollendeter Form zelebriert.',
                    ],
                    'en' => [
                        'name' => 'D6',
                        'short_description' => '',
                        'description' => 'A rich, ultra-feminine floral bouquet that celebrates the beauty of rose and jasmine in their most exquisite form.',
                    ],
                    'ar' => [
                        'name' => 'D6',
                        'short_description' => '',
                        'description' => 'باقة زهرية غنية وفائقة الأنوثة، تحتفي بجمال الورد والياسمين في أبهى صورهما',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'damaszener-rose',
                        1 => 'grasse-jasmin',
                        2 => 'jasmin-sambac',
                        3 => 'komorischer-ylang-ylang',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            6 => [
                'slug' => 'd7',
                'translations' => [
                    'de' => [
                        'name' => 'D7',
                        'short_description' => '',
                        'description' => 'Eine lebendige und strahlende Komposition aus frischen italienischen Zitrusnoten und einem zarten Frühlingsblüten-Bouquet, abgerundet durch weichen Moschus.',
                    ],
                    'en' => [
                        'name' => 'D7',
                        'short_description' => '',
                        'description' => 'A vibrant and radiant blend combining fresh Italian citrus notes with a delicate bouquet of spring florals, finished with a soft touch of musk.',
                    ],
                    'ar' => [
                        'name' => 'D7',
                        'short_description' => '',
                        'description' => 'مزيج حيوي ومشرق يجمع بين انتعاش الحمضيات الإيطالية وباقة من الزهور الربيعية الرقيقة بلمسة مسكية ناعمة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'klassisch',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'damaszener-rose',
                        1 => 'kalabrische-bergamotte',
                        2 => 'maigloeckchen',
                        3 => 'pfingstrose',
                        4 => 'sizilianische-mandarine',
                        5 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            7 => [
                'slug' => 'd8',
                'translations' => [
                    'de' => [
                        'name' => 'D8',
                        'short_description' => '',
                        'description' => 'Eine reiche und verführerische Komposition, die samtige Früchte mit luxuriösen weißen Blüten verbindet und in einem warmen Ausklang aus Sandelholz und Vanille endet.',
                    ],
                    'en' => [
                        'name' => 'D8',
                        'short_description' => '',
                        'description' => 'A mysterious and intense fragrance that blends the sweetness of tropical fruits and warm spices with an opulent floral heart and a creamy base.',
                    ],
                    'ar' => [
                        'name' => 'D8',
                        'short_description' => '',
                        'description' => 'تركيبة غنية ومغرية تمزج بين الفواكه المخملية والزهور البيضاء الفاخرة، لتنتهي بلمسة دافئة من خشب الصندل والفانيليا.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'unvergesslich',
                        2 => 'intensiv',
                    ],
                    'noten' => [
                        0 => 'aprikose',
                        1 => 'bittermandel',
                        2 => 'jasmin-sambac',
                        3 => 'kokosnuss',
                        4 => 'maigloeckchen',
                        5 => 'pflaume',
                        6 => 'piment',
                        7 => 'rose',
                        8 => 'rosenholz',
                        9 => 'sandelholz',
                        10 => 'tuberose',
                        11 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            8 => [
                'slug' => 'd9',
                'translations' => [
                    'de' => [
                        'name' => 'D9',
                        'short_description' => '',
                        'description' => 'Eine strahlende Komposition voller lebendiger Zitrusnoten und reiner weißer Blüten, die auf einer warmen, edlen Holzbasis ruht.',
                    ],
                    'en' => [
                        'name' => 'D9',
                        'short_description' => '',
                        'description' => 'A radiant composition bursting with vibrant citrus and pure white florals, resting on a sophisticated, warm woody base.',
                    ],
                    'ar' => [
                        'name' => 'D9',
                        'short_description' => '',
                        'description' => 'توليفة مشرقة تفيض بحيوية الحمضيات ونقاء الزهور البيضاء، تستقر على قاعدة خشبية دافئة وراقية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'klassisch',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'gardenie',
                        2 => 'jasmin',
                        3 => 'mandarine',
                        4 => 'neroli',
                        5 => 'orange',
                        6 => 'sandelholz',
                        7 => 'weisser-amber',
                        8 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            9 => [
                'slug' => 'd10',
                'translations' => [
                    'de' => [
                        'name' => 'D10',
                        'short_description' => '',
                        'description' => 'Eine verspielte und attraktive Komposition aus fruchtiger Frische, süßem Karamell und Popcorn, abgerundet durch ein zartes Blütenherz und eine warme Basis',
                    ],
                    'en' => [
                        'name' => 'D10',
                        'short_description' => '',
                        'description' => 'A playful and alluring blend combining vibrant fruits, sweet caramel, and popcorn, finished with a delicate floral heart and a warm base.',
                    ],
                    'ar' => [
                        'name' => 'D10',
                        'short_description' => '',
                        'description' => 'مزيج مرح وجذاب يجمع بين حيوية الفواكه، حلاوة الكراميل والفشار، مع قلب زهري ناعم وقاعدة دافئة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'anziehend',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'ananas',
                        2 => 'jasmin',
                        3 => 'karamell',
                        4 => 'kirsche',
                        5 => 'mandarine',
                        6 => 'moschus',
                        7 => 'patchouli',
                        8 => 'popcorn',
                        9 => 'rose',
                        10 => 'veilchen',
                        11 => 'walderdbeere',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            10 => [
                'slug' => 'd11',
                'translations' => [
                    'de' => [
                        'name' => 'D11',
                        'short_description' => '',
                        'description' => 'Eine fesselnde Komposition, die die Wärme von Amber mit der Sanftheit weißer Blüten und einer reichen Vanillenote verbindet, was für Luxus und Anziehungskraft sorgt.',
                    ],
                    'en' => [
                        'name' => 'D11',
                        'short_description' => '',
                        'description' => 'A captivating blend that combines the warmth of amber with the softness of white florals, enriched with a deep vanilla note to create an aura of luxury and allure.',
                    ],
                    'ar' => [
                        'name' => 'D11',
                        'short_description' => '',
                        'description' => 'مزيج آسر يجمع بين دفء العنبر ونعومة الزهور البيضاء، مع لمسة فانيليا غنية تضفي طابعاً من الفخامة والجاذبية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'maskulin',
                        1 => 'professionell',
                        2 => 'selbstbewusst',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'jasmin',
                        2 => 'vanille',
                        3 => 'mandarine',
                        4 => 'orangenbluete',
                        5 => 'moschus',
                        6 => 'neroli',
                        7 => 'lavendel',
                        8 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            11 => [
                'slug' => 'd12',
                'translations' => [
                    'de' => [
                        'name' => 'D12',
                        'short_description' => '',
                        'description' => 'Eine kühne und aufregende Mischung, die die Energie von warmem Kaffee mit der Zartheit weißer Blüten verbindet, abgerundet durch eine tiefe, holzige Basis, die für ein geheimnisvolles und attraktives Flair sorgt.',
                    ],
                    'en' => [
                        'name' => 'D12',
                        'short_description' => '',
                        'description' => 'A bold and exciting blend that combines the energy of warm coffee with the delicacy of white florals, grounded by a deep woody base that adds a touch of mystery and allure.',
                    ],
                    'ar' => [
                        'name' => 'D12',
                        'short_description' => '',
                        'description' => 'مزيج جريء ومثير يجمع بين طاقة القهوة الدافئة ورقة الزهور البيضاء، مع قاعدة خشبية عميقة تضفي لمسة من الغموض والجاذبية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'unvergesslich',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'jasmin',
                        1 => 'kaffee',
                        2 => 'orangenbluete',
                        3 => 'patchouli',
                        4 => 'rosa-pfeffer',
                        5 => 'vanille',
                        6 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            12 => [
                'slug' => 'd13',
                'translations' => [
                    'de' => [
                        'name' => 'D13',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse, königliche Komposition, die die Frische von Zitrusfrüchten mit der Magie seltener Blüten und einer warmen Basis verbindet, die einen unvergesslichen Eindruck hinterlässt.',
                    ],
                    'en' => [
                        'name' => 'D13',
                        'short_description' => '',
                        'description' => 'A luxurious, regal composition that balances the freshness of citrus with the magic of rare florals, finished with a warm base that leaves an unforgettable trail.',
                    ],
                    'ar' => [
                        'name' => 'D13',
                        'short_description' => '',
                        'description' => 'تركيبة ملكية فاخرة توازن بين نضارة الحمضيات وسحر الزهور النادرة، مع قاعدة دافئة تترك أثراً لا ينسى.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'luxurioes',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'jasmin',
                        1 => 'amber',
                        2 => 'holzig',
                        3 => 'rose',
                        4 => 'mandarine',
                        5 => 'moschus',
                        6 => 'neroli',
                        7 => 'patchouli',
                        8 => 'johannisbeere',
                        9 => 'bergamotte',
                        10 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            13 => [
                'slug' => 'd14',
                'translations' => [
                    'de' => [
                        'name' => 'D14',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse florale Komposition, die durch Noten von Tuberose und Jasmin erstrahlt, ergänzt durch eine warme Basis aus Vanille und Holz, die für eine unwiderstehlich elegante Präsenz sorgt.',
                    ],
                    'en' => [
                        'name' => 'D14',
                        'short_description' => '',
                        'description' => 'A luxurious floral blend that shines with notes of tuberose and jasmine, complemented by a warm base of vanilla and wood, providing an irresistibly elegant presence.',
                    ],
                    'ar' => [
                        'name' => 'D14',
                        'short_description' => '',
                        'description' => 'مزيج زهري فخم يتألق بنفحات التوبيروز والياسمين، مع قاعدة دافئة من الفانيليا والأخشاب تمنحك حضوراً أنيقاً لا يقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'charismatisch',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'orangenbluete',
                        1 => 'tuberose',
                        2 => 'jasmin',
                        3 => 'bergamotte',
                        4 => 'vanille',
                        5 => 'zedernholz',
                        6 => 'moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            14 => [
                'slug' => 'd15',
                'translations' => [
                    'de' => [
                        'name' => 'D15',
                        'short_description' => '',
                        'description' => 'Eine zarte Mischung, die die Süße der Frucht mit der Frische der Blumen verbindet, ergänzt durch einen warmen Hauch von Vanille und Moschus, der für eine luxuriöse, samtige Ausstrahlung sorgt.',
                    ],
                    'en' => [
                        'name' => 'D15',
                        'short_description' => '',
                        'description' => 'A delicate blend combining the sweetness of fruit with the freshness of florals, finished with a warm touch of vanilla and musk that imparts a luxurious, velvety character.',
                    ],
                    'ar' => [
                        'name' => 'D15',
                        'short_description' => '',
                        'description' => 'مزيج رقيق يجمع بين حلاوة الفاكهة وانتعاش الزهور، مع لمسة دافئة من الفانيليا والمسك تضفي طابعاً مخملياً فاخراً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'jugendlich',
                        1 => 'anziehend',
                        2 => 'frisch',
                    ],
                    'noten' => [
                        0 => 'himbeere',
                        1 => 'neroli',
                        2 => 'patchouli',
                        3 => 'rose',
                        4 => 'vanille',
                        5 => 'moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            15 => [
                'slug' => 'd16',
                'translations' => [
                    'de' => [
                        'name' => 'D16',
                        'short_description' => '',
                        'description' => 'Eine reiche orientalische Duftsymphonie, die das Funkeln von Zitrusfrüchten mit der Zartheit weißer Blüten vereint und in einer tiefen, warmen Basis endet, die unvergleichlichen Luxus ausstrahlt.',
                    ],
                    'en' => [
                        'name' => 'D16',
                        'short_description' => '',
                        'description' => 'A rich oriental fragrance symphony that combines the sparkle of citrus with the softness of white florals, grounded by a deep, warm base that offers an incomparable sense of luxury.',
                    ],
                    'ar' => [
                        'name' => 'D16',
                        'short_description' => '',
                        'description' => 'سيمفونية عطرية شرقية غنية تجمع بين تألق الحمضيات ونعومة الزهور البيضاء، مع قاعدة عميقة ودافئة تمنحك إحساساً لا مثيل له بالفخامة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'jasmin',
                        2 => 'mandarine',
                        3 => 'mimose',
                        4 => 'opoponax',
                        5 => 'orange',
                        6 => 'orangenbluete',
                        7 => 'patchouli',
                        8 => 'rose',
                        9 => 'tonkabohne',
                        10 => 'vanille',
                        11 => 'vetiver',
                        12 => 'moschus',
                        13 => 'ylang-ylang',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            16 => [
                'slug' => 'd17',
                'translations' => [
                    'de' => [
                        'name' => 'D17',
                        'short_description' => '',
                        'description' => 'Eine lebendige Komposition, die die Frische von Zitrusfrüchten mit der Zartheit von Blüten ausbalanciert, abgerundet durch eine tiefe Holzbasis für ein Gefühl von Vertrauen und Erneuerung.',
                    ],
                    'en' => [
                        'name' => 'D17',
                        'short_description' => '',
                        'description' => 'A vibrant blend that balances citrus freshness with delicate florals, grounded by a deep woody base that provides a sense of confidence and renewal.',
                    ],
                    'ar' => [
                        'name' => 'D17',
                        'short_description' => '',
                        'description' => 'مزيج حيوي يوازن بين انتعاش الحمضيات ورقة الزهور، مع قاعدة خشبية عميقة تمنحك شعوراً بالثقة والتجدد',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'klassisch',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'iris',
                        2 => 'jasmin',
                        3 => 'moschus',
                        4 => 'patchouli',
                        5 => 'rosa-pfeffer',
                        6 => 'teakholz',
                        7 => 'vetiver',
                        8 => 'wasserhyazinthe',
                        9 => 'zedernholz',
                        10 => 'zitrusfruechte',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            17 => [
                'slug' => 'd18',
                'translations' => [
                    'de' => [
                        'name' => 'D18',
                        'short_description' => '',
                        'description' => 'Eine zeitlose, ikonische Komposition, die das Funkeln von Aldehyden mit der Opulenz seltener Blüten vereint, abgerundet durch eine warme, samtige Note für einen unvergleichlich klassischen Charakter.',
                    ],
                    'en' => [
                        'name' => 'D18',
                        'short_description' => '',
                        'description' => 'A timeless, iconic composition that blends the sparkle of aldehydes with the opulence of rare florals, finished with a warm, velvety touch that imparts an incomparably classic character.',
                    ],
                    'ar' => [
                        'name' => 'D18',
                        'short_description' => '',
                        'description' => 'تركيبة أيقونية خالدة تمزج بين تألق الألدهيدات وفخامة الزهور النادرة، مع لمسة دافئة ومخملية تمنح العطر طابعاً كلاسيكياً لا يضاهى',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'pudrig',
                    ],
                    'stimmung' => [
                        0 => 'klassisch',
                        1 => 'exklusiv',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'aldehyde',
                        1 => 'amber',
                        2 => 'bergamotte',
                        3 => 'jasmin',
                        4 => 'iris',
                        5 => 'maigloeckchen',
                        6 => 'rose',
                        7 => 'neroli',
                        8 => 'sandelholz',
                        9 => 'vanille',
                        10 => 'vetiver',
                        11 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            18 => [
                'slug' => 'd19',
                'translations' => [
                    'de' => [
                        'name' => 'D19',
                        'short_description' => '',
                        'description' => 'Eine raffinierte florale Komposition, die die Eleganz von Rose und Jasmin mit der Wärme von Sandelholz verbindet, während scharfe Gewürznoten für außergewöhnliche Tiefe und Luxus sorgen.',
                    ],
                    'en' => [
                        'name' => 'D19',
                        'short_description' => '',
                        'description' => 'A sophisticated floral blend combining the elegance of rose and jasmine with the warmth of sandalwood, accented by sharp spice notes that provide exceptional depth and luxury.',
                    ],
                    'ar' => [
                        'name' => 'D19',
                        'short_description' => '',
                        'description' => 'مزيج زهري متطور يجمع بين رقي الورد والياسمين ودفء خشب الصندل، مع لمسات توابل حادة تضفي عمقاً وفخامة استثنائية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'charismatisch',
                    ],
                    'noten' => [
                        0 => 'sandelholz',
                        1 => 'benzoe',
                        2 => 'rose',
                        3 => 'patchouli',
                        4 => 'bergamotte',
                        5 => 'jasmin',
                        6 => 'magnolie',
                        7 => 'mandarinenbluete',
                        8 => 'schwarzer-pfeffer',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            19 => [
                'slug' => 'd20',
                'translations' => [
                    'de' => [
                        'name' => 'D20',
                        'short_description' => '',
                        'description' => 'Eine moderne und verführerische Komposition, in der die Süße von Früchten und Blüten mit einer warmen, zuckrigen Note verschmilzt, um einen strahlenden und anziehenden Auftritt zu garantieren.',
                    ],
                    'en' => [
                        'name' => 'D20',
                        'short_description' => '',
                        'description' => 'A modern and seductive composition where the sweetness of fruits and florals blends with a warm, sugary touch to provide a radiant and alluring presence.',
                    ],
                    'ar' => [
                        'name' => 'D20',
                        'short_description' => '',
                        'description' => 'توليفة عصرية وجذابة تمتزج فيها حلاوة الفواكه والزهور مع لمسة سكرية دافئة، لتمنحك إطلالة مشرقة ومغرية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'jugendlich',
                        1 => 'charismatisch',
                        2 => 'warm',
                    ],
                    'noten' => [
                        0 => 'birnenbluete',
                        1 => 'brauner-zucker',
                        2 => 'frangipani',
                        3 => 'gardenie',
                        4 => 'mandarine',
                        5 => 'jasmin',
                        6 => 'patchouli',
                        7 => 'rote-beeren',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            20 => [
                'slug' => 'd21',
                'translations' => [
                    'de' => [
                        'name' => 'D21',
                        'short_description' => '',
                        'description' => 'Eine reiche, floral-fruchtige Komposition, die die Frische von Zitrusfrüchten mit der Zartheit weißer Blüten vereint, abgerundet durch eine warme orientalische Basis, die ein Gefühl von Weiblichkeit und Geheimnis verleiht.',
                    ],
                    'en' => [
                        'name' => 'D21',
                        'short_description' => '',
                        'description' => 'A rich floral-fruity blend that combines the freshness of citrus with the softness of white florals, grounded by a warm oriental base that evokes a sense of femininity and mystery.',
                    ],
                    'ar' => [
                        'name' => 'D21',
                        'short_description' => '',
                        'description' => 'مزيج زهري فاكهي غني يجمع بين انتعاش الحمضيات ونعومة الأزهار البيضاء، مع قاعدة شرقية دافئة تمنحك إحساساً بالأنوثة والغموض.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'luxurioes',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'jasmin',
                        3 => 'litschi',
                        4 => 'madonnenlilie',
                        5 => 'maigloeckchen',
                        6 => 'mandarine',
                        7 => 'moschus',
                        8 => 'pfirsich',
                        9 => 'pflaume',
                        10 => 'vanille',
                        11 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            21 => [
                'slug' => 'd22',
                'translations' => [
                    'de' => [
                        'name' => 'D22',
                        'short_description' => '',
                        'description' => 'Ein freudiges Dufterlebnis, das die Säure kandierter Zitrone mit der Zartheit von Orangenblüten verbindet, ergänzt durch eine warme Vanillebasis, die einen Hauch verführerischer Süße verleiht.',
                    ],
                    'en' => [
                        'name' => 'D22',
                        'short_description' => '',
                        'description' => 'A joyful fragrance experience that blends the acidity of candied lemon with the delicacy of orange blossoms, finished with a warm vanilla base that adds a touch of seductive sweetness.',
                    ],
                    'ar' => [
                        'name' => 'D22',
                        'short_description' => '',
                        'description' => 'تجربة عطرية مبهجة تمزج بين حمضية الليمون المحلى ونعومة الزهور، مع قاعدة دافئة من الفانيليا تضفي لمسة من الحلاوة المغرية.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'anziehend',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'kandierte-zitrone',
                        1 => 'orangenbluete',
                        2 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            22 => [
                'slug' => 'd23',
                'translations' => [
                    'de' => [
                        'name' => 'D23',
                        'short_description' => '',
                        'description' => 'Eine perfekte Balance zwischen der Frische von aromatischem Lavendel und der Tiefe reicher Vanille, abgerundet durch eine erdige Patchouli-Note, die dem Duft eine verführerische und tiefgründige Ausstrahlung verleiht.',
                    ],
                    'en' => [
                        'name' => 'D23',
                        'short_description' => '',
                        'description' => 'A perfect balance between the freshness of aromatic lavender and the depth of rich vanilla, finished with an earthy touch of patchouli that gives the fragrance a seductive and profound character.',
                    ],
                    'ar' => [
                        'name' => 'D23',
                        'short_description' => '',
                        'description' => 'توازن مثالي بين انتعاش اللافندر العطري وعمق الفانيليا الغنية، مع لمسة ترابية من الباتشولي تمنح العطر طابعاً جذاباً وعميقاً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'unvergesslich',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille',
                        1 => 'lavendel',
                        2 => 'patchouli',
                        3 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            23 => [
                'slug' => 'd24',
                'translations' => [
                    'de' => [
                        'name' => 'D24',
                        'short_description' => '',
                        'description' => 'Eine Explosion aus roten Waldfrüchten, die mit der Zartheit von Blüten verschmilzt, abgerundet durch einen warmen Hauch von Moschus und Amber für einen lebendigen und verführerischen Charakter.',
                    ],
                    'en' => [
                        'name' => 'D24',
                        'short_description' => '',
                        'description' => 'An explosion of red and wild berries blended with delicate florals, finished with a warm touch of musk and amber to create a vibrant and alluring character.',
                    ],
                    'ar' => [
                        'name' => 'D24',
                        'short_description' => '',
                        'description' => 'انفجار من الفواكه الحمراء والبرية يمتزج برقة الزهور، مع لمسة دافئة من المسك والعنبر تضفي طابعاً حيوياً ومغرياً.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'anziehend',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'brombeere',
                        2 => 'erdbeere',
                        3 => 'heidelbeere',
                        4 => 'himbeere',
                        5 => 'jasmin',
                        6 => 'kirsche',
                        7 => 'moschus',
                        8 => 'veilchen',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            24 => [
                'slug' => 'd25',
                'translations' => [
                    'de' => [
                        'name' => 'D25',
                        'short_description' => '',
                        'description' => 'Eine zarte Komposition, die die Frische von Rosenblüten mit der Wärme von Gewürzen vereint, abgerundet durch eine reiche, tiefe Basis, die für Eleganz und Verführung sorgt.',
                    ],
                    'en' => [
                        'name' => 'D25',
                        'short_description' => '',
                        'description' => 'A delicate blend that combines the freshness of rose petals with the warmth of spices, finished with a rich, deep base that adds a touch of elegance and allure.',
                    ],
                    'ar' => [
                        'name' => 'D25',
                        'short_description' => '',
                        'description' => 'مزيج رقيق يجمع بين انتعاش بتلات الورود ودفء التوابل، مع قاعدة غنية وعميقة تضفي لمسة من الأناقة والجاذبية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'pudrig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sauber',
                        1 => 'professionell',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'moschus',
                        2 => 'patchouli',
                        3 => 'pfingstrose',
                        4 => 'rosa-pfeffer',
                        5 => 'rose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            25 => [
                'slug' => 'd26',
                'translations' => [
                    'de' => [
                        'name' => 'D26',
                        'short_description' => '',
                        'description' => 'Eine reichhaltige und intensive Duftkomposition, die die Intensität von Kaffee und Kakao mit der Zartheit weißer Blüten verbindet, abgerundet durch eine warme Basis aus Gewürzen und Hölzern für eine kraftvolle und verführerische Ausstrahlung.',
                    ],
                    'en' => [
                        'name' => 'D26',
                        'short_description' => '',
                        'description' => 'A rich and intense fragrance composition, combining the sharpness of coffee and cocoa with the delicacy of white florals, grounded by a warm base of spices and woods to provide a powerful and alluring presence.',
                    ],
                    'ar' => [
                        'name' => 'D26',
                        'short_description' => '',
                        'description' => 'تركيبة عطرية غنية ومكثفة، تجمع بين حدة القهوة والكاكاو وبين رقة الزهور البيضاء، مع قاعدة دافئة من التوابل والأخشاب لتمنحك حضوراً قوياً وجذاباً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'bulgarische-rose',
                        3 => 'geroestete-tonkabohne',
                        4 => 'jasmin-sambac',
                        5 => 'kaffee',
                        6 => 'kakao',
                        7 => 'kaschmir',
                        8 => 'mandel',
                        9 => 'moschus',
                        10 => 'orangenbluete',
                        11 => 'patchouli',
                        12 => 'praline',
                        13 => 'sandelholz',
                        14 => 'tuberose',
                        15 => 'zedernholz',
                        16 => 'zimt',
                        17 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            26 => [
                'slug' => 'd27',
                'translations' => [
                    'de' => [
                        'name' => 'D27',
                        'short_description' => '',
                        'description' => 'Eine strahlende florale Komposition voller Lebendigkeit, die die Helligkeit von Zitrusfrüchten mit der Zartheit weißer Blüten vereint, abgerundet durch eine tiefe Basis aus Hölzern und Patchouli für einen eleganten und verführerischen Charakter.',
                    ],
                    'en' => [
                        'name' => 'D27',
                        'short_description' => '',
                        'description' => 'A radiant floral composition full of vibrancy, combining the brightness of citrus with the delicacy of white florals, grounded by a deep woody and patchouli base for an elegant and alluring character.',
                    ],
                    'ar' => [
                        'name' => 'D27',
                        'short_description' => '',
                        'description' => 'مزيج زهري متألق ينبض بالحيوية، يجمع بين إشراق الحمضيات ونعومة الزهور البيضاء، مع قاعدة عميقة من الأخشاب والباتشولي تضفي طابعاً راقياً وجذاباً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'exklusiv',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'vetiver',
                        1 => 'tuberose',
                        2 => 'jasmin-sambac',
                        3 => 'patchouli',
                        4 => 'bergamotte',
                        5 => 'ingwer',
                        6 => 'orangenbluete',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            27 => [
                'slug' => 'd28',
                'translations' => [
                    'de' => [
                        'name' => 'D28',
                        'short_description' => '',
                        'description' => 'Eine gewagte und intensive Komposition mit einem geheimnisvollen orientalischen Charakter, bei der die Frische von Zitrusfrüchten mit der Schärfe von Gewürzen verschmilzt und in einer tiefen, warmen Basis aus Sandelholz und Patchouli mündet.',
                    ],
                    'en' => [
                        'name' => 'D28',
                        'short_description' => '',
                        'description' => 'A bold and intense composition with a mysterious oriental flair, blending the freshness of citrus with the heat of spices, resting on a deep, warm base of sandalwood and patchouli.',
                    ],
                    'ar' => [
                        'name' => 'D28',
                        'short_description' => '',
                        'description' => 'تركيبة جريئة ومكثفة تأخذ طابعاً شرقياً غامضاً، حيث تمتزج انتعاش الحمضيات مع حرارة التوابل، لتستقر على قاعدة عميقة ودافئة من خشب الصندل والباتشولي',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'dunkel',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'jasmin-sambac',
                        1 => 'patchouli',
                        2 => 'ingwer',
                        3 => 'sandelholz',
                        4 => 'pimentblatt',
                        5 => 'blutorange',
                        6 => 'tuberose',
                        7 => 'orangenbluete',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            28 => [
                'slug' => 'd30',
                'translations' => [
                    'de' => [
                        'name' => 'D30',
                        'short_description' => '',
                        'description' => 'Eine klassische, raffinierte Komposition, die die Süße von Sommerfrüchten (Pfirsich und Aprikose) mit der Zartheit eines luxuriösen Blumenbouquets vereint, abgerundet durch eine warme Holzbasis, die dem Duft eine unvergleichliche Beständigkeit und Eleganz verleiht.',
                    ],
                    'en' => [
                        'name' => 'D30',
                        'short_description' => '',
                        'description' => 'A sophisticated, classic composition that blends the sweetness of summer fruits (peach and apricot) with the softness of a luxurious floral bouquet, grounded by a warm woody base that provides incomparable longevity and elegance',
                    ],
                    'ar' => [
                        'name' => 'D30',
                        'short_description' => '',
                        'description' => 'تركيبة كلاسيكية راقية تجمع بين حلاوة الفواكه الصيفية (الخوخ والمشمش) ونعومة باقة من الزهور الفاخرة، مع قاعدة خشبية دافئة تمنح العطر ثباتاً وأناقة لا تضاهى.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'klassisch',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'aprikose-galbanum-himbeere-hyazinthe-jasmin-moschus-pfirsich-rose-sandelholz-ylang-ylang-zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            29 => [
                'slug' => 'd31',
                'translations' => [
                    'de' => [
                        'name' => 'D31',
                        'short_description' => '',
                        'description' => 'Eine zarte und erfrischende Komposition, die auf einem Strauß taufrischer Blumen basiert. Die leichte Süße der Litschi verschmilzt mit blühenden floralen Noten und ruht auf einer warmen, ruhigen Basis aus Hölzern und Amber.',
                    ],
                    'en' => [
                        'name' => 'D31',
                        'short_description' => '',
                        'description' => 'A delicate and refreshing blend based on a bouquet of dew-kissed flowers. The light sweetness of lychee mingles with blooming floral notes, resting on a warm, serene base of woods and amber.',
                    ],
                    'ar' => [
                        'name' => 'D31',
                        'short_description' => '',
                        'description' => 'مزيج رقيق ومنعش يعتمد على باقة من الزهور الندية، حيث تمتزج حلاوة الليتشي الخفيفة مع نفحات الأزهار المتفتحة، لتستقر على قاعدة دافئة وهادئة من الأخشاب والعنبر',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sauber',
                        1 => 'elegant',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'freesie',
                        2 => 'litschi',
                        3 => 'magnolie',
                        4 => 'maigloeckchen',
                        5 => 'pfingstrose',
                        6 => 'rose',
                        7 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            30 => [
                'slug' => 'd32',
                'translations' => [
                    'de' => [
                        'name' => 'D32',
                        'short_description' => '',
                        'description' => 'Eine moderne Komposition, die die Lebendigkeit von Früchten (Birne und Litschi) mit der Tiefe edler Blüten vereint, abgerundet durch eine rauchige und warme Basis aus Weihrauch, die dem Duft eine Nuance von Geheimnis und außergewöhnlicher Anziehungskraft verleiht.',
                    ],
                    'en' => [
                        'name' => 'D32',
                        'short_description' => '',
                        'description' => 'A modern composition that combines the vibrancy of fruits (pear and lychee) with the depth of noble flowers, rounded off by a smoky and warm base of incense that gives the fragrance a hint of mystery and exceptional allure.',
                    ],
                    'ar' => [
                        'name' => 'D32',
                        'short_description' => '',
                        'description' => 'تركيبة عصرية تجمع بين حيوية الفواكه (الكمثرى والليتشي) وعمق الزهور الفاخرة، مع قاعدة دخانية ودافئة من البخور والباتشولي تضفي لمسة من الغموض والجاذبية الاستثنائية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'unvergesslich',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'birne',
                        1 => 'eichenmoos',
                        2 => 'grapefruit',
                        3 => 'litschi',
                        4 => 'moschus',
                        5 => 'tuerkische-damaszener-rose',
                        6 => 'vanille',
                        7 => 'vetiver',
                        8 => 'weihrauch',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            31 => [
                'slug' => 'd33',
                'translations' => [
                    'de' => [
                        'name' => 'D33',
                        'short_description' => '',
                        'description' => 'Eine zarte und ausgewogene Komposition, die mit der Frische saftiger Früchte eröffnet, in ein weiches florales Herz übergeht und mit einer holzig-erdigen Basis abschließt, die dem Duft Beständigkeit und eine anziehende Tiefe verleiht.',
                    ],
                    'en' => [
                        'name' => 'D33',
                        'short_description' => '',
                        'description' => 'A delicate and balanced composition, opening with the freshness of succulent fruits, transitioning into a soft floral heart, and concluding with a woody, earthy base that provides the fragrance with longevity and alluring depth.',
                    ],
                    'ar' => [
                        'name' => 'D33',
                        'short_description' => '',
                        'description' => 'تركيبة رقيقة ومتوازنة، تفتتح بانتعاش الفواكه الغنية، لتستقر في قلب زهري ناعم، وتنتهي بقاعدة خشبية ترابية تمنح العطر ثباتاً وعمقاً جذاباً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'charismatisch',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'litschi',
                        1 => 'pfirsich',
                        2 => 'bergamotte',
                        3 => 'orangenbluete',
                        4 => 'jasmin',
                        5 => 'pfingstrose',
                        6 => 'moschus',
                        7 => 'holzige-noten',
                        8 => 'moos',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            32 => [
                'slug' => 'd35',
                'translations' => [
                    'de' => [
                        'name' => 'D35',
                        'short_description' => '',
                        'description' => 'Eine Verkörperung moderner Eleganz, bei der der Duft von frischem Jasmin mit der Wärme von Vanille verschmilzt, um eine unvergessliche Duftsignatur zu kreieren.',
                    ],
                    'en' => [
                        'name' => 'D35',
                        'short_description' => '',
                        'description' => 'An embodiment of modern luxury, where the scent of fresh jasmine blends with the warmth of vanilla to create an unforgettable olfactory signature.',
                    ],
                    'ar' => [
                        'name' => 'D35',
                        'short_description' => '',
                        'description' => 'تجسيد للفخامة العصرية، حيث يمتزج عبق الياسمين المنعش مع دفء الفانيليا ليخلق بصمة عطرية لا تُنسى',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'jasmin',
                        2 => 'vanille',
                        3 => 'amber',
                        4 => 'moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            33 => [
                'slug' => 'd36',
                'translations' => [
                    'de' => [
                        'name' => 'D36',
                        'short_description' => '',
                        'description' => 'Eine strahlende und raffinierte Komposition, die die Frische italienischer Zitrusfrüchte mit der Zartheit weißer Blüten vereint, abgerundet durch eine warme, verlockende Basis aus Vanille und Moschus.',
                    ],
                    'en' => [
                        'name' => 'D36',
                        'short_description' => '',
                        'description' => 'A bright and sophisticated blend that combines the freshness of Italian citrus with the delicacy of white florals, rounded off by a warm and alluring base of vanilla and musk.',
                    ],
                    'ar' => [
                        'name' => 'D36',
                        'short_description' => '',
                        'description' => 'مزيج مشرق وراقٍ يجمع بين انتعاش الحمضيات الإيطالية ونعومة الزهور البيضاء، مع قاعدة دافئة ومغرية من الفانيليا والمسك',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'jugendlich',
                        1 => 'anziehend',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'ambroxan',
                        1 => 'birne',
                        2 => 'bitterorangenbluete',
                        3 => 'bourbon-vanille',
                        4 => 'jasmin-sambac-absolue',
                        5 => 'kalabrische-bergamotte',
                        6 => 'neroli',
                        7 => 'siam-benzoe',
                        8 => 'tangerine',
                        9 => 'tunesische-orangenbluete-absolue',
                        10 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            34 => [
                'slug' => 'd37',
                'translations' => [
                    'de' => [
                        'name' => 'D37',
                        'short_description' => '',
                        'description' => 'Eine süße und warme Note, die die Sinne mit der üppigen Süße von Karamell und der Sanftheit von weißem Moschus verzaubert und für einen samtigen, verführerischen Charakter sorgt.',
                    ],
                    'en' => [
                        'name' => 'D37',
                        'short_description' => '',
                        'description' => 'A sweet and warm touch that captivates the senses with a blend of rich caramel sweetness and the softness of white musk, creating a velvety and alluring character.',
                    ],
                    'ar' => [
                        'name' => 'D37',
                        'short_description' => '',
                        'description' => 'لمسة حلوة ودافئة تأسر الحواس بمزيج من حلاوة الكراميل الغنية ونعومة المسك الأبيض، مما يضفي طابعاً مخملياً وجذاباً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'frisch',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'karamell',
                        1 => 'siam-benzoe',
                        2 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            35 => [
                'slug' => 'd38',
                'translations' => [
                    'de' => [
                        'name' => 'D38',
                        'short_description' => '',
                        'description' => 'Ein luxuriöser und hochfemininer Duftstrauß, der mit einer harmonischen Mischung aus erfrischenden Früchten und zarten Blumen verströmt, die auf einer warmen und opulenten Basis ruhen.',
                    ],
                    'en' => [
                        'name' => 'D38',
                        'short_description' => '',
                        'description' => 'A luxurious and ultra-feminine fragrance bouquet, exuding a harmonious blend of refreshing fruits and delicate flowers that rest on a warm and opulent base.',
                    ],
                    'ar' => [
                        'name' => 'D38',
                        'short_description' => '',
                        'description' => 'باقة عطرية فاخرة وفائقة الأنوثة، تعبق بمزيج متناغم من الفواكه المنعشة والزهور الرقيقة التي تستقر على قاعدة دافئة ومترفة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'aquatisch',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'luxurioes',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'ananas',
                        2 => 'bergamotte',
                        3 => 'brombeere',
                        4 => 'himbeere',
                        5 => 'honig',
                        6 => 'iris',
                        7 => 'jasmin',
                        8 => 'lotus',
                        9 => 'maigloeckchen',
                        10 => 'mairose',
                        11 => 'melone',
                        12 => 'moschus',
                        13 => 'pfirsich',
                        14 => 'quitte',
                        15 => 'sandelholz',
                        16 => 'schwarze-johannisbeere',
                        17 => 'seerose',
                        18 => 'vanille',
                        19 => 'veilchenwurzel',
                        20 => 'vetiver',
                        21 => 'weissdorn',
                        22 => 'zitrische-noten',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            36 => [
                'slug' => 'd39',
                'translations' => [
                    'de' => [
                        'name' => 'D39',
                        'short_description' => '',
                        'description' => 'Ein gewagtes und mysteriöses Dufterlebnis, das die Süße von Kirsche mit Tabak- und Cognac-Noten verbindet, um ein unwiderstehliches Gefühl von Luxus und Tiefe zu vermitteln.',
                    ],
                    'en' => [
                        'name' => 'D39',
                        'short_description' => '',
                        'description' => 'A bold and mysterious fragrance experience, blending the sweetness of cherry with notes of tobacco and cognac to provide an irresistible feeling of luxury and depth.',
                    ],
                    'ar' => [
                        'name' => 'D39',
                        'short_description' => '',
                        'description' => 'تجربة عطرية جريئة وغامضة، تدمج حلاوة الكرز مع نوتات التبغ والكونياك لتمنحك شعوراً لا يقاوم بالفخامة والعمق',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'professionell',
                        2 => 'charismatisch',
                    ],
                    'noten' => [
                        0 => 'cognac',
                        1 => 'jasmin',
                        2 => 'kirsche',
                        3 => 'rosa-pfeffer',
                        4 => 'schwarzer-pfeffer',
                        5 => 'tabak',
                        6 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            37 => [
                'slug' => 'd40',
                'translations' => [
                    'de' => [
                        'name' => 'D40',
                        'short_description' => '',
                        'description' => 'Eine warme und opulente Komposition, die die Zartheit von Jasmin und den Luxus von Sandelholz mit einer einzigartigen, nussigen Note von Kastanie und Vanille vereint.',
                    ],
                    'en' => [
                        'name' => 'D40',
                        'short_description' => '',
                        'description' => 'A warm and opulent composition that combines the delicacy of jasmine and the luxury of sandalwood with a unique, nutty touch of chestnut and vanilla.',
                    ],
                    'ar' => [
                        'name' => 'D40',
                        'short_description' => '',
                        'description' => 'مزيج دافئ ومترف يجمع بين نعومة الياسمين وفخامة خشب الصندل مع لمسة فريدة ومغذية من الكستناء والفانيليا',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aquatisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'unvergesslich',
                        2 => 'intensiv',
                    ],
                    'noten' => [
                        0 => 'jasmin-sambac',
                        1 => 'kaschmir',
                        2 => 'kastanie',
                        3 => 'rosa-pfeffer',
                        4 => 'sandelholz',
                        5 => 'seide',
                        6 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            38 => [
                'slug' => 'd41',
                'translations' => [
                    'de' => [
                        'name' => 'D41',
                        'short_description' => '',
                        'description' => 'Eine minimalistische und betörende Komposition, die auf dem Kontrast zwischen der Anziehungskraft von Jasmin und der Wärme edler Hölzer basiert und die Haut in eine seidige Aura hüllt.',
                    ],
                    'en' => [
                        'name' => 'D41',
                        'short_description' => '',
                        'description' => 'A simple and captivating composition that relies on the contrast between the allure of jasmine and the warmth of precious woods, enveloping the skin in a silky aura.',
                    ],
                    'ar' => [
                        'name' => 'D41',
                        'short_description' => '',
                        'description' => 'تركيبة عطرية بسيطة وآسرة، تعتمد على التباين بين جاذبية الياسمين ودفء الأخشاب الفاخرة التي تغلف البشرة بلمسة حريرية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'jugendlich',
                        1 => 'charismatisch',
                        2 => 'frisch',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'jasmin-sambac',
                        2 => 'kaschmirholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            39 => [
                'slug' => 'd42',
                'translations' => [
                    'de' => [
                        'name' => 'D42',
                        'short_description' => '',
                        'description' => 'Eine lebendige und freudige Komposition, die auf erfrischenden Waldbeerennoten und einem zarten Blumenstrauß basiert, abgerundet durch warme Akzente von Moschus und Vanille.',
                    ],
                    'en' => [
                        'name' => 'D42',
                        'short_description' => '',
                        'description' => 'A vibrant and joyful composition based on refreshing wild berry notes and a soft floral bouquet, finished with warm accents of musk and vanilla.',
                    ],
                    'ar' => [
                        'name' => 'D42',
                        'short_description' => '',
                        'description' => 'مزيج حيوي ومبهج يعتمد على نكهات التوت البري المنعشة مع باقة زهرية ناعمة، تختتم بلمسات دافئة من المسك والفانيليا.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'anziehend',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'erdbeere',
                        1 => 'heidelbeere',
                        2 => 'himbeere',
                        3 => 'kaschmirholz',
                        4 => 'lilie',
                        5 => 'maigloeckchen',
                        6 => 'moschus',
                        7 => 'rote-pfingstrose',
                        8 => 'vanille',
                        9 => 'veilchen',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            40 => [
                'slug' => 'd43',
                'translations' => [
                    'de' => [
                        'name' => 'D43',
                        'short_description' => '',
                        'description' => 'Eine reine tropische Note, die die Sinne an warme Strände entführt, wobei die cremige Süße der Kokosnuss auf erfrischende und verführerische Weise zur Geltung kommt.',
                    ],
                    'en' => [
                        'name' => 'D43',
                        'short_description' => '',
                        'description' => 'A pure tropical note that transports the senses to warm beaches, highlighting the creamy sweetness of coconut in a fresh and alluring way.',
                    ],
                    'ar' => [
                        'name' => 'D43',
                        'short_description' => '',
                        'description' => 'نفحة استوائية خالصة تنقل الحواس إلى شواطئ دافئة، حيث تبرز حلاوة جوز الهند الكريمية بأسلوب منعش وجذاب',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'klassisch',
                        2 => 'frisch',
                    ],
                    'noten' => [
                        0 => 'kokosnuss',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            41 => [
                'slug' => 'd44',
                'translations' => [
                    'de' => [
                        'name' => 'D44',
                        'short_description' => '',
                        'description' => 'Ein opulenter und luxuriöser Blumenstrauß, zentriert um Noten von Tuberose und Jasmin, ruhend auf einer warmen Holzbasis, die dem Duft Langlebigkeit und unwiderstehliche Anziehungskraft verleiht.',
                    ],
                    'en' => [
                        'name' => 'D44',
                        'short_description' => '',
                        'description' => 'An opulent and luxurious floral bouquet centered around notes of tuberose and jasmine, resting on a warm woody base that gives the fragrance longevity and irresistible allure.',
                    ],
                    'ar' => [
                        'name' => 'D44',
                        'short_description' => '',
                        'description' => 'باقة زهرية غنية وفخمة تتوسطها نفحات التوبيروز والياسمين، ترتكز على قاعدة خشبية دافئة تمنح العطر ثباتاً وجاذبية لا تقاوم.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'elegant',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'holzige-noten',
                        1 => 'jasmin',
                        2 => 'moschus',
                        3 => 'orangenbluete',
                        4 => 'rose',
                        5 => 'tuberose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            42 => [
                'slug' => 'd45',
                'translations' => [
                    'de' => [
                        'name' => 'D45',
                        'short_description' => '',
                        'description' => 'Ein zarter und moderner Duftausdruck, der die Reinheit und Schönheit von Tulpen in voller Blüte verkörpert und einen Hauch von frühlingshafter Vitalität und Weiblichkeit verleiht.',
                    ],
                    'en' => [
                        'name' => 'D45',
                        'short_description' => '',
                        'description' => 'A delicate and modern olfactory expression that embodies the purity and beauty of tulips in full bloom, adding a touch of spring-like vitality and femininity.',
                    ],
                    'ar' => [
                        'name' => 'D45',
                        'short_description' => '',
                        'description' => 'تعبير عطري رقيق وعصري يجسد نقاء وجمال زهور التوليب في أوج تفتحها، مما يضفي لمسة من الحيوية والأنوثة الربيعية.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'professionell',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'tulpen',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            43 => [
                'slug' => 'd46',
                'translations' => [
                    'de' => [
                        'name' => 'D46',
                        'short_description' => '',
                        'description' => 'Eine zeitlose Verkörperung der Weiblichkeit, bei der Jasmin mit seinem intensiven und betörenden blumigen Duft hervorsticht, der bei jedem Sprühstoß Eleganz und Verführung ausstrahlt.',
                    ],
                    'en' => [
                        'name' => 'D46',
                        'short_description' => '',
                        'description' => 'A timeless embodiment of femininity, where jasmine stands out with its intense and captivating floral scent, radiating elegance and allure with every spray.',
                    ],
                    'ar' => [
                        'name' => 'D46',
                        'short_description' => '',
                        'description' => 'تجسيد خالد للأنوثة، حيث يبرز الياسمين بعبيره الزهري المكثف والآسر الذي يفيض بالرقي والجاذبية في كل رشة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'elegant',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'jasmin',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            44 => [
                'slug' => 'd48',
                'translations' => [
                    'de' => [
                        'name' => 'D48',
                        'short_description' => '',
                        'description' => 'Eine raffinierte Komposition, die die Frische von Früchten und die Lebendigkeit von Zitrusfrüchten mit einem reichen Blumenherz vereint, basierend auf einer tiefen Basis aus Patschuli und Vanille.',
                    ],
                    'en' => [
                        'name' => 'D48',
                        'short_description' => '',
                        'description' => 'A sophisticated composition that combines the freshness of fruits and the vibrancy of citrus with a rich floral heart, resting on a deep base of patchouli and vanilla.',
                    ],
                    'ar' => [
                        'name' => 'D48',
                        'short_description' => '',
                        'description' => 'تركيبة متطورة تجمع بين انتعاش الفاكهة وحيوية الحمضيات، مع قلب زهري غني يرتكز على قاعدة عميقة من الباتشولي والفانيليا.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'sauber',
                        1 => 'klassisch',
                        2 => 'feminin',
                    ],
                    'noten' => [
                        0 => 'ananas',
                        1 => 'hyazinthe',
                        2 => 'iris',
                        3 => 'jasmin',
                        4 => 'moschus',
                        5 => 'patchouli',
                        6 => 'rosa-pfeffer',
                        7 => 'vanille',
                        8 => 'vetiver',
                        9 => 'zitrusfruechte',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            45 => [
                'slug' => 'd49',
                'translations' => [
                    'de' => [
                        'name' => 'D49',
                        'short_description' => '',
                        'description' => 'Eine außergewöhnliche Komposition, die die Lebendigkeit von Zitrusfrüchten und Gewürzen mit der Wärme orientalischer Blumen ausbalanciert, um ein geheimnisvolles und luxuriöses Erlebnis zu schaffen, das einen unvergesslichen Eindruck hinterlässt.',
                    ],
                    'en' => [
                        'name' => 'D49',
                        'short_description' => '',
                        'description' => 'An exceptional blend that balances the vibrancy of citrus and spices with the warmth of oriental florals, creating a mysterious and luxurious experience that leaves an unforgettable impression.',
                    ],
                    'ar' => [
                        'name' => 'D49',
                        'short_description' => '',
                        'description' => 'مزيج استثنائي يوازن بين حيوية الحمضيات والتوابل ودفء الزهور الشرقية، ليخلق تجربة غامضة وفخمة تترك أثراً لا يُنسى.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'pudrig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'exklusiv',
                        2 => 'raffiniert',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'ingwer',
                        2 => 'kamelie',
                        3 => 'litschi',
                        4 => 'mandarine',
                        5 => 'mimose',
                        6 => 'patchouli',
                        7 => 'rose',
                        8 => 'vanille',
                        9 => 'veilchen',
                        10 => 'weihrauch',
                        11 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            46 => [
                'slug' => 'd50',
                'translations' => [
                    'de' => [
                        'name' => 'D50',
                        'short_description' => '',
                        'description' => 'Eine zarte und innovative Duftkomposition, die die Frische von Früchten und Zitrusfrüchten mit einem samtigen Blumenherz vereint, umhüllt von einer pudrigen Süße und warmen Holznoten.',
                    ],
                    'en' => [
                        'name' => 'D50',
                        'short_description' => '',
                        'description' => 'A delicate and innovative fragrance composition that combines the freshness of fruits and citrus with a velvety floral heart, enveloped by powdery sweetness and warm woody notes.',
                    ],
                    'ar' => [
                        'name' => 'D50',
                        'short_description' => '',
                        'description' => 'توليفة عطرية رقيقة ومبتكرة تجمع بين انتعاش الفواكه والحمضيات مع قلب زهري مخملي، تحيطه حلاوة البودرة واللمسات الخشبية الدافئة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'professionell',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'freesie',
                        1 => 'heidelbeere',
                        2 => 'jasmin',
                        3 => 'kaschmirholz',
                        4 => 'mandarine',
                        5 => 'moschus',
                        6 => 'orangenbluete',
                        7 => 'puderzucker',
                        8 => 'rosa-pfeffer',
                        9 => 'sandelholz',
                        10 => 'vanille',
                        11 => 'veilchenblatt',
                        12 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            47 => [
                'slug' => 'd51',
                'translations' => [
                    'de' => [
                        'name' => 'D51',
                        'short_description' => '',
                        'description' => 'Eine lebendige Mischung, die die Frische aquatischer Noten mit der Reinheit weißer Blüten vereint, ergänzt durch einen leichten fruchtigen Akzent und eine warme Holzbasis für ein perfektes Gleichgewicht.',
                    ],
                    'en' => [
                        'name' => 'D51',
                        'short_description' => '',
                        'description' => 'A vibrant blend that combines the freshness of aquatic notes with the purity of white florals, complemented by a light fruity accent and a warm woody base for perfect balance.',
                    ],
                    'ar' => [
                        'name' => 'D51',
                        'short_description' => '',
                        'description' => 'مزيج حيوي يجمع بين انتعاش النوتات المائية ونقاء الزهور البيضاء، مع لمسة فاكهية خفيفة وقاعدة خشبية دافئة تمنحه توازناً مثالياً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'charismatisch',
                    ],
                    'noten' => [
                        0 => 'aquatische-noten',
                        1 => 'gruener-apfel',
                        2 => 'jasmin',
                        3 => 'sandelholz',
                        4 => 'vanillebluete',
                        5 => 'weisse-lilie',
                        6 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            48 => [
                'slug' => 'd52',
                'translations' => [
                    'de' => [
                        'name' => 'D52',
                        'short_description' => '',
                        'description' => 'Ein intensiver und opulenter Blumenstrauß, der die Schönheit weißer Blüten zelebriert, wobei Jasmin, Tuberose und Rangunschlinger ineinanderfließen, um ein lebendiges und modernes Dufterlebnis zu schaffen.',
                    ],
                    'en' => [
                        'name' => 'D52',
                        'short_description' => '',
                        'description' => 'An intense and opulent floral bouquet that celebrates the beauty of white flowers, where jasmine, tuberose, and rangoon creeper intertwine to create a vibrant and modern fragrance experience.',
                    ],
                    'ar' => [
                        'name' => 'D52',
                        'short_description' => '',
                        'description' => 'باقة زهرية مكثفة وغنية تحتفي بجمال الزهور البيضاء، حيث يتداخل الياسمين مع التوبيروز والرانغون لخلق تجربة عطرية حيوية وعصرية.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'jugendlich',
                        1 => 'anziehend',
                        2 => 'warm',
                    ],
                    'noten' => [
                        0 => 'jasmin',
                        1 => 'moschus',
                        2 => 'rangunschlinger',
                        3 => 'tuberose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            49 => [
                'slug' => 'd54',
                'translations' => [
                    'de' => [
                        'name' => 'D54',
                        'short_description' => '',
                        'description' => 'Eine herrlich freudige und unwiderstehliche Komposition, die die Frische spritziger Zitrusfrüchte mit der Süße von Beeren und einem reichhaltigen, cremigen Herzen verbindet, um ein Gefühl von Verwöhnung und moderner Weiblichkeit zu vermitteln.',
                    ],
                    'en' => [
                        'name' => 'D54',
                        'short_description' => '',
                        'description' => 'A delightful and irresistible fragrance composition, blending the freshness of sparkling citrus and the sweetness of berries with a rich, creamy heart to evoke a sense of indulgence and modern femininity.',
                    ],
                    'ar' => [
                        'name' => 'D54',
                        'short_description' => '',
                        'description' => 'تركيبة عطرية مبهجة ولا تقاوم، تمزج بين انتعاش الحمضيات الفوارة وحلاوة التوت مع قلب كريمي غني يمنحك شعوراً بالدلال والأنوثة العصرية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'unvergesslich',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'ambrette',
                        1 => 'grapefruit',
                        2 => 'himbeere',
                        3 => 'italienische-bergamotte',
                        4 => 'mandarine',
                        5 => 'marshmallow',
                        6 => 'moschus',
                        7 => 'orangenbluete',
                        8 => 'sahne',
                        9 => 'schwarze-johannisbeere',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            50 => [
                'slug' => 'd55',
                'translations' => [
                    'de' => [
                        'name' => 'D55',
                        'short_description' => '',
                        'description' => 'Eine außergewöhnliche Mischung, die die cremige Wärme von Vanille mit der Reinheit von Kokosnuss vereint, ergänzt durch eine tiefe, spirituelle Note von Palo Santo-Holz, die ein warmes und beruhigendes Dufterlebnis schafft.',
                    ],
                    'en' => [
                        'name' => 'D55',
                        'short_description' => '',
                        'description' => 'An exceptional blend that combines the creamy warmth of vanilla with the purity of coconut, complemented by a deep, spiritual touch of Palo Santo wood, creating a warm and soothing fragrance experience.',
                    ],
                    'ar' => [
                        'name' => 'D55',
                        'short_description' => '',
                        'description' => 'مزيج استثنائي يجمع بين دفء الفانيليا الكريمي ونقاء جوز الهند، مع لمسة روحانية عميقة يضفيها خشب البالو سانتو، مما يخلق تجربة عطرية دافئة وهادئة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'pudrig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'dunkel',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille-absolue',
                        1 => 'ecuadorianisches-palo-santo',
                        2 => 'kokosnuss',
                        3 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            51 => [
                'slug' => 'd56',
                'translations' => [
                    'de' => [
                        'name' => 'D56',
                        'short_description' => '',
                        'description' => 'Eine mutige und verführerische Komposition, die das blumige Aroma der Tuberose mit der goldenen Süße von Honig verbindet, während Patschuli und Tonkabohne eine warme Tiefe und geheimnisvolle Sinnlichkeit verleihen, die die Sinne fesselt.',
                    ],
                    'en' => [
                        'name' => 'D56',
                        'short_description' => '',
                        'description' => 'A bold and seductive blend that combines the floral aroma of tuberose with the golden sweetness of honey, while patchouli and tonka bean add a warm depth and mysterious allure that captivates the senses.',
                    ],
                    'ar' => [
                        'name' => 'D56',
                        'short_description' => '',
                        'description' => 'مزيج جريء ومغري يجمع بين عبير التوبيروز الزهري وحلاوة العسل الذهبية، بينما يضفي الباتشولي وفول التونكا عمقاً دافئاً وغموضاً يأسر الحواس',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'sauber',
                        1 => 'professionell',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'honig',
                        1 => 'patchouli',
                        2 => 'tonkabohne',
                        3 => 'tuberose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            52 => [
                'slug' => 'd57',
                'translations' => [
                    'de' => [
                        'name' => 'D57',
                        'short_description' => '',
                        'description' => 'Die Verkörperung von Reinheit und Schlichtheit; der Duft von weißem Moschus umhüllt dich mit einem sanften, weichen Aroma, das an das Gefühl frischer Haut nach dem Duschen erinnert und ein Gefühl von Komfort und Gelassenheit vermittelt.',
                    ],
                    'en' => [
                        'name' => 'D57',
                        'short_description' => '',
                        'description' => 'The embodiment of purity and simplicity; the scent of white musk envelops you in a soft, gentle aroma reminiscent of fresh skin after a shower, providing a sense of comfort and serenity.',
                    ],
                    'ar' => [
                        'name' => 'D57',
                        'short_description' => '',
                        'description' => 'تجسيد للنقاء والبساطة، حيث يغلفك عطر المسك الأبيض برائحة هادئة وناعمة تشبه ملمس البشرة المنعشة بعد الاستحمام، مما يمنحك شعوراً بالراحة والهدوء',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'pudrig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'jugendlich',
                        1 => 'anziehend',
                        2 => 'warm',
                    ],
                    'noten' => [
                        0 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            53 => [
                'slug' => 'd59',
                'translations' => [
                    'de' => [
                        'name' => 'D59',
                        'short_description' => '',
                        'description' => 'Ein freudiges olfaktorisches Fest, das vor fruchtigem Zucker und der Süße von Marshmallow und Praline sprüht, ergänzt durch eine reiche, samtige Basis aus Vanille und Moschus, die ihm einen unwiderstehlich lebendigen Charakter verleiht.',
                    ],
                    'en' => [
                        'name' => 'D59',
                        'short_description' => '',
                        'description' => 'A joyful olfactory celebration, overflowing with fruity sugar and the sweetness of marshmallow and praline, complemented by a rich, velvety base of vanilla and musk that gives it an irresistibly vibrant character.',
                    ],
                    'ar' => [
                        'name' => 'D59',
                        'short_description' => '',
                        'description' => 'احتفالية عطرية مبهجة، تفيض بسكر الفواكه وحلاوة المارشميلو والبرالين، مع قاعدة غنية ومخملية من الفانيليا والمسك تمنحها طابعاً حيوياً لا يقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'klassisch',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'ambrox',
                        1 => 'cripps-pink-apfel',
                        2 => 'erdbeere',
                        3 => 'freesie',
                        4 => 'himbeere',
                        5 => 'italienische-zitrone',
                        6 => 'kokosnuss',
                        7 => 'marshmallow',
                        8 => 'moschus',
                        9 => 'nektarinenbluete',
                        10 => 'orangenbluetenwasser',
                        11 => 'praline',
                        12 => 'rosa-moschus',
                        13 => 'tonkabohne',
                        14 => 'vanille',
                        15 => 'zucker',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            54 => [
                'slug' => 'd60',
                'translations' => [
                    'de' => [
                        'name' => 'D60',
                        'short_description' => '',
                        'description' => 'Eine reichhaltige und mehrdimensionale blumige Symphonie, die die Frische aquatischer Früchte mit einem Bouquet aus verschiedensten Blumen vereint und schließlich auf einer warmen Holzbasis ruht, die einen Hauch klassischer Eleganz verleiht.',
                    ],
                    'en' => [
                        'name' => 'D60',
                        'short_description' => '',
                        'description' => 'A rich and multidimensional floral symphony, blending the freshness of aquatic fruits with a bouquet of diverse flowers, eventually settling into a warm woody base that adds a touch of classic sophistication.',
                    ],
                    'ar' => [
                        'name' => 'D60',
                        'short_description' => '',
                        'description' => 'سيمفونية زهرية غنية ومتعددة الأبعاد، تمزج بين انتعاش الفواكه المائية وباقة من الزهور المتنوعة، لتستقر في النهاية على قاعدة خشبية دافئة تضفي طابعاً من الرقي الكلاسيكي.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aquatisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'luxurioes',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'alpenveilchen',
                        1 => 'amber',
                        2 => 'exotische-hoelzer',
                        3 => 'freesie',
                        4 => 'gartennelke',
                        5 => 'lilie',
                        6 => 'lotus',
                        7 => 'maigloeckchen',
                        8 => 'melone',
                        9 => 'moschus',
                        10 => 'osmanthus',
                        11 => 'pfingstrose',
                        12 => 'rose',
                        13 => 'rosenwasser',
                        14 => 'sandelholz',
                        15 => 'tuberose',
                        16 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            55 => [
                'slug' => 'd61',
                'translations' => [
                    'de' => [
                        'name' => 'D61',
                        'short_description' => '',
                        'description' => 'Eine geheimnisvolle und provokative Komposition, die den Reichtum dunkler Früchte mit seltenen Blumennoten ausbalanciert, ergänzt durch eine tiefe, erdige Note von Trüffel und Patschuli, was dem Duft einen dramatischen und luxuriösen Charakter verleiht.',
                    ],
                    'en' => [
                        'name' => 'D61',
                        'short_description' => '',
                        'description' => 'A mysterious and provocative composition that balances the richness of dark fruits with rare floral notes, complemented by a deep, earthy touch of truffle and patchouli, giving the fragrance a dramatic and luxurious character.',
                    ],
                    'ar' => [
                        'name' => 'D61',
                        'short_description' => '',
                        'description' => 'تركيبة غامضة ومثيرة توازن بين ثراء الفاكهة الداكنة ونوتات الزهور النادرة، مع لمسة ترابية عميقة من الترف والباتشولي، مما يمنح العطر طابعاً درامياً وفاخراً',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'bitterorange',
                        2 => 'patchouli',
                        3 => 'rum',
                        4 => 'schwarze-orchidee',
                        5 => 'schwarze-pflaume',
                        6 => 'schwarze-trueffel',
                        7 => 'vanille',
                        8 => 'ylang-ylang',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            56 => [
                'slug' => 'd62',
                'translations' => [
                    'de' => [
                        'name' => 'D62',
                        'short_description' => '',
                        'description' => 'Die Verkörperung von Glück und moderner Weiblichkeit. Ein fruchtiger Nektar verbindet sich mit einem samtigen Blumenherz, während die Basis aus Praline und Vanille eine unwiderstehlich süße und elegante Tiefe verleiht.',
                    ],
                    'en' => [
                        'name' => 'D62',
                        'short_description' => '',
                        'description' => 'An embodiment of happiness and modern femininity, where fruit nectar blends with a velvety floral heart, while the praline and vanilla base imparts an irresistibly sweet and sophisticated depth.',
                    ],
                    'ar' => [
                        'name' => 'D62',
                        'short_description' => '',
                        'description' => 'تجسيد للسعادة والأنوثة العصرية، حيث يمتزج رحيق الفواكه مع قلب زهري مخملي، بينما تمنح قاعدة "البرالين" والفانيليا عمقاً حلواً وراقياً لا يُقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'unvergesslich',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'birne',
                        1 => 'iris',
                        2 => 'jasmin',
                        3 => 'orangenbluete',
                        4 => 'patchouli',
                        5 => 'praline',
                        6 => 'schwarze-johannisbeere',
                        7 => 'tonkabohne',
                        8 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            57 => [
                'slug' => 'd63',
                'translations' => [
                    'de' => [
                        'name' => 'D63',
                        'short_description' => '',
                        'description' => 'Eine lebendige Komposition, die die Schärfe von Gewürzen mit der Wärme von Hölzern ausbalanciert, während ein reiches Blumenherz einen Hauch von Eleganz und Anziehungskraft verleiht – perfekt für die starke und moderne Frau.',
                    ],
                    'en' => [
                        'name' => 'D63',
                        'short_description' => '',
                        'description' => 'A vibrant composition that balances the sharpness of spices with the warmth of woods, while a rich floral heart adds a touch of elegance and allure, making it perfect for the strong and modern woman.',
                    ],
                    'ar' => [
                        'name' => 'D63',
                        'short_description' => '',
                        'description' => 'تركيبة مفعمة بالحيوية توازن بين حدة التوابل ودفء الأخشاب، مع قلب زهري غني يضفي لمسة من الأناقة والجاذبية، مما يجعلها مثالية للمرأة القوية والعصرية',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'gardenie',
                        2 => 'ingwer',
                        3 => 'kardamom',
                        4 => 'moschus',
                        5 => 'orangenbluete',
                        6 => 'pfeffer',
                        7 => 'pfingstrose',
                        8 => 'sandelholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            58 => [
                'slug' => 'd64',
                'translations' => [
                    'de' => [
                        'name' => 'D64',
                        'short_description' => '',
                        'description' => 'Eine erfrischende und strahlende Mischung, die mit knackigen Frucht- und Frische-Noten (Gurke) beginnt, sich in ein zartes florales Herz entfaltet und auf einer warmen Holzbasis ruht, die den ganzen Tag über ein Gefühl von Sauberkeit und Klarheit vermittelt.',
                    ],
                    'en' => [
                        'name' => 'D64',
                        'short_description' => '',
                        'description' => 'A refreshing and radiant blend that opens with crisp fruit and fresh green notes (cucumber), unfolds into a delicate floral heart, and rests on a warm wood base that gives you a feeling of cleanliness and clarity throughout the day.',
                    ],
                    'ar' => [
                        'name' => 'D64',
                        'short_description' => '',
                        'description' => 'مزيج منعش ومشرق يفتتح برائحة الفواكه والخضار المنعشة، ليتطور إلى قلب زهري رقيق، ويستقر على قاعدة خشبية دافئة تمنحك شعوراً بالنظافة والصفاء طوال اليوم.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'frisch',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'apfel',
                        1 => 'grapefruit',
                        2 => 'gurke',
                        3 => 'hoelzer',
                        4 => 'magnolie',
                        5 => 'maigloeckchen',
                        6 => 'rose',
                        7 => 'tuberose',
                        8 => 'veilchen',
                        9 => 'weisser-amber',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            59 => [
                'slug' => 'd65',
                'translations' => [
                    'de' => [
                        'name' => 'D65',
                        'short_description' => '',
                        'description' => 'Eine duftende Symphonie, die den Duft luxuriöser weißer Blüten mit der Wärme königlicher Vanille vereint, um absolute Weiblichkeit zu verkörpern.',
                    ],
                    'en' => [
                        'name' => 'D65',
                        'short_description' => '',
                        'description' => 'A fragrant symphony combining the scent of luxurious white florals with the warmth of royal vanilla to embody absolute femininity.',
                    ],
                    'ar' => [
                        'name' => 'D65',
                        'short_description' => '',
                        'description' => 'سيمفونية عطرية تجمع بين عبير الزهور البيضاء الفاخرة ودفء الفانيليا الملكية لتجسيد الأنوثة المطلقة.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'dunkel',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille',
                        1 => 'jasmin-sambac-absolue',
                        2 => 'mandarinenblatt',
                        3 => 'tunesische-orangenbluete',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            60 => [
                'slug' => 'd66',
                'translations' => [
                    'de' => [
                        'name' => 'D66',
                        'short_description' => '',
                        'description' => 'Eine mutige Mischung, die fruchtige Lebendigkeit mit einem Hauch von dunklem Kaffee verbindet, abgerundet durch eine reiche Basis aus Vanille und Patchouli für einen unwiderstehlich modernen Auftritt.',
                    ],
                    'en' => [
                        'name' => 'D66',
                        'short_description' => '',
                        'description' => 'A bold blend merging fruity vibrancy with a touch of dark coffee, rounded off by a rich base of vanilla and patchouli for an irresistibly modern allure.',
                    ],
                    'ar' => [
                        'name' => 'D66',
                        'short_description' => '',
                        'description' => 'مزيج جريء يدمج بين حيوية الفواكه ولمسة القهوة الداكنة، مع قاعدة غنية من الفانيليا والباتشولي لإطلالة عصرية لا تقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'charismatisch',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille',
                        1 => 'gruene-mandarine',
                        2 => 'indonesisches-patchouli',
                        3 => 'kaffee',
                        4 => 'kirsche',
                        5 => 'marokkanischer-jasmin',
                        6 => 'orangenbluete-absolue',
                        7 => 'schwarzer-tee',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            61 => [
                'slug' => 'd67',
                'translations' => [
                    'de' => [
                        'name' => 'D67',
                        'short_description' => '',
                        'description' => 'Eine duftende Komposition, die mit der Süße exotischer Früchte strahlt und in einem Bouquet aus samtiger Rose erblüht, ergänzt durch eine warme, erdige Note für zusätzliche Raffinesse.',
                    ],
                    'en' => [
                        'name' => 'D67',
                        'short_description' => '',
                        'description' => 'A fragrant composition that radiates with the sweetness of tropical fruits and blossoms with the scent of velvety rose, enhanced by a warm, earthy touch for added sophistication.',
                    ],
                    'ar' => [
                        'name' => 'D67',
                        'short_description' => '',
                        'description' => 'توليفة عطرية تتألق بحلاوة الفواكه الاستوائية وتزدهر بعبق الورد المخملي، مع لمسة ترابية دافئة تعزز من فخامة العطر.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'exklusiv',
                        2 => 'warm',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille',
                        1 => 'johannisbeere',
                        2 => 'litschi',
                        3 => 'rose',
                        4 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            62 => [
                'slug' => 'd68',
                'translations' => [
                    'de' => [
                        'name' => 'D68',
                        'short_description' => '',
                        'description' => 'Eine opulente Duftreise, die dich in bezaubernde tropische Welten entführt, wo Jasmin und Tuberose mit cremigen, warmen Akzenten verschmelzen und für eine unvergessliche Präsenz sorgen.',
                    ],
                    'en' => [
                        'name' => 'D68',
                        'short_description' => '',
                        'description' => 'An opulent olfactory journey that transports you to enchanting tropical worlds, where jasmine and tuberose blend with creamy, warm accents to ensure an unforgettable presence.',
                    ],
                    'ar' => [
                        'name' => 'D68',
                        'short_description' => '',
                        'description' => 'رحلة عطرية غنية تأخذك إلى عوالم استوائية ساحرة، حيث تمتزج زهور الياسمين والتيوبيروز بلمسات كريمية دافئة تمنحك حضوراً فواحاً لا يُنسى',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'intensiv',
                    ],
                    'noten' => [
                        0 => 'benzoe',
                        1 => 'bergamotte',
                        2 => 'jasmin',
                        3 => 'seychellenpalme',
                        4 => 'tonkabohne',
                        5 => 'tuberose',
                        6 => 'ylang-ylang',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            63 => [
                'slug' => 'd69',
                'translations' => [
                    'de' => [
                        'name' => 'D69',
                        'short_description' => '',
                        'description' => 'Eine lebendige Duftkreation, die die Zartheit tropischer Blüten mit der Süße exotischer Früchte verbindet und sanft auf einer warmen Basis aus Vanille ruht.',
                    ],
                    'en' => [
                        'name' => 'D69',
                        'short_description' => '',
                        'description' => 'A vibrant fragrance creation that blends the delicacy of tropical blossoms with the sweetness of exotic fruits, resting softly on a warm vanilla base.',
                    ],
                    'ar' => [
                        'name' => 'D69',
                        'short_description' => '',
                        'description' => 'إشراقة عطرية مفعمة بالحيوية تمزج بين رقة الزهور الاستوائية وعذوبة الفواكه الغريبة، لتستقر بنعومة على قاعدة دافئة من الفانيليا.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'elegant',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'cherry-hill-pfingstrose',
                        1 => 'drachenfrucht',
                        2 => 'roter-frangipani',
                        3 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            64 => [
                'slug' => 'd70',
                'translations' => [
                    'de' => [
                        'name' => 'D70',
                        'short_description' => '',
                        'description' => 'Eine komplexe und aufregende Komposition, die die Frische von Früchten mit der Zartheit von Blüten ausbalanciert, abgerundet durch eine tiefe Basis aus Leder und Röstaromen für eine mysteriöse und luxuriöse Aura.',
                    ],
                    'en' => [
                        'name' => 'D70',
                        'short_description' => '',
                        'description' => 'A complex and exciting composition balancing fruity freshness with delicate florals, finished with a deep base of leather and roasted notes for a mysterious and luxurious aura.',
                    ],
                    'ar' => [
                        'name' => 'D70',
                        'short_description' => '',
                        'description' => 'تركيبة معقدة ومثيرة توازن بين انتعاش الفاكهة ونعومة الزهور، مع قاعدة عميقة من الجلد والروائح المحمصة التي تضفي طابعاً غامضاً وفخماً.',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'blumige-noten',
                        3 => 'gruene-birne',
                        4 => 'leder',
                        5 => 'moschus',
                        6 => 'roestaromen',
                        7 => 'vanille',
                        8 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            65 => [
                'slug' => 'd71',
                'translations' => [
                    'de' => [
                        'name' => 'D71',
                        'short_description' => '',
                        'description' => 'Eine moderne Komposition voller Lebendigkeit, in der sich erfrischende Zitrusnoten mit der Zartheit weißer Blüten und tiefen holzigen Akzenten zu einem Gefühl von Reinheit und Luxus vereinen.',
                    ],
                    'en' => [
                        'name' => 'D71',
                        'short_description' => '',
                        'description' => 'A modern composition full of vibrancy, where refreshing citrus notes blend with the delicacy of white florals and deep woody accents to evoke a sense of purity and luxury.',
                    ],
                    'ar' => [
                        'name' => 'D71',
                        'short_description' => '',
                        'description' => 'توليفة عصرية تنبض بالحيوية، تمتزج فيها الحمضيات المنعشة مع نعومة الزهور البيضاء ولمسات خشبية عميقة تمنح شعوراً بالنظافة والفخامة',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'pudrig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'feminin',
                        1 => 'elegant',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'ambroxan',
                        1 => 'bergamotte',
                        2 => 'haitianisches-vetiver',
                        3 => 'holzige-noten',
                        4 => 'italienische-mandarine',
                        5 => 'moschus',
                        6 => 'orangenbluete',
                        7 => 'vanille',
                        8 => 'weisse-blueten',
                        9 => 'weisser-pfirsich',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            66 => [
                'slug' => 'd72',
                'translations' => [
                    'de' => [
                        'name' => 'D72',
                        'short_description' => '',
                        'description' => 'Ein reiches und verführerisches Dufterlebnis, das die Sinne in die Wärme von Honig und Vanille-Karamell hüllt, abgerundet durch einen samtigen Hauch von Moschus für unwiderstehliche Tiefe.',
                    ],
                    'en' => [
                        'name' => 'D72',
                        'short_description' => '',
                        'description' => 'A rich and alluring olfactory experience that wraps the senses in the warmth of honey and vanilla-caramel, finished with a velvety touch of musk for irresistible depth.',
                    ],
                    'ar' => [
                        'name' => 'D72',
                        'short_description' => '',
                        'description' => 'تجربة عطرية غنية ومغرية تغلف الحواس بدفء العسل وكراميل الفانيليا، مع لمسة مخملية من المسك تضفي عمقاً وجاذبية لا تقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'luxurioes',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'honig',
                        1 => 'karamell',
                        2 => 'tonkabohne',
                        3 => 'vanille',
                        4 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            67 => [
                'slug' => 'h1',
                'translations' => [
                    'de' => [
                        'name' => 'H1',
                        'short_description' => '',
                        'description' => 'Eine klassische, reichhaltige Komposition, die die belebende Frische aromatischer Kräuter mit der tiefen Wärme orientalischer Gewürze vereint, um ein harmonisches Dufterlebnis von zeitloser Eleganz zu kreieren.',
                    ],
                    'en' => [
                        'name' => 'H1',
                        'short_description' => '',
                        'description' => 'A rich, classic composition that blends the invigorating freshness of aromatic herbs with the deep warmth of oriental spices, creating a harmonious fragrance experience of timeless elegance.',
                    ],
                    'ar' => [
                        'name' => 'H1',
                        'short_description' => '',
                        'description' => 'توليفة كلاسيكية غنية تجمع بين انتعاش الأعشاب العطرية ودفء التوابل الشرقية العميق، لتخلق تجربة عطرية متناغمة توحي بالفخامة والأناقة الخالدة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'estragon',
                        3 => 'kardamom',
                        4 => 'kuemmel',
                        5 => 'lavendel',
                        6 => 'minze',
                        7 => 'neroli',
                        8 => 'sandelholz',
                        9 => 'tonkabohne',
                        10 => 'vanille',
                        11 => 'zedernholz',
                        12 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            68 => [
                'slug' => 'h2',
                'translations' => [
                    'de' => [
                        'name' => 'H2',
                        'short_description' => '',
                        'description' => 'Eine faszinierende Kreation, die die spritzige Frische der Bergamotte mit der cremigen Tiefe von Kokospalmenholz und der süßen Wärme der Tonkabohne vereint – ein moderner und zugleich betörender Duft.',
                    ],
                    'en' => [
                        'name' => 'H2',
                        'short_description' => '',
                        'description' => 'A fascinating creation that combines the sparkling freshness of bergamot with the creamy depth of coconut wood and the sweet warmth of tonka bean – a modern and simultaneously captivating fragrance.',
                    ],
                    'ar' => [
                        'name' => 'H2',
                        'short_description' => '',
                        'description' => 'ابتكار آسر يجمع بين انتعاش البرغموت المنعش والعمق الكريمي لخشب جوز الهند مع الدفء الحلو لحبوب التونكا، ليقدم عطراً عصرياً وجذاباً في آن واحد',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'charismatisch',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'kokospalmenholz',
                        2 => 'tonkabohne',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            69 => [
                'slug' => 'h3',
                'translations' => [
                    'de' => [
                        'name' => 'H3',
                        'short_description' => '',
                        'description' => 'Eine raffinierte Komposition, bei der die blumige, leicht minzige Nuance der Rosengeranie auf die samtige Sanftheit von Sandelholz und die cremige Süße der Tonkabohne trifft – ein Duft von zeitloser',
                    ],
                    'en' => [
                        'name' => 'H3',
                        'short_description' => '',
                        'description' => 'A refined composition where the floral, slightly minty nuance of rose geranium meets the velvety softness of sandalwood and the creamy sweetness of tonka bean—a fragrance of timeless allure.',
                    ],
                    'ar' => [
                        'name' => 'H3',
                        'short_description' => '',
                        'description' => 'تركيبة راقية تلتقي فيها النفحات الزهرية واللمسات النعناعية الخفيفة لزهرة الغرنوقي مع نعومة خشب الصندل المخملية وحلاوة حبوب التونكا الكريمية، لتشكل عطراً يفيض بجاذبية خالدة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'intensiv',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'rosengeranie',
                        1 => 'sandelholz',
                        2 => 'tonkabohne',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            70 => [
                'slug' => 'h4',
                'translations' => [
                    'de' => [
                        'name' => 'H4',
                        'short_description' => '',
                        'description' => 'Eine exzellente Mischung, die die spritzige Frische kalabrischer Bergamotte und sizilianischer Zeder mit der würzigen Schärfe von Ingwer und Zimt sowie einer edlen Note von schwarzem Tee vereint – modern, lebendig und äußerst raffiniert.',
                    ],
                    'en' => [
                        'name' => 'H4',
                        'short_description' => '',
                        'description' => 'An excellent blend that combines the sparkling freshness of Calabrian bergamot and Sicilian cedar with the spicy heat of ginger and cinnamon, rounded off by a noble note of black tea—modern, vibrant, and highly refined.',
                    ],
                    'ar' => [
                        'name' => 'H4',
                        'short_description' => '',
                        'description' => 'مزيج استثنائي يجمع بين انتعاش البرغموت الكالابري وخشب الأرز الصقلي مع حرارة الزنجبيل والقرفة، مع لمسة فاخرة من الشاي الأسود، ليقدم عطراً عصرياً وحيوياً يتسم برقي بالغ',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'exklusiv',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'ambrox',
                        1 => 'ceylon-zimt',
                        2 => 'chinesischer-schwarzer-tee-co2',
                        3 => 'kalabrische-bergamotte',
                        4 => 'nigerianischer-ingwer',
                        5 => 'sizilianische-zeder',
                        6 => 'tunesisches-neroli',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            71 => [
                'slug' => 'h5',
                'translations' => [
                    'de' => [
                        'name' => 'H5',
                        'short_description' => '',
                        'description' => 'Eine geheimnisvolle und tiefgründige Kreation, bei der die fruchtige Süße der Himbeere auf das rauchige Aroma von Weihrauch, edles Oud und die balsamische Wärme von Benzoe trifft – ein Duft voller Charakter und Intensität.',
                    ],
                    'en' => [
                        'name' => 'H5',
                        'short_description' => '',
                        'description' => 'A mysterious and profound creation where the fruity sweetness of raspberry meets the smoky aroma of incense, precious oud, and the balsamic warmth of benzoin—a fragrance full of character and intensity.',
                    ],
                    'ar' => [
                        'name' => 'H5',
                        'short_description' => '',
                        'description' => 'ابتكار غامض وعميق تلتقي فيه حلاوة التوت العطرية مع عبق البخور الدخاني، ونفحات العود الفاخرة، ودفء الراتنج البلسمي المستخلص من البنزوين، ليشكل عطراً مليئاً بالشخصية والحدة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'ledrig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'unvergesslich',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'benzoe',
                        1 => 'himbeere',
                        2 => 'oud',
                        3 => 'weihrauch',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            72 => [
                'slug' => 'h7',
                'translations' => [
                    'de' => [
                        'name' => 'H7',
                        'short_description' => '',
                        'description' => 'Eine kraftvolle und verführerische Komposition, in der die prickelnde Frische von Minze und Mandarine auf ein würziges Herz aus Zimt und Rose trifft, abgerundet durch eine markante, sinnliche Basis aus Leder und Amber.',
                    ],
                    'en' => [
                        'name' => 'H7',
                        'short_description' => '',
                        'description' => 'A powerful and seductive composition where the sparkling freshness of mint and mandarin meets a spicy heart of cinnamon and rose, rounded off by a bold, sensual base of leather and amber.',
                    ],
                    'ar' => [
                        'name' => 'H7',
                        'short_description' => '',
                        'description' => 'تركيبة قوية وآسرة، تلتقي فيها انتعاشة النعناع والماندرين بقلب توابل دافئ من القرفة والورد، لتستقر على قاعدة جريئة وحسية من الجلد والعنبر',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'anziehend',
                        2 => 'selbstbewusst',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'leder',
                        2 => 'pfefferminze',
                        3 => 'rose-absolue',
                        4 => 'rote-mandarine',
                        5 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            73 => [
                'slug' => 'h8',
                'translations' => [
                    'de' => [
                        'name' => 'H8',
                        'short_description' => '',
                        'description' => 'Eine dynamische und vielschichtige Komposition, die die spritzige Lebendigkeit italienischer Zitronen und Rhabarber mit der aromatischen Tiefe von Lavendel und Salbei verbindet, perfekt abgerundet durch eine warme, erdige Basis aus Vetiver, Patchouli und Vanille.',
                    ],
                    'en' => [
                        'name' => 'H8',
                        'short_description' => '',
                        'description' => 'A dynamic and multi-faceted composition that blends the sparkling vibrancy of Italian lemon and rhubarb with the aromatic depth of lavender and sage, perfectly rounded off by a warm, earthy base of vetiver, patchouli, and vanilla.',
                    ],
                    'ar' => [
                        'name' => 'H8',
                        'short_description' => '',
                        'description' => 'تركيبة ديناميكية ومتعددة الأبعاد، تمزج بين حيوية الليمون الإيطالي والراوند مع العمق العطري للخزامى والميرمية، وتستقر بشكل مثالي على قاعدة دافئة وترابية من نجيل الهند والباتشولي والفانيليا',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'charismatisch',
                        1 => 'jugendlich',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'fruchtige-noten',
                        1 => 'haitianisches-vetiver',
                        2 => 'indonesisches-patchouli',
                        3 => 'italienische-zitronenschale',
                        4 => 'muskatellersalbei',
                        5 => 'provenzalischer-lavendel-absolue',
                        6 => 'rhabarber',
                        7 => 'vanille-absolue',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            74 => [
                'slug' => 'h9',
                'translations' => [
                    'de' => [
                        'name' => 'H9',
                        'short_description' => '',
                        'description' => 'Eine energiegeladene und kraftvolle Komposition, die die spritzige Frische von Grapefruit und maritimen Noten mit der würzigen Intensität von Lorbeerblatt sowie einer maskulinen, holzigen Basis aus Eichenmoos und Guajakholz vereint.',
                    ],
                    'en' => [
                        'name' => 'H9',
                        'short_description' => '',
                        'description' => 'An energetic and powerful composition that combines the zesty freshness of grapefruit and maritime notes with the spicy intensity of bay leaf, supported by a masculine, woody base of oakmoss and guaiac wood.',
                    ],
                    'ar' => [
                        'name' => 'H9',
                        'short_description' => '',
                        'description' => 'تركيبة مفعمة بالطاقة والقوة، تمزج بين انتعاش الجريب فروت والنوتات البحرية مع حدة أوراق الغار العطرية، مدعومة بقاعدة ذكورية خشبية من طحلب البلوط وخشب الغاياك.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'frisch',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'eichenmoos',
                        2 => 'grapefruit',
                        3 => 'guajakholz',
                        4 => 'jasmin',
                        5 => 'lorbeerblatt',
                        6 => 'maritime-noten',
                        7 => 'patchouli',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            75 => [
                'slug' => 'h10',
                'translations' => [
                    'de' => [
                        'name' => 'H10',
                        'short_description' => '',
                        'description' => 'Eine meisterhafte und komplexe Komposition, die eine Fülle an frischen Zitrusfrüchten und aromatischen Kräutern mit einem blumig-würzigen Herz verbindet, bevor sie in eine tiefgründige, lederne und holzige Basis übergeht – ein Inbegriff zeitloser Maskulinität.',
                    ],
                    'en' => [
                        'name' => 'H10',
                        'short_description' => '',
                        'description' => 'A masterful and complex composition that combines an abundance of fresh citrus and aromatic herbs with a floral-spicy heart, before transitioning into a deep, leathery, and woody base—the epitome of timeless masculinity.',
                    ],
                    'ar' => [
                        'name' => 'H10',
                        'short_description' => '',
                        'description' => 'تركيبة بارعة ومعقدة تجمع بين وفرة من الحمضيات المنعشة والأعشاب العطرية مع قلب زهري توابل، قبل أن تستقر في قاعدة عميقة من الجلد والأخشاب، لتجسد جوهر الرجولة الخالدة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'ledrig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'maskulin',
                        1 => 'unvergesslich',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'gartennelke',
                        3 => 'geissblatt',
                        4 => 'jasmin',
                        5 => 'kamille',
                        6 => 'lavendel',
                        7 => 'leder',
                        8 => 'maigloeckchen',
                        9 => 'mandarine',
                        10 => 'moschus',
                        11 => 'muskat',
                        12 => 'muskatbluete',
                        13 => 'patchouli',
                        14 => 'sandelholz',
                        15 => 'tonkabohne',
                        16 => 'veilchenblatt',
                        17 => 'vetiver',
                        18 => 'weissdorn',
                        19 => 'zeder',
                        20 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            76 => [
                'slug' => 'h11',
                'translations' => [
                    'de' => [
                        'name' => 'H11',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und minimalistische Komposition, bei der die erdige, pudrige Eleganz der florentinischen Schwertlilie auf die moschusartige Sanftheit der Ambrettesamen und die trockene, klare Holznote der Virginiazeder trifft.',
                    ],
                    'en' => [
                        'name' => 'H11',
                        'short_description' => '',
                        'description' => 'A refined and minimalist composition where the earthy, powdery elegance of Florentine iris meets the musky softness of ambrette seeds and the dry, clear woody note of Virginia cedar.',
                    ],
                    'ar' => [
                        'name' => 'H11',
                        'short_description' => '',
                        'description' => 'تركيبة راقية وبسيطة تلتقي فيها الأناقة الترابية البودرية لسوسن فلورنسا مع نعومة بذور الأمبريت المسكية ونفحات خشب الأرز الفيرجيني الجافة والنقية.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'elegant',
                        1 => 'luxurioes',
                        2 => 'raffiniert',
                    ],
                    'noten' => [
                        0 => 'ecuadorianischer-ambrettesamen',
                        1 => 'florentinische-schwertlilie-absolue',
                        2 => 'virginiazeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            77 => [
                'slug' => 'h12',
                'translations' => [
                    'de' => [
                        'name' => 'H12',
                        'short_description' => '',
                        'description' => 'Eine moderne und kraftvolle Komposition, die die spritzige Frische von Bergamotte mit einer würzigen Explosion aus Szechuanpfeffer, Sternanis und Muskat verbindet, während die Basis aus Ambroxan und edler Vanille aus Papua-Neuguinea für eine langanhaltende, sinnliche Tiefe sorgt.',
                    ],
                    'en' => [
                        'name' => 'H12',
                        'short_description' => '',
                        'description' => 'A modern and powerful composition that combines the sparkling freshness of bergamot with a spicy explosion of Szechuan pepper, star anise, and nutmeg, while the base of ambroxan and precious vanilla from Papua New Guinea provides a long-lasting, sensual depth.',
                    ],
                    'ar' => [
                        'name' => 'H12',
                        'short_description' => '',
                        'description' => 'تركيبة عصرية وقوية تجمع بين انتعاش البرغموت وانفجار توابل من فلفل سيتشوان واليانسون النجمي وجوزة الطيب، بينما تضفي قاعدة الأمبروكسان والفانيليا الثمينة من بابوا غينيا الجديدة عمقاً حسياً يدوم طويلاً.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'professionell',
                        1 => 'anziehend',
                        2 => 'maskulin',
                    ],
                    'noten' => [
                        0 => 'ambroxan',
                        1 => 'bergamotte',
                        2 => 'lavendel',
                        3 => 'muskat',
                        4 => 'papua-neuguinea-vanille',
                        5 => 'sternanis',
                        6 => 'szechuanpfeffer',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            78 => [
                'slug' => 'h13',
                'translations' => [
                    'de' => [
                        'name' => 'H13',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und moderne Komposition, die die helle, sonnige Frische kalabrischer Bergamotte und Bergamotteblätter mit der blumigen Eleganz tunesischer Orangenblüte vereint, untermalt von einer tiefgründigen Basis aus erdigem Patchouli, Ambroxan und edlen Hölzern.',
                    ],
                    'en' => [
                        'name' => 'H13',
                        'short_description' => '',
                        'description' => 'A refined and modern composition that combines the bright, sunny freshness of Calabrian bergamot and bergamot leaves with the floral elegance of Tunisian orange blossom, underscored by a profound base of earthy patchouli, ambroxan, and noble woods.',
                    ],
                    'ar' => [
                        'name' => 'H13',
                        'short_description' => '',
                        'description' => 'تركيبة راقية وعصرية تجمع بين انتعاش البرغموت الكالابري وأوراق البرغموت المشرقة مع الأناقة الزهرية لزهر البرتقال التونسي، يبرزها عمق القاعدة المكونة من الباتشولي الترابي والأمبروكسان والأخشاب الفاخرة.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'elegant',
                        2 => 'professionell',
                    ],
                    'noten' => [
                        0 => 'ambroxan',
                        1 => 'bergamotteblatt',
                        2 => 'hoelzer',
                        3 => 'indonesisches-patchouli',
                        4 => 'kalabrische-bergamotte',
                        5 => 'tunesische-orangenbluete-absolue',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            79 => [
                'slug' => 'h14',
                'translations' => [
                    'de' => [
                        'name' => 'H14',
                        'short_description' => '',
                        'description' => 'Eine faszinierende und vielschichtige Kreation, die die spritzige Frische von Bergamotte und die grüne Note von Veilchenblatt mit einer würzigen Intensität aus schwarzem Pfeffer und Koriander vereint, während ein blumiges Herz aus Rose und Maiglöckchen auf einer warmen, verführerischen Basis aus Bourbon-Vanille, Patchouli und Ambra ruht.',
                    ],
                    'en' => [
                        'name' => 'H14',
                        'short_description' => '',
                        'description' => 'A fascinating and multi-layered creation that combines the zesty freshness of bergamot and the green note of violet leaf with a spicy intensity of black pepper and coriander, while a floral heart of rose and lily of the valley rests on a warm, seductive base of Bourbon vanilla, patchouli, and amber.',
                    ],
                    'ar' => [
                        'name' => 'H14',
                        'short_description' => '',
                        'description' => 'ابتكار آسر ومتعدد الأبعاد يجمع بين انتعاش البرغموت واللمسات الخضراء لأوراق البنفسج مع حدة توابل الفلفل الأسود والكزبرة، بينما يستقر قلب زهري من الورد وزنبق الوادي على قاعدة دافئة وجذابة من فانيليا البوربون والباتشولي والعنبر',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'exklusiv',
                        1 => 'raffiniert',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'bergamotte',
                        2 => 'bourbon-vanille',
                        3 => 'koriandersamen',
                        4 => 'maigloeckchen',
                        5 => 'patchouli',
                        6 => 'rose',
                        7 => 'schwarzer-pfeffer',
                        8 => 'veilchenblatt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            80 => [
                'slug' => 'h15',
                'translations' => [
                    'de' => [
                        'name' => 'H15',
                        'short_description' => '',
                        'description' => 'Eine markante und belebende Komposition, die die salzige Frische aquatischer Noten und Bergamotte mit einer aromatischen Herznote aus Rosmarin, Salbei und Rosengeranie kombiniert, elegant abgerundet durch eine tiefgründige, würzig-rauchige Basis aus Weihrauch und Patchouli.',
                    ],
                    'en' => [
                        'name' => 'H15',
                        'short_description' => '',
                        'description' => 'A striking and invigorating composition that combines the salty freshness of aquatic notes and bergamot with an aromatic heart of rosemary, sage, and rose geranium, elegantly rounded off by a profound, spicy-smoky base of incense and patchouli.',
                    ],
                    'ar' => [
                        'name' => 'H15',
                        'short_description' => '',
                        'description' => 'تركيبة بارزة ومنعشة تجمع بين انتعاش النوتات المائية والبرغموت مع قلب عطري من إكليل الجبل والمريمية وإبرة الراعي، يكتمل بأناقة مع قاعدة عميقة غنية بنفحات البخور والباتشولي.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'klassisch',
                        1 => 'professionell',
                        2 => 'maskulin',
                    ],
                    'noten' => [
                        0 => 'aquatische-noten',
                        1 => 'bergamotte',
                        2 => 'patchouli',
                        3 => 'rosengeranie',
                        4 => 'rosmarin',
                        5 => 'salbei',
                        6 => 'weihrauch',
                        7 => 'wuerzige-noten',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            81 => [
                'slug' => 'h16',
                'translations' => [
                    'de' => [
                        'name' => 'H16',
                        'short_description' => '',
                        'description' => 'Eine herzerwärmende und moderne Komposition, die die würzige Frische von Kardamom, rosa Pfeffer und Salbei mit dem gourmandigen, süßen Aroma glasierter Kastanien verbindet, perfekt abgerundet durch eine sanfte Basis aus Vanille und Veilchenblatt.',
                    ],
                    'en' => [
                        'name' => 'H16',
                        'short_description' => '',
                        'description' => 'A heart-warming and modern composition that blends the spicy freshness of cardamom, pink pepper, and sage with the gourmand, sweet aroma of glazed chestnut, perfectly rounded off by a soft base of vanilla and violet leaf.',
                    ],
                    'ar' => [
                        'name' => 'H16',
                        'short_description' => '',
                        'description' => 'تركيبة دافئة وعصرية تجمع بين انتعاش التوابل للهيل والفلفل الوردي والمريمية مع عبير الكستناء المسكرة الحلو، وتكتمل بلمسة ناعمة من الفانيليا وأوراق البنفسج.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'sinnlich',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'glasierte-kastanie',
                        1 => 'kardamom',
                        2 => 'rosa-pfeffer',
                        3 => 'salbei',
                        4 => 'vanille',
                        5 => 'veilchenblatt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            82 => [
                'slug' => 'h17',
                'translations' => [
                    'de' => [
                        'name' => 'H17',
                        'short_description' => '',
                        'description' => 'Eine minimalistische und zugleich tiefgründige Komposition, in der die aromatische, klare Frische von provenzalischem Lavendel auf die süße, cremige Wärme der Bourbon-Vanille trifft, perfekt verankert durch einen edlen, goldenen Amber-Akkord.',
                    ],
                    'en' => [
                        'name' => 'H17',
                        'short_description' => '',
                        'description' => 'A minimalist yet profound composition where the aromatic, clear freshness of Provençal lavender meets the sweet, creamy warmth of Bourbon vanilla, perfectly anchored by a noble, golden amber accord.',
                    ],
                    'ar' => [
                        'name' => 'H17',
                        'short_description' => '',
                        'description' => 'تركيبة بسيطة وعميقة في آن واحد، تلتقي فيها انتعاشة الخزامى البروفنسالي العطرية الصافية مع دفء فانيليا البوربون الكريمي الحلو، وتستقر ببراعة على قاعدة غنية من العنبر الذهبي الفاخر.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'luxurioes',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bourbon-vanille',
                        2 => 'provenzalischer-lavendel',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            83 => [
                'slug' => 'h18',
                'translations' => [
                    'de' => [
                        'name' => 'H18',
                        'short_description' => '',
                        'description' => 'Eine verführerische und ausdrucksstarke Komposition, die die spritzige Frische von Apfel, Bergamotte und grüner Zitrone mit einem blumigen Herz aus Neroli und Rose verbindet, während die Basis aus cremigem Teakholz, Vanille, Moschus und Labdanum für eine unwiderstehliche, langanhaltende Tiefe sorgt.',
                    ],
                    'en' => [
                        'name' => 'H18',
                        'short_description' => '',
                        'description' => 'A seductive and expressive composition that combines the zesty freshness of apple, bergamot, and green lime with a floral heart of neroli and rose, while the base of creamy teak wood, vanilla, musk, and labdanum provides an irresistible, long-lasting depth.',
                    ],
                    'ar' => [
                        'name' => 'H18',
                        'short_description' => '',
                        'description' => 'تركيبة مغرية ومعبرة تجمع بين انتعاش التفاح والبرغموت والليمون الأخضر مع قلب زهري من النيرولي والورد، بينما تضفي القاعدة المكونة من خشب الساج الكريمي والفانيليا والمسك واللابدانوم عمقاً جذاباً يدوم طويلاً',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'anziehend',
                        1 => 'modern',
                        2 => 'sinnlich',
                    ],
                    'noten' => [
                        0 => 'apfel',
                        1 => 'bergamotte',
                        2 => 'gruene-zitrone',
                        3 => 'labdanum',
                        4 => 'moschus',
                        5 => 'neroli',
                        6 => 'patchouli',
                        7 => 'rose',
                        8 => 'teakholz',
                        9 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            84 => [
                'slug' => 'h19',
                'translations' => [
                    'de' => [
                        'name' => 'H19',
                        'short_description' => '',
                        'description' => 'Eine komplexe und harmonische Komposition, die frische, aromatische Akzente wie Minze, Basilikum und Lavendel mit der pudrigen Eleganz von Iris und Veilchen vereint, getragen von einer tiefgründigen, erdigen Basis aus Vetiver, Zeder, Eichenmoos und einem Hauch warmer Tonkabohne.',
                    ],
                    'en' => [
                        'name' => 'H19',
                        'short_description' => '',
                        'description' => 'A complex and harmonious composition that combines fresh, aromatic accents like mint, basil, and lavender with the powdery elegance of iris and violet, supported by a profound, earthy base of vetiver, cedar, oakmoss, and a hint of warm tonka bean.',
                    ],
                    'ar' => [
                        'name' => 'H19',
                        'short_description' => '',
                        'description' => 'تركيبة معقدة ومتناغمة تجمع بين اللمسات العطرية المنعشة مثل النعناع والريحان والخزامى مع الأناقة البودرية للسوسن والبنفسج، ترتكز على قاعدة عميقة وترابية من نجيل الهند وخشب الأرز وطحلب البلوط مع لمسة دافئة من حبوب التونكا',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'sauber',
                        2 => 'sportlich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'basilikum',
                        2 => 'eichenmoos',
                        3 => 'freesie',
                        4 => 'gruene-noten',
                        5 => 'iris',
                        6 => 'lavendel',
                        7 => 'mimose',
                        8 => 'minze',
                        9 => 'patchouli',
                        10 => 'salbei',
                        11 => 'tonkabohne',
                        12 => 'veilchen',
                        13 => 'vetiver',
                        14 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            85 => [
                'slug' => 'h20',
                'translations' => [
                    'de' => [
                        'name' => 'H20',
                        'short_description' => '',
                        'description' => 'Eine tiefgründige, waldige Komposition, die die spritzige Frische von Grapefruit und grünem Apfel mit einer aromatischen Kräutervielfalt aus Basilikum, Minze und Tannenbalsam vereint, abgerundet durch eine maskuline, ledrige Basis mit warmen holzigen Noten und einem Hauch von Rum.',
                    ],
                    'en' => [
                        'name' => 'H20',
                        'short_description' => '',
                        'description' => 'A profound, forest-inspired composition that blends the zesty freshness of grapefruit and green apple with an aromatic variety of herbs, including basil, mint, and balsam fir, rounded off by a masculine, leathery base with warm woody notes and a hint of rum.',
                    ],
                    'ar' => [
                        'name' => 'H20',
                        'short_description' => '',
                        'description' => 'تركيبة عميقة مستوحاة من الغابات، تجمع بين انتعاش الجريب فروت والتفاح الأخضر مع تنوع عطري من الأعشاب مثل الريحان والنعناع وبلسم التنوب، وتكتمل بقاعدة جلدية رجولية مع نوتات خشبية دافئة ولمسة من الروم.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'professionell',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'basilikum',
                        1 => 'gartennelke',
                        2 => 'grapefruit',
                        3 => 'gruener-apfel',
                        4 => 'jasmin',
                        5 => 'kiefernnadel',
                        6 => 'lavendel',
                        7 => 'minze',
                        8 => 'moos',
                        9 => 'rosengeranienblatt',
                        10 => 'rum',
                        11 => 'salbei',
                        12 => 'sandelholz',
                        13 => 'tannenbalsam',
                        14 => 'thymian',
                        15 => 'vetiver',
                        16 => 'wildleder',
                        17 => 'zedernblatt',
                        18 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            86 => [
                'slug' => 'h21',
                'translations' => [
                    'de' => [
                        'name' => 'H21',
                        'short_description' => '',
                        'description' => 'Eine moderne und provokante Komposition, die die salzige Frische mineralischer Noten mit der würzigen Schärfe von Ingwer vereint, verfeinert durch ein Herz aus Salbei und Veilchenblatt, das auf einer eleganten und tiefgründigen Basis aus rauchigem Vetiver und Zedernholz ruht.',
                    ],
                    'en' => [
                        'name' => 'H21',
                        'short_description' => '',
                        'description' => 'A modern and provocative composition that combines the salty freshness of mineral notes with the spicy sharpness of ginger, refined by a heart of sage and violet leaf, resting on an elegant and profound base of smoky vetiver and cedarwood.',
                    ],
                    'ar' => [
                        'name' => 'H21',
                        'short_description' => '',
                        'description' => 'تركيبة عصرية وجريئة تجمع بين انتعاش النوتات المعدنية المالح مع حدة الزنجبيل الحارة، وتكتمل بقلب من المريمية وأوراق البنفسج، تستقر على قاعدة أنيقة وعميقة من نجيل الهند المدخن وخشب الأرز',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'anziehend',
                        2 => 'charismatisch',
                    ],
                    'noten' => [
                        0 => 'ingwer',
                        1 => 'mineralische-noten',
                        2 => 'salbei',
                        3 => 'salz',
                        4 => 'veilchenblatt',
                        5 => 'vetiver',
                        6 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            87 => [
                'slug' => 'h22',
                'translations' => [
                    'de' => [
                        'name' => 'H22',
                        'short_description' => '',
                        'description' => 'Eine reduzierte und kraftvolle Komposition, die die cremige, sanfte Tiefe von neukaledonischem Sandelholz mit der trockenen, maskulinen Stärke von Zeder vereint – eine Hommage an die reine Essenz edler Hölzer.',
                    ],
                    'en' => [
                        'name' => 'H22',
                        'short_description' => '',
                        'description' => 'A refined and powerful composition that blends the creamy, soft depth of New Caledonian sandalwood with the dry, masculine strength of cedar – a tribute to the pure essence of noble woods.',
                    ],
                    'ar' => [
                        'name' => 'H22',
                        'short_description' => '',
                        'description' => 'تركيبة مركزة وقوية تجمع بين العمق الكريمي والناعم لخشب الصندل من كاليدونيا الجديدة مع القوة الجافة والذكورية لخشب الأرز؛ تكريم لجوهر الأخشاب الفاخرة النقي.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'elegant',
                        1 => 'professionell',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'neukaledonisches-sandelholz',
                        1 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            88 => [
                'slug' => 'h24',
                'translations' => [
                    'de' => [
                        'name' => 'H24',
                        'short_description' => '',
                        'description' => 'Eine ikonische und erfrischende Komposition, die die salzige Kühle des Ozeans mit einer aromatischen Mischung aus Lavendel, Minze und Rosmarin verbindet, perfekt abgerundet durch eine klassische Basis aus Moos, Sandelholz und Moschus, die eine zeitlose maritime Frische ausstrahlt.',
                    ],
                    'en' => [
                        'name' => 'H24',
                        'short_description' => '',
                        'description' => 'An iconic and refreshing composition that blends the salty coolness of the ocean with an aromatic blend of lavender, mint, and rosemary, perfectly rounded off by a classic base of moss, sandalwood, and musk, radiating a timeless maritime freshness.',
                    ],
                    'ar' => [
                        'name' => 'H24',
                        'short_description' => '',
                        'description' => 'تركيبة أيقونية ومنعشة تجمع بين برودة المحيط المالح مع مزيج عطري من الخزامى والنعناع وإكليل الجبل، وتكتمل ببراعة مع قاعدة كلاسيكية من طحالب البلوط وخشب الصندل والمسك، مما يضفي انتعاشاً بحرياً لا يتقادم',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'klassisch',
                        2 => 'frisch',
                    ],
                    'noten' => [
                        0 => 'meerwasser',
                        1 => 'minze',
                        2 => 'lavendel',
                        3 => 'rosmarin',
                        4 => 'geranie',
                        5 => 'sandelholz',
                        6 => 'eichenmoos',
                        7 => 'moschus',
                        8 => 'zeder',
                        9 => 'amber',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            89 => [
                'slug' => 'h25',
                'translations' => [
                    'de' => [
                        'name' => 'H25',
                        'short_description' => '',
                        'description' => 'Eine kraftvolle und luxuriöse Komposition, die durch die prominente und exotische Note von Mango in der Kopfnote besticht. Gewürze wie Kardamom und schwarzer Pfeffer verleihen Tiefe, während eine Basis aus cremigem Teakholz, Vanille und Amber für eine extrem langanhaltende und maskuline Präsenz sorgt.',
                    ],
                    'en' => [
                        'name' => 'H25',
                        'short_description' => '',
                        'description' => 'A powerful and luxurious composition, distinguished by the prominent and exotic note of mango in the top note. Spices like cardamom and black pepper add depth, while a base of creamy teak wood, vanilla, and amber ensures an extremely long-lasting and masculine presence.',
                    ],
                    'ar' => [
                        'name' => 'H25',
                        'short_description' => '',
                        'description' => 'تركيبة قوية وفاخرة تتميز بنوتة المانجو الاستوائية البارزة في الافتتاحية. تضفي التوابل مثل الهيل والفلفل الأسود عمقاً، بينما تضمن القاعدة المكونة من خشب الساج الكريمي والفانيليا والعنبر حضوراً ذكورياً قوياً يدوم طويلاً',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'modern',
                        2 => 'charismatisch',
                    ],
                    'noten' => [
                        0 => 'mango',
                        1 => 'apfel',
                        2 => 'gruene-mandarine',
                        3 => 'kardamom',
                        4 => 'lavendel',
                        5 => 'schwarzer-pfeffer',
                        6 => 'pfingstrose',
                        7 => 'veilchen',
                        8 => 'patchouli',
                        9 => 'vetiver',
                        10 => 'teakholz',
                        11 => 'vanille',
                        12 => 'amber',
                        13 => 'moos',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            90 => [
                'slug' => 'h26',
                'translations' => [
                    'de' => [
                        'name' => 'H26',
                        'short_description' => '',
                        'description' => 'Eine sinnliche und moderne Komposition, die durch einen würzig-frischen Auftakt aus Grapefruit, Koriander und Basilikum besticht. Das Herz aus Ingwer, Kardamom und Orangenblüte verleiht dem Duft eine warme Intensität, während die Basis aus Tabak, Amber und Zedernholz für eine unvergessliche, maskuline Tiefe sorgt.',
                    ],
                    'en' => [
                        'name' => 'H26',
                        'short_description' => '',
                        'description' => 'A sensual and modern composition that captivates with a spicy-fresh opening of grapefruit, coriander, and basil. The heart of ginger, cardamom, and orange blossom gives the fragrance a warm intensity, while the base of tobacco, amber, and cedarwood provides an unforgettable, masculine depth.',
                    ],
                    'ar' => [
                        'name' => 'H26',
                        'short_description' => '',
                        'description' => 'تركيبة حسية وعصرية، تأسر الحواس بافتتاحية حارة ومنعشة من الجريب فروت والكزبرة والريحان. يضفي قلب العطر المكون من الزنجبيل والهيل وزهر البرتقال كثافة دافئة، بينما توفر القاعدة المكونة من التبغ والعنبر وخشب الأرز عمقاً ذكورياً لا يُنسى.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'elegant',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber-basilikum-grapefruit-ingwer-kardamom-koriander-orangenbluete-tabak-zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            91 => [
                'slug' => 'h27',
                'translations' => [
                    'de' => [
                        'name' => 'H27',
                        'short_description' => '',
                        'description' => 'Eine lebendige und kraftvolle Komposition, die durch einen eisig-frischen Auftakt aus italienischer Zitrone, Minze und knackigem grünem Apfel besticht. Ein aromatisches Herz aus Rosengeranie führt in eine tiefgründige, sinnliche Basis aus Vanille, Tonkabohne und edlen Hölzern, die durch die moderne Note von Ambroxan perfekt abgerundet wird.',
                    ],
                    'en' => [
                        'name' => 'H27',
                        'short_description' => '',
                        'description' => 'A vibrant and powerful composition that captivates with an icy-fresh opening of Italian lemon, mint, and crisp green apple. An aromatic heart of geranium leads into a profound, sensual base of vanilla, tonka bean, and noble woods, perfectly rounded off by the modern note of ambroxan.',
                    ],
                    'ar' => [
                        'name' => 'H27',
                        'short_description' => '',
                        'description' => 'تركيبة حيوية وقوية تأسر الحواس بافتتاحية باردة ومنعشة من الليمون الإيطالي والنعناع والتفاح الأخضر المقرمش. يقود قلب عطري من إبرة الراعي إلى قاعدة عميقة وحسية من الفانيليا وفول التونكا والأخشاب الفاخرة، التي تكتمل ببراعة مع لمسة "الأمبروكسان" العصرية',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'ambroxan',
                        1 => 'atlaszeder',
                        2 => 'bourbon-vanille',
                        3 => 'eichenmoos',
                        4 => 'gruener-apfel',
                        5 => 'italienische-zitrone',
                        6 => 'minze',
                        7 => 'rosengeranie',
                        8 => 'venezolanische-tonkabohne',
                        9 => 'vetiver',
                        10 => 'virginiazeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            92 => [
                'slug' => 'h28',
                'translations' => [
                    'de' => [
                        'name' => 'H28',
                        'short_description' => '',
                        'description' => 'Eine kraftvolle und ikonische Komposition, die durch die fruchtige Spritzigkeit von Ananas, schwarzer Johannisbeere und Bergamotte eröffnet. Ein komplexes Herz aus Jasmin, Birke und rosa Pfeffer verleiht dem Duft Tiefe, während die maskuline Basis aus Eichenmoos, Patchouli und Ambra für eine unverwechselbare und lang anhaltende Präsenz sorgt.',
                    ],
                    'en' => [
                        'name' => 'H28',
                        'short_description' => '',
                        'description' => 'A powerful and iconic composition that opens with the fruity zest of pineapple, black currant, and bergamot. A complex heart of jasmine, birch, and pink pepper adds depth, while the masculine base of oakmoss, patchouli, and ambergris ensures an unmistakable and long-lasting presence.',
                    ],
                    'ar' => [
                        'name' => 'H28',
                        'short_description' => '',
                        'description' => 'تركيبة قوية وأيقونية تبدأ بحيوية فاكهية من الأناناس والكشمش الأسود والبرغموت. يضفي قلب معقد من الياسمين وخشب البتولا والفلفل الوردي عمقاً للرائحة، بينما تضمن القاعدة الذكورية من طحلب البلوط والباتشولي والعنبر حضوراً لا يُنسى ويدوم طويلاً',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'charismatisch',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'ananas',
                        2 => 'apfel',
                        3 => 'bergamotte',
                        4 => 'birke',
                        5 => 'eichenmoos',
                        6 => 'indonesisches-patchouli',
                        7 => 'jasmin',
                        8 => 'moschus',
                        9 => 'rosa-pfeffer',
                        10 => 'schwarze-johannisbeere',
                        11 => 'zedernholz',
                        12 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            93 => [
                'slug' => 'h29',
                'translations' => [
                    'de' => [
                        'name' => 'H29',
                        'short_description' => '',
                        'description' => 'Eine luftige und belebende Komposition, die durch einen spritzigen Auftakt aus Zitrusfrüchten, Bergamotte und exotischer Papaya definiert wird. Ein sanftes florales Herz aus Jasmin, Rose und Maiglöckchen verbindet sich mit der subtilen Würze von grünem Tee und Muskat, während eine klassische Basis aus Moschus und Amber für einen sauberen, angenehmen Ausklang sorgt.',
                    ],
                    'en' => [
                        'name' => 'H29',
                        'short_description' => '',
                        'description' => 'An airy and invigorating composition defined by a zesty opening of citrus fruits, bergamot, and exotic papaya. A gentle floral heart of jasmine, rose, and lily of the valley blends with the subtle spice of green tea and nutmeg, while a classic base of musk and amber provides a clean, pleasant finish.',
                    ],
                    'ar' => [
                        'name' => 'H29',
                        'short_description' => '',
                        'description' => 'تركيبة منعشة وخفيفة تُعرف بافتتاحيتها الحيوية من الحمضيات والبرغموت والبابايا الاستوائية. يمتزج قلب زهري ناعم من الياسمين والورد وزنبق الوادي مع اللمسة التابلية الرقيقة للشاي الأخضر وجوزة الطيب، بينما توفر القاعدة الكلاسيكية من المسك والعنبر لمسة نهائية نظيفة ومريحة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'gruener-tee',
                        3 => 'jasmin',
                        4 => 'maigloeckchen',
                        5 => 'mandarine',
                        6 => 'moschus',
                        7 => 'muskat',
                        8 => 'papaya',
                        9 => 'rose',
                        10 => 'veilchen',
                        11 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            94 => [
                'slug' => 'h30',
                'translations' => [
                    'de' => [
                        'name' => 'H30',
                        'short_description' => '',
                        'description' => 'Eine raffinierte Komposition, die durch einen spritzigen Auftakt aus Zitrone und Litschi überzeugt. Die aromatische Frische von Lavendel und Rosmarin wird durch eine komplexe Herznote aus warmen Gewürzen wie Kardamom, Koriander und Muskat perfekt ergänzt. Eine maskuline Basis aus edlem Teakholz, Tonkabohne und Vetiver rundet den Duft mit Tiefe und Beständigkeit ab.',
                    ],
                    'en' => [
                        'name' => 'H30',
                        'short_description' => '',
                        'description' => 'A sophisticated composition that impresses with a zesty opening of lemon and lychee. The aromatic freshness of lavender and rosemary is perfectly complemented by a complex heart note of warm spices such as cardamom, coriander, and nutmeg. A masculine base of noble teakwood, tonka bean, and vetiver completes the fragrance with depth and longevity.',
                    ],
                    'ar' => [
                        'name' => 'H30',
                        'short_description' => '',
                        'description' => 'تركيبة راقية تبهر الحواس بافتتاحية منعشة من الليمون والليتشي. يكتمل الانتعاش العطري للخزامى وإكليل الجبل بقلب معقد من التوابل الدافئة كالهيل والكزبرة وجوزة الطيب. وتختتم العطر قاعدة ذكورية من خشب الساج الفاخر وفول التونكا ونجيل الهند، مما يمنحه عمقاً وثباتاً مميزاً',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'anziehend',
                        2 => 'maskulin',
                    ],
                    'noten' => [
                        0 => 'kardamom',
                        1 => 'koriander',
                        2 => 'lavendel',
                        3 => 'litschi',
                        4 => 'muskat',
                        5 => 'orangenbluete',
                        6 => 'rosengeranie',
                        7 => 'rosmarin',
                        8 => 'teakholz',
                        9 => 'tonkabohne',
                        10 => 'vetiver',
                        11 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            95 => [
                'slug' => 'h31',
                'translations' => [
                    'de' => [
                        'name' => 'H31',
                        'short_description' => '',
                        'description' => 'Ein kraftvoller, maskuliner Klassiker, der durch seine opulente Kombination aus honigsüßen Nuancen, aromatischen Kräutern und einer markanten Tabak-Basis eine unverkennbare Präsenz ausstrahlt',
                    ],
                    'en' => [
                        'name' => 'H31',
                        'short_description' => '',
                        'description' => 'A powerful, masculine classic that radiates an unmistakable presence through its opulent combination of honey-sweet nuances, aromatic herbs, and a striking tobacco base.',
                    ],
                    'ar' => [
                        'name' => 'H31',
                        'short_description' => '',
                        'description' => 'كلاسيكيات العطور الرجالية القوية، حيث يجمع بين حلاوة العسل الغنية والأعشاب العطرية، مرتكزاً على قاعدة مميزة من التبغ لتمنح حضوراً لا يُنسى',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'klassisch',
                        1 => 'intensiv',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'ananas',
                        2 => 'basilikum',
                        3 => 'bergamotte',
                        4 => 'eichenmoos',
                        5 => 'estragon',
                        6 => 'honig',
                        7 => 'iriswurzel',
                        8 => 'jasmin',
                        9 => 'kiefer',
                        10 => 'kuemmel',
                        11 => 'lavendel',
                        12 => 'maigloeckchen',
                        13 => 'moschus',
                        14 => 'patchouli',
                        15 => 'petitgrain',
                        16 => 'rose',
                        17 => 'rosenholz',
                        18 => 'sandelholz',
                        19 => 'tabak',
                        20 => 'tonkabohne',
                        21 => 'wacholderbeere',
                        22 => 'zeder',
                        23 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            96 => [
                'slug' => 'h32',
                'translations' => [
                    'de' => [
                        'name' => 'H32',
                        'short_description' => '',
                        'description' => 'Ein erfrischender und belebender Duft, der die knackige Frische von Äpfeln mit aquatischen Lotusnoten und einer erdigen, holzigen Basis harmonisch verbindet.',
                    ],
                    'en' => [
                        'name' => 'H32',
                        'short_description' => '',
                        'description' => 'A refreshing and invigorating fragrance that harmoniously combines the crisp freshness of apples with aquatic lotus notes and an earthy, woody base.',
                    ],
                    'ar' => [
                        'name' => 'H32',
                        'short_description' => '',
                        'description' => 'عطر منعش وحيوي يمزج بين حيوية التفاح المقرمش ونوتات اللوتس المائية مع قاعدة خشبية ترابية متناغمة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'sauber',
                        2 => 'sportlich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'apfel',
                        2 => 'blaetter',
                        3 => 'lotus',
                        4 => 'moos',
                        5 => 'moschus',
                        6 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            97 => [
                'slug' => 'h33',
                'translations' => [
                    'de' => [
                        'name' => 'H33',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und luxuriöse Duftkomposition, die die metallische Frische der Zypresse mit der warmen, pudrigen Süße von Bittermandel und Vanille zu einem maskulinen Meisterwerk vereint.',
                    ],
                    'en' => [
                        'name' => 'H33',
                        'short_description' => '',
                        'description' => 'A refined and luxurious fragrance composition that combines the metallic freshness of cypress with the warm, powdery sweetness of bitter almond and vanilla into a masculine masterpiece.',
                    ],
                    'ar' => [
                        'name' => 'H33',
                        'short_description' => '',
                        'description' => 'تركيبة عطرية فاخرة وراقية، تجمع بين الانتعاش المعدني للسرو مع الدفء البودري لحلاوة اللوز المر والفانيليا لتشكل تحفة رجالية بامتياز',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'elegant',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'bittermandel',
                        3 => 'heliotrop',
                        4 => 'jasmin',
                        5 => 'lavendel',
                        6 => 'sandelholz',
                        7 => 'vanille',
                        8 => 'zypresse',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            98 => [
                'slug' => 'h34',
                'translations' => [
                    'de' => [
                        'name' => 'H34',
                        'short_description' => '',
                        'description' => 'Eine rauchige und atmosphärische Komposition, die das berauschende Aroma von altem Rum mit der süßen Tiefe von Tabak und Vanille zu einer eleganten, nächtlichen Duftreise verschmilzt.',
                    ],
                    'en' => [
                        'name' => 'H34',
                        'short_description' => '',
                        'description' => 'A smoky and atmospheric composition that blends the intoxicating aroma of aged rum with the sweet depth of tobacco and vanilla into an elegant, nocturnal fragrance journey.',
                    ],
                    'ar' => [
                        'name' => 'H34',
                        'short_description' => '',
                        'description' => 'تركيبة دخانية ذات طابع جذاب، تمزج بين رائحة الروم المعتق والعمق الحلو للتبغ والفانيليا لتأخذك في رحلة عطرية ليلية أنيقة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'dunkel',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'java-vetiver',
                        1 => 'muskatellersalbei',
                        2 => 'neroli',
                        3 => 'primofiore-zitrone',
                        4 => 'rosa-pfeffer',
                        5 => 'rum-absolue',
                        6 => 'styrax',
                        7 => 'tabak-absolue',
                        8 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            99 => [
                'slug' => 'h35',
                'translations' => [
                    'de' => [
                        'name' => 'H35',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und energiegeladene Duftkomposition, die die belebende Schärfe von Ingwer und Kardamom mit einer rauchigen Holznote und der süßen Tiefe von Tonkabohne meisterhaft kombiniert.',
                    ],
                    'en' => [
                        'name' => 'H35',
                        'short_description' => '',
                        'description' => 'A refined and energetic fragrance composition that masterfully combines the invigorating spiciness of ginger and cardamom with a smoky wood note and the sweet depth of tonka bean.',
                    ],
                    'ar' => [
                        'name' => 'H35',
                        'short_description' => '',
                        'description' => 'تركيبة عطرية راقية ومليئة بالطاقة، تدمج ببراعة بين حدة الزنجبيل والهيل المنعشة مع لمسة خشبية مدخنة وعمق حلو من حبوب التونكا',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'charismatisch',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'brasilianische-tonkabohne',
                        1 => 'cade-holz',
                        2 => 'guatemala-kardamom',
                        3 => 'haitianisches-vetiver',
                        4 => 'kalabrische-zitrone',
                        5 => 'nigerianischer-ingwer',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            100 => [
                'slug' => 'h36',
                'translations' => [
                    'de' => [
                        'name' => 'H36',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und kontrastreiche Komposition, die die spritzige Frische von Zitrusfrüchten und eine intensive Pfeffermischung mit der warmen, cremigen Süße von Kakao und Tonkabohne verbindet.',
                    ],
                    'en' => [
                        'name' => 'H36',
                        'short_description' => '',
                        'description' => 'A refined and contrasting composition that combines the zesty freshness of citrus fruits and an intense pepper blend with the warm, creamy sweetness of cocoa and tonka bean.',
                    ],
                    'ar' => [
                        'name' => 'H36',
                        'short_description' => '',
                        'description' => 'تركيبة راقية ومتباينة تجمع بين انتعاش الحمضيات ومزيج الفلفل المكثف مع الدفء الكريمي الحلو للكاكاو وحبوب التونكا',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'grapefruit',
                        1 => 'italienische-bergamotte',
                        2 => 'kakao-absolue',
                        3 => 'muskatellersalbei',
                        4 => 'rosa-pfeffer',
                        5 => 'schwarzer-pfeffer',
                        6 => 'tonkabohne',
                        7 => 'vetiver',
                        8 => 'weisser-pfeffer',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            101 => [
                'slug' => 'h37',
                'translations' => [
                    'de' => [
                        'name' => 'H37',
                        'short_description' => '',
                        'description' => 'Eine ausgewogene und frische Duftkomposition, die den sauberen, aromatischen Charakter von Rosmarin und Zedernblatt mit einer blumig-ledrigen Basis elegant kombiniert.',
                    ],
                    'en' => [
                        'name' => 'H37',
                        'short_description' => '',
                        'description' => 'A balanced and fresh fragrance composition that elegantly combines the clean, aromatic character of rosemary and cedar leaf with a floral-leathery base.',
                    ],
                    'ar' => [
                        'name' => 'H37',
                        'short_description' => '',
                        'description' => 'تركيبة عطرية متوازنة ومنعشة، تدمج بين الطابع العطري النظيف لإكليل الجبل وأوراق الأرز مع قاعدة جلدية زهرية بأناقة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'sauber',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'grapefruit',
                        1 => 'holzige-noten',
                        2 => 'kardamom',
                        3 => 'rosmarin',
                        4 => 'tuberose',
                        5 => 'vetiver',
                        6 => 'weihrauch',
                        7 => 'wildleder',
                        8 => 'ylang-ylang',
                        9 => 'zedernblatt',
                        10 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            102 => [
                'slug' => 'h38',
                'translations' => [
                    'de' => [
                        'name' => 'H38',
                        'short_description' => '',
                        'description' => 'Eine dynamische und moderne Komposition, die fruchtige Frische mit aromatischen Kräutern und einem tiefgründigen, holzig-rauchigen Ausklang perfekt verbindet.',
                    ],
                    'en' => [
                        'name' => 'H38',
                        'short_description' => '',
                        'description' => 'A dynamic and modern composition that perfectly balances fruity freshness with aromatic herbs and a deep, woody, smoky finish.',
                    ],
                    'ar' => [
                        'name' => 'H38',
                        'short_description' => '',
                        'description' => 'تركيبة ديناميكية وعصرية توازن بشكل مثالي بين انتعاش الفاكهة والأعشاب العطرية مع قاعدة عميقة من الأخشاب والبخور',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'professionell',
                        2 => 'charismatisch',
                    ],
                    'noten' => [
                        0 => 'apfel',
                        1 => 'bergamotte',
                        2 => 'elemiharz',
                        3 => 'ingwer',
                        4 => 'lavendel',
                        5 => 'rosengeranie-absolue',
                        6 => 'salbei',
                        7 => 'tonkabohne',
                        8 => 'vetiver',
                        9 => 'wacholderbeere',
                        10 => 'weihrauch',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            103 => [
                'slug' => 'h39',
                'translations' => [
                    'de' => [
                        'name' => 'H39',
                        'short_description' => '',
                        'description' => 'Ein kraftvoller und verführerischer Duft, der die aromatische Frische von Lavendel und Salbei mit einer üppigen, süß-würzigen Basis aus Vanille, Zimt und edlem Leder verbindet.',
                    ],
                    'en' => [
                        'name' => 'H39',
                        'short_description' => '',
                        'description' => 'A powerful and seductive fragrance that combines the aromatic freshness of lavender and sage with a rich, sweet-spicy base of vanilla, cinnamon, and fine leather.',
                    ],
                    'ar' => [
                        'name' => 'H39',
                        'short_description' => '',
                        'description' => 'عطر قوي وجذاب يجمع بين الانتعاش العطري للخزامى والميرمية مع قاعدة غنية وحلوة التوابل تتكون من الفانيليا والقرفة والجلد الفاخر',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'frisch',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'artemisia',
                        1 => 'iris',
                        2 => 'kardamom',
                        3 => 'lavendel',
                        4 => 'leder',
                        5 => 'patchouli',
                        6 => 'rosa-pfeffer',
                        7 => 'salbei',
                        8 => 'sandelholz',
                        9 => 'tannenbalsam',
                        10 => 'tonkabohne',
                        11 => 'vanille',
                        12 => 'zedernholz',
                        13 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            104 => [
                'slug' => 'h40',
                'translations' => [
                    'de' => [
                        'name' => 'H40',
                        'short_description' => '',
                        'description' => 'Eine dunkle und anspruchsvolle Komposition, die die spritzige Frische von Zitrusfrüchten mit einer komplexen Würze aus Kardamom und Zimt sowie einer süß-harzigen Basis aus Praline und schwarzem Amber meisterhaft verbindet.',
                    ],
                    'en' => [
                        'name' => 'H40',
                        'short_description' => '',
                        'description' => 'A dark and sophisticated composition that masterfully combines the zesty freshness of citrus with complex spices of cardamom and cinnamon, and a sweet-resinous base of praline and black amber.',
                    ],
                    'ar' => [
                        'name' => 'H40',
                        'short_description' => '',
                        'description' => 'تركيبة غامضة وراقية، تدمج ببراعة بين الانتعاش الحمضي والتوابل المعقدة للهيل والقرفة، مع قاعدة حلوة وراتنجية من البرالين والعنبر الأسود',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'sinnlich',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'calamondinorange',
                        1 => 'ebenholz',
                        2 => 'kalabrische-zitrone',
                        3 => 'patchouli',
                        4 => 'praline',
                        5 => 'rosenholz',
                        6 => 'salbei',
                        7 => 'schwarzer-amber',
                        8 => 'schwarzer-kardamom',
                        9 => 'tagetes',
                        10 => 'tolubalsam',
                        11 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            105 => [
                'slug' => 'h41',
                'translations' => [
                    'de' => [
                        'name' => 'H41',
                        'short_description' => '',
                        'description' => 'Ein kraftvoller und nostalgischer Duft, der fruchtige Süße mit einer würzigen, maskulinen Tabaknote vereint, um ein charakterstarkes und zeitloses Erlebnis zu schaffen.',
                    ],
                    'en' => [
                        'name' => 'H41',
                        'short_description' => '',
                        'description' => 'A powerful and nostalgic fragrance that combines fruity sweetness with a spicy, masculine tobacco note to create a characterful and timeless experience.',
                    ],
                    'ar' => [
                        'name' => 'H41',
                        'short_description' => '',
                        'description' => 'عطر قوي ذو طابع كلاسيكي، يجمع بين حلاوة الفاكهة ونوتة التبغ الذكورية الحارة ليخلق تجربة عطرية غنية بالشخصية والخالدة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'tabak',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'maskulin',
                        1 => 'klassisch',
                        2 => 'raffiniert',
                    ],
                    'noten' => [
                        0 => 'ananas',
                        1 => 'basilikum',
                        2 => 'bergamotte',
                        3 => 'birne',
                        4 => 'jasmin',
                        5 => 'lorbeer',
                        6 => 'moschus',
                        7 => 'muskat',
                        8 => 'patchouli',
                        9 => 'pflaume',
                        10 => 'ringelblume',
                        11 => 'rosengeranie',
                        12 => 'sandelholz',
                        13 => 'tabak',
                        14 => 'zeder',
                        15 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            106 => [
                'slug' => 'h42',
                'translations' => [
                    'de' => [
                        'name' => 'H42',
                        'short_description' => '',
                        'description' => 'Eine opulente und faszinierende Komposition, die die exotische Süße des indischen Kulfi-Desserts mit kostbaren floralen Noten, würzigem Safran und einer warmen, cremigen Basis aus Vanille und Sandelholz verbindet.',
                    ],
                    'en' => [
                        'name' => 'H42',
                        'short_description' => '',
                        'description' => 'An opulent and fascinating composition that blends the exotic sweetness of the Indian Kulfi dessert with precious floral notes, spicy saffron, and a warm, creamy base of vanilla and sandalwood.',
                    ],
                    'ar' => [
                        'name' => 'H42',
                        'short_description' => '',
                        'description' => 'تركيبة غنية وفاتنة، تمزج بين الحلاوة الغريبة لحلوى "الكولفي" الهندية مع نوتات زهرية ثمينة، الزعفران الحار، وقاعدة دافئة وكريمية من الفانيليا وخشب الصندل',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'sinnlich',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'jasmin',
                        2 => 'kardamom',
                        3 => 'kulfi',
                        4 => 'mandarine',
                        5 => 'mastixharz',
                        6 => 'muskat',
                        7 => 'neroli',
                        8 => 'orangenbluete',
                        9 => 'rose',
                        10 => 'safran',
                        11 => 'sandelholz',
                        12 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            107 => [
                'slug' => 'h43',
                'translations' => [
                    'de' => [
                        'name' => 'H43',
                        'short_description' => '',
                        'description' => 'Ein kühner und ikonischer Duft, der die belebende Kühle von Minze und Lavendel mit der sinnlichen Wärme von Zimt, Vanille und würzigen orientalischen Akzenten kontrastiert.',
                    ],
                    'en' => [
                        'name' => 'H43',
                        'short_description' => '',
                        'description' => 'A bold and iconic fragrance that contrasts the invigorating coolness of mint and lavender with the sensual warmth of cinnamon, vanilla, and spicy oriental accents.',
                    ],
                    'ar' => [
                        'name' => 'H43',
                        'short_description' => '',
                        'description' => 'تركيبة جريئة وأيقونية، تباين بين برودة النعناع والخزامى المنعشة والدفء الحسي للقرفة والفانيليا واللمسات الشرقية الحارة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'birne',
                        3 => 'hoelzer',
                        4 => 'kreuzkuemmel',
                        5 => 'lavendel',
                        6 => 'minze',
                        7 => 'muskatellersalbei',
                        8 => 'vanille',
                        9 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            108 => [
                'slug' => 'h44',
                'translations' => [
                    'de' => [
                        'name' => 'H44',
                        'short_description' => '',
                        'description' => 'Eine meisterhafte und raffinierte Komposition, die die edle, erdige Tiefe von Oud und Zedernholz mit einer würzigen Kopfnote aus rosa Pfeffer und einer sanften, cremigen Moschus-Basis harmonisch vereint',
                    ],
                    'en' => [
                        'name' => 'H44',
                        'short_description' => '',
                        'description' => 'A masterful and refined composition that harmoniously combines the noble, earthy depth of oud and cedarwood with a spicy top note of pink pepper and a soft, creamy musk base.',
                    ],
                    'ar' => [
                        'name' => 'H44',
                        'short_description' => '',
                        'description' => 'تركيبة بارعة وراقية، تدمج بانسجام بين العمق الترابي النبيل للعود وخشب الأرز مع نوتة عليا حارة من الفلفل الوردي وقاعدة ناعمة وكريمية من المسك',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'dunkel',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'agarholz-oud',
                        1 => 'amber',
                        2 => 'angelika',
                        3 => 'bergamotte',
                        4 => 'galbanum',
                        5 => 'moschus',
                        6 => 'muskat',
                        7 => 'pinker-pfeffer',
                        8 => 'sandelholz',
                        9 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            109 => [
                'slug' => 'h45',
                'translations' => [
                    'de' => [
                        'name' => 'H45',
                        'short_description' => '',
                        'description' => 'Eine hochkonzentrierte und kraftvolle Interpretation, die die ikonische Frische von Lavendel mit einer warmen, würzigen Herznote aus Zimt und Muskatnuss sowie einer tiefen, holzig-sinnlichen Basis vereint. Ein Duft mit außergewöhnlicher Sillage und Langlebigkeit.',
                    ],
                    'en' => [
                        'name' => 'H45',
                        'short_description' => '',
                        'description' => 'A highly concentrated and powerful interpretation that combines the iconic freshness of lavender with a warm, spicy heart of cinnamon and nutmeg, followed by a deep, woody, and sensual base. A fragrance with exceptional sillage and longevity.',
                    ],
                    'ar' => [
                        'name' => 'H45',
                        'short_description' => '',
                        'description' => 'تركيبة مركزة وقوية للغاية، تجمع بين الانتعاش الأيقوني للخزامى مع قلب دافئ وحار من القرفة وجوزة الطيب، يليه قاعدة عميقة خشبية وحسية. عطر يتميز بفوحان وثبات استثنائي',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'unvergesslich',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'zimt',
                        1 => 'muskatnuss',
                        2 => 'kardamom',
                        3 => 'grapefruit',
                        4 => 'lavendel',
                        5 => 'suessholz-lakritze',
                        6 => 'sandelholz',
                        7 => 'amber',
                        8 => 'patschuli',
                        9 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            110 => [
                'slug' => 'h46',
                'translations' => [
                    'de' => [
                        'name' => 'H46',
                        'short_description' => '',
                        'description' => 'Eine moderne Interpretation des klassischen Oud-Themas. „Weißes Oud“ steht für einen hellen, weniger animalischen und „saubereren“ Oud-Akkord, der oft mit cremigen Hölzern und weichem Moschus kombiniert wird. Es ist ein sehr eleganter, unaufdringlicher Duft, der Reinheit mit orientalischer Tiefe verbindet.',
                    ],
                    'en' => [
                        'name' => 'H46',
                        'short_description' => '',
                        'description' => 'A modern interpretation of the classic oud theme. "White Oud" represents a bright, less animalic, and "cleaner" oud accord, often paired with creamy woods and soft musk. It is a very elegant, unobtrusive scent that blends purity with oriental depth.',
                    ],
                    'ar' => [
                        'name' => 'H46',
                        'short_description' => '',
                        'description' => 'تفسير عصري لنوتة العود الكلاسيكية. يرمز "العود الأبيض" إلى عود فاتح، أقل حدة وحيوانية، وأكثر "نظافة"، وغالباً ما يتم دمجه مع الأخشاب الكريمية والمسك الناعم. هو عطر أنيق جداً وغير متكلف، يجمع بين النقاء والعمق الشرقي',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'elegant',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'weisses-oud-synthetischhell',
                        1 => 'weisser-moschus',
                        2 => 'sandelholz',
                        3 => 'vanille',
                        4 => 'florale-noten-oft-rose-oder-jasmin',
                        5 => 'leichte-zitrusnoten',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            111 => [
                'slug' => 'h48',
                'translations' => [
                    'de' => [
                        'name' => 'H48',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und ausdrucksstarke Komposition, die die pudrige Eleganz der Iris mit einer würzigen Kopfnote aus Pfeffer und einer tiefen, sinnlichen Basis aus schwarzer Vanille und holzigem Patchouli perfekt in Szene setzt.',
                    ],
                    'en' => [
                        'name' => 'H48',
                        'short_description' => '',
                        'description' => 'A refined and expressive composition that perfectly showcases the powdery elegance of iris with a spicy top note of pepper and a deep, sensual base of black vanilla and woody patchouli.',
                    ],
                    'ar' => [
                        'name' => 'H48',
                        'short_description' => '',
                        'description' => 'تركيبة راقية ومعبرة، تبرز ببراعة الأناقة البودرية لزهرة السوسن (Iris) مع نوتة عليا حارة من الفلفل وقاعدة عميقة وحسية من الفانيليا السوداء والباتشولي الخشبي',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'elegant',
                        1 => 'klassisch',
                        2 => 'raffiniert',
                    ],
                    'noten' => [
                        0 => 'iris',
                        1 => 'lavendel',
                        2 => 'birne',
                        3 => 'schwarzer-pfeffer',
                        4 => 'patchouli',
                        5 => 'schwarze-vanille',
                        6 => 'tolubalsam',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            112 => [
                'slug' => 'h49',
                'translations' => [
                    'de' => [
                        'name' => 'H49',
                        'short_description' => '',
                        'description' => 'Eine moderne Interpretation von Männlichkeit, die die belebende Spritzigkeit von Bergamotte mit einer aromatischen Würze aus Pfeffer und Wacholder verbindet. Die Basis aus drei edlen Zedernholzarten sorgt für eine kraftvolle, erdige und elegante Tiefe.',
                    ],
                    'en' => [
                        'name' => 'H49',
                        'short_description' => '',
                        'description' => 'A modern interpretation of masculinity that combines the invigorating zest of bergamot with an aromatic spice of pepper and juniper. The base of three noble cedarwood varieties provides a powerful, earthy, and elegant depth.',
                    ],
                    'ar' => [
                        'name' => 'H49',
                        'short_description' => '',
                        'description' => 'تفسير عصري للرجولة، يجمع بين انتعاش البرغموت المشرق والتوابل العطرية للفلفل والعرعر. القاعدة المكونة من ثلاثة أنواع فاخرة من خشب الأرز تمنح العطر عمقاً قوياً، ترابياً وأنيقاً',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'maskulin',
                        2 => 'professionell',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'schwarzer-pfeffer',
                        2 => 'wacholder',
                        3 => 'virginia-zeder',
                        4 => 'atlas-zeder',
                        5 => 'himalaya-zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            113 => [
                'slug' => 'h50',
                'translations' => [
                    'de' => [
                        'name' => 'H50',
                        'short_description' => '',
                        'description' => 'Eine betörende und luxuriöse Komposition, die den würzigen Auftakt von Safran und Zimt mit der samtigen Herznote aus Rose und Patschuli vereint. Eine Basis aus tiefem Oud, warmem Amber und süßer Vanille verleiht dem Duft eine mysteriöse und unverwechselbare Präsenz.',
                    ],
                    'en' => [
                        'name' => 'H50',
                        'short_description' => '',
                        'description' => 'A captivating and luxurious composition that combines the spicy opening of saffron and cinnamon with a velvety heart of rose and patchouli. A base of deep oud, warm amber, and sweet vanilla gives the fragrance a mysterious and unmistakable presence.',
                    ],
                    'ar' => [
                        'name' => 'H50',
                        'short_description' => '',
                        'description' => 'تركيبة فاتنة وفاخرة، تجمع بين الافتتاحية الحارة للزعفران والقرفة مع قلب مخملي من الورد والباتشولي. قاعدة من العود العميق، العنبر الدافئ، والفانيليا تمنح العطر حضوراً غامضاً لا ينسى',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'luxurioes',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'safran',
                        1 => 'zimt',
                        2 => 'rose',
                        3 => 'patschuli',
                        4 => 'oud',
                        5 => 'amber',
                        6 => 'moschus',
                        7 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            114 => [
                'slug' => 'h51',
                'translations' => [
                    'de' => [
                        'name' => 'H51',
                        'short_description' => '',
                        'description' => 'Eine hochkonzentrierte und berauschende Interpretation. Die ikonische Frische von Lavendel und Minze trifft auf eine sinnliche Basis aus warmem Honig, intensiver Vanille, edlem Tabak und süßer Tonkabohne. Ein Duft mit extremem Wiedererkennungswert.',
                    ],
                    'en' => [
                        'name' => 'H51',
                        'short_description' => '',
                        'description' => 'A highly concentrated and intoxicating interpretation. The iconic freshness of lavender and mint meets a sensual base of warm honey, intense vanilla, noble tobacco, and sweet tonka bean. A fragrance with extreme recognizability.',
                    ],
                    'ar' => [
                        'name' => 'H51',
                        'short_description' => '',
                        'description' => 'تركيبة مركزة ومسكرة للغاية. يلتقي الانتعاش الأيقوني للخزامى والنعناع بقاعدة حسية دافئة من العسل، والفانيليا المكثفة، والتبغ النبيل، وفول التونكا. عطر يتميز ببروز وقوة استثنائية',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'sinnlich',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'lavendel',
                        1 => 'minze',
                        2 => 'zimt',
                        3 => 'benzoe',
                        4 => 'tonkabohne',
                        5 => 'honig',
                        6 => 'tabak',
                        7 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            115 => [
                'slug' => 'h52',
                'translations' => [
                    'de' => [
                        'name' => 'H52',
                        'short_description' => '',
                        'description' => 'Eine moderne, leuchtende Komposition, die durch den metallischen Glanz von Aldehyden und eine aquatische Meeresbrise eröffnet wird. Das Herz aus spritzigen Zitrusfrüchten und würzigem Pfeffer findet in einer maskulinen Basis aus holzigem Vetiver, Zeder und der süßlichen Tiefe von Tonkabohne und Vanille ihren Abschluss.',
                    ],
                    'en' => [
                        'name' => 'H52',
                        'short_description' => '',
                        'description' => 'A modern, luminous composition that opens with the metallic shine of aldehydes and an aquatic sea breeze. The heart of zesty citrus and spicy pepper concludes in a masculine base of woody vetiver, cedar, and the sweet depth of tonka bean and vanilla.',
                    ],
                    'ar' => [
                        'name' => 'H52',
                        'short_description' => '',
                        'description' => 'تركيبة عصرية مشرقة، تفتتح ببريق الألدهيدات المعدني ونسيم البحر المائي. يمتزج قلب العطر المكون من الحمضيات المنعشة والفلفل الحار مع قاعدة ذكورية من نجيل الهند الخشبي، وخشب الأرز، والعمق الحلو لفول التونكا والفانيليا',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'sportlich',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'aldehyde',
                        1 => 'meerwasser',
                        2 => 'mandarine',
                        3 => 'orange',
                        4 => 'neroli',
                        5 => 'pfeffer',
                        6 => 'zeder',
                        7 => 'vetiver',
                        8 => 'moschus',
                        9 => 'amber',
                        10 => 'tonkabohne',
                        11 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            116 => [
                'slug' => 'h53',
                'translations' => [
                    'de' => [
                        'name' => 'H53',
                        'short_description' => '',
                        'description' => 'Eine raffinierte und konzentrierte Interpretation von Boss Bottled. Die rauchige Tiefe von Weihrauch und die würzige Wärme von Kardamom eröffnen ein kraftvolles Herz aus Patchouli und Vetiver. Die Basis aus Labdanum Absolue und Zedernholz verleiht dem Duft eine langanhaltende, elegante Männlichkeit.',
                    ],
                    'en' => [
                        'name' => 'H53',
                        'short_description' => '',
                        'description' => 'A sophisticated and concentrated interpretation of Boss Bottled. The smoky depth of incense and the spicy warmth of cardamom open a powerful heart of patchouli and vetiver. The base of labdanum absolute and cedarwood gives the fragrance a long-lasting, elegant masculinity.',
                    ],
                    'ar' => [
                        'name' => 'H53',
                        'short_description' => '',
                        'description' => 'تفسير راقٍ ومركز لعطر "بوس بوتلد". تفتح الرائحة بعمق دخاني من البخور ودفء حار من الهيل، لتكشف عن قلب قوي من الباتشولي ونجيل الهند. تمنح القاعدة المكونة من "لابدانوم أبسولوت" وخشب الأرز العطر طابعاً ذكورياً أنيقاً ويدوم طويلاً',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'professionell',
                        1 => 'luxurioes',
                        2 => 'intensiv',
                    ],
                    'noten' => [
                        0 => 'weihrauch',
                        1 => 'kardamom',
                        2 => 'vetiver',
                        3 => 'patchouli',
                        4 => 'labdanum-absolue',
                        5 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            117 => [
                'slug' => 'h54',
                'translations' => [
                    'de' => [
                        'name' => 'H54',
                        'short_description' => '',
                        'description' => 'Eine intensive und kraftvolle Neuinterpretation. Die elegante florale Note von Orangenblüte und Iris trifft auf eine würzige Herznote aus Muskat und Piment. Die reichhaltige, balsamische Basis aus Siam-Benzoe, Patchouli und cremigem Vanillin verleiht diesem Elixier eine beispiellose Tiefe und Anziehungskraft.',
                    ],
                    'en' => [
                        'name' => 'H54',
                        'short_description' => '',
                        'description' => 'An intensive and powerful reinterpretation. The elegant floral note of orange blossom and iris meets a spicy heart of nutmeg and allspice. The rich, balsamic base of Siam benzoin, patchouli, and creamy vanillin gives this elixir unparalleled depth and allure.',
                    ],
                    'ar' => [
                        'name' => 'H54',
                        'short_description' => '',
                        'description' => 'إعادة تفسير مكثفة وقوية. تلتقي النوتة الزهرية الأنيقة لزهر البرتقال والسوسن مع قلب حار من جوزة الطيب والبهارات (الفلفل الإفرنجي). تمنح القاعدة الغنية والبالسمية من "سيام بنزوين"، والباتشولي، والفانيليا الكريمية، هذا الإكسير عمقاً وجاذبية لا تضاهى',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'elegant',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'orangenbluete-absolue',
                        1 => 'muskat',
                        2 => 'piment',
                        3 => 'irisbutter',
                        4 => 'osmanthus',
                        5 => 'siam-benzoe',
                        6 => 'patchouli',
                        7 => 'ambroxan',
                        8 => 'vanillin',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            118 => [
                'slug' => 'h55',
                'translations' => [
                    'de' => [
                        'name' => 'H55',
                        'short_description' => '',
                        'description' => 'Eine intensive Interpretation, die den Fokus auf rauchige und würzige Akzente legt. Der Tabak steht im Zentrum und wird durch die Hitze von Chili und Zimt verstärkt, während die ikonische Kastanien- und Vanillenote für eine elegante, süßliche Wärme in der Basis sorgt.',
                    ],
                    'en' => [
                        'name' => 'H55',
                        'short_description' => '',
                        'description' => 'An intense interpretation that focuses on smoky and spicy accents. Tobacco takes center stage and is enhanced by the heat of chili and cinnamon, while the iconic chestnut and vanilla note provides an elegant, sweet warmth in the base.',
                    ],
                    'ar' => [
                        'name' => 'H55',
                        'short_description' => '',
                        'description' => 'تفسير مكثف يركز على اللمسات الدخانية والتوابل. يحتل التبغ مركز العطر ويُعزز بحرارة الفلفل الحار والقرفة، بينما توفر نوتة الكستناء والفانيليا الأيقونية دفئاً حلواً وأنيقاً في القاعدة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'tabak',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'warm',
                        2 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'schwarzer-pfeffer',
                        1 => 'salbei',
                        2 => 'tabak',
                        3 => 'zimt',
                        4 => 'chili',
                        5 => 'kastanie',
                        6 => 'bourbon-vanille',
                        7 => 'benzoe',
                        8 => 'guajakholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            119 => [
                'slug' => 'h56',
                'translations' => [
                    'de' => [
                        'name' => 'H56',
                        'short_description' => '',
                        'description' => 'Eine noch reichhaltigere und süßere Interpretation des Originals. Die Kombination aus Kastanie und Vanille wird durch eine intensive Karamellnote und eine würzige Zimt-Nuance verstärkt, was den Duft extrem langanhaltend und verführerisch macht.',
                    ],
                    'en' => [
                        'name' => 'H56',
                        'short_description' => '',
                        'description' => 'An even richer and sweeter interpretation of the original. The combination of chestnut and vanilla is enhanced by an intense caramel note and a spicy cinnamon nuance, making the fragrance extremely long-lasting and seductive.',
                    ],
                    'ar' => [
                        'name' => 'H56',
                        'short_description' => '',
                        'description' => 'تجسيد أكثر غنى وحلاوة للنسخة الأصلية. يُعزز مزيج الكستناء والفانيليا بنوتة مكثفة من الكراميل ولمسة من القرفة، مما يجعل هذا العطر يتميز بثبات فائق وجاذبية لا تقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'sinnlich',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'rosa-pfeffer',
                        1 => 'lavendel',
                        2 => 'salbei',
                        3 => 'zimt',
                        4 => 'karamell',
                        5 => 'kastanie',
                        6 => 'vanille',
                        7 => 'tonkabohne',
                        8 => 'amberholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            120 => [
                'slug' => 'h57',
                'translations' => [
                    'de' => [
                        'name' => 'H57',
                        'short_description' => '',
                        'description' => 'Eine warme und opulente Komposition, die mit den Noten von Zimt und luxuriösem Honig betört, ergänzt durch eine tiefe Basis aus Amber und Vanille für ein Gefühl von Luxus und außergewöhnlicher Anziehungskraft.',
                    ],
                    'en' => [
                        'name' => 'H57',
                        'short_description' => '',
                        'description' => 'A warm and opulent composition that captivates with notes of cinnamon and luxurious honey, complemented by a deep base of amber and vanilla for a feeling of luxury and exceptional allure.',
                    ],
                    'ar' => [
                        'name' => 'H57',
                        'short_description' => '',
                        'description' => 'توليفة دافئة وغنية تفيض برائحة القرفة والعسل الفاخر، تمتزج بقاعدة عميقة من العنبر والفانيليا لتمنحك شعوراً بالفخامة والجاذبية الاستثنائية',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'luxurioes',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'benzoe',
                        2 => 'davana',
                        3 => 'honig',
                        4 => 'labdanum',
                        5 => 'osmanthus',
                        6 => 'patchouli',
                        7 => 'tonkabohne',
                        8 => 'vanille',
                        9 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            121 => [
                'slug' => 'h58',
                'translations' => [
                    'de' => [
                        'name' => 'H58',
                        'short_description' => '',
                        'description' => 'Ein mysteriöses und komplexes Dufterlebnis, das scharfe Gewürze und tiefe Harze mit einer luxuriösen Ledernote kombiniert, die eine kraftvolle Präsenz hinterlässt.',
                    ],
                    'en' => [
                        'name' => 'H58',
                        'short_description' => '',
                        'description' => 'A mysterious and complex olfactory experience that blends sharp spices and deep resins with a luxurious leather note, commanding a powerful presence.',
                    ],
                    'ar' => [
                        'name' => 'H58',
                        'short_description' => '',
                        'description' => 'تجربة عطرية غامضة ومعقدة تمزج بين التوابل اللاذعة والراتنجات العميقة مع لمسة جلدية فخمة تفرض حضورها القوي.',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'intensiv',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'leder',
                        3 => 'opoponax',
                        4 => 'oregano',
                        5 => 'oud',
                        6 => 'patchouli',
                        7 => 'piment',
                        8 => 'sandelholz',
                        9 => 'weihrauch',
                        10 => 'zistrose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            122 => [
                'slug' => 'h59',
                'translations' => [
                    'de' => [
                        'name' => 'H59',
                        'short_description' => '',
                        'description' => 'Eine moderne Komposition, die die Wärme glasierter Kastanien mit der Sanftheit von Vanille und würzig-ledrigen Akzenten für ein verführerisches Erlebnis vereint.',
                    ],
                    'en' => [
                        'name' => 'H59',
                        'short_description' => '',
                        'description' => 'A modern blend combining the warmth of glazed chestnut and the softness of vanilla with spicy, leathery accents for an alluring experience.',
                    ],
                    'ar' => [
                        'name' => 'H59',
                        'short_description' => '',
                        'description' => 'مزيج عصري يجمع بين دفء الكستناء المحلاة ونعومة الفانيليا مع لمسات عطرية حادة من الجلد والتوابل لتجربة جذابة',
                    ],
                ],
                'categories' => [
                    0 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'elegant',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille',
                        1 => 'elemiharz',
                        2 => 'glasierte-kastanie',
                        3 => 'lavendel',
                        4 => 'leder',
                        5 => 'muskatellersalbei',
                        6 => 'rosa-pfeffer',
                        7 => 'zeder',
                        8 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '15.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            123 => [
                'slug' => 'u1',
                'translations' => [
                    'de' => [
                        'name' => 'U1',
                        'short_description' => '',
                        'description' => 'Ein opulenter und dramatischer Duft, der die dramatische Präsenz der türkischen Rose mit dunklen, ledrigen Facetten und einer cremigen Basis aus Vanille und Ambra perfekt in Szene setzt.',
                    ],
                    'en' => [
                        'name' => 'U1',
                        'short_description' => '',
                        'description' => 'An opulent and dramatic fragrance that perfectly showcases the dramatic presence of Turkish rose with dark, leathery facets and a creamy base of vanilla and amber.',
                    ],
                    'ar' => [
                        'name' => 'U1',
                        'short_description' => '',
                        'description' => 'عطر فخم ودرامي يبرز الحضور القوي للورد التركي مع جوانب جلدية غامضة وقاعدة كريمية غنية من الفانيليا والعنبر',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'luxurioes',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'fruchtige-noten',
                        2 => 'haitianisches-vetiver',
                        3 => 'leder',
                        4 => 'moschus',
                        5 => 'muskat',
                        6 => 'patchouli',
                        7 => 'tuerkische-rose',
                        8 => 'ylang-ylang',
                        9 => 'zedernholz',
                        10 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            124 => [
                'slug' => 'u2',
                'translations' => [
                    'de' => [
                        'name' => 'U2',
                        'short_description' => '',
                        'description' => 'Ein strahlender und charismatischer Duft, der mit einer fruchtigen Ananas-Note beginnt und durch ein florales Herz aus Iris und Jasmin sowie eine sinnlich-warme Basis besticht.',
                    ],
                    'en' => [
                        'name' => 'U2',
                        'short_description' => '',
                        'description' => 'A radiant and charismatic fragrance that begins with a fruity pineapple note and captivates through a floral heart of iris and jasmine, as well as a sensual, warm base.',
                    ],
                    'ar' => [
                        'name' => 'U2',
                        'short_description' => '',
                        'description' => 'عطر مشرق وجذاب يفتتح بنوتة الأناناس الفاكهية ويأسر الحواس بقلب زهري من السوسن والياسمين، مع قاعدة دافئة وحسية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'ananas',
                        2 => 'hyazinthe',
                        3 => 'iris',
                        4 => 'jasmin',
                        5 => 'moschus',
                        6 => 'patchouli',
                        7 => 'rosa-pfeffer',
                        8 => 'vanille',
                        9 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            125 => [
                'slug' => 'u3',
                'translations' => [
                    'de' => [
                        'name' => 'U3',
                        'short_description' => '',
                        'description' => 'Eine betörende und tiefgründige Komposition, die die frische Spritzigkeit von Zitrusfrüchten mit der süßen Wärme von Honig, Tabak und würzigem Zimt harmonisch vereint',
                    ],
                    'en' => [
                        'name' => 'U3',
                        'short_description' => '',
                        'description' => 'A beguiling and profound composition that harmoniously combines the fresh vibrancy of citrus fruits with the sweet warmth of honey, tobacco, and spicy cinnamon.',
                    ],
                    'ar' => [
                        'name' => 'U3',
                        'short_description' => '',
                        'description' => 'تركيبة ساحرة وعميقة تجمع بانسجام بين حيوية الحمضيات المنعشة والدفء الحلو للعسل والتبغ والقرفة الحارة',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'intensiv',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'honig',
                        2 => 'jasmin-sambac',
                        3 => 'kaschmir',
                        4 => 'lavendel',
                        5 => 'tabak',
                        6 => 'tonkabohne',
                        7 => 'vanille',
                        8 => 'zimt',
                        9 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            126 => [
                'slug' => 'u4',
                'translations' => [
                    'de' => [
                        'name' => 'U4',
                        'short_description' => '',
                        'description' => 'Eine lebendige und sonnendurchflutete Kreation, die spritzige Zitrusfrüchte aus Sizilien mit der süßen Tiefe von Bourbon-Vanille und edlem Amber verschmilzt.',
                    ],
                    'en' => [
                        'name' => 'U4',
                        'short_description' => '',
                        'description' => 'A vibrant and sun-drenched creation that merges zesty citrus fruits from Sicily with the sweet depth of Bourbon vanilla and precious amber.',
                    ],
                    'ar' => [
                        'name' => 'U4',
                        'short_description' => '',
                        'description' => 'ابتكار حيوي مشبع بضوء الشمس، يدمج بين حمضيات صقلية المنعشة والعمق الحلو للفانيليا البوربونية والعنبر الفاخر',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bourbon-vanille',
                        2 => 'fruchtige-noten',
                        3 => 'kalabrische-bergamotte',
                        4 => 'sizilianische-orange',
                        5 => 'sizilianische-zitrone',
                        6 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            127 => [
                'slug' => 'u5',
                'translations' => [
                    'de' => [
                        'name' => 'U5',
                        'short_description' => '',
                        'description' => 'Eine opulente und tiefgründige Kreation, die rauchigen Tabak mit der intensiven Süße von Trockenfrüchten und edlem Kakao zu einem unwiderstehlichen Erlebnis verbindet.',
                    ],
                    'en' => [
                        'name' => 'U5',
                        'short_description' => '',
                        'description' => 'An opulent and profound creation that combines smoky tobacco with the intense sweetness of dried fruits and fine cocoa into an irresistible experience.',
                    ],
                    'ar' => [
                        'name' => 'U5',
                        'short_description' => '',
                        'description' => 'ابتكار فخم وعميق يمزج بين التبغ المدخن وحلاوة الفواكه المجففة المكثفة والكاكاو الفاخر ليقدم تجربة عطرية لا تقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'sinnlich',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'getrocknete-fruechte',
                        1 => 'harze',
                        2 => 'ingwer',
                        3 => 'kakao',
                        4 => 'tabak',
                        5 => 'tonkabohne',
                        6 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            128 => [
                'slug' => 'u6',
                'translations' => [
                    'de' => [
                        'name' => 'U6',
                        'short_description' => '',
                        'description' => 'Ein provokanter und tiefgründiger Duft, der die Süße der Vanille mit sinnlichen animalischen Noten und pudriger Iris zu einem verführerischen und modernen Meisterwerk verbindet.',
                    ],
                    'en' => [
                        'name' => 'U6',
                        'short_description' => '',
                        'description' => 'A provocative and profound fragrance that blends the sweetness of vanilla with sensual animalic notes and powdery iris into a seductive and modern masterpiece.',
                    ],
                    'ar' => [
                        'name' => 'U6',
                        'short_description' => '',
                        'description' => 'عطر استفزازي وعميق يمزج حلاوة الفانيليا مع النوتات الحيوانية الحسية والسوسن البودري ليخلق تحفة فنية مغرية وعصرية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'modern',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'animalische-noten',
                        1 => 'indische-vanille',
                        2 => 'iriswurzel',
                        3 => 'jasmin-absolue',
                        4 => 'sandelholz',
                        5 => 'vanille-absolue',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            129 => [
                'slug' => 'u7',
                'translations' => [
                    'de' => [
                        'name' => 'U7',
                        'short_description' => '',
                        'description' => 'Eine berauschende und opulente Komposition, die die saftige Intensität reifer Kirschen mit einem Hauch von Bittermandel und edlen balsamischen Noten zu einem verführerischen Gourmand-Erlebnis verschmilzt.',
                    ],
                    'en' => [
                        'name' => 'U7',
                        'short_description' => '',
                        'description' => 'An intoxicating and opulent composition that fuses the juicy intensity of ripe cherries with a hint of bitter almond and precious balsamic notes into a seductive gourmand experience.',
                    ],
                    'ar' => [
                        'name' => 'U7',
                        'short_description' => '',
                        'description' => 'تركيبة مسكرة وفاخرة تمزج بين كثافة الكرز الناضج مع لمسة من اللوز المر والنوتات البلسمية الثمينة لخلق تجربة عطرية شرقية لا تقاوم',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'bittermandel',
                        1 => 'geroestete-tonkabohne',
                        2 => 'jasmin-sambac',
                        3 => 'kirsch-likoer',
                        4 => 'perubalsam',
                        5 => 'sandelholz',
                        6 => 'sauerkirschsirup',
                        7 => 'schwarzkirsche',
                        8 => 'tuerkische-rose',
                        9 => 'vetiver',
                        10 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            130 => [
                'slug' => 'u8',
                'translations' => [
                    'de' => [
                        'name' => 'U8',
                        'short_description' => '',
                        'description' => 'Ein kühner und ikonischer Duft, der die aromatische Frische von Lavendel und Salbei mit einer dekadenten, ledrigen Herznote und einer cremig-süßen Basis aus Tonkabohne und Vanille vereint.',
                    ],
                    'en' => [
                        'name' => 'U8',
                        'short_description' => '',
                        'description' => 'A bold and iconic fragrance that combines the aromatic freshness of lavender and sage with a decadent, leathery heart and a creamy-sweet base of tonka bean and vanilla.',
                    ],
                    'ar' => [
                        'name' => 'U8',
                        'short_description' => '',
                        'description' => 'عطر جريء وأيقوني يجمع بين الانتعاش العطري لللافندر والميرمية مع قلب جلدي مترف وقاعدة كريمية حلوة من التونكا والفانيليا',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'elegant',
                        1 => 'professionell',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bittermandel',
                        2 => 'helle-hoelzer',
                        3 => 'iris',
                        4 => 'lavendel',
                        5 => 'leder',
                        6 => 'muskatellersalbei',
                        7 => 'tonkabohne',
                        8 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            131 => [
                'slug' => 'u9',
                'translations' => [
                    'de' => [
                        'name' => 'U9',
                        'short_description' => '',
                        'description' => 'Eine tiefgründige und mystische Komposition, die die rauchige Eleganz von Oud und Rosenholz mit einer würzigen Wärme aus Kardamom und Rosa Pfeffer harmonisch verbindet.',
                    ],
                    'en' => [
                        'name' => 'U9',
                        'short_description' => '',
                        'description' => 'A profound and mystical composition that harmoniously combines the smoky elegance of oud and rosewood with a spicy warmth of cardamom and pink pepper.',
                    ],
                    'ar' => [
                        'name' => 'U9',
                        'short_description' => '',
                        'description' => 'تركيبة عميقة وروحانية تمزج بانسجام بين الأناقة الدخانية للعود وخشب الورد مع دفء حار من الهيل والفلفل الوردي',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'intensiv',
                        2 => 'maskulin',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'kardamom',
                        2 => 'oud',
                        3 => 'rosa-pfeffer',
                        4 => 'rosenholz',
                        5 => 'sandelholz',
                        6 => 'tonkabohne',
                        7 => 'vetiver',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            132 => [
                'slug' => 'u10',
                'translations' => [
                    'de' => [
                        'name' => 'U10',
                        'short_description' => '',
                        'description' => 'Ein exzentrischer und berauschender Duft, der die süße Saftigkeit von Weinbergpfirsich mit einer dunklen, harzigen Basis aus Patchouli und einer würzigen alkoholischen Note von Cognac und Rum veredelt.',
                    ],
                    'en' => [
                        'name' => 'U10',
                        'short_description' => '',
                        'description' => 'An eccentric and intoxicating fragrance that ennobles the sweet juiciness of vine peach with a dark, resinous base of patchouli and a spicy alcoholic note of cognac and rum.',
                    ],
                    'ar' => [
                        'name' => 'U10',
                        'short_description' => '',
                        'description' => 'عطر استثنائي ومسكر يرفع من شأن الحلاوة العصيرية لدرّاق الكرم، مع قاعدة داكنة وراتنجية من الباتشولي ونوتات كحولية حارة من الكونياك والروم',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'modern',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'benzoe',
                        1 => 'cognac',
                        2 => 'davana',
                        3 => 'heliotrop',
                        4 => 'indonesisches-patchouli',
                        5 => 'jasmin-sambac-absolue',
                        6 => 'kardamom',
                        7 => 'labdanum',
                        8 => 'moschus',
                        9 => 'neukaledonisches-sandelholz',
                        10 => 'rum-absolue',
                        11 => 'sizilianische-blutorange',
                        12 => 'styrax',
                        13 => 'tonkabohne-absolue',
                        14 => 'vanille',
                        15 => 'weinbergpfirsich',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            133 => [
                'slug' => 'u11',
                'translations' => [
                    'de' => [
                        'name' => 'U11',
                        'short_description' => '',
                        'description' => 'Eine prickelnde und dynamische Komposition, die die spritzige Säure der Sauerkirsche mit der würzigen Wärme von Ingwer und der blumigen Opulenz des Jasmin-Sambac harmonisch verbindet.',
                    ],
                    'en' => [
                        'name' => 'U11',
                        'short_description' => '',
                        'description' => 'A sparkling and dynamic composition that harmoniously combines the zesty acidity of sour cherry with the spicy warmth of ginger and the floral opulence of jasmine sambac.',
                    ],
                    'ar' => [
                        'name' => 'U11',
                        'short_description' => '',
                        'description' => 'تركيبة متلألئة وديناميكية تجمع بانسجام بين حموضة الكرز اللاذعة ودفء الزنجبيل الحار وفخامة الياسمين الزهرية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'jugendlich',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'indischer-ingwer',
                        1 => 'indischer-jasmin-sambac-absolue',
                        2 => 'moschus',
                        3 => 'pistazie',
                        4 => 'rosa-pfeffer',
                        5 => 'sandelholz',
                        6 => 'sauerkirsche',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            134 => [
                'slug' => 'u12',
                'translations' => [
                    'de' => [
                        'name' => 'U12',
                        'short_description' => '',
                        'description' => 'Ein berauschendes Meisterwerk, das die rauchige Tiefe von Oud und Leder mit der unwiderstehlichen, süßen Wärme von Tonkabohne und Rohrzucker verbindet. Es ist ein Duft mit einer enormen Ausstrahlung und einer fast magischen, würzigen Eleganz.',
                    ],
                    'en' => [
                        'name' => 'U12',
                        'short_description' => '',
                        'description' => 'An intoxicating masterpiece that combines the smoky depth of oud and leather with the irresistible, sweet warmth of tonka bean and cane sugar. It is a fragrance with enormous projection and an almost magical, spicy elegance.',
                    ],
                    'ar' => [
                        'name' => 'U12',
                        'short_description' => '',
                        'description' => 'تحفة عطرية مسكرة تجمع بين العمق الدخاني للعود والجلد مع الدفء الحلو الذي لا يقاوم لفول التونكا وسكر القصب. إنه عطر يتميز بفوحان هائل وأناقة حارة ذات طابع سحري تقريباً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'luxurioes',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'bulgarische-rose',
                        3 => 'eichenmoos',
                        4 => 'leder',
                        5 => 'nepalesisches-oud',
                        6 => 'rohrzucker',
                        7 => 'safran',
                        8 => 'tonkabohne',
                        9 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            135 => [
                'slug' => 'u13',
                'translations' => [
                    'de' => [
                        'name' => 'U13',
                        'short_description' => '',
                        'description' => 'Eine meisterhafte Balance zwischen der aromatischen Kraft frisch gerösteter Kaffeebohnen und der samtigen Eleganz einer tiefroten Rose. Abgerundet durch eine cremige Basis aus Vanille, Amber und weißem Moschus entsteht ein süßer, lang anhaltender und absolut fesselnder Duft.',
                    ],
                    'en' => [
                        'name' => 'U13',
                        'short_description' => '',
                        'description' => 'A masterful balance between the aromatic power of freshly roasted coffee beans and the velvety elegance of a deep red rose. Rounded off by a creamy base of vanilla, amber, and white musk, it creates a sweet, long-lasting, and absolutely captivating scent.',
                    ],
                    'ar' => [
                        'name' => 'U13',
                        'short_description' => '',
                        'description' => 'توازن متقن بين القوة العطرية لحبوب القهوة المحمصة طازجاً والأناقة المخملية للورد الأحمر العميق. تكتمل التركيبة بقاعدة كريمية من الفانيليا والعنبر والمسك الأبيض، مما ينتج عطراً حلواً ويدوم طويلاً وآسراً للغاية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'luxurioes',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'blumige-noten',
                        2 => 'kaffee',
                        3 => 'rose',
                        4 => 'vanille',
                        5 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            136 => [
                'slug' => 'u14',
                'translations' => [
                    'de' => [
                        'name' => 'U14',
                        'short_description' => '',
                        'description' => 'Eine olfaktorische Interpretation eines Abends in Paris. Dieser Duft vereint die Wärme von hochwertigem Amber und Labdanum mit der sanften Süße von Vanille und Tonkabohne, was eine goldene, fast leuchtende Eleganz auf der Haut hinterlässt.',
                    ],
                    'en' => [
                        'name' => 'U14',
                        'short_description' => '',
                        'description' => 'An olfactory interpretation of an evening in Paris. This fragrance combines the warmth of high-quality amber and labdanum with the soft sweetness of vanilla and tonka bean, leaving a golden, almost luminous elegance on the skin.',
                    ],
                    'ar' => [
                        'name' => 'U14',
                        'short_description' => '',
                        'description' => 'تجسيد عطري لأمسية باريسية ساحرة. يجمع هذا العطر بين دفء العنبر واللابدانوم عالي الجودة مع الحلاوة الناعمة للفانيليا وفول التونكا، مما يترك أثراً من الأناقة الذهبية المتوهجة على البشرة',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'elegant',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'brasilianische-tonkabohne',
                        1 => 'ceylon-zimtblatt',
                        2 => 'provenzalischer-lavendel',
                        3 => 'siam-benzoe',
                        4 => 'spanisches-labdanum',
                        5 => 'vanille',
                        6 => 'venezolanische-tonkabohne',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            137 => [
                'slug' => 'u15',
                'translations' => [
                    'de' => [
                        'name' => 'U15',
                        'short_description' => '',
                        'description' => 'Eine explosive und extrem haltbare Kreation, in der die rauchige Tiefe von Tabak auf eine opulente Mischung aus Gewürzen wie Zimt und Muskat trifft. Das kostbare Oud und die cremige Vanille verleihen dem Duft eine berauschende, sinnliche und maskuline Aura.',
                    ],
                    'en' => [
                        'name' => 'U15',
                        'short_description' => '',
                        'description' => 'An explosive and extremely long-lasting creation where the smoky depth of tobacco meets an opulent blend of spices such as cinnamon and nutmeg. The precious oud and creamy vanilla give the fragrance an intoxicating, sensual, and masculine aura.',
                    ],
                    'ar' => [
                        'name' => 'U15',
                        'short_description' => '',
                        'description' => 'إبداع انفجاري وذو ثباتية استثنائية، يلتقي فيه العمق الدخاني للتبغ مع مزيج فاخر من التوابل مثل القرفة وجوزة الطيب. يضفي العود الثمين والفانيليا الكريمية على العطر هالة مسكرة وحسية وذكورية بامتياز',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'intensiv',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'gruener-apfel',
                        2 => 'guajakholz',
                        3 => 'holzige-noten',
                        4 => 'jasmin',
                        5 => 'muskat',
                        6 => 'nepalesisches-oud',
                        7 => 'patchouli',
                        8 => 'safran',
                        9 => 'tabak',
                        10 => 'vanille',
                        11 => 'vetiver',
                        12 => 'weihrauch',
                        13 => 'weisser-moschus',
                        14 => 'weisser-pfirsich',
                        15 => 'zim',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            138 => [
                'slug' => 'u16',
                'translations' => [
                    'de' => [
                        'name' => 'U16',
                        'short_description' => '',
                        'description' => 'Eine tiefschwarze, komplexe Komposition, die das rauchige Aroma von Hanf und Tabak mit harzigen Hölzern, Kaffee und einer dunklen Süße verbindet. Ein intensiver und kontroverser Duft, der eine kraftvolle, fast spirituelle Aura von absoluter Tiefe und Beständigkeit ausstrahlt.',
                    ],
                    'en' => [
                        'name' => 'U16',
                        'short_description' => '',
                        'description' => 'A deep, black, and complex composition that combines the smoky aroma of hemp and tobacco with resinous woods, coffee, and a dark sweetness. An intense and controversial fragrance that exudes a powerful, almost spiritual aura of absolute depth and persistence.',
                    ],
                    'ar' => [
                        'name' => 'U16',
                        'short_description' => '',
                        'description' => 'تركيبة سوداء عميقة ومعقدة تجمع بين رائحة القنب والتبغ المدخنة مع الأخشاب الراتنجية والقهوة وحلاوة داكنة. عطر مكثف ومثير للجدل، يطلق هالة قوية تكاد تكون روحانية ذات عمق مطلق وثباتية استثنائية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'intensiv',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'agarholz',
                        1 => 'ambra',
                        2 => 'ambroxan',
                        3 => 'animalische-noten',
                        4 => 'beifuss',
                        5 => 'gruene-noten',
                        6 => 'guajakholz',
                        7 => 'gurjanbalsam',
                        8 => 'hanf',
                        9 => 'harze',
                        10 => 'himbeere',
                        11 => 'holzige-noten',
                        12 => 'kaffee',
                        13 => 'moschus',
                        14 => 'safran',
                        15 => 'tabak',
                        16 => 'thymian',
                        17 => 'tonkabohne',
                        18 => 'vanille',
                        19 => 'veilchen',
                        20 => 'weihrauch',
                        21 => 'zeder',
                        22 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            139 => [
                'slug' => 'u17',
                'translations' => [
                    'de' => [
                        'name' => 'U17',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse und wärmende Kreation, die durch die süße Opulenz von Datteln, Praline und Vanille besticht. Die würzige Tiefe von Zimt und Muskat, gepaart mit einer harzigen Basis aus Myrrhe und Benzoe, verleiht dem Duft eine reiche, verführerische und exklusive Ausstrahlung.',
                    ],
                    'en' => [
                        'name' => 'U17',
                        'short_description' => '',
                        'description' => 'A luxurious and warming creation, distinguished by the sweet opulence of dates, praline, and vanilla. The spicy depth of cinnamon and nutmeg, paired with a resinous base of myrrh and benzoin, gives the fragrance a rich, seductive, and exclusive aura.',
                    ],
                    'ar' => [
                        'name' => 'U17',
                        'short_description' => '',
                        'description' => 'إبداع فاخر ودافئ يتميز بالثراء الحلو للتمور والبرالين والفانيليا. يمنح العمق الحار للقرفة وجوزة الطيب، مقترناً بقاعدة راتنجية من المر والبنزوين، هذا العطر هالة غنية وجذابة',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'sinnlich',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amberholz',
                        1 => 'bergamotte',
                        2 => 'blumige-noten',
                        3 => 'dattel',
                        4 => 'geroestete-tonkabohne',
                        5 => 'holzige-noten',
                        6 => 'muskat',
                        7 => 'myrrhe',
                        8 => 'praline',
                        9 => 'siam-benzoe',
                        10 => 'tuberose',
                        11 => 'vanille',
                        12 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            140 => [
                'slug' => 'u18',
                'translations' => [
                    'de' => [
                        'name' => 'U18',
                        'short_description' => '',
                        'description' => 'Ein zarter und verführerischer Duft, der die Wärme von Amber und Vanille mit einer pudrigen Moschus-Basis verbindet. Blumige Akzente von Damaszener-Rose und Geißblatt, gepaart mit einer leichten Fruchtigkeit, machen ihn zu einem eleganten Begleiter für jeden Anlass.',
                    ],
                    'en' => [
                        'name' => 'U18',
                        'short_description' => '',
                        'description' => 'A delicate and seductive fragrance that blends the warmth of amber and vanilla with a powdery musk base. Floral accents of Damask rose and honeysuckle, paired with a light fruitiness, make it an elegant companion for any occasion.',
                    ],
                    'ar' => [
                        'name' => 'U18',
                        'short_description' => '',
                        'description' => 'عطر رقيق وجذاب يمزج بين دفء العنبر والفانيليا وقاعدة من المسك البودري. اللمسات الزهرية من الورد الدمشقي وزهر العسل، المقترنة بلمحة فاكهية خفيفة، تجعل منه رفيقاً أنيقاً يناسب جميع المناسبات',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'pudrig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'sauber',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'balsamische-noten',
                        2 => 'blumige-noten',
                        3 => 'damaszener-rose',
                        4 => 'fruchtige-noten',
                        5 => 'geissblatt',
                        6 => 'grapefruit',
                        7 => 'moschusnoten',
                        8 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            141 => [
                'slug' => 'u19',
                'translations' => [
                    'de' => [
                        'name' => 'U19',
                        'short_description' => '',
                        'description' => 'Eine meisterhafte Komposition, die die opulente Intensität von Oud mit der samtigen Eleganz der Rose verbindet. Durch die rauchige Tiefe von Labdanum, die erdige Würze von Patchouli und die cremige Wärme von Sandelholz entsteht ein Duft, der sowohl kraftvoll als auch exzellent ausbalanciert ist.',
                    ],
                    'en' => [
                        'name' => 'U19',
                        'short_description' => '',
                        'description' => 'A masterful composition that blends the opulent intensity of oud with the velvety elegance of rose. Through the smoky depth of labdanum, the earthy spice of patchouli, and the creamy warmth of sandalwood, a fragrance is created that is both powerful and excellently balanced.',
                    ],
                    'ar' => [
                        'name' => 'U19',
                        'short_description' => '',
                        'description' => 'تركيبة متقنة تجمع بين كثافة العود الفاخرة وأناقة الورد المخملية. يمنح العمق الدخاني للابدانوم، والتوابل الترابية للباتشولي، والدفء الكريمي لخشب الصندل هذا العطر توازناً استثنائياً وحضوراً قوياً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'dunkel',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'labdanum',
                        1 => 'oud',
                        2 => 'patchouli',
                        3 => 'rose',
                        4 => 'sandelholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            142 => [
                'slug' => 'u20',
                'translations' => [
                    'de' => [
                        'name' => 'U20',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse und betörende Komposition, die das intensive Oud-Aroma mit einer köstlichen Fruchtigkeit aus Birne und Himbeere verbindet. Die Herznote aus bulgarischer Rose und Orangenblüte verleiht dem Duft eine florale Fülle, während Amber, Patchouli und Moschus für einen langanhaltenden, warmen und sinnlichen Ausklang sorgen.',
                    ],
                    'en' => [
                        'name' => 'U20',
                        'short_description' => '',
                        'description' => 'A luxurious and beguiling composition that blends the intense oud aroma with a delicious fruitiness of pear and raspberry. The heart note of Bulgarian rose and orange blossom gives the fragrance a floral richness, while amber, patchouli, and musk ensure a long-lasting, warm, and sensual finish.',
                    ],
                    'ar' => [
                        'name' => 'U20',
                        'short_description' => '',
                        'description' => 'تركيبة فاخرة وآسرة تجمع بين رائحة العود المكثفة ونكهة الفاكهة اللذيذة من الكمثرى والتوت. يضفي قلب العطر المكون من الورد البلغاري وزهر البرتقال غنىً زهرياً، بينما يضمن العنبر والباتشولي والمسك لمسة نهائية دافئة وحسية تدوم طويلاً.',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'intensiv',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'birne',
                        2 => 'bulgarische-rose',
                        3 => 'himbeere',
                        4 => 'moschus',
                        5 => 'orangenbluete',
                        6 => 'oud',
                        7 => 'patchouli',
                        8 => 'safran',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            143 => [
                'slug' => 'u21',
                'translations' => [
                    'de' => [
                        'name' => 'U21',
                        'short_description' => '',
                        'description' => 'Eine moderne Interpretation des Chypre-Klassikers. Hacivat besticht durch seine explosive, fruchtige Eröffnung aus Ananas und Zitrusfrüchten, die in ein elegantes, holziges Herz übergeht. Die Basis aus Eichenmoos und trockenen Hölzern verleiht dem Duft eine bemerkenswerte Tiefe und eine herausragende Haltbarkeit.',
                    ],
                    'en' => [
                        'name' => 'U21',
                        'short_description' => '',
                        'description' => 'A modern interpretation of the classic chypre. Hacivat captivates with its explosive, fruity opening of pineapple and citrus, transitioning into an elegant, woody heart. The base of oakmoss and dry woods gives the fragrance remarkable depth and outstanding longevity.',
                    ],
                    'ar' => [
                        'name' => 'U21',
                        'short_description' => '',
                        'description' => 'تجسيد عصري لعطور الشيبر الكلاسيكية. يتميز "هاسيفات" بافتتاحية فاكهية انفجارية من الأناناس والحمضيات، التي تنتقل إلى قلب خشبي أنيق. تمنح قاعدة طحلب البلوط والأخشاب الجافة العطر عمقاً استثنائياً وثباتية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'charismatisch',
                        2 => 'selbstbewusst',
                    ],
                    'noten' => [
                        0 => 'ananas',
                        1 => 'bergamotte',
                        2 => 'eichenmoos',
                        3 => 'grapefruit',
                        4 => 'holzige-noten',
                        5 => 'jasmin',
                        6 => 'patchouli',
                        7 => 'trockene-hoelzer',
                        8 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            144 => [
                'slug' => 'u22',
                'translations' => [
                    'de' => [
                        'name' => 'U22',
                        'short_description' => '',
                        'description' => 'Eine faszinierende und kühne Kreation, die die exotische, saftige Säure der Passionsfrucht mit der dunklen, rauchigen Tiefe von Oud kombiniert. Die florale Eleganz der türkischen Rose und die würzige Wärme von Safran treffen auf eine reichhaltige, balsamische Basis aus Leder, Vanille und Benzoe, was diesen Duft zu einem unverwechselbaren, modernen Meisterwerk macht.',
                    ],
                    'en' => [
                        'name' => 'U22',
                        'short_description' => '',
                        'description' => 'A fascinating and bold creation that combines the exotic, juicy acidity of passion fruit with the dark, smoky depth of oud. The floral elegance of Turkish rose and the spicy warmth of saffron meet a rich, balsamic base of leather, vanilla, and benzoin, making this fragrance an unmistakable, modern masterpiece.',
                    ],
                    'ar' => [
                        'name' => 'U22',
                        'short_description' => '',
                        'description' => 'إبداع جريء ومذهل يجمع بين الحموضة الاستوائية اللذيذة لفاكهة العاطفة (الباشن فروت) والعمق الداكن والدخاني للعود. تلتقي الأناقة الزهرية للورد التركي ودفء الزعفران التوابلي مع قاعدة غنية وبلسمية من الجلد والفانيليا والبنزوين، مما يجعل هذا العطر تحفة فنية عصرية لا تُنسى.',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'intensiv',
                        1 => 'luxurioes',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'holzige-noten',
                        1 => 'indonesisches-patchouli',
                        2 => 'leder',
                        3 => 'oud',
                        4 => 'passionsfrucht',
                        5 => 'safran',
                        6 => 'siam-benzoe',
                        7 => 'spanische-zistrose-absolue',
                        8 => 'tuerkische-rose-absolue',
                        9 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            145 => [
                'slug' => 'u23',
                'translations' => [
                    'de' => [
                        'name' => 'U23',
                        'short_description' => '',
                        'description' => 'Eine olfaktorische Hommage an das Erbe der Parfümeursfamilie Hennessy. Der Duft fängt die Essenz von in Eichenfässern gereiftem Cognac ein, veredelt durch eine unwiderstehliche Süße aus Himbeer-Likör, würzigem Zimt und cremiger Tonkabohne. Die bulgarische Rose und das edle Sandelholz verleihen dieser Kreation eine luxuriöse Tiefe, die an einen exklusiven Likör erinnert.',
                    ],
                    'en' => [
                        'name' => 'U23',
                        'short_description' => '',
                        'description' => 'An olfactory tribute to the heritage of the Hennessy perfumer family. The fragrance captures the essence of cognac aged in oak barrels, refined by an irresistible sweetness of raspberry liqueur, spicy cinnamon, and creamy tonka bean. Bulgarian rose and precious sandalwood give this creation a luxurious depth reminiscent of an exclusive liqueur.',
                    ],
                    'ar' => [
                        'name' => 'U23',
                        'short_description' => '',
                        'description' => 'تكريم عطري لإرث عائلة "هينيسي" لصانعي العطور. يجسد العطر جوهر الكونياك المعتق في براميل البلوط، والمُعزز بحلاوة لا تقاوم من مشروب التوت، والقرفة الحارة، وفول التونكا الكريمي. يمنح الورد البلغاري وخشب الصندل الفاخر هذا الإبداع عمقاً مترفاً يشبه مشروباً حصرياً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'sinnlich',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'bulgarische-rose',
                        1 => 'cognac',
                        2 => 'eiche',
                        3 => 'himbeer-likoer',
                        4 => 'indisches-sandelholz',
                        5 => 'tonkabohne-absolue',
                        6 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            146 => [
                'slug' => 'u24',
                'translations' => [
                    'de' => [
                        'name' => 'U24',
                        'short_description' => '',
                        'description' => 'Eine hypnotische und strahlende Komposition, die an einen Spaziergang an einem exotischen Strand erinnert. Die Kopfnote aus einer Fülle reifer Früchte wie Passionsfrucht, Pfirsich und Himbeere wirkt sofort belebend. Das Herz aus Maiglöckchen fügt eine zarte Blumigkeit hinzu, während eine warme, langanhaltende Basis aus Moschus, Sandelholz und Vanille dem Duft eine unwiderstehliche, fast schon süchtig machende Ausstrahlung verleiht.',
                    ],
                    'en' => [
                        'name' => 'U24',
                        'short_description' => '',
                        'description' => 'A hypnotic and radiant composition reminiscent of a stroll on an exotic beach. The top note of an abundance of ripe fruits like passion fruit, peach, and raspberry feels instantly invigorating. The heart of lily of the valley adds a delicate floral touch, while a warm, long-lasting base of musk, sandalwood, and vanilla gives the fragrance an irresistible, almost addictive aura.',
                    ],
                    'ar' => [
                        'name' => 'U24',
                        'short_description' => '',
                        'description' => 'تركيبة مغناطيسية ومشرقة تذكرنا بنزهة على شاطئ استوائي. تمنح النوتات الافتتاحية المليئة بالفواكه الناضجة مثل الباشن فروت والخوخ والتوت شعوراً فورياً بالانتعاش. يضيف قلب زنبق الوادي لمسة زهرية رقيقة، بينما تمنح القاعدة الدافئة والثابتة من المسك وخشب الصندل والفانيليا العطر هالة لا تقاوم تكاد تكون إدمانية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'anziehend',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'birne',
                        1 => 'heliotrop',
                        2 => 'himbeere',
                        3 => 'maigloeckchen',
                        4 => 'moschus',
                        5 => 'passionsfrucht',
                        6 => 'patchouli',
                        7 => 'pfirsich',
                        8 => 'sand',
                        9 => 'sandelholz',
                        10 => 'schwarze-johannisbeere',
                        11 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            147 => [
                'slug' => 'u25',
                'translations' => [
                    'de' => [
                        'name' => 'U25',
                        'short_description' => '',
                        'description' => 'Eine lebhafte und strahlende Kreation, die von der Entdeckung eines Hibiskus-Feldes inspiriert ist. Der Duft eröffnet mit einer fruchtig-säuerlichen Explosion aus Granatapfel, Johannisbeere und Hibiskus, verfeinert durch einen Hauch erfrischender Minze. Die blumige Herznote der Damaszener-Rose verschmilzt mit einer süßen, warmen Basis aus Vanille, Leder und einer Prise Zimt, was für eine außergewöhnliche Komplexität und lange Haltbarkeit sorgt.',
                    ],
                    'en' => [
                        'name' => 'U25',
                        'short_description' => '',
                        'description' => 'A vibrant and radiant creation, inspired by the discovery of a hibiscus field. The fragrance opens with a fruity-tangy explosion of pomegranate, blackcurrant, and hibiscus, refined by a touch of refreshing mint. The floral heart note of Damask rose blends with a sweet, warm base of vanilla, leather, and a hint of cinnamon, providing exceptional complexity and long-lasting performance.',
                    ],
                    'ar' => [
                        'name' => 'U25',
                        'short_description' => '',
                        'description' => 'إبداع حيوي ومشرق مستوحى من اكتشاف حقل من زهور الكركديه. يفتتح العطر بانفجار فاكهي حامض من الرمان والكشمش الأسود والكركديه، مع لمسة من النعناع المنعش. يمتزج قلب العطر الزهري من الورد الدمشقي مع قاعدة حلوة ودافئة من الفانيليا والجلد ورشة من القرفة، مما يمنح هذا العطر تعقيداً استثنائياً وثباتاً طويلاً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'orientalisch',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'exklusiv',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'ambrettesamen-absolue',
                        1 => 'damaszener-rose-absolue',
                        2 => 'granatapfel',
                        3 => 'gruene-minze',
                        4 => 'hibiskus',
                        5 => 'hibiskustee',
                        6 => 'leder',
                        7 => 'schwarze-johannisbeere',
                        8 => 'vanille-absolue',
                        9 => 'vanilleorchidee',
                        10 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            148 => [
                'slug' => 'u26',
                'translations' => [
                    'de' => [
                        'name' => 'U26',
                        'short_description' => '',
                        'description' => 'Ein legendärer Unisex-Duft, der für seine minimalistische und dennoch extrem kraftvolle Komposition bekannt ist. Die perfekte Synergie aus warmem Amber, sinnlichem Moschus und süßer, cremiger Vanille schafft eine unvergleichliche Aura. Ein Duft, der Reinheit und Verführung vereint und durch seine enorme Langlebigkeit besticht.',
                    ],
                    'en' => [
                        'name' => 'U26',
                        'short_description' => '',
                        'description' => 'A legendary unisex fragrance known for its minimalist yet extremely powerful composition. The perfect synergy of warm amber, sensual musk, and sweet, creamy vanilla creates an incomparable aura. A fragrance that combines purity and seduction, distinguished by its immense longevity.',
                    ],
                    'ar' => [
                        'name' => 'U26',
                        'short_description' => '',
                        'description' => 'عطر أسطوري للجنسين يشتهر بتركيبته البسيطة والقوية في آن واحد. التناغم المثالي بين العنبر الدافئ، والمسك الحسي، والفانيليا الكريمية الحلوة يخلق هالة لا تضاهى. هو عطر يجمع بين النقاء والإغراء ويتميز بثباته الاستثنائي',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'sinnlich',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'moschus',
                        2 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            149 => [
                'slug' => 'u27',
                'translations' => [
                    'de' => [
                        'name' => 'U27',
                        'short_description' => '',
                        'description' => 'Eine dunkle, orientalische Komposition, die das florale Herz der schwarzen Rose mit der erdigen Tiefe von schwarzem Trüffel, Patschuli und Oud vereint. Ein mysteriöser und sinnlicher Duft, der durch einen Hauch von Vanille perfekt abgerundet wird.',
                    ],
                    'en' => [
                        'name' => 'U27',
                        'short_description' => '',
                        'description' => 'A dark, oriental composition that blends the floral heart of black rose with the earthy depth of black truffle, patchouli, and oud. A mysterious and sensual fragrance, perfectly rounded off by a touch of vanilla.',
                    ],
                    'ar' => [
                        'name' => 'U27',
                        'short_description' => '',
                        'description' => 'تركيبة شرقية داكنة تمزج بين قلب الورد الأسود والعمق الترابي للكمأة السوداء والباتشولي والعود. عطر غامض وحسي، تكتمل روعته بلمسة ناعمة من الفانيليا',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'dunkel',
                        1 => 'sinnlich',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'schwarze-rose',
                        1 => 'schwarzer-trueffel',
                        2 => 'patschuli',
                        3 => 'oud',
                        4 => 'vanille',
                        5 => 'eichenmoos',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            150 => [
                'slug' => 'u28',
                'translations' => [
                    'de' => [
                        'name' => 'U28',
                        'short_description' => '',
                        'description' => 'Ein hypnotischer und kühner Duft, der die berauschende Wärme von Rum und Zimt mit der tiefen Sinnlichkeit von Tabak und Vanille verbindet. Akzente von Safran und Jasmin verleihen eine florale Würze, während Sandelholz für eine cremige, holzige Basis sorgt. Ein Duft mit starkem Charakter und unverwechselbarer Präsenz.',
                    ],
                    'en' => [
                        'name' => 'U28',
                        'short_description' => '',
                        'description' => 'A hypnotic and bold fragrance that combines the intoxicating warmth of rum and cinnamon with the deep sensuality of tobacco and vanilla. Accents of saffron and jasmine provide a floral spice, while sandalwood adds a creamy, woody base. A fragrance with a strong character and unmistakable presence.',
                    ],
                    'ar' => [
                        'name' => 'U28',
                        'short_description' => '',
                        'description' => 'عطر مغناطيسي وجريء يجمع بين دفء الروم والقرفة المسكر وعمق التبغ والفانيليا الحسي. تضفي لمسات الزعفران والياسمين طابعاً زهرياً توابلياً، بينما يمنح خشب الصندل قاعدة كريمية خشبية. عطر يتمتع بشخصية قوية وحضور لا ينسى',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'intensiv',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'jasmin',
                        1 => 'rum',
                        2 => 'safran',
                        3 => 'sandelholz',
                        4 => 'tabak',
                        5 => 'vanille',
                        6 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            151 => [
                'slug' => 'u29',
                'translations' => [
                    'de' => [
                        'name' => 'U29',
                        'short_description' => '',
                        'description' => 'Eine meisterhafte Komposition, die durch ihre vielschichtige Struktur besticht. Die fruchtige Frische von Birne und die nussige Note von Haselnuss verbinden sich mit einem floralen Herz aus Jasmin, Rose und Osmanthus. Eine Basis aus kostbarem Sandelholz, Weihrauch und Vanille verleiht dem Duft eine außergewöhnliche Tiefe und elegante Langlebigkeit.',
                    ],
                    'en' => [
                        'name' => 'U29',
                        'short_description' => '',
                        'description' => 'A masterful composition that impresses with its multi-layered structure. The fruity freshness of pear and the nutty note of hazelnut blend with a floral heart of jasmine, rose, and osmanthus. A base of precious sandalwood, incense, and vanilla provides the fragrance with extraordinary depth and elegant longevity.',
                    ],
                    'ar' => [
                        'name' => 'U29',
                        'short_description' => '',
                        'description' => 'تركيبة بارعة تتميز بهيكلها متعدد الطبقات. تمتزج نضارة الكمثرى الفاكهية مع لمسة البندق في قلب زهري من الياسمين والورد والأوسمانثوس. تمنح قاعدة خشب الصندل الثمين والبخور والفانيليا العطر عمقاً استثنائياً وثباتاً أنيقاً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'raffiniert',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'birne',
                        2 => 'haselnuss',
                        3 => 'holzige-noten',
                        4 => 'jasmin-sambac',
                        5 => 'osmanthus',
                        6 => 'rose',
                        7 => 'safran',
                        8 => 'sandelholz',
                        9 => 'vanille',
                        10 => 'weihrauch',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            152 => [
                'slug' => 'u30',
                'translations' => [
                    'de' => [
                        'name' => 'U30',
                        'short_description' => '',
                        'description' => 'Ein rauer und dennoch raffinierter Duft, der die Essenz von feinem schwarzen Leder mit würzigen Nuancen von Kardamom und Safran einfängt. Jasmin-Sambac verleiht eine subtile florale Eleganz, während Vetiver, Patschuli und weißes Moos für eine erdige und langanhaltende Basis sorgen.',
                    ],
                    'en' => [
                        'name' => 'U30',
                        'short_description' => '',
                        'description' => 'A rugged yet sophisticated fragrance that captures the essence of fine black leather with spicy nuances of cardamom and saffron. Jasmine sambac adds a subtle floral elegance, while vetiver, patchouli, and white moss provide an earthy and long-lasting base.',
                    ],
                    'ar' => [
                        'name' => 'U30',
                        'short_description' => '',
                        'description' => 'عطر خشن ومع ذلك متطور، يجسد جوهر الجلد الأسود الفاخر مع لمسات توابلية من الهيل والزعفران. يضيف ياسمين سامباك أناقة زهرية خفيفة، بينما يوفر نجيل الهند والباتشولي والطحالب البيضاء قاعدة ترابية ذات ثبات عالٍ',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'ledrig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'maskulin',
                        1 => 'dunkel',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'jasmin-sambac',
                        2 => 'kardamom',
                        3 => 'patchouli',
                        4 => 'safran',
                        5 => 'schwarzes-leder',
                        6 => 'vetiver',
                        7 => 'weisses-moos',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            153 => [
                'slug' => 'u31',
                'translations' => [
                    'de' => [
                        'name' => 'U31',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse und minimalistische Komposition, die durch den intensiven Kontrast zwischen spritziger Grapefruit und tiefem, warmem Ambra besticht. Akzente von würzigem Ingwer und edlen Hölzern verleihen dem Duft eine außergewöhnliche Eleganz und eine beeindruckende, maskuline Präsenz.',
                    ],
                    'en' => [
                        'name' => 'U31',
                        'short_description' => '',
                        'description' => 'A luxurious and minimalist composition, distinguished by the intense contrast between tangy grapefruit and deep, warm amber. Accents of spicy ginger and precious woods give the fragrance extraordinary elegance and an impressive, masculine presence.',
                    ],
                    'ar' => [
                        'name' => 'U31',
                        'short_description' => '',
                        'description' => 'تركيبة فاخرة ومختصرة تتميز بالتباين المكثف بين الجريب فروت المنعش والعنبر الدافئ العميق. تضفي لمسات الزنجبيل الحار والأخشاب الثمينة على العطر أناقة استثنائية وحضوراً ذكورياً مهيباً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'exklusiv',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'ambra',
                        1 => 'grapefruit',
                        2 => 'holzige-noten',
                        3 => 'ingwer',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            154 => [
                'slug' => 'u32',
                'translations' => [
                    'de' => [
                        'name' => 'U32',
                        'short_description' => '',
                        'description' => 'Eine luxuriöse und betörende Kreation, die die Tiefe von Oud mit der süßen Verführung von Schokolade, Praline und Vanille verbindet. Diese opulente Duftreise wird durch würzige Akzente von Rum und Zimt sowie eine florale Herznote abgerundet, was zu einer unvergleichlich reichhaltigen und verführerischen Signatur führt.',
                    ],
                    'en' => [
                        'name' => 'U32',
                        'short_description' => '',
                        'description' => 'A luxurious and bewitching creation that combines the depth of oud with the sweet temptation of chocolate, praline, and vanilla. This opulent fragrance journey is rounded off by spicy accents of rum and cinnamon as well as a floral heart note, resulting in an incomparably rich and seductive signature.',
                    ],
                    'ar' => [
                        'name' => 'U32',
                        'short_description' => '',
                        'description' => 'ابتكار فاخر وآسر يجمع بين عمق العود وإغراء الشوكولاتة والبرالين والفانيليا. تكتمل هذه الرحلة العطرية المترفة بلمسات توابلية من الروم والقرفة وقلب زهري، مما ينتج عنه توقيع عطري غني ومغرٍ لا يضاهى',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'designer',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'luxurioes',
                        2 => 'warm',
                    ],
                    'noten' => [
                        0 => 'gewuerzter-rum',
                        1 => 'iriswurzel',
                        2 => 'jasmin',
                        3 => 'kakao',
                        4 => 'kandierter-apfel',
                        5 => 'kaschmirholz',
                        6 => 'mate',
                        7 => 'moschus',
                        8 => 'oud',
                        9 => 'praline',
                        10 => 'sandelholz',
                        11 => 'schokolade',
                        12 => 'tonkabohne',
                        13 => 'vanille',
                        14 => 'weihrauch',
                        15 => 'zimt',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    1 => [
                        'size_ml' => 100,
                        'price' => '35.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            155 => [
                'slug' => 'u33',
                'translations' => [
                    'de' => [
                        'name' => 'U33',
                        'short_description' => '',
                        'description' => 'Ein olfaktorisches Porträt des Segelsports und des Lebens auf dem offenen Meer. Dieser Duft fängt die Essenz der salzigen Meeresbrise und des Holzes von Segelbooten perfekt ein. Eine elegante, mineralische Komposition, die durch ihre Tiefe und ihre exklusive, beinahe süchtig machende Frische besticht.',
                    ],
                    'en' => [
                        'name' => 'U33',
                        'short_description' => '',
                        'description' => 'An olfactory portrait of sailing and life on the open sea. This fragrance perfectly captures the essence of salty sea breeze and the wood of sailboats. An elegant, mineral composition that stands out for its depth and its exclusive, almost addictive freshness.',
                    ],
                    'ar' => [
                        'name' => 'U33',
                        'short_description' => '',
                        'description' => 'تجسيد عطري لرياضة الإبحار والحياة في عرض البحر. يلتقط هذا العطر جوهر نسيم البحر المالح وخشب قوارب الشراع بدقة. تركيبة معدنية أنيقة تتميز بعمقها وانتعاشها الحصري الذي يكاد يكون مسبباً للإدمان',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'elegant',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'meerwasser',
                        1 => 'salz',
                        2 => 'gruene-noten',
                        3 => 'holzige-noten',
                        4 => 'zeder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            156 => [
                'slug' => 'u34',
                'translations' => [
                    'de' => [
                        'name' => 'U34',
                        'short_description' => '',
                        'description' => 'Ein olfaktorisches Abbild eines perfekten Strandtages. Die strahlende Frische der japanischen Yuzu und die blumige Zartheit von tunesischem Neroli werden durch aromatische Kräuter wie Rosmarin und Thymian ergänzt. Ein Hauch von Rosa Pfeffer und Gewürznelke verleiht dem Duft eine dynamische Tiefe, während die Zypresse an die salzige Brise und die küstennahe Vegetation erinnert. Ein sommerlicher und energiegeladener Duft.',
                    ],
                    'en' => [
                        'name' => 'U34',
                        'short_description' => '',
                        'description' => 'An olfactory portrait of a perfect day at the beach. The radiant freshness of Japanese yuzu and the floral delicacy of Tunisian neroli are complemented by aromatic herbs such as rosemary and thyme. A hint of pink pepper and clove adds dynamic depth, while the cypress evokes the salty breeze and coastal vegetation. A summery and energetic fragrance.',
                    ],
                    'ar' => [
                        'name' => 'U34',
                        'short_description' => '',
                        'description' => 'تجسيد عطري ليوم مثالي على الشاطئ. تكمل نضارة فاكهة اليوزو اليابانية ورقة زهر البرتقال التونسي بالأعشاب العطرية مثل إكليل الجبل والزعتر. تضفي لمسات الفلفل الوردي والقرنفل عمقاً ديناميكياً، بينما يذكرنا السرو بنسيم البحر المالح ونباتات السواحل. عطر صيفي مليء بالطاقة والحيوية',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'aquatisch',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'japanische-yuzu',
                        1 => 'tunesisches-neroli',
                        2 => 'rosmarin',
                        3 => 'thymian',
                        4 => 'rosa-pfeffer',
                        5 => 'gewuerznelke',
                        6 => 'zypresse',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            157 => [
                'slug' => 'u35',
                'translations' => [
                    'de' => [
                        'name' => 'U35',
                        'short_description' => '',
                        'description' => 'Ein Duft, der das Gefühl eines „Detox“-Moments an der kalifornischen Küste einfängt. Die saftige Süße von schwarzer Johannisbeere, Aprikose und Datteln trifft auf die belebende Kühle von Minze, Basilikum und Zitronatzitrone. Ein moderner, strahlender Duft, der die Seele baumeln lässt und pure Lebensfreude versprüht.',
                    ],
                    'en' => [
                        'name' => 'U35',
                        'short_description' => '',
                        'description' => 'A fragrance that captures the feeling of a "detox" moment on the California coast. The juicy sweetness of blackcurrant, apricot, and dates meets the invigorating coolness of mint, basil, and cedrat. A modern, radiant fragrance that lets the soul unwind and exudes pure joie de vivre.',
                    ],
                    'ar' => [
                        'name' => 'U35',
                        'short_description' => '',
                        'description' => 'عطر يجسد لحظات الاستجمام والهدوء على ساحل كاليفورنيا. يلتقي الحلاوة الغنية للكشمش الأسود والمشمش والتمور مع الانتعاش المفعم بالحيوية للنعناع والريحان والليمون (السيدرات). عطر عصري ومشرق يبعث على الاسترخاء ويشع بحيوية لا مثيل لها',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'aquatisch',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'ambrettesamen',
                        1 => 'aprikose',
                        2 => 'basilikum',
                        3 => 'dattel',
                        4 => 'feige',
                        5 => 'koriandersamen',
                        6 => 'mairose',
                        7 => 'moehrensamen',
                        8 => 'orange',
                        9 => 'pfefferminze',
                        10 => 'schwarze-johannisbeere',
                        11 => 'zitronatzitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            158 => [
                'slug' => 'u36',
                'translations' => [
                    'de' => [
                        'name' => 'U36',
                        'short_description' => '',
                        'description' => 'Eine sonnendurchflutete Kreation, die wie ein Sprung in das kühle Nass an einem heißen Nachmittag wirkt. Der Duft besticht durch seine explosive Zitrus-Frische, angeführt von einer hochwertigen sizilianischen Orange, die durch die würzige Wärme von Ingwer eine unerwartete Dynamik erhält. Die Basis aus sanftem Ambra verleiht dem Duft eine angenehme Wärme und Tiefe, ohne die federleichte Frische zu beschweren.',
                    ],
                    'en' => [
                        'name' => 'U36',
                        'short_description' => '',
                        'description' => 'A sun-drenched creation that feels like a jump into cool water on a hot afternoon. The fragrance captivates with its explosive citrus freshness, led by high-quality Sicilian orange, which gains unexpected dynamic through the spicy warmth of ginger. The base of soft amber adds pleasant warmth and depth without weighing down the feather-light freshness.',
                    ],
                    'ar' => [
                        'name' => 'U36',
                        'short_description' => '',
                        'description' => 'ابتكار مشمس يمنحك شعور الغطس في مياه باردة في ظهيرة يوم صيفي حار. يتميز العطر بنضارته الحمضية المتفجرة، بقيادة البرتقال الصقلي الفاخر، الذي يكتسب ديناميكية غير متوقعة من دفء الزنجبيل الحار. تمنح قاعدة العنبر الناعمة العطر دفئاً وعمقاً مريحاً دون أن تؤثر على خفته وانتعاشه',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'aquatisch',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'sauber',
                    ],
                    'noten' => [
                        0 => 'sizilianische-orange',
                        1 => 'bergamotte',
                        2 => 'mandarine',
                        3 => 'ingwer',
                        4 => 'ambra',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            159 => [
                'slug' => 'u37',
                'translations' => [
                    'de' => [
                        'name' => 'U37',
                        'short_description' => '',
                        'description' => 'Eine warme und geheimnisvolle Komposition, die edlen Tabak und würzigen Zimt mit einem Hauch von frischem Apfel vereint, abgerundet durch eine cremige, samtige Basis, die die Sinne fesselt.',
                    ],
                    'en' => [
                        'name' => 'U37',
                        'short_description' => '',
                        'description' => 'A warm and mysterious blend combining noble tobacco and spicy cinnamon with a hint of fresh apple, settled on a creamy, velvety base that captivates the senses.',
                    ],
                    'ar' => [
                        'name' => 'U37',
                        'short_description' => '',
                        'description' => 'توليفة دافئة وغامضة تجمع بين عبق التبغ الفاخر ونكهة القرفة الشهية مع لمسات من التفاح المنعش، لتستقر في قاعدة كريمية مخملية تأسر الحواس',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'warm',
                        1 => 'intensiv',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'tabak',
                        1 => 'zimt',
                        2 => 'apfel',
                        3 => 'vanille',
                        4 => 'eichenmoos',
                        5 => 'moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            160 => [
                'slug' => 'u38',
                'translations' => [
                    'de' => [
                        'name' => 'U38',
                        'short_description' => '',
                        'description' => 'Eine erfrischende Explosion aus Zitrusfrüchten, gepaart mit warmen Gewürzen und saftigen Früchten, die auf einer holzigen Ambra-Basis für ein modernes und luxuriöses Gefühl sorgt.',
                    ],
                    'en' => [
                        'name' => 'U38',
                        'short_description' => '',
                        'description' => 'A refreshing explosion of citrus blended with warm spices and succulent fruits, settling on a woody amber base that provides a modern and luxurious sensation.',
                    ],
                    'ar' => [
                        'name' => 'U38',
                        'short_description' => '',
                        'description' => 'انفجار منعش من الحمضيات الممزوجة بالتوابل الدافئة والفواكه اللذيذة، يستقر على قاعدة خشبية وعنبرية تمنحك إحساساً عصرياً وفخماً',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'frisch',
                        1 => 'modern',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'zitrone',
                        1 => 'amber',
                        2 => 'bourbon-vanille',
                        3 => 'orange',
                        4 => 'gewuerznelke',
                        5 => 'apfel',
                        6 => 'kardamom',
                        7 => 'hoelzer',
                        8 => 'ingwer',
                        9 => 'bergamotte',
                        10 => 'zimt',
                        11 => 'melone',
                        12 => 'moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            161 => [
                'slug' => 'u39',
                'translations' => [
                    'de' => [
                        'name' => 'U39',
                        'short_description' => '',
                        'description' => 'Ein samtiges Dufterlebnis, das die Zartheit der Tuberose mit der Sanftheit von Mandelmilch und einer bezaubernden Moschus-Note verbindet, die absolute Eleganz widerspiegelt.',
                    ],
                    'en' => [
                        'name' => 'U39',
                        'short_description' => '',
                        'description' => 'A velvety fragrant experience that combines the delicacy of tuberose with the softness of almond milk and a charming touch of musk, reflecting absolute elegance.',
                    ],
                    'ar' => [
                        'name' => 'U39',
                        'short_description' => '',
                        'description' => 'تجربة عطرية مخملية تجمع بين دلال زهرة التيوبروز ونعومة حليب اللوز بلمسة مسكية ساحرة تعكس الأناقة المطلقة.',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'gourmand',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'elegant',
                    ],
                    'noten' => [
                        0 => 'ambrettesamen',
                        1 => 'freesie',
                        2 => 'iris',
                        3 => 'mandelmilch',
                        4 => 'moschus',
                        5 => 'tonkabohne',
                        6 => 'tuberose',
                        7 => 'vanille',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            162 => [
                'slug' => 'u40',
                'translations' => [
                    'de' => [
                        'name' => 'U40',
                        'short_description' => '',
                        'description' => 'Eine kühne Komposition, die die Süße tropischer Mango mit der Schärfe von Gewürzen und der Tiefe von Oud verbindet und so ein einzigartiges Gleichgewicht zwischen Frische und orientalischer Mystik schafft.',
                    ],
                    'en' => [
                        'name' => 'U40',
                        'short_description' => '',
                        'description' => 'A bold composition that blends the sweetness of tropical mango with spicy sharpness and the depth of oud, creating a unique balance between freshness and oriental mystery.',
                    ],
                    'ar' => [
                        'name' => 'U40',
                        'short_description' => '',
                        'description' => 'توليفة جريئة تدمج حلاوة المانجو الاستوائية مع حدة التوابل وعمق العود، لتخلق توازناً فريداً بين الانتعاش والغموض الشرقي',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'charismatisch',
                        2 => 'anziehend',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'ingwer',
                        2 => 'jasmin',
                        3 => 'mango',
                        4 => 'moschus',
                        5 => 'nagarmotha',
                        6 => 'oud',
                        7 => 'rosa-pfeffer',
                        8 => 'tonkabohne',
                        9 => 'hoelzer',
                        10 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            163 => [
                'slug' => 'u41',
                'translations' => [
                    'de' => [
                        'name' => 'U41',
                        'short_description' => '',
                        'description' => 'Eine raffinierte Mischung aus luxuriösem Safran und der Zartheit von Jasmin, abgerundet durch eine warme holzige Basis, die dem Duft Langlebigkeit und moderne Ausstrahlung verleiht.',
                    ],
                    'en' => [
                        'name' => 'U41',
                        'short_description' => '',
                        'description' => 'A sophisticated blend combining the luxury of saffron and the delicacy of jasmine, with a warm woody base that gives the fragrance longevity and a modern radiance.',
                    ],
                    'ar' => [
                        'name' => 'U41',
                        'short_description' => '',
                        'description' => 'مزيج متطور يجمع بين فخامة الزعفران ونعومة الياسمين، مع قاعدة خشبية دافئة تمنح العطر ثباتاً وإشراقاً عصرياً.',
                    ],
                ],
                'categories' => [
                    0 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'nische',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'elegant',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'ambroxan',
                        1 => 'jasmin',
                        2 => 'safran',
                        3 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 30,
                        'price' => '20.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                    1 => [
                        'size_ml' => 50,
                        'price' => '30.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                    2 => [
                        'size_ml' => 100,
                        'price' => '50.00',
                        'compare_at_price' => null,
                        'is_default' => false,
                    ],
                ],
            ],
            164 => [
                'slug' => 'lu1',
                'translations' => [
                    'de' => [
                        'name' => 'LU1',
                        'short_description' => '',
                        'description' => 'Ein berauschendes Meisterwerk! Die luxuriöse Wärme von Amber und edlem Tabak verschmilzt mit einer Explosion aus exotischen Früchten und betörenden Blüten zu einem unvergesslichen, opulenten Erlebnis.',
                    ],
                    'en' => [
                        'name' => 'LU1',
                        'short_description' => '',
                        'description' => 'A breathtaking masterpiece! The luxurious warmth of amber and refined tobacco merges with an explosion of exotic fruits and intoxicating florals to create an unforgettable, opulent experience.',
                    ],
                    'ar' => [
                        'name' => 'LU1',
                        'short_description' => '',
                        'description' => 'تحفة فنية تخطف الأنفاس! يمتزج فيها دفء العنبر الفاخر والتبغ النبيل مع انفجار من الفواكه الغريبة والزهور الساحرة، لتمنحك تجربة عطرية غنية وفخمة لا تُنسى',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'luxurioes',
                        2 => 'intensiv',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bitterorange',
                        2 => 'getrocknete-fruechte',
                        3 => 'heller-tabak',
                        4 => 'jasmin',
                        5 => 'tonkabohne',
                        6 => 'tuberose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            165 => [
                'slug' => 'lu2',
                'translations' => [
                    'de' => [
                        'name' => 'LU2',
                        'short_description' => '',
                        'description' => 'Ein olfaktorisches Manifest purer Extravaganz! Die meisterhafte Harmonie aus kostbarem Oud, edlen Harzen und seltenen Gewürzen kreiert eine monumentale Präsenz, die den Träger in einen Mantel aus exklusiver, zeitloser Noblesse hüllt.',
                    ],
                    'en' => [
                        'name' => 'LU2',
                        'short_description' => '',
                        'description' => 'An olfactory manifesto of pure extravagance! The masterful harmony of precious oud, noble resins, and rare spices creates a monumental presence, enveloping the wearer in a cloak of exclusive, timeless nobility.',
                    ],
                    'ar' => [
                        'name' => 'LU2',
                        'short_description' => '',
                        'description' => 'بيان عطري يجسد الفخامة المطلقة! التناغم المتقن بين العود النادر والراتنجات الملكية والتوابل النفيسة يخلق حضوراً مهيباً، يغمرك بوشاح من الرقي الاستثنائي الذي لا يزول مع الزمن',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'wuerzig',
                    ],
                    'stimmung' => [
                        0 => 'charismatisch',
                        1 => 'dunkel',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'ambra',
                        2 => 'anis',
                        3 => 'benzoe',
                        4 => 'bergamotte',
                        5 => 'birke',
                        6 => 'davana',
                        7 => 'elemiharz',
                        8 => 'kardamom',
                        9 => 'koriander',
                        10 => 'kuemmel',
                        11 => 'labdanum',
                        12 => 'moschus',
                        13 => 'opoponax',
                        14 => 'orangenbluete',
                        15 => 'oud',
                        16 => 'patchouli',
                        17 => 'rose',
                        18 => 'rosengeranie',
                        19 => 'safran',
                        20 => 'szechuanpfeffer',
                        21 => 'vanille',
                        22 => 'weihrauch',
                        23 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            166 => [
                'slug' => 'lu3',
                'translations' => [
                    'de' => [
                        'name' => 'LU3',
                        'short_description' => '',
                        'description' => 'Eine tiefgründige, hypnotische Kreation aus seltenen Hölzern, feinstem Wildleder und würzigem Weihrauch – ein Duft, der Stille und monumentale Eleganz in einer luxuriösen Aura vereint.',
                    ],
                    'en' => [
                        'name' => 'LU3',
                        'short_description' => '',
                        'description' => 'A profound, hypnotic creation of rare woods, finest suede, and spicy incense – a scent that unites silence and monumental elegance in a luxurious aura.',
                    ],
                    'ar' => [
                        'name' => 'LU3',
                        'short_description' => '',
                        'description' => 'إبداع عميق ومغناطيسي يجمع بين الأخشاب النادرة والجلود الفاخرة والبخور التابلي – عطر يدمج بين السكينة والأناقة المهيبة في هالة من الفخامة المطلقة',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'ledrig',
                    ],
                    'stimmung' => [
                        0 => 'professionell',
                        1 => 'raffiniert',
                        2 => 'selbstbewusst',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'holzige-noten',
                        2 => 'papyrus',
                        3 => 'piment',
                        4 => 'rosa-pfeffer',
                        5 => 'rose',
                        6 => 'safran',
                        7 => 'sandelholz',
                        8 => 'vanille',
                        9 => 'vetiver',
                        10 => 'weihrauch',
                        11 => 'wildleder',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            167 => [
                'slug' => 'lu4',
                'translations' => [
                    'de' => [
                        'name' => 'LU4',
                        'short_description' => '',
                        'description' => 'Ein berauschendes, süßes Elixier, das die strahlende Reinheit von Orangenblüten mit der dunklen Tiefe von Honig und Weihrauch verbindet – ein leidenschaftliches Bekenntnis in flüssiger Form.',
                    ],
                    'en' => [
                        'name' => 'LU4',
                        'short_description' => '',
                        'description' => 'An intoxicating, sweet elixir that combines the radiant purity of orange blossoms with the dark depth of honey and incense – a passionate confession in liquid form.',
                    ],
                    'ar' => [
                        'name' => 'LU4',
                        'short_description' => '',
                        'description' => 'إكسير مسكر يجمع بين نقاء زهر البرتقال المتألق والعمق الداكن للعسل والبخور، ليقدم عطراً يحاكي قصيدة غرامية عاطفية في أبهى صورها',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'bourbon-vanille-absolue',
                        1 => 'eichenmoos',
                        2 => 'jasmin',
                        3 => 'labdanum',
                        4 => 'orangenbluete',
                        5 => 'provenzalischer-honig-absolue',
                        6 => 'somalischer-weihrauch',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            168 => [
                'slug' => 'lu5',
                'translations' => [
                    'de' => [
                        'name' => 'LU5',
                        'short_description' => '',
                        'description' => 'Eine kristallklare und zugleich sinnliche Komposition, in der die Reinheit des Moschus mit der zarten Sinnlichkeit von Rose und Jasmin zu einer unvergesslichen, eleganten Aura verschmilzt.',
                    ],
                    'en' => [
                        'name' => 'LU5',
                        'short_description' => '',
                        'description' => 'A crystal-clear yet sensual composition, where the purity of musk merges with the delicate sensuality of rose and jasmine into an unforgettable, elegant aura.',
                    ],
                    'ar' => [
                        'name' => 'LU5',
                        'short_description' => '',
                        'description' => 'تركيبة نقية وشفافة تنبض بالجاذبية، حيث يمتزج نقاء المسك مع الرقة الحسية لزهور الورد والياسمين لتشكل هالة عطرية أنيقة لا تُنسى',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'blumig',
                        1 => 'pudrig',
                    ],
                    'stimmung' => [
                        0 => 'sauber',
                        1 => 'elegant',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'jasmin',
                        2 => 'moschus',
                        3 => 'rose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            169 => [
                'slug' => 'lu6',
                'translations' => [
                    'de' => [
                        'name' => 'LU6',
                        'short_description' => '',
                        'description' => 'Ein süchtig machendes Meisterwerk der Verführung! Die spritzige Frische der Zitrone weicht sofort einer sinnlichen Welle aus cremigem Rosenlokum und luxuriöser Vanille – ein Duft, der eine unwiderstehliche, pudrige Spur voller Eleganz hinterlässt.',
                    ],
                    'en' => [
                        'name' => 'LU6',
                        'short_description' => '',
                        'description' => 'An addictive masterpiece of seduction! The zesty freshness of lemon immediately gives way to a sensual wave of creamy Turkish delight and luxurious vanilla—a scent that leaves an irresistible, powdery trail full of elegance.',
                    ],
                    'ar' => [
                        'name' => 'LU6',
                        'short_description' => '',
                        'description' => 'تحفة فنية تخطف الحواس وتدمن عليها! تذوب حمضية الليمون المنعشة فوراً في موجة حسية من حلوى "اللوكوم" (حلوى الورد التركية) الكريمية وفانيليا البوربون الفاخرة، لتترك خلفك أثراً بودرياً ساحراً يفيض بالأناقة',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'luxurioes',
                    ],
                    'noten' => [
                        0 => 'kalabrische-zitrone',
                        1 => 'rosenlokum',
                        2 => 'vanille',
                        3 => 'weisser-moschus',
                        4 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            170 => [
                'slug' => 'lu7',
                'translations' => [
                    'de' => [
                        'name' => 'LU7',
                        'short_description' => '',
                        'description' => 'Ein Duft wie ein süßer, verträumter Kuss. Die strahlende Frische von Orangenblüten und Neroli verschmilzt mit einer unwiderstehlichen Marshmallow-Note zu einer Komposition, die Unschuld und verführerische Tiefe perfekt vereint.',
                    ],
                    'en' => [
                        'name' => 'LU7',
                        'short_description' => '',
                        'description' => 'A scent like a sweet, dreamy kiss. The radiant freshness of orange blossom and neroli merges with an irresistible marshmallow note to create a composition that perfectly balances innocence and seductive depth.',
                    ],
                    'ar' => [
                        'name' => 'LU7',
                        'short_description' => '',
                        'description' => 'عطر يشبه القبلة الحالمة. تندمج نضارة زهر البرتقال والنيرولي مع لمسة لا تقاوم من المارشميلو، لتشكل تركيبة تجمع بين البراءة والعمق الجذاب في توازن مثالي.',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'jugendlich',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'geissblatt',
                        2 => 'marshmallow',
                        3 => 'neroli',
                        4 => 'orangenbluete-absolue',
                        5 => 'rose',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            171 => [
                'slug' => 'lu8',
                'translations' => [
                    'de' => [
                        'name' => 'LU8',
                        'short_description' => '',
                        'description' => 'Eine olfaktorische Hommage an die italienische Konditorkunst! Cremiges Karamell verschmilzt mit würzigem Zimt und spritzigen Zitrusfrüchten zu einem Duft, der wie eine luxuriöse Zitronen-Vanille-Tarte duftet – absolut unwiderstehlich und elegant.',
                    ],
                    'en' => [
                        'name' => 'LU8',
                        'short_description' => '',
                        'description' => 'An olfactory homage to Italian confectionery! Creamy caramel merges with spicy cinnamon and zesty citrus to create a scent that smells like a luxurious lemon-vanilla tart—absolutely irresistible and elegant.',
                    ],
                    'ar' => [
                        'name' => 'LU8',
                        'short_description' => '',
                        'description' => 'تكريم عطري لفن الحلويات الإيطالية! يمتزج الكراميل الكريمي مع القرفة الدافئة والحمضيات المتألقة ليخلق رائحة تشبه "تارت الليمون بالفانيليا" الفاخرة؛ عطر لا يُقاوم يفيض بالأناقة واللذة',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'damenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'gourmand',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'blutorange',
                        1 => 'bergamotte',
                        2 => 'lavendel',
                        3 => 'zimt',
                        4 => 'suessholz',
                        5 => 'jasmin',
                        6 => 'bulgarische-rose',
                        7 => 'vanille',
                        8 => 'moschus',
                        9 => 'karamell',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            172 => [
                'slug' => 'lu9',
                'translations' => [
                    'de' => [
                        'name' => 'LU9',
                        'short_description' => '',
                        'description' => 'Ein flüssiges Meisterwerk, das sich wie Seide auf die Haut legt. Die opulente Kombination aus intensiven Rosen, edlem Oud und einer warmen, fast essbaren Vanille-Benzoe-Note schafft eine Aura, die zeitlos, tief und absolut berauschend ist.',
                    ],
                    'en' => [
                        'name' => 'LU9',
                        'short_description' => '',
                        'description' => 'A liquid masterpiece that drapes over the skin like silk. The opulent combination of intense roses, precious Oud, and a warm, almost edible vanilla-benzoin note creates an aura that is timeless, deep, and absolutely intoxicating.',
                    ],
                    'ar' => [
                        'name' => 'LU9',
                        'short_description' => '',
                        'description' => 'تحفة فنية سائلة تلامس البشرة بنعومة الحرير. المزيج الفاخر بين كثافة الورد والعود النبيل مع لمسة دافئة تقترب من روائح "الغورماند" للفانيليا والبنزوين، يخلق هالة عطرية خالدة، عميقة، وآسرة للغاية',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'blumig',
                    ],
                    'stimmung' => [
                        0 => 'luxurioes',
                        1 => 'intensiv',
                        2 => 'unvergesslich',
                    ],
                    'noten' => [
                        0 => 'bulgarische-damaszener-rose-tuerkische-damaszener-rose-absolue-laotisches-oud-vanille-siam-benzoe-veilchen-amber',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            173 => [
                'slug' => 'lu10',
                'translations' => [
                    'de' => [
                        'name' => 'LU10',
                        'short_description' => '',
                        'description' => 'Ein sonniges, lebensfrohes Statement! Die spritzige Lebendigkeit von Orange und Bergamotte entfaltet sich in einem üppigen Blütenmeer, während eine sanfte, holzige Basis und Moschus dem Duft eine lang anhaltende, fast hautnahe Eleganz verleihen.',
                    ],
                    'en' => [
                        'name' => 'LU10',
                        'short_description' => '',
                        'description' => 'A sunny, vibrant statement! The zesty liveliness of orange and bergamot unfolds in a lush sea of blossoms, while a soft, woody base and musk give the scent a long-lasting, skin-hugging elegance.',
                    ],
                    'ar' => [
                        'name' => 'LU10',
                        'short_description' => '',
                        'description' => 'إعلان عطري مشمس ومفعم بالحيوية! تتفتح نضارة البرتقال والبرغموت في بحر من الزهور الغنية، بينما تضفي القاعدة الخشبية الناعمة مع المسك لمسة من الأناقة المستمرة التي تلازم البشرة برقي',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'fruchtig',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'modern',
                        1 => 'sauber',
                        2 => 'frisch',
                    ],
                    'noten' => [
                        0 => 'duftnoten-bergamotte',
                        1 => 'gewuerznelke',
                        2 => 'holzige-noten',
                        3 => 'jasmin',
                        4 => 'maigloeckchen',
                        5 => 'moschus',
                        6 => 'orange',
                        7 => 'orangenbluete',
                        8 => 'rose',
                        9 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            174 => [
                'slug' => 'lu11',
                'translations' => [
                    'de' => [
                        'name' => 'LU11',
                        'short_description' => '',
                        'description' => 'Eine komplexe und luxuriöse Komposition, die die moderne Eleganz der britischen Metropole widerspiegelt. Die fruchtige Süße der Himbeere trifft auf die raue Tiefe von Leder und Oud, während florale Akzente für eine unerwartete, pudrige Weichheit sorgen. Ein urbaner, hochmoderner Duft mit außergewöhnlicher Ausstrahlung.',
                    ],
                    'en' => [
                        'name' => 'LU11',
                        'short_description' => '',
                        'description' => 'A complex and luxurious composition reflecting the modern elegance of the British capital. The fruity sweetness of raspberry meets the raw depth of leather and oud, while floral accents provide an unexpected, powdery softness. An urban, ultra-modern scent with exceptional charisma.',
                    ],
                    'ar' => [
                        'name' => 'LU11',
                        'short_description' => '',
                        'description' => 'تركيبة معقدة وفاخرة تعكس الأناقة العصرية للعاصمة البريطانية. تمتزج حلاوة التوت البري مع العمق الخام للجلد والعود، بينما تضفي اللمسات الزهرية نعومة بودرية غير متوقعة. عطر حضري متطور للغاية يتمتع بهالة عطرية استثنائية',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'herrenparfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'wuerzig',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'charismatisch',
                        1 => 'maskulin',
                        2 => 'klassisch',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'himbeere',
                        2 => 'leder',
                        3 => 'maigloeckchen',
                        4 => 'moschus',
                        5 => 'oud',
                        6 => 'vanille',
                        7 => 'veilchen',
                        8 => 'zypresse',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            175 => [
                'slug' => 'lu12',
                'translations' => [
                    'de' => [
                        'name' => 'LU12',
                        'short_description' => '',
                        'description' => 'Dieser Duft verkörpert die Essenz des Hedonismus. Er verbindet meisterhaft die Süße der Schwarzkirsche mit der Tiefe von Tabak und Leder und schafft so ein geheimnisvolles und äußerst verführerisches Dufterlebnis.',
                    ],
                    'en' => [
                        'name' => 'LU12',
                        'short_description' => '',
                        'description' => 'This fragrance embodies the essence of hedonism. It masterfully blends the sweetness of black cherry with the depth of tobacco and leather, creating a mysterious and highly seductive olfactory experience.',
                    ],
                    'ar' => [
                        'name' => 'LU12',
                        'short_description' => '',
                        'description' => 'يجسد هذا العطر جوهر "الهدونيزم" أو مذهب اللذة. يمزج ببراعة بين حلاوة الكرز الأسود وعمق التبغ والجلود، مما يخلق تجربة عطرية غامضة ومغرية للغاية.',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'orientalisch',
                        1 => 'fruchtig',
                    ],
                    'stimmung' => [
                        0 => 'sinnlich',
                        1 => 'anziehend',
                        2 => 'exklusiv',
                    ],
                    'noten' => [
                        0 => 'amber',
                        1 => 'bergamotte',
                        2 => 'grapefruit',
                        3 => 'iris',
                        4 => 'jasmin',
                        5 => 'kakaoblatt',
                        6 => 'labdanum',
                        7 => 'leder',
                        8 => 'mate',
                        9 => 'muskatellersalbei',
                        10 => 'neroli',
                        11 => 'opium',
                        12 => 'papyrus',
                        13 => 'schwarzkirsche',
                        14 => 'tabak',
                        15 => 'tonkabohne',
                        16 => 'vanille',
                        17 => 'wermutkraut',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            176 => [
                'slug' => 'lu13',
                'translations' => [
                    'de' => [
                        'name' => 'LU13',
                        'short_description' => '',
                        'description' => 'Ein beruhigendes Dufterlebnis, das ein Gefühl von Luxus und Gelassenheit vermittelt. Die Frische von Zitrusfrüchten verschmilzt mit der Sanftheit der Magnolie und der Lebendigkeit der schwarzen Johannisbeere, eingehüllt in eine samtige Aura aus weißem Moschus und indischem Sandelholz. Ein Duft, der pure Entspannung und vollendete Eleganz verkörpert.',
                    ],
                    'en' => [
                        'name' => 'LU13',
                        'short_description' => '',
                        'description' => 'A soothing olfactory experience that evokes a sense of luxury and serenity. The freshness of citrus blends with the softness of magnolia and the vibrancy of blackcurrant, enveloped in a velvety aura of white musk and Indian sandalwood. A fragrance that embodies well-being and ultimate elegance.',
                    ],
                    'ar' => [
                        'name' => 'LU13',
                        'short_description' => '',
                        'description' => 'تجربة عطرية مهدئة تمنح شعوراً بالرفاهية والسكينة، حيث يمتزج انتعاش الحمضيات مع نعومة الماغنوليا وحيوية الكشمش الأسود، لتغلفها هالة مخملية من المسك الأبيض والصندل الهندي. عطر يجسد الراحة النفسية والأناقة المطلقة',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'holzig',
                        1 => 'zitrisch',
                    ],
                    'stimmung' => [
                        0 => 'sauber',
                        1 => 'frisch',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'bergamotte',
                        1 => 'indisches-sandelholz',
                        2 => 'magnolie',
                        3 => 'mandarine',
                        4 => 'rosa-moschus',
                        5 => 'schwarze-johannisbeere',
                        6 => 'weisser-moschus',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            177 => [
                'slug' => 'lu14',
                'translations' => [
                    'de' => [
                        'name' => 'LU14',
                        'short_description' => '',
                        'description' => 'Der Duft eröffnet mit einem lebendigen und erfrischenden Impuls, der die Kühle von Minze mit aromatischen Kräutern vereint und sofort ein Gefühl von Energie und Vitalität vermittelt. Das Herz entfaltet sich mit subtilen floralen Noten, während die Basis auf sanftem Moschus ruht, was dem Duft einen Hauch von moderner Eleganz und sommerlicher Exzellenz verleiht.',
                    ],
                    'en' => [
                        'name' => 'LU14',
                        'short_description' => '',
                        'description' => 'The fragrance opens with a vibrant and refreshing pulse, combining the coolness of mint with aromatic herbs to provide an immediate sensation of energy and vitality. The heart evolves with subtle floral touches, while the base settles into soft musky notes that add a touch of modern elegance and summer excellence.',
                    ],
                    'ar' => [
                        'name' => 'LU14',
                        'short_description' => '',
                        'description' => 'يفتتح العطر بنبض حيوي ومنعش يجمع بين انتعاش النعناع وعبق الأعشاب العطرية، مما يمنح إحساساً فورياً بالطاقة والنشاط. يتطور القلب العطري بلمسات زهرية خفيفة لتستقر القاعدة على نفحات مسكية ناعمة تضفي لمسة من الأناقة العصرية والتميز الصيفي.',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'zitrisch',
                        1 => 'aromatisch',
                    ],
                    'stimmung' => [
                        0 => 'sportlich',
                        1 => 'frisch',
                        2 => 'modern',
                    ],
                    'noten' => [
                        0 => 'basilikum',
                        1 => 'eisenkraut',
                        2 => 'jasmin',
                        3 => 'lavendel',
                        4 => 'minze',
                        5 => 'moschus',
                        6 => 'rosmarin',
                        7 => 'schwarze-johannisbeere',
                        8 => 'thymian',
                        9 => 'zitrone',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
            178 => [
                'slug' => 'lu15',
                'translations' => [
                    'de' => [
                        'name' => 'LU15',
                        'short_description' => '',
                        'description' => 'Der Duft eröffnet mit berauschenden tropischen Noten, die ein Gefühl von Vitalität vermitteln, und entwickelt sich schnell zu einem Herzen, das reich an warmen Gewürzen, Tee- und Kaffeenoten ist, was ihm eine süchtig machende Note verleiht. Die Basis ist holzig-harzig und luxuriös, was dem Duft eine lange Haltbarkeit und eine starke olfaktorische Aura verleiht.',
                    ],
                    'en' => [
                        'name' => 'LU15',
                        'short_description' => '',
                        'description' => 'The fragrance opens with delightful tropical notes that provide a sense of vitality, quickly evolving to reveal a heart rich in warm spices, tea, and coffee notes, giving it an addictive character. The base is luxurious, woody, and resinous, providing long-lasting performance and a powerful olfactory aura.',
                    ],
                    'ar' => [
                        'name' => 'LU15',
                        'short_description' => '',
                        'description' => 'يفتتح العطر بنغمات استوائية مبهجة تضفي إحساساً بالحيوية، وسرعان ما يتطور ليكشف عن قلب غني بالتوابل الدافئة ونفحات الشاي والقهوة التي تمنحه طابعاً إدمانياً. القاعدة خشبية راتنجية فخمة تمنحه ثباتاً طويلاً وهالة عطرية قوية',
                    ],
                ],
                'categories' => [
                    0 => 'luxusparfums',
                    1 => 'unisex-parfums',
                ],
                'attributes' => [
                    'art' => [
                        0 => 'luxus',
                    ],
                    'familie' => [
                        0 => 'aromatisch',
                        1 => 'holzig',
                    ],
                    'stimmung' => [
                        0 => 'exklusiv',
                        1 => 'charismatisch',
                        2 => 'raffiniert',
                    ],
                    'noten' => [
                        0 => 'aprikose',
                        1 => 'cappuccino',
                        2 => 'cypriol',
                        3 => 'davana',
                        4 => 'honig',
                        5 => 'ingwer',
                        6 => 'kardamom',
                        7 => 'labdanum',
                        8 => 'mango',
                        9 => 'schwarzer-tee',
                        10 => 'tangerine',
                        11 => 'tonkabohne',
                        12 => 'vanille',
                        13 => 'vetiver',
                        14 => 'zedernholz',
                    ],
                ],
                'variants' => [
                    0 => [
                        'size_ml' => 50,
                        'price' => '40.00',
                        'compare_at_price' => null,
                        'is_default' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return list<array{slug: string, name: string}>
     */
    public static function categories(): array
    {
        return [
            0 => [
                'slug' => 'damenparfums',
                'name' => 'Damenparfums',
            ],
            1 => [
                'slug' => 'herrenparfums',
                'name' => 'Herrenparfums',
            ],
            2 => [
                'slug' => 'unisex-parfums',
                'name' => 'Unisex Parfums',
            ],
            3 => [
                'slug' => 'luxusparfums',
                'name' => 'Luxusparfums',
            ],
        ];
    }

    /**
     * @return list<array{code: string, name: string, is_multiple: bool}>
     */
    public static function attributes(): array
    {
        return [
            0 => [
                'code' => 'art',
                'name' => 'Art',
                'is_multiple' => true,
            ],
            1 => [
                'code' => 'familie',
                'name' => 'Familie',
                'is_multiple' => true,
            ],
            2 => [
                'code' => 'stimmung',
                'name' => 'Stimmung',
                'is_multiple' => true,
            ],
            3 => [
                'code' => 'noten',
                'name' => 'Noten',
                'is_multiple' => true,
            ],
        ];
    }

    /**
     * @return array<string, list<array{slug: string, name: string}>>
     */
    public static function attributeValues(): array
    {
        return [
            'art' => [
                0 => [
                    'slug' => 'designer',
                    'name' => 'Designer',
                ],
                1 => [
                    'slug' => 'nische',
                    'name' => 'Nische',
                ],
                2 => [
                    'slug' => 'luxus',
                    'name' => 'Luxus',
                ],
            ],
            'familie' => [
                0 => [
                    'slug' => 'orientalisch',
                    'name' => 'Orientalisch',
                ],
                1 => [
                    'slug' => 'gourmand',
                    'name' => 'Gourmand',
                ],
                2 => [
                    'slug' => 'blumig',
                    'name' => 'Blumig',
                ],
                3 => [
                    'slug' => 'fruchtig',
                    'name' => 'Fruchtig',
                ],
                4 => [
                    'slug' => 'zitrisch',
                    'name' => 'Zitrisch',
                ],
                5 => [
                    'slug' => 'holzig',
                    'name' => 'Holzig',
                ],
                6 => [
                    'slug' => 'pudrig',
                    'name' => 'Pudrig',
                ],
                7 => [
                    'slug' => 'aromatisch',
                    'name' => 'Aromatisch',
                ],
                8 => [
                    'slug' => 'aquatisch',
                    'name' => 'Aquatisch',
                ],
                9 => [
                    'slug' => 'frisch',
                    'name' => 'Frisch',
                ],
                10 => [
                    'slug' => 'ledrig',
                    'name' => 'Ledrig',
                ],
                11 => [
                    'slug' => 'wuerzig',
                    'name' => 'Würzig',
                ],
                12 => [
                    'slug' => 'tabak',
                    'name' => 'Tabak',
                ],
            ],
            'stimmung' => [
                0 => [
                    'slug' => 'sinnlich',
                    'name' => 'Sinnlich',
                ],
                1 => [
                    'slug' => 'anziehend',
                    'name' => 'Anziehend',
                ],
                2 => [
                    'slug' => 'luxurioes',
                    'name' => 'Luxuriös',
                ],
                3 => [
                    'slug' => 'feminin',
                    'name' => 'Feminin',
                ],
                4 => [
                    'slug' => 'elegant',
                    'name' => 'Elegant',
                ],
                5 => [
                    'slug' => 'exklusiv',
                    'name' => 'Exklusiv',
                ],
                6 => [
                    'slug' => 'selbstbewusst',
                    'name' => 'Selbstbewusst',
                ],
                7 => [
                    'slug' => 'sportlich',
                    'name' => 'Sportlich',
                ],
                8 => [
                    'slug' => 'charismatisch',
                    'name' => 'Charismatisch',
                ],
                9 => [
                    'slug' => 'modern',
                    'name' => 'Modern',
                ],
                10 => [
                    'slug' => 'professionell',
                    'name' => 'Professionell',
                ],
                11 => [
                    'slug' => 'klassisch',
                    'name' => 'Klassisch',
                ],
                12 => [
                    'slug' => 'frisch',
                    'name' => 'Frisch',
                ],
                13 => [
                    'slug' => 'sauber',
                    'name' => 'Sauber',
                ],
                14 => [
                    'slug' => 'dunkel',
                    'name' => 'Dunkel',
                ],
                15 => [
                    'slug' => 'unvergesslich',
                    'name' => 'Unvergesslich',
                ],
                16 => [
                    'slug' => 'intensiv',
                    'name' => 'Intensiv',
                ],
                17 => [
                    'slug' => 'jugendlich',
                    'name' => 'Jugendlich',
                ],
                18 => [
                    'slug' => 'maskulin',
                    'name' => 'Maskulin',
                ],
                19 => [
                    'slug' => 'warm',
                    'name' => 'Warm',
                ],
                20 => [
                    'slug' => 'raffiniert',
                    'name' => 'Raffiniert',
                ],
            ],
            'noten' => [
                0 => [
                    'slug' => 'blutorange',
                    'name' => 'Blutorange',
                ],
                1 => [
                    'slug' => 'gardenie',
                    'name' => 'Gardenie',
                ],
                2 => [
                    'slug' => 'honig',
                    'name' => 'Honig',
                ],
                3 => [
                    'slug' => 'patchouli',
                    'name' => 'Patchouli',
                ],
                4 => [
                    'slug' => 'baiser',
                    'name' => 'Baiser',
                ],
                5 => [
                    'slug' => 'lilie',
                    'name' => 'Lilie',
                ],
                6 => [
                    'slug' => 'salz',
                    'name' => 'Salz',
                ],
                7 => [
                    'slug' => 'weisse-blueten',
                    'name' => 'Weiße Blüten',
                ],
                8 => [
                    'slug' => 'bitterorange',
                    'name' => 'Bitterorange',
                ],
                9 => [
                    'slug' => 'himbeere',
                    'name' => 'Himbeere',
                ],
                10 => [
                    'slug' => 'jasmin-sambac',
                    'name' => 'Jasmin-Sambac',
                ],
                11 => [
                    'slug' => 'neroli',
                    'name' => 'Neroli',
                ],
                12 => [
                    'slug' => 'orangenbluete',
                    'name' => 'Orangenblüte',
                ],
                13 => [
                    'slug' => 'ambra',
                    'name' => 'Ambra',
                ],
                14 => [
                    'slug' => 'gesalzene-vanille',
                    'name' => 'Gesalzene Vanille',
                ],
                15 => [
                    'slug' => 'gruene-mandarine',
                    'name' => 'Grüne Mandarine',
                ],
                16 => [
                    'slug' => 'kaschmirholz',
                    'name' => 'Kaschmirholz',
                ],
                17 => [
                    'slug' => 'wasserjasmin',
                    'name' => 'Wasserjasmin',
                ],
                18 => [
                    'slug' => 'zieringwer',
                    'name' => 'Zieringwer',
                ],
                19 => [
                    'slug' => 'birne',
                    'name' => 'Birne',
                ],
                20 => [
                    'slug' => 'bourbon-vanille-absolue',
                    'name' => 'Bourbon-Vanille Absolue',
                ],
                21 => [
                    'slug' => 'jasmin',
                    'name' => 'Jasmin',
                ],
                22 => [
                    'slug' => 'karamell',
                    'name' => 'Karamell',
                ],
                23 => [
                    'slug' => 'lavendel',
                    'name' => 'Lavendel',
                ],
                24 => [
                    'slug' => 'madagassische-mandarine',
                    'name' => 'Madagassische Mandarine',
                ],
                25 => [
                    'slug' => 'madagassischer-ylang-ylang',
                    'name' => 'Madagassischer Ylang-Ylang',
                ],
                26 => [
                    'slug' => 'moosige-noten',
                    'name' => 'Moosige Noten',
                ],
                27 => [
                    'slug' => 'moschus',
                    'name' => 'Moschus',
                ],
                28 => [
                    'slug' => 'rosenoxid',
                    'name' => 'Rosenoxid',
                ],
                29 => [
                    'slug' => 'damaszener-rose',
                    'name' => 'Damaszener-Rose',
                ],
                30 => [
                    'slug' => 'grasse-jasmin',
                    'name' => 'Grasse-Jasmin',
                ],
                31 => [
                    'slug' => 'komorischer-ylang-ylang',
                    'name' => 'Komorischer Ylang-Ylang',
                ],
                32 => [
                    'slug' => 'kalabrische-bergamotte',
                    'name' => 'Kalabrische Bergamotte',
                ],
                33 => [
                    'slug' => 'maigloeckchen',
                    'name' => 'Maiglöckchen',
                ],
                34 => [
                    'slug' => 'pfingstrose',
                    'name' => 'Pfingstrose',
                ],
                35 => [
                    'slug' => 'sizilianische-mandarine',
                    'name' => 'Sizilianische Mandarine',
                ],
                36 => [
                    'slug' => 'weisser-moschus',
                    'name' => 'Weißer Moschus',
                ],
                37 => [
                    'slug' => 'aprikose',
                    'name' => 'Aprikose',
                ],
                38 => [
                    'slug' => 'bittermandel',
                    'name' => 'Bittermandel',
                ],
                39 => [
                    'slug' => 'kokosnuss',
                    'name' => 'Kokosnuss',
                ],
                40 => [
                    'slug' => 'pflaume',
                    'name' => 'Pflaume',
                ],
                41 => [
                    'slug' => 'piment',
                    'name' => 'Piment',
                ],
                42 => [
                    'slug' => 'rose',
                    'name' => 'Rose',
                ],
                43 => [
                    'slug' => 'rosenholz',
                    'name' => 'Rosenholz',
                ],
                44 => [
                    'slug' => 'sandelholz',
                    'name' => 'Sandelholz',
                ],
                45 => [
                    'slug' => 'tuberose',
                    'name' => 'Tuberose',
                ],
                46 => [
                    'slug' => 'vanille',
                    'name' => 'Vanille',
                ],
                47 => [
                    'slug' => 'bergamotte',
                    'name' => 'Bergamotte',
                ],
                48 => [
                    'slug' => 'mandarine',
                    'name' => 'Mandarine',
                ],
                49 => [
                    'slug' => 'orange',
                    'name' => 'Orange',
                ],
                50 => [
                    'slug' => 'weisser-amber',
                    'name' => 'Weißer Amber',
                ],
                51 => [
                    'slug' => 'zeder',
                    'name' => 'Zeder',
                ],
                52 => [
                    'slug' => 'ananas',
                    'name' => 'Ananas',
                ],
                53 => [
                    'slug' => 'kirsche',
                    'name' => 'Kirsche',
                ],
                54 => [
                    'slug' => 'popcorn',
                    'name' => 'Popcorn',
                ],
                55 => [
                    'slug' => 'veilchen',
                    'name' => 'Veilchen',
                ],
                56 => [
                    'slug' => 'walderdbeere',
                    'name' => 'Walderdbeere',
                ],
                57 => [
                    'slug' => 'amber',
                    'name' => 'Amber',
                ],
                58 => [
                    'slug' => 'zedernholz',
                    'name' => 'Zedernholz',
                ],
                59 => [
                    'slug' => 'kaffee',
                    'name' => 'Kaffee',
                ],
                60 => [
                    'slug' => 'rosa-pfeffer',
                    'name' => 'Rosa Pfeffer',
                ],
                61 => [
                    'slug' => 'holzig',
                    'name' => 'Holzig',
                ],
                62 => [
                    'slug' => 'johannisbeere',
                    'name' => 'Johannisbeere',
                ],
                63 => [
                    'slug' => 'mimose',
                    'name' => 'Mimose',
                ],
                64 => [
                    'slug' => 'opoponax',
                    'name' => 'Opoponax',
                ],
                65 => [
                    'slug' => 'tonkabohne',
                    'name' => 'Tonkabohne',
                ],
                66 => [
                    'slug' => 'vetiver',
                    'name' => 'Vetiver',
                ],
                67 => [
                    'slug' => 'ylang-ylang',
                    'name' => 'Ylang-Ylang',
                ],
                68 => [
                    'slug' => 'iris',
                    'name' => 'Iris',
                ],
                69 => [
                    'slug' => 'teakholz',
                    'name' => 'Teakholz',
                ],
                70 => [
                    'slug' => 'wasserhyazinthe',
                    'name' => 'Wasserhyazinthe',
                ],
                71 => [
                    'slug' => 'zitrusfruechte',
                    'name' => 'Zitrusfrüchte',
                ],
                72 => [
                    'slug' => 'aldehyde',
                    'name' => 'Aldehyde',
                ],
                73 => [
                    'slug' => 'zitrone',
                    'name' => 'Zitrone',
                ],
                74 => [
                    'slug' => 'benzoe',
                    'name' => 'Benzoe',
                ],
                75 => [
                    'slug' => 'magnolie',
                    'name' => 'Magnolie',
                ],
                76 => [
                    'slug' => 'mandarinenbluete',
                    'name' => 'Mandarinenblüte',
                ],
                77 => [
                    'slug' => 'schwarzer-pfeffer',
                    'name' => 'Schwarzer Pfeffer',
                ],
                78 => [
                    'slug' => 'birnenbluete',
                    'name' => 'Birnenblüte',
                ],
                79 => [
                    'slug' => 'brauner-zucker',
                    'name' => 'Brauner Zucker',
                ],
                80 => [
                    'slug' => 'frangipani',
                    'name' => 'Frangipani',
                ],
                81 => [
                    'slug' => 'rote-beeren',
                    'name' => 'Rote Beeren',
                ],
                82 => [
                    'slug' => 'litschi',
                    'name' => 'Litschi',
                ],
                83 => [
                    'slug' => 'madonnenlilie',
                    'name' => 'Madonnenlilie',
                ],
                84 => [
                    'slug' => 'pfirsich',
                    'name' => 'Pfirsich',
                ],
                85 => [
                    'slug' => 'kandierte-zitrone',
                    'name' => 'Kandierte Zitrone',
                ],
                86 => [
                    'slug' => 'bourbon-vanille',
                    'name' => 'Bourbon-Vanille',
                ],
                87 => [
                    'slug' => 'brombeere',
                    'name' => 'Brombeere',
                ],
                88 => [
                    'slug' => 'erdbeere',
                    'name' => 'Erdbeere',
                ],
                89 => [
                    'slug' => 'heidelbeere',
                    'name' => 'Heidelbeere',
                ],
                90 => [
                    'slug' => 'bulgarische-rose',
                    'name' => 'Bulgarische Rose',
                ],
                91 => [
                    'slug' => 'geroestete-tonkabohne',
                    'name' => 'Geröstete Tonkabohne',
                ],
                92 => [
                    'slug' => 'kakao',
                    'name' => 'Kakao',
                ],
                93 => [
                    'slug' => 'kaschmir',
                    'name' => 'Kaschmir',
                ],
                94 => [
                    'slug' => 'mandel',
                    'name' => 'Mandel',
                ],
                95 => [
                    'slug' => 'praline',
                    'name' => 'Praline',
                ],
                96 => [
                    'slug' => 'zimt',
                    'name' => 'Zimt',
                ],
                97 => [
                    'slug' => 'ingwer',
                    'name' => 'Ingwer',
                ],
                98 => [
                    'slug' => 'pimentblatt',
                    'name' => 'Pimentblatt',
                ],
                99 => [
                    'slug' => 'aprikose-galbanum-himbeere-hyazinthe-jasmin-moschus-pfirsich-rose-sandelholz-ylang-ylang-zedernholz',
                    'name' => 'Aprikose, Galbanum, Himbeere, Hyazinthe, Jasmin, Moschus, Pfirsich, Rose, Sandelholz, Ylang-Ylang, Zedernholz',
                ],
                100 => [
                    'slug' => 'freesie',
                    'name' => 'Freesie',
                ],
                101 => [
                    'slug' => 'eichenmoos',
                    'name' => 'Eichenmoos',
                ],
                102 => [
                    'slug' => 'grapefruit',
                    'name' => 'Grapefruit',
                ],
                103 => [
                    'slug' => 'tuerkische-damaszener-rose',
                    'name' => 'Türkische Damaszener-Rose',
                ],
                104 => [
                    'slug' => 'weihrauch',
                    'name' => 'Weihrauch',
                ],
                105 => [
                    'slug' => 'holzige-noten',
                    'name' => 'Holzige Noten',
                ],
                106 => [
                    'slug' => 'moos',
                    'name' => 'Moos',
                ],
                107 => [
                    'slug' => 'ambroxan',
                    'name' => 'Ambroxan',
                ],
                108 => [
                    'slug' => 'bitterorangenbluete',
                    'name' => 'Bitterorangenblüte',
                ],
                109 => [
                    'slug' => 'jasmin-sambac-absolue',
                    'name' => 'Jasmin-Sambac Absolue',
                ],
                110 => [
                    'slug' => 'siam-benzoe',
                    'name' => 'Siam-Benzoe',
                ],
                111 => [
                    'slug' => 'tangerine',
                    'name' => 'Tangerine',
                ],
                112 => [
                    'slug' => 'tunesische-orangenbluete-absolue',
                    'name' => 'Tunesische Orangenblüte Absolue',
                ],
                113 => [
                    'slug' => 'lotus',
                    'name' => 'Lotus',
                ],
                114 => [
                    'slug' => 'mairose',
                    'name' => 'Mairose',
                ],
                115 => [
                    'slug' => 'melone',
                    'name' => 'Melone',
                ],
                116 => [
                    'slug' => 'quitte',
                    'name' => 'Quitte',
                ],
                117 => [
                    'slug' => 'schwarze-johannisbeere',
                    'name' => 'Schwarze Johannisbeere',
                ],
                118 => [
                    'slug' => 'seerose',
                    'name' => 'Seerose',
                ],
                119 => [
                    'slug' => 'veilchenwurzel',
                    'name' => 'Veilchenwurzel',
                ],
                120 => [
                    'slug' => 'weissdorn',
                    'name' => 'Weißdorn',
                ],
                121 => [
                    'slug' => 'zitrische-noten',
                    'name' => 'Zitrische Noten',
                ],
                122 => [
                    'slug' => 'cognac',
                    'name' => 'Cognac',
                ],
                123 => [
                    'slug' => 'tabak',
                    'name' => 'Tabak',
                ],
                124 => [
                    'slug' => 'kastanie',
                    'name' => 'Kastanie',
                ],
                125 => [
                    'slug' => 'seide',
                    'name' => 'Seide',
                ],
                126 => [
                    'slug' => 'rote-pfingstrose',
                    'name' => 'Rote Pfingstrose',
                ],
                127 => [
                    'slug' => 'tulpen',
                    'name' => 'Tulpen',
                ],
                128 => [
                    'slug' => 'hyazinthe',
                    'name' => 'Hyazinthe',
                ],
                129 => [
                    'slug' => 'kamelie',
                    'name' => 'Kamelie',
                ],
                130 => [
                    'slug' => 'puderzucker',
                    'name' => 'Puderzucker',
                ],
                131 => [
                    'slug' => 'veilchenblatt',
                    'name' => 'Veilchenblatt',
                ],
                132 => [
                    'slug' => 'aquatische-noten',
                    'name' => 'Aquatische Noten',
                ],
                133 => [
                    'slug' => 'gruener-apfel',
                    'name' => 'Grüner Apfel',
                ],
                134 => [
                    'slug' => 'vanillebluete',
                    'name' => 'Vanilleblüte',
                ],
                135 => [
                    'slug' => 'weisse-lilie',
                    'name' => 'Weiße Lilie',
                ],
                136 => [
                    'slug' => 'rangunschlinger',
                    'name' => 'Rangunschlinger',
                ],
                137 => [
                    'slug' => 'ambrette',
                    'name' => 'Ambrette',
                ],
                138 => [
                    'slug' => 'italienische-bergamotte',
                    'name' => 'Italienische Bergamotte',
                ],
                139 => [
                    'slug' => 'marshmallow',
                    'name' => 'Marshmallow',
                ],
                140 => [
                    'slug' => 'sahne',
                    'name' => 'Sahne',
                ],
                141 => [
                    'slug' => 'ecuadorianisches-palo-santo',
                    'name' => 'Ecuadorianisches Palo Santo',
                ],
                142 => [
                    'slug' => 'ambrox',
                    'name' => 'Ambrox',
                ],
                143 => [
                    'slug' => 'cripps-pink-apfel',
                    'name' => 'Cripps-Pink-Apfel',
                ],
                144 => [
                    'slug' => 'italienische-zitrone',
                    'name' => 'Italienische Zitrone',
                ],
                145 => [
                    'slug' => 'nektarinenbluete',
                    'name' => 'Nektarinenblüte',
                ],
                146 => [
                    'slug' => 'orangenbluetenwasser',
                    'name' => 'Orangenblütenwasser',
                ],
                147 => [
                    'slug' => 'rosa-moschus',
                    'name' => 'Rosa Moschus',
                ],
                148 => [
                    'slug' => 'zucker',
                    'name' => 'Zucker',
                ],
                149 => [
                    'slug' => 'alpenveilchen',
                    'name' => 'Alpenveilchen',
                ],
                150 => [
                    'slug' => 'exotische-hoelzer',
                    'name' => 'Exotische Hölzer',
                ],
                151 => [
                    'slug' => 'gartennelke',
                    'name' => 'Gartennelke',
                ],
                152 => [
                    'slug' => 'osmanthus',
                    'name' => 'Osmanthus',
                ],
                153 => [
                    'slug' => 'rosenwasser',
                    'name' => 'Rosenwasser',
                ],
                154 => [
                    'slug' => 'rum',
                    'name' => 'Rum',
                ],
                155 => [
                    'slug' => 'schwarze-orchidee',
                    'name' => 'Schwarze Orchidee',
                ],
                156 => [
                    'slug' => 'schwarze-pflaume',
                    'name' => 'Schwarze Pflaume',
                ],
                157 => [
                    'slug' => 'schwarze-trueffel',
                    'name' => 'Schwarze Trüffel',
                ],
                158 => [
                    'slug' => 'kardamom',
                    'name' => 'Kardamom',
                ],
                159 => [
                    'slug' => 'pfeffer',
                    'name' => 'Pfeffer',
                ],
                160 => [
                    'slug' => 'apfel',
                    'name' => 'Apfel',
                ],
                161 => [
                    'slug' => 'gurke',
                    'name' => 'Gurke',
                ],
                162 => [
                    'slug' => 'hoelzer',
                    'name' => 'Hölzer',
                ],
                163 => [
                    'slug' => 'mandarinenblatt',
                    'name' => 'Mandarinenblatt',
                ],
                164 => [
                    'slug' => 'tunesische-orangenbluete',
                    'name' => 'Tunesische Orangenblüte',
                ],
                165 => [
                    'slug' => 'indonesisches-patchouli',
                    'name' => 'Indonesisches Patchouli',
                ],
                166 => [
                    'slug' => 'marokkanischer-jasmin',
                    'name' => 'Marokkanischer Jasmin',
                ],
                167 => [
                    'slug' => 'orangenbluete-absolue',
                    'name' => 'Orangenblüte Absolue',
                ],
                168 => [
                    'slug' => 'schwarzer-tee',
                    'name' => 'Schwarzer Tee',
                ],
                169 => [
                    'slug' => 'seychellenpalme',
                    'name' => 'Seychellenpalme',
                ],
                170 => [
                    'slug' => 'cherry-hill-pfingstrose',
                    'name' => 'Cherry Hill-Pfingstrose',
                ],
                171 => [
                    'slug' => 'drachenfrucht',
                    'name' => 'Drachenfrucht',
                ],
                172 => [
                    'slug' => 'roter-frangipani',
                    'name' => 'Roter Frangipani',
                ],
                173 => [
                    'slug' => 'blumige-noten',
                    'name' => 'Blumige Noten',
                ],
                174 => [
                    'slug' => 'gruene-birne',
                    'name' => 'Grüne Birne',
                ],
                175 => [
                    'slug' => 'leder',
                    'name' => 'Leder',
                ],
                176 => [
                    'slug' => 'roestaromen',
                    'name' => 'Röstaromen',
                ],
                177 => [
                    'slug' => 'haitianisches-vetiver',
                    'name' => 'Haitianisches Vetiver',
                ],
                178 => [
                    'slug' => 'italienische-mandarine',
                    'name' => 'Italienische Mandarine',
                ],
                179 => [
                    'slug' => 'weisser-pfirsich',
                    'name' => 'Weißer Pfirsich',
                ],
                180 => [
                    'slug' => 'estragon',
                    'name' => 'Estragon',
                ],
                181 => [
                    'slug' => 'kuemmel',
                    'name' => 'Kümmel',
                ],
                182 => [
                    'slug' => 'minze',
                    'name' => 'Minze',
                ],
                183 => [
                    'slug' => 'kokospalmenholz',
                    'name' => 'Kokospalmenholz',
                ],
                184 => [
                    'slug' => 'rosengeranie',
                    'name' => 'Rosengeranie',
                ],
                185 => [
                    'slug' => 'ceylon-zimt',
                    'name' => 'Ceylon-Zimt',
                ],
                186 => [
                    'slug' => 'chinesischer-schwarzer-tee-co2',
                    'name' => 'Chinesischer schwarzer Tee CO2',
                ],
                187 => [
                    'slug' => 'nigerianischer-ingwer',
                    'name' => 'Nigerianischer Ingwer',
                ],
                188 => [
                    'slug' => 'sizilianische-zeder',
                    'name' => 'Sizilianische Zeder',
                ],
                189 => [
                    'slug' => 'tunesisches-neroli',
                    'name' => 'Tunesisches Neroli',
                ],
                190 => [
                    'slug' => 'oud',
                    'name' => 'Oud',
                ],
                191 => [
                    'slug' => 'pfefferminze',
                    'name' => 'Pfefferminze',
                ],
                192 => [
                    'slug' => 'rose-absolue',
                    'name' => 'Rose Absolue',
                ],
                193 => [
                    'slug' => 'rote-mandarine',
                    'name' => 'Rote Mandarine',
                ],
                194 => [
                    'slug' => 'fruchtige-noten',
                    'name' => 'Fruchtige Noten',
                ],
                195 => [
                    'slug' => 'italienische-zitronenschale',
                    'name' => 'Italienische Zitronenschale',
                ],
                196 => [
                    'slug' => 'muskatellersalbei',
                    'name' => 'Muskatellersalbei',
                ],
                197 => [
                    'slug' => 'provenzalischer-lavendel-absolue',
                    'name' => 'Provenzalischer Lavendel Absolue',
                ],
                198 => [
                    'slug' => 'rhabarber',
                    'name' => 'Rhabarber',
                ],
                199 => [
                    'slug' => 'vanille-absolue',
                    'name' => 'Vanille Absolue',
                ],
                200 => [
                    'slug' => 'guajakholz',
                    'name' => 'Guajakholz',
                ],
                201 => [
                    'slug' => 'lorbeerblatt',
                    'name' => 'Lorbeerblatt',
                ],
                202 => [
                    'slug' => 'maritime-noten',
                    'name' => 'Maritime Noten',
                ],
                203 => [
                    'slug' => 'geissblatt',
                    'name' => 'Geißblatt',
                ],
                204 => [
                    'slug' => 'kamille',
                    'name' => 'Kamille',
                ],
                205 => [
                    'slug' => 'muskat',
                    'name' => 'Muskat',
                ],
                206 => [
                    'slug' => 'muskatbluete',
                    'name' => 'Muskatblüte',
                ],
                207 => [
                    'slug' => 'ecuadorianischer-ambrettesamen',
                    'name' => 'Ecuadorianischer Ambrettesamen',
                ],
                208 => [
                    'slug' => 'florentinische-schwertlilie-absolue',
                    'name' => 'Florentinische Schwertlilie Absolue',
                ],
                209 => [
                    'slug' => 'virginiazeder',
                    'name' => 'Virginiazeder',
                ],
                210 => [
                    'slug' => 'papua-neuguinea-vanille',
                    'name' => 'Papua-Neuguinea-Vanille',
                ],
                211 => [
                    'slug' => 'sternanis',
                    'name' => 'Sternanis',
                ],
                212 => [
                    'slug' => 'szechuanpfeffer',
                    'name' => 'Szechuanpfeffer',
                ],
                213 => [
                    'slug' => 'bergamotteblatt',
                    'name' => 'Bergamotteblatt',
                ],
                214 => [
                    'slug' => 'koriandersamen',
                    'name' => 'Koriandersamen',
                ],
                215 => [
                    'slug' => 'rosmarin',
                    'name' => 'Rosmarin',
                ],
                216 => [
                    'slug' => 'salbei',
                    'name' => 'Salbei',
                ],
                217 => [
                    'slug' => 'wuerzige-noten',
                    'name' => 'Würzige Noten',
                ],
                218 => [
                    'slug' => 'glasierte-kastanie',
                    'name' => 'Glasierte Kastanie',
                ],
                219 => [
                    'slug' => 'provenzalischer-lavendel',
                    'name' => 'Provenzalischer Lavendel',
                ],
                220 => [
                    'slug' => 'gruene-zitrone',
                    'name' => 'Grüne Zitrone',
                ],
                221 => [
                    'slug' => 'labdanum',
                    'name' => 'Labdanum',
                ],
                222 => [
                    'slug' => 'basilikum',
                    'name' => 'Basilikum',
                ],
                223 => [
                    'slug' => 'gruene-noten',
                    'name' => 'Grüne Noten',
                ],
                224 => [
                    'slug' => 'kiefernnadel',
                    'name' => 'Kiefernnadel',
                ],
                225 => [
                    'slug' => 'rosengeranienblatt',
                    'name' => 'Rosengeranienblatt',
                ],
                226 => [
                    'slug' => 'tannenbalsam',
                    'name' => 'Tannenbalsam',
                ],
                227 => [
                    'slug' => 'thymian',
                    'name' => 'Thymian',
                ],
                228 => [
                    'slug' => 'wildleder',
                    'name' => 'Wildleder',
                ],
                229 => [
                    'slug' => 'zedernblatt',
                    'name' => 'Zedernblatt',
                ],
                230 => [
                    'slug' => 'mineralische-noten',
                    'name' => 'Mineralische Noten',
                ],
                231 => [
                    'slug' => 'neukaledonisches-sandelholz',
                    'name' => 'Neukaledonisches Sandelholz',
                ],
                232 => [
                    'slug' => 'meerwasser',
                    'name' => 'Meerwasser',
                ],
                233 => [
                    'slug' => 'geranie',
                    'name' => 'Geranie',
                ],
                234 => [
                    'slug' => 'mango',
                    'name' => 'Mango',
                ],
                235 => [
                    'slug' => 'amber-basilikum-grapefruit-ingwer-kardamom-koriander-orangenbluete-tabak-zedernholz',
                    'name' => 'Amber, Basilikum, Grapefruit, Ingwer, Kardamom, Koriander, Orangenblüte, Tabak, Zedernholz',
                ],
                236 => [
                    'slug' => 'atlaszeder',
                    'name' => 'Atlaszeder',
                ],
                237 => [
                    'slug' => 'venezolanische-tonkabohne',
                    'name' => 'Venezolanische Tonkabohne',
                ],
                238 => [
                    'slug' => 'birke',
                    'name' => 'Birke',
                ],
                239 => [
                    'slug' => 'gruener-tee',
                    'name' => 'Grüner Tee',
                ],
                240 => [
                    'slug' => 'papaya',
                    'name' => 'Papaya',
                ],
                241 => [
                    'slug' => 'koriander',
                    'name' => 'Koriander',
                ],
                242 => [
                    'slug' => 'iriswurzel',
                    'name' => 'Iriswurzel',
                ],
                243 => [
                    'slug' => 'kiefer',
                    'name' => 'Kiefer',
                ],
                244 => [
                    'slug' => 'petitgrain',
                    'name' => 'Petitgrain',
                ],
                245 => [
                    'slug' => 'wacholderbeere',
                    'name' => 'Wacholderbeere',
                ],
                246 => [
                    'slug' => 'blaetter',
                    'name' => 'Blätter',
                ],
                247 => [
                    'slug' => 'heliotrop',
                    'name' => 'Heliotrop',
                ],
                248 => [
                    'slug' => 'zypresse',
                    'name' => 'Zypresse',
                ],
                249 => [
                    'slug' => 'java-vetiver',
                    'name' => 'Java-Vetiver',
                ],
                250 => [
                    'slug' => 'primofiore-zitrone',
                    'name' => 'Primofiore-Zitrone',
                ],
                251 => [
                    'slug' => 'rum-absolue',
                    'name' => 'Rum Absolue',
                ],
                252 => [
                    'slug' => 'styrax',
                    'name' => 'Styrax',
                ],
                253 => [
                    'slug' => 'tabak-absolue',
                    'name' => 'Tabak Absolue',
                ],
                254 => [
                    'slug' => 'brasilianische-tonkabohne',
                    'name' => 'Brasilianische Tonkabohne',
                ],
                255 => [
                    'slug' => 'cade-holz',
                    'name' => 'Cade-Holz',
                ],
                256 => [
                    'slug' => 'guatemala-kardamom',
                    'name' => 'Guatemala-Kardamom',
                ],
                257 => [
                    'slug' => 'kalabrische-zitrone',
                    'name' => 'Kalabrische Zitrone',
                ],
                258 => [
                    'slug' => 'kakao-absolue',
                    'name' => 'Kakao Absolue',
                ],
                259 => [
                    'slug' => 'weisser-pfeffer',
                    'name' => 'Weißer Pfeffer',
                ],
                260 => [
                    'slug' => 'elemiharz',
                    'name' => 'Elemiharz',
                ],
                261 => [
                    'slug' => 'rosengeranie-absolue',
                    'name' => 'Rosengeranie Absolue',
                ],
                262 => [
                    'slug' => 'artemisia',
                    'name' => 'Artemisia',
                ],
                263 => [
                    'slug' => 'calamondinorange',
                    'name' => 'Calamondinorange',
                ],
                264 => [
                    'slug' => 'ebenholz',
                    'name' => 'Ebenholz',
                ],
                265 => [
                    'slug' => 'schwarzer-amber',
                    'name' => 'Schwarzer Amber',
                ],
                266 => [
                    'slug' => 'schwarzer-kardamom',
                    'name' => 'Schwarzer Kardamom',
                ],
                267 => [
                    'slug' => 'tagetes',
                    'name' => 'Tagetes',
                ],
                268 => [
                    'slug' => 'tolubalsam',
                    'name' => 'Tolubalsam',
                ],
                269 => [
                    'slug' => 'lorbeer',
                    'name' => 'Lorbeer',
                ],
                270 => [
                    'slug' => 'ringelblume',
                    'name' => 'Ringelblume',
                ],
                271 => [
                    'slug' => 'kulfi',
                    'name' => 'Kulfi',
                ],
                272 => [
                    'slug' => 'mastixharz',
                    'name' => 'Mastixharz',
                ],
                273 => [
                    'slug' => 'safran',
                    'name' => 'Safran',
                ],
                274 => [
                    'slug' => 'kreuzkuemmel',
                    'name' => 'Kreuzkümmel',
                ],
                275 => [
                    'slug' => 'agarholz-oud',
                    'name' => 'Agarholz (Oud)',
                ],
                276 => [
                    'slug' => 'angelika',
                    'name' => 'Angelika',
                ],
                277 => [
                    'slug' => 'galbanum',
                    'name' => 'Galbanum',
                ],
                278 => [
                    'slug' => 'pinker-pfeffer',
                    'name' => 'Pinker Pfeffer',
                ],
                279 => [
                    'slug' => 'muskatnuss',
                    'name' => 'Muskatnuss',
                ],
                280 => [
                    'slug' => 'suessholz-lakritze',
                    'name' => 'Süßholz (Lakritze)',
                ],
                281 => [
                    'slug' => 'patschuli',
                    'name' => 'Patschuli',
                ],
                282 => [
                    'slug' => 'weisses-oud-synthetischhell',
                    'name' => 'Weißes Oud (Synthetisch/Hell)',
                ],
                283 => [
                    'slug' => 'florale-noten-oft-rose-oder-jasmin',
                    'name' => 'Florale Noten (oft Rose oder Jasmin)',
                ],
                284 => [
                    'slug' => 'leichte-zitrusnoten',
                    'name' => 'Leichte Zitrusnoten',
                ],
                285 => [
                    'slug' => 'schwarze-vanille',
                    'name' => 'Schwarze Vanille',
                ],
                286 => [
                    'slug' => 'wacholder',
                    'name' => 'Wacholder',
                ],
                287 => [
                    'slug' => 'virginia-zeder',
                    'name' => 'Virginia-Zeder',
                ],
                288 => [
                    'slug' => 'atlas-zeder',
                    'name' => 'Atlas-Zeder',
                ],
                289 => [
                    'slug' => 'himalaya-zeder',
                    'name' => 'Himalaya-Zeder',
                ],
                290 => [
                    'slug' => 'labdanum-absolue',
                    'name' => 'Labdanum Absolue',
                ],
                291 => [
                    'slug' => 'irisbutter',
                    'name' => 'Irisbutter',
                ],
                292 => [
                    'slug' => 'vanillin',
                    'name' => 'Vanillin',
                ],
                293 => [
                    'slug' => 'chili',
                    'name' => 'Chili',
                ],
                294 => [
                    'slug' => 'amberholz',
                    'name' => 'Amberholz',
                ],
                295 => [
                    'slug' => 'davana',
                    'name' => 'Davana',
                ],
                296 => [
                    'slug' => 'oregano',
                    'name' => 'Oregano',
                ],
                297 => [
                    'slug' => 'zistrose',
                    'name' => 'Zistrose',
                ],
                298 => [
                    'slug' => 'tuerkische-rose',
                    'name' => 'Türkische Rose',
                ],
                299 => [
                    'slug' => 'sizilianische-orange',
                    'name' => 'Sizilianische Orange',
                ],
                300 => [
                    'slug' => 'sizilianische-zitrone',
                    'name' => 'Sizilianische Zitrone',
                ],
                301 => [
                    'slug' => 'getrocknete-fruechte',
                    'name' => 'Getrocknete Früchte',
                ],
                302 => [
                    'slug' => 'harze',
                    'name' => 'Harze',
                ],
                303 => [
                    'slug' => 'animalische-noten',
                    'name' => 'Animalische Noten',
                ],
                304 => [
                    'slug' => 'indische-vanille',
                    'name' => 'Indische Vanille',
                ],
                305 => [
                    'slug' => 'jasmin-absolue',
                    'name' => 'Jasmin Absolue',
                ],
                306 => [
                    'slug' => 'kirsch-likoer',
                    'name' => 'Kirsch-Likör',
                ],
                307 => [
                    'slug' => 'perubalsam',
                    'name' => 'Perubalsam',
                ],
                308 => [
                    'slug' => 'sauerkirschsirup',
                    'name' => 'Sauerkirschsirup',
                ],
                309 => [
                    'slug' => 'schwarzkirsche',
                    'name' => 'Schwarzkirsche',
                ],
                310 => [
                    'slug' => 'helle-hoelzer',
                    'name' => 'Helle Hölzer',
                ],
                311 => [
                    'slug' => 'sizilianische-blutorange',
                    'name' => 'Sizilianische Blutorange',
                ],
                312 => [
                    'slug' => 'tonkabohne-absolue',
                    'name' => 'Tonkabohne Absolue',
                ],
                313 => [
                    'slug' => 'weinbergpfirsich',
                    'name' => 'Weinbergpfirsich',
                ],
                314 => [
                    'slug' => 'indischer-ingwer',
                    'name' => 'Indischer Ingwer',
                ],
                315 => [
                    'slug' => 'indischer-jasmin-sambac-absolue',
                    'name' => 'Indischer Jasmin-Sambac Absolue',
                ],
                316 => [
                    'slug' => 'pistazie',
                    'name' => 'Pistazie',
                ],
                317 => [
                    'slug' => 'sauerkirsche',
                    'name' => 'Sauerkirsche',
                ],
                318 => [
                    'slug' => 'nepalesisches-oud',
                    'name' => 'Nepalesisches Oud',
                ],
                319 => [
                    'slug' => 'rohrzucker',
                    'name' => 'Rohrzucker',
                ],
                320 => [
                    'slug' => 'ceylon-zimtblatt',
                    'name' => 'Ceylon-Zimtblatt',
                ],
                321 => [
                    'slug' => 'spanisches-labdanum',
                    'name' => 'Spanisches Labdanum',
                ],
                322 => [
                    'slug' => 'zim',
                    'name' => 'Zim',
                ],
                323 => [
                    'slug' => 'agarholz',
                    'name' => 'Agarholz',
                ],
                324 => [
                    'slug' => 'beifuss',
                    'name' => 'Beifuß',
                ],
                325 => [
                    'slug' => 'gurjanbalsam',
                    'name' => 'Gurjanbalsam',
                ],
                326 => [
                    'slug' => 'hanf',
                    'name' => 'Hanf',
                ],
                327 => [
                    'slug' => 'dattel',
                    'name' => 'Dattel',
                ],
                328 => [
                    'slug' => 'myrrhe',
                    'name' => 'Myrrhe',
                ],
                329 => [
                    'slug' => 'balsamische-noten',
                    'name' => 'Balsamische Noten',
                ],
                330 => [
                    'slug' => 'moschusnoten',
                    'name' => 'Moschusnoten',
                ],
                331 => [
                    'slug' => 'trockene-hoelzer',
                    'name' => 'Trockene Hölzer',
                ],
                332 => [
                    'slug' => 'passionsfrucht',
                    'name' => 'Passionsfrucht',
                ],
                333 => [
                    'slug' => 'spanische-zistrose-absolue',
                    'name' => 'Spanische Zistrose Absolue',
                ],
                334 => [
                    'slug' => 'tuerkische-rose-absolue',
                    'name' => 'Türkische Rose Absolue',
                ],
                335 => [
                    'slug' => 'eiche',
                    'name' => 'Eiche',
                ],
                336 => [
                    'slug' => 'himbeer-likoer',
                    'name' => 'Himbeer-Likör',
                ],
                337 => [
                    'slug' => 'indisches-sandelholz',
                    'name' => 'Indisches Sandelholz',
                ],
                338 => [
                    'slug' => 'sand',
                    'name' => 'Sand',
                ],
                339 => [
                    'slug' => 'ambrettesamen-absolue',
                    'name' => 'Ambrettesamen Absolue',
                ],
                340 => [
                    'slug' => 'damaszener-rose-absolue',
                    'name' => 'Damaszener-Rose Absolue',
                ],
                341 => [
                    'slug' => 'granatapfel',
                    'name' => 'Granatapfel',
                ],
                342 => [
                    'slug' => 'gruene-minze',
                    'name' => 'Grüne Minze',
                ],
                343 => [
                    'slug' => 'hibiskus',
                    'name' => 'Hibiskus',
                ],
                344 => [
                    'slug' => 'hibiskustee',
                    'name' => 'Hibiskustee',
                ],
                345 => [
                    'slug' => 'vanilleorchidee',
                    'name' => 'Vanilleorchidee',
                ],
                346 => [
                    'slug' => 'schwarze-rose',
                    'name' => 'Schwarze Rose',
                ],
                347 => [
                    'slug' => 'schwarzer-trueffel',
                    'name' => 'Schwarzer Trüffel',
                ],
                348 => [
                    'slug' => 'haselnuss',
                    'name' => 'Haselnuss',
                ],
                349 => [
                    'slug' => 'schwarzes-leder',
                    'name' => 'Schwarzes Leder',
                ],
                350 => [
                    'slug' => 'weisses-moos',
                    'name' => 'Weißes Moos',
                ],
                351 => [
                    'slug' => 'gewuerzter-rum',
                    'name' => 'Gewürzter Rum',
                ],
                352 => [
                    'slug' => 'kandierter-apfel',
                    'name' => 'Kandierter Apfel',
                ],
                353 => [
                    'slug' => 'mate',
                    'name' => 'Mate',
                ],
                354 => [
                    'slug' => 'schokolade',
                    'name' => 'Schokolade',
                ],
                355 => [
                    'slug' => 'japanische-yuzu',
                    'name' => 'Japanische Yuzu',
                ],
                356 => [
                    'slug' => 'gewuerznelke',
                    'name' => 'Gewürznelke',
                ],
                357 => [
                    'slug' => 'ambrettesamen',
                    'name' => 'Ambrettesamen',
                ],
                358 => [
                    'slug' => 'feige',
                    'name' => 'Feige',
                ],
                359 => [
                    'slug' => 'moehrensamen',
                    'name' => 'Möhrensamen',
                ],
                360 => [
                    'slug' => 'zitronatzitrone',
                    'name' => 'Zitronatzitrone',
                ],
                361 => [
                    'slug' => 'mandelmilch',
                    'name' => 'Mandelmilch',
                ],
                362 => [
                    'slug' => 'nagarmotha',
                    'name' => 'Nagarmotha',
                ],
                363 => [
                    'slug' => 'heller-tabak',
                    'name' => 'Heller Tabak',
                ],
                364 => [
                    'slug' => 'anis',
                    'name' => 'Anis',
                ],
                365 => [
                    'slug' => 'papyrus',
                    'name' => 'Papyrus',
                ],
                366 => [
                    'slug' => 'provenzalischer-honig-absolue',
                    'name' => 'Provenzalischer Honig Absolue',
                ],
                367 => [
                    'slug' => 'somalischer-weihrauch',
                    'name' => 'Somalischer Weihrauch',
                ],
                368 => [
                    'slug' => 'rosenlokum',
                    'name' => 'Rosenlokum',
                ],
                369 => [
                    'slug' => 'suessholz',
                    'name' => 'Süßholz',
                ],
                370 => [
                    'slug' => 'bulgarische-damaszener-rose-tuerkische-damaszener-rose-absolue-laotisches-oud-vanille-siam-benzoe-veilchen-amber',
                    'name' => 'Bulgarische Damaszener-Rose, Türkische Damaszener-Rose Absolue, Laotisches Oud, Vanille, Siam-Benzoe, Veilchen, Amber',
                ],
                371 => [
                    'slug' => 'duftnoten-bergamotte',
                    'name' => 'Duftnoten: Bergamotte',
                ],
                372 => [
                    'slug' => 'kakaoblatt',
                    'name' => 'Kakaoblatt',
                ],
                373 => [
                    'slug' => 'opium',
                    'name' => 'Opium',
                ],
                374 => [
                    'slug' => 'wermutkraut',
                    'name' => 'Wermutkraut',
                ],
                375 => [
                    'slug' => 'eisenkraut',
                    'name' => 'Eisenkraut',
                ],
                376 => [
                    'slug' => 'cappuccino',
                    'name' => 'Cappuccino',
                ],
                377 => [
                    'slug' => 'cypriol',
                    'name' => 'Cypriol',
                ],
            ],
        ];
    }
}
