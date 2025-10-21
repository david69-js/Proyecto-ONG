<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory;
    protected $table = 'ng_projects';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'objetivo',
        'beneficiarios',
        'presupuesto_total',
        'fondos_asignados',
        'fondos_ejecutados',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'responsable_id',
        'ubicacion',
        'resultados_esperados',
        'resultados_obtenidos',
        'fase_actual',
        'porcentaje_diagnostico',
        'porcentaje_formulacion',
        'porcentaje_financiacion',
        'porcentaje_ejecucion',
        'porcentaje_evaluacion',
        'porcentaje_cierre',
        'fecha_inicio_diagnostico',
        'fecha_fin_diagnostico',
        'fecha_inicio_formulacion',
        'fecha_fin_formulacion',
        'fecha_inicio_financiacion',
        'fecha_fin_financiacion',
        'fecha_inicio_ejecucion',
        'fecha_fin_ejecucion',
        'fecha_inicio_evaluacion',
        'fecha_fin_evaluacion',
        'fecha_inicio_cierre',
        'fecha_fin_cierre',
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Get the beneficiaries for this project.
     */
    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    /**
     * Get the users assigned to this project.
     */
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'rel_project_assignments')
                    ->withPivot('role_in_project', 'assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    /**
     * Get the phase images for this project.
     */
    public function phaseImages()
    {
        return $this->hasMany(ProjectPhaseImage::class);
    }

    /**
     * Get images for a specific phase.
     */
    public function getPhaseImages($fase)
    {
        return $this->phaseImages()->where('fase', $fase)->orderBy('orden')->get();
    }

    /**
     * Get the total progress percentage of the project.
     */
    public function getTotalProgressAttribute()
    {
        return ($this->porcentaje_diagnostico + 
                $this->porcentaje_formulacion + 
                $this->porcentaje_financiacion + 
                $this->porcentaje_ejecucion + 
                $this->porcentaje_evaluacion + 
                $this->porcentaje_cierre) / 6;
    }

    /**
     * Get the current phase name in Spanish.
     */
    public function getFaseActualNombreAttribute()
    {
        $fases = [
            'diagnostico' => 'Diagnóstico',
            'formulacion' => 'Formulación',
            'financiacion' => 'Financiación',
            'ejecucion' => 'Ejecución',
            'evaluacion' => 'Evaluación',
            'cierre' => 'Cierre'
        ];

        return $fases[$this->fase_actual] ?? 'Desconocida';
    }

    /**
     * Get all phases with their percentages.
     */
    public function getFasesConPorcentajesAttribute()
    {
        return [
            'diagnostico' => [
                'nombre' => 'Diagnóstico',
                'porcentaje' => $this->porcentaje_diagnostico,
                'fecha_inicio' => $this->fecha_inicio_diagnostico,
                'fecha_fin' => $this->fecha_fin_diagnostico
            ],
            'formulacion' => [
                'nombre' => 'Formulación',
                'porcentaje' => $this->porcentaje_formulacion,
                'fecha_inicio' => $this->fecha_inicio_formulacion,
                'fecha_fin' => $this->fecha_fin_formulacion
            ],
            'financiacion' => [
                'nombre' => 'Financiación',
                'porcentaje' => $this->porcentaje_financiacion,
                'fecha_inicio' => $this->fecha_inicio_financiacion,
                'fecha_fin' => $this->fecha_fin_financiacion
            ],
            'ejecucion' => [
                'nombre' => 'Ejecución',
                'porcentaje' => $this->porcentaje_ejecucion,
                'fecha_inicio' => $this->fecha_inicio_ejecucion,
                'fecha_fin' => $this->fecha_fin_ejecucion
            ],
            'evaluacion' => [
                'nombre' => 'Evaluación',
                'porcentaje' => $this->porcentaje_evaluacion,
                'fecha_inicio' => $this->fecha_inicio_evaluacion,
                'fecha_fin' => $this->fecha_fin_evaluacion
            ],
            'cierre' => [
                'nombre' => 'Cierre',
                'porcentaje' => $this->porcentaje_cierre,
                'fecha_inicio' => $this->fecha_inicio_cierre,
                'fecha_fin' => $this->fecha_fin_cierre
            ]
        ];
    }
}
