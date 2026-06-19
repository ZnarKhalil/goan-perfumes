import {
    Facebook,
    Instagram,
    Mail,
    Phone,
    Send,
    Video,
} from '@/components/public/icons';
import PublicHead from '@/components/public/public-head';
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
            theme="dark"
        >
            <PublicHead meta={page.meta} />

            <section className="px-4 pt-28 pb-14 md:px-8 md:pt-36 md:pb-20">
                <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-end">
                    <div>
                        <p className="flex items-center gap-3 text-[0.7rem] font-semibold tracking-[0.38em] text-[#e7c889] uppercase">
                            <span className="vitrine-pulse inline-block size-2 rounded-full bg-[#e7c889]" />
                            {copy.contact.eyebrow}
                        </p>
                        <h1 className="mt-5 max-w-3xl font-display text-5xl leading-[1.02] font-light text-stone-50 md:text-7xl">
                            {copy.contact.title}
                        </h1>
                    </div>
                    <p className="max-w-2xl text-lg leading-8 text-stone-300">
                        {copy.contact.intro}
                    </p>
                </div>
            </section>

            <section className="px-4 pb-16 md:px-8 md:pb-24">
                <div className="mx-auto grid max-w-7xl gap-4 md:grid-cols-2 lg:grid-cols-3">
                    {links.length > 0 ? (
                        links.map((link) => {
                            const Icon = link.icon;
                            const isExternal = link.href.startsWith('http');

                            return (
                                <a
                                    key={link.label}
                                    href={link.href}
                                    target={isExternal ? '_blank' : undefined}
                                    rel={isExternal ? 'noreferrer' : undefined}
                                    className="group grid min-h-48 rounded-[1.4rem] border border-white/10 bg-white/[0.035] p-6 backdrop-blur-xl transition-colors duration-500 hover:border-[#e7c889]/40 hover:bg-white/[0.06]"
                                >
                                    <div className="flex items-start justify-between gap-4">
                                        <div>
                                            <p className="text-[0.7rem] tracking-[0.22em] text-[#e7c889] uppercase">
                                                {link.label}
                                            </p>
                                            <p className="mt-4 font-display text-3xl leading-tight break-words text-stone-50">
                                                {link.value}
                                            </p>
                                        </div>
                                        <Icon className="size-5 text-stone-500 transition group-hover:text-[#e7c889]" />
                                    </div>
                                    <p className="mt-auto text-sm text-stone-400">
                                        {copy.contact.openMethod(link.label)}
                                    </p>
                                </a>
                            );
                        })
                    ) : (
                        <div className="rounded-[1.4rem] border border-white/10 bg-white/[0.035] p-6 text-sm text-stone-400 md:col-span-2 lg:col-span-3">
                            {copy.contact.empty}
                        </div>
                    )}
                </div>
            </section>

            <section className="px-4 pb-24 md:px-8 md:pb-32">
                <div className="mx-auto grid max-w-7xl gap-8 rounded-[2rem] border border-white/10 bg-white/[0.03] px-6 py-14 backdrop-blur-xl md:grid-cols-[18rem_1fr] md:px-12">
                    <h2 className="font-display text-4xl leading-tight font-light text-stone-50">
                        {copy.contact.directExchangeTitle}
                    </h2>
                    <p className="max-w-2xl text-base leading-8 text-stone-300">
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
