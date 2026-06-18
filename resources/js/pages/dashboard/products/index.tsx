import { Head, Link, router } from '@inertiajs/react';
import {
    ArrowDownAZ,
    ArrowUpAZ,
    Pencil,
    Plus,
    RotateCcw,
    Trash2,
} from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import ProductController from '@/actions/App/Http/Controllers/Dashboard/ProductController';
import DataTable from '@/components/dashboard/data-table';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { adminTitle, dashboardLabels } from '@/lib/de';
import productsRoutes from '@/routes/dashboard/products';

type ProductRow = {
    id: number;
    slug: string;
    name: string;
    brand: string | null;
    categories: string[];
    min_price: string | null;
    max_price: string | null;
    variants_count: number;
    is_active: boolean;
    is_featured: boolean;
    image_url: string | null;
};

type CategoryOption = {
    id: number;
    name: string;
};

type Filters = {
    name: string;
    brand: string;
    category: number | null;
    status: string | null;
    featured: string | null;
    sort: string;
    direction: string;
};

const ALL = '__all__';

const sortOptions: { value: string; label: string }[] = [
    { value: 'created', label: 'Neueste' },
    { value: 'name', label: 'Produkt' },
    { value: 'brand', label: 'Marke' },
    { value: 'price', label: 'Preis' },
    { value: 'variants', label: 'Varianten' },
];

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type Pagination = {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLink[];
};

type Props = {
    products: ProductRow[];
    pagination: Pagination;
    filters: Filters;
    categories: CategoryOption[];
};

const euro = new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'EUR',
});

export default function ProductsIndex({
    products,
    pagination,
    filters,
    categories,
}: Props) {
    const [nameSearch, setNameSearch] = useState(filters.name);
    const [brandSearch, setBrandSearch] = useState(filters.brand);
    const isInitialMount = useRef(true);

    const applyFilters = (overrides: Partial<Filters>) => {
        const next: Filters = { ...filters, ...overrides };
        const query: Record<string, string> = {};

        if (next.name) {
            query.name = next.name;
        }

        if (next.brand) {
            query.brand = next.brand;
        }

        if (next.category !== null) {
            query.category = String(next.category);
        }

        if (next.status !== null) {
            query.status = next.status;
        }

        if (next.featured !== null) {
            query.featured = next.featured;
        }

        if (next.sort !== 'created') {
            query.sort = next.sort;
        }

        if (next.direction !== 'desc') {
            query.direction = next.direction;
        }

        router.get(productsRoutes.index().url, query, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    };

    // Debounce the free-text inputs so we don't fire a request per keystroke.
    useEffect(() => {
        if (isInitialMount.current) {
            isInitialMount.current = false;

            return;
        }

        const timeout = setTimeout(() => {
            if (nameSearch !== filters.name || brandSearch !== filters.brand) {
                applyFilters({ name: nameSearch, brand: brandSearch });
            }
        }, 350);

        return () => clearTimeout(timeout);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [nameSearch, brandSearch]);

    const hasActiveFilters =
        filters.name !== '' ||
        filters.brand !== '' ||
        filters.category !== null ||
        filters.status !== null ||
        filters.featured !== null ||
        filters.sort !== 'created' ||
        filters.direction !== 'desc';

    const resetFilters = () => {
        setNameSearch('');
        setBrandSearch('');
        router.get(
            productsRoutes.index().url,
            {},
            { preserveScroll: true, replace: true },
        );
    };

    const remove = (row: ProductRow) => {
        if (
            !confirm(
                `Produkt "${row.name}" wirklich löschen? Diese Aktion lässt sich nicht rückgängig machen.`,
            )
        ) {
            return;
        }

        router.delete(ProductController.destroy.url({ product: row.id }), {
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title={adminTitle(dashboardLabels.products)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="flex items-start justify-between gap-4">
                    <Heading
                        title="Produkte"
                        description="Verwalte Katalogprodukte, Varianten, Filterwerte und Bilder."
                    />
                    <Button asChild>
                        <Link href={productsRoutes.create()}>
                            <Plus className="mr-1 h-4 w-4" /> Neues Produkt
                        </Link>
                    </Button>
                </div>

                <div className="rounded-lg border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <div className="space-y-1.5">
                            <Label htmlFor="filter-name">Produktname</Label>
                            <Input
                                id="filter-name"
                                value={nameSearch}
                                onChange={(event) =>
                                    setNameSearch(event.target.value)
                                }
                                placeholder="Nach Name suchen…"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <Label htmlFor="filter-brand">Marke</Label>
                            <Input
                                id="filter-brand"
                                value={brandSearch}
                                onChange={(event) =>
                                    setBrandSearch(event.target.value)
                                }
                                placeholder="Nach Marke suchen…"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <Label>Kategorie</Label>
                            <Select
                                value={
                                    filters.category === null
                                        ? ALL
                                        : String(filters.category)
                                }
                                onValueChange={(value) =>
                                    applyFilters({
                                        category:
                                            value === ALL
                                                ? null
                                                : Number(value),
                                    })
                                }
                            >
                                <SelectTrigger className="w-full">
                                    <SelectValue />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value={ALL}>
                                        Alle Kategorien
                                    </SelectItem>
                                    {categories.map((category) => (
                                        <SelectItem
                                            key={category.id}
                                            value={String(category.id)}
                                        >
                                            {category.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </div>

                        <div className="space-y-1.5">
                            <Label>Status</Label>
                            <Select
                                value={filters.status ?? ALL}
                                onValueChange={(value) =>
                                    applyFilters({
                                        status: value === ALL ? null : value,
                                    })
                                }
                            >
                                <SelectTrigger className="w-full">
                                    <SelectValue />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value={ALL}>
                                        Alle Status
                                    </SelectItem>
                                    <SelectItem value="active">
                                        Aktiv
                                    </SelectItem>
                                    <SelectItem value="inactive">
                                        Inaktiv
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div className="space-y-1.5">
                            <Label>Highlight</Label>
                            <Select
                                value={filters.featured ?? ALL}
                                onValueChange={(value) =>
                                    applyFilters({
                                        featured: value === ALL ? null : value,
                                    })
                                }
                            >
                                <SelectTrigger className="w-full">
                                    <SelectValue />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value={ALL}>Alle</SelectItem>
                                    <SelectItem value="yes">
                                        Nur Highlights
                                    </SelectItem>
                                    <SelectItem value="no">
                                        Ohne Highlight
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div className="space-y-1.5">
                            <Label>Sortieren nach</Label>
                            <div className="flex gap-2">
                                <Select
                                    value={filters.sort}
                                    onValueChange={(value) =>
                                        applyFilters({ sort: value })
                                    }
                                >
                                    <SelectTrigger className="w-full">
                                        <SelectValue />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {sortOptions.map((option) => (
                                            <SelectItem
                                                key={option.value}
                                                value={option.value}
                                            >
                                                {option.label}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="icon"
                                    aria-label={
                                        filters.direction === 'asc'
                                            ? 'Aufsteigend'
                                            : 'Absteigend'
                                    }
                                    onClick={() =>
                                        applyFilters({
                                            direction:
                                                filters.direction === 'asc'
                                                    ? 'desc'
                                                    : 'asc',
                                        })
                                    }
                                >
                                    {filters.direction === 'asc' ? (
                                        <ArrowUpAZ className="h-4 w-4" />
                                    ) : (
                                        <ArrowDownAZ className="h-4 w-4" />
                                    )}
                                </Button>
                            </div>
                        </div>
                    </div>

                    {hasActiveFilters && (
                        <div className="mt-4 flex justify-end">
                            <Button
                                type="button"
                                variant="ghost"
                                size="sm"
                                onClick={resetFilters}
                            >
                                <RotateCcw className="mr-1 h-4 w-4" /> Filter
                                zurücksetzen
                            </Button>
                        </div>
                    )}
                </div>

                <DataTable<ProductRow>
                    rows={products}
                    rowKey={(row) => row.id}
                    emptyMessage="Noch keine Produkte angelegt."
                    columns={[
                        {
                            key: 'image',
                            label: 'Bild',
                            className: 'w-20',
                            render: (row) =>
                                row.image_url ? (
                                    <img
                                        src={row.image_url}
                                        alt=""
                                        className="h-12 w-12 rounded object-cover"
                                    />
                                ) : (
                                    <span className="text-xs text-muted-foreground">
                                        —
                                    </span>
                                ),
                        },
                        {
                            key: 'name',
                            label: 'Produkt',
                            render: (row) => (
                                <div>
                                    <div className="font-medium">
                                        {row.name}
                                    </div>
                                    <div className="text-xs text-muted-foreground">
                                        {row.slug}
                                    </div>
                                </div>
                            ),
                        },
                        {
                            key: 'brand',
                            label: 'Marke',
                            render: (row) => row.brand ?? '—',
                        },
                        {
                            key: 'categories',
                            label: 'Kategorien',
                            render: (row) =>
                                row.categories.length > 0
                                    ? row.categories.join(', ')
                                    : '—',
                        },
                        {
                            key: 'price',
                            label: 'Preis',
                            render: (row) => formatPriceRange(row),
                        },
                        {
                            key: 'status',
                            label: 'Status',
                            className: 'w-36',
                            render: (row) => (
                                <div className="flex flex-wrap gap-1">
                                    {row.is_active ? (
                                        <Badge variant="outline">Aktiv</Badge>
                                    ) : (
                                        <Badge variant="secondary">
                                            Inaktiv
                                        </Badge>
                                    )}
                                    {row.is_featured && (
                                        <Badge>Highlight</Badge>
                                    )}
                                </div>
                            ),
                        },
                    ]}
                    actions={(row) => (
                        <>
                            <Button asChild variant="ghost" size="sm">
                                <Link
                                    href={productsRoutes.edit({
                                        product: row.id,
                                    })}
                                >
                                    <Pencil className="h-4 w-4" />
                                </Link>
                            </Button>
                            <Button
                                variant="ghost"
                                size="sm"
                                onClick={() => remove(row)}
                            >
                                <Trash2 className="h-4 w-4" />
                            </Button>
                        </>
                    )}
                />

                {pagination.last_page > 1 && (
                    <nav
                        aria-label="Seitennavigation"
                        className="flex flex-wrap items-center justify-between gap-3"
                    >
                        <p className="text-sm text-muted-foreground">
                            {pagination.from}–{pagination.to} von{' '}
                            {pagination.total} Produkten
                        </p>
                        <div className="flex flex-wrap gap-1">
                            {pagination.links.map((link, index) =>
                                link.url ? (
                                    <Button
                                        key={index}
                                        asChild
                                        variant={
                                            link.active ? 'default' : 'outline'
                                        }
                                        size="sm"
                                    >
                                        <Link href={link.url} preserveScroll>
                                            {paginationLabel(link.label)}
                                        </Link>
                                    </Button>
                                ) : (
                                    <Button
                                        key={index}
                                        variant="outline"
                                        size="sm"
                                        disabled
                                    >
                                        {paginationLabel(link.label)}
                                    </Button>
                                ),
                            )}
                        </div>
                    </nav>
                )}
            </div>
        </>
    );
}

function paginationLabel(label: string): string {
    if (label.includes('Previous')) {
        return '‹ Zurück';
    }

    if (label.includes('Next')) {
        return 'Weiter ›';
    }

    return label;
}

function formatPriceRange(row: ProductRow): string {
    if (!row.min_price || !row.max_price) {
        return '—';
    }

    const min = euro.format(Number(row.min_price));
    const max = euro.format(Number(row.max_price));

    return min === max ? min : `${min} – ${max}`;
}

ProductsIndex.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.products, href: productsRoutes.index() },
    ],
};
