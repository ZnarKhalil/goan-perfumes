import { Link } from '@inertiajs/react';
import Reveal from '@/components/public/home/reveal';
import TiltCard from '@/components/public/home/tilt-card';
import { publicCategoryPrefetch } from '@/lib/inertia-cache';
import type { PublicCopy } from '@/lib/public-copy';
import type { PublicPromotion } from '@/types/public';

type Props = {
    offers: PublicPromotion[];
    copy: PublicCopy;
    shopHref: string;
};

export default function Offers({ offers, copy, shopHref }: Props) {
    if (offers.length === 0) {
        return null;
    }

    const visible = offers.slice(0, 3);

    return (
        <section className="relative px-4 py-20 md:px-8 md:py-28">
            <div className="mx-auto max-w-7xl">
                <Reveal className="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                    <div>
                        <p className="flex items-center gap-3 text-[0.7rem] font-semibold tracking-[0.38em] text-[#e7c889] uppercase">
                            <span className="vitrine-pulse inline-block size-2 rounded-full bg-[#e7c889]" />
                            {copy.home.offersEyebrow}
                        </p>
                        <h2 className="mt-5 max-w-2xl font-display text-3xl leading-[1.1] font-light text-stone-50 md:text-5xl">
                            {copy.home.offersTitle}
                        </h2>
                    </div>
                    <Link
                        href={shopHref}
                        {...publicCategoryPrefetch}
                        className="group inline-flex items-center gap-2 text-sm font-medium text-[#e7c889] transition-colors hover:text-stone-50"
                    >
                        {copy.home.luxuryLink}
                        <span className="transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180">
                            →
                        </span>
                    </Link>
                </Reveal>

                <div className="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {visible.map((offer) => (
                        <Reveal key={offer.id}>
                            <TiltCard className="relative h-full overflow-hidden rounded-[1.4rem] border border-[#e7c889]/20 bg-[linear-gradient(150deg,rgba(231,200,137,0.14),rgba(255,255,255,0.02)_45%,rgba(255,255,255,0.01))] p-7 backdrop-blur-xl">
                                <div className="absolute inset-x-7 top-0 h-px bg-linear-to-r from-transparent via-[#e7c889]/60 to-transparent" />
                                <div className="absolute -top-10 right-[-10%] h-32 w-32 rounded-full bg-[#e7c889]/20 blur-3xl transition-transform duration-700 group-hover/tilt:scale-125" />

                                <div className="relative flex h-full flex-col gap-5">
                                    {offer.badge && (
                                        <span className="w-fit rounded-full bg-[#e7c889] px-3 py-1 text-[0.6rem] font-semibold tracking-[0.18em] text-stone-950 uppercase">
                                            {offer.badge}
                                        </span>
                                    )}
                                    <div>
                                        <h3 className="font-display text-2xl leading-tight font-medium text-stone-50 md:text-3xl">
                                            {offer.title}
                                        </h3>
                                        <p className="mt-3 text-sm leading-7 text-stone-300">
                                            {offer.subtitle}
                                        </p>
                                    </div>
                                    {offer.cta_text && (
                                        <p className="mt-auto inline-flex items-center gap-2 text-xs font-semibold tracking-[0.16em] text-[#e7c889] uppercase">
                                            {offer.cta_text}
                                            <span className="transition-transform duration-500 group-hover/tilt:translate-x-1 rtl:rotate-180">
                                                →
                                            </span>
                                        </p>
                                    )}
                                </div>
                            </TiltCard>
                        </Reveal>
                    ))}
                </div>
            </div>
        </section>
    );
}
