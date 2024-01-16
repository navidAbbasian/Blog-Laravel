<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mag_post_category', function (Blueprint $table) {
            $table->foreignId('post_id')->references('id')->on('mag_posts')->cascadeOnDelete();
            $table->foreignId('category_id')->references('id')->on('mag_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_post_category');
    }
};
