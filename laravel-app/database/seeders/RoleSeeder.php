<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Administrador',
                'slug' => 'super-admin',
                'description' => 'Acceso completo al sistema, puede gestionar todo',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'Administrador del sistema con permisos amplios',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Coordinador de Proyectos',
                'slug' => 'project-coordinator',
                'description' => 'Coordina y supervisa proyectos específicos',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Coordinador de Beneficiarios',
                'slug' => 'beneficiary-coordinator',
                'description' => 'Gestiona la información de beneficiarios',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Voluntario',
                'slug' => 'volunteer',
                'description' => 'Voluntario con acceso limitado al sistema',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Consultor',
                'slug' => 'consultant',
                'description' => 'Consultor externo con acceso de solo lectura',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Donante',
                'slug' => 'donor',
                'description' => 'Donante con acceso limitado a reportes',
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}