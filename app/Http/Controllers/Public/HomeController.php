<?php

namespace App\Http\Controllers\Public;

use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends PublicController
{
    public function __invoke(): Response
    {
        $featuredProducts = $this->productCardQuery()
            ->where('is_featured', true)
            ->orderByDesc('id')
            ->limit(4)
            ->get()
            ->map(fn (Product $product) => $this->productCard($product))
            ->values()
            ->all();

        return Inertia::render('public/home', [
            ...$this->layoutProps(),
            'promotions' => $this->promotions(),
            'page_sections' => $this->pageSections(),
            'featured_products' => $featuredProducts,
        ]);
    }
}
