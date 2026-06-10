import { Head, Link } from '@inertiajs/react';
import { ChevronDown, Menu, Search, X } from 'lucide-react';
import { useMemo, useState } from 'react';
import ProductGrid from '@/components/public/product-grid';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import PublicLayout from '@/layouts/public-layout';
import { getPublicCopy, paginationLabel } from '@/lib/public-copy';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type {
    PublicCategoryPageProps,
    PublicFilterGroup,
    PublicFilterValue,
} from '@/types/public';

export default function Category(page: PublicCategoryPageProps) {
    const copy = getPublicCopy(page.locale);
    const isRtl = page.locale?.dir === 'rtl';
    const activeFilters = page.filters.flatMap((group) =>
        group.values
            .filter((value) => value.selected)
            .map((value) => ({ group, value })),
    );

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
            theme="dark"
        >
            <Head title={page.meta.title}>
                <meta name="description" content={page.meta.description} />
            </Head>
            <section className="relative min-h-[58svh] overflow-hidden">
                {page.category.banner_url ? (
                    <img
                        src={page.category.banner_url}
                        alt=""
                        className="absolute inset-0 h-full w-full object-cover"
                    />
                ) : (
                    <div className="absolute inset-0 bg-[radial-gradient(120%_120%_at_30%_10%,#241708,#0b0907)]" />
                )}
                <div className="absolute inset-0 bg-[linear-gradient(180deg,rgba(7,5,4,0.5)_0%,rgba(7,5,4,0.35)_45%,rgba(11,9,7,0.96)_100%)]" />
                <div className="absolute inset-0 grain-layer opacity-[0.1] mix-blend-overlay" />
                <div className="relative flex min-h-[58svh] items-end px-4 pt-28 pb-12 md:px-8 md:pt-32 md:pb-16">
                    <div className="max-w-4xl">
                        <p className="mb-5 flex items-center gap-3 text-[0.7rem] font-semibold tracking-[0.38em] text-[#e7c889] uppercase">
                            <span className="vitrine-pulse inline-block size-2 rounded-full bg-[#e7c889]" />
                            {copy.category.eyebrow}
                        </p>
                        <h1 className="font-display text-5xl leading-[1.02] font-light text-stone-50 md:text-7xl">
                            {page.category.name}
                        </h1>
                        <p className="mt-5 max-w-2xl text-base leading-7 text-stone-300 md:text-lg">
                            {page.category.description}
                        </p>
                    </div>
                </div>
            </section>

            <section className="px-4 py-12 md:px-8 md:py-16">
                <div className="mx-auto max-w-7xl">
                    <div className="grid gap-8">
                        <div className="flex flex-col justify-between gap-3 border-b border-white/10 pb-5 md:flex-row md:items-end">
                            <div>
                                <p className="text-sm text-stone-400">
                                    {copy.category.results(
                                        page.pagination.from,
                                        page.pagination.to,
                                        page.pagination.total,
                                    )}
                                </p>
                                <h2 className="mt-2 font-display text-3xl font-light text-stone-50">
                                    {copy.category.filteredSelection}
                                </h2>
                            </div>
                            <div className="flex flex-col gap-3 md:items-end">
                                <p className="max-w-sm text-sm leading-6 text-stone-400">
                                    {copy.category.filterHelp}
                                </p>
                                <FilterSheet
                                    activeFilters={activeFilters}
                                    categoryHref={page.category.href}
                                    copy={copy}
                                    filters={page.filters}
                                    isRtl={isRtl}
                                    selectedFilters={page.selected_filters}
                                />
                            </div>
                        </div>

                        <ProductGrid
                            products={page.products}
                            copy={copy}
                            emptyMessage={copy.category.empty}
                        />

                        <Pagination copy={copy} links={page.pagination.links} />
                    </div>
                </div>
            </section>
        </PublicLayout>
    );
}

function FilterSheet({
    activeFilters,
    categoryHref,
    copy,
    filters,
    isRtl,
    selectedFilters,
}: {
    activeFilters: ActiveFilter[];
    categoryHref: string;
    copy: PublicCopy;
    filters: PublicFilterGroup[];
    isRtl: boolean;
    selectedFilters: PublicCategoryPageProps['selected_filters'];
}) {
    return (
        <Sheet>
            <SheetTrigger asChild>
                <button
                    type="button"
                    className="relative inline-flex h-11 items-center gap-2 rounded-full border border-[#e7c889]/40 px-4 text-sm font-medium text-stone-100 transition hover:bg-[#e7c889] hover:text-stone-950"
                >
                    <Menu className="size-5 shrink-0" />
                    <span>{copy.category.filter}</span>
                    {activeFilters.length > 0 && (
                        <span className="absolute -top-2 -right-2 min-w-5 rounded-full bg-[#e7c889] px-1.5 py-0.5 text-center text-xs font-semibold text-stone-950">
                            {activeFilters.length}
                        </span>
                    )}
                </button>
            </SheetTrigger>
            <SheetContent
                side={isRtl ? 'right' : 'left'}
                className="h-svh w-[92vw] gap-0 overflow-hidden border-white/10 bg-[#0b0907] p-0 text-stone-100 sm:max-w-md"
            >
                <SheetHeader
                    className={cn(
                        'shrink-0 border-b border-white/10 px-5 py-5',
                        isRtl ? 'text-right' : 'text-left',
                    )}
                >
                    <SheetTitle className="font-display text-3xl text-stone-50">
                        {copy.category.filter}
                    </SheetTitle>
                </SheetHeader>
                <div className="min-h-0 flex-1 overflow-y-auto px-5 pb-8">
                    <FilterPanel
                        activeFilters={activeFilters}
                        categoryHref={categoryHref}
                        copy={copy}
                        filters={filters}
                        selectedFilters={selectedFilters}
                    />
                </div>
            </SheetContent>
        </Sheet>
    );
}

type ActiveFilter = {
    group: PublicFilterGroup;
    value: PublicFilterValue;
};

function FilterPanel({
    activeFilters,
    categoryHref,
    copy,
    filters,
    selectedFilters,
}: {
    activeFilters: ActiveFilter[];
    categoryHref: string;
    copy: PublicCopy;
    filters: PublicFilterGroup[];
    selectedFilters: PublicCategoryPageProps['selected_filters'];
}) {
    const [query, setQuery] = useState('');
    const searchableQuery = query.trim().toLocaleLowerCase();
    const filteredGroups = useMemo(
        () =>
            filters
                .map((group) => {
                    const values =
                        searchableQuery === ''
                            ? group.values
                            : group.values.filter((value) =>
                                  value.name
                                      .toLocaleLowerCase()
                                      .includes(searchableQuery),
                              );

                    return { ...group, values };
                })
                .filter((group) => group.values.length > 0),
        [filters, searchableQuery],
    );

    return (
        <>
            <div className="sticky top-0 z-10 border-b border-white/10 bg-[#0b0907] py-5">
                <div className="flex items-center justify-between gap-4">
                    <h2 className="text-sm font-semibold tracking-[0.18em] text-[#e7c889] uppercase">
                        {copy.category.filter}
                    </h2>
                    {activeFilters.length > 0 && (
                        <Link
                            href={categoryHref}
                            className="text-xs text-stone-400 underline underline-offset-4 transition hover:text-[#e7c889]"
                        >
                            {copy.category.reset}
                        </Link>
                    )}
                </div>
                <label className="mt-4 flex h-11 items-center gap-3 rounded-full border border-white/10 bg-white/[0.04] px-4 text-sm text-stone-300 focus-within:border-[#e7c889]/60">
                    <Search className="size-4 shrink-0 text-stone-500" />
                    <input
                        type="search"
                        value={query}
                        onChange={(event) => setQuery(event.target.value)}
                        placeholder={copy.category.search}
                        className="min-w-0 flex-1 bg-transparent text-sm text-stone-100 outline-none placeholder:text-stone-500"
                    />
                    {query !== '' && (
                        <button
                            type="button"
                            onClick={() => setQuery('')}
                            className="rounded-full p-1 text-stone-500 transition hover:bg-white/10 hover:text-stone-100"
                            aria-label={copy.category.clearSearch}
                        >
                            <X className="size-3.5" />
                        </button>
                    )}
                </label>
                {activeFilters.length > 0 && (
                    <div className="mt-4 flex flex-wrap gap-2">
                        {activeFilters.map(({ group, value }) => (
                            <Link
                                key={`${group.code}-${value.slug}`}
                                href={buildFilterHref(
                                    categoryHref,
                                    selectedFilters,
                                    group.code,
                                    value.slug,
                                    false,
                                )}
                                className="inline-flex items-center gap-1 rounded-full bg-[#e7c889] px-2.5 py-1.5 text-xs font-medium text-stone-950"
                            >
                                {value.name}
                                <X className="size-3" />
                            </Link>
                        ))}
                    </div>
                )}
            </div>

            <div className="grid gap-3 py-5">
                {filteredGroups.length === 0 && (
                    <p className="rounded-lg border border-white/10 px-4 py-5 text-sm text-stone-400">
                        {copy.category.noFilterResults}
                    </p>
                )}
                {filteredGroups.map((group) => (
                    <FilterGroup
                        key={group.code}
                        categoryHref={categoryHref}
                        copy={copy}
                        forceOpen={searchableQuery !== ''}
                        group={group}
                        selectedFilters={selectedFilters}
                    />
                ))}
            </div>
        </>
    );
}

function FilterGroup({
    categoryHref,
    copy,
    forceOpen,
    group,
    selectedFilters,
}: {
    categoryHref: string;
    copy: PublicCopy;
    forceOpen: boolean;
    group: PublicFilterGroup;
    selectedFilters: PublicCategoryPageProps['selected_filters'];
}) {
    const hasSelectedValues = group.values.some((value) => value.selected);
    const [isOpen, setIsOpen] = useState(hasSelectedValues);
    const isExpanded = forceOpen || isOpen;

    return (
        <section className="overflow-hidden rounded-lg border border-white/10 bg-white/[0.03]">
            <button
                type="button"
                onClick={() => setIsOpen((open) => !open)}
                className="flex min-h-14 w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-white/[0.04]"
                aria-expanded={isExpanded}
            >
                <span className="min-w-0">
                    <span className="block truncate text-sm font-medium text-stone-100">
                        {group.name}
                    </span>
                    <span className="mt-1 block text-xs text-stone-500">
                        {group.is_multiple
                            ? copy.category.filterModeMultiple
                            : copy.category.filterModeSingle}
                        {' · '}
                        {group.values.length}
                    </span>
                </span>
                <ChevronDown
                    className={cn(
                        'size-4 shrink-0 text-stone-500 transition',
                        isExpanded && 'rotate-180 text-[#e7c889]',
                    )}
                />
            </button>
            {isExpanded && (
                <div className="max-h-72 overflow-y-auto border-t border-white/10 px-4 py-4">
                    <div className="flex flex-wrap gap-2">
                        {group.values.map((value) => (
                            <FilterChip
                                key={value.slug}
                                categoryHref={categoryHref}
                                group={group}
                                selectedFilters={selectedFilters}
                                value={value}
                            />
                        ))}
                    </div>
                </div>
            )}
        </section>
    );
}

function FilterChip({
    categoryHref,
    group,
    selectedFilters,
    value,
}: {
    categoryHref: string;
    group: PublicFilterGroup;
    selectedFilters: PublicCategoryPageProps['selected_filters'];
    value: PublicFilterValue;
}) {
    return (
        <Link
            href={buildFilterHref(
                categoryHref,
                selectedFilters,
                group.code,
                value.slug,
                !value.selected,
                group.is_multiple,
            )}
            preserveScroll
            className={cn(
                'rounded-full border px-3 py-2 text-sm transition',
                value.selected
                    ? 'border-[#e7c889] bg-[#e7c889] text-stone-950'
                    : 'border-white/15 text-stone-300 hover:border-[#e7c889]/60 hover:text-stone-50',
            )}
        >
            {value.name}
        </Link>
    );
}

function buildFilterHref(
    basePath: string,
    selectedFilters: PublicCategoryPageProps['selected_filters'],
    groupCode: string,
    valueSlug: string,
    shouldSelect: boolean,
    isMultiple = true,
): string {
    const nextFilters = new Map<string, string[]>(
        Object.entries(selectedFilters).map(([key, values]) => [
            key,
            [...values],
        ]),
    );
    const currentValues = nextFilters.get(groupCode) ?? [];
    const nextValues = shouldSelect
        ? isMultiple
            ? Array.from(new Set([...currentValues, valueSlug]))
            : [valueSlug]
        : currentValues.filter((slug) => slug !== valueSlug);

    if (nextValues.length > 0) {
        nextFilters.set(groupCode, nextValues);
    } else {
        nextFilters.delete(groupCode);
    }

    const params = new URLSearchParams();

    [...nextFilters.entries()].forEach(([key, values]) => {
        if (values.length > 0) {
            params.set(key, values.join(','));
        }
    });

    const query = params.toString();

    return query ? `${basePath}?${query}` : basePath;
}

function Pagination({
    copy,
    links,
}: {
    copy: PublicCopy;
    links: PublicCategoryPageProps['pagination']['links'];
}) {
    return (
        <nav
            aria-label={copy.pagination.label}
            className="flex flex-wrap items-center gap-2 pt-3"
        >
            {links.map((link) => (
                <Link
                    key={link.label}
                    href={link.href ?? '#'}
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
