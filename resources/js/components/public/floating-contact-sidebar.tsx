import { Link } from '@inertiajs/react';
import {
    Facebook,
    Instagram,
    Mail,
    MessageCircle,
    Music2,
    Phone,
} from 'lucide-react';
import { cn } from '@/lib/utils';
import type { PublicContactSettings } from '@/types/public';

type Props = {
    contact: PublicContactSettings;
    className?: string;
};

export default function FloatingContactSidebar({ contact, className }: Props) {
    const links = [
        {
            label: 'WhatsApp',
            href: contact.whatsapp_url,
            icon: MessageCircle,
        },
        {
            label: 'E-Mail',
            href: contact.email_url,
            icon: Mail,
        },
        {
            label: 'Telefon',
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
                    className="fixed right-4 bottom-4 z-40 flex size-14 items-center justify-center rounded-full bg-stone-950 text-white shadow-lg shadow-stone-950/25 transition hover:bg-stone-800 md:hidden"
                    aria-label="WhatsApp"
                >
                    <MessageCircle className="size-6" />
                </Link>
            )}

            {links.length > 0 && (
                <aside
                    className={cn(
                        'fixed top-1/2 right-0 z-30 hidden -translate-y-1/2 flex-col border border-r-0 border-stone-200 bg-[#fbf8f2]/95 shadow-sm backdrop-blur md:flex',
                        className,
                    )}
                    aria-label="Kontakt"
                >
                    {links.map((item) => {
                        const Icon = item.icon;

                        return (
                            <Link
                                key={item.label}
                                href={item.href ?? '#'}
                                className="flex size-11 items-center justify-center border-b border-stone-200 text-stone-700 transition last:border-b-0 hover:bg-stone-950 hover:text-white"
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
