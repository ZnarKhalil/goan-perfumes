import { Link, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import CookieConsent from '@/components/public/cookie-consent';
import FloatingContactSidebar from '@/components/public/floating-contact-sidebar';
import { Facebook, Instagram, Music2 } from '@/components/public/icons';
import SiteHeader from '@/components/public/site-header';
import { getPublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicLayoutProps } from '@/types/public';

export default function PublicLayout({
    navigation,
    contact,
    logo_url,
    locale,
    theme = 'light',
    children,
}: PublicLayoutProps) {
    const { url } = usePage();
    const copy = getPublicCopy(locale);
    const direction = locale?.dir ?? 'ltr';
    const isDark = theme === 'dark';
    const isArabic = locale?.current === 'ar';
    const privacyHref = locale
        ? `/${locale.current}/datenschutz`
        : '/datenschutz';
    const impressumHref = locale
        ? `/${locale.current}/impressum`
        : '/impressum';
    const termsHref = locale ? `/${locale.current}/agb` : '/agb';
    const footerSocialLinks = [
        {
            label: 'Instagram',
            href: contact.instagram_url,
            icon: Instagram,
        },
        {
            label: 'TikTok',
            href: contact.tiktok_url,
            icon: Music2,
        },
        {
            label: 'Facebook',
            href: contact.facebook_url,
            icon: Facebook,
        },
    ];
    const socialLinks = footerSocialLinks.filter(
        (link): link is (typeof footerSocialLinks)[number] & { href: string } =>
            link.href !== null,
    );

    useEffect(() => {
        document.body.style.pointerEvents = '';
        document.body.style.overflow = '';
        document.body.removeAttribute('data-scroll-locked');
        document
            .querySelectorAll(
                '[data-slot="sheet-overlay"], [data-slot="dropdown-menu-content"]',
            )
            .forEach((element) => element.remove());
    }, [url]);

    return (
        <div
            dir={direction}
            className={cn(
                'min-h-screen font-body antialiased',
                'max-w-full overflow-x-clip',
                isArabic && 'font-arabic',
                isDark
                    ? 'bg-[#0b0907] text-stone-100'
                    : 'bg-[#fbf8f2] text-stone-950',
            )}
        >
            <SiteHeader
                navigation={navigation}
                logoUrl={logo_url}
                locale={locale}
                copy={copy}
                theme={theme}
            />
            <main>{children}</main>
            <FloatingContactSidebar contact={contact} copy={copy} />
            <footer
                className={cn(
                    'px-4 pt-14 pb-24 text-sm md:px-8 md:pb-10',
                    isDark
                        ? 'border-t border-white/10 bg-[#0b0907] text-stone-400'
                        : 'border-t border-stone-200 text-stone-500',
                )}
            >
                <div className="mx-auto grid max-w-7xl gap-10 md:grid-cols-[1.4fr_1fr_1fr] md:gap-8">
                    <div className="max-w-sm">
                        <p
                            className={cn(
                                'font-display text-xl tracking-wide',
                                isDark ? 'text-stone-100' : 'text-stone-800',
                            )}
                        >
                            {copy.footer.brand}
                        </p>
                        <p className="mt-4 leading-7">{copy.footer.summary}</p>
                    </div>

                    {navigation.length > 0 && (
                        <nav aria-label={copy.footer.collectionsTitle}>
                            <p
                                className={cn(
                                    'text-[0.65rem] font-semibold tracking-[0.3em] uppercase',
                                    isDark
                                        ? 'text-stone-300'
                                        : 'text-stone-600',
                                )}
                            >
                                {copy.footer.collectionsTitle}
                            </p>
                            <ul className="mt-4 space-y-2.5">
                                {navigation.map((category) => (
                                    <li key={category.id}>
                                        <Link
                                            href={category.href}
                                            className={cn(
                                                'transition-colors duration-300',
                                                isDark
                                                    ? 'hover:text-[#e7c889]'
                                                    : 'hover:text-stone-900',
                                            )}
                                        >
                                            {category.name}
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </nav>
                    )}

                    <div>
                        <p
                            className={cn(
                                'text-[0.65rem] font-semibold tracking-[0.3em] uppercase',
                                isDark ? 'text-stone-300' : 'text-stone-600',
                            )}
                        >
                            {copy.footer.contactTitle}
                        </p>
                        <ul className="mt-4 space-y-2.5">
                            {contact.whatsapp_url && (
                                <li>
                                    <a
                                        href={contact.whatsapp_url}
                                        target="_blank"
                                        rel="noreferrer"
                                        className={cn(
                                            'transition-colors duration-300',
                                            isDark
                                                ? 'hover:text-[#e7c889]'
                                                : 'hover:text-stone-900',
                                        )}
                                    >
                                        {copy.contact.methods.whatsapp}
                                    </a>
                                </li>
                            )}
                            {contact.email_url && contact.email && (
                                <li>
                                    <a
                                        href={contact.email_url}
                                        className={cn(
                                            'transition-colors duration-300',
                                            isDark
                                                ? 'hover:text-[#e7c889]'
                                                : 'hover:text-stone-900',
                                        )}
                                    >
                                        {contact.email}
                                    </a>
                                </li>
                            )}
                            {contact.phone_url && contact.phone && (
                                <li>
                                    <a
                                        href={contact.phone_url}
                                        dir="ltr"
                                        className={cn(
                                            'transition-colors duration-300',
                                            isDark
                                                ? 'hover:text-[#e7c889]'
                                                : 'hover:text-stone-900',
                                        )}
                                    >
                                        {contact.phone}
                                    </a>
                                </li>
                            )}
                            <li>
                                <Link
                                    href={
                                        locale
                                            ? `/${locale.current}/kontakt`
                                            : '/kontakt'
                                    }
                                    className={cn(
                                        'transition-colors duration-300',
                                        isDark
                                            ? 'hover:text-[#e7c889]'
                                            : 'hover:text-stone-900',
                                    )}
                                >
                                    {copy.footer.contactPage}
                                </Link>
                            </li>
                        </ul>

                        {socialLinks.length > 0 && (
                            <div className="mt-6 flex flex-wrap gap-2">
                                {socialLinks.map((item) => {
                                    const Icon = item.icon;

                                    return (
                                        <a
                                            key={item.label}
                                            href={item.href}
                                            target="_blank"
                                            rel="noreferrer"
                                            className={cn(
                                                'flex size-10 items-center justify-center rounded-full border transition-colors duration-300',
                                                isDark
                                                    ? 'border-white/15 text-stone-300 hover:border-[#e7c889] hover:bg-[#e7c889] hover:text-stone-950'
                                                    : 'border-stone-300 text-stone-600 hover:border-stone-900 hover:bg-stone-900 hover:text-stone-50',
                                            )}
                                            aria-label={item.label}
                                        >
                                            <Icon className="size-4" />
                                        </a>
                                    );
                                })}
                            </div>
                        )}
                    </div>
                </div>

                <div
                    className={cn(
                        'mx-auto mt-12 flex max-w-7xl flex-col gap-3 border-t pt-6 text-xs sm:flex-row sm:items-center sm:justify-between',
                        isDark ? 'border-white/10' : 'border-stone-200',
                    )}
                >
                    <p>
                        © {new Date().getFullYear()} {copy.footer.brand}
                    </p>
                    <div className="flex flex-wrap items-center gap-4">
                        <Link
                            href={impressumHref}
                            className={cn(
                                'transition-colors duration-300',
                                isDark
                                    ? 'hover:text-[#e7c889]'
                                    : 'hover:text-stone-900',
                            )}
                        >
                            {copy.footer.impressumLink}
                        </Link>
                        <Link
                            href={privacyHref}
                            className={cn(
                                'transition-colors duration-300',
                                isDark
                                    ? 'hover:text-[#e7c889]'
                                    : 'hover:text-stone-900',
                            )}
                        >
                            {copy.cookies.privacyLink}
                        </Link>
                        <Link
                            href={termsHref}
                            className={cn(
                                'transition-colors duration-300',
                                isDark
                                    ? 'hover:text-[#e7c889]'
                                    : 'hover:text-stone-900',
                            )}
                        >
                            {copy.footer.termsLink}
                        </Link>
                        <CookieConsent
                            copy={copy}
                            privacyHref={privacyHref}
                            theme={theme}
                        />
                    </div>
                </div>
            </footer>
        </div>
    );
}
