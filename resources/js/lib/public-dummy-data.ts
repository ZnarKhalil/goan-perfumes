import type {
    PublicCategoryNavItem,
    PublicCategoryPageProps,
    PublicContactPageProps,
    PublicContactSettings,
    PublicFilterGroup,
    PublicHomePageProps,
    PublicPageSections,
    PublicProductCard,
    PublicProductDetail,
    PublicProductPageProps,
    PublicPromotion,
    PublicVariant,
} from '@/types/public';

const image = (id: string, width = 1400, height = 1800): string =>
    `https://images.unsplash.com/${id}?auto=format&fit=crop&w=${width}&h=${height}&q=80`;

export const publicDummyNavigation: PublicCategoryNavItem[] = [
    {
        id: 1,
        slug: 'luxusparfums',
        name: 'Luxusparfums',
        href: '/luxusparfums',
        image_url: image('photo-1592945403244-b3fbafd7f539'),
    },
    {
        id: 2,
        slug: 'nischenparfums',
        name: 'Nischenparfums',
        href: '/nischenparfums',
        image_url: image('photo-1615634260167-c8cdede054de'),
    },
    {
        id: 3,
        slug: 'designerparfums',
        name: 'Designerparfums',
        href: '/designerparfums',
        image_url: image('photo-1590736704728-f4730bb30770'),
    },
    {
        id: 4,
        slug: 'arabische-parfums',
        name: 'Arabische Parfums',
        href: '/arabische-parfums',
        image_url: image('photo-1541643600914-78b084683601'),
    },
    {
        id: 5,
        slug: 'damenparfums',
        name: 'Damenparfums',
        href: '/damenparfums',
        image_url: image('photo-1585386959984-a41552231658'),
    },
    {
        id: 6,
        slug: 'herrenparfums',
        name: 'Herrenparfums',
        href: '/herrenparfums',
        image_url: image('photo-1523293182086-7651a899d37f'),
    },
    {
        id: 7,
        slug: 'unisex-parfums',
        name: 'Unisex-Parfums',
        href: '/unisex-parfums',
        image_url: image('photo-1595425964071-2c1ec3c98302'),
    },
];

export const publicDummyContact: PublicContactSettings = {
    whatsapp_number: '+49 170 1234567',
    whatsapp_url: 'https://wa.me/491701234567',
    email: 'kontakt@goanperfume.de',
    email_url: 'mailto:kontakt@goanperfume.de',
    phone: '+49 30 1234567',
    phone_url: 'tel:+49301234567',
    instagram_url: 'https://instagram.com/goanperfume',
    tiktok_url: 'https://tiktok.com/@goanperfume',
    facebook_url: 'https://facebook.com/goanperfume',
};

export const publicDummyLogoUrl: string | null = null;

export const publicDummyPageSections: PublicPageSections = {
    hero: {
        eyebrow: 'Goan Perfume',
        title: 'Goan Perfume',
        body: 'Ausgewählte Nischen- und Luxusparfums in Berlin, kuratiert für Menschen, die Duft bewusst tragen.',
        cta_text: 'Kollektion entdecken',
        image_url: null,
        video_url: null,
    },
    about: {
        title: 'Über Goan Perfume',
        body: 'Wir verbinden persönliche Duftberatung mit einem sorgfältig ausgewählten Sortiment aus Nische, Designer und arabischer Parfumkunst.',
    },
    why_us: {
        title: 'Warum wir',
        items: [
            'Kuratiertes Sortiment statt austauschbarer Massenware',
            'Beratung nach Duftfamilie, Stimmung und Anlass',
            'Direkter Kontakt per WhatsApp, Telefon oder E-Mail',
        ],
    },
};

export const publicDummyPromotions: PublicPromotion[] = [
    {
        id: 1,
        title: 'Ausgewählte Nischendüfte',
        subtitle:
            'Nur diese Woche: warme, elegante Signaturen für besondere Abende.',
        badge: 'LIMITIERTES ANGEBOT',
        cta_text: 'Angebot ansehen',
    },
    {
        id: 2,
        title: 'Arabische Duftkunst',
        subtitle: 'Oud, Amber und Gewürze mit Tiefe und Präsenz.',
        badge: 'NEU EINGETROFFEN',
        cta_text: 'Arabische Parfums',
    },
];

const variants = (
    baseId: number,
    prices: [string, string, string],
): PublicVariant[] => [
    {
        id: baseId,
        size: '30 ml',
        price: prices[0],
        compare_at_price: null,
        is_default: false,
    },
    {
        id: baseId + 1,
        size: '50 ml',
        price: prices[1],
        compare_at_price: null,
        is_default: true,
    },
    {
        id: baseId + 2,
        size: '100 ml',
        price: prices[2],
        compare_at_price: null,
        is_default: false,
    },
];

const categoryBySlug = (slug: string): PublicCategoryNavItem =>
    publicDummyNavigation.find((category) => category.slug === slug) ??
    publicDummyNavigation[0];

export const publicDummyProducts: PublicProductCard[] = [
    {
        id: 1,
        slug: 'amber-noir-intense',
        href: '/produkt/amber-noir-intense',
        name: 'Amber Noir Intense',
        brand: 'Maison Goan',
        image_url: image('photo-1594035910387-fea47794261f'),
        image_alt: 'Amber Noir Intense Parfumflakon',
        min_price: '42.00',
        max_price: '118.00',
        categories: [
            categoryBySlug('luxusparfums'),
            categoryBySlug('unisex-parfums'),
        ],
        is_featured: true,
    },
    {
        id: 2,
        slug: 'rose-saffron-oud',
        href: '/produkt/rose-saffron-oud',
        name: 'Rose Saffron Oud',
        brand: 'Al Qamar',
        image_url: image('photo-1595425970377-c9703cf48b6d'),
        image_alt: 'Rose Saffron Oud Parfum',
        min_price: '38.00',
        max_price: '99.00',
        categories: [
            categoryBySlug('arabische-parfums'),
            categoryBySlug('damenparfums'),
        ],
        is_featured: true,
    },
    {
        id: 3,
        slug: 'citrus-vetiver-club',
        href: '/produkt/citrus-vetiver-club',
        name: 'Citrus Vetiver Club',
        brand: 'Atelier Nord',
        image_url: image('photo-1595425972665-1f6ce5d6ba74'),
        image_alt: 'Citrus Vetiver Club Duftflakon',
        min_price: '29.00',
        max_price: '78.00',
        categories: [
            categoryBySlug('herrenparfums'),
            categoryBySlug('designerparfums'),
        ],
        is_featured: true,
    },
    {
        id: 4,
        slug: 'iris-musk-powder',
        href: '/produkt/iris-musk-powder',
        name: 'Iris Musk Powder',
        brand: 'Velour Parfums',
        image_url: image('photo-1615634262417-98ba6bc8e58c'),
        image_alt: 'Iris Musk Powder Parfum',
        min_price: '35.00',
        max_price: '92.00',
        categories: [
            categoryBySlug('damenparfums'),
            categoryBySlug('nischenparfums'),
        ],
        is_featured: true,
    },
    {
        id: 5,
        slug: 'bergamot-tea-air',
        href: '/produkt/bergamot-tea-air',
        name: 'Bergamot Tea Air',
        brand: 'Verde Studio',
        image_url: image('photo-1596462502278-27bfdc403348'),
        image_alt: 'Bergamot Tea Air Parfum',
        min_price: '24.00',
        max_price: '64.00',
        categories: [categoryBySlug('unisex-parfums')],
        is_featured: false,
    },
    {
        id: 6,
        slug: 'leather-tonka-reserve',
        href: '/produkt/leather-tonka-reserve',
        name: 'Leather Tonka Reserve',
        brand: 'Nocturne',
        image_url: image('photo-1617897903246-719242758050'),
        image_alt: 'Leather Tonka Reserve Flakon',
        min_price: '45.00',
        max_price: '125.00',
        categories: [
            categoryBySlug('herrenparfums'),
            categoryBySlug('luxusparfums'),
        ],
        is_featured: false,
    },
    {
        id: 7,
        slug: 'fig-jasmine-silk',
        href: '/produkt/fig-jasmine-silk',
        name: 'Fig Jasmine Silk',
        brand: 'Aurelia',
        image_url: image('photo-1615108391178-9fc4f3f541a7'),
        image_alt: 'Fig Jasmine Silk Parfum',
        min_price: '31.00',
        max_price: '82.00',
        categories: [categoryBySlug('damenparfums')],
        is_featured: false,
    },
    {
        id: 8,
        slug: 'oud-coffee-lab',
        href: '/produkt/oud-coffee-lab',
        name: 'Oud Coffee Lab',
        brand: 'Sillage 47',
        image_url: image('photo-1595425970377-2f8ded7c7b34'),
        image_alt: 'Oud Coffee Lab Duftflakon',
        min_price: '48.00',
        max_price: '132.00',
        categories: [
            categoryBySlug('arabische-parfums'),
            categoryBySlug('nischenparfums'),
        ],
        is_featured: false,
    },
];

export const publicDummyFilterGroups: PublicFilterGroup[] = [
    {
        id: 1,
        code: 'art',
        name: 'Art',
        is_multiple: false,
        values: [
            {
                id: 1,
                slug: 'nische',
                name: 'Nische',
                selected: true,
                href: '?art=nische',
            },
            {
                id: 2,
                slug: 'designer',
                name: 'Designer',
                selected: false,
                href: '?art=designer',
            },
        ],
    },
    {
        id: 2,
        code: 'familie',
        name: 'Familie',
        is_multiple: true,
        values: [
            {
                id: 3,
                slug: 'orientalisch',
                name: 'Orientalisch',
                selected: false,
                href: '?familie=orientalisch',
            },
            {
                id: 4,
                slug: 'blumig',
                name: 'Blumig',
                selected: true,
                href: '?familie=blumig',
            },
            {
                id: 5,
                slug: 'zitrisch',
                name: 'Zitrisch',
                selected: false,
                href: '?familie=zitrisch',
            },
            {
                id: 6,
                slug: 'holzig',
                name: 'Holzig',
                selected: true,
                href: '?familie=blumig,holzig',
            },
            {
                id: 7,
                slug: 'gourmand',
                name: 'Gourmand',
                selected: false,
                href: '?familie=gourmand',
            },
        ],
    },
    {
        id: 3,
        code: 'stimmung',
        name: 'Stimmung',
        is_multiple: true,
        values: [
            {
                id: 8,
                slug: 'frisch',
                name: 'Frisch',
                selected: false,
                href: '?stimmung=frisch',
            },
            {
                id: 9,
                slug: 'warm',
                name: 'Warm',
                selected: true,
                href: '?stimmung=warm',
            },
            {
                id: 10,
                slug: 'elegant',
                name: 'Elegant',
                selected: false,
                href: '?stimmung=elegant',
            },
            {
                id: 11,
                slug: 'sinnlich',
                name: 'Sinnlich',
                selected: false,
                href: '?stimmung=sinnlich',
            },
        ],
    },
    {
        id: 4,
        code: 'noten',
        name: 'Noten',
        is_multiple: true,
        values: [
            {
                id: 12,
                slug: 'rose',
                name: 'Rose',
                selected: true,
                href: '?noten=rose',
            },
            {
                id: 13,
                slug: 'oud',
                name: 'Oud',
                selected: false,
                href: '?noten=oud',
            },
            {
                id: 14,
                slug: 'amber',
                name: 'Amber',
                selected: true,
                href: '?noten=rose,amber',
            },
            {
                id: 15,
                slug: 'bergamotte',
                name: 'Bergamotte',
                selected: false,
                href: '?noten=bergamotte',
            },
            {
                id: 16,
                slug: 'vanille',
                name: 'Vanille',
                selected: false,
                href: '?noten=vanille',
            },
        ],
    },
];

export const publicDummyProductDetail: PublicProductDetail = {
    id: 1,
    slug: 'amber-noir-intense',
    name: 'Amber Noir Intense',
    brand: 'Maison Goan',
    short_description:
        'Ein warmer Amberduft mit dunkler Vanille, feinem Rauch und sauberem Moschus.',
    description:
        'Amber Noir Intense öffnet weich und würzig, bleibt lange auf der Haut und entwickelt eine elegante Tiefe ohne schwer zu wirken. Ideal für Abende, besondere Anlässe und alle, die einen präsenten, aber kontrollierten Duft suchen.',
    media: [
        {
            id: 1,
            url: image('photo-1594035910387-fea47794261f'),
            alt: 'Amber Noir Intense Hauptbild',
            is_primary: true,
        },
        {
            id: 2,
            url: image('photo-1619994403073-2cec844b8e63'),
            alt: 'Amber Noir Intense Detailaufnahme',
            is_primary: false,
        },
        {
            id: 3,
            url: image('photo-1600612253971-422e7f7faeb6'),
            alt: 'Amber Noir Intense mit warmer Lichtstimmung',
            is_primary: false,
        },
    ],
    variants: variants(101, ['42.00', '72.00', '118.00']),
    attribute_groups: [
        {
            code: 'familie',
            name: 'Familie',
            values: [
                {
                    id: 4,
                    group_code: 'familie',
                    group_name: 'Familie',
                    slug: 'orientalisch',
                    name: 'Orientalisch',
                },
                {
                    id: 6,
                    group_code: 'familie',
                    group_name: 'Familie',
                    slug: 'holzig',
                    name: 'Holzig',
                },
            ],
        },
        {
            code: 'stimmung',
            name: 'Stimmung',
            values: [
                {
                    id: 9,
                    group_code: 'stimmung',
                    group_name: 'Stimmung',
                    slug: 'warm',
                    name: 'Warm',
                },
                {
                    id: 10,
                    group_code: 'stimmung',
                    group_name: 'Stimmung',
                    slug: 'elegant',
                    name: 'Elegant',
                },
            ],
        },
        {
            code: 'noten',
            name: 'Noten',
            values: [
                {
                    id: 14,
                    group_code: 'noten',
                    group_name: 'Noten',
                    slug: 'amber',
                    name: 'Amber',
                },
                {
                    id: 16,
                    group_code: 'noten',
                    group_name: 'Noten',
                    slug: 'vanille',
                    name: 'Vanille',
                },
            ],
        },
    ],
    categories: [
        categoryBySlug('luxusparfums'),
        categoryBySlug('unisex-parfums'),
    ],
    primary_category: categoryBySlug('luxusparfums'),
};

const publicDummyMeta = {
    title: 'Goan Perfume',
    description:
        'Ausgewählte Luxus-, Nischen- und arabische Parfums, kuratiert von Goan Perfume.',
};

export const publicDummyHomeProps: PublicHomePageProps = {
    navigation: publicDummyNavigation,
    contact: publicDummyContact,
    logo_url: publicDummyLogoUrl,
    meta: publicDummyMeta,
    promotions: publicDummyPromotions,
    page_sections: publicDummyPageSections,
    featured_products: publicDummyProducts
        .filter((product) => product.is_featured)
        .slice(0, 4),
};

export const publicDummyCategoryProps: PublicCategoryPageProps = {
    navigation: publicDummyNavigation,
    contact: publicDummyContact,
    logo_url: publicDummyLogoUrl,
    meta: publicDummyMeta,
    category: {
        ...categoryBySlug('damenparfums'),
        description:
            'Florale, pudrige und elegante Düfte für jeden Tag und besondere Momente.',
        banner_url: image('photo-1585386959984-a41552231658', 1800, 900),
    },
    filters: publicDummyFilterGroups,
    selected_filters: {
        art: ['nische'],
        familie: ['blumig', 'holzig'],
        stimmung: ['warm'],
        noten: ['rose', 'amber'],
    },
    products: publicDummyProducts.slice(0, 6),
    pagination: {
        current_page: 1,
        last_page: 3,
        per_page: 6,
        total: 18,
        from: 1,
        to: 6,
        links: [
            { label: 'Zurück', href: null, active: false },
            { label: '1', href: '/damenparfums?page=1', active: true },
            { label: '2', href: '/damenparfums?page=2', active: false },
            { label: '3', href: '/damenparfums?page=3', active: false },
            { label: 'Weiter', href: '/damenparfums?page=2', active: false },
        ],
    },
};

export const publicDummyProductProps: PublicProductPageProps = {
    navigation: publicDummyNavigation,
    contact: publicDummyContact,
    logo_url: publicDummyLogoUrl,
    meta: publicDummyMeta,
    product: publicDummyProductDetail,
};

export const publicDummyContactProps: PublicContactPageProps = {
    navigation: publicDummyNavigation,
    contact: publicDummyContact,
    logo_url: publicDummyLogoUrl,
    meta: publicDummyMeta,
};
