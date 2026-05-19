<?php

namespace App\Http\Middleware;

use App\Support\PublicLocale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class SetPublicLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeLocale = $request->route('locale');

        if ($routeLocale !== null && ! PublicLocale::isSupported((string) $routeLocale)) {
            abort(404);
        }

        $locale = PublicLocale::normalize(
            is_string($routeLocale) ? $routeLocale : $request->cookie(PublicLocale::CookieName),
        );

        app()->setLocale($locale);
        $request->attributes->set('public_locale', $locale);
        Inertia::share('locale', $this->localeProps($request, $locale));
        Cookie::queue(PublicLocale::CookieName, $locale, 60 * 24 * 365);

        return $next($request);
    }

    /**
     * @return array{current: string, dir: string, formatter_locale: string, supported: array<int, array<string, string>>, switcher_urls: array<string, string>}
     */
    private function localeProps(Request $request, string $locale): array
    {
        return [
            'current' => $locale,
            'dir' => PublicLocale::direction($locale),
            'formatter_locale' => PublicLocale::formatterLocale($locale),
            'supported' => array_values(PublicLocale::supported()),
            'switcher_urls' => collect(PublicLocale::codes())
                ->mapWithKeys(fn (string $code) => [$code => $this->localizedUrl($request, $code)])
                ->all(),
        ];
    }

    private function localizedUrl(Request $request, string $locale): string
    {
        $route = $request->route();
        $name = $route?->getName();

        if ($name === null) {
            return $request->fullUrl();
        }

        $url = route($name, [
            ...$route->parameters(),
            'locale' => $locale,
        ]);
        $queryString = $request->getQueryString();

        return $queryString ? "{$url}?{$queryString}" : $url;
    }
}
