<?php

namespace App\Http\Controllers\Public;

use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class PricingController extends PublicController
{
    public function __invoke(): Response
    {
        $categories = Category::query()
            ->with('translations')
            ->whereIn('slug', self::CATEGORY_SLUGS)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Category $category) => $this->categoryNavItem($category))
            ->values()
            ->all();

        return Inertia::render('public/pricing', [
            ...$this->layoutProps(),
            'categories' => $categories,
        ]);
    }
}
