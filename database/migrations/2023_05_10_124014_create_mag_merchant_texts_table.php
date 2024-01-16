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
        Schema::create('mag_merchant_texts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->references('id')->on('merchant');
            $table->string('title');
            $table->string('name')->nullable();
            $table->longText('body')->nullable();
            $table->string('landing_page');
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
        Schema::dropIfExists('mag_merchant_texts');
    }
};
