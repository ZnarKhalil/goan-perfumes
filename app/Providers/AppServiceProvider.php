<?php

namespace App\Providers;

use App\Models\PageSection;
use App\Models\Promotion;
use App\Models\Setting;
use App\Models\Translation;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\ExceptionResponse;
use Inertia\Inertia;
use Opcodes\LogViewer\Facades\LogViewer;
use Spatie\Analytics\AnalyticsClient;
use Spatie\Analytics\AnalyticsClientFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureHomepageFreshness();
        $this->configureGoogleAnalytics();
        $this->configureDefaults();
        $this->configureErrorPages();
        $this->configureLogViewer();
    }

    private function configureHomepageFreshness(): void
    {
        $recordChange = function (Model $model): void {
            if ($model instanceof Translation
                && ! in_array($model->translatable_type, [PageSection::class, Promotion::class], true)) {
                return;
            }

            Setting::put('home_content_updated_at', now()->toIso8601String());
            Cache::forget('public.sitemap.xml');
            DB::afterCommit(fn (): bool => Cache::forget('public.sitemap.xml'));
        };

        foreach ([PageSection::class, Promotion::class, Translation::class] as $model) {
            $model::created($recordChange);
            $model::updated(function (Model $model) use ($recordChange): void {
                if (array_diff_key($model->getChanges(), ['updated_at' => true]) !== []) {
                    $recordChange($model);
                }
            });
            $model::deleted($recordChange);
        }
    }

    /**
     * Keep Spatie Analytics' binary protobuf cache out of the database cache.
     */
    protected function configureGoogleAnalytics(): void
    {
        $this->app->bind(AnalyticsClient::class, function (): AnalyticsClient {
            $analyticsConfig = config('analytics');
            $cacheStore = (string) ($analyticsConfig['cache']['store'] ?? config('cache.default'));

            $client = new AnalyticsClient(
                AnalyticsClientFactory::createAuthenticatedGoogleClient($analyticsConfig),
                $this->app->make(CacheFactory::class)->store($cacheStore),
            );

            return $client->setCacheLifeTimeInMinutes(
                (int) $analyticsConfig['cache_lifetime_in_minutes'],
            );
        });
    }

    /**
     * Restrict the Log Viewer to authenticated admin users, consistent with
     * the EnsureUserIsAdmin middleware and Dashboard form requests.
     */
    protected function configureLogViewer(): void
    {
        // The log-viewer binding is unavailable while its package manifest is
        // (re)built, e.g. during `package:discover` on a fresh deploy. Guard the
        // facade call so boot never hard-fails when the binding is not yet set.
        if (! $this->app->bound('log-viewer')) {
            return;
        }

        LogViewer::auth(fn ($request): bool => $request->user()?->is_admin === true);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        // Surface lazy loading (N+1), discarded attributes, and missing
        // attribute access during development and testing.
        Model::shouldBeStrict(! $this->app->isProduction());

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Render branded Inertia pages for common HTTP errors.
     */
    protected function configureErrorPages(): void
    {
        Inertia::handleExceptionsUsing(function (ExceptionResponse $response) {
            if (! in_array($response->statusCode(), [403, 404, 419, 429, 500, 503], true)) {
                return null;
            }

            return $response->render('error', [
                'status' => $response->statusCode(),
            ])->withSharedData();
        });
    }
}
