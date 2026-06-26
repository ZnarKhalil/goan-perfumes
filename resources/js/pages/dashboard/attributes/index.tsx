import { Head, Link, router } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import DataTable from '@/components/dashboard/data-table';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { adminTitle, dashboardLabels } from '@/lib/de';
import { publicCatalogCacheTags } from '@/lib/inertia-cache';
import attributesRoutes from '@/routes/dashboard/attributes';

type AttributeRow = {
    id: number;
    code: string;
    name: string;
    sort_order: number;
    is_filterable: boolean;
    is_multiple: boolean;
    values_count: number;
};

type Props = {
    attributes: AttributeRow[];
};

export default function AttributesIndex({ attributes }: Props) {
    const remove = (row: AttributeRow) => {
        if (
            !confirm(
                `Attribut "${row.name}" wirklich löschen? Alle Werte dieses Attributs werden ebenfalls gelöscht.`,
            )
        ) {
            return;
        }

        router.delete(attributesRoutes.destroy({ attribute: row.id }).url, {
            invalidateCacheTags: publicCatalogCacheTags,
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title={adminTitle(dashboardLabels.attributes)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="flex items-start justify-between gap-4">
                    <Heading
                        title="Attribute"
                        description="Verwalte Filtergruppen und ihre Werte."
                    />
                    <Button asChild>
                        <Link href={attributesRoutes.create()}>
                            <Plus className="mr-1 h-4 w-4" /> Neues Attribut
                        </Link>
                    </Button>
                </div>

                <DataTable<AttributeRow>
                    rows={attributes}
                    rowKey={(row) => row.id}
                    columns={[
                        {
                            key: 'name',
                            label: 'Name',
                            render: (row) => (
                                <div>
                                    <div className="font-medium">
                                        {row.name}
                                    </div>
                                    <div className="text-xs text-muted-foreground">
                                        {row.code}
                                    </div>
                                </div>
                            ),
                        },
                        {
                            key: 'values_count',
                            label: 'Werte',
                            className: 'w-24',
                        },
                        {
                            key: 'mode',
                            label: 'Auswahl',
                            className: 'w-32',
                            render: (row) =>
                                row.is_multiple ? 'Mehrfach' : 'Einfach',
                        },
                        {
                            key: 'filterable',
                            label: 'Filter',
                            className: 'w-28',
                            render: (row) =>
                                row.is_filterable ? (
                                    <Badge variant="outline">Aktiv</Badge>
                                ) : (
                                    <Badge variant="secondary">Aus</Badge>
                                ),
                        },
                        {
                            key: 'sort_order',
                            label: 'Reihenfolge',
                            className: 'w-28',
                        },
                    ]}
                    actions={(row) => (
                        <>
                            <Button asChild variant="ghost" size="sm">
                                <Link
                                    href={attributesRoutes.edit({
                                        attribute: row.id,
                                    })}
                                >
                                    <Pencil className="h-4 w-4" />
                                </Link>
                            </Button>
                            <Button
                                type="button"
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

AttributesIndex.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.attributes, href: attributesRoutes.index() },
    ],
};
