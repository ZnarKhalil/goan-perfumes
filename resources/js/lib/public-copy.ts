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
        search: string;
        clearSearch: string;
        noFilterResults: string;
        relatedTitle: string;
    };
    contact: {
        directExchangeBody: string;
        directExchangeTitle: string;
        empty: string;
        eyebrow: string;
        intro: string;
        open: string;
        openMethod: (method: string) => string;
        pageTitle: string;
        title: string;
        methods: {
            email: string;
            phone: string;
            whatsapp: string;
        };
    };
    cookies: {
        accept: string;
        analyticsDescription: string;
        analyticsTitle: string;
        bannerLabel: string;
        description: string;
        footerSettings: string;
        necessaryDescription: string;
        necessaryTitle: string;
        privacyLink: string;
        reject: string;
        save: string;
        settings: string;
        settingsDescription: string;
        settingsTitle: string;
        title: string;
    };
    footer: {
        brand: string;
        summary: string;
        collectionsTitle: string;
        contactTitle: string;
        contactPage: string;
        impressumLink: string;
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
        heroSecondary: string;
        luxuryLink: string;
        offersEyebrow: string;
        offersTitle: string;
        whyEyebrow: string;
        whatsappCta: string;
    };
    navigation: {
        homepage: string;
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
        categoriesTitle: string;
        scentProfile: string;
        sizeHelp: string;
        sizeTitle: string;
    };
    productCard: {
        highlight: string;
        imageMissing: string;
    };
    search: {
        eyebrow: string;
        title: string;
        placeholder: string;
        submit: string;
        clear: string;
        resultsFor: (query: string) => string;
        results: (
            from: number | null,
            to: number | null,
            total: number,
        ) => string;
        empty: string;
        prompt: string;
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
            search: 'Filter suchen',
            clearSearch: 'Suche löschen',
            noFilterResults: 'Keine Filter gefunden.',
            relatedTitle: 'Weitere Duftwelten',
        },
        contact: {
            directExchangeBody:
                'Am schnellsten beantworten wir Fragen zu Duftprofil, Größen und Verfügbarkeit über WhatsApp, Telefon, E-Mail oder Social Media.',
            directExchangeTitle: 'Direkter Austausch',
            empty: 'Noch keine Kontaktdaten hinterlegt.',
            eyebrow: 'Kontakt',
            intro: 'Schreiben Sie uns für Produktfragen, verfügbare Größen, aktuelle Angebote oder eine persönliche Empfehlung.',
            open: 'Öffnen',
            openMethod: (method) => `${method} öffnen`,
            pageTitle: 'Kontakt',
            title: 'Direkter Kontakt für Duftberatung.',
            methods: {
                email: 'E-Mail',
                phone: 'Telefon',
                whatsapp: 'WhatsApp',
            },
        },
        cookies: {
            accept: 'Alle akzeptieren',
            analyticsDescription:
                'Hilft uns zu verstehen, welche Seiten und Produkte besucht werden. Google Analytics wird erst nach Ihrer Zustimmung geladen.',
            analyticsTitle: 'Analytics',
            bannerLabel: 'Cookie-Hinweis',
            description:
                'Wir verwenden notwendige Cookies für die Website und optionale Analytics-Cookies, um die Nutzung der Website zu messen.',
            footerSettings: 'Cookie-Einstellungen',
            necessaryDescription:
                'Erforderlich für Grundfunktionen wie Spracheinstellung und gespeicherte Cookie-Auswahl.',
            necessaryTitle: 'Notwendige Cookies',
            privacyLink: 'Datenschutzerklärung',
            reject: 'Alle ablehnen',
            save: 'Auswahl speichern',
            settings: 'Einstellungen',
            settingsDescription:
                'Sie können Analytics jederzeit aktivieren oder deaktivieren. Notwendige Cookies bleiben immer aktiv.',
            settingsTitle: 'Cookie-Einstellungen',
            title: 'Cookies und Datenschutz',
        },
        footer: {
            brand: 'Goan Perfume',
            summary:
                'Produkt-Showcase ohne Online-Shop. Kontakt direkt per WhatsApp, Telefon oder E-Mail.',
            collectionsTitle: 'Kollektionen',
            contactTitle: 'Kontakt',
            contactPage: 'Kontaktseite',
            impressumLink: 'Impressum',
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
            heroSecondary: 'Persönliche Beratung',
            luxuryLink: 'Alle Luxusparfums',
            offersEyebrow: 'Aktionen',
            offersTitle: 'Aktuelle Angebote mit besonderem Duftmoment.',
            whyEyebrow: 'Warum wir',
            whatsappCta: 'WhatsApp öffnen',
        },
        navigation: {
            homepage: 'Homepage',
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
            categoriesTitle: 'Kategorien',
            scentProfile: 'Duftprofil',
            sizeHelp: 'Anfrage basiert auf der ausgewählten Größe.',
            sizeTitle: 'Größe wählen',
        },
        productCard: {
            highlight: 'Highlight',
            imageMissing: 'Kein Bild',
        },
        search: {
            eyebrow: 'Suche',
            title: 'Produkte suchen',
            placeholder: 'Produkte suchen',
            submit: 'Suchen',
            clear: 'Suche löschen',
            resultsFor: (query) => `Ergebnisse für „${query}“`,
            results: (from, to, total) =>
                `Ergebnisse ${from ?? 0}-${to ?? 0} von ${total}`,
            empty: 'Keine Produkte für Ihre Suche gefunden.',
            prompt: 'Geben Sie einen Suchbegriff ein, um Produkte zu finden.',
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
            search: 'Search filters',
            clearSearch: 'Clear search',
            noFilterResults: 'No filters found.',
            relatedTitle: 'More scent worlds',
        },
        contact: {
            directExchangeBody:
                'We answer questions about scent profile, sizes, and availability fastest via WhatsApp, phone, email, or social media.',
            directExchangeTitle: 'Direct exchange',
            empty: 'No contact details have been added yet.',
            eyebrow: 'Contact',
            intro: 'Write to us about product questions, available sizes, current offers, or a personal recommendation.',
            open: 'Open',
            openMethod: (method) => `Open ${method}`,
            pageTitle: 'Contact',
            title: 'Direct contact for fragrance advice.',
            methods: {
                email: 'Email',
                phone: 'Phone',
                whatsapp: 'WhatsApp',
            },
        },
        cookies: {
            accept: 'Accept all',
            analyticsDescription:
                'Helps us understand which pages and products are visited. Google Analytics only loads after your consent.',
            analyticsTitle: 'Analytics',
            bannerLabel: 'Cookie notice',
            description:
                'We use necessary cookies for the website and optional analytics cookies to measure website usage.',
            footerSettings: 'Cookie settings',
            necessaryDescription:
                'Required for basic features such as language preference and saved cookie choice.',
            necessaryTitle: 'Necessary cookies',
            privacyLink: 'Privacy policy',
            reject: 'Reject all',
            save: 'Save selection',
            settings: 'Settings',
            settingsDescription:
                'You can enable or disable analytics at any time. Necessary cookies always remain active.',
            settingsTitle: 'Cookie settings',
            title: 'Cookies and privacy',
        },
        footer: {
            brand: 'Goan Perfume',
            summary:
                'Product showcase without online checkout. Contact us directly by WhatsApp, phone, or email.',
            collectionsTitle: 'Collections',
            contactTitle: 'Contact',
            contactPage: 'Contact page',
            impressumLink: 'Legal notice',
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
            heroSecondary: 'Personal advice',
            luxuryLink: 'All luxury perfumes',
            offersEyebrow: 'Offers',
            offersTitle: 'Current offers with a special fragrance moment.',
            whyEyebrow: 'Why us',
            whatsappCta: 'Open WhatsApp',
        },
        navigation: {
            homepage: 'Homepage',
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
            categoriesTitle: 'Categories',
            scentProfile: 'Scent profile',
            sizeHelp: 'The inquiry is based on the selected size.',
            sizeTitle: 'Choose size',
        },
        productCard: {
            highlight: 'Highlight',
            imageMissing: 'No image',
        },
        search: {
            eyebrow: 'Search',
            title: 'Search products',
            placeholder: 'Search products',
            submit: 'Search',
            clear: 'Clear search',
            resultsFor: (query) => `Results for “${query}”`,
            results: (from, to, total) =>
                `Results ${from ?? 0}-${to ?? 0} of ${total}`,
            empty: 'No products were found for your search.',
            prompt: 'Enter a search term to find products.',
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
            search: 'بحث في الفلاتر',
            clearSearch: 'مسح البحث',
            noFilterResults: 'لم يتم العثور على فلاتر.',
            relatedTitle: 'عوالم عطرية أخرى',
        },
        contact: {
            directExchangeBody:
                'نجيب بسرعة عن الأسئلة المتعلقة بطابع العطر والمقاسات والتوفر عبر واتساب أو الهاتف أو البريد الإلكتروني أو وسائل التواصل.',
            directExchangeTitle: 'تواصل مباشر',
            empty: 'لم تتم إضافة بيانات تواصل بعد.',
            eyebrow: 'التواصل',
            intro: 'راسلنا بخصوص أسئلة المنتجات أو المقاسات المتوفرة أو العروض الحالية أو للحصول على توصية شخصية.',
            open: 'فتح',
            openMethod: (method) => `فتح ${method}`,
            pageTitle: 'التواصل',
            title: 'تواصل مباشر لاستشارة العطور.',
            methods: {
                email: 'البريد الإلكتروني',
                phone: 'الهاتف',
                whatsapp: 'واتساب',
            },
        },
        cookies: {
            accept: 'قبول الكل',
            analyticsDescription:
                'يساعدنا على فهم الصفحات والمنتجات التي تتم زيارتها. لا يتم تحميل Google Analytics إلا بعد موافقتك.',
            analyticsTitle: 'التحليلات',
            bannerLabel: 'إشعار ملفات تعريف الارتباط',
            description:
                'نستخدم ملفات تعريف ارتباط ضرورية للموقع وملفات اختيارية للتحليلات لقياس استخدام الموقع.',
            footerSettings: 'إعدادات ملفات تعريف الارتباط',
            necessaryDescription:
                'ضرورية للوظائف الأساسية مثل تفضيل اللغة وحفظ اختيار ملفات تعريف الارتباط.',
            necessaryTitle: 'ملفات تعريف الارتباط الضرورية',
            privacyLink: 'سياسة الخصوصية',
            reject: 'رفض الكل',
            save: 'حفظ الاختيار',
            settings: 'الإعدادات',
            settingsDescription:
                'يمكنك تفعيل التحليلات أو إيقافها في أي وقت. تبقى الملفات الضرورية مفعلة دائمًا.',
            settingsTitle: 'إعدادات ملفات تعريف الارتباط',
            title: 'ملفات تعريف الارتباط والخصوصية',
        },
        footer: {
            brand: 'Goan Perfume',
            summary:
                'عرض منتجات بدون متجر إلكتروني. تواصل مباشر عبر واتساب أو الهاتف أو البريد الإلكتروني.',
            collectionsTitle: 'المجموعات',
            contactTitle: 'التواصل',
            contactPage: 'صفحة التواصل',
            impressumLink: 'البيانات القانونية',
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
            heroSecondary: 'استشارة شخصية',
            luxuryLink: 'كل العطور الفاخرة',
            offersEyebrow: 'العروض',
            offersTitle: 'عروض حالية مع لحظة عطرية خاصة.',
            whyEyebrow: 'لماذا نحن',
            whatsappCta: 'فتح واتساب',
        },
        navigation: {
            homepage: 'الصفحة الرئيسية',
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
            categoriesTitle: 'الفئات',
            scentProfile: 'طابع العطر',
            sizeHelp: 'يعتمد الاستفسار على المقاس المحدد.',
            sizeTitle: 'اختر المقاس',
        },
        productCard: {
            highlight: 'مميز',
            imageMissing: 'لا توجد صورة',
        },
        search: {
            eyebrow: 'بحث',
            title: 'ابحث عن المنتجات',
            placeholder: 'ابحث عن المنتجات',
            submit: 'بحث',
            clear: 'مسح البحث',
            resultsFor: (query) => `نتائج البحث عن «${query}»`,
            results: (from, to, total) =>
                `النتائج ${from ?? 0}-${to ?? 0} من ${total}`,
            empty: 'لم يتم العثور على منتجات لبحثك.',
            prompt: 'أدخل كلمة للبحث عن المنتجات.',
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
