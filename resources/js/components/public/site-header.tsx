import { Link } from '@inertiajs/react';
import { Menu } from 'lucide-react';
import { useEffect, useState } from 'react';
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
            <div className="grid h-16 grid-cols-[1fr_auto_1fr] items-center px-4 md:h-20 md:px-8">
                <div className="flex items-center">
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
                    className="flex items-center justify-center text-center"
                    aria-label={copy.aria.goHome}
                >
                    {logoUrl ? (
                        <img
                            src={logoUrl}
                            alt="Goan Perfume"
                            className={cn(
                                'max-h-10 w-auto transition',
                                isDark && 'brightness-0 invert',
                            )}
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

                <div className="flex items-center justify-end gap-2">
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
