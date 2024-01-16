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
        Schema::create('mag_merchant_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->references('id')->on('merchant');
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('abstracted')->nullable();
            $table->longText('body')->nullable();
            $table->foreignId('author')->references('id')->on('customer');
            $table->tinyInteger('published')->default(0);
            $table->timestamp('published_date')->nullable();
            $table->string('similar')->nullable();
            $table->string('more')->nullable();
            $table->string('source')->nullable();
            $table->string('source_link')->nullable();
            $table->string('pic')->nullable();
            $table->string('pic_small')->nullable();
            $table->string('pic_very_small')->nullable();
            $table->string('video')->nullable();
            $table->string('embed')->nullable();
            $table->string('alt')->nullable();
            $table->integer('view')->nullable();
            $table->integer('view_aff')->nullable();
            $table->tinyInteger('chief_select')->default(0);
            $table->tinyInteger('type')->default(0)->comment('default type 0 = post,type 1 = video');
            $table->tinyInteger('share')->default(0);
            $table->string('products')->nullable();
            $table->bigInteger('createdBy')->nullable();
            $table->bigInteger('editedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_merchant_posts');
    }
};
