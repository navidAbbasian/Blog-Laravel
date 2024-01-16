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
        Schema::create('mag_merchant_slider', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->references('id')->on('merchant');
            $table->string('title')->default('');
            $table->string('alt')->default('');
            $table->string('picture')->default('');
            $table->string('mobile_picture')->default('');
            $table->string('category')->default('');
            $table->string('link')->default('');
            $table->string('position')->default('')->comment('1= right-bottom, 2=left-bottom, 3=left-bottom, 4=right-up, 5=center, 6=left-up');
            $table->bigInteger('CreatedBy')->nullable(); //the person who logged in
            $table->bigInteger('EditedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_merchant_slider');
    }
};
