import { Link } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { Menu } from '@/components/public/icons';
import LocaleSwitcher from '@/components/public/locale-switcher';
import SiteDrawer from '@/components/public/site-drawer';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type {
    PublicCategoryNavItem,
    PublicLocaleProps,
    PublicSurfaceTheme,
} from '@/types/public';

type Props = {
    navigation: PublicCategoryNavItem[];
    logoUrl: string | null;
    locale?: PublicLocaleProps;
    copy: PublicCopy;
    theme?: PublicSurfaceTheme;
};

export default function SiteHeader({
    navigation,
    logoUrl,
    locale,
    copy,
    theme = 'light',
}: Props) {
    const homeHref = locale ? `/${locale.current}` : '/';
    const contactHref = locale ? `/${locale.current}/kontakt` : '/kontakt';
    const isDark = theme === 'dark';
    const [scrolled, setScrolled] = useState(false);

    useEffect(() => {
        if (!isDark) {
            return;
        }

        const onScroll = () => setScrolled(window.scrollY > 24);

        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        return () => window.removeEventListener('scroll', onScroll);
    }, [isDark]);

    return (
        <header
            className={cn(
                'sticky top-0 z-40 transition-[background-color,border-color,backdrop-filter] duration-500',
                isDark
                    ? scrolled
                        ? 'border-b border-white/10 bg-[#0b0907]/80 backdrop-blur-xl'
                        : 'border-b border-transparent bg-transparent'
                    : 'border-b border-stone-200/80 bg-[#fbf8f2]/90 backdrop-blur',
            )}
        >
            <div className="grid h-16 grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] items-center px-4 md:h-20 md:px-8">
                <div className="flex min-w-0 items-center">
                    <SiteDrawer
                        navigation={navigation}
                        homeHref={homeHref}
                        locale={locale}
                        contactHref={contactHref}
                        copy={copy}
                        trigger={
                            <button
                                type="button"
                                className={cn(
                                    'inline-flex size-10 items-center justify-center transition',
                                    isDark
                                        ? 'text-stone-100 hover:text-[#e7c889]'
                                        : 'text-stone-950 hover:text-stone-500',
                                )}
                                aria-label={copy.aria.mobileMenu}
                            >
                                <Menu className="size-5" />
                            </button>
                        }
                    />
                </div>

                <Link
                    href={homeHref}
                    className="flex max-w-[min(12rem,48vw)] min-w-0 items-center justify-center text-center"
                    aria-label={copy.aria.goHome}
                >
                    {logoUrl ? (
                        <img
                            src={logoUrl}
                            alt="Goan Perfume"
                            className="max-h-10 max-w-full object-contain transition"
                        />
                    ) : (
                        <span
                            className={cn(
                                'font-display text-xl tracking-[0.22em] uppercase md:text-2xl',
                                isDark ? 'text-stone-50' : 'text-stone-950',
                            )}
                        >
                            Goan
                        </span>
                    )}
                </Link>

                <div className="flex min-w-0 items-center justify-end gap-2">
                    <div className="hidden md:block">
                        <LocaleSwitcher
                            locale={locale}
                            tone={isDark ? 'dark' : 'light'}
                        />
                    </div>
                </div>
            </div>
        </header>
    );
}
