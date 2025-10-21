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
    Schema::create('ng_projects', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->string('objetivo')->nullable();
        $table->string('beneficiarios')->nullable();
        $table->decimal('presupuesto_total', 15, 2)->nullable();
        $table->decimal('fondos_asignados', 15, 2)->nullable();
        $table->decimal('fondos_ejecutados', 15, 2)->nullable();
        $table->date('fecha_inicio');
        $table->date('fecha_fin')->nullable();
        $table->enum('estado', ['planificado','en_progreso','pausado','finalizado','cancelado'])->default('planificado');
        $table->unsignedBigInteger('responsable_id')->nullable();
        $table->string('ubicacion')->nullable();
        $table->text('resultados_esperados')->nullable();
        $table->text('resultados_obtenidos')->nullable();
        
        // Campos para fases del proyecto con porcentajes
        $table->enum('fase_actual', ['diagnostico', 'formulacion', 'financiacion', 'ejecucion', 'evaluacion', 'cierre'])->default('diagnostico');
        $table->integer('porcentaje_diagnostico')->default(0);
        $table->integer('porcentaje_formulacion')->default(0);
        $table->integer('porcentaje_financiacion')->default(0);
        $table->integer('porcentaje_ejecucion')->default(0);
        $table->integer('porcentaje_evaluacion')->default(0);
        $table->integer('porcentaje_cierre')->default(0);
        
        // Campos para fechas de cada fase
        $table->date('fecha_inicio_diagnostico')->nullable();
        $table->date('fecha_fin_diagnostico')->nullable();
        $table->date('fecha_inicio_formulacion')->nullable();
        $table->date('fecha_fin_formulacion')->nullable();
        $table->date('fecha_inicio_financiacion')->nullable();
        $table->date('fecha_fin_financiacion')->nullable();
        $table->date('fecha_inicio_ejecucion')->nullable();
        $table->date('fecha_fin_ejecucion')->nullable();
        $table->date('fecha_inicio_evaluacion')->nullable();
        $table->date('fecha_fin_evaluacion')->nullable();
        $table->date('fecha_inicio_cierre')->nullable();
        $table->date('fecha_fin_cierre')->nullable();
        
        $table->timestamps();

        $table->foreign('responsable_id')->references('id')->on('sys_users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ng_projects');
    }
};
