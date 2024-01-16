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
        Schema::create('mag_post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->references('id')->on('mag_posts')->onDelete('cascade');
            $table->foreignId('tag_id')->references('id')->on('mag_tag')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_post_tag');
    }
};
