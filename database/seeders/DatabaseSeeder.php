<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            SettingSeeder::class,
            PageSectionSeeder::class,
            ProductCatalogSeeder::class,
        ]);

        $this->prunePromotions();
    }

    private function prunePromotions(): void
    {
        Promotion::query()
            ->with('translations')
            ->each(function (Promotion $promotion): void {
                $promotion->translations()->delete();
                $promotion->delete();
            });
    }
}
