import { Link } from '@inertiajs/react';
import type { InertiaLinkProps } from '@inertiajs/react';
import type { ReactNode } from 'react';
import { cn } from '@/lib/utils';

type InertiaLinkCacheProps = Partial<Pick<
    InertiaLinkProps,
    'cacheFor' | 'cacheTags' | 'prefetch'
>>;

type Props = InertiaLinkCacheProps & {
    href: string;
    external?: boolean;
    children: ReactNode;
    className?: string;
};

/**
 * CTA link wrapper kept intentionally light for the public landing page.
 */
export default function MagneticLink({
    href,
    external = false,
    children,
    className,
    cacheFor,
    cacheTags,
    prefetch,
}: Props) {
    const shared = {
        className: cn(
            'group/magnet relative inline-flex items-center justify-center gap-2 overflow-hidden whitespace-nowrap transition-transform duration-300 motion-safe:hover:-translate-y-0.5',
            className,
        ),
    };

    if (external) {
        return (
            <a
                href={href}
                target="_blank"
                rel="noopener noreferrer"
                {...shared}
            >
                {children}
            </a>
        );
    }

    return (
        <Link
            href={href}
            cacheFor={cacheFor}
            cacheTags={cacheTags}
            prefetch={prefetch}
            {...shared}
        >
            {children}
        </Link>
    );
}
