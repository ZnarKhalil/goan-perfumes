import { Link } from '@inertiajs/react';
import {
    motion,
    useReducedMotion,
    useScroll,
    useTransform,
} from 'motion/react';
import { useRef } from 'react';
import CtaLink from '@/components/public/home/cta-link';
import {
    publicCategoryPrefetch,
    publicNavigationPrefetch,
} from '@/lib/inertia-cache';
import type { PublicCopy } from '@/lib/public-copy';
import type { PublicHeroSection } from '@/types/public';

type Props = {
    hero: PublicHeroSection;
    copy: PublicCopy;
    ctaHref: string;
    contactHref: string;
};

const PARTICLES = [
    { top: '14%', left: '10%', size: 6, delay: 0, dur: 16 },
    { top: '22%', left: '78%', size: 4, delay: -3, dur: 20 },
    { top: '64%', left: '16%', size: 5, delay: -6, dur: 22 },
    { top: '72%', left: '68%', size: 7, delay: -2, dur: 18 },
    { top: '38%', left: '50%', size: 3, delay: -9, dur: 24 },
    { top: '18%', left: '38%', size: 4, delay: -5, dur: 21 },
    { top: '52%', left: '88%', size: 5, delay: -8, dur: 19 },
    { top: '84%', left: '32%', size: 4, delay: -1, dur: 23 },
];

export default function Hero({ hero, copy, ctaHref, contactHref }: Props) {
    const reduceMotion = useReducedMotion();
    const sectionRef = useRef<HTMLElement>(null);

    const { scrollYProgress } = useScroll({
        target: sectionRef,
        offset: ['start start', 'end start'],
    });
    const mediaY = useTransform(scrollYProgress, [0, 1], ['0%', '16%']);
    const mediaScale = useTransform(scrollYProgress, [0, 1], [1, 1.08]);
    const contentY = useTransform(scrollYProgress, [0, 1], ['0%', '40%']);
    const contentOpacity = useTransform(scrollYProgress, [0, 0.8], [1, 0]);

    const words = hero.title.trim().split(/\s+/);
    const eyebrow = hero.eyebrow ?? copy.home.featuredEyebrow;

    return (
        <section
            ref={sectionRef}
            className="relative isolate flex flex-col overflow-hidden sm:min-h-svh sm:items-end"
        >
            {/* full-bleed background media — always covers the viewport */}
            <motion.div
                aria-hidden
                className="relative w-full bg-[#0b0907] sm:absolute sm:inset-0 sm:-z-20"
                style={
                    reduceMotion
                        ? undefined
                        : {
                              y: mediaY,
                              scale: mediaScale,
                          }
                }
            >
                {hero.video_url ? (
                    <video
                        key={hero.video_url}
                        className="h-auto w-full object-contain object-center sm:h-full sm:object-cover"
                        autoPlay
                        muted
                        loop
                        playsInline
                    >
                        <source src={hero.video_url} />
                    </video>
                ) : hero.image_url ? (
                    <img
                        src={hero.image_url}
                        alt=""
                        loading="eager"
                        fetchPriority="high"
                        decoding="sync"
                        className="h-auto w-full object-contain object-center sm:h-full sm:object-cover"
                    />
                ) : (
                    <div className="h-[22svh] w-full bg-[radial-gradient(120%_120%_at_30%_20%,#241708,#0b0907)] sm:h-full" />
                )}
            </motion.div>

            {/* legibility scrims (desktop overlay only) */}
            <div className="absolute inset-0 -z-10 hidden bg-[linear-gradient(105deg,rgba(7,5,4,0.86)_0%,rgba(7,5,4,0.55)_42%,rgba(7,5,4,0.2)_70%,rgba(7,5,4,0.45)_100%)] sm:block" />
            <div className="absolute inset-0 -z-10 hidden bg-[linear-gradient(180deg,rgba(7,5,4,0.55)_0%,transparent_28%,transparent_55%,rgba(11,9,7,0.96)_100%)] sm:block" />
            <div className="absolute inset-0 -z-10 hidden grain-layer opacity-[0.12] mix-blend-overlay sm:block" />

            {/* ambient drifting embers */}
            <div aria-hidden className="absolute inset-0 -z-10 hidden sm:block">
                {PARTICLES.map((p, i) => (
                    <span
                        key={i}
                        className="vitrine-drift absolute rounded-full bg-[#e7c889]/55 blur-[1px]"
                        style={{
                            top: p.top,
                            left: p.left,
                            width: p.size,
                            height: p.size,
                            animationDelay: `${p.delay}s`,
                            animationDuration: `${p.dur}s`,
                        }}
                    />
                ))}
                <div className="vitrine-pulse absolute top-[34%] left-[58%] h-1.5 w-1.5 rounded-full bg-[#f0dca0]" />
                <div
                    className="vitrine-pulse absolute top-[60%] left-[24%] h-1.5 w-1.5 rounded-full bg-[#f0dca0]"
                    style={{ animationDelay: '-1.6s' }}
                />
            </div>

            <motion.div
                className="relative mx-auto w-full max-w-7xl px-4 pt-10 pb-20 sm:pt-28 sm:pb-24 md:px-8 md:pb-28 lg:pt-36 xl:pt-40"
                style={
                    reduceMotion
                        ? undefined
                        : { y: contentY, opacity: contentOpacity }
                }
            >
                <div className="max-w-3xl">
                    <motion.p
                        className="mb-6 flex items-center gap-3 text-[0.7rem] font-medium tracking-[0.42em] text-[#e7c889] uppercase"
                        initial={reduceMotion ? false : { opacity: 0, y: 16 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.9, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <span className="vitrine-pulse inline-block size-2 rounded-full bg-[#e7c889]" />
                        {eyebrow}
                    </motion.p>

                    <h1 className="font-display text-[clamp(2.5rem,5.5vw,5rem)] leading-[1.02] font-light [[dir=rtl]_&]:leading-[1.35]">
                        {words.map((word, index) => (
                            <span
                                key={`${word}-${index}`}
                                className="-my-[0.25em] mr-[0.22em] inline-block overflow-hidden py-[0.25em] align-bottom"
                            >
                                <motion.span
                                    className="vitrine-shimmer-text inline-block"
                                    initial={
                                        reduceMotion
                                            ? false
                                            : { y: '150%', rotate: 5 }
                                    }
                                    animate={{ y: 0, rotate: 0 }}
                                    transition={{
                                        duration: 1.1,
                                        delay: 0.15 + index * 0.09,
                                        ease: [0.16, 1, 0.3, 1],
                                    }}
                                >
                                    {word}
                                </motion.span>
                            </span>
                        ))}
                    </h1>

                    <motion.p
                        className="mt-7 max-w-xl text-base leading-8 text-stone-200 md:text-lg"
                        initial={reduceMotion ? false : { opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{
                            duration: 1,
                            delay: 0.2 + words.length * 0.09,
                            ease: [0.16, 1, 0.3, 1],
                        }}
                    >
                        {hero.body}
                    </motion.p>

                    <motion.div
                        className="mt-10 flex flex-wrap items-center gap-5"
                        initial={reduceMotion ? false : { opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{
                            duration: 1,
                            delay: 0.34 + words.length * 0.09,
                            ease: [0.16, 1, 0.3, 1],
                        }}
                    >
                        <CtaLink href={ctaHref} {...publicCategoryPrefetch}>
                            {hero.cta_text ?? copy.home.heroCta}
                        </CtaLink>
                        <Link
                            href={contactHref}
                            {...publicNavigationPrefetch}
                            className="group/advice hidden items-center gap-2 text-xs tracking-[0.28em] text-stone-300 uppercase transition-colors duration-300 hover:text-[#e7c889] sm:inline-flex"
                        >
                            {copy.home.heroSecondary}
                            <span className="h-px w-7 bg-current opacity-50 transition-all duration-300 group-hover/advice:w-10 group-hover/advice:opacity-100" />
                        </Link>
                    </motion.div>
                </div>
            </motion.div>

            <motion.div
                aria-hidden
                className="absolute inset-x-0 bottom-6 mx-auto flex w-fit flex-col items-center gap-2 text-[0.6rem] tracking-[0.3em] text-stone-400 uppercase"
                initial={reduceMotion ? false : { opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 1, delay: 1.4 }}
            >
                <span className="vitrine-float h-9 w-px bg-linear-to-b from-[#e7c889]/70 to-transparent" />
            </motion.div>
        </section>
    );
}
