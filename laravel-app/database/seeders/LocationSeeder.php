<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'nombre' => 'Centro Comunitario Zona 1',
                'direccion' => '6ta Avenida 8-45, Zona 1',
                'ciudad' => 'Ciudad de Guatemala',
                'pais' => 'Guatemala',
                'latitud' => 14.6349,
                'longitud' => -90.5069,
            ],
            [
                'nombre' => 'Escuela Rural San Juan',
                'direccion' => 'Carretera a El Progreso Km 15',
                'ciudad' => 'El Progreso',
                'pais' => 'Guatemala',
                'latitud' => 14.8500,
                'longitud' => -90.0167,
            ],
            [
                'nombre' => 'Centro de Salud Comunitario',
                'direccion' => 'Calle Real 5-25, Zona 2',
                'ciudad' => 'Antigua Guatemala',
                'pais' => 'Guatemala',
                'latitud' => 14.5591,
                'longitud' => -90.7345,
            ],
            [
                'nombre' => 'Centro de Capacitación Técnica',
                'direccion' => 'Boulevard Los Próceres 25-50, Zona 10',
                'ciudad' => 'Ciudad de Guatemala',
                'pais' => 'Guatemala',
                'latitud' => 14.6038,
                'longitud' => -90.5142,
            ],
            [
                'nombre' => 'Comunidad Rural "Nueva Esperanza"',
                'direccion' => 'Camino Rural s/n, Aldea Nueva Esperanza',
                'ciudad' => 'Quetzaltenango',
                'pais' => 'Guatemala',
                'latitud' => 14.8347,
                'longitud' => -91.5181,
            ],
            [
                'nombre' => 'Centro de Desarrollo Comunitario',
                'direccion' => 'Calle del Comercio 3-45, Centro Histórico',
                'ciudad' => 'Chichicastenango',
                'pais' => 'Guatemala',
                'latitud' => 14.9442,
                'longitud' => -91.1108,
            ],
            [
                'nombre' => 'Escuela Secundaria Técnica',
                'direccion' => 'Avenida Universidad 8-25, Zona 12',
                'ciudad' => 'Ciudad de Guatemala',
                'pais' => 'Guatemala',
                'latitud' => 14.5889,
                'longitud' => -90.5200,
            ],
            [
                'nombre' => 'Centro de Atención a Adultos Mayores',
                'direccion' => 'Calle de la Libertad 12-30, Zona 3',
                'ciudad' => 'Escuintla',
                'pais' => 'Guatemala',
                'latitud' => 14.3009,
                'longitud' => -90.7858,
            ],
            [
                'nombre' => 'Reserva Natural "Sierra de las Minas"',
                'direccion' => 'Carretera a la Sierra, Km 45',
                'ciudad' => 'Zacapa',
                'pais' => 'Guatemala',
                'latitud' => 14.9724,
                'longitud' => -89.5309,
            ],
            [
                'nombre' => 'Centro de Microempresas Femeninas',
                'direccion' => 'Plaza del Mercado 2-15, Zona Centro',
                'ciudad' => 'Cobán',
                'pais' => 'Guatemala',
                'latitud' => 15.4708,
                'longitud' => -90.3708,
            ],
            [
                'nombre' => 'Centro de Capacitación en Oficios',
                'direccion' => 'Calle del Trabajo 4-20, Zona Industrial',
                'ciudad' => 'Villa Nueva',
                'pais' => 'Guatemala',
                'latitud' => 14.5319,
                'longitud' => -90.5875,
            ],
            [
                'nombre' => 'Comunidad Indígena "Nueva Vida"',
                'direccion' => 'Camino Vecinal s/n, Aldea Nueva Vida',
                'ciudad' => 'Sololá',
                'pais' => 'Guatemala',
                'latitud' => 14.7722,
                'longitud' => -91.1831,
            ],
            [
                'nombre' => 'Centro de Salud Mental Comunitario',
                'direccion' => 'Avenida de la Salud 6-40, Zona 7',
                'ciudad' => 'Ciudad de Guatemala',
                'pais' => 'Guatemala',
                'latitud' => 14.6400,
                'longitud' => -90.5000,
            ],
            [
                'nombre' => 'Escuela de Artes y Oficios',
                'direccion' => 'Calle de las Artes 1-25, Barrio Histórico',
                'ciudad' => 'San Pedro La Laguna',
                'pais' => 'Guatemala',
                'latitud' => 14.6944,
                'longitud' => -91.2722,
            ],
            [
                'nombre' => 'Centro de Desarrollo Rural Integral',
                'direccion' => 'Carretera Rural 15, Aldea San Miguel',
                'ciudad' => 'Huehuetenango',
                'pais' => 'Guatemala',
                'latitud' => 15.3167,
                'longitud' => -91.4667,
            ],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['nombre' => $location['nombre']],
                $location
            );
        }
    }
}