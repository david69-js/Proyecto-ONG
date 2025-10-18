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

            // Patrocinadores
            [
                'name' => 'Ver Patrocinadores',
                'slug' => 'sponsors.view',
                'description' => 'Puede ver la lista de patrocinadores',
                'module' => 'sponsors',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Patrocinadores',
                'slug' => 'sponsors.create',
                'description' => 'Puede crear nuevos patrocinadores',
                'module' => 'sponsors',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Patrocinadores',
                'slug' => 'sponsors.edit',
                'description' => 'Puede editar información de patrocinadores',
                'module' => 'sponsors',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Patrocinadores',
                'slug' => 'sponsors.delete',
                'description' => 'Puede eliminar patrocinadores',
                'module' => 'sponsors',
                'is_active' => true,
            ],

            // Donaciones
            [
                'name' => 'Ver Donaciones',
                'slug' => 'donations.view',
                'description' => 'Puede ver la lista de donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Ver Solo Sus Donaciones',
                'slug' => 'donations.view.own',
                'description' => 'Puede ver solo sus propias donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Donaciones',
                'slug' => 'donations.create',
                'description' => 'Puede crear nuevas donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Donaciones',
                'slug' => 'donations.edit',
                'description' => 'Puede editar información de donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Donaciones',
                'slug' => 'donations.delete',
                'description' => 'Puede eliminar donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Confirmar Donaciones',
                'slug' => 'donations.confirm',
                'description' => 'Puede confirmar donaciones pendientes',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Procesar Donaciones',
                'slug' => 'donations.process',
                'description' => 'Puede procesar donaciones confirmadas',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Ver Reportes de Donaciones',
                'slug' => 'donations.reports',
                'description' => 'Puede ver reportes y estadísticas de donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],
            [
                'name' => 'Exportar Donaciones',
                'slug' => 'donations.export',
                'description' => 'Puede exportar datos de donaciones',
                'module' => 'donations',
                'is_active' => true,
            ],

            // Productos
            [
                'name' => 'Ver Productos',
                'slug' => 'products.view',
                'description' => 'Puede ver la lista de productos',
                'module' => 'products',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Productos',
                'slug' => 'products.create',
                'description' => 'Puede crear nuevos productos',
                'module' => 'products',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Productos',
                'slug' => 'products.edit',
                'description' => 'Puede editar información de productos',
                'module' => 'products',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Productos',
                'slug' => 'products.delete',
                'description' => 'Puede eliminar productos',
                'module' => 'products',
                'is_active' => true,
            ],
            [
                'name' => 'Ver Catálogo Público',
                'slug' => 'products.catalog',
                'description' => 'Puede ver el catálogo público de productos',
                'module' => 'products',
                'is_active' => true,
            ],
            [
                'name' => 'Ver Estadísticas de Productos',
                'slug' => 'products.statistics',
                'description' => 'Puede ver estadísticas de productos',
                'module' => 'products',
                'is_active' => true,
            ],
            [
                'name' => 'Gestionar Inventario',
                'slug' => 'products.inventory',
                'description' => 'Puede gestionar el inventario de productos',
                'module' => 'products',
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