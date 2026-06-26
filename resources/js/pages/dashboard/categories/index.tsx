import { Head, Link, router } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import CategoryController from '@/actions/App/Http/Controllers/Dashboard/CategoryController';
import DataTable from '@/components/dashboard/data-table';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { adminTitle, dashboardLabels } from '@/lib/de';
import categoriesRoutes from '@/routes/dashboard/categories';

type CategoryRow = {
    id: number;
    slug: string;
    name: string;
    parent_name: string | null;
    sort_order: number;
    is_active: boolean;
    image_url: string | null;
};

type Props = {
    categories: CategoryRow[];
};

export default function CategoriesIndex({ categories }: Props) {
    const remove = (row: CategoryRow) => {
        if (
            !confirm(
                `Kategorie "${row.name}" wirklich löschen? Diese Aktion lässt sich nicht rückgängig machen.`,
            )
        ) {
            return;
        }

        router.delete(CategoryController.destroy.url({ category: row.id }), {
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title={adminTitle(dashboardLabels.categories)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="flex items-start justify-between">
                    <Heading
                        title="Kategorien"
                        description="Verwalte die Hauptkategorien des Onlineshops."
                    />
                    <Button asChild>
                        <Link href={categoriesRoutes.create()}>
                            <Plus className="mr-1 h-4 w-4" /> Neue Kategorie
                        </Link>
                    </Button>
                </div>

                <DataTable<CategoryRow>
                    rows={categories}
                    rowKey={(row) => row.id}
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
                                        className="size-12 rounded-md object-cover"
                                    />
                                ) : (
                                    <div className="size-12 rounded-md border border-dashed border-sidebar-border/70 bg-muted/30 dark:border-sidebar-border" />
                                ),
                        },
                        {
                            key: 'name',
                            label: 'Name',
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
                            key: 'parent',
                            label: 'Übergeordnet',
                            render: (row) => row.parent_name ?? '—',
                        },
                        {
                            key: 'sort_order',
                            label: 'Reihenfolge',
                            className: 'w-28',
                        },
                        {
                            key: 'status',
                            label: 'Status',
                            className: 'w-24',
                            render: (row) =>
                                row.is_active ? (
                                    <Badge variant="outline">Aktiv</Badge>
                                ) : (
                                    <Badge variant="secondary">Inaktiv</Badge>
                                ),
                        },
                    ]}
                    actions={(row) => (
                        <>
                            <Button asChild variant="ghost" size="sm">
                                <Link
                                    href={categoriesRoutes.edit({
                                        category: row.id,
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
            </div>
        </>
    );
}

CategoriesIndex.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.categories, href: categoriesRoutes.index() },
    ],
};
