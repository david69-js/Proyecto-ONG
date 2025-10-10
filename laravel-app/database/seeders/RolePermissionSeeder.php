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
        // Asignar permisos a roles usando los modelos
        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles(): void
    {
        // Super Administrador - todos los permisos
        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $allPermissions = Permission::all();
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        // Administrador - permisos amplios excepto gestión de roles
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPermissions = Permission::whereNotIn('slug', [
                'roles.manage',
                'roles.assign',
                'permissions.manage',
                'settings.manage'
            ])->get();
            $admin->permissions()->sync($adminPermissions->pluck('id'));
        }

        // Coordinador de Proyectos - permisos relacionados con proyectos y usuarios
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
                'reports.view',
            ])->get();
            $projectCoordinator->permissions()->sync($projectCoordinatorPermissions->pluck('id'));
        }

        // Coordinador de Beneficiarios - permisos relacionados con beneficiarios
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
            ])->get();
            $beneficiaryCoordinator->permissions()->sync($beneficiaryCoordinatorPermissions->pluck('id'));
        }

        // Voluntario - permisos básicos de solo lectura
        $volunteer = Role::where('slug', 'volunteer')->first();
        if ($volunteer) {
            $volunteerPermissions = Permission::whereIn('slug', [
                'users.view',
                'projects.view',
                'beneficiaries.view',
                'locations.view',
            ])->get();
            $volunteer->permissions()->sync($volunteerPermissions->pluck('id'));
        }

        // Consultor - permisos de solo lectura
        $consultant = Role::where('slug', 'consultant')->first();
        if ($consultant) {
            $consultantPermissions = Permission::whereIn('slug', [
                'users.view',
                'projects.view',
                'beneficiaries.view',
                'locations.view',
                'reports.view',
            ])->get();
            $consultant->permissions()->sync($consultantPermissions->pluck('id'));
        }

        // Donante - permisos muy limitados
        $donor = Role::where('slug', 'donor')->first();
        if ($donor) {
            $donorPermissions = Permission::whereIn('slug', [
                'projects.view',
                'reports.view',
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
            ])->get();
            $beneficiary->permissions()->sync($beneficiaryPermissions->pluck('id'));
        }
    }
}
