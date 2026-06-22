import { router } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import { Search, X } from '@/components/public/icons';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicLocaleProps, PublicSurfaceTheme } from '@/types/public';

type Props = {
    locale?: PublicLocaleProps;
    copy: PublicCopy;
    tone?: PublicSurfaceTheme;
    initialQuery?: string;
    autoFocus?: boolean;
    className?: string;
    onSubmitted?: () => void;
};

export default function SearchForm({
    locale,
    copy,
    tone = 'light',
    initialQuery = '',
    autoFocus = false,
    className,
    onSubmitted,
}: Props) {
    const [query, setQuery] = useState(initialQuery);
    const isDark = tone === 'dark';
    const searchHref = locale ? `/${locale.current}/suche` : '/suche';

    const handleSubmit = (event: FormEvent<HTMLFormElement>): void => {
        event.preventDefault();
        const term = query.trim();

        if (term === '') {
            return;
        }

        router.get(searchHref, { q: term });
        onSubmitted?.();
    };

    return (
        <form
            role="search"
            onSubmit={handleSubmit}
            className={cn(
                'flex h-10 items-center gap-2 rounded-full border px-3 transition-colors',
                isDark
                    ? 'border-white/15 bg-white/[0.04] text-stone-100 focus-within:border-[#e7c889]/60'
                    : 'border-stone-300 bg-white/70 text-stone-900 focus-within:border-stone-900',
                className,
            )}
        >
            <input
                type="search"
                value={query}
                onChange={(event) => setQuery(event.target.value)}
                placeholder={copy.search.placeholder}
                aria-label={copy.search.placeholder}
                autoFocus={autoFocus}
                className={cn(
                    'min-w-0 flex-1 bg-transparent text-sm outline-none',
                    isDark
                        ? 'placeholder:text-stone-500'
                        : 'placeholder:text-stone-400',
                )}
            />
            {query !== '' && (
                <button
                    type="button"
                    onClick={() => setQuery('')}
                    aria-label={copy.search.clear}
                    className={cn(
                        'rounded-full p-1 transition',
                        isDark
                            ? 'text-stone-500 hover:bg-white/10 hover:text-stone-100'
                            : 'text-stone-400 hover:bg-stone-200 hover:text-stone-900',
                    )}
                >
                    <X className="size-3.5" />
                </button>
            )}
            <button
                type="submit"
                aria-label={copy.search.submit}
                className={cn(
                    'inline-flex size-7 shrink-0 items-center justify-center rounded-full transition',
                    isDark
                        ? 'text-stone-300 hover:bg-[#e7c889] hover:text-stone-950'
                        : 'text-stone-600 hover:bg-stone-900 hover:text-stone-50',
                )}
            >
                <Search className="size-4" />
            </button>
        </form>
    );
}
