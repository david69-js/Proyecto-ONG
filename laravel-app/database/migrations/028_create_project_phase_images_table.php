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
        Schema::create('project_phase_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->enum('fase', ['diagnostico', 'formulacion', 'financiacion', 'ejecucion', 'evaluacion', 'cierre']);
            $table->string('imagen_path');
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('ng_projects')->onDelete('cascade');
            $table->index(['project_id', 'fase']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_phase_images');
    }
};
