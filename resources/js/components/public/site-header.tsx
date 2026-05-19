import { Link } from '@inertiajs/react';
import { Menu, ShoppingBag } from 'lucide-react';
import LocaleSwitcher from '@/components/public/locale-switcher';
import SiteDrawer from '@/components/public/site-drawer';
import type { PublicCopy } from '@/lib/public-copy';
import type {
    PublicCategoryNavItem,
    PublicContactSettings,
    PublicLocaleProps,
} from '@/types/public';

type Props = {
    navigation: PublicCategoryNavItem[];
    contact: PublicContactSettings;
    logoUrl: string | null;
    locale?: PublicLocaleProps;
    copy: PublicCopy;
};

export default function SiteHeader({
    navigation,
    contact,
    logoUrl,
    locale,
    copy,
}: Props) {
    const homeHref = locale ? `/${locale.current}` : '/';
    const contactHref = locale ? `/${locale.current}/kontakt` : '/kontakt';

    return (
        <header className="sticky top-0 z-40 border-b border-stone-200/80 bg-[#fbf8f2]/90 backdrop-blur">
            <div className="grid h-16 grid-cols-[1fr_auto_1fr] items-center px-4 md:h-20 md:px-8">
                <div className="flex items-center">
                    <SiteDrawer
                        navigation={navigation}
                        locale={locale}
                        contactHref={contactHref}
                        copy={copy}
                        trigger={
                            <button
                                type="button"
                                className="inline-flex size-10 items-center justify-center text-stone-950 transition hover:text-stone-500"
                                aria-label={copy.aria.mobileMenu}
                            >
                                <Menu className="size-5" />
                            </button>
                        }
                    />
                </div>

                <Link
                    href={homeHref}
                    className="flex items-center justify-center text-center"
                    aria-label={copy.aria.goHome}
                >
                    {logoUrl ? (
                        <img
                            src={logoUrl}
                            alt="Goan Perfume"
                            className="max-h-10 w-auto"
                        />
                    ) : (
                        <span className="font-serif text-xl tracking-[0.18em] text-stone-950 uppercase md:text-2xl">
                            Goan
                        </span>
                    )}
                </Link>

                <div className="flex items-center justify-end gap-2">
                    <div className="hidden md:block">
                        <LocaleSwitcher locale={locale} />
                    </div>
                    {contact.whatsapp_url && (
                        <Link
                            href={contact.whatsapp_url}
                            className="hidden text-sm font-medium text-stone-700 transition hover:text-stone-950 sm:inline"
                        >
                            WhatsApp
                        </Link>
                    )}
                    <button
                        type="button"
                        className="inline-flex size-10 items-center justify-center text-stone-950 opacity-60"
                        aria-label={copy.aria.cartUnavailable}
                        disabled
                    >
                        <ShoppingBag className="size-5" />
                    </button>
                </div>
            </div>
        </header>
    );
}
