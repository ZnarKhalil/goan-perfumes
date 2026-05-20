import FloatingContactSidebar from '@/components/public/floating-contact-sidebar';
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
    const copy = getPublicCopy(locale);
    const direction = locale?.dir ?? 'ltr';
    const isDark = theme === 'dark';
    const isArabic = locale?.current === 'ar';

    return (
        <div
            dir={direction}
            className={cn(
                'min-h-screen font-body antialiased',
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
                    'px-4 py-10 text-sm md:px-8',
                    isDark
                        ? 'border-t border-white/10 bg-[#0b0907] text-stone-400'
                        : 'border-t border-stone-200 text-stone-500',
                )}
            >
                <div className="mx-auto flex max-w-7xl flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <p
                        className={cn(
                            'font-display text-base tracking-wide',
                            isDark ? 'text-stone-200' : 'text-stone-700',
                        )}
                    >
                        {copy.footer.brand}
                    </p>
                    <p>{copy.footer.summary}</p>
                </div>
            </footer>
        </div>
    );
}
