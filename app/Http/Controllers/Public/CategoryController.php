<?php

namespace App\Http\Controllers\Public;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends PublicController
{
    public function show(Request $request, string $locale, string $slug): Response
    {
        $category = Category::query()
            ->with('translations')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        $selectedFilters = $this->selectedFilters($request->query());
        $products = $this->applyFilters(
            $this->orderByPublicCatalogName(
                $this->productCardQuery()
                    ->whereHas('categories', fn ($query) => $query->whereKey($category->id)),
            ),
            $selectedFilters,
        )->paginate(12)->withQueryString();
        $canonical = route('categories.show', [
            'locale' => $this->locale(),
            'slug' => $category->slug,
        ]);
        $hasQueryParameters = $request->query() !== [];

        return Inertia::render('public/category', [
            ...$this->layoutProps(),
            'meta' => $this->modelMeta(
                $category,
                canonical: $canonical,
                alternates: $this->localizedRouteUrls('categories.show', ['slug' => $category->slug]),
                structuredData: [
                    $this->breadcrumbStructuredData([
                        [
                            'name' => 'Goan Perfume',
                            'url' => route('home', ['locale' => $this->locale()]),
                        ],
                        [
                            'name' => $this->translation($category, 'name') ?? $category->slug,
                            'url' => $canonical,
                        ],
                    ]),
                ],
                robots: $hasQueryParameters ? 'noindex, follow' : null,
            ),
            'category' => [
                ...$this->categoryNavItem($category),
                'description' => $this->translation($category, 'description') ?? '',
            ],
            'related_categories' => $this->relatedCategoryNavItems($category),
            'filters' => $this->filterGroups($selectedFilters, $category->slug),
            'selected_filters' => $selectedFilters,
            'products' => $products
                ->getCollection()
                ->map(fn (Product $product) => $this->productCard($product, $category))
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
}
