<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\PublicLocale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use XMLWriter;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('public.sitemap.xml', now()->addHour(), function (): string {
            /** @var Collection<int, Category> $categories */
            $categories = Category::query()
                ->where('is_active', true)
                ->orderBy('id')
                ->get(['id', 'slug', 'updated_at']);

            /** @var Collection<int, Product> $products */
            $products = Product::query()
                ->where('is_active', true)
                ->orderBy('id')
                ->get(['id', 'slug', 'updated_at']);

            return $this->xml($categories, $products);
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    /**
     * @param  Collection<int, Category>  $categories
     * @param  Collection<int, Product>  $products
     */
    private function xml(Collection $categories, Collection $products): string
    {
        $writer = new XMLWriter;
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $writer->writeAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');

        $this->writeLocalizedStaticRoute($writer, 'home', [
            resource_path('js/pages/public/home.tsx'),
            resource_path('js/lib/public-copy.ts'),
        ]);
        $this->writeLocalizedStaticRoute($writer, 'contact', [
            resource_path('js/pages/public/contact.tsx'),
            resource_path('js/lib/public-copy.ts'),
        ]);
        $this->writeLocalizedStaticRoute($writer, 'impressum', [
            resource_path('js/pages/public/impressum.tsx'),
        ]);
        $this->writeLocalizedStaticRoute($writer, 'privacy', [
            resource_path('js/pages/public/privacy-policy.tsx'),
        ]);
        $this->writeLocalizedStaticRoute($writer, 'terms', [
            resource_path('js/pages/public/terms.tsx'),
        ]);

        foreach ($categories as $category) {
            $alternates = $this->localizedRouteUrls('categories.show', ['slug' => $category->slug]);

            foreach (PublicLocale::codes() as $locale) {
                $this->writeUrl(
                    $writer,
                    $alternates[$locale],
                    $category->updated_at?->toDateString(),
                    $alternates,
                );
            }
        }

        foreach ($products as $product) {
            $alternates = $this->localizedRouteUrls('products.show', ['slug' => $product->slug]);

            foreach (PublicLocale::codes() as $locale) {
                $this->writeUrl(
                    $writer,
                    $alternates[$locale],
                    $product->updated_at?->toDateString(),
                    $alternates,
                );
            }
        }

        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }

    /**
     * @param  array<int, string>  $sourceFiles
     */
    private function writeLocalizedStaticRoute(XMLWriter $writer, string $routeName, array $sourceFiles): void
    {
        $alternates = $this->localizedRouteUrls($routeName);
        $lastModified = $this->latestSourceDate($sourceFiles);

        foreach (PublicLocale::codes() as $locale) {
            $this->writeUrl($writer, $alternates[$locale], $lastModified, $alternates);
        }
    }

    /**
     * @param  array<string, string>  $alternates
     */
    private function writeUrl(XMLWriter $writer, string $location, ?string $lastModified = null, array $alternates = []): void
    {
        $writer->startElement('url');
        $writer->writeElement('loc', $location);

        if ($lastModified !== null) {
            $writer->writeElement('lastmod', $lastModified);
        }

        foreach ($alternates as $hrefLang => $href) {
            $writer->startElement('xhtml:link');
            $writer->writeAttribute('rel', 'alternate');
            $writer->writeAttribute('hreflang', $hrefLang);
            $writer->writeAttribute('href', $href);
            $writer->endElement();
        }

        $writer->endElement();
    }

    /**
     * @param  array<int, string>  $sourceFiles
     */
    private function latestSourceDate(array $sourceFiles): string
    {
        $timestamps = collect($sourceFiles)
            ->filter(fn (string $path): bool => is_file($path))
            ->map(fn (string $path): int => (int) filemtime($path))
            ->filter()
            ->values();

        if ($timestamps->isEmpty()) {
            return now()->toDateString();
        }

        return date('Y-m-d', $timestamps->max());
    }

    /**
     * @return array<string, string>
     */
    private function localizedRouteUrls(string $name, array $parameters = []): array
    {
        $urls = collect(PublicLocale::codes())
            ->mapWithKeys(fn (string $locale): array => [
                $locale => route($name, [
                    'locale' => $locale,
                    ...$parameters,
                ]),
            ])
            ->all();

        return [
            ...$urls,
            'x-default' => route($name, [
                'locale' => PublicLocale::Default,
                ...$parameters,
            ]),
        ];
    }
}
