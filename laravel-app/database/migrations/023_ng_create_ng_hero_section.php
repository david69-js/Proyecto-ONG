<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('subtitle')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_primary_text')->nullable();
            $table->string('button_primary_link')->nullable();
            $table->string('button_secondary_text')->nullable();
            $table->string('button_secondary_link')->nullable();
            $table->integer('anios_servicio')->nullable();
            $table->integer('viviendas_construidas')->nullable();
            $table->integer('familias_beneficiadas')->nullable();
            $table->string('image_main')->nullable();
            $table->string('image_badge_text')->nullable();
            $table->string('image_badge_subtext')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
