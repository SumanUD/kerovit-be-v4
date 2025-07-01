<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customer_care_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->string('below_banner_image')->nullable();
            $table->string('service_query_email')->nullable();
            $table->string('info_email')->nullable();
            $table->string('call_number')->nullable();
            $table->string('tollfree_number')->nullable();
            $table->string('whatsapp_chat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customer_care_pages');
    }
};

