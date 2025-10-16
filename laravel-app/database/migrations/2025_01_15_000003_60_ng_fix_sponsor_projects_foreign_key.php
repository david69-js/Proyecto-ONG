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
        Schema::table('rel_sponsor_projects', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea existente
            $table->dropForeign(['project_id']);
            
            // Agregar la nueva restricción de clave foránea que apunta a la tabla correcta
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
