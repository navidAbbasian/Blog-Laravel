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
        Schema::create('mag_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alt')->nullable();
            $table->string('pic')->nullable();
            $table->string('code')->nullable();
            $table->string('link')->nullable();
            $table->string('landing_page')->nullable();
            $table->tinyInteger('row')->nullable();
            $table->tinyInteger('col')->nullable();
            $table->integer('order')->nullable();
            $table->integer('click')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('mag_banners');
    }
};
