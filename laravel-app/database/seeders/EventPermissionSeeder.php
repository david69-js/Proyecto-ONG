<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class EventPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos para eventos
        $permissions = [
            [
                'name' => 'Ver Eventos',
                'slug' => 'events.view',
                'description' => 'Puede ver la lista de eventos',
                'module' => 'events',
                'is_active' => true,
            ],
            [
                'name' => 'Crear Eventos',
                'slug' => 'events.create',
                'description' => 'Puede crear nuevos eventos',
                'module' => 'events',
                'is_active' => true,
            ],
            [
                'name' => 'Editar Eventos',
                'slug' => 'events.edit',
                'description' => 'Puede editar eventos existentes',
                'module' => 'events',
                'is_active' => true,
            ],
            [
                'name' => 'Eliminar Eventos',
                'slug' => 'events.delete',
                'description' => 'Puede eliminar eventos',
                'module' => 'events',
                'is_active' => true,
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Asignar permisos a roles administrativos
        $adminRoles = ['Super Administrador', 'Administrador', 'Coordinador de Proyectos'];

        foreach ($adminRoles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->permissions()->syncWithoutDetaching(
                    Permission::whereIn('slug', ['events.view', 'events.create', 'events.edit', 'events.delete'])->pluck('id')
                );
            }
        }

        // Asignar permisos específicos a otros roles
        $volunteerRole = Role::where('name', 'Voluntario')->first();
        if ($volunteerRole) {
            $volunteerRole->permissions()->syncWithoutDetaching(
                Permission::where('slug', 'events.view')->pluck('id')
            );
        }

        $donorRole = Role::where('name', 'Donante')->first();
        if ($donorRole) {
            $donorRole->permissions()->syncWithoutDetaching(
                Permission::where('slug', 'events.view')->pluck('id')
            );
        }

        $consultantRole = Role::where('name', 'Consultor')->first();
        if ($consultantRole) {
            $consultantRole->permissions()->syncWithoutDetaching(
                Permission::where('slug', 'events.view')->pluck('id')
            );
        }
    }
}
