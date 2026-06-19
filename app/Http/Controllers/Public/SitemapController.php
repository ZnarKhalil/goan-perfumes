<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\PublicLocale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use XMLWriter;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
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

        return response($this->xml($categories, $products), 200, [
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

        foreach (PublicLocale::codes() as $locale) {
            $this->writeUrl($writer, route('home', ['locale' => $locale]));
            $this->writeUrl($writer, route('contact', ['locale' => $locale]));
            $this->writeUrl($writer, route('impressum', ['locale' => $locale]));
            $this->writeUrl($writer, route('privacy', ['locale' => $locale]));
        }

        foreach ($categories as $category) {
            foreach (PublicLocale::codes() as $locale) {
                $this->writeUrl(
                    $writer,
                    route('categories.show', [
                        'locale' => $locale,
                        'slug' => $category->slug,
                    ]),
                    $category->updated_at?->toDateString(),
                );
            }
        }

        foreach ($products as $product) {
            foreach (PublicLocale::codes() as $locale) {
                $this->writeUrl(
                    $writer,
                    route('products.show', [
                        'locale' => $locale,
                        'slug' => $product->slug,
                    ]),
                    $product->updated_at?->toDateString(),
                );
            }
        }

        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }

    private function writeUrl(XMLWriter $writer, string $location, ?string $lastModified = null): void
    {
        $writer->startElement('url');
        $writer->writeElement('loc', $location);

        if ($lastModified !== null) {
            $writer->writeElement('lastmod', $lastModified);
        }

        $writer->endElement();
    }
}
