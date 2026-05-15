import { Head, Link } from '@inertiajs/react';
import { ArrowRight, Mail, Phone, Send } from 'lucide-react';
import PublicLayout from '@/layouts/public-layout';
import type {
    PublicCategoryNavItem,
    PublicContactSettings,
    PublicPricingPageProps,
} from '@/types/public';

export default function Pricing(page: PublicPricingPageProps) {
    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
        >
            <Head title="Preise" />

            <section className="px-4 py-14 md:px-8 md:py-20">
                <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[0.95fr_1.05fr] lg:items-end">
                    <div>
                        <p className="text-xs tracking-[0.28em] text-stone-500 uppercase">
                            Preise
                        </p>
                        <h1 className="mt-4 max-w-3xl font-serif text-5xl leading-none text-stone-950 md:text-7xl">
                            Preise nach Duft, Größe und Verfügbarkeit.
                        </h1>
                    </div>
                    <p className="max-w-2xl text-lg leading-8 text-stone-700">
                        Goan Perfume ist ein kuratierter Produkt-Showcase ohne
                        Checkout. Für genaue Preise, Größen und aktuelle
                        Verfügbarkeit kontaktieren Sie uns direkt.
                    </p>
                </div>
            </section>

            <section className="border-y border-stone-200 bg-[#f1eadf] px-4 py-12 md:px-8 md:py-16">
                <div className="mx-auto grid max-w-7xl gap-8 md:grid-cols-[18rem_1fr]">
                    <div>
                        <h2 className="font-serif text-4xl leading-tight text-stone-950">
                            Kategorien
                        </h2>
                        <p className="mt-4 text-sm leading-6 text-stone-600">
                            Direkt in die passende Duftwelt wechseln und dort
                            nach Stil, Familie, Stimmung und Noten filtern.
                        </p>
                    </div>
                    <CategoryDirectory categories={page.categories} />
                </div>
            </section>

            <section className="px-4 py-14 md:px-8 md:py-20">
                <div className="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1fr_1fr]">
                    <div className="border-t border-stone-200 pt-6">
                        <p className="text-sm font-medium text-stone-950">
                            Was beeinflusst den Preis?
                        </p>
                        <dl className="mt-6 grid gap-5">
                            <PriceFactor
                                label="Größe"
                                value="30 ml, 50 ml und 100 ml können unterschiedliche Preise haben."
                            />
                            <PriceFactor
                                label="Duftart"
                                value="Nische, Luxus und arabische Duftkunst unterscheiden sich je nach Komposition."
                            />
                            <PriceFactor
                                label="Verfügbarkeit"
                                value="Limitierte oder frisch eingetroffene Produkte werden direkt bestätigt."
                            />
                        </dl>
                    </div>

                    <PricingContact contact={page.contact} />
                </div>
            </section>
        </PublicLayout>
    );
}

function CategoryDirectory({
    categories,
}: {
    categories: PublicCategoryNavItem[];
}) {
    if (categories.length === 0) {
        return (
            <div className="border border-dashed border-stone-300 px-6 py-10 text-sm text-stone-500">
                Noch keine Kategorien veröffentlicht.
            </div>
        );
    }

    return (
        <div className="grid gap-px overflow-hidden border border-stone-200 bg-stone-200 md:grid-cols-2">
            {categories.map((category) => (
                <Link
                    key={category.id}
                    href={category.href}
                    className="group grid min-h-32 bg-[#fbf8f2] p-5 transition hover:bg-white"
                >
                    <div className="flex items-start justify-between gap-4">
                        <span className="font-serif text-2xl leading-tight text-stone-950">
                            {category.name}
                        </span>
                        <ArrowRight className="mt-1 size-4 text-stone-400 transition group-hover:translate-x-1 group-hover:text-stone-950" />
                    </div>
                    <span className="mt-auto text-sm text-stone-500">
                        Produkte ansehen
                    </span>
                </Link>
            ))}
        </div>
    );
}

function PriceFactor({ label, value }: { label: string; value: string }) {
    return (
        <div className="grid gap-2 border-b border-stone-200 pb-5 md:grid-cols-[9rem_1fr]">
            <dt className="text-sm text-stone-500">{label}</dt>
            <dd className="text-base leading-7 text-stone-800">{value}</dd>
        </div>
    );
}

function PricingContact({ contact }: { contact: PublicContactSettings }) {
    const links = [
        {
            label: 'WhatsApp',
            href: contact.whatsapp_url,
            value: contact.whatsapp_number,
            icon: Send,
        },
        {
            label: 'Telefon',
            href: contact.phone_url,
            value: contact.phone,
            icon: Phone,
        },
        {
            label: 'E-Mail',
            href: contact.email_url,
            value: contact.email,
            icon: Mail,
        },
    ].filter((link) => link.href);

    return (
        <div className="bg-stone-950 p-6 text-white md:p-8">
            <p className="text-xs tracking-[0.22em] text-white/50 uppercase">
                Direktkontakt
            </p>
            <h2 className="mt-4 font-serif text-4xl leading-tight">
                Preis und Verfügbarkeit anfragen.
            </h2>
            <div className="mt-8 grid gap-3">
                {links.length > 0 ? (
                    links.map((link) => {
                        const Icon = link.icon;

                        return (
                            <a
                                key={link.label}
                                href={link.href ?? undefined}
                                className="flex items-center justify-between gap-4 border border-white/20 px-4 py-3 text-sm transition hover:bg-white hover:text-stone-950"
                            >
                                <span>
                                    <span className="block font-medium">
                                        {link.label}
                                    </span>
                                    {link.value && (
                                        <span className="mt-1 block text-white/60">
                                            {link.value}
                                        </span>
                                    )}
                                </span>
                                <Icon className="size-4" />
                            </a>
                        );
                    })
                ) : (
                    <p className="text-sm leading-6 text-white/60">
                        Noch keine Kontaktdaten hinterlegt.
                    </p>
                )}
            </div>
        </div>
    );
}
