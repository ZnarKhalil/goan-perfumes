<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->unique(['product_id', 'size_ml'], 'product_variants_product_size_unique');
        });

        if (in_array(DB::getDriverName(), ['pgsql', 'sqlite'], true)) {
            DB::statement(
                'CREATE UNIQUE INDEX product_variants_one_default_per_product ON product_variants (product_id) WHERE is_default = true',
            );
        }
    }

    public function down(): void
    {
        if (in_array(DB::getDriverName(), ['pgsql', 'sqlite'], true)) {
            DB::statement('DROP INDEX IF EXISTS product_variants_one_default_per_product');
        }

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique('product_variants_product_size_unique');
        });
    }
};
