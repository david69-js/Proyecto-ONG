<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Create a default super admin user if it doesn't exist
        $adminUser = User::where('email', 'admin@ong.com')->first();
        
        if (!$adminUser) {
            $adminUser = User::create([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@ong.com',
                'password' => bcrypt('password'),
                'is_active' => true,
                'is_verified' => true,
            ]);
        }
        
        // Assign super admin role if not already assigned
        if (!$adminUser->hasRole('super_admin')) {
            $adminUser->assignRole('super_admin');
        }
    }
}
