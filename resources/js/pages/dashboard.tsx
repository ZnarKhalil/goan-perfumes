import { Head, Link } from '@inertiajs/react';
import {
    Activity,
    ArrowDownRight,
    ArrowUpRight,
    ChartNoAxesCombined,
    CircleHelp,
    Clock3,
    Eye,
    Globe2,
    Laptop,
    MapPin,
    Minus,
    MousePointerClick,
    Radio,
    Users,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import type { ReactNode } from 'react';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { adminTitle, dashboardLabels } from '@/lib/de';
import { cn } from '@/lib/utils';
import { dashboard } from '@/routes';

type AnalyticsStatus = 'ready' | 'not_configured' | 'unavailable';

type MetricSummary = {
    active_users: number;
    sessions: number;
    page_views: number;
    engagement_rate: number;
};

type DatePeriod = {
    start: string;
    end: string;
};

type MetricComparison = {
    previous: number;
    change_value: number;
    change_percent: number | null;
};

type SummaryComparison = {
    active_users: MetricComparison;
    sessions: MetricComparison;
    page_views: MetricComparison;
    engagement_rate: MetricComparison;
};

type RealtimeSummary = {
    active_users: number;
};

type PageRow = {
    title: string;
    url: string;
    views: number;
    title_count: number;
    is_suspicious: boolean;
};

type SourceRow = {
    source: string;
    medium: string | null;
    raw_source_medium: string;
    sessions: number;
    views: number;
    engaged_sessions: number;
    engagement_rate: number;
};

type LandingPageRow = {
    path: string;
    sessions: number;
    views: number;
    engaged_sessions: number;
    engagement_rate: number;
    is_suspicious: boolean;
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
    current_period: DatePeriod;
    previous_period: DatePeriod;
    summary: MetricSummary;
    summary_comparison: SummaryComparison;
    realtime: RealtimeSummary;
    top_pages: PageRow[];
    top_product_pages: PageRow[];
    landing_pages: LandingPageRow[];
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
const periodDateFormatter = new Intl.DateTimeFormat('de-DE', {
    day: '2-digit',
    month: '2-digit',
    year: '2-digit',
});
const compactNumberFormatter = new Intl.NumberFormat('de-DE', {
    notation: 'compact',
    maximumFractionDigits: 1,
});

export default function Dashboard({ analytics, filters }: Props) {
    const previousPeriodLabel = formatPeriod(analytics.previous_period);
    const summaryCards = [
        {
            label: 'Aktive Nutzer',
            value: numberFormatter.format(analytics.summary.active_users),
            icon: Users,
            comparison: analytics.summary_comparison.active_users,
            comparisonMode: 'percent' as const,
        },
        {
            label: 'Besuche',
            value: numberFormatter.format(analytics.summary.sessions),
            icon: MousePointerClick,
            comparison: analytics.summary_comparison.sessions,
            comparisonMode: 'percent' as const,
        },
        {
            label: 'Seitenaufrufe',
            value: numberFormatter.format(analytics.summary.page_views),
            icon: Eye,
            comparison: analytics.summary_comparison.page_views,
            comparisonMode: 'percent' as const,
        },
        {
            label: 'Engagement-Rate',
            value: `${analytics.summary.engagement_rate.toLocaleString('de-DE')}%`,
            icon: Activity,
            comparison: analytics.summary_comparison.engagement_rate,
            comparisonMode: 'points' as const,
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
                                <MetricDelta
                                    comparison={item.comparison}
                                    mode={item.comparisonMode}
                                    previousPeriodLabel={previousPeriodLabel}
                                />
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

                <div className="grid gap-4 xl:grid-cols-[1.4fr_1fr]">
                    <ReportPanel
                        title="Einstiegsseiten"
                        description="Seiten, auf denen Besucher ihren Besuch begonnen haben."
                        icon={MapPin}
                    >
                        <LandingPageTable rows={analytics.landing_pages} />
                    </ReportPanel>

                    <ReportPanel
                        title="Traffic-Quellen"
                        description="Woher die Besuche kamen, zusammengefasst aus Quelle und Kanal."
                        icon={Globe2}
                    >
                        <SourceTable rows={analytics.top_sources} />
                    </ReportPanel>
                </div>

                <div className="grid gap-4 xl:grid-cols-2">
                    <ReportPanel title="Top-Seiten" icon={ChartNoAxesCombined}>
                        <PageTable
                            rows={analytics.top_pages}
                            empty="Noch keine Seitendaten vorhanden."
                        />
                    </ReportPanel>

                    <ReportPanel title="Top-Produktseiten" icon={Eye}>
                        <PageTable
                            rows={analytics.top_product_pages}
                            empty="Noch keine Produktseiten-Daten vorhanden."
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
    const paddingLeft = 54;
    const paddingRight = 20;
    const paddingTop = 22;
    const chartHeight = 150;
    const chartWidth = width - paddingLeft - paddingRight;
    const maxValue = Math.max(
        1,
        ...rows.flatMap((row) => [row.page_views, row.active_users]),
    );
    const pageViewPoints = chartPoints({
        rows,
        valueKey: 'page_views',
        maxValue,
        paddingX: paddingLeft,
        paddingTop,
        chartWidth,
        chartHeight,
    });
    const activeUserPoints = chartPoints({
        rows,
        valueKey: 'active_users',
        maxValue,
        paddingX: paddingLeft,
        paddingTop,
        chartWidth,
        chartHeight,
    });
    const dateLabels = chartDateLabels(rows, paddingLeft, width - paddingRight);
    const tickLabels = [0, 0.25, 0.5, 0.75, 1].map((tick) => ({
        tick,
        y: paddingTop + chartHeight * tick,
        value: Math.round(maxValue * (1 - tick)),
    }));

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
                {tickLabels.map((label) => (
                    <g key={label.tick}>
                        <line
                            x1={paddingLeft}
                            x2={width - paddingRight}
                            y1={label.y}
                            y2={label.y}
                            className="stroke-border"
                            strokeWidth="1"
                        />
                        <text
                            x={paddingLeft - 10}
                            y={label.y + 4}
                            textAnchor="end"
                            className="fill-muted-foreground text-[11px]"
                        >
                            {compactNumberFormatter.format(label.value)}
                        </text>
                    </g>
                ))}

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

                {rows.map((row, index) => {
                    const x = chartX({
                        index,
                        rowsLength: rows.length,
                        paddingX: paddingLeft,
                        chartWidth,
                    });
                    const pageViewsY = chartY({
                        value: row.page_views,
                        maxValue,
                        paddingTop,
                        chartHeight,
                    });
                    const activeUsersY = chartY({
                        value: row.active_users,
                        maxValue,
                        paddingTop,
                        chartHeight,
                    });
                    const title = `${formatShortDate(row.date)}
Seitenaufrufe: ${numberFormatter.format(row.page_views)}
Aktive Nutzer: ${numberFormatter.format(row.active_users)}`;

                    return (
                        <g key={row.date}>
                            <line
                                x1={x}
                                x2={x}
                                y1={paddingTop}
                                y2={paddingTop + chartHeight}
                                stroke="transparent"
                                strokeWidth="14"
                            >
                                <title>{title}</title>
                            </line>
                            <circle
                                cx={x}
                                cy={pageViewsY}
                                r="4"
                                className="fill-emerald-500"
                            >
                                <title>{title}</title>
                            </circle>
                            <circle
                                cx={x}
                                cy={activeUsersY}
                                r="4"
                                className="fill-sky-500"
                            >
                                <title>{title}</title>
                            </circle>
                        </g>
                    );
                })}

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

function MetricDelta({
    comparison,
    mode,
    previousPeriodLabel,
}: {
    comparison: MetricComparison;
    mode: 'percent' | 'points';
    previousPeriodLabel: string;
}) {
    const changeValue = comparison.change_value;
    const isPositive = changeValue > 0;
    const isNegative = changeValue < 0;
    const Icon = isPositive ? ArrowUpRight : isNegative ? ArrowDownRight : Minus;
    const value =
        mode === 'points'
            ? `${Math.abs(changeValue).toLocaleString('de-DE')} Pkt.`
            : comparison.change_percent === null
              ? numberFormatter.format(Math.abs(changeValue))
              : `${Math.abs(comparison.change_percent).toLocaleString('de-DE')}%`;

    return (
        <p
            className={cn(
                'mt-2 flex items-center gap-1 text-xs text-muted-foreground',
                isPositive && 'text-emerald-600 dark:text-emerald-400',
                isNegative && 'text-red-600 dark:text-red-400',
            )}
        >
            <Icon className="size-3" />
            <span>
                {isPositive ? '+' : isNegative ? '-' : ''}
                {value} vs. {previousPeriodLabel}
            </span>
        </p>
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
            const x = chartX({
                index,
                rowsLength: rows.length,
                paddingX,
                chartWidth,
            });
            const y = chartY({
                value: row[valueKey],
                maxValue,
                paddingTop,
                chartHeight,
            });

            return `${x},${y}`;
        })
        .join(' ');
}

function chartX({
    index,
    rowsLength,
    paddingX,
    chartWidth,
}: {
    index: number;
    rowsLength: number;
    paddingX: number;
    chartWidth: number;
}) {
    return rowsLength === 1
        ? paddingX + chartWidth / 2
        : paddingX + (index / (rowsLength - 1)) * chartWidth;
}

function chartY({
    value,
    maxValue,
    paddingTop,
    chartHeight,
}: {
    value: number;
    maxValue: number;
    paddingTop: number;
    chartHeight: number;
}) {
    return paddingTop + chartHeight - (value / maxValue) * chartHeight;
}

function chartDateLabels(
    rows: DailyRow[],
    leftX: number,
    rightX: number,
): Array<{ date: string; x: number; anchor: ChartTextAnchor }> {
    const middleX = leftX + (rightX - leftX) / 2;

    if (rows.length === 1) {
        return [
            {
                date: rows[0].date,
                x: middleX,
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
                    ? leftX
                    : label.index === rows.length - 1
                      ? rightX
                      : middleX,
            anchor: label.anchor,
        }));
    }

    return labels.map((label) => ({
        date: rows[label.index].date,
        x: label.index === 0 ? leftX : rightX,
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

function formatPeriod(period: DatePeriod) {
    return `${formatPeriodDate(period.start)} - ${formatPeriodDate(period.end)}`;
}

function formatPeriodDate(date: string) {
    const parsed = new Date(`${date}T00:00:00`);

    if (Number.isNaN(parsed.getTime())) {
        return date;
    }

    return periodDateFormatter.format(parsed);
}

function ReportPanel({
    title,
    description,
    icon: Icon,
    children,
}: {
    title: string;
    description?: string;
    icon: LucideIcon;
    children: ReactNode;
}) {
    return (
        <section className="rounded-lg border bg-card p-5 text-card-foreground shadow-xs">
            <div className="mb-4 flex items-center justify-between gap-4">
                <div className="grid gap-1">
                    <h2 className="text-base font-semibold">{title}</h2>
                    {description && (
                        <p className="text-sm text-muted-foreground">
                            {description}
                        </p>
                    )}
                </div>
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
                    key={row.url}
                    className="grid gap-1 rounded-md border p-3"
                >
                    <div className="flex items-start justify-between gap-4">
                        <div className="min-w-0">
                            <p className="truncate font-medium">
                                {row.title || '—'}
                            </p>
                            <div className="mt-1 flex flex-wrap gap-1.5">
                                {row.title_count > 1 && (
                                    <Badge
                                        variant="outline"
                                        className="text-[0.68rem]"
                                    >
                                        {row.title_count} Titel in GA
                                    </Badge>
                                )}
                                {row.is_suspicious && (
                                    <Badge
                                        variant="outline"
                                        className="border-amber-300 bg-amber-50 text-[0.68rem] text-amber-800 dark:border-amber-900/60 dark:bg-amber-950/30 dark:text-amber-200"
                                    >
                                        URL prüfen
                                    </Badge>
                                )}
                            </div>
                        </div>
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

function LandingPageTable({ rows }: { rows: LandingPageRow[] }) {
    if (rows.length === 0) {
        return (
            <p className="text-sm text-muted-foreground">
                Noch keine Einstiegsseiten-Daten vorhanden.
            </p>
        );
    }

    return (
        <div className="grid gap-3">
            {rows.map((row) => (
                <div key={row.path} className="grid gap-3 rounded-md border p-3">
                    <div className="flex items-start justify-between gap-3">
                        <p className="min-w-0 truncate text-sm font-medium">
                            {row.path || '—'}
                        </p>
                        {row.is_suspicious && (
                            <Badge
                                variant="outline"
                                className="shrink-0 border-amber-300 bg-amber-50 text-[0.68rem] text-amber-800 dark:border-amber-900/60 dark:bg-amber-950/30 dark:text-amber-200"
                            >
                                URL prüfen
                            </Badge>
                        )}
                    </div>
                    <div className="grid grid-cols-3 gap-2">
                        <ReportMetric
                            label="Besuche"
                            value={numberFormatter.format(row.sessions)}
                            help="Wie oft Besucher hier gestartet sind."
                        />
                        <ReportMetric
                            label="Seitenaufrufe"
                            value={numberFormatter.format(row.views)}
                            help="Wie oft diese Seite angesehen wurde."
                        />
                        <ReportMetric
                            label="Engagement"
                            value={formatPercent(row.engagement_rate)}
                            help="Anteil der Besuche mit echter Aktivität."
                        />
                    </div>
                </div>
            ))}
        </div>
    );
}

function SourceTable({ rows }: { rows: SourceRow[] }) {
    if (rows.length === 0) {
        return (
            <p className="text-sm text-muted-foreground">
                Noch keine Quellen-Daten vorhanden.
            </p>
        );
    }

    return (
        <div className="grid gap-3">
            {rows.map((row) => (
                <div
                    key={row.raw_source_medium}
                    className="grid gap-3 rounded-md border p-3"
                >
                    <div className="min-w-0">
                        <div className="flex flex-wrap items-center gap-2">
                            <p className="truncate text-sm font-medium">
                                {row.source || '—'}
                            </p>
                            {row.medium && (
                                <Badge variant="outline" className="text-[0.68rem]">
                                    {row.medium}
                                </Badge>
                            )}
                        </div>
                        <p className="mt-1 truncate text-xs text-muted-foreground">
                            GA: {row.raw_source_medium}
                        </p>
                    </div>
                    <div className="grid grid-cols-3 gap-2">
                        <ReportMetric
                            label="Besuche"
                            value={numberFormatter.format(row.sessions)}
                            help="Wie oft diese Quelle Besucher gebracht hat."
                        />
                        <ReportMetric
                            label="Seitenaufrufe"
                            value={numberFormatter.format(row.views)}
                            help="Wie viele Seitenaufrufe daraus entstanden sind."
                        />
                        <ReportMetric
                            label="Engagement"
                            value={formatPercent(row.engagement_rate)}
                            help="Anteil der Besuche mit echter Aktivität."
                        />
                    </div>
                </div>
            ))}
        </div>
    );
}

function ReportMetric({
    label,
    value,
    help,
}: {
    label: string;
    value: string;
    help?: string;
}) {
    return (
        <div className="rounded-md bg-muted/50 px-2.5 py-2">
            <div className="flex items-center gap-1 text-[0.7rem] text-muted-foreground">
                <span>{label}</span>
                {help && (
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <button
                                type="button"
                                className="rounded-full text-muted-foreground outline-none hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring"
                                aria-label={`${label}: ${help}`}
                            >
                                <CircleHelp className="size-3" />
                            </button>
                        </TooltipTrigger>
                        <TooltipContent className="max-w-56 text-xs">
                            {help}
                        </TooltipContent>
                    </Tooltip>
                )}
            </div>
            <p className="mt-1 text-sm font-medium">{value}</p>
        </div>
    );
}

function formatPercent(value: number) {
    return `${value.toLocaleString('de-DE')}%`;
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
