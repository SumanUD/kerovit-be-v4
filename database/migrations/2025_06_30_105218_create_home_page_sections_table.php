<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('home_page_sections', function (Blueprint $table) {
        $table->id();

        // Section 1: Banner Videos (array of URLs or file paths)
        $table->json('banner_videos')->nullable();

        // Section 2: Categories
        $table->text('categories_description')->nullable();
        $table->string('category_faucet_image')->nullable();
        $table->string('category_showers_image')->nullable();
        $table->string('category_basin_image')->nullable();
        $table->string('category_toilet_image')->nullable();
        $table->string('category_furniture_image')->nullable();
        $table->string('category_accessories_image')->nullable();

        // Section 3: Collections
        $table->text('collections_description')->nullable();
        $table->text('aurum_description')->nullable();
        $table->string('aurum_image')->nullable();
        $table->text('klassic_description')->nullable();
        $table->string('klassic_image')->nullable();

        // Section 4: Locate Our Store
        $table->string('store_banner_image')->nullable();
        $table->string('store_header')->nullable();
        $table->text('store_description')->nullable();

        // Section 5: About Us
        $table->string('about_banner_video')->nullable();
        $table->text('about_description')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_sections');
    }
};
