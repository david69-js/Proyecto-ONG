<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beneficiary;
use App\Models\Project;

class BeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener proyectos para asignar beneficiarios
        $educacionProject = Project::where('nombre', 'Educación Comunitaria Rural')->first();
        $saludProject = Project::where('nombre', 'Salud Preventiva Infantil')->first();
        $desarrolloProject = Project::where('nombre', 'Desarrollo Empresarial Femenino')->first();
        $aguaProject = Project::where('nombre', 'Agua Potable y Saneamiento')->first();
        $adultosProject = Project::where('nombre', 'Apoyo a Adultos Mayores')->first();

        $beneficiaries = [
            // Beneficiarios del proyecto de Educación
            [
                'name' => 'María Elena González',
                'birth_date' => '2010-03-15',
                'gender' => 'Female',
                'address' => 'Calle Principal 123, Colonia Centro',
                'phone' => '+52 951 123 4567',
                'email' => 'maria.gonzalez@email.com',
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $educacionProject?->id,
                'notes' => 'Estudiante destacada, necesita apoyo con materiales escolares',
            ],
            [
                'name' => 'Carlos Alberto Ruiz',
                'birth_date' => '2009-07-22',
                'gender' => 'Male',
                'address' => 'Carretera Federal 190, Km 45',
                'phone' => '+52 951 234 5678',
                'email' => null,
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $educacionProject?->id,
                'notes' => 'Hijo de familia campesina, muy motivado para estudiar',
            ],
            [
                'name' => 'Familia Hernández',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Ejido El Progreso, Comunidad Rural',
                'phone' => '+52 951 345 6789',
                'email' => null,
                'beneficiary_type' => 'Family',
                'status' => 'Active',
                'project_id' => $educacionProject?->id,
                'notes' => 'Familia de 5 miembros, 3 niños en edad escolar',
            ],

            // Beneficiarios del proyecto de Salud
            [
                'name' => 'Sofía Isabel Morales',
                'birth_date' => '2020-11-08',
                'gender' => 'Female',
                'address' => 'Avenida Revolución 456, Colonia Popular',
                'phone' => '+52 55 1234 5678',
                'email' => null,
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $saludProject?->id,
                'notes' => 'Bebé de 3 años, necesita vacunación completa',
            ],
            [
                'name' => 'Diego Alejandro Torres',
                'birth_date' => '2019-05-12',
                'gender' => 'Male',
                'address' => 'Calle Secundaria 789, Colonia Popular',
                'phone' => '+52 55 2345 6789',
                'email' => null,
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $saludProject?->id,
                'notes' => 'Niño con desnutrición leve, en seguimiento nutricional',
            ],
            [
                'name' => 'Comunidad San Rafael',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Colonia San Rafael, Zona Marginada',
                'phone' => '+52 55 3456 7890',
                'email' => null,
                'beneficiary_type' => 'Community',
                'status' => 'Active',
                'project_id' => $saludProject?->id,
                'notes' => 'Comunidad de 200 familias, alta incidencia de enfermedades prevenibles',
            ],

            // Beneficiarios del proyecto de Desarrollo Empresarial
            [
                'name' => 'Rosa María López',
                'birth_date' => '1985-09-18',
                'gender' => 'Female',
                'address' => 'Plaza del Mercado 147, Zona Centro',
                'phone' => '+52 744 123 4567',
                'email' => 'rosa.lopez@email.com',
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $desarrolloProject?->id,
                'notes' => 'Emprendedora, quiere iniciar negocio de artesanías',
            ],
            [
                'name' => 'Carmen Elena Vásquez',
                'birth_date' => '1988-12-03',
                'gender' => 'Female',
                'address' => 'Calle del Trabajo 258, Colonia Obrera',
                'phone' => '+52 744 234 5678',
                'email' => 'carmen.vasquez@email.com',
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $desarrolloProject?->id,
                'notes' => 'Madre soltera, interesada en microempresa de alimentos',
            ],
            [
                'name' => 'Grupo de Mujeres Emprendedoras',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Comunidad Rural "Nueva Esperanza"',
                'phone' => '+52 744 345 6789',
                'email' => null,
                'beneficiary_type' => 'Community',
                'status' => 'Active',
                'project_id' => $desarrolloProject?->id,
                'notes' => 'Grupo de 15 mujeres, quieren crear cooperativa de textiles',
            ],

            // Beneficiarios del proyecto de Agua Potable
            [
                'name' => 'Comunidad El Progreso',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Ejido El Progreso, Zona Rural',
                'phone' => '+52 222 123 4567',
                'email' => null,
                'beneficiary_type' => 'Community',
                'status' => 'Active',
                'project_id' => $aguaProject?->id,
                'notes' => 'Comunidad de 150 familias sin acceso a agua potable',
            ],
            [
                'name' => 'Familias de San Miguel',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Ejido San Miguel, Zona Rural',
                'phone' => '+52 222 234 5678',
                'email' => null,
                'beneficiary_type' => 'Family',
                'status' => 'Active',
                'project_id' => $aguaProject?->id,
                'notes' => 'Grupo de 80 familias, alta incidencia de enfermedades gastrointestinales',
            ],

            // Beneficiarios del proyecto de Adultos Mayores
            [
                'name' => 'Don José María Hernández',
                'birth_date' => '1945-04-20',
                'gender' => 'Male',
                'address' => 'Calle Independencia 987, Colonia Libertad',
                'phone' => '+52 33 123 4567',
                'email' => null,
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $adultosProject?->id,
                'notes' => 'Adulto mayor de 78 años, viudo, necesita atención médica regular',
            ],
            [
                'name' => 'Doña Carmen Silva',
                'birth_date' => '1950-08-15',
                'gender' => 'Female',
                'address' => 'Avenida de la Salud 369, Colonia San Rafael',
                'phone' => '+52 33 234 5678',
                'email' => null,
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => $adultosProject?->id,
                'notes' => 'Señora de 73 años, con diabetes, necesita apoyo nutricional',
            ],
            [
                'name' => 'Centro de Día para Adultos Mayores',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Calle de las Artes 741, Barrio Histórico',
                'phone' => '+52 33 345 6789',
                'email' => null,
                'beneficiary_type' => 'Community',
                'status' => 'Active',
                'project_id' => $adultosProject?->id,
                'notes' => 'Centro que atiende a 50 adultos mayores diariamente',
            ],

            // Beneficiarios adicionales sin proyecto específico
            [
                'name' => 'Ana Patricia Morales',
                'birth_date' => '1995-01-10',
                'gender' => 'Female',
                'address' => 'Calle 5 de Mayo 321, Centro Histórico',
                'phone' => '+52 443 123 4567',
                'email' => 'ana.morales@email.com',
                'beneficiary_type' => 'Person',
                'status' => 'Active',
                'project_id' => null,
                'notes' => 'Joven en situación de vulnerabilidad, busca oportunidades de capacitación',
            ],
            [
                'name' => 'Comunidad Indígena "Nueva Esperanza"',
                'birth_date' => null,
                'gender' => null,
                'address' => 'Camino Vecinal s/n, Comunidad Indígena',
                'phone' => '+52 967 123 4567',
                'email' => null,
                'beneficiary_type' => 'Community',
                'status' => 'Active',
                'project_id' => null,
                'notes' => 'Comunidad indígena de 300 personas, necesita apoyo integral',
            ],
        ];

        foreach ($beneficiaries as $beneficiary) {
            Beneficiary::updateOrCreate(
                [
                    'name' => $beneficiary['name'],
                    'project_id' => $beneficiary['project_id'],
                ],
                $beneficiary
            );
        }
    }
}