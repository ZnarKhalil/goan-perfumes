import { Head, Link } from '@inertiajs/react';
import { Pencil } from 'lucide-react';
import DataTable from '@/components/dashboard/data-table';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { adminTitle, dashboardLabels } from '@/lib/de';
import pageSectionsRoutes from '@/routes/dashboard/page-sections';

type SectionRow = {
    id: number;
    key: string;
    label: string;
    type: string;
    sort_order: number;
    is_active: boolean;
    title: string;
    summary: string;
};

type Props = {
    sections: SectionRow[];
};

const typeLabels: Record<string, string> = {
    image: 'Bild',
    text: 'Text',
    product_list: 'Produktliste',
};

export default function PageSectionsIndex({ sections }: Props) {
    return (
        <>
            <Head title={adminTitle(dashboardLabels.pageSections)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Seiten-Inhalt"
                    description="Bearbeite die festen Inhaltsbereiche der Startseite."
                />

                <DataTable<SectionRow>
                    rows={sections}
                    rowKey={(row) => row.id}
                    emptyMessage="Keine Seitenbereiche angelegt."
                    columns={[
                        {
                            key: 'label',
                            label: 'Bereich',
                            render: (row) => (
                                <div>
                                    <div className="font-medium">
                                        {row.label}
                                    </div>
                                    <div className="text-xs text-muted-foreground">
                                        {row.key}
                                    </div>
                                </div>
                            ),
                        },
                        {
                            key: 'title',
                            label: 'Titel',
                        },
                        {
                            key: 'summary',
                            label: 'Inhalt',
                        },
                        {
                            key: 'type',
                            label: 'Typ',
                            render: (row) => typeLabels[row.type] ?? row.type,
                        },
                        {
                            key: 'sort_order',
                            label: 'Reihenfolge',
                            className: 'w-28',
                        },
                        {
                            key: 'status',
                            label: 'Status',
                            className: 'w-28',
                            render: (row) => (
                                <Badge
                                    variant={
                                        row.is_active ? 'outline' : 'secondary'
                                    }
                                >
                                    {row.is_active ? 'Aktiv' : 'Inaktiv'}
                                </Badge>
                            ),
                        },
                    ]}
                    actions={(row) => (
                        <Button asChild variant="ghost" size="sm">
                            <Link
                                href={pageSectionsRoutes.edit({
                                    page_section: row.id,
                                })}
                            >
                                <Pencil className="h-4 w-4" />
                            </Link>
                        </Button>
                    )}
                />
            </div>
        </>
    );
}

PageSectionsIndex.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        {
            title: dashboardLabels.pageSections,
            href: pageSectionsRoutes.index(),
        },
    ],
};
