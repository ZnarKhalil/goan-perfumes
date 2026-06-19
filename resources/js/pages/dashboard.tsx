import { Head, Link } from '@inertiajs/react';
import {
    Activity,
    ChartNoAxesCombined,
    Clock3,
    Eye,
    Globe2,
    Laptop,
    MousePointerClick,
    Radio,
    Users,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import type { ReactNode } from 'react';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { adminTitle, dashboardLabels } from '@/lib/de';
import { dashboard } from '@/routes';

type AnalyticsStatus = 'ready' | 'not_configured' | 'unavailable';

type MetricSummary = {
    active_users: number;
    sessions: number;
    page_views: number;
    engagement_rate: number;
};

type RealtimeSummary = {
    active_users: number;
};

type PageRow = {
    title: string;
    url: string;
    views: number;
};

type SourceRow = {
    source: string;
    views: number;
};

type CountryRow = {
    country: string;
    views: number;
};

type DeviceRow = {
    device: string;
    sessions: number;
};

type DailyRow = {
    date: string;
    active_users: number;
    page_views: number;
};

type ChartTextAnchor = 'start' | 'middle' | 'end';

type AnalyticsDashboard = {
    range_days: number;
    property_id: string | null;
    configured: boolean;
    status: AnalyticsStatus;
    message: string | null;
    summary: MetricSummary;
    realtime: RealtimeSummary;
    top_pages: PageRow[];
    top_product_pages: PageRow[];
    top_sources: SourceRow[];
    top_countries: CountryRow[];
    devices: DeviceRow[];
    daily: DailyRow[];
};

type Props = {
    analytics: AnalyticsDashboard;
    filters: {
        range: number;
        ranges: number[];
    };
};

const numberFormatter = new Intl.NumberFormat('de-DE');
const shortDateFormatter = new Intl.DateTimeFormat('de-DE', {
    day: '2-digit',
    month: '2-digit',
});

export default function Dashboard({ analytics, filters }: Props) {
    const summaryCards = [
        {
            label: 'Aktive Nutzer',
            value: numberFormatter.format(analytics.summary.active_users),
            icon: Users,
        },
        {
            label: 'Sitzungen',
            value: numberFormatter.format(analytics.summary.sessions),
            icon: MousePointerClick,
        },
        {
            label: 'Seitenaufrufe',
            value: numberFormatter.format(analytics.summary.page_views),
            icon: Eye,
        },
        {
            label: 'Engagement-Rate',
            value: `${analytics.summary.engagement_rate.toLocaleString('de-DE')}%`,
            icon: Activity,
        },
    ];

    return (
        <>
            <Head title={adminTitle(dashboardLabels.dashboard)} />

            <div className="flex h-full flex-1 flex-col gap-6 p-4">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        title="Dashboard"
                        description="Traffic, Quellen und meistbesuchte Seiten aus Google Analytics."
                    />

                    <div className="flex flex-wrap gap-2">
                        {filters.ranges.map((range) => (
                            <Button
                                key={range}
                                asChild
                                size="sm"
                                variant={
                                    filters.range === range
                                        ? 'default'
                                        : 'outline'
                                }
                            >
                                <Link
                                    href={dashboard({
                                        query: { range },
                                    })}
                                    preserveScroll
                                >
                                    {range} Tage
                                </Link>
                            </Button>
                        ))}
                    </div>
                </div>

                {analytics.message && (
                    <div className="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-200">
                        {analytics.message}
                    </div>
                )}

                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {summaryCards.map((item) => {
                        const Icon = item.icon;

                        return (
                            <div
                                key={item.label}
                                className="rounded-lg border bg-card p-5 text-card-foreground shadow-xs"
                            >
                                <div className="flex items-center justify-between gap-4">
                                    <p className="text-sm text-muted-foreground">
                                        {item.label}
                                    </p>
                                    <Icon className="size-4 text-muted-foreground" />
                                </div>
                                <p className="mt-3 text-3xl font-semibold tracking-tight">
                                    {item.value}
                                </p>
                            </div>
                        );
                    })}
                </div>

                <div className="grid gap-4 xl:grid-cols-[1.4fr_1fr]">
                    <ReportPanel
                        title="Traffic-Verlauf"
                        icon={ChartNoAxesCombined}
                    >
                        <TrafficLineChart rows={analytics.daily} />
                    </ReportPanel>

                    <ReportPanel title="Geräte-Sitzungen" icon={Laptop}>
                        <DeviceBarChart rows={analytics.devices} />
                    </ReportPanel>
                </div>

                <div className="grid gap-4 xl:grid-cols-[1.4fr_1fr]">
                    <ReportPanel title="Top-Seiten" icon={ChartNoAxesCombined}>
                        <PageTable
                            rows={analytics.top_pages}
                            empty="Noch keine Seitendaten vorhanden."
                        />
                    </ReportPanel>

                    <ReportPanel title="Realtime" icon={Radio}>
                        <div className="flex items-center justify-between gap-4 rounded-md border p-4">
                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Aktive Nutzer in den letzten Minuten
                                </p>
                                <p className="mt-2 text-3xl font-semibold">
                                    {numberFormatter.format(
                                        analytics.realtime.active_users,
                                    )}
                                </p>
                            </div>
                            <Clock3 className="size-5 text-muted-foreground" />
                        </div>
                    </ReportPanel>
                </div>

                <div className="grid gap-4 xl:grid-cols-2">
                    <ReportPanel title="Top-Produktseiten" icon={Eye}>
                        <PageTable
                            rows={analytics.top_product_pages}
                            empty="Noch keine Produktseiten-Daten vorhanden."
                        />
                    </ReportPanel>

                    <ReportPanel title="Traffic-Quellen" icon={Globe2}>
                        <SimpleRows
                            rows={analytics.top_sources}
                            labelKey="source"
                            valueKey="views"
                            empty="Noch keine Quellen-Daten vorhanden."
                        />
                    </ReportPanel>
                </div>

                <div className="grid gap-4 xl:grid-cols-2">
                    <ReportPanel title="Länder" icon={Globe2}>
                        <SimpleRows
                            rows={analytics.top_countries}
                            labelKey="country"
                            valueKey="views"
                            empty="Noch keine Länder-Daten vorhanden."
                        />
                    </ReportPanel>

                    <ReportPanel title="Geräte" icon={Laptop}>
                        <SimpleRows
                            rows={analytics.devices}
                            labelKey="device"
                            valueKey="sessions"
                            empty="Noch keine Geräte-Daten vorhanden."
                        />
                    </ReportPanel>
                </div>

                <div className="text-xs text-muted-foreground">
                    <Badge variant="outline" className="mr-2">
                        Property {analytics.property_id ?? 'nicht gesetzt'}
                    </Badge>
                    GA4-Daten können zeitverzögert, modelliert oder durch
                    Cookie-Einwilligungen reduziert sein.
                </div>
            </div>
        </>
    );
}

function TrafficLineChart({ rows }: { rows: DailyRow[] }) {
    if (rows.length === 0) {
        return (
            <p className="text-sm text-muted-foreground">
                Noch keine Verlaufsdaten vorhanden.
            </p>
        );
    }

    const width = 640;
    const height = 220;
    const paddingX = 32;
    const paddingTop = 22;
    const chartHeight = 150;
    const chartWidth = width - paddingX * 2;
    const maxValue = Math.max(
        1,
        ...rows.flatMap((row) => [row.page_views, row.active_users]),
    );
    const pageViewPoints = chartPoints({
        rows,
        valueKey: 'page_views',
        maxValue,
        paddingX,
        paddingTop,
        chartWidth,
        chartHeight,
    });
    const activeUserPoints = chartPoints({
        rows,
        valueKey: 'active_users',
        maxValue,
        paddingX,
        paddingTop,
        chartWidth,
        chartHeight,
    });
    const dateLabels = chartDateLabels(rows);

    return (
        <div className="grid gap-4">
            <div className="flex flex-wrap gap-x-5 gap-y-2 text-xs text-muted-foreground">
                <span className="flex items-center gap-2">
                    <span className="size-2 rounded-full bg-emerald-500" />
                    Seitenaufrufe
                </span>
                <span className="flex items-center gap-2">
                    <span className="size-2 rounded-full bg-sky-500" />
                    Aktive Nutzer
                </span>
            </div>

            <svg
                role="img"
                aria-label="Traffic-Verlauf"
                viewBox={`0 0 ${width} ${height}`}
                className="h-64 w-full overflow-visible"
            >
                {[0, 0.25, 0.5, 0.75, 1].map((tick) => {
                    const y = paddingTop + chartHeight * tick;

                    return (
                        <line
                            key={tick}
                            x1={paddingX}
                            x2={width - paddingX}
                            y1={y}
                            y2={y}
                            className="stroke-border"
                            strokeWidth="1"
                        />
                    );
                })}

                <polyline
                    points={pageViewPoints}
                    fill="none"
                    className="stroke-emerald-500"
                    strokeWidth="3"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                />
                <polyline
                    points={activeUserPoints}
                    fill="none"
                    className="stroke-sky-500"
                    strokeWidth="3"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                />

                {dateLabels.map((label) => (
                    <text
                        key={`${label.date}-${label.x}`}
                        x={label.x}
                        y={height - 18}
                        textAnchor={label.anchor}
                        className="fill-muted-foreground text-[12px]"
                    >
                        {formatShortDate(label.date)}
                    </text>
                ))}
            </svg>
        </div>
    );
}

function DeviceBarChart({ rows }: { rows: DeviceRow[] }) {
    if (rows.length === 0) {
        return (
            <p className="text-sm text-muted-foreground">
                Noch keine Geräte-Daten vorhanden.
            </p>
        );
    }

    const maxSessions = Math.max(1, ...rows.map((row) => row.sessions));

    return (
        <div className="grid gap-4">
            {rows.map((row) => {
                const width = Math.max(6, (row.sessions / maxSessions) * 100);

                return (
                    <div key={row.device} className="grid gap-2">
                        <div className="flex items-center justify-between gap-4 text-sm">
                            <span className="capitalize">{row.device}</span>
                            <span className="font-medium">
                                {numberFormatter.format(row.sessions)}
                            </span>
                        </div>
                        <div className="h-2 rounded-full bg-muted">
                            <div
                                className="h-full rounded-full bg-emerald-500"
                                style={{ width: `${width}%` }}
                            />
                        </div>
                    </div>
                );
            })}
        </div>
    );
}

function chartPoints({
    rows,
    valueKey,
    maxValue,
    paddingX,
    paddingTop,
    chartWidth,
    chartHeight,
}: {
    rows: DailyRow[];
    valueKey: 'active_users' | 'page_views';
    maxValue: number;
    paddingX: number;
    paddingTop: number;
    chartWidth: number;
    chartHeight: number;
}) {
    return rows
        .map((row, index) => {
            const x =
                rows.length === 1
                    ? paddingX + chartWidth / 2
                    : paddingX + (index / (rows.length - 1)) * chartWidth;
            const y =
                paddingTop +
                chartHeight -
                (row[valueKey] / maxValue) * chartHeight;

            return `${x},${y}`;
        })
        .join(' ');
}

function chartDateLabels(
    rows: DailyRow[],
): Array<{ date: string; x: number; anchor: ChartTextAnchor }> {
    if (rows.length === 1) {
        return [
            {
                date: rows[0].date,
                x: 320,
                anchor: 'middle',
            } as const,
        ];
    }

    const labels: Array<{ index: number; anchor: ChartTextAnchor }> = [
        { index: 0, anchor: 'start' },
        { index: rows.length - 1, anchor: 'end' },
    ];

    if (rows.length > 3) {
        const middleLabel: { index: number; anchor: ChartTextAnchor } = {
            index: Math.floor(rows.length / 2),
            anchor: 'middle',
        };

        return [labels[0], middleLabel, labels[1]].map((label) => ({
            date: rows[label.index].date,
            x:
                label.index === 0
                    ? 32
                    : label.index === rows.length - 1
                      ? 608
                      : 320,
            anchor: label.anchor,
        }));
    }

    return labels.map((label) => ({
        date: rows[label.index].date,
        x: label.index === 0 ? 32 : 608,
        anchor: label.anchor,
    }));
}

function formatShortDate(date: string) {
    const parsed = new Date(`${date}T00:00:00`);

    if (Number.isNaN(parsed.getTime())) {
        return date;
    }

    return shortDateFormatter.format(parsed);
}

function ReportPanel({
    title,
    icon: Icon,
    children,
}: {
    title: string;
    icon: LucideIcon;
    children: ReactNode;
}) {
    return (
        <section className="rounded-lg border bg-card p-5 text-card-foreground shadow-xs">
            <div className="mb-4 flex items-center justify-between gap-4">
                <h2 className="text-base font-semibold">{title}</h2>
                <Icon className="size-4 text-muted-foreground" />
            </div>
            {children}
        </section>
    );
}

function PageTable({ rows, empty }: { rows: PageRow[]; empty: string }) {
    if (rows.length === 0) {
        return <p className="text-sm text-muted-foreground">{empty}</p>;
    }

    return (
        <div className="grid gap-3">
            {rows.map((row) => (
                <div
                    key={`${row.title}-${row.url}`}
                    className="grid gap-1 rounded-md border p-3"
                >
                    <div className="flex items-start justify-between gap-4">
                        <p className="font-medium">{row.title || '—'}</p>
                        <p className="text-sm font-medium">
                            {numberFormatter.format(row.views)}
                        </p>
                    </div>
                    <p className="truncate text-xs text-muted-foreground">
                        {row.url || '—'}
                    </p>
                </div>
            ))}
        </div>
    );
}

function SimpleRows<T extends Record<string, string | number>>({
    rows,
    labelKey,
    valueKey,
    empty,
}: {
    rows: T[];
    labelKey: keyof T;
    valueKey: keyof T;
    empty: string;
}) {
    if (rows.length === 0) {
        return <p className="text-sm text-muted-foreground">{empty}</p>;
    }

    return (
        <div className="grid gap-2">
            {rows.map((row) => (
                <div
                    key={String(row[labelKey])}
                    className="flex items-center justify-between gap-4 rounded-md border px-3 py-2"
                >
                    <p className="text-sm capitalize">{row[labelKey]}</p>
                    <p className="text-sm font-medium">
                        {numberFormatter.format(Number(row[valueKey]))}
                    </p>
                </div>
            ))}
        </div>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: dashboardLabels.dashboard,
            href: dashboard(),
        },
    ],
};
