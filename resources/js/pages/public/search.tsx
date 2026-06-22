import { Link, router } from '@inertiajs/react';
import type { MouseEvent } from 'react';
import ProductGrid from '@/components/public/product-grid';
import PublicHead from '@/components/public/public-head';
import SearchForm from '@/components/public/search-form';
import PublicLayout from '@/layouts/public-layout';
import { getPublicCopy, paginationLabel } from '@/lib/public-copy';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicSearchPageProps } from '@/types/public';

export default function Search(page: PublicSearchPageProps) {
    const copy = getPublicCopy(page.locale);
    const hasQuery = page.query !== '';

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
            theme="dark"
        >
            <PublicHead meta={page.meta} />
            <section className="relative overflow-hidden border-b border-white/10">
                <div className="absolute inset-0 category-animated-field" />
                <div className="absolute inset-0 bg-[linear-gradient(90deg,rgba(7,5,4,0.82)_0%,rgba(7,5,4,0.55)_48%,rgba(11,9,7,0.88)_100%)]" />
                <div className="relative px-4 py-8 md:px-8 md:py-10">
                    <div className="mx-auto max-w-7xl">
                        <p className="mb-2 flex items-center gap-3 text-[0.65rem] font-semibold tracking-[0.32em] text-[#e7c889] uppercase">
                            <span className="vitrine-pulse inline-block size-1.5 rounded-full bg-[#e7c889]" />
                            {copy.search.eyebrow}
                        </p>
                        <h1 className="font-display text-3xl leading-tight font-light text-stone-50 md:text-5xl">
                            {hasQuery
                                ? copy.search.resultsFor(page.query)
                                : copy.search.title}
                        </h1>
                        <div className="mt-6 max-w-xl">
                            <SearchForm
                                locale={page.locale}
                                copy={copy}
                                tone="dark"
                                initialQuery={page.query}
                                className="w-full"
                            />
                        </div>
                    </div>
                </div>
            </section>

            <section className="px-4 py-12 md:px-8 md:py-16">
                <div className="mx-auto max-w-7xl">
                    {hasQuery ? (
                        <div className="grid gap-8">
                            <p className="text-sm text-stone-400">
                                {copy.search.results(
                                    page.pagination.from,
                                    page.pagination.to,
                                    page.pagination.total,
                                )}
                            </p>
                            <ProductGrid
                                products={page.products}
                                copy={copy}
                                emptyMessage={copy.search.empty}
                            />
                            <Pagination
                                copy={copy}
                                links={page.pagination.links}
                            />
                        </div>
                    ) : (
                        <p className="rounded-[1.4rem] border border-dashed border-white/15 px-6 py-16 text-center text-sm text-stone-400">
                            {copy.search.prompt}
                        </p>
                    )}
                </div>
            </section>
        </PublicLayout>
    );
}

function Pagination({
    copy,
    links,
}: {
    copy: PublicCopy;
    links: PublicSearchPageProps['pagination']['links'];
}) {
    function visitPage(event: MouseEvent<Element>, href: string | null): void {
        event.preventDefault();

        if (!href) {
            return;
        }

        router.visit(href, { preserveScroll: true });
    }

    if (links.length <= 3) {
        return null;
    }

    return (
        <nav
            aria-label={copy.pagination.label}
            className="flex flex-wrap items-center gap-2 pt-3"
        >
            {links.map((link) => (
                <Link
                    key={link.label}
                    href={link.href ?? '#'}
                    onClick={(event) => visitPage(event, link.href)}
                    className={cn(
                        'min-w-10 rounded-full border px-3 py-2 text-center text-sm transition',
                        link.active
                            ? 'border-[#e7c889] bg-[#e7c889] text-stone-950'
                            : 'border-white/15 text-stone-300 hover:border-[#e7c889]/60 hover:text-stone-50',
                        !link.href && 'pointer-events-none opacity-40',
                    )}
                >
                    {paginationLabel(link.label, copy)}
                </Link>
            ))}
        </nav>
    );
}
