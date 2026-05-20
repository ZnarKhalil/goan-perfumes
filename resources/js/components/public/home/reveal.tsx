import { motion, useReducedMotion } from 'motion/react';
import type { ReactNode } from 'react';

type Props = {
    children: ReactNode;
    className?: string;
    /** Stagger delay in seconds. */
    delay?: number;
    /** Vertical travel distance in px. */
    y?: number;
    /** Blur the element in until revealed. */
    blur?: boolean;
};

/**
 * Scroll-triggered reveal. Fades, rises and (optionally) de-blurs an element
 * the first time it enters the viewport. Honours `prefers-reduced-motion`.
 */
export default function Reveal({
    children,
    className,
    delay = 0,
    y = 36,
    blur = true,
}: Props) {
    const reduceMotion = useReducedMotion();

    if (reduceMotion) {
        return <div className={className}>{children}</div>;
    }

    return (
        <motion.div
            className={className}
            initial={{
                opacity: 0,
                y,
                filter: blur ? 'blur(14px)' : 'blur(0px)',
            }}
            whileInView={{ opacity: 1, y: 0, filter: 'blur(0px)' }}
            viewport={{ once: true, margin: '-12% 0px -12% 0px' }}
            transition={{
                duration: 1,
                delay,
                ease: [0.16, 1, 0.3, 1],
            }}
        >
            {children}
        </motion.div>
    );
}
