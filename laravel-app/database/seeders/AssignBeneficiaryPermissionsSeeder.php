<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class AssignBeneficiaryPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch the 'beneficiary' role
        $role = Role::where('slug', 'beneficiary')->first();

        if (!$role) {
            $this->command->error("Role 'beneficiary' not found.");
            return;
        }

        // Define the permissions to assign
        $permissions = ['view-assigned-projects', 'view-profile'];

        foreach ($permissions as $permissionSlug) {
            $permission = Permission::where('slug', $permissionSlug)->first();

            if ($permission) {
                // Attach the permission to the role
                $role->permissions()->syncWithoutDetaching($permission->id);
                $this->command->info("Permission '{$permissionSlug}' assigned to 'beneficiary' role.");
            } else {
                $this->command->warn("Permission '{$permissionSlug}' not found.");
            }
        }
    }
}