import { Head, Link, router } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import PromotionController from '@/actions/App/Http/Controllers/Dashboard/PromotionController';
import DataTable from '@/components/dashboard/data-table';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { adminTitle, dashboardLabels } from '@/lib/de';
import promotionsRoutes from '@/routes/dashboard/promotions';

type PromotionRow = {
    id: number;
    title: string;
    starts_at: string | null;
    ends_at: string | null;
    sort_order: number;
    is_active: boolean;
    status: 'active' | 'upcoming' | 'expired' | 'inactive';
};

type Props = {
    promotions: PromotionRow[];
};

const statusLabels = {
    active: 'Aktiv',
    upcoming: 'Geplant',
    expired: 'Abgelaufen',
    inactive: 'Inaktiv',
};

export default function PromotionsIndex({ promotions }: Props) {
    const remove = (row: PromotionRow) => {
        if (
            !confirm(
                `Aktion "${row.title}" wirklich löschen? Diese Aktion lässt sich nicht rückgängig machen.`,
            )
        ) {
            return;
        }

        router.delete(PromotionController.destroy.url({ promotion: row.id }), {
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title={adminTitle(dashboardLabels.promotions)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="flex items-start justify-between gap-4">
                    <Heading
                        title="Aktionen"
                        description="Verwalte Textangebote für die Startseite."
                    />
                    <Button asChild>
                        <Link href={promotionsRoutes.create()}>
                            <Plus className="mr-1 h-4 w-4" /> Neue Aktion
                        </Link>
                    </Button>
                </div>

                <DataTable<PromotionRow>
                    rows={promotions}
                    rowKey={(row) => row.id}
                    emptyMessage="Noch keine Aktionen angelegt."
                    columns={[
                        {
                            key: 'title',
                            label: 'Aktion',
                            render: (row) => (
                                <div className="font-medium">{row.title}</div>
                            ),
                        },
                        {
                            key: 'window',
                            label: 'Laufzeit',
                            render: (row) => (
                                <div className="text-xs">
                                    <div>{row.starts_at ?? 'Sofort'}</div>
                                    <div className="text-muted-foreground">
                                        bis {row.ends_at ?? 'offen'}
                                    </div>
                                </div>
                            ),
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
                                        row.status === 'active'
                                            ? 'outline'
                                            : 'secondary'
                                    }
                                >
                                    {statusLabels[row.status]}
                                </Badge>
                            ),
                        },
                    ]}
                    actions={(row) => (
                        <>
                            <Button asChild variant="ghost" size="sm">
                                <Link
                                    href={promotionsRoutes.edit({
                                        promotion: row.id,
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

PromotionsIndex.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.promotions, href: promotionsRoutes.index() },
    ],
};
