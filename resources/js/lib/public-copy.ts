import type { PublicLocaleCode, PublicLocaleProps } from '@/types/public';

export type PublicCopy = {
    aria: {
        contactSidebar: string;
        cartUnavailable: string;
        goHome: string;
        localeSwitcher: string;
        mobileMenuTitle: string;
        mobileMenu: string;
        promotion: (index: number) => string;
        showLocale: (label: string) => string;
    };
    category: {
        eyebrow: string;
        empty: string;
        filter: string;
        filterModeMultiple: string;
        filterModeSingle: string;
        filteredSelection: string;
        filterHelp: string;
        results: (
            from: number | null,
            to: number | null,
            total: number,
        ) => string;
        reset: string;
    };
    contact: {
        directExchangeBody: string;
        directExchangeTitle: string;
        empty: string;
        eyebrow: string;
        intro: string;
        open: string;
        pageTitle: string;
        title: string;
        methods: {
            email: string;
            phone: string;
            whatsapp: string;
        };
    };
    footer: {
        brand: string;
        summary: string;
    };
    home: {
        aboutEyebrow: string;
        adviceEyebrow: string;
        adviceTitle: string;
        collectionsEyebrow: string;
        collectionsTitle: string;
        featuredEmpty: string;
        featuredEyebrow: string;
        featuredTitle: string;
        heroCta: string;
        luxuryLink: string;
        offersEyebrow: string;
        offersTitle: string;
        whyEyebrow: string;
        whatsappCta: string;
    };
    pagination: {
        label: string;
        next: string;
        previous: string;
    };
    product: {
        availabilityTitle: string;
        backToCategory: (category: string) => string;
        description: string;
        imageMissing: string;
        inquiry: string;
        priceOnRequest: string;
        scentProfile: string;
        sizeHelp: string;
        sizeTitle: string;
    };
    productCard: {
        highlight: string;
        imageMissing: string;
    };
};

const publicCopy: Record<PublicLocaleCode, PublicCopy> = {
    de: {
        aria: {
            contactSidebar: 'Kontakt',
            cartUnavailable: 'Warenkorb nicht verfügbar',
            goHome: 'Goan Perfume Startseite',
            localeSwitcher: 'Sprache wechseln',
            mobileMenu: 'Menü öffnen',
            mobileMenuTitle: 'Menü',
            promotion: (index) => `Promotion ${index}`,
            showLocale: (label) => `${label} anzeigen`,
        },
        category: {
            eyebrow: 'Kategorie',
            empty: 'Für diese Filter wurden keine Produkte gefunden.',
            filter: 'Filter',
            filterModeMultiple: 'Mehrfachauswahl',
            filterModeSingle: 'Einzelauswahl',
            filteredSelection: 'Gefilterte Duftauswahl',
            filterHelp:
                'Mehrere Werte in einer Gruppe erweitern die Auswahl. Verschiedene Gruppen verfeinern sie.',
            results: (from, to, total) =>
                `Ergebnisse ${from ?? 0}-${to ?? 0} von ${total}`,
            reset: 'Zurücksetzen',
        },
        contact: {
            directExchangeBody:
                'Am schnellsten beantworten wir Fragen zu Duftprofil, Größen und Verfügbarkeit über WhatsApp, Telefon, E-Mail oder Social Media.',
            directExchangeTitle: 'Direkter Austausch',
            empty: 'Noch keine Kontaktdaten hinterlegt.',
            eyebrow: 'Kontakt',
            intro: 'Schreiben Sie uns für Produktfragen, verfügbare Größen, aktuelle Angebote oder eine persönliche Empfehlung.',
            open: 'Öffnen',
            pageTitle: 'Kontakt',
            title: 'Direkter Kontakt für Duftberatung.',
            methods: {
                email: 'E-Mail',
                phone: 'Telefon',
                whatsapp: 'WhatsApp',
            },
        },
        footer: {
            brand: 'Goan Perfume',
            summary:
                'Produkt-Showcase ohne Online-Shop. Kontakt direkt per WhatsApp, Telefon oder E-Mail.',
        },
        home: {
            aboutEyebrow: 'Über uns',
            adviceEyebrow: 'Beratung',
            adviceTitle: 'Duftauswahl direkt mit Goan Perfume abstimmen.',
            collectionsEyebrow: 'Kollektionen',
            collectionsTitle: 'Durch unsere Duftwelten navigieren.',
            featuredEmpty: 'Noch keine Highlights ausgewählt.',
            featuredEyebrow: 'Luxus-Highlights',
            featuredTitle:
                'Signaturen mit Präsenz, Tiefe und sauberer Projektion.',
            heroCta: 'Kollektion entdecken',
            luxuryLink: 'Alle Luxusparfums',
            offersEyebrow: 'Aktionen',
            offersTitle: 'Aktuelle Angebote mit besonderem Duftmoment.',
            whyEyebrow: 'Warum wir',
            whatsappCta: 'WhatsApp öffnen',
        },
        pagination: {
            label: 'Seitennavigation',
            next: 'Weiter',
            previous: 'Zurück',
        },
        product: {
            availabilityTitle: 'Verfügbarkeit direkt anfragen.',
            backToCategory: (category) => `Zurück zu ${category}`,
            description: 'Beschreibung',
            imageMissing: 'Kein Bild',
            inquiry: 'Anfrage',
            priceOnRequest: 'Preis auf Anfrage',
            scentProfile: 'Duftprofil',
            sizeHelp: 'Anfrage basiert auf der ausgewählten Größe.',
            sizeTitle: 'Größe wählen',
        },
        productCard: {
            highlight: 'Highlight',
            imageMissing: 'Kein Bild',
        },
    },
    en: {
        aria: {
            contactSidebar: 'Contact',
            cartUnavailable: 'Cart unavailable',
            goHome: 'Goan Perfume home',
            localeSwitcher: 'Switch language',
            mobileMenu: 'Open menu',
            mobileMenuTitle: 'Menu',
            promotion: (index) => `Promotion ${index}`,
            showLocale: (label) => `Show ${label}`,
        },
        category: {
            eyebrow: 'Category',
            empty: 'No products were found for these filters.',
            filter: 'Filter',
            filterModeMultiple: 'Multiple selection',
            filterModeSingle: 'Single selection',
            filteredSelection: 'Filtered fragrance selection',
            filterHelp:
                'Multiple values in one group broaden the selection. Different groups refine it.',
            results: (from, to, total) =>
                `Results ${from ?? 0}-${to ?? 0} of ${total}`,
            reset: 'Reset',
        },
        contact: {
            directExchangeBody:
                'We answer questions about scent profile, sizes, and availability fastest via WhatsApp, phone, email, or social media.',
            directExchangeTitle: 'Direct exchange',
            empty: 'No contact details have been added yet.',
            eyebrow: 'Contact',
            intro: 'Write to us about product questions, available sizes, current offers, or a personal recommendation.',
            open: 'Open',
            pageTitle: 'Contact',
            title: 'Direct contact for fragrance advice.',
            methods: {
                email: 'Email',
                phone: 'Phone',
                whatsapp: 'WhatsApp',
            },
        },
        footer: {
            brand: 'Goan Perfume',
            summary:
                'Product showcase without online checkout. Contact us directly by WhatsApp, phone, or email.',
        },
        home: {
            aboutEyebrow: 'About us',
            adviceEyebrow: 'Advice',
            adviceTitle:
                'Coordinate your fragrance choice directly with Goan Perfume.',
            collectionsEyebrow: 'Collections',
            collectionsTitle: 'Navigate through our scent worlds.',
            featuredEmpty: 'No highlights selected yet.',
            featuredEyebrow: 'Luxury highlights',
            featuredTitle:
                'Signatures with presence, depth, and clean projection.',
            heroCta: 'Explore the collection',
            luxuryLink: 'All luxury perfumes',
            offersEyebrow: 'Offers',
            offersTitle: 'Current offers with a special fragrance moment.',
            whyEyebrow: 'Why us',
            whatsappCta: 'Open WhatsApp',
        },
        pagination: {
            label: 'Pagination',
            next: 'Next',
            previous: 'Previous',
        },
        product: {
            availabilityTitle: 'Ask directly about availability.',
            backToCategory: (category) => `Back to ${category}`,
            description: 'Description',
            imageMissing: 'No image',
            inquiry: 'Inquiry',
            priceOnRequest: 'Price on request',
            scentProfile: 'Scent profile',
            sizeHelp: 'The inquiry is based on the selected size.',
            sizeTitle: 'Choose size',
        },
        productCard: {
            highlight: 'Highlight',
            imageMissing: 'No image',
        },
    },
    ar: {
        aria: {
            contactSidebar: 'التواصل',
            cartUnavailable: 'سلة التسوق غير متاحة',
            goHome: 'الصفحة الرئيسية لعطور Goan',
            localeSwitcher: 'تغيير اللغة',
            mobileMenu: 'فتح القائمة',
            mobileMenuTitle: 'القائمة',
            promotion: (index) => `عرض ${index}`,
            showLocale: (label) => `عرض ${label}`,
        },
        category: {
            eyebrow: 'الفئة',
            empty: 'لم يتم العثور على منتجات لهذه الفلاتر.',
            filter: 'فلتر',
            filterModeMultiple: 'اختيار متعدد',
            filterModeSingle: 'اختيار واحد',
            filteredSelection: 'تشكيلة العطور المفلترة',
            filterHelp:
                'القيم المتعددة داخل المجموعة توسع الاختيار. المجموعات المختلفة تضيق النتائج.',
            results: (from, to, total) =>
                `النتائج ${from ?? 0}-${to ?? 0} من ${total}`,
            reset: 'إعادة ضبط',
        },
        contact: {
            directExchangeBody:
                'نجيب بسرعة عن الأسئلة المتعلقة بطابع العطر والمقاسات والتوفر عبر واتساب أو الهاتف أو البريد الإلكتروني أو وسائل التواصل.',
            directExchangeTitle: 'تواصل مباشر',
            empty: 'لم تتم إضافة بيانات تواصل بعد.',
            eyebrow: 'التواصل',
            intro: 'راسلنا بخصوص أسئلة المنتجات أو المقاسات المتوفرة أو العروض الحالية أو للحصول على توصية شخصية.',
            open: 'فتح',
            pageTitle: 'التواصل',
            title: 'تواصل مباشر لاستشارة العطور.',
            methods: {
                email: 'البريد الإلكتروني',
                phone: 'الهاتف',
                whatsapp: 'واتساب',
            },
        },
        footer: {
            brand: 'Goan Perfume',
            summary:
                'عرض منتجات بدون متجر إلكتروني. تواصل مباشر عبر واتساب أو الهاتف أو البريد الإلكتروني.',
        },
        home: {
            aboutEyebrow: 'من نحن',
            adviceEyebrow: 'استشارة',
            adviceTitle: 'نسق اختيار عطرك مباشرة مع Goan Perfume.',
            collectionsEyebrow: 'المجموعات',
            collectionsTitle: 'تنقل بين عوالمنا العطرية.',
            featuredEmpty: 'لم يتم اختيار منتجات مميزة بعد.',
            featuredEyebrow: 'مختارات فاخرة',
            featuredTitle: 'تواقيع عطرية بحضور وعمق وانتشار نقي.',
            heroCta: 'استكشف المجموعة',
            luxuryLink: 'كل العطور الفاخرة',
            offersEyebrow: 'العروض',
            offersTitle: 'عروض حالية مع لحظة عطرية خاصة.',
            whyEyebrow: 'لماذا نحن',
            whatsappCta: 'فتح واتساب',
        },
        pagination: {
            label: 'التنقل بين الصفحات',
            next: 'التالي',
            previous: 'السابق',
        },
        product: {
            availabilityTitle: 'اسأل مباشرة عن التوفر.',
            backToCategory: (category) => `العودة إلى ${category}`,
            description: 'الوصف',
            imageMissing: 'لا توجد صورة',
            inquiry: 'استفسار',
            priceOnRequest: 'السعر عند الطلب',
            scentProfile: 'طابع العطر',
            sizeHelp: 'يعتمد الاستفسار على المقاس المحدد.',
            sizeTitle: 'اختر المقاس',
        },
        productCard: {
            highlight: 'مميز',
            imageMissing: 'لا توجد صورة',
        },
    },
};

export function getPublicCopy(locale?: PublicLocaleProps): PublicCopy {
    return publicCopy[locale?.current ?? 'de'];
}

export function paginationLabel(label: string, copy: PublicCopy): string {
    if (label.includes('Previous') || label.includes('Zurück')) {
        return copy.pagination.previous;
    }

    if (label.includes('Next') || label.includes('Weiter')) {
        return copy.pagination.next;
    }

    return label;
}
