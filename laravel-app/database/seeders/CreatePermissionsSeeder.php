<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class CreatePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'View Assigned Projects',
                'slug' => 'view-assigned-projects',
                'description' => 'Allows viewing of assigned projects.',
            ],
            [
                'name' => 'View Profile',
                'slug' => 'view-profile',
                'description' => 'Allows viewing of user profile.',
            ],
        ];

        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                ['slug' => $permissionData['slug']],
                $permissionData
            );
        }

        $this->command->info('Permissions created successfully.');
    }
}