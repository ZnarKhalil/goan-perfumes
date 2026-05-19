import { Link } from '@inertiajs/react';
import { Check, ChevronDown } from 'lucide-react';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { getPublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicLocaleProps } from '@/types/public';

type Props = {
    locale?: PublicLocaleProps;
    compact?: boolean;
    tone?: 'light' | 'dark';
};

export default function LocaleSwitcher({
    locale,
    compact = false,
    tone = 'light',
}: Props) {
    if (!locale) {
        return null;
    }

    const isDark = tone === 'dark';

    const copy = getPublicCopy(locale);
    const currentLocale =
        locale.supported.find((item) => item.code === locale.current) ??
        locale.supported[0];

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <button
                    type="button"
                    aria-label={copy.aria.localeSwitcher}
                    className={cn(
                        'inline-flex h-9 items-center justify-between gap-2 rounded-full border px-3 text-sm font-medium transition',
                        isDark
                            ? 'border-white/15 bg-white/8 text-stone-100 backdrop-blur hover:border-[#e7c889]/50 hover:text-white'
                            : 'border-stone-200 bg-white/60 text-stone-800 hover:border-stone-300 hover:bg-white hover:text-stone-950',
                        compact ? 'w-full' : 'min-w-32',
                    )}
                >
                    <span>{currentLocale.native_label}</span>
                    <ChevronDown className="size-3.5 text-stone-500" />
                </button>
            </DropdownMenuTrigger>
            <DropdownMenuContent
                align={compact ? 'start' : 'end'}
                className={cn(
                    'min-w-40 p-1',
                    isDark
                        ? 'border-white/10 bg-[#0b0907] text-stone-100'
                        : 'border-stone-200 bg-[#fbf8f2] text-stone-950',
                )}
            >
                {locale.supported.map((item) => {
                    const active = item.code === locale.current;
                    const href = locale.switcher_urls[item.code] ?? '#';

                    return (
                        <DropdownMenuItem key={item.code} asChild>
                            <Link
                                href={href}
                                aria-label={copy.aria.showLocale(
                                    item.native_label,
                                )}
                                aria-current={active ? 'page' : undefined}
                                className={cn(
                                    'flex cursor-pointer items-center justify-between gap-3 rounded px-3 py-2 text-sm font-medium transition',
                                    isDark
                                        ? active
                                            ? 'text-[#e7c889] focus:bg-white/10'
                                            : 'text-stone-300 hover:text-stone-50 focus:bg-white/10'
                                        : active
                                          ? 'text-stone-950 focus:bg-stone-100'
                                          : 'text-stone-600 hover:text-stone-950 focus:bg-stone-100',
                                )}
                            >
                                <span>{item.native_label}</span>
                                {active && <Check className="size-4" />}
                            </Link>
                        </DropdownMenuItem>
                    );
                })}
            </DropdownMenuContent>
        </DropdownMenu>
    );
}
