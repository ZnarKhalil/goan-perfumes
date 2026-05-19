import { Head } from '@inertiajs/react';
import { Facebook, Instagram, Mail, Phone, Send, Video } from 'lucide-react';
import PublicLayout from '@/layouts/public-layout';
import { getPublicCopy } from '@/lib/public-copy';
import type {
    PublicContactPageProps,
    PublicContactSettings,
} from '@/types/public';

export default function Contact(page: PublicContactPageProps) {
    const copy = getPublicCopy(page.locale);
    const links = contactLinks(page.contact, copy);

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
        >
            <Head title={copy.contact.pageTitle} />

            <section className="px-4 py-14 md:px-8 md:py-20">
                <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-end">
                    <div>
                        <p className="text-xs tracking-[0.28em] text-stone-500 uppercase">
                            {copy.contact.eyebrow}
                        </p>
                        <h1 className="mt-4 max-w-3xl font-serif text-5xl leading-none text-stone-950 md:text-7xl">
                            {copy.contact.title}
                        </h1>
                    </div>
                    <p className="max-w-2xl text-lg leading-8 text-stone-700">
                        {copy.contact.intro}
                    </p>
                </div>
            </section>

            <section className="px-4 pb-16 md:px-8 md:pb-24">
                <div className="mx-auto grid max-w-7xl gap-px overflow-hidden border border-stone-200 bg-stone-200 md:grid-cols-2 lg:grid-cols-3">
                    {links.length > 0 ? (
                        links.map((link) => {
                            const Icon = link.icon;

                            return (
                                <a
                                    key={link.label}
                                    href={link.href}
                                    className="group grid min-h-48 bg-[#fbf8f2] p-6 transition hover:bg-white"
                                >
                                    <div className="flex items-start justify-between gap-4">
                                        <div>
                                            <p className="text-xs tracking-[0.2em] text-stone-500 uppercase">
                                                {link.label}
                                            </p>
                                            <p className="mt-4 font-serif text-3xl leading-tight break-words text-stone-950">
                                                {link.value}
                                            </p>
                                        </div>
                                        <Icon className="size-5 text-stone-400 transition group-hover:text-stone-950" />
                                    </div>
                                    <p className="mt-auto text-sm text-stone-500">
                                        {copy.contact.open}
                                    </p>
                                </a>
                            );
                        })
                    ) : (
                        <div className="bg-[#fbf8f2] p-6 text-sm text-stone-500 md:col-span-2 lg:col-span-3">
                            {copy.contact.empty}
                        </div>
                    )}
                </div>
            </section>

            <section className="border-t border-stone-200 bg-[#f1eadf] px-4 py-14 md:px-8">
                <div className="mx-auto grid max-w-7xl gap-8 md:grid-cols-[18rem_1fr]">
                    <h2 className="font-serif text-4xl leading-tight text-stone-950">
                        {copy.contact.directExchangeTitle}
                    </h2>
                    <p className="max-w-2xl text-base leading-8 text-stone-700">
                        {copy.contact.directExchangeBody}
                    </p>
                </div>
            </section>
        </PublicLayout>
    );
}

function contactLinks(
    contact: PublicContactSettings,
    copy: ReturnType<typeof getPublicCopy>,
) {
    const links = [
        {
            label: copy.contact.methods.whatsapp,
            value: contact.whatsapp_number,
            href: contact.whatsapp_url,
            icon: Send,
        },
        {
            label: copy.contact.methods.email,
            value: contact.email,
            href: contact.email_url,
            icon: Mail,
        },
        {
            label: copy.contact.methods.phone,
            value: contact.phone,
            href: contact.phone_url,
            icon: Phone,
        },
        {
            label: 'Instagram',
            value: 'Instagram',
            href: contact.instagram_url,
            icon: Instagram,
        },
        {
            label: 'TikTok',
            value: 'TikTok',
            href: contact.tiktok_url,
            icon: Video,
        },
        {
            label: 'Facebook',
            value: 'Facebook',
            href: contact.facebook_url,
            icon: Facebook,
        },
    ];

    return links.filter(
        (link): link is (typeof links)[number] & { href: string } =>
            link.href !== null,
    );
}
