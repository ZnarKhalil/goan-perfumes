<?php

namespace App\Http\Controllers\Public;

use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        $pageSections = $this->pageSections();
        $meta = match ($this->locale()) {
            'en' => [
                null,
                'Discover luxury, niche, and Arabic perfumes at Goan Perfume in Kelheim with curated collections and personal fragrance advice.',
            ],
            'ar' => [
                null,
                'اكتشف عطوراً فاخرة ونادرة وعربية لدى Goan Perfume في كيلهايم مع مجموعات مختارة واستشارة عطرية شخصية.',
            ],
            default => [
                null,
                'Entdecken Sie Luxus-, Nischen- und arabische Parfums bei Goan Perfume in Kelheim mit kuratierten Kollektionen und persönlicher Duftberatung.',
            ],
        };

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
            'meta' => $this->localizedMeta(
                $meta[0],
                $meta[1],
                'home',
                preloadImageUrl: $pageSections['hero']['video_url'] ? null : $pageSections['hero']['image_url'],
            ),
            'promotions' => $this->promotions(),
            'page_sections' => $pageSections,
            'featured_products' => $featuredProducts,
        ]);
    }
}
