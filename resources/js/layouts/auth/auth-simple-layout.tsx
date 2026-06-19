import { Link } from '@inertiajs/react';
import { motion, useReducedMotion } from 'motion/react';
import AppLogoIcon from '@/components/app-logo-icon';
import type { AuthLayoutProps } from '@/types';

const AUTH_HERO_IMAGE =
    '/storage/page-sections/hero/01KV11VK47W3DEE81GD06X5KJD-1280.webp';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    const reduceMotion = useReducedMotion();

    return (
        <main className="relative isolate min-h-svh overflow-hidden bg-[#0b0907] text-stone-50">
            <img
                src={AUTH_HERO_IMAGE}
                alt=""
                className="absolute inset-0 -z-30 h-full w-full object-cover opacity-70"
            />
            <div className="absolute inset-0 -z-20 bg-[linear-gradient(105deg,rgba(7,5,4,0.94)_0%,rgba(7,5,4,0.72)_46%,rgba(7,5,4,0.35)_73%,rgba(7,5,4,0.78)_100%)]" />
            <div className="absolute inset-0 -z-20 grain-layer opacity-[0.13] mix-blend-overlay" />
            <div
                aria-hidden
                className="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
            >
                <motion.svg
                    viewBox="0 0 900 900"
                    className="absolute top-1/2 left-1/2 h-[82rem] w-[82rem] max-w-none -translate-x-1/2 -translate-y-1/2 text-[#e7c889]/35"
                    fill="none"
                    initial={reduceMotion ? false : { opacity: 0, rotate: -8 }}
                    animate={
                        reduceMotion
                            ? { opacity: 1 }
                            : { opacity: 1, rotate: 10 }
                    }
                    transition={{
                        duration: 18,
                        repeat: reduceMotion ? 0 : Infinity,
                        repeatType: 'mirror',
                        ease: 'easeInOut',
                    }}
                >
                    <path
                        d="M451 756c-126 0-228-102-228-228 0-103 84-187 187-187 83 0 151 68 151 151 0 65-53 118-118 118-50 0-91-41-91-91 0-37 30-68 68-68 27 0 49 22 49 49"
                        stroke="currentColor"
                        strokeWidth="2"
                        strokeLinecap="round"
                    />
                    <path
                        d="M472 154c146 0 264 118 264 264 0 118-96 214-214 214-94 0-170-76-170-170 0-73 59-132 132-132 56 0 101 45 101 101"
                        stroke="currentColor"
                        strokeWidth="1.2"
                        strokeLinecap="round"
                        opacity="0.55"
                    />
                </motion.svg>

                {Array.from({ length: 8 }, (_, index) => (
                    <span
                        key={index}
                        className="vitrine-drift absolute rounded-full bg-[#e7c889]/55 blur-[1px]"
                        style={{
                            top: `${16 + ((index * 19) % 68)}%`,
                            left: `${8 + ((index * 23) % 82)}%`,
                            width: 3 + (index % 4),
                            height: 3 + (index % 4),
                            animationDelay: `${index * -1.7}s`,
                            animationDuration: `${18 + index}s`,
                        }}
                    />
                ))}
            </div>

            <div className="relative grid min-h-svh items-center gap-10 px-5 py-8 md:px-10 lg:grid-cols-[minmax(0,1fr)_minmax(25rem,30rem)] lg:px-14">
                <motion.section
                    className="hidden max-w-3xl lg:block"
                    initial={reduceMotion ? false : { opacity: 0, y: 24 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.9, ease: [0.16, 1, 0.3, 1] }}
                >
                    <Link
                        href="/"
                        className="mb-16 inline-flex items-center gap-3 text-sm font-medium tracking-[0.26em] text-stone-200 uppercase transition-colors hover:text-[#e7c889]"
                    >
                        <AppLogoIcon className="size-8 fill-current text-[#e7c889]" />
                        Goan Perfume
                    </Link>

                    <p className="mb-5 flex items-center gap-3 text-[0.68rem] font-semibold tracking-[0.44em] text-[#e7c889] uppercase">
                        <span className="vitrine-pulse inline-block size-2 rounded-full bg-[#e7c889]" />
                        Private atelier
                    </p>

                    <h1 className="max-w-2xl font-display text-6xl leading-[0.95] font-light text-balance md:text-7xl xl:text-8xl">
                        <span className="vitrine-shimmer-text">
                            Step into the scent room.
                        </span>
                    </h1>

                    <p className="mt-8 max-w-xl font-body text-lg leading-8 text-stone-200">
                        A calm admin entrance for curating collections, product
                        stories, and every detail customers discover before
                        choosing their fragrance.
                    </p>
                </motion.section>

                <motion.section
                    className="mx-auto w-full max-w-md lg:mx-0"
                    initial={reduceMotion ? false : { opacity: 0, y: 28 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{
                        duration: 0.85,
                        delay: 0.12,
                        ease: [0.16, 1, 0.3, 1],
                    }}
                >
                    <div className="mb-9 flex justify-center lg:hidden">
                        <Link
                            href="/"
                            className="flex items-center gap-3 text-sm font-medium tracking-[0.22em] text-stone-100 uppercase"
                        >
                            <AppLogoIcon className="size-8 fill-current text-[#e7c889]" />
                            Goan Perfume
                        </Link>
                    </div>

                    <div className="relative overflow-hidden rounded-[1.75rem] border border-white/15 bg-[#120d09]/70 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-8">
                        <div className="pointer-events-none absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-[#e7c889]/70 to-transparent" />
                        <div className="mb-8 space-y-3">
                            <p className="text-[0.65rem] font-semibold tracking-[0.38em] text-[#e7c889] uppercase">
                                Secure access
                            </p>
                            <h2 className="font-display text-3xl leading-tight font-light text-stone-50">
                                {title}
                            </h2>
                            <p className="font-body text-sm leading-6 text-stone-300">
                                {description}
                            </p>
                        </div>

                        <div className="text-stone-100">{children}</div>
                    </div>

                    <p className="mt-6 text-center text-xs tracking-[0.22em] text-stone-500 uppercase">
                        Goan Perfume Admin
                    </p>
                </motion.section>
            </div>
        </main>
    );
}
