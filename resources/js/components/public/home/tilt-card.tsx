import {
    motion,
    useMotionValue,
    useReducedMotion,
    useSpring,
    useTransform,
} from 'motion/react';
import type { PointerEvent, ReactNode } from 'react';
import { cn } from '@/lib/utils';

type Props = {
    children: ReactNode;
    className?: string;
    /** Max rotation in degrees on each axis. */
    max?: number;
    /** Lift toward the viewer on hover, in px. */
    lift?: number;
    /** Show the moving specular glare. */
    glare?: boolean;
};

/**
 * Pointer-reactive 3D display case. The card rotates toward the cursor with
 * spring physics and casts a specular highlight, evoking glass behind which a
 * perfume bottle sits. Pointer interaction is skipped on coarse pointers and
 * when the user prefers reduced motion.
 */
export default function TiltCard({
    children,
    className,
    max = 8,
    lift = 14,
    glare = true,
}: Props) {
    const reduceMotion = useReducedMotion();

    const px = useMotionValue(0.5);
    const py = useMotionValue(0.5);

    const spring = { stiffness: 170, damping: 18, mass: 0.4 };
    const sx = useSpring(px, spring);
    const sy = useSpring(py, spring);

    const rotateY = useTransform(sx, [0, 1], [-max, max]);
    const rotateX = useTransform(sy, [0, 1], [max, -max]);
    const glareX = useTransform(sx, [0, 1], ['12%', '88%']);
    const glareY = useTransform(sy, [0, 1], ['8%', '92%']);
    const glareBackground = useTransform(
        [glareX, glareY],
        ([gx, gy]: string[]) =>
            `radial-gradient(420px circle at ${gx} ${gy}, rgba(255,255,255,0.55), rgba(255,255,255,0) 60%)`,
    );

    const handleMove = (event: PointerEvent<HTMLDivElement>) => {
        if (reduceMotion || event.pointerType === 'touch') {
            return;
        }

        const rect = event.currentTarget.getBoundingClientRect();
        px.set((event.clientX - rect.left) / rect.width);
        py.set((event.clientY - rect.top) / rect.height);
    };

    const reset = () => {
        px.set(0.5);
        py.set(0.5);
    };

    return (
        <div
            className="group/tilt perspective-[1400px]"
            onPointerMove={handleMove}
            onPointerLeave={reset}
        >
            <motion.div
                className={cn('relative transform-3d', className)}
                style={
                    reduceMotion
                        ? undefined
                        : { rotateX, rotateY, transformPerspective: 1400 }
                }
                whileHover={reduceMotion ? undefined : { z: lift }}
                transition={{ type: 'spring', ...spring }}
            >
                {children}

                {glare && !reduceMotion && (
                    <motion.div
                        aria-hidden
                        className="pointer-events-none absolute inset-0 opacity-0 mix-blend-soft-light transition-opacity duration-500 group-hover/tilt:opacity-100"
                        style={{ background: glareBackground }}
                    />
                )}
            </motion.div>
        </div>
    );
}
