import type { ReactNode } from 'react';
import { cn } from '@/lib/utils';

type Props = {
    children: ReactNode;
    className?: string;
    /** Show the moving specular glare. */
    glare?: boolean;
};

/**
 * Lightweight display case wrapper. Hover depth is handled with CSS so the
 * public homepage does not need the motion runtime during initial load.
 */
export default function TiltCard({
    children,
    className,
    glare = true,
}: Props) {
    return (
        <div className="group/tilt perspective-[1400px]">
            <div
                className={cn(
                    'relative transition-transform duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] motion-safe:group-hover/tilt:-translate-y-2',
                    className,
                )}
            >
                {children}

                {glare && (
                    <div
                        aria-hidden
                        className="pointer-events-none absolute inset-0 bg-[radial-gradient(420px_circle_at_50%_10%,rgba(255,255,255,0.42),rgba(255,255,255,0)_60%)] opacity-0 mix-blend-soft-light transition-opacity duration-500 group-hover/tilt:opacity-100"
                    />
                )}
            </div>
        </div>
    );
}
