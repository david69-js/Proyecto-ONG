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
<<<<<<< HEAD
        'link_conoce_mas',
    ];
}
=======
        'link_conoce_mas'
    ];
}
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
