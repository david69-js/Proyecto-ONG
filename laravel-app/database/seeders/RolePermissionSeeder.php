<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero, crear o actualizar todos los permisos
        $this->createPermissions();
        
        // Luego, asignar permisos a cada rol
        $this->assignPermissionsToRoles();
    }

    /**
     * Crear o actualizar todos los permisos del sistema
     */
    private function createPermissions(): void
    {
        $permissions = [
            // Permisos de Usuarios
            ['name' => 'Ver Usuarios', 'slug' => 'users.view', 'description' => 'Ver listado de usuarios'],
            ['name' => 'Crear Usuario', 'slug' => 'users.create', 'description' => 'Crear nuevos usuarios'],
            ['name' => 'Editar Usuario', 'slug' => 'users.edit', 'description' => 'Editar información de usuarios'],
            ['name' => 'Eliminar Usuario', 'slug' => 'users.delete', 'description' => 'Eliminar usuarios del sistema'],

            // Permisos de Proyectos
            ['name' => 'Ver Proyectos', 'slug' => 'projects.view', 'description' => 'Ver todos los proyectos'],
            ['name' => 'Ver Proyectos Propios', 'slug' => 'projects.view.own', 'description' => 'Ver solo proyectos asignados'],
            ['name' => 'Crear Proyecto', 'slug' => 'projects.create', 'description' => 'Crear nuevos proyectos'],
            ['name' => 'Editar Proyecto', 'slug' => 'projects.edit', 'description' => 'Editar proyectos'],
            ['name' => 'Eliminar Proyecto', 'slug' => 'projects.delete', 'description' => 'Eliminar proyectos'],

            // Permisos de Beneficiarios
            ['name' => 'Ver Beneficiarios', 'slug' => 'beneficiaries.view', 'description' => 'Ver todos los beneficiarios'],
            ['name' => 'Ver Beneficiarios Propios', 'slug' => 'beneficiaries.view.own', 'description' => 'Ver solo beneficiarios del proyecto asignado'],
            ['name' => 'Crear Beneficiario', 'slug' => 'beneficiaries.create', 'description' => 'Crear nuevos beneficiarios'],
            ['name' => 'Editar Beneficiario', 'slug' => 'beneficiaries.edit', 'description' => 'Editar información de beneficiarios'],
            ['name' => 'Eliminar Beneficiario', 'slug' => 'beneficiaries.delete', 'description' => 'Eliminar beneficiarios'],

            // Permisos de Ubicaciones
            ['name' => 'Ver Ubicaciones', 'slug' => 'locations.view', 'description' => 'Ver ubicaciones'],
            ['name' => 'Crear Ubicación', 'slug' => 'locations.create', 'description' => 'Crear nuevas ubicaciones'],
            ['name' => 'Editar Ubicación', 'slug' => 'locations.edit', 'description' => 'Editar ubicaciones'],
            ['name' => 'Eliminar Ubicación', 'slug' => 'locations.delete', 'description' => 'Eliminar ubicaciones'],

            // Permisos de Patrocinadores
            ['name' => 'Ver Patrocinadores', 'slug' => 'sponsors.view', 'description' => 'Ver patrocinadores'],
            ['name' => 'Crear Patrocinador', 'slug' => 'sponsors.create', 'description' => 'Crear nuevos patrocinadores'],
            ['name' => 'Editar Patrocinador', 'slug' => 'sponsors.edit', 'description' => 'Editar patrocinadores'],
            ['name' => 'Eliminar Patrocinador', 'slug' => 'sponsors.delete', 'description' => 'Eliminar patrocinadores'],

            // Permisos de Eventos
            ['name' => 'Ver Eventos', 'slug' => 'events.view', 'description' => 'Ver eventos'],
            ['name' => 'Crear Evento', 'slug' => 'events.create', 'description' => 'Crear nuevos eventos'],
            ['name' => 'Editar Evento', 'slug' => 'events.edit', 'description' => 'Editar eventos'],
            ['name' => 'Eliminar Evento', 'slug' => 'events.delete', 'description' => 'Eliminar eventos'],

            // Permisos de Donaciones
            ['name' => 'Ver Donaciones', 'slug' => 'donations.view', 'description' => 'Ver donaciones'],
            ['name' => 'Ver Solo Sus Donaciones', 'slug' => 'donations.view.own', 'description' => 'Ver solo sus propias donaciones'],
            ['name' => 'Crear Donación', 'slug' => 'donations.create', 'description' => 'Registrar nuevas donaciones'],
            ['name' => 'Editar Donación', 'slug' => 'donations.edit', 'description' => 'Editar donaciones'],
            ['name' => 'Eliminar Donación', 'slug' => 'donations.delete', 'description' => 'Eliminar donaciones'],
            ['name' => 'Confirmar Donaciones', 'slug' => 'donations.confirm', 'description' => 'Confirmar donaciones pendientes'],
            ['name' => 'Procesar Donaciones', 'slug' => 'donations.process', 'description' => 'Procesar donaciones confirmadas'],
            ['name' => 'Ver Reportes de Donaciones', 'slug' => 'donations.reports', 'description' => 'Ver reportes y estadísticas de donaciones'],
            ['name' => 'Exportar Donaciones', 'slug' => 'donations.export', 'description' => 'Exportar datos de donaciones'],

            // Permisos de Reportes
            ['name' => 'Ver Reportes', 'slug' => 'reports.view', 'description' => 'Ver reportes'],
            ['name' => 'Exportar Reportes', 'slug' => 'reports.export', 'description' => 'Exportar reportes a diferentes formatos'],
            ['name' => 'Ver Estadísticas', 'slug' => 'reports.statistics', 'description' => 'Ver estadísticas e indicadores'],

            // Permisos de Perfil
            ['name' => 'Ver Perfil Propio', 'slug' => 'profile.view.own', 'description' => 'Ver perfil personal'],
            ['name' => 'Editar Perfil Propio', 'slug' => 'profile.edit.own', 'description' => 'Editar perfil personal'],

            // Permisos de Beneficios
            ['name' => 'Ver Beneficios Propios', 'slug' => 'benefits.view.own', 'description' => 'Ver beneficios personales'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }

    /**
     * Asignar permisos a roles
     */
    private function assignPermissionsToRoles(): void
    {
        // SUPER ADMINISTRADOR - Todos los permisos
        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $allPermissions = Permission::all();
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        // ADMINISTRADOR - Todos los permisos excepto eliminar usuarios
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPermissions = Permission::whereNotIn('slug', [
                'users.delete', // No puede eliminar usuarios
            ])->get();
            $admin->permissions()->sync($adminPermissions->pluck('id'));
        }

        // COORDINADOR DE PROYECTOS
        $projectCoordinator = Role::where('slug', 'project-coordinator')->first();
        if ($projectCoordinator) {
            $projectCoordinatorPermissions = Permission::whereIn('slug', [
                // Usuarios - Solo ver
                'users.view',
                
                // Proyectos - Ver, crear, editar (propios)
                'projects.view',
                'projects.create',
                'projects.edit',
                
                // Beneficiarios - Ver, crear, editar propios
                'beneficiaries.view',
                'beneficiaries.create',
                'beneficiaries.edit',
                
                // Ubicaciones - Ver, crear, editar
                'locations.view',
                'locations.create',
                'locations.edit',
                
                // Patrocinadores - Ver, crear, editar
                'sponsors.view',
                'sponsors.create',
                'sponsors.edit',
                
                // Donaciones - Gestión completa
                'donations.view',
                'donations.create',
                'donations.edit',
                'donations.confirm',
                'donations.process',
                'donations.reports',
                'donations.export',
                
                // Reportes - Ver propios
                'reports.view',
            ])->get();
            $projectCoordinator->permissions()->sync($projectCoordinatorPermissions->pluck('id'));
        }

        // COORDINADOR DE BENEFICIARIOS
        $beneficiaryCoordinator = Role::where('slug', 'beneficiary-coordinator')->first();
        if ($beneficiaryCoordinator) {
            $beneficiaryCoordinatorPermissions = Permission::whereIn('slug', [
                
                // Proyectos - Solo ver todos
                'projects.view',
                
                // Beneficiarios - Ver, crear, editar, eliminar (todos)
                'beneficiaries.view',
                'beneficiaries.create',
                'beneficiaries.edit',
                'beneficiaries.delete',
                
                // Ubicaciones - Solo ver
                'locations.view',
                
                // Reportes - Ver
                'reports.view',
            ])->get();
            $beneficiaryCoordinator->permissions()->sync($beneficiaryCoordinatorPermissions->pluck('id'));
        }

        // VOLUNTARIO - Solo lectura limitada
        $volunteer = Role::where('slug', 'volunteer')->first();
        if ($volunteer) {
            $volunteerPermissions = Permission::whereIn('slug', [
                // Proyectos - Ver asignados
                'projects.view.own',
                
                // Beneficiarios - Ver asignados
                'beneficiaries.view.own',
                
                // Ubicaciones - Solo ver
                'locations.view',
                
                // Eventos - Solo ver
                'events.view',
                
                // Donaciones - Ver y crear básicas
                'donations.view',
                'donations.create',
            ])->get();
            $volunteer->permissions()->sync($volunteerPermissions->pluck('id'));
        }

        // CONSULTOR - Solo lectura
        $consultant = Role::where('slug', 'consultant')->first();
        if ($consultant) {
            $consultantPermissions = Permission::whereIn('slug', [
                // Usuarios - Solo ver
                'users.view',
                
                // Proyectos - Ver todos
                'projects.view',
                
                // Beneficiarios - Ver todos
                'beneficiaries.view',
                
                // Ubicaciones - Solo ver
                'locations.view',
                
                // Patrocinadores - Solo ver
                'sponsors.view',
                
                // Donaciones - Ver y reportes
                'donations.view',
                'donations.reports',
                'donations.export',
                
                // Reportes - Ver y exportar
                'reports.view',
                'reports.export',
                'reports.statistics',
            ])->get();
            $consultant->permissions()->sync($consultantPermissions->pluck('id'));
        }

        // DONANTE - Acceso muy limitado
        $donor = Role::where('slug', 'donor')->first();
        if ($donor) {
            $donorPermissions = Permission::whereIn('slug', [
                // Proyectos - Ver (donde tiene donaciones)
                'projects.view',
                
                // Patrocinadores - Ver
                'sponsors.view',
                
                // Donaciones - Ver y crear sus propias donaciones
                'donations.view.own',
                'donations.create',
                
                // Reportes - Ver y exportar
                'reports.view',
                'reports.export',
                'reports.statistics',
            ])->get();
            $donor->permissions()->sync($donorPermissions->pluck('id'));
        }

        // BENEFICIARIO - Solo acceso a datos personales
        $beneficiary = Role::where('slug', 'beneficiary')->first();
        if ($beneficiary) {
            $beneficiaryPermissions = Permission::whereIn('slug', [
                // Perfil - Ver y editar propio
                'profile.view.own',
                'profile.edit.own',
                
                // Proyectos - Ver asignado
                'projects.view.own',
                
                // Beneficios - Ver propios
                'benefits.view.own',
            ])->get();
            $beneficiary->permissions()->sync($beneficiaryPermissions->pluck('id'));
        }
    }
}