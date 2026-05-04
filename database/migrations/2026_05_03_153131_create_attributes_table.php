<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_filterable')->default(true);
            $table->boolean('is_multiple');
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
