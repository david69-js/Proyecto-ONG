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
}
