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
        Schema::create('catalogue_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogue_page_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('thumbnail_image')->nullable();
            $table->string('pdf_link')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_categories');
    }
};
