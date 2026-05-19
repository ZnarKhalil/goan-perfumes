import { Head, Link } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import ProductGrid from '@/components/public/product-grid';
import PublicLayout from '@/layouts/public-layout';
import { getPublicCopy } from '@/lib/public-copy';
import type { PublicHomePageProps } from '@/types/public';

export default function Home(page: PublicHomePageProps) {
    const copy = getPublicCopy(page.locale);
    const hero = page.page_sections.hero;
    const heroVideo = hero.video_url;
    const heroImage = hero.image_url;
    const luxuryHref =
        page.navigation.find((category) => category.slug === 'luxusparfums')
            ?.href ?? `/${page.locale?.current ?? 'de'}`;

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
        >
            <Head title="Goan Perfume" />
            <section className="relative min-h-[calc(100svh-4rem)] overflow-hidden md:min-h-[calc(100svh-5rem)]">
                {heroImage && (
                    <img
                        src={heroImage}
                        alt=""
                        className="absolute inset-0 h-full w-full object-cover"
                    />
                )}
                {heroVideo && (
                    <video
                        key={heroVideo}
                        className="absolute inset-0 h-full w-full object-cover"
                        poster={heroImage ?? undefined}
                        autoPlay
                        muted
                        loop
                        playsInline
                    >
                        <source src={heroVideo} />
                    </video>
                )}
                <div className="absolute inset-0 bg-linear-to-r from-black/75 via-black/40 to-black/10" />
                <div className="relative flex min-h-[calc(100svh-4rem)] items-end px-4 py-12 md:min-h-[calc(100svh-5rem)] md:px-8 md:py-16">
                    <div className="max-w-3xl text-white">
                        <p className="mb-4 text-xs tracking-[0.28em] text-white/70 uppercase">
                            Goan Perfume
                        </p>
                        <h1 className="max-w-2xl font-serif text-5xl leading-[0.95] md:text-7xl lg:text-8xl">
                            {hero.title}
                        </h1>
                        <p className="mt-6 max-w-xl text-base leading-7 text-white/82 md:text-lg">
                            {hero.body}
                        </p>
                        <div className="mt-8 flex flex-wrap items-center gap-3">
                            <Link
                                href={luxuryHref}
                                className="inline-flex items-center gap-2 bg-white px-5 py-3 text-sm font-medium text-stone-950 transition hover:bg-stone-200"
                            >
                                {hero.cta_text ?? copy.home.heroCta}
                                <ArrowRight className="size-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <section className="px-4 py-16 md:px-8 md:py-24">
                <div className="mx-auto grid max-w-7xl gap-10">
                    <div className="flex flex-col justify-between gap-4 md:flex-row md:items-end">
                        <div>
                            <p className="text-xs tracking-[0.22em] text-stone-500 uppercase">
                                {copy.home.featuredEyebrow}
                            </p>
                            <h2 className="mt-3 max-w-2xl font-serif text-4xl leading-tight md:text-5xl">
                                {copy.home.featuredTitle}
                            </h2>
                        </div>
                        <Link
                            href={luxuryHref}
                            className="text-sm font-medium text-stone-700 underline underline-offset-4 hover:text-stone-950"
                        >
                            {copy.home.luxuryLink}
                        </Link>
                    </div>
                    <ProductGrid
                        products={page.featured_products}
                        copy={copy}
                        emptyMessage={copy.home.featuredEmpty}
                    />
                </div>
            </section>

            <section className="border-y border-stone-200 bg-[#f1eadf] px-4 py-16 md:px-8 md:py-24">
                <div className="mx-auto grid max-w-7xl gap-10 md:grid-cols-[0.8fr_1.2fr] md:items-end">
                    <p className="text-xs tracking-[0.22em] text-stone-500 uppercase">
                        {copy.home.aboutEyebrow}
                    </p>
                    <div>
                        <h2 className="font-serif text-4xl leading-tight md:text-6xl">
                            {page.page_sections.about.title}
                        </h2>
                        <p className="mt-6 max-w-2xl text-lg leading-8 text-stone-700">
                            {page.page_sections.about.body}
                        </p>
                    </div>
                </div>
            </section>

            <section className="px-4 py-16 md:px-8 md:py-24">
                <div className="mx-auto grid max-w-7xl gap-10 md:grid-cols-[0.8fr_1.2fr]">
                    <div>
                        <p className="text-xs tracking-[0.22em] text-stone-500 uppercase">
                            {copy.home.whyEyebrow}
                        </p>
                        <h2 className="mt-3 font-serif text-4xl leading-tight md:text-5xl">
                            {page.page_sections.why_us.title}
                        </h2>
                    </div>
                    <div className="grid gap-0 border-t border-stone-200">
                        {page.page_sections.why_us.items.map((item, index) => (
                            <div
                                key={item}
                                className="grid gap-4 border-b border-stone-200 py-6 md:grid-cols-[6rem_1fr]"
                            >
                                <span className="font-serif text-3xl text-stone-300">
                                    {String(index + 1).padStart(2, '0')}
                                </span>
                                <p className="text-xl leading-8 text-stone-800">
                                    {item}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="bg-stone-950 px-4 py-14 text-white md:px-8">
                <div className="mx-auto flex max-w-7xl flex-col justify-between gap-6 md:flex-row md:items-center">
                    <div>
                        <p className="text-xs tracking-[0.22em] text-white/50 uppercase">
                            {copy.home.adviceEyebrow}
                        </p>
                        <h2 className="mt-3 max-w-2xl font-serif text-3xl leading-tight md:text-5xl">
                            {copy.home.adviceTitle}
                        </h2>
                    </div>
                    {page.contact.whatsapp_url && (
                        <a
                            href={page.contact.whatsapp_url}
                            className="inline-flex w-fit items-center gap-2 border border-white/30 px-5 py-3 text-sm font-medium text-white transition hover:bg-white hover:text-stone-950"
                        >
                            {copy.home.whatsappCta}
                            <ArrowRight className="size-4" />
                        </a>
                    )}
                </div>
            </section>
        </PublicLayout>
    );
}
