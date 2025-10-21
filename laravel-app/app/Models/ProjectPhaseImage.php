<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPhaseImage extends Model
{
    use HasFactory;

    protected $table = 'project_phase_images';
    
    protected $fillable = [
        'project_id',
        'fase',
        'imagen_path',
        'titulo',
        'descripcion',
        'orden'
    ];

    /**
     * Get the project that owns the image.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the full URL for the image.
     */
    public function getImagenUrlAttribute()
    {
        return asset('storage/' . $this->imagen_path);
    }

    /**
     * Get the phase name in Spanish.
     */
    public function getFaseNombreAttribute()
    {
        $fases = [
            'diagnostico' => 'Diagnóstico',
            'formulacion' => 'Formulación',
            'financiacion' => 'Financiación',
            'ejecucion' => 'Ejecución',
            'evaluacion' => 'Evaluación',
            'cierre' => 'Cierre'
        ];

        return $fases[$this->fase] ?? 'Desconocida';
    }
}
