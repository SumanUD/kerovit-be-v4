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
    Schema::create('product_variants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->string('product_code')->unique();
        $table->string('product_picture')->nullable();
        $table->string('product_title');
        $table->string('series')->nullable();
        $table->string('shape')->nullable();
        $table->string('spray')->nullable();
        $table->text('product_description')->nullable();
        $table->string('product_color_code')->nullable();
        $table->text('product_feature')->nullable();
        $table->text('product_installation_service_parts')->nullable();
        $table->string('design_files')->nullable();
        $table->text('additional_information')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
