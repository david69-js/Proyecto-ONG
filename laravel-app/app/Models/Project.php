<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

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

    /**
     * Relación con el usuario responsable
     */
    public function responsable()
    {
        return $this->belongsTo(SysUser::class, 'responsable_id');
    }
}
