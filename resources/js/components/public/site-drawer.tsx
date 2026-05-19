import { Link } from '@inertiajs/react';
import type { ReactNode } from 'react';
import LocaleSwitcher from '@/components/public/locale-switcher';
import {
    Sheet,
    SheetContent,
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
    contactHref: string;
    copy: PublicCopy;
    trigger: ReactNode;
};

export default function SiteDrawer({
    navigation,
    locale,
    contactHref,
    copy,
    trigger,
}: Props) {
    const isRtl = locale?.dir === 'rtl';

    return (
        <Sheet>
            <SheetTrigger asChild>{trigger}</SheetTrigger>
            <SheetContent
                side={isRtl ? 'right' : 'left'}
                className="w-[86vw] max-w-sm border-stone-200 bg-[#f8f3eb] px-0 text-stone-950"
            >
                <SheetHeader
                    className={cn(
                        'border-b border-stone-200 px-6 py-5',
                        isRtl ? 'text-right' : 'text-left',
                    )}
                >
                    <SheetTitle className="font-serif text-2xl">
                        {copy.aria.mobileMenuTitle}
                    </SheetTitle>
                </SheetHeader>
                <nav className="grid px-6 py-6">
                    {navigation.slice(0, 4).map((category) => (
                        <Link
                            key={category.slug}
                            href={category.href}
                            className="border-b border-stone-200 py-4 text-lg font-medium transition hover:text-stone-500"
                        >
                            {category.name}
                        </Link>
                    ))}
                    <Link
                        href={contactHref}
                        className="border-b border-stone-200 py-4 text-lg font-medium transition hover:text-stone-500"
                    >
                        {copy.contact.eyebrow}
                    </Link>
                </nav>
                <div className="border-t border-stone-200 px-6 py-5">
                    <LocaleSwitcher locale={locale} compact />
                </div>
            </SheetContent>
        </Sheet>
    );
}
