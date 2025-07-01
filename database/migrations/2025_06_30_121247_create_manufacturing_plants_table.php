<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturingPlantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('manufacturing_plants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_us_page_id')->constrained()->onDelete('cascade');
            $table->string('plant_title');
            $table->string('plant_image')->nullable();
            $table->text('plant_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturing_plants');
    }
}
