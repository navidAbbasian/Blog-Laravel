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
        Schema::create('mag_merchant_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->references('id')->on('merchant');
            $table->foreignId('post_id')->references('id')->on('mag_merchant_posts')->cascadeOnDelete();
            $table->bigInteger('customer_id')->default(0);
            $table->string('name');
            $table->string('email');
            $table->longText('body');
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->bigInteger('is_answer')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('mag_merchant_comments');
    }
};
