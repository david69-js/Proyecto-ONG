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
        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles(): void
    {
        // Super Administrador - TODOS los permisos
        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $allPermissions = Permission::all();
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        // Administrador - todos los permisos EXCEPTO gestión de roles
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPermissions = Permission::whereNotIn('slug', [
                // Excluir solo gestión de roles si existe ese permiso
            ])->get();
            $admin->permissions()->sync($adminPermissions->pluck('id'));
        }

        // Coordinador de Proyectos - permisos de proyectos, beneficiarios, ubicaciones y EVENTOS
        $projectCoordinator = Role::where('slug', 'project-coordinator')->first();
        if ($projectCoordinator) {
            $projectCoordinatorPermissions = Permission::whereIn('slug', [
                'users.view',
                'projects.view',
                'projects.create',
                'projects.edit',
                'beneficiaries.view',
                'beneficiaries.create',
                'beneficiaries.edit',
                'locations.view',
                'locations.create',
                'locations.edit',
                'sponsors.view',
                'sponsors.create',
                'sponsors.edit',
                'reports.view',
                // AGREGADOS: Permisos de eventos
                'events.view',
                'events.create',
                'events.edit',
                'events.delete',
            ])->get();
            $projectCoordinator->permissions()->sync($projectCoordinatorPermissions->pluck('id'));
        }

        // Coordinador de Beneficiarios - permisos de beneficiarios y EVENTOS (lectura)
        $beneficiaryCoordinator = Role::where('slug', 'beneficiary-coordinator')->first();
        if ($beneficiaryCoordinator) {
            $beneficiaryCoordinatorPermissions = Permission::whereIn('slug', [
                'users.view',
                'projects.view',
                'beneficiaries.view',
                'beneficiaries.create',
                'beneficiaries.edit',
                'beneficiaries.delete',
                'locations.view',
                'reports.view',
                // AGREGADOS: Permisos de eventos (lectura)
                'events.view',
            ])->get();
            $beneficiaryCoordinator->permissions()->sync($beneficiaryCoordinatorPermissions->pluck('id'));
        }

        // Voluntario - permisos básicos de solo lectura + EVENTOS
        $volunteer = Role::where('slug', 'volunteer')->first();
        if ($volunteer) {
            $volunteerPermissions = Permission::whereIn('slug', [
                'projects.view',
                'beneficiaries.view',
                'locations.view',
                'sponsors.view',
                // AGREGADOS: Permisos de eventos (lectura)
                'events.view',
            ])->get();
            $volunteer->permissions()->sync($volunteerPermissions->pluck('id'));
        }

        // Consultor - permisos de solo lectura + EVENTOS
        $consultant = Role::where('slug', 'consultant')->first();
        if ($consultant) {
            $consultantPermissions = Permission::whereIn('slug', [
                'users.view',
                'projects.view',
                'beneficiaries.view',
                'locations.view',
                'sponsors.view',
                'reports.view',
                // AGREGADOS: Permisos de eventos (lectura)
                'events.view',
            ])->get();
            $consultant->permissions()->sync($consultantPermissions->pluck('id'));
        }

        // Donante - permisos muy limitados + EVENTOS
        $donor = Role::where('slug', 'donor')->first();
        if ($donor) {
            $donorPermissions = Permission::whereIn('slug', [
                'projects.view',
                'sponsors.view',
                'reports.view',
                // AGREGADOS: Permisos de eventos (lectura)
                'events.view',
            ])->get();
            $donor->permissions()->sync($donorPermissions->pluck('id'));
        }

        // Beneficiario - solo acceso a sus propios datos
        $beneficiary = Role::where('slug', 'beneficiary')->first();
        if ($beneficiary) {
            $beneficiaryPermissions = Permission::whereIn('slug', [
                'profile.view.own',
                'profile.edit.own',
                'projects.view.own',
                'benefits.view.own',
                // AGREGADOS: Permisos de eventos (lectura)
                'events.view',
            ])->get();
            $beneficiary->permissions()->sync($beneficiaryPermissions->pluck('id'));
        }
    }
}