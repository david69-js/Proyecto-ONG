<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
{
    if (!Schema::hasTable('about_sections')) {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion_principal')->nullable();
            $table->text('descripcion_secundaria')->nullable();
            $table->integer('anios_servicio')->nullable();
            $table->integer('hogares_construidos')->nullable();
            $table->integer('compromiso_social')->nullable();
            $table->integer('colaboradores_activos')->nullable();
            $table->string('imagen_principal')->nullable();
            $table->string('imagen_secundaria')->nullable();
            $table->string('imagen_extra')->nullable();
            $table->string('badge_1')->nullable();
            $table->string('badge_2')->nullable();
            $table->string('badge_3')->nullable();
            $table->text('link_conoce_mas')->nullable();
            $table->timestamps();
        });
    }
}

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
