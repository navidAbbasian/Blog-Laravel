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
        Schema::create('mag_setting', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("");
            $table->string('meta_title')->default("");
            $table->string('meta_description',)->default("");
            $table->string('logo_dark')->nullable();
            $table->string('logo_light')->nullable();
            $table->string('header_btn')->default("");
            $table->string('header_link')->default("");
            $table->string('area_code')->default("");
            $table->string('phone_number')->default("");
            $table->mediumText('mag_home_description')->nullable();
            $table->mediumText('mag_video_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mag_setting');
    }
};
