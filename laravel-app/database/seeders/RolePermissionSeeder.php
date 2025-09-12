<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles only if they don't exist
        if (DB::table('cfg_roles')->count() == 0) {
            $roles = [
            [
                'name' => 'Super Administrator',
                'slug' => 'super_admin',
                'description' => 'Full system access with all permissions',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Administrative access to most system features',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coordinator',
                'slug' => 'coordinator',
                'description' => 'Can manage volunteers and coordinate activities',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Volunteer',
                'slug' => 'volunteer',
                'description' => 'Basic volunteer access to participate in activities',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ];

            DB::table('cfg_roles')->insert($roles);
        }

        // Create permissions only if they don't exist
        if (DB::table('cfg_permissions')->count() == 0) {
            $permissions = [
            // User Management
            ['name' => 'View Users', 'slug' => 'users.view', 'description' => 'View user list and details', 'module' => 'users', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Create Users', 'slug' => 'users.create', 'description' => 'Create new users', 'module' => 'users', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edit Users', 'slug' => 'users.edit', 'description' => 'Edit existing users', 'module' => 'users', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'description' => 'Delete users', 'module' => 'users', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Role Management
            ['name' => 'View Roles', 'slug' => 'roles.view', 'description' => 'View roles and permissions', 'module' => 'roles', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'description' => 'Create, edit and delete roles', 'module' => 'roles', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Activities/Projects
            ['name' => 'View Activities', 'slug' => 'activities.view', 'description' => 'View activities and projects', 'module' => 'activities', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Create Activities', 'slug' => 'activities.create', 'description' => 'Create new activities', 'module' => 'activities', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Edit Activities', 'slug' => 'activities.edit', 'description' => 'Edit existing activities', 'module' => 'activities', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Delete Activities', 'slug' => 'activities.delete', 'description' => 'Delete activities', 'module' => 'activities', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'description' => 'View system reports', 'module' => 'reports', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Export Reports', 'slug' => 'reports.export', 'description' => 'Export reports to various formats', 'module' => 'reports', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ];

            DB::table('cfg_permissions')->insert($permissions);
        }

        // Assign permissions to roles only if not already assigned
        if (DB::table('rel_role_permissions')->count() == 0) {
            $rolePermissions = [
            // Super Admin gets all permissions
            ['role_id' => 1, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Admin gets most permissions except super admin specific ones
            ['role_id' => 2, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Coordinator gets limited permissions
            ['role_id' => 3, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            
            // Volunteer gets basic permissions
            ['role_id' => 4, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 4, 'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ];

            DB::table('rel_role_permissions')->insert($rolePermissions);
        }
    }
}
