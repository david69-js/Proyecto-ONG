<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory;
    protected $table = 'ng_projects';
    
    // Constantes para las fases del proyecto
    const PHASES = [
        'diagnostico' => ['name' => 'Diagnóstico', 'percentage' => 0],
        'formulacion' => ['name' => 'Formulación', 'percentage' => 15],
        'financiacion' => ['name' => 'Financiación', 'percentage' => 30],
        'ejecucion' => ['name' => 'Ejecución', 'percentage' => 50],
        'evaluacion' => ['name' => 'Evaluación', 'percentage' => 80],
        'cierre' => ['name' => 'Cierre', 'percentage' => 100],
    ];
    
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
        'fase',
        'porcentaje',
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
     * Get the phase name and percentage.
     */
    public function getPhaseInfoAttribute()
    {
        return self::PHASES[$this->fase] ?? null;
    }

    /**
     * Update percentage when phase changes.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($project) {
            if ($project->isDirty('fase')) {
                $phaseInfo = self::PHASES[$project->fase] ?? null;
                if ($phaseInfo) {
                    $project->porcentaje = $phaseInfo['percentage'];
                }
            }
        });
    }
}
