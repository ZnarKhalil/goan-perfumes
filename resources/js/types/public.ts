import type { ReactNode } from 'react';

export type PublicLocaleCode = 'de' | 'en' | 'ar';

export type PublicTextDirection = 'ltr' | 'rtl';

export type PublicSupportedLocale = {
    code: PublicLocaleCode;
    label: string;
    native_label: string;
    flag: string;
    dir: PublicTextDirection;
    formatter_locale: string;
};

export type PublicLocaleProps = {
    current: PublicLocaleCode;
    dir: PublicTextDirection;
    formatter_locale: string;
    supported: PublicSupportedLocale[];
    switcher_urls: Record<PublicLocaleCode, string>;
};

export type PublicCategoryNavItem = {
    id: number;
    slug: string;
    name: string;
    href: string;
    image_url: string | null;
};

export type PublicContactSettings = {
    whatsapp_number: string | null;
    whatsapp_url: string | null;
    email: string | null;
    email_url: string | null;
    phone: string | null;
    phone_url: string | null;
    instagram_url: string | null;
    tiktok_url: string | null;
    facebook_url: string | null;
};

export type PublicVariant = {
    id: number;
    size: string;
    price: string;
    compare_at_price: string | null;
    is_default: boolean;
};

export type PublicProductCard = {
    id: number;
    slug: string;
    href: string;
    name: string;
    brand: string | null;
    image_url: string | null;
    image_alt: string;
    min_price: string | null;
    max_price: string | null;
    categories: PublicCategoryNavItem[];
    is_featured: boolean;
};

export type PublicMediaItem = {
    id: number;
    url: string;
    alt: string;
    is_primary: boolean;
};

export type PublicAttributeBadge = {
    id: number;
    group_code: string;
    group_name: string;
    slug: string;
    name: string;
};

export type PublicAttributeBadgeGroup = {
    code: string;
    name: string;
    values: PublicAttributeBadge[];
};

export type PublicProductDetail = {
    id: number;
    slug: string;
    name: string;
    brand: string | null;
    short_description: string;
    description: string;
    media: PublicMediaItem[];
    variants: PublicVariant[];
    attribute_groups: PublicAttributeBadgeGroup[];
    categories: PublicCategoryNavItem[];
    primary_category: PublicCategoryNavItem | null;
};

export type PublicFilterValue = {
    id: number;
    slug: string;
    name: string;
    selected: boolean;
    href: string;
};

export type PublicFilterGroup = {
    id: number;
    code: string;
    name: string;
    is_multiple: boolean;
    values: PublicFilterValue[];
};

export type PublicPromotion = {
    id: number;
    title: string;
    subtitle: string;
    badge: string | null;
    cta_text: string | null;
};

export type PublicSurfaceTheme = 'light' | 'dark';

export type PublicHeroSection = {
    eyebrow: string | null;
    title: string;
    body: string;
    cta_text: string | null;
    image_url: string | null;
    video_url: string | null;
};

export type PublicTextSection = {
    title: string;
    body: string;
};

export type PublicBulletSection = {
    title: string;
    items: string[];
};

export type PublicPageSections = {
    hero: PublicHeroSection;
    about: PublicTextSection;
    why_us: PublicBulletSection;
};

export type PublicPaginationLink = {
    label: string;
    href: string | null;
    active: boolean;
};

export type PublicPagination = {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PublicPaginationLink[];
};

export type PublicMeta = {
    title: string;
    description: string;
};

export type PublicLayoutProps = {
    navigation: PublicCategoryNavItem[];
    contact: PublicContactSettings;
    logo_url: string | null;
    locale?: PublicLocaleProps;
    theme?: PublicSurfaceTheme;
    children: ReactNode;
};

export type PublicHomePageProps = {
    navigation: PublicCategoryNavItem[];
    contact: PublicContactSettings;
    logo_url: string | null;
    locale?: PublicLocaleProps;
    meta: PublicMeta;
    promotions: PublicPromotion[];
    page_sections: PublicPageSections;
    featured_products: PublicProductCard[];
};

export type PublicCategoryPageProps = {
    navigation: PublicCategoryNavItem[];
    contact: PublicContactSettings;
    logo_url: string | null;
    locale?: PublicLocaleProps;
    meta: PublicMeta;
    category: PublicCategoryNavItem & {
        description: string;
        banner_url: string | null;
    };
    filters: PublicFilterGroup[];
    selected_filters: Record<string, string[]>;
    products: PublicProductCard[];
    pagination: PublicPagination;
};

export type PublicProductPageProps = {
    navigation: PublicCategoryNavItem[];
    contact: PublicContactSettings;
    logo_url: string | null;
    locale?: PublicLocaleProps;
    meta: PublicMeta;
    product: PublicProductDetail;
};

export type PublicContactPageProps = {
    navigation: PublicCategoryNavItem[];
    contact: PublicContactSettings;
    logo_url: string | null;
    locale?: PublicLocaleProps;
    meta: PublicMeta;
};
