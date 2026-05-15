import { Link } from '@inertiajs/react';
import type { ReactNode } from 'react';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import type { PublicCategoryNavItem } from '@/types/public';

type Props = {
    navigation: PublicCategoryNavItem[];
    trigger: ReactNode;
};

export default function SiteDrawer({ navigation, trigger }: Props) {
    return (
        <Sheet>
            <SheetTrigger asChild>{trigger}</SheetTrigger>
            <SheetContent
                side="left"
                className="w-[86vw] max-w-sm border-stone-200 bg-[#f8f3eb] px-0 text-stone-950"
            >
                <SheetHeader className="border-b border-stone-200 px-6 py-5 text-left">
                    <SheetTitle className="font-serif text-2xl">
                        القائمه
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
                        href="/kontakt"
                        className="border-b border-stone-200 py-4 text-lg font-medium transition hover:text-stone-500"
                    >
                        Kontakt
                    </Link>
                </nav>
            </SheetContent>
        </Sheet>
    );
}
