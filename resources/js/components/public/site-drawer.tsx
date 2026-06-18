import { Link } from '@inertiajs/react';
import { useState } from 'react';
import type { ReactNode } from 'react';
import LocaleSwitcher from '@/components/public/locale-switcher';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicCategoryNavItem } from '@/types/public';
import type { PublicLocaleProps } from '@/types/public';

type Props = {
    navigation: PublicCategoryNavItem[];
    locale?: PublicLocaleProps;
    homeHref: string;
    contactHref: string;
    copy: PublicCopy;
    trigger: ReactNode;
};

export default function SiteDrawer({
    navigation,
    locale,
    homeHref,
    contactHref,
    copy,
    trigger,
}: Props) {
    const [open, setOpen] = useState(false);
    const isRtl = locale?.dir === 'rtl';
    const closeDrawer = () => setOpen(false);

    return (
        <Sheet open={open} onOpenChange={setOpen}>
            <SheetTrigger asChild>{trigger}</SheetTrigger>
            <SheetContent
                side={isRtl ? 'right' : 'left'}
                className="w-[86vw] max-w-sm border-white/10 bg-[#0b0907] px-0 text-stone-100"
            >
                <SheetHeader
                    className={cn(
                        'border-b border-white/10 px-6 py-5',
                        isRtl ? 'text-right' : 'text-left',
                    )}
                >
                    <SheetTitle className="font-display text-2xl text-stone-50">
                        {copy.aria.mobileMenuTitle}
                    </SheetTitle>
                    <SheetDescription className="sr-only">
                        {copy.aria.mobileMenuTitle}
                    </SheetDescription>
                </SheetHeader>
                <nav className="grid px-6 py-6">
                    <Link
                        href={homeHref}
                        onClick={closeDrawer}
                        className="border-b border-white/10 py-4 text-lg font-medium transition hover:text-[#e7c889]"
                    >
                        {copy.navigation.homepage}
                    </Link>
                    {navigation.map((category) => (
                        <Link
                            key={category.slug}
                            href={category.href}
                            onClick={closeDrawer}
                            className="border-b border-white/10 py-4 text-lg font-medium transition hover:text-[#e7c889]"
                        >
                            {category.name}
                        </Link>
                    ))}
                    <Link
                        href={contactHref}
                        onClick={closeDrawer}
                        className="py-4 text-lg font-medium transition hover:text-[#e7c889]"
                    >
                        {copy.contact.eyebrow}
                    </Link>
                </nav>
                <div className="px-6 py-5">
                    <LocaleSwitcher
                        locale={locale}
                        compact
                        tone="dark"
                        onNavigate={closeDrawer}
                        reloadDocument
                        navigateDelayMs={220}
                    />
                </div>
            </SheetContent>
        </Sheet>
    );
}
