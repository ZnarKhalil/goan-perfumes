<?php

namespace App\Http\Controllers\Public;

use App\Models\Product;
use App\Support\PublicLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends PublicController
{
    public function index(Request $request, string $locale): Response
    {
        $term = Str::squish((string) $request->query('q', ''));

        $query = $this->orderByPublicCatalogName($this->productCardQuery());

        if ($term === '') {
            $query->whereRaw('1 = 0');
        } else {
            $like = '%'.addcslashes($term, '%_\\').'%';
            $locales = array_values(array_unique([$this->locale(), PublicLocale::Default]));

            $query->whereHas('translations', fn (Builder $translation) => $translation
                ->where('field', 'name')
                ->whereIn('locale', $locales)
                ->where('value', 'like', $like));
        }

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('public/search', [
            ...$this->layoutProps(),
            'meta' => $this->meta(
                $this->searchTitle($term),
                $this->searchDescription(),
                canonical: route('search', ['locale' => $this->locale()]),
                robots: 'noindex, follow',
            ),
            'query' => $term,
            'products' => $products
                ->getCollection()
                ->map(fn (Product $product) => $this->productCard($product))
                ->values()
                ->all(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
                'links' => $products->linkCollection()
                    ->map(fn (array $link): array => [
                        'label' => $link['label'],
                        'href' => $link['url'],
                        'active' => $link['active'],
                    ])
                    ->all(),
            ],
        ]);
    }

    private function searchTitle(string $term): string
    {
        $label = match ($this->locale()) {
            'en' => 'Search',
            'ar' => 'بحث',
            default => 'Suche',
        };

        return $term === '' ? $label : "{$label}: {$term}";
    }

    private function searchDescription(): string
    {
        return match ($this->locale()) {
            'en' => 'Search the Goan Perfume catalogue by product name.',
            'ar' => 'ابحث في كتالوج Goan Perfume حسب اسم المنتج.',
            default => 'Durchsuchen Sie den Goan-Perfume-Katalog nach Produktnamen.',
        };
    }
}
