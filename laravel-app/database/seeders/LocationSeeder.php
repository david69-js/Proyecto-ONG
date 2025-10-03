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
                'nombre' => 'Centro Comunitario San José',
                'direccion' => 'Calle Principal 123, Colonia Centro',
                'ciudad' => 'Oaxaca de Juárez',
                'pais' => 'México',
                'latitud' => 17.0732,
                'longitud' => -96.7266,
            ],
            [
                'nombre' => 'Escuela Primaria Rural "Benito Juárez"',
                'direccion' => 'Carretera Federal 190, Km 45',
                'ciudad' => 'San Juan Bautista Tuxtepec',
                'pais' => 'México',
                'latitud' => 18.1000,
                'longitud' => -96.1167,
            ],
            [
                'nombre' => 'Centro de Salud Comunitario',
                'direccion' => 'Avenida Revolución 456, Colonia Popular',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'latitud' => 19.4326,
                'longitud' => -99.1332,
            ],
            [
                'nombre' => 'Centro de Capacitación Técnica',
                'direccion' => 'Boulevard Industrial 789, Zona Industrial',
                'ciudad' => 'Puebla',
                'pais' => 'México',
                'latitud' => 19.0414,
                'longitud' => -98.2063,
            ],
            [
                'nombre' => 'Comunidad Rural "El Progreso"',
                'direccion' => 'Camino Rural s/n, Ejido El Progreso',
                'ciudad' => 'Tuxtla Gutiérrez',
                'pais' => 'México',
                'latitud' => 16.7500,
                'longitud' => -93.1167,
            ],
            [
                'nombre' => 'Centro de Desarrollo Comunitario',
                'direccion' => 'Calle 5 de Mayo 321, Centro Histórico',
                'ciudad' => 'Morelia',
                'pais' => 'México',
                'latitud' => 19.7008,
                'longitud' => -101.1844,
            ],
            [
                'nombre' => 'Escuela Secundaria Técnica',
                'direccion' => 'Avenida Universidad 654, Colonia Universitaria',
                'ciudad' => 'Veracruz',
                'pais' => 'México',
                'latitud' => 19.1738,
                'longitud' => -96.1342,
            ],
            [
                'nombre' => 'Centro de Atención a Adultos Mayores',
                'direccion' => 'Calle Independencia 987, Colonia Libertad',
                'ciudad' => 'Guadalajara',
                'pais' => 'México',
                'latitud' => 20.6597,
                'longitud' => -103.3496,
            ],
            [
                'nombre' => 'Reserva Natural "Sierra Madre"',
                'direccion' => 'Carretera a la Sierra, Km 25',
                'ciudad' => 'Michoacán',
                'pais' => 'México',
                'latitud' => 19.5667,
                'longitud' => -101.6000,
            ],
            [
                'nombre' => 'Centro de Microempresas Femeninas',
                'direccion' => 'Plaza del Mercado 147, Zona Centro',
                'ciudad' => 'Acapulco',
                'pais' => 'México',
                'latitud' => 16.8531,
                'longitud' => -99.8237,
            ],
            [
                'nombre' => 'Centro de Capacitación en Oficios',
                'direccion' => 'Calle del Trabajo 258, Colonia Obrera',
                'ciudad' => 'Monterrey',
                'pais' => 'México',
                'latitud' => 25.6866,
                'longitud' => -100.3161,
            ],
            [
                'nombre' => 'Comunidad Indígena "Nueva Esperanza"',
                'direccion' => 'Camino Vecinal s/n, Comunidad Indígena',
                'ciudad' => 'San Cristóbal de las Casas',
                'pais' => 'México',
                'latitud' => 16.7370,
                'longitud' => -92.6376,
            ],
            [
                'nombre' => 'Centro de Salud Mental Comunitario',
                'direccion' => 'Avenida de la Salud 369, Colonia San Rafael',
                'ciudad' => 'Tijuana',
                'pais' => 'México',
                'latitud' => 32.5149,
                'longitud' => -117.0382,
            ],
            [
                'nombre' => 'Escuela de Artes y Oficios',
                'direccion' => 'Calle de las Artes 741, Barrio Histórico',
                'ciudad' => 'Guanajuato',
                'pais' => 'México',
                'latitud' => 21.0190,
                'longitud' => -101.2574,
            ],
            [
                'nombre' => 'Centro de Desarrollo Rural Integral',
                'direccion' => 'Carretera Rural 125, Ejido San Miguel',
                'ciudad' => 'Durango',
                'pais' => 'México',
                'latitud' => 24.0225,
                'longitud' => -104.6708,
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