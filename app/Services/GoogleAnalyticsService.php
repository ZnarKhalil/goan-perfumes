<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;
use Throwable;

class GoogleAnalyticsService
{
    /**
     * @return array{
     *     range_days: int,
     *     property_id: ?string,
     *     configured: bool,
     *     status: 'ready'|'not_configured'|'unavailable',
     *     message: ?string,
     *     summary: array{active_users: int, sessions: int, page_views: int, engagement_rate: float},
     *     realtime: array{active_users: int},
     *     top_pages: list<array{title: string, url: string, views: int}>,
     *     top_product_pages: list<array{title: string, url: string, views: int}>,
     *     top_sources: list<array{source: string, views: int}>,
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

        return Cache::remember(
            key: "google-analytics.dashboard.{$rangeDays}",
            ttl: now()->addMinutes(30),
            callback: fn () => $this->fetchDashboard($rangeDays),
        );
    }

    private function fetchDashboard(int $rangeDays): array
    {
        $period = Period::days($rangeDays);

        try {
            return [
                ...$this->emptyDashboard($rangeDays),
                'status' => 'ready',
                'message' => null,
                'summary' => $this->summary($period),
                'realtime' => $this->realtime(),
                'top_pages' => $this->topPages($period),
                'top_product_pages' => $this->topProductPages($period),
                'top_sources' => $this->topSources($period),
                'top_countries' => $this->topCountries($period),
                'devices' => $this->devices($period),
                'daily' => $this->daily($period, $rangeDays),
            ];
        } catch (Throwable) {
            return $this->emptyDashboard(
                rangeDays: $rangeDays,
                status: 'unavailable',
                message: 'Google Analytics konnte gerade nicht gelesen werden. Bitte später erneut versuchen.',
            );
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
     * @return array{active_users: int}
     */
    private function realtime(): array
    {
        $period = Period::create(
            CarbonImmutable::now()->subMinutes(30),
            CarbonImmutable::now(),
        );

        $row = Analytics::getRealtime($period, ['activeUsers'])->first() ?? [];

        return [
            'active_users' => (int) ($row['activeUsers'] ?? 0),
        ];
    }

    /**
     * @return list<array{title: string, url: string, views: int}>
     */
    private function topPages(Period $period): array
    {
        return Analytics::fetchMostVisitedPages($period, 10)
            ->map(fn (array $row): array => [
                'title' => (string) ($row['pageTitle'] ?? 'Unbenannte Seite'),
                'url' => (string) ($row['fullPageUrl'] ?? ''),
                'views' => (int) ($row['screenPageViews'] ?? 0),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{title: string, url: string, views: int}>
     */
    private function topProductPages(Period $period): array
    {
        return Analytics::get(
            period: $period,
            metrics: ['screenPageViews'],
            dimensions: ['pageTitle', 'pagePath'],
            maxResults: 10,
            orderBy: [OrderBy::metric('screenPageViews', true)],
        )
            ->filter(fn (array $row): bool => str_contains((string) ($row['pagePath'] ?? ''), '/produkt/'))
            ->map(fn (array $row): array => [
                'title' => (string) ($row['pageTitle'] ?? 'Produktseite'),
                'url' => (string) ($row['pagePath'] ?? ''),
                'views' => (int) ($row['screenPageViews'] ?? 0),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{source: string, views: int}>
     */
    private function topSources(Period $period): array
    {
        return Analytics::get(
            period: $period,
            metrics: ['screenPageViews'],
            dimensions: ['sessionSourceMedium'],
            maxResults: 5,
            orderBy: [OrderBy::metric('screenPageViews', true)],
        )
            ->map(fn (array $row): array => [
                'source' => (string) ($row['sessionSourceMedium'] ?? 'Unbekannt'),
                'views' => (int) ($row['screenPageViews'] ?? 0),
            ])
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
     *     summary: array{active_users: int, sessions: int, page_views: int, engagement_rate: float},
     *     realtime: array{active_users: int},
     *     top_pages: list<array{title: string, url: string, views: int}>,
     *     top_product_pages: list<array{title: string, url: string, views: int}>,
     *     top_sources: list<array{source: string, views: int}>,
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
            'summary' => [
                'active_users' => 0,
                'sessions' => 0,
                'page_views' => 0,
                'engagement_rate' => 0.0,
            ],
            'realtime' => [
                'active_users' => 0,
            ],
            'top_pages' => [],
            'top_product_pages' => [],
            'top_sources' => [],
            'top_countries' => [],
            'devices' => [],
            'daily' => [],
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

    private function isConfigured(): bool
    {
        $credentials = config('analytics.service_account_credentials_json');

        return filled($this->propertyId())
            && is_string($credentials)
            && file_exists($credentials);
    }

    private function propertyId(): ?string
    {
        $propertyId = config('analytics.property_id');

        return filled($propertyId) ? (string) $propertyId : null;
    }
}
