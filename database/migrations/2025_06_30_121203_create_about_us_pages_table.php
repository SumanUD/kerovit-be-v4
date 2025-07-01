<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsPagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('about_us_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_video')->nullable();
            $table->text('below_banner_description')->nullable();
            $table->string('director_image')->nullable();
            $table->text('director_description')->nullable();
            $table->json('certification_images')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us_pages');
    }
}
