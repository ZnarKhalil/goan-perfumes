import { Head } from '@inertiajs/react';
import PublicLayout from '@/layouts/public-layout';
import type {
    PublicImpressumPageProps,
    PublicLocaleCode,
} from '@/types/public';

type ImpressumContent = {
    eyebrow: string;
    title: string;
    intro: string;
    placeholderNote: string;
    sections: {
        title: string;
        rows: {
            label: string;
            value: string;
        }[];
    }[];
};

const content: Record<PublicLocaleCode, ImpressumContent> = {
    de: {
        eyebrow: 'Rechtliches',
        title: 'Impressum',
        intro: 'Angaben gemäß § 5 DDG.',
        placeholderNote:
            'Bitte die E-Mail-Adresse vor Veröffentlichung ergänzen.',
        sections: [
            {
                title: 'Anbieter',
                rows: [
                    {
                        label: 'Unternehmen / Betreiber',
                        value: 'Goan Perfume',
                    },
                    {
                        label: 'Anschrift',
                        value: 'Ludwigsplatz 11, 93309 Kelheim, Deutschland',
                    },
                ],
            },
            {
                title: 'Kontakt',
                rows: [
                    {
                        label: 'E-Mail',
                        value: 'info@goanperfume.de',
                    },
                    {
                        label: 'Telefon',
                        value: '+49 157 38149500',
                    },
                ],
            },
        ],
    },
    en: {
        eyebrow: 'Legal',
        title: 'Legal notice',
        intro: 'Provider information according to section 5 DDG.',
        placeholderNote: 'Please add the email address before publication.',
        sections: [
            {
                title: 'Provider',
                rows: [
                    {
                        label: 'Business / operator',
                        value: 'Goan Perfume',
                    },
                    {
                        label: 'Address',
                        value: 'Ludwigsplatz 11, 93309 Kelheim, Germany',
                    },
                ],
            },
            {
                title: 'Contact',
                rows: [
                    {
                        label: 'Email',
                        value: 'info@goanperfume.de',
                    },
                    {
                        label: 'Phone',
                        value: '+49 157 38149500',
                    },
                ],
            },
        ],
    },
    ar: {
        eyebrow: 'قانوني',
        title: 'البيانات القانونية',
        intro: 'معلومات المزوّد وفقاً للمادة 5 من DDG.',
        placeholderNote: 'يرجى إضافة عنوان البريد الإلكتروني قبل النشر.',
        sections: [
            {
                title: 'المزوّد',
                rows: [
                    {
                        label: 'الشركة / المشغّل',
                        value: 'Goan Perfume',
                    },
                    {
                        label: 'العنوان',
                        value: 'Ludwigsplatz 11, 93309 Kelheim, Germany',
                    },
                ],
            },
            {
                title: 'التواصل',
                rows: [
                    {
                        label: 'البريد الإلكتروني',
                        value: 'info@goanperfume.de',
                    },
                    {
                        label: 'الهاتف',
                        value: '+49 157 38149500',
                    },
                ],
            },
        ],
    },
};

export default function Impressum(page: PublicImpressumPageProps) {
    const locale = page.locale?.current ?? 'de';
    const copy = content[locale];

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
        >
            <Head title={page.meta.title}>
                <meta name="description" content={page.meta.description} />
            </Head>

            <section className="px-4 py-16 md:px-8 md:py-24">
                <div className="mx-auto max-w-4xl">
                    <p className="text-[0.7rem] font-semibold tracking-[0.34em] text-stone-500 uppercase">
                        {copy.eyebrow}
                    </p>
                    <h1 className="mt-5 font-display text-5xl leading-tight font-light text-stone-950 md:text-6xl">
                        {copy.title}
                    </h1>
                    <p className="mt-6 max-w-3xl text-base leading-8 text-stone-600">
                        {copy.intro}
                    </p>
                    <p className="mt-5 rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-900">
                        {copy.placeholderNote}
                    </p>
                </div>
            </section>

            <section className="px-4 pb-24 md:px-8 md:pb-32">
                <div className="mx-auto grid max-w-4xl gap-8">
                    {copy.sections.map((section) => (
                        <section
                            key={section.title}
                            className="border-t border-stone-200 pt-8"
                        >
                            <h2 className="font-display text-3xl font-light text-stone-950">
                                {section.title}
                            </h2>
                            <dl className="mt-5 grid gap-4">
                                {section.rows.map((row) => (
                                    <div
                                        key={`${section.title}-${row.label}`}
                                        className="grid gap-1 rounded-lg border border-stone-200 bg-white/55 p-4 md:grid-cols-[14rem_1fr] md:gap-6"
                                    >
                                        <dt className="text-sm font-semibold text-stone-700">
                                            {row.label}
                                        </dt>
                                        <dd className="text-sm leading-6 text-stone-600">
                                            {row.value}
                                        </dd>
                                    </div>
                                ))}
                            </dl>
                        </section>
                    ))}
                </div>
            </section>
        </PublicLayout>
    );
}
