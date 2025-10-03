<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios para asignar como responsables
        $projectCoordinator = User::where('email', 'proyectos@ong.com')->first();
        $admin = User::where('email', 'coordinador@ong.com')->first();

        $projects = [
            [
                'nombre' => 'Educación Comunitaria Rural',
                'descripcion' => 'Proyecto enfocado en mejorar el acceso a la educación en comunidades rurales marginadas, proporcionando materiales educativos, capacitación docente y apoyo escolar.',
                'objetivo' => 'Reducir el analfabetismo en 5 comunidades rurales en un 40% durante el primer año',
                'beneficiarios' => '500 niños y niñas de 6 a 15 años, 50 maestros rurales',
                'presupuesto_total' => 250000.00,
                'fondos_asignados' => 200000.00,
                'fondos_ejecutados' => 75000.00,
                'fecha_inicio' => '2024-01-15',
                'fecha_fin' => '2025-01-15',
                'estado' => 'en_progreso',
                'responsable_id' => $projectCoordinator?->id,
                'ubicacion' => 'Comunidades rurales del estado de Oaxaca',
                'resultados_esperados' => 'Mejora en el rendimiento académico, reducción del abandono escolar, capacitación de maestros',
                'resultados_obtenidos' => 'Se han capacitado 30 maestros, se han distribuido 200 kits escolares',
            ],
            [
                'nombre' => 'Salud Preventiva Infantil',
                'descripcion' => 'Iniciativa para implementar programas de vacunación, nutrición y atención médica preventiva en zonas urbanas marginadas.',
                'objetivo' => 'Vacunar al 95% de los niños menores de 5 años en 3 colonias marginadas',
                'beneficiarios' => '800 niños menores de 5 años, 200 familias',
                'presupuesto_total' => 180000.00,
                'fondos_asignados' => 150000.00,
                'fondos_ejecutados' => 90000.00,
                'fecha_inicio' => '2024-03-01',
                'fecha_fin' => '2024-12-31',
                'estado' => 'en_progreso',
                'responsable_id' => $admin?->id,
                'ubicacion' => 'Colonias marginadas de la Ciudad de México',
                'resultados_esperados' => 'Reducción de enfermedades prevenibles, mejora en el estado nutricional infantil',
                'resultados_obtenidos' => 'Se han vacunado 600 niños, se han realizado 150 consultas nutricionales',
            ],
            [
                'nombre' => 'Desarrollo Empresarial Femenino',
                'descripcion' => 'Programa de capacitación y financiamiento para mujeres emprendedoras en comunidades rurales, enfocado en microempresas sostenibles.',
                'objetivo' => 'Crear 50 microempresas lideradas por mujeres en 10 comunidades rurales',
                'beneficiarios' => '100 mujeres emprendedoras, 200 familias indirectas',
                'presupuesto_total' => 320000.00,
                'fondos_asignados' => 280000.00,
                'fondos_ejecutados' => 120000.00,
                'fecha_inicio' => '2024-02-01',
                'fecha_fin' => '2025-08-01',
                'estado' => 'en_progreso',
                'responsable_id' => $projectCoordinator?->id,
                'ubicacion' => 'Comunidades rurales de Chiapas y Guerrero',
                'resultados_esperados' => 'Empoderamiento económico femenino, generación de empleo local, desarrollo comunitario',
                'resultados_obtenidos' => 'Se han capacitado 60 mujeres, se han creado 15 microempresas',
            ],
            [
                'nombre' => 'Agua Potable y Saneamiento',
                'descripcion' => 'Instalación de sistemas de purificación de agua y construcción de letrinas ecológicas en comunidades sin acceso a servicios básicos.',
                'objetivo' => 'Proporcionar agua potable a 3 comunidades rurales (500 familias)',
                'beneficiarios' => '500 familias (2,500 personas aproximadamente)',
                'presupuesto_total' => 450000.00,
                'fondos_asignados' => 400000.00,
                'fondos_ejecutados' => 200000.00,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => '2024-12-31',
                'estado' => 'en_progreso',
                'responsable_id' => $admin?->id,
                'ubicacion' => 'Comunidades rurales de Puebla y Veracruz',
                'resultados_esperados' => 'Acceso a agua potable, reducción de enfermedades gastrointestinales, mejora en la calidad de vida',
                'resultados_obtenidos' => 'Se han instalado 2 sistemas de purificación, se han construido 50 letrinas',
            ],
            [
                'nombre' => 'Apoyo a Adultos Mayores',
                'descripcion' => 'Programa integral de atención y acompañamiento para adultos mayores en situación de vulnerabilidad, incluyendo atención médica, alimentación y actividades recreativas.',
                'objetivo' => 'Atender a 200 adultos mayores en situación de abandono o vulnerabilidad',
                'beneficiarios' => '200 adultos mayores, 100 familias cuidadoras',
                'presupuesto_total' => 150000.00,
                'fondos_asignados' => 120000.00,
                'fondos_ejecutados' => 60000.00,
                'fecha_inicio' => '2024-04-01',
                'fecha_fin' => '2025-04-01',
                'estado' => 'en_progreso',
                'responsable_id' => $projectCoordinator?->id,
                'ubicacion' => 'Centros comunitarios en zonas urbanas marginadas',
                'resultados_esperados' => 'Mejora en la calidad de vida de adultos mayores, reducción del aislamiento social',
                'resultados_obtenidos' => 'Se han atendido 80 adultos mayores, se han realizado 200 consultas médicas',
            ],
            [
                'nombre' => 'Capacitación Técnica Juvenil',
                'descripcion' => 'Programa de formación técnica en oficios demandados para jóvenes de 16 a 25 años en situación de vulnerabilidad social.',
                'objetivo' => 'Capacitar a 300 jóvenes en oficios técnicos con alta demanda laboral',
                'beneficiarios' => '300 jóvenes de 16 a 25 años',
                'presupuesto_total' => 280000.00,
                'fondos_asignados' => 250000.00,
                'fondos_ejecutados' => 0.00,
                'fecha_inicio' => '2024-09-01',
                'fecha_fin' => '2025-09-01',
                'estado' => 'planificado',
                'responsable_id' => $projectCoordinator?->id,
                'ubicacion' => 'Centros de capacitación en 5 ciudades principales',
                'resultados_esperados' => 'Inserción laboral del 70% de los capacitados, mejora en las oportunidades económicas',
                'resultados_obtenidos' => 'Proyecto en fase de planificación',
            ],
            [
                'nombre' => 'Conservación Ambiental Comunitaria',
                'descripcion' => 'Proyecto de reforestación y educación ambiental en comunidades rurales, enfocado en la conservación de ecosistemas locales.',
                'objetivo' => 'Reforestar 50 hectáreas y capacitar a 200 familias en prácticas ambientales sostenibles',
                'beneficiarios' => '200 familias rurales, 1,000 personas indirectas',
                'presupuesto_total' => 200000.00,
                'fondos_asignados' => 180000.00,
                'fondos_ejecutados' => 45000.00,
                'fecha_inicio' => '2024-06-01',
                'fecha_fin' => '2025-06-01',
                'estado' => 'en_progreso',
                'responsable_id' => $admin?->id,
                'ubicacion' => 'Reservas naturales y comunidades rurales de Michoacán',
                'resultados_esperados' => 'Restauración de ecosistemas, conciencia ambiental comunitaria, prácticas sostenibles',
                'resultados_obtenidos' => 'Se han reforestado 15 hectáreas, se han capacitado 80 familias',
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['nombre' => $project['nombre']],
                $project
            );
        }
    }
}