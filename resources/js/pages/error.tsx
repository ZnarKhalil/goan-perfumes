import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, Home } from 'lucide-react';
import { motion, useReducedMotion } from 'motion/react';
import AppLogoIcon from '@/components/app-logo-icon';
import NoindexHead from '@/components/noindex-head';
import { Button } from '@/components/ui/button';

type Props = {
    status: 403 | 404 | 419 | 429 | 500 | 503;
};

const copy: Record<
    Props['status'],
    {
        eyebrow: string;
        title: string;
        description: string;
        note: string;
    }
> = {
    403: {
        eyebrow: 'Access held',
        title: 'This room is reserved.',
        description:
            'The page exists, but your current account does not have permission to enter it.',
        note: 'Use an admin account or return to the public catalogue.',
    },
    404: {
        eyebrow: 'Trail faded',
        title: 'This fragrance path disappeared.',
        description:
            'The page may have moved, been renamed, or never existed in this collection.',
        note: 'Return home and start from the current Goan Perfume catalogue.',
    },
    419: {
        eyebrow: 'Session expired',
        title: 'The access note went cold.',
        description:
            'Your session token expired while the page was waiting. Refresh and try again.',
        note: 'No changes were applied from the expired request.',
    },
    429: {
        eyebrow: 'Too many attempts',
        title: 'Give the room a moment.',
        description:
            'Too many requests arrived too quickly. Wait briefly before trying again.',
        note: 'This protects the admin area and customer-facing catalogue.',
    },
    500: {
        eyebrow: 'Internal error',
        title: 'Something broke behind the counter.',
        description:
            'The server could not complete the request. The issue can be reviewed from the application logs.',
        note: 'Try again shortly, or head back to a known page.',
    },
    503: {
        eyebrow: 'Service paused',
        title: 'The atelier is being prepared.',
        description:
            'Goan Perfume is temporarily unavailable while maintenance is in progress.',
        note: 'Please check back soon.',
    },
};

export default function ErrorPage({ status }: Props) {
    const reduceMotion = useReducedMotion();
    const content = copy[status] ?? copy[500];

    return (
        <main className="relative isolate min-h-svh overflow-hidden bg-[#0b0907] text-stone-50">
            <Head title={`${status} - ${content.title}`} />
            <NoindexHead />

            <div className="absolute inset-0 -z-30 category-animated-field" />
            <div className="absolute inset-0 -z-20 bg-[radial-gradient(ellipse_at_center,transparent_0%,rgba(11,9,7,0.38)_44%,rgba(11,9,7,0.95)_100%)]" />
            <div className="absolute inset-0 -z-20 grain-layer opacity-[0.15] mix-blend-overlay" />

            <div aria-hidden className="absolute inset-0 -z-10 overflow-hidden">
                <div className="absolute top-[30%] left-[-18%] h-px w-[135%] category-ribbon" />
                <div className="absolute top-[62%] left-[-22%] h-px w-[140%] category-ribbon category-ribbon-reverse" />
                <motion.div
                    className="absolute top-1/2 left-1/2 h-[32rem] w-[32rem] -translate-x-1/2 -translate-y-1/2 rounded-full border border-[#e7c889]/20"
                    initial={reduceMotion ? false : { scale: 0.86, opacity: 0 }}
                    animate={
                        reduceMotion
                            ? { opacity: 1 }
                            : {
                                  scale: [0.9, 1.08, 0.9],
                                  opacity: [0.2, 0.6, 0.2],
                              }
                    }
                    transition={{
                        duration: 12,
                        repeat: reduceMotion ? 0 : Infinity,
                        ease: 'easeInOut',
                    }}
                />
            </div>

            <section className="mx-auto flex min-h-svh w-full max-w-6xl flex-col px-5 py-8 md:px-8">
                <Link
                    href="/"
                    className="inline-flex w-fit items-center gap-3 text-sm font-medium tracking-[0.26em] text-stone-200 uppercase transition-colors hover:text-[#e7c889]"
                >
                    <AppLogoIcon className="size-8 fill-current text-[#e7c889]" />
                    Goan Perfume
                </Link>

                <div className="grid flex-1 place-items-center py-16">
                    <motion.div
                        className="w-full max-w-3xl text-center"
                        initial={reduceMotion ? false : { opacity: 0, y: 24 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{
                            duration: 0.9,
                            ease: [0.16, 1, 0.3, 1],
                        }}
                    >
                        <p className="mb-6 text-[0.68rem] font-semibold tracking-[0.44em] text-[#e7c889] uppercase">
                            {status} / {content.eyebrow}
                        </p>

                        <h1 className="font-display text-[clamp(3.6rem,18vw,12rem)] leading-none font-light">
                            <span className="vitrine-shimmer-text">
                                {status}
                            </span>
                        </h1>

                        <h2 className="mt-6 font-display text-4xl leading-tight font-light text-balance md:text-6xl">
                            {content.title}
                        </h2>

                        <p className="mx-auto mt-6 max-w-2xl font-body text-base leading-8 text-stone-200 md:text-lg">
                            {content.description}
                        </p>

                        <p className="mx-auto mt-4 max-w-xl text-sm leading-6 text-stone-500">
                            {content.note}
                        </p>

                        <div className="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                            <Button
                                asChild
                                className="h-11 rounded-full bg-[#e7c889] px-6 text-stone-950 shadow-none hover:bg-[#f1dca3]"
                            >
                                <Link href="/">
                                    <Home className="size-4" />
                                    Go home
                                </Link>
                            </Button>
                            <Button
                                type="button"
                                variant="ghost"
                                className="h-11 rounded-full px-6 text-stone-200 hover:bg-white/10 hover:text-[#e7c889]"
                                onClick={() => window.history.back()}
                            >
                                <ArrowLeft className="size-4" />
                                Go back
                            </Button>
                        </div>
                    </motion.div>
                </div>
            </section>
        </main>
    );
}
