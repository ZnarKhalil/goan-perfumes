import { Link } from '@inertiajs/react';
import Reveal from '@/components/public/home/reveal';
import TiltCard from '@/components/public/home/tilt-card';
import Price from '@/components/public/price';
import type { PublicCopy } from '@/lib/public-copy';
import type { PublicProductCard } from '@/types/public';

type Props = {
    products: PublicProductCard[];
    copy: PublicCopy;
    title: string;
    eyebrow: string;
    seeAllHref: string;
    seeAllLabel: string;
    emptyMessage: string;
};

export default function ProductVitrine({
    products,
    copy,
    title,
    eyebrow,
    seeAllHref,
    seeAllLabel,
    emptyMessage,
}: Props) {
    return (
        <section className="relative px-4 py-24 md:px-8 md:py-36">
            <div className="mx-auto max-w-7xl">
                <Reveal className="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                    <div>
                        <p className="flex items-center gap-3 text-[0.7rem] font-medium tracking-[0.38em] text-[#e7c889] uppercase">
                            <span className="h-px w-10 bg-[#e7c889]/60" />
                            {eyebrow}
                        </p>
                        <h2 className="mt-5 max-w-2xl font-display text-4xl leading-[1.05] font-light text-stone-50 md:text-6xl">
                            {title}
                        </h2>
                    </div>
                    <Link
                        href={seeAllHref}
                        className="group inline-flex items-center gap-2 text-sm font-medium text-stone-300 transition-colors hover:text-[#e7c889]"
                    >
                        {seeAllLabel}
                        <span className="transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180">
                            →
                        </span>
                    </Link>
                </Reveal>

                {products.length === 0 ? (
                    <div className="mt-14 rounded-2xl border border-dashed border-white/15 px-6 py-16 text-center text-sm text-stone-400">
                        {emptyMessage}
                    </div>
                ) : (
                    <div className="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {products.map((product, index) => (
                            <Reveal
                                key={product.id}
                                delay={index * 0.09}
                                y={48}
                            >
                                <VitrineCard product={product} copy={copy} />
                            </Reveal>
                        ))}
                    </div>
                )}
            </div>
        </section>
    );
}

function VitrineCard({
    product,
    copy,
}: {
    product: PublicProductCard;
    copy: PublicCopy;
}) {
    return (
        <TiltCard className="h-full rounded-[1.4rem] border border-white/10 bg-white/[0.035] p-3 shadow-[0_30px_70px_-40px_rgba(0,0,0,0.9)] backdrop-blur-xl">
            <Link
                href={product.href}
                className="flex h-full flex-col focus-visible:outline-none"
            >
                <div className="relative aspect-[4/5] overflow-hidden rounded-[1.05rem] bg-[radial-gradient(120%_90%_at_50%_0%,#221708,#0c0907)]">
                    {/* glass shelf glow */}
                    <div className="absolute inset-x-6 top-0 h-px bg-linear-to-r from-transparent via-[#e7c889]/50 to-transparent" />
                    <div className="absolute inset-x-10 bottom-6 h-12 rounded-[50%] bg-[#e7c889]/15 blur-2xl" />

                    {product.image_url ? (
                        <img
                            src={product.image_url}
                            alt={product.image_alt}
                            width={800}
                            height={1000}
                            loading="lazy"
                            decoding="async"
                            className="vitrine-float absolute inset-0 m-auto h-[82%] w-auto object-contain drop-shadow-[0_24px_30px_rgba(0,0,0,0.55)] transition-transform duration-700 group-hover/tilt:scale-[1.06]"
                        />
                    ) : (
                        <div className="flex h-full flex-col items-center justify-center gap-3 text-stone-500">
                            <svg
                                viewBox="0 0 24 24"
                                className="size-10 text-[#e7c889]/40"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="1.2"
                                aria-hidden
                            >
                                <path d="M10 3h4M11 3v4h2V3M8.5 9.5 7 11a5 5 0 0 0-1 3v4a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3v-4a5 5 0 0 0-1-3l-1.5-1.5M9 9.5h6a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v.5a1 1 0 0 0 1 1Z" />
                            </svg>
                            <span className="text-[0.65rem] tracking-[0.24em] uppercase">
                                {copy.productCard.imageMissing}
                            </span>
                        </div>
                    )}

                    {/* sweeping sheen on hover */}
                    <div className="pointer-events-none absolute inset-0 overflow-hidden">
                        <div className="absolute top-0 -left-1/3 h-full w-1/3 -translate-x-full bg-linear-to-r from-transparent via-white/12 to-transparent transition-transform duration-1000 group-hover/tilt:translate-x-[420%]" />
                    </div>

                    {product.is_featured && (
                        <span className="absolute top-4 left-4 rounded-full border border-[#e7c889]/40 bg-black/40 px-3 py-1 text-[0.6rem] font-medium tracking-[0.18em] text-[#e7c889] uppercase backdrop-blur">
                            {copy.productCard.highlight}
                        </span>
                    )}
                </div>

                <div className="flex flex-1 flex-col gap-1.5 px-2 pt-5 pb-3">
                    {product.brand && (
                        <p className="text-[0.68rem] tracking-[0.2em] text-stone-400 uppercase">
                            {product.brand}
                        </p>
                    )}
                    <h3 className="font-display text-lg leading-tight font-medium text-stone-50">
                        {product.name}
                    </h3>
                    <Price
                        min={product.min_price}
                        max={product.max_price}
                        fallback={copy.product.priceOnRequest}
                        className="mt-auto pt-2 text-sm text-[#e7c889]"
                    />
                </div>
            </Link>
        </TiltCard>
    );
}
