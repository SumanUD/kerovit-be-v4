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
        
    Schema::create('dealers', function (Blueprint $table) {
        $table->id();
        $table->string('dealercode', 150)->nullable(); // New field
        $table->string('dealername', 150)->nullable();
        $table->text('address')->nullable(); // Merged address1, 2, 3
        $table->string('city', 150)->nullable();
        $table->string('state', 150)->nullable();
        $table->string('pincode', 25)->nullable();
        $table->string('phone', 100)->nullable();
        $table->string('fax', 50)->nullable();
        $table->string('contactnumber', 200)->nullable();
        $table->string('contactperson', 200)->nullable();
        $table->string('dealertype', 100)->nullable();
        $table->text('google_link')->nullable();
        $table->date('date_of_updation')->nullable(); // New field
        $table->timestamps();
    });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
