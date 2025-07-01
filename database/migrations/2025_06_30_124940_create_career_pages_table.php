<?php

// database/migrations/xxxx_xx_xx_create_career_pages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerPagesTable extends Migration
{
    public function up()
    {
        Schema::create('career_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->text('banner_description')->nullable();
            $table->text('below_banner_description')->nullable();
            $table->string('below_description_image')->nullable();
            $table->string('apply_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('career_pages');
    }
}

