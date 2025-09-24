<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // 👇 aquí especificas el nombre real de la tabla
    protected $table = 'locations';

    protected $fillable = [
        'nombre', 
        'direccion', 
        'ciudad', 
        'pais', 
        'latitud', 
        'longitud'
    ];
}

