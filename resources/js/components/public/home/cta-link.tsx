import MagneticLink from '@/components/public/home/magnetic-link';
import type { InertiaLinkCacheProps } from '@/lib/inertia-cache';
import { cn } from '@/lib/utils';

type Props = InertiaLinkCacheProps & {
    href: string;
    children: React.ReactNode;
    external?: boolean;
    variant?: 'solid' | 'ghost';
    className?: string;
};

/**
 * Primary call-to-action: a magnetic pill whose gold fill wipes up from the
 * bottom on hover, with an arrow that nudges forward. Text and arrow always
 * stay on one line.
 */
export default function CtaLink({
    href,
    children,
    external = false,
    variant = 'solid',
    className,
    cacheFor,
    cacheTags,
    prefetch,
}: Props) {
    return (
        <MagneticLink
            href={href}
            external={external}
            cacheFor={cacheFor}
            cacheTags={cacheTags}
            prefetch={prefetch}
            className={cn(
                'rounded-full px-8 py-4 text-sm font-medium tracking-wide backdrop-blur-md transition-colors duration-500',
                variant === 'solid'
                    ? 'border border-[#e7c889]/45 text-stone-50 hover:text-stone-950'
                    : 'border border-white/20 text-stone-100 hover:text-stone-950',
                className,
            )}
        >
            <span
                aria-hidden
                className="absolute inset-0 origin-bottom scale-y-0 bg-[#e7c889] transition-transform duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] group-hover/magnet:scale-y-100"
            />
            <span className="relative z-10">{children}</span>
            <svg
                viewBox="0 0 24 24"
                className="relative z-10 size-4 shrink-0 transition-transform duration-500 group-hover/magnet:translate-x-1 rtl:rotate-180"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.8"
            >
                <path d="M5 12h14M13 6l6 6-6 6" />
            </svg>
        </MagneticLink>
    );
}
