import { Head, Link } from '@inertiajs/react';
import { SlidersHorizontal, X } from 'lucide-react';
import ProductGrid from '@/components/public/product-grid';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import PublicLayout from '@/layouts/public-layout';
import { cn } from '@/lib/utils';
import type {
    PublicCategoryPageProps,
    PublicFilterGroup,
    PublicFilterValue,
} from '@/types/public';

export default function Category(page: PublicCategoryPageProps) {
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
        >
            <Head title={page.category.name} />
            <section className="relative min-h-[52svh] overflow-hidden">
                {page.category.banner_url && (
                    <img
                        src={page.category.banner_url}
                        alt=""
                        className="absolute inset-0 h-full w-full object-cover"
                    />
                )}
                <div className="absolute inset-0 bg-black/45" />
                <div className="relative flex min-h-[52svh] items-end px-4 py-10 md:px-8 md:py-14">
                    <div className="max-w-4xl text-white">
                        <p className="mb-4 text-xs tracking-[0.28em] text-white/70 uppercase">
                            Kategorie
                        </p>
                        <h1 className="font-serif text-5xl leading-none md:text-7xl">
                            {page.category.name}
                        </h1>
                        <p className="mt-5 max-w-2xl text-base leading-7 text-white/80 md:text-lg">
                            {page.category.description}
                        </p>
                    </div>
                </div>
            </section>

            <section className="px-4 py-8 md:px-8 md:py-12">
                <div className="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[18rem_1fr]">
                    <aside className="hidden lg:sticky lg:top-24 lg:block lg:self-start">
                        <FilterPanel
                            activeFilters={activeFilters}
                            categoryHref={page.category.href}
                            filters={page.filters}
                            selectedFilters={page.selected_filters}
                        />
                    </aside>

                    <div className="grid gap-8">
                        <div className="flex flex-col justify-between gap-3 border-b border-stone-200 pb-5 md:flex-row md:items-end">
                            <div>
                                <p className="text-sm text-stone-500">
                                    Ergebnisse {page.pagination.from}-
                                    {page.pagination.to} von{' '}
                                    {page.pagination.total}
                                </p>
                                <h2 className="mt-2 font-serif text-3xl text-stone-950">
                                    Gefilterte Duftauswahl
                                </h2>
                            </div>
                            <div className="flex flex-col gap-3 md:items-end">
                                <p className="max-w-sm text-sm leading-6 text-stone-600">
                                    Mehrere Werte in einer Gruppe erweitern die
                                    Auswahl. Verschiedene Gruppen verfeinern
                                    sie.
                                </p>
                                <MobileFilterSheet
                                    activeFilters={activeFilters}
                                    categoryHref={page.category.href}
                                    filters={page.filters}
                                    selectedFilters={page.selected_filters}
                                />
                            </div>
                        </div>

                        <ProductGrid
                            products={page.products}
                            emptyMessage="Für diese Filter wurden keine Produkte gefunden."
                        />

                        <Pagination links={page.pagination.links} />
                    </div>
                </div>
            </section>
        </PublicLayout>
    );
}

function MobileFilterSheet({
    activeFilters,
    categoryHref,
    filters,
    selectedFilters,
}: {
    activeFilters: ActiveFilter[];
    categoryHref: string;
    filters: PublicFilterGroup[];
    selectedFilters: PublicCategoryPageProps['selected_filters'];
}) {
    return (
        <Sheet>
            <SheetTrigger asChild>
                <button
                    type="button"
                    className="inline-flex w-fit items-center gap-2 border border-stone-950 px-4 py-2.5 text-sm font-medium text-stone-950 transition hover:bg-stone-950 hover:text-white lg:hidden"
                >
                    <SlidersHorizontal className="size-4" />
                    Filter
                    {activeFilters.length > 0 && (
                        <span className="rounded-full bg-stone-950 px-2 py-0.5 text-xs text-white">
                            {activeFilters.length}
                        </span>
                    )}
                </button>
            </SheetTrigger>
            <SheetContent
                side="left"
                className="w-[88vw] overflow-y-auto bg-[#fbf8f2] p-0 text-stone-950 sm:max-w-md lg:hidden"
            >
                <SheetHeader className="border-b border-stone-200 px-5 py-5 text-left">
                    <SheetTitle className="font-serif text-3xl">
                        Filter
                    </SheetTitle>
                </SheetHeader>
                <div className="px-5 pb-8">
                    <FilterPanel
                        activeFilters={activeFilters}
                        categoryHref={categoryHref}
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
    filters,
    selectedFilters,
}: {
    activeFilters: ActiveFilter[];
    categoryHref: string;
    filters: PublicFilterGroup[];
    selectedFilters: PublicCategoryPageProps['selected_filters'];
}) {
    return (
        <>
            <div className="border-y border-stone-200 py-5">
                <div className="flex items-center justify-between gap-4">
                    <h2 className="text-sm font-medium tracking-wide text-stone-950 uppercase">
                        Filter
                    </h2>
                    {activeFilters.length > 0 && (
                        <Link
                            href={categoryHref}
                            className="text-xs text-stone-500 underline underline-offset-4 hover:text-stone-950"
                        >
                            Zurücksetzen
                        </Link>
                    )}
                </div>
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
                                className="inline-flex items-center gap-1 bg-stone-950 px-2.5 py-1.5 text-xs text-white"
                            >
                                {value.name}
                                <X className="size-3" />
                            </Link>
                        ))}
                    </div>
                )}
            </div>

            <div className="grid gap-7 py-7">
                {filters.map((group) => (
                    <FilterGroup
                        key={group.code}
                        categoryHref={categoryHref}
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
    group,
    selectedFilters,
}: {
    categoryHref: string;
    group: PublicFilterGroup;
    selectedFilters: PublicCategoryPageProps['selected_filters'];
}) {
    return (
        <section className="grid gap-3">
            <div>
                <h3 className="text-sm font-medium text-stone-950">
                    {group.name}
                </h3>
                <p className="mt-1 text-xs text-stone-500">
                    {group.is_multiple ? 'Mehrfachauswahl' : 'Einzelauswahl'}
                </p>
            </div>
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
            className={cn(
                'border px-3 py-2 text-sm transition',
                value.selected
                    ? 'border-stone-950 bg-stone-950 text-white'
                    : 'border-stone-300 text-stone-700 hover:border-stone-950 hover:text-stone-950',
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
    links,
}: {
    links: PublicCategoryPageProps['pagination']['links'];
}) {
    return (
        <nav className="flex flex-wrap items-center gap-2 pt-3">
            {links.map((link) => (
                <Link
                    key={link.label}
                    href={link.href ?? '#'}
                    className={cn(
                        'min-w-10 border px-3 py-2 text-center text-sm transition',
                        link.active
                            ? 'border-stone-950 bg-stone-950 text-white'
                            : 'border-stone-300 text-stone-700 hover:border-stone-950',
                        !link.href && 'pointer-events-none opacity-40',
                    )}
                >
                    {link.label}
                </Link>
            ))}
        </nav>
    );
}
