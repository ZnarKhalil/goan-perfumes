import { Link } from '@inertiajs/react';
import Reveal from '@/components/public/home/reveal';
import type { PublicCategoryNavItem } from '@/types/public';

type Props = {
    categories: PublicCategoryNavItem[];
    eyebrow: string;
    title: string;
};

/**
 * Category "vitrine doors" — tall glass panels that lift and reveal their
 * scene on hover. Horizontally scrollable on small screens, gridded on wide.
 */
export default function Collections({ categories, eyebrow, title }: Props) {
    if (categories.length === 0) {
        return null;
    }

    return (
        <section className="relative px-4 py-24 md:px-8 md:py-32">
            <div className="mx-auto max-w-7xl">
                <Reveal className="max-w-2xl">
                    <p className="flex items-center gap-3 text-[0.7rem] font-medium tracking-[0.38em] text-[#e7c889] uppercase">
                        <span className="h-px w-10 bg-[#e7c889]/60" />
                        {eyebrow}
                    </p>
                    <h2 className="mt-5 font-display text-4xl leading-[1.05] font-light text-stone-50 md:text-6xl">
                        {title}
                    </h2>
                </Reveal>

                <div className="mt-14 flex snap-x snap-mandatory gap-5 overflow-x-auto pb-4 [scrollbar-width:none] md:grid md:grid-cols-3 md:overflow-visible lg:grid-cols-4 [&::-webkit-scrollbar]:hidden">
                    {categories.map((category, index) => (
                        <Reveal
                            key={category.id}
                            delay={index * 0.07}
                            className="min-w-[78vw] snap-start sm:min-w-[44vw] md:min-w-0"
                        >
                            <Link
                                href={category.href}
                                className="group relative block aspect-[3/4] overflow-hidden rounded-[1.4rem] border border-white/10"
                            >
                                <div className="absolute inset-0 scale-125 category-animated-field transition-transform duration-[1200ms] ease-out group-hover:scale-140" />
                                <div className="absolute top-1/2 left-[-38%] h-16 w-[110%] -translate-y-1/2 category-ribbon" />
                                <div className="absolute inset-y-0 -left-1/2 w-2/3 category-light-sweep opacity-70" />

                                <div className="absolute inset-0 bg-[linear-gradient(180deg,rgba(7,5,4,0.15)_0%,rgba(7,5,4,0.2)_45%,rgba(7,5,4,0.86)_100%)] transition-opacity duration-700 group-hover:opacity-90" />
                                <div className="absolute inset-3 rounded-[1.05rem] border border-white/10 transition-colors duration-700 group-hover:border-[#e7c889]/45" />

                                <div className="absolute inset-x-0 bottom-0 flex items-end justify-between gap-3 p-6">
                                    <h3 className="font-display text-2xl leading-tight font-medium text-stone-50 transition-transform duration-500 group-hover:-translate-y-1">
                                        {category.name}
                                    </h3>
                                    <span className="grid size-10 shrink-0 place-items-center rounded-full border border-white/25 text-stone-100 backdrop-blur transition-all duration-500 group-hover:border-[#e7c889] group-hover:bg-[#e7c889] group-hover:text-stone-950">
                                        <svg
                                            viewBox="0 0 24 24"
                                            className="size-4 rtl:rotate-180"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth="1.8"
                                        >
                                            <path d="M5 12h14M13 6l6 6-6 6" />
                                        </svg>
                                    </span>
                                </div>
                            </Link>
                        </Reveal>
                    ))}
                </div>
            </div>
        </section>
    );
}
