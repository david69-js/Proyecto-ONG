<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion_principal',
        'descripcion_secundaria',
        'anios_servicio',
        'hogares_construidos',
        'compromiso_social',
        'colaboradores_activos',
        'imagen_principal',
        'imagen_secundaria',
        'link_conoce_mas'
    ];
}
