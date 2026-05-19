<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'background_image_path',
                'background_color',
                'link_url',
                'promo_code',
                'discount_percent',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique();
            $table->string('background_image_path')->nullable();
            $table->string('background_color')->nullable();
            $table->string('link_url')->nullable();
            $table->string('promo_code')->nullable();
            $table->smallInteger('discount_percent')->nullable();
        });
    }
};
