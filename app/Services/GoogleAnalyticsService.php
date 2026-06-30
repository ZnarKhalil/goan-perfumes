<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;
use Throwable;

class GoogleAnalyticsService
{
    private const RealtimeLookbackMinutes = 29;

    /**
     * @return array{
     *     range_days: int,
     *     property_id: ?string,
     *     configured: bool,
     *     status: 'ready'|'not_configured'|'unavailable',
     *     message: ?string,
     *     current_period: array{start: string, end: string},
     *     previous_period: array{start: string, end: string},
     *     summary: array{active_users: int, sessions: int, page_views: int, engagement_rate: float},
     *     summary_comparison: array{
     *         active_users: array{previous: float, change_value: float, change_percent: ?float},
     *         sessions: array{previous: float, change_value: float, change_percent: ?float},
     *         page_views: array{previous: float, change_value: float, change_percent: ?float},
     *         engagement_rate: array{previous: float, change_value: float, change_percent: ?float}
     *     },
     *     realtime: array{active_users: int},
     *     top_pages: list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>,
     *     top_product_pages: list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>,
     *     landing_pages: list<array{path: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float, is_suspicious: bool}>,
     *     top_sources: list<array{source: string, medium: ?string, raw_source_medium: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float}>,
     *     top_countries: list<array{country: string, views: int}>,
     *     devices: list<array{device: string, sessions: int}>,
     *     daily: list<array{date: string, active_users: int, page_views: int}>
     * }
     */
    public function dashboard(int $rangeDays): array
    {
        $rangeDays = in_array($rangeDays, [7, 30, 90], true) ? $rangeDays : 30;

        if (! $this->isConfigured()) {
            return $this->emptyDashboard(
                rangeDays: $rangeDays,
                status: 'not_configured',
                message: 'Google Analytics ist noch nicht vollständig konfiguriert.',
            );
        }

        $cacheKey = "google-analytics.dashboard.v3.{$rangeDays}";

        if (is_array($cached = Cache::get($cacheKey))) {
            return $cached;
        }

        $dashboard = $this->fetchDashboard($rangeDays);

        // Only cache successful reads. Caching an 'unavailable' result would
        // pin a transient API failure for the full cache window, which is why
        // the dashboard error previously persisted long after the cause was gone.
        if ($dashboard['status'] === 'ready') {
            Cache::put($cacheKey, $dashboard, now()->addMinutes(30));
        }

        return $dashboard;
    }

    private function fetchDashboard(int $rangeDays): array
    {
        $period = Period::days($rangeDays);
        $previousPeriod = $this->previousPeriod($period);

        try {
            $summary = $this->summary($period);
            $previousSummary = $this->summary($previousPeriod);

            return [
                ...$this->emptyDashboard($rangeDays),
                'status' => 'ready',
                'message' => null,
                'current_period' => $this->periodDates($period),
                'previous_period' => $this->periodDates($previousPeriod),
                'summary' => $summary,
                'summary_comparison' => $this->summaryComparison($summary, $previousSummary),
                'realtime' => $this->realtime(),
                'top_pages' => $this->optionalReport(fn (): array => $this->topPages($period), []),
                'top_product_pages' => $this->optionalReport(fn (): array => $this->topProductPages($period), []),
                'landing_pages' => $this->optionalReport(fn (): array => $this->landingPages($period), []),
                'top_sources' => $this->optionalReport(fn (): array => $this->topSources($period), []),
                'top_countries' => $this->optionalReport(fn (): array => $this->topCountries($period), []),
                'devices' => $this->optionalReport(fn (): array => $this->devices($period), []),
                'daily' => $this->optionalReport(fn (): array => $this->daily($period, $rangeDays), []),
            ];
        } catch (Throwable $exception) {
            report($exception);

            return $this->emptyDashboard(
                rangeDays: $rangeDays,
                status: 'unavailable',
                message: 'Google Analytics konnte gerade nicht gelesen werden. Bitte später erneut versuchen.',
            );
        }
    }

    /**
     * @param  callable(): array  $callback
     */
    private function optionalReport(callable $callback, array $fallback): array
    {
        try {
            return $callback();
        } catch (Throwable $exception) {
            report($exception);

            return $fallback;
        }
    }

    /**
     * @return array{active_users: int, sessions: int, page_views: int, engagement_rate: float}
     */
    private function summary(Period $period): array
    {
        $row = Analytics::get($period, [
            'activeUsers',
            'sessions',
            'screenPageViews',
            'engagementRate',
        ])->first() ?? [];

        return [
            'active_users' => (int) ($row['activeUsers'] ?? 0),
            'sessions' => (int) ($row['sessions'] ?? 0),
            'page_views' => (int) ($row['screenPageViews'] ?? 0),
            'engagement_rate' => round((float) ($row['engagementRate'] ?? 0) * 100, 1),
        ];
    }

    /**
     * @param  array{active_users: int, sessions: int, page_views: int, engagement_rate: float}  $current
     * @param  array{active_users: int, sessions: int, page_views: int, engagement_rate: float}  $previous
     * @return array{
     *     active_users: array{previous: float, change_value: float, change_percent: ?float},
     *     sessions: array{previous: float, change_value: float, change_percent: ?float},
     *     page_views: array{previous: float, change_value: float, change_percent: ?float},
     *     engagement_rate: array{previous: float, change_value: float, change_percent: ?float}
     * }
     */
    private function summaryComparison(array $current, array $previous): array
    {
        return [
            'active_users' => $this->metricComparison($current['active_users'], $previous['active_users']),
            'sessions' => $this->metricComparison($current['sessions'], $previous['sessions']),
            'page_views' => $this->metricComparison($current['page_views'], $previous['page_views']),
            'engagement_rate' => $this->metricComparison($current['engagement_rate'], $previous['engagement_rate']),
        ];
    }

    /**
     * @return array{previous: float, change_value: float, change_percent: ?float}
     */
    private function metricComparison(float|int $current, float|int $previous): array
    {
        $changeValue = round($current - $previous, 1);

        return [
            'previous' => round($previous, 1),
            'change_value' => $changeValue,
            'change_percent' => $previous > 0
                ? round(($changeValue / $previous) * 100, 1)
                : null,
        ];
    }

    /**
     * @return array{active_users: int}
     */
    private function realtime(): array
    {
        // Anchor the end of the range to the top of the hour. Spatie's
        // Period::toMinuteRange() derives endMinutesAgo from the end date's
        // minute-of-hour, so any other end date produces an invalid range
        // (endMinutesAgo > startMinutesAgo) and the Realtime API rejects it.
        $end = CarbonImmutable::now()->startOfHour();

        $period = Period::create(
            $end->subMinutes(self::RealtimeLookbackMinutes),
            $end,
        );

        try {
            $row = Analytics::getRealtime($period, ['activeUsers'])->first() ?? [];
        } catch (Throwable) {
            return ['active_users' => 0];
        }

        return [
            'active_users' => (int) ($row['activeUsers'] ?? 0),
        ];
    }

    /**
     * @return list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>
     */
    private function topPages(Period $period): array
    {
        $rows = Analytics::get(
            period: $period,
            metrics: ['screenPageViews'],
            dimensions: ['pageTitle', 'pagePathPlusQueryString'],
            maxResults: 50,
            orderBy: [OrderBy::metric('screenPageViews', true)],
        );

        return $this->pageRows($rows, 'pagePathPlusQueryString', 'Unbenannte Seite');
    }

    /**
     * @return list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>
     */
    private function topProductPages(Period $period): array
    {
        $rows = Analytics::get(
            period: $period,
            metrics: ['screenPageViews'],
            dimensions: ['pageTitle', 'pagePathPlusQueryString'],
            maxResults: 50,
            orderBy: [OrderBy::metric('screenPageViews', true)],
        );

        return $this->pageRows(
            rows: $rows,
            urlDimension: 'pagePathPlusQueryString',
            fallbackTitle: 'Produktseite',
            filter: fn (string $url): bool => str_contains($url, '/produkt/'),
        );
    }

    /**
     * @return list<array{path: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float, is_suspicious: bool}>
     */
    private function landingPages(Period $period): array
    {
        return Analytics::get(
            period: $period,
            metrics: ['sessions', 'screenPageViews', 'engagedSessions', 'engagementRate'],
            dimensions: ['landingPagePlusQueryString'],
            maxResults: 10,
            orderBy: [OrderBy::metric('sessions', true)],
        )
            ->map(fn (array $row): array => [
                'path' => $this->normalizeAnalyticsUrl($row['landingPagePlusQueryString'] ?? 'Unbekannt'),
                'sessions' => (int) ($row['sessions'] ?? 0),
                'views' => (int) ($row['screenPageViews'] ?? 0),
                'engaged_sessions' => (int) ($row['engagedSessions'] ?? 0),
                'engagement_rate' => round((float) ($row['engagementRate'] ?? 0) * 100, 1),
                'is_suspicious' => $this->isSuspiciousAnalyticsUrl($row['landingPagePlusQueryString'] ?? ''),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{source: string, medium: ?string, raw_source_medium: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float}>
     */
    private function topSources(Period $period): array
    {
        return Analytics::get(
            period: $period,
            metrics: ['sessions', 'screenPageViews', 'engagedSessions', 'engagementRate'],
            dimensions: ['sessionSourceMedium'],
            maxResults: 5,
            orderBy: [OrderBy::metric('sessions', true)],
        )
            ->map(fn (array $row): array => $this->sourceRow($row))
            ->values()
            ->all();
    }

    /**
     * @return list<array{country: string, views: int}>
     */
    private function topCountries(Period $period): array
    {
        return Analytics::fetchTopCountries($period, 5)
            ->map(fn (array $row): array => [
                'country' => (string) ($row['country'] ?? 'Unbekannt'),
                'views' => (int) ($row['screenPageViews'] ?? 0),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{device: string, sessions: int}>
     */
    private function devices(Period $period): array
    {
        return Analytics::get(
            period: $period,
            metrics: ['sessions'],
            dimensions: ['deviceCategory'],
            maxResults: 3,
            orderBy: [OrderBy::metric('sessions', true)],
        )
            ->map(fn (array $row): array => [
                'device' => (string) ($row['deviceCategory'] ?? 'unknown'),
                'sessions' => (int) ($row['sessions'] ?? 0),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{date: string, active_users: int, page_views: int}>
     */
    private function daily(Period $period, int $rangeDays): array
    {
        return Analytics::get(
            period: $period,
            metrics: ['activeUsers', 'screenPageViews'],
            dimensions: ['date'],
            maxResults: $rangeDays + 1,
            orderBy: [OrderBy::dimension('date')],
        )
            ->map(fn (array $row): array => [
                'date' => $this->analyticsDate($row['date'] ?? null),
                'active_users' => (int) ($row['activeUsers'] ?? 0),
                'page_views' => (int) ($row['screenPageViews'] ?? 0),
            ])
            ->values()
            ->all();
    }

    /**
     * @return array{
     *     range_days: int,
     *     property_id: ?string,
     *     configured: bool,
     *     status: 'ready'|'not_configured'|'unavailable',
     *     message: ?string,
     *     current_period: array{start: string, end: string},
     *     previous_period: array{start: string, end: string},
     *     summary: array{active_users: int, sessions: int, page_views: int, engagement_rate: float},
     *     summary_comparison: array{
     *         active_users: array{previous: float, change_value: float, change_percent: ?float},
     *         sessions: array{previous: float, change_value: float, change_percent: ?float},
     *         page_views: array{previous: float, change_value: float, change_percent: ?float},
     *         engagement_rate: array{previous: float, change_value: float, change_percent: ?float}
     *     },
     *     realtime: array{active_users: int},
     *     top_pages: list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>,
     *     top_product_pages: list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>,
     *     landing_pages: list<array{path: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float, is_suspicious: bool}>,
     *     top_sources: list<array{source: string, medium: ?string, raw_source_medium: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float}>,
     *     top_countries: list<array{country: string, views: int}>,
     *     devices: list<array{device: string, sessions: int}>,
     *     daily: list<array{date: string, active_users: int, page_views: int}>
     * }
     */
    private function emptyDashboard(
        int $rangeDays,
        string $status = 'ready',
        ?string $message = null,
    ): array {
        return [
            'range_days' => $rangeDays,
            'property_id' => $this->propertyId(),
            'configured' => $this->isConfigured(),
            'status' => $status,
            'message' => $message,
            'current_period' => $this->periodDates(Period::days($rangeDays)),
            'previous_period' => $this->periodDates($this->previousPeriod(Period::days($rangeDays))),
            'summary' => [
                'active_users' => 0,
                'sessions' => 0,
                'page_views' => 0,
                'engagement_rate' => 0.0,
            ],
            'summary_comparison' => [
                'active_users' => $this->metricComparison(0, 0),
                'sessions' => $this->metricComparison(0, 0),
                'page_views' => $this->metricComparison(0, 0),
                'engagement_rate' => $this->metricComparison(0, 0),
            ],
            'realtime' => [
                'active_users' => 0,
            ],
            'top_pages' => [],
            'top_product_pages' => [],
            'landing_pages' => [],
            'top_sources' => [],
            'top_countries' => [],
            'devices' => [],
            'daily' => [],
        ];
    }

    /**
     * @param  iterable<array<string, mixed>>  $rows
     * @return list<array{title: string, url: string, views: int, title_count: int, is_suspicious: bool}>
     */
    private function pageRows(
        iterable $rows,
        string $urlDimension,
        string $fallbackTitle,
        ?callable $filter = null,
    ): array {
        $pages = [];

        foreach ($rows as $row) {
            $url = $this->normalizeAnalyticsUrl($row[$urlDimension] ?? '');

            if ($url === '' || ($filter !== null && ! $filter($url))) {
                continue;
            }

            $title = $this->cleanPageTitle($row['pageTitle'] ?? null, $fallbackTitle);

            if (! isset($pages[$url])) {
                $pages[$url] = [
                    'url' => $url,
                    'views' => 0,
                    'title_views' => [],
                    'is_suspicious' => $this->isSuspiciousAnalyticsUrl($row[$urlDimension] ?? ''),
                ];
            }

            $views = (int) ($row['screenPageViews'] ?? 0);

            $pages[$url]['views'] += $views;
            $pages[$url]['title_views'][$title] = ($pages[$url]['title_views'][$title] ?? 0) + $views;
            $pages[$url]['is_suspicious'] = $pages[$url]['is_suspicious']
                || $this->isSuspiciousAnalyticsUrl($row[$urlDimension] ?? '');
        }

        return collect($pages)
            ->map(function (array $page) use ($fallbackTitle): array {
                arsort($page['title_views']);

                $title = (string) array_key_first($page['title_views']);

                return [
                    'title' => $title !== '' ? $title : $fallbackTitle,
                    'url' => (string) $page['url'],
                    'views' => (int) $page['views'],
                    'title_count' => count($page['title_views']),
                    'is_suspicious' => (bool) $page['is_suspicious'],
                ];
            })
            ->sortByDesc('views')
            ->take(10)
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array{source: string, medium: ?string, raw_source_medium: string, sessions: int, views: int, engaged_sessions: int, engagement_rate: float}
     */
    private function sourceRow(array $row): array
    {
        $rawSourceMedium = (string) ($row['sessionSourceMedium'] ?? 'Unbekannt');
        [$source, $medium] = array_pad(explode(' / ', $rawSourceMedium, 2), 2, null);

        return [
            'source' => $this->trafficSourceLabel($source),
            'medium' => $this->trafficMediumLabel($medium),
            'raw_source_medium' => $rawSourceMedium,
            'sessions' => (int) ($row['sessions'] ?? 0),
            'views' => (int) ($row['screenPageViews'] ?? 0),
            'engaged_sessions' => (int) ($row['engagedSessions'] ?? 0),
            'engagement_rate' => round((float) ($row['engagementRate'] ?? 0) * 100, 1),
        ];
    }

    private function normalizeAnalyticsUrl(mixed $url): string
    {
        $value = trim((string) $url);

        if ($value === '') {
            return '';
        }

        if (! str_starts_with($value, '/') && preg_match('/^[a-z0-9.-]+\.[a-z]{2,}(\/.*)?$/i', $value)) {
            $value = "https://{$value}";
        }

        $path = parse_url($value, PHP_URL_PATH);
        $query = parse_url($value, PHP_URL_QUERY);

        if (! is_string($path) || $path === '') {
            $path = str_starts_with($value, '/') ? $value : "/{$value}";
            $query = null;
        }

        $normalized = $path.($query ? "?{$query}" : '');

        return rawurldecode($normalized);
    }

    private function isSuspiciousAnalyticsUrl(mixed $url): bool
    {
        $normalized = $this->normalizeAnalyticsUrl($url);

        return substr_count($normalized, '?') > 1
            || (bool) preg_match('/[?&][^=&?]+=[^&?]*\?/', $normalized);
    }

    private function cleanPageTitle(mixed $title, string $fallback): string
    {
        $value = trim(preg_replace('/\s+/', ' ', (string) $title) ?? '');

        return $value !== '' ? $value : $fallback;
    }

    private function trafficSourceLabel(?string $source): string
    {
        $value = trim((string) $source);
        $normalized = Str::lower($value);

        return match (true) {
            $normalized === '', $normalized === '(not set)' => 'Unbekannt',
            $normalized === '(direct)', $normalized === 'direct' => 'Direkt',
            in_array($normalized, ['ig', 'instagram', 'instagram.com', 'l.instagram.com', 'lm.instagram.com'], true) => 'Instagram',
            in_array($normalized, ['fb', 'facebook', 'facebook.com', 'm.facebook.com', 'l.facebook.com'], true) => 'Facebook',
            str_contains($normalized, 'google') => 'Google',
            str_contains($normalized, 'bing') => 'Bing',
            str_contains($normalized, 'tiktok') => 'TikTok',
            str_contains($normalized, 'pinterest') => 'Pinterest',
            default => Str::headline($value),
        };
    }

    private function trafficMediumLabel(?string $medium): ?string
    {
        $value = trim((string) $medium);
        $normalized = Str::lower($value);

        return match ($normalized) {
            '', '(not set)', '(none)' => null,
            'organic' => 'Organisch',
            'cpc', 'ppc', 'paid', 'paid_search' => 'Bezahlt',
            'referral' => 'Verweis',
            'social', 'organic_social', 'paid_social' => 'Social',
            'email' => 'E-Mail',
            'affiliate' => 'Affiliate',
            'display' => 'Display',
            default => Str::headline($value),
        };
    }

    /**
     * @return array{start: string, end: string}
     */
    private function periodDates(Period $period): array
    {
        return [
            'start' => $period->startDate->format('Y-m-d'),
            'end' => $period->endDate->format('Y-m-d'),
        ];
    }

    private function analyticsDate(mixed $date): string
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        $value = (string) $date;

        if (! preg_match('/^\d{8}$/', $value)) {
            return $value;
        }

        try {
            return CarbonImmutable::createFromFormat('Ymd', $value)->format('Y-m-d');
        } catch (Throwable) {
            return $value;
        }
    }

    private function previousPeriod(Period $period): Period
    {
        $currentStartDate = CarbonImmutable::parse($period->startDate->format('Y-m-d'))->startOfDay();
        $currentEndDate = CarbonImmutable::parse($period->endDate->format('Y-m-d'))->startOfDay();
        $periodLength = (int) $currentStartDate->diffInDays($currentEndDate);
        $previousEndDate = $currentStartDate->subDay();

        return Period::create(
            $previousEndDate->subDays($periodLength)->startOfDay(),
            $previousEndDate,
        );
    }

    private function isConfigured(): bool
    {
        $credentials = config('analytics.service_account_credentials_json');

        return filled($this->propertyId())
            && is_string($credentials)
            && file_exists($credentials)
            && is_readable($credentials);
    }

    private function propertyId(): ?string
    {
        $propertyId = config('analytics.property_id');

        return filled($propertyId) ? (string) $propertyId : null;
    }
}
