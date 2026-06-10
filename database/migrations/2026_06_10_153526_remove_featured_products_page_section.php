<?php

use App\Models\PageSection;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Drop the unused featured_products page section. The public home page
     * sources its featured products from the products.is_featured flag, so
     * this section was editable in the dashboard but never rendered.
     */
    public function up(): void
    {
        PageSection::query()
            ->where('key', 'featured_products')
            ->get()
            ->each(function (PageSection $section): void {
                $section->translations()->delete();
                $section->delete();
            });
    }

    public function down(): void
    {
        PageSection::query()->firstOrCreate(
            ['key' => 'featured_products'],
            [
                'type' => 'product_list',
                'payload' => ['product_ids' => []],
                'sort_order' => 30,
                'is_active' => true,
            ],
        );
    }
};
