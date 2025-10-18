<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();

            // Texto principal
            $table->string('titulo');
            $table->text('descripcion_principal')->nullable();
            $table->text('descripcion_secundaria')->nullable();

            // Logros numéricos (enteros)
            $table->integer('anios_servicio')->nullable();
            $table->integer('hogares_construidos')->nullable();
            $table->integer('compromiso_social')->nullable();
            $table->integer('colaboradores_activos')->nullable();

            // Imágenes generales
            $table->string('imagen_principal')->nullable();
            $table->string('imagen_secundaria')->nullable();
            $table->string('imagen_extra')->nullable();

            // Imágenes de Alianzas y Reconocimientos (certificaciones)
            $table->string('badge_1')->nullable();
            $table->string('badge_2')->nullable();
            $table->string('badge_3')->nullable();

            // Enlace “Conoce más”
            $table->text('link_conoce_mas')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
