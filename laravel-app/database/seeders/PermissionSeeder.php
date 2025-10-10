<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Usuarios
            [
                'name' => 'Ver Usuarios',
                'slug' => 'users.view',
                'description' => 'Puede ver la lista de usuarios',
                'module' => 'users',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Usuarios',
                'slug' => 'users.create',
                'description' => 'Puede crear nuevos usuarios',
                'module' => 'users',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Usuarios',
                'slug' => 'users.edit',
                'description' => 'Puede editar información de usuarios',
                'module' => 'users',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Usuarios',
                'slug' => 'users.delete',
                'description' => 'Puede eliminar usuarios',
                'module' => 'users',
                'is_active' => true,
            ],
            [
                'name' => 'Gestionar Permisos de Usuarios',
                'slug' => 'users.permissions',
                'description' => 'Puede asignar y revocar permisos a usuarios',
                'module' => 'users',
                'is_active' => true,
            ],

            // Proyectos
            [
                'name' => 'Ver Proyectos',
                'slug' => 'projects.view',
                'description' => 'Puede ver la lista de proyectos',
                'module' => 'projects',
                'is_active' => true,
            ],
            [
                'name' => 'Ver Solo Proyectos Asignados',
                'slug' => 'projects.view.own',
                'description' => 'Puede ver solo los proyectos a los que está asignado',
                'module' => 'projects',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Proyectos',
                'slug' => 'projects.create',
                'description' => 'Puede crear nuevos proyectos',
                'module' => 'projects',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Proyectos',
                'slug' => 'projects.edit',
                'description' => 'Puede editar información de proyectos',
                'module' => 'projects',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Proyectos',
                'slug' => 'projects.delete',
                'description' => 'Puede eliminar proyectos',
                'module' => 'projects',
                'is_active' => true,
            ],

            // Beneficiarios
            [
                'name' => 'Ver Beneficiarios',
                'slug' => 'beneficiaries.view',
                'description' => 'Puede ver la lista de beneficiarios',
                'module' => 'beneficiaries',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Beneficiarios',
                'slug' => 'beneficiaries.create',
                'description' => 'Puede crear nuevos beneficiarios',
                'module' => 'beneficiaries',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Beneficiarios',
                'slug' => 'beneficiaries.edit',
                'description' => 'Puede editar información de beneficiarios',
                'module' => 'beneficiaries',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Beneficiarios',
                'slug' => 'beneficiaries.delete',
                'description' => 'Puede eliminar beneficiarios',
                'module' => 'beneficiaries',
                'is_active' => true,
            ],

            // Ubicaciones
            [
                'name' => 'Ver Ubicaciones',
                'slug' => 'locations.view',
                'description' => 'Puede ver la lista de ubicaciones',
                'module' => 'locations',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Ubicaciones',
                'slug' => 'locations.create',
                'description' => 'Puede crear nuevas ubicaciones',
                'module' => 'locations',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Ubicaciones',
                'slug' => 'locations.edit',
                'description' => 'Puede editar información de ubicaciones',
                'module' => 'locations',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Ubicaciones',
                'slug' => 'locations.delete',
                'description' => 'Puede eliminar ubicaciones',
                'module' => 'locations',
                'is_active' => true,
            ],

            // Roles y Permisos
            [
                'name' => 'Gestionar Roles',
                'slug' => 'roles.manage',
                'description' => 'Puede crear, editar y eliminar roles',
                'module' => 'roles',
                'is_active' => true,
            ],
            [
                'name' => 'Asignar Roles',
                'slug' => 'roles.assign',
                'description' => 'Puede asignar roles y permisos a usuarios',
                'module' => 'roles',
                'is_active' => true,
            ],
            [
                'name' => 'Gestionar Permisos',
                'slug' => 'permissions.manage',
                'description' => 'Puede crear, editar y eliminar permisos',
                'module' => 'roles',
                'is_active' => true,
            ],

            // Reportes
            [
                'name' => 'Ver Reportes',
                'slug' => 'reports.view',
                'description' => 'Puede ver reportes del sistema',
                'module' => 'reports',
                'is_active' => true,
            ],
            [
                'name' => 'Exportar Datos',
                'slug' => 'data.export',
                'description' => 'Puede exportar datos del sistema',
                'module' => 'reports',
                'is_active' => true,
            ],

            // Configuración
            [
                'name' => 'Gestionar Configuración',
                'slug' => 'settings.manage',
                'description' => 'Puede modificar la configuración del sistema',
                'module' => 'settings',
                'is_active' => true,
            ],

            // Permisos específicos para beneficiarios
            [
                'name' => 'Ver Perfil Propio',
                'slug' => 'profile.view.own',
                'description' => 'Puede ver solo su propio perfil',
                'module' => 'profile',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Perfil Propio',
                'slug' => 'profile.edit.own',
                'description' => 'Puede editar solo su propio perfil',
                'module' => 'profile',
                'is_active' => true,
            ],
            [
                'name' => 'Ver Beneficios Propios',
                'slug' => 'benefits.view.own',
                'description' => 'Puede ver solo sus propios beneficios',
                'module' => 'beneficiaries',
                'is_active' => true,
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}