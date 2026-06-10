<?php

namespace App\Http\Controllers\Public;

use App\Models\Category;
use App\Models\Product;
use App\Support\StorageUrl;
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
            $this->productCardQuery()
                ->whereHas('categories', fn ($query) => $query->whereKey($category->id))
                ->orderByDesc('id'),
            $selectedFilters,
        )->paginate(12)->withQueryString();

        return Inertia::render('public/category', [
            ...$this->layoutProps(),
            'meta' => $this->modelMeta($category),
            'category' => [
                ...$this->categoryNavItem($category),
                'description' => $this->translation($category, 'description') ?? '',
                'banner_url' => StorageUrl::for($category->image_path),
            ],
            'filters' => $this->filterGroups($selectedFilters, $category->slug),
            'selected_filters' => $selectedFilters,
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
                'links' => $products->linkCollection()->all(),
            ],
        ]);
    }
}
