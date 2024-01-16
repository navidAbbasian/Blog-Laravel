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
        Schema::create('mag_merchant_customer_favorite_post', function (Blueprint $table) {
            $table->foreignId('customer_id')->references('id')->on('customer')->cascadeOnDelete();
            $table->foreignId('post_id')->references('id')->on('mag_merchant_posts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_merchant_customer_favorite_post');
    }
};
