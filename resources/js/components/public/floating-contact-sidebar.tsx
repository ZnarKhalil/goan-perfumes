import { Link } from '@inertiajs/react';
import {
    Facebook,
    Instagram,
    Mail,
    MessageCircle,
    Music2,
    Phone,
} from 'lucide-react';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicContactSettings } from '@/types/public';

type Props = {
    contact: PublicContactSettings;
    copy: PublicCopy;
    className?: string;
};

export default function FloatingContactSidebar({
    contact,
    copy,
    className,
}: Props) {
    const links = [
        {
            label: copy.contact.methods.whatsapp,
            href: contact.whatsapp_url,
            icon: MessageCircle,
        },
        {
            label: copy.contact.methods.email,
            href: contact.email_url,
            icon: Mail,
        },
        {
            label: copy.contact.methods.phone,
            href: contact.phone_url,
            icon: Phone,
        },
        {
            label: 'TikTok',
            href: contact.tiktok_url,
            icon: Music2,
        },
        {
            label: 'Instagram',
            href: contact.instagram_url,
            icon: Instagram,
        },
        {
            label: 'Facebook',
            href: contact.facebook_url,
            icon: Facebook,
        },
    ].filter((item) => item.href);

    if (links.length === 0 && !contact.whatsapp_url) {
        return null;
    }

    return (
        <>
            {contact.whatsapp_url && (
                <Link
                    href={contact.whatsapp_url}
                    className="fixed right-4 bottom-4 z-40 flex size-14 items-center justify-center rounded-full bg-[#e7c889] text-stone-950 shadow-lg shadow-black/40 transition hover:bg-[#f0dca0] md:hidden"
                    aria-label={links[0]?.label ?? 'WhatsApp'}
                >
                    <MessageCircle className="size-6" />
                </Link>
            )}

            {links.length > 0 && (
                <aside
                    className={cn(
                        'fixed top-1/2 right-0 z-30 hidden -translate-y-1/2 flex-col overflow-hidden rounded-l-2xl border border-r-0 border-white/10 bg-white/[0.04] shadow-lg shadow-black/30 backdrop-blur-xl md:flex',
                        className,
                    )}
                    aria-label={copy.aria.contactSidebar}
                >
                    {links.map((item) => {
                        const Icon = item.icon;

                        return (
                            <Link
                                key={item.label}
                                href={item.href ?? '#'}
                                className="flex size-11 items-center justify-center border-b border-white/10 text-stone-300 transition last:border-b-0 hover:bg-[#e7c889] hover:text-stone-950"
                                aria-label={item.label}
                            >
                                <Icon className="size-4" />
                            </Link>
                        );
                    })}
                </aside>
            )}
        </>
    );
}
