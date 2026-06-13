import { Head, Link, router } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import ProductController from '@/actions/App/Http/Controllers/Dashboard/ProductController';
import DataTable from '@/components/dashboard/data-table';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
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
};

const euro = new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'EUR',
});

export default function ProductsIndex({ products, pagination }: Props) {
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
