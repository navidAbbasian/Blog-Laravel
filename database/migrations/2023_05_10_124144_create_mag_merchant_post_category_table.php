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
        Schema::create('mag_merchant_post_category', function (Blueprint $table) {
            $table->foreignId('post_id')->references('id')->on('mag_merchant_posts')->onDelete('cascade');
            $table->foreignId('category_id')->references('id')->on('mag_merchant_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_merchant_post_category');
    }
};
