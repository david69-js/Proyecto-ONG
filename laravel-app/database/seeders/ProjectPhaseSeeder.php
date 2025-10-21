<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Actualizar proyectos existentes con valores por defecto para las fases
        Project::whereNull('fase_actual')->update([
            'fase_actual' => 'diagnostico',
            'porcentaje_diagnostico' => 0,
            'porcentaje_formulacion' => 0,
            'porcentaje_financiacion' => 0,
            'porcentaje_ejecucion' => 0,
            'porcentaje_evaluacion' => 0,
            'porcentaje_cierre' => 0,
        ]);

        $this->command->info('Fases de proyecto actualizadas con valores por defecto.');
    }
}
