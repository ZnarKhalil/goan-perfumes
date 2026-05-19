import { Link } from '@inertiajs/react';
import {
    motion,
    useMotionValue,
    useReducedMotion,
    useSpring,
} from 'motion/react';
import type { PointerEvent, ReactNode } from 'react';
import { cn } from '@/lib/utils';

const MotionInertiaLink = motion.create(Link);

type Props = {
    href: string;
    external?: boolean;
    children: ReactNode;
    className?: string;
    /** Magnet strength as a fraction of the offset from center. */
    strength?: number;
};

/**
 * A link that magnetically eases toward the cursor while hovered, then springs
 * back on leave. Falls back to a plain link with reduced motion.
 */
export default function MagneticLink({
    href,
    external = false,
    children,
    className,
    strength = 0.35,
}: Props) {
    const reduceMotion = useReducedMotion();
    const x = useMotionValue(0);
    const y = useMotionValue(0);
    const sx = useSpring(x, { stiffness: 220, damping: 14, mass: 0.3 });
    const sy = useSpring(y, { stiffness: 220, damping: 14, mass: 0.3 });

    const handleMove = (event: PointerEvent<HTMLElement>) => {
        if (reduceMotion || event.pointerType === 'touch') {
            return;
        }

        const rect = event.currentTarget.getBoundingClientRect();
        x.set((event.clientX - (rect.left + rect.width / 2)) * strength);
        y.set((event.clientY - (rect.top + rect.height / 2)) * strength);
    };

    const reset = () => {
        x.set(0);
        y.set(0);
    };

    const shared = {
        className: cn(
            'group/magnet relative inline-flex items-center justify-center gap-2 overflow-hidden whitespace-nowrap',
            className,
        ),
        style: reduceMotion ? undefined : { x: sx, y: sy },
        onPointerMove: handleMove,
        onPointerLeave: reset,
    };

    if (external) {
        return (
            <motion.a
                href={href}
                target="_blank"
                rel="noopener noreferrer"
                {...shared}
            >
                {children}
            </motion.a>
        );
    }

    return (
        <MotionInertiaLink href={href} {...shared}>
            {children}
        </MotionInertiaLink>
    );
}
