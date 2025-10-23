<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'ng_projects';

    /**
     * Fases del proyecto con su nombre y porcentaje de avance.
     */
    const PHASES = [
        'diagnostico'  => ['name' => 'Diagnóstico',  'percentage' => 0],
        'formulacion'  => ['name' => 'Formulación',  'percentage' => 15],
        'financiacion' => ['name' => 'Financiación', 'percentage' => 30],
        'ejecucion'    => ['name' => 'Ejecución',    'percentage' => 50],
        'evaluacion'   => ['name' => 'Evaluación',   'percentage' => 80],
        'cierre'       => ['name' => 'Cierre',       'percentage' => 100],
    ];

    /**
     * Campos asignables en masa.
     */
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
        'is_published',
    ];

    /**
     * Conversiones automáticas de tipo.
     */
    protected $casts = [
        'is_published'   => 'boolean',
        'fecha_inicio'   => 'date',
        'fecha_fin'      => 'date',
        'presupuesto_total' => 'decimal:2',
        'fondos_asignados'  => 'decimal:2',
        'fondos_ejecutados' => 'decimal:2',
    ];

    /*-----------------------------------------
     | RELACIONES
     |-----------------------------------------*/

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'rel_project_assignments')
            ->withPivot('role_in_project', 'assigned_at', 'assigned_by')
            ->withTimestamps();
    }

    public function phaseImages()
    {
        return $this->hasMany(ProjectPhaseImage::class, 'project_id');
    }

    /*-----------------------------------------
     | MÉTODOS PERSONALIZADOS
     |-----------------------------------------*/

    /**
     * Devuelve el nombre y porcentaje de la fase actual.
     */
    public function getPhaseInfoAttribute()
    {
        return self::PHASES[$this->fase] ?? null;
    }

    /**
     * Mutador automático: actualiza porcentaje según fase.
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

    /*-----------------------------------------
     | SCOPES (consultas rápidas)
     |-----------------------------------------*/

    /**
     * Filtra solo proyectos publicados.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Filtra solo proyectos no publicados.
     */
    public function scopeUnpublished($query)
    {
        return $query->where('is_published', false);
    }
}
