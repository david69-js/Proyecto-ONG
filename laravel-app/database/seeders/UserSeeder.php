<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Super Administrador
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@ong.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Administrador',
                'email' => 'admin@ong.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567890',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        // Crear perfil para Super Admin
        UserProfile::updateOrCreate(
            ['user_id' => $superAdmin->id],
            [
                'date_of_birth' => '1985-01-15',
                'gender' => 'male',
                'bio' => 'Super administrador del sistema de gestión de ONG',
                'address' => 'Calle Principal 123',
                'city' => 'Ciudad Capital',
                'state' => 'Estado Principal',
                'postal_code' => '12345',
                'country' => 'México',
                'emergency_contact_name' => 'María González',
                'emergency_contact_phone' => '+1234567891',
                'emergency_contact_relationship' => 'Esposa',
            ]
        );

        // Asignar rol de Super Admin
        $superAdminRole = Role::where('slug', 'system-admin')->first();
        if ($superAdminRole) {
            $superAdmin->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }

        // Crear Administrador
        $admin = User::updateOrCreate(
            ['email' => 'coordinador@ong.com'],
            [
                'first_name' => 'María',
                'last_name' => 'González',
                'email' => 'coordinador@ong.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567892',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'date_of_birth' => '1988-05-20',
                'gender' => 'female',
                'bio' => 'Coordinadora general de proyectos',
                'address' => 'Avenida Central 456',
                'city' => 'Ciudad Capital',
                'state' => 'Estado Principal',
                'postal_code' => '12346',
                'country' => 'México',
            ]
        );

        $adminRole = Role::where('slug', 'project-coordinator')->first();
        if ($adminRole) {
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        // Crear Coordinador de Proyectos
        $projectCoordinator = User::updateOrCreate(
            ['email' => 'proyectos@ong.com'],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Rodríguez',
                'email' => 'proyectos@ong.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567893',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::updateOrCreate(
            ['user_id' => $projectCoordinator->id],
            [
                'date_of_birth' => '1990-08-10',
                'gender' => 'male',
                'bio' => 'Coordinador especializado en gestión de proyectos sociales',
                'address' => 'Calle Secundaria 789',
                'city' => 'Ciudad Capital',
                'state' => 'Estado Principal',
                'postal_code' => '12347',
                'country' => 'México',
            ]
        );

        $projectCoordinatorRole = Role::where('slug', 'project-coordinator')->first();
        if ($projectCoordinatorRole) {
            $projectCoordinator->roles()->syncWithoutDetaching([$projectCoordinatorRole->id]);
        }

        // Crear Coordinador de Beneficiarios
        $beneficiaryCoordinator = User::updateOrCreate(
            ['email' => 'beneficiarios@ong.com'],
            [
                'first_name' => 'Ana',
                'last_name' => 'Martínez',
                'email' => 'beneficiarios@ong.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567894',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::updateOrCreate(
            ['user_id' => $beneficiaryCoordinator->id],
            [
                'date_of_birth' => '1992-03-25',
                'gender' => 'female',
                'bio' => 'Especialista en gestión de beneficiarios y atención social',
                'address' => 'Plaza Mayor 321',
                'city' => 'Ciudad Capital',
                'state' => 'Estado Principal',
                'postal_code' => '12348',
                'country' => 'México',
            ]
        );

        $beneficiaryCoordinatorRole = Role::where('slug', 'beneficiary-coordinator')->first();
        if ($beneficiaryCoordinatorRole) {
            $beneficiaryCoordinator->roles()->syncWithoutDetaching([$beneficiaryCoordinatorRole->id]);
        }

        // Crear Voluntario
        $volunteer = User::updateOrCreate(
            ['email' => 'voluntario@ong.com'],
            [
                'first_name' => 'Luis',
                'last_name' => 'Hernández',
                'email' => 'voluntario@ong.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567895',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::updateOrCreate(
            ['user_id' => $volunteer->id],
            [
                'date_of_birth' => '1995-11-12',
                'gender' => 'male',
                'bio' => 'Voluntario comprometido con la causa social',
                'address' => 'Calle Voluntarios 654',
                'city' => 'Ciudad Capital',
                'state' => 'Estado Principal',
                'postal_code' => '12349',
                'country' => 'México',
            ]
        );

        $volunteerRole = Role::where('slug', 'volunteer')->first();
        if ($volunteerRole) {
            $volunteer->roles()->syncWithoutDetaching([$volunteerRole->id]);
        }

        // Crear Consultor
        $consultant = User::updateOrCreate(
            ['email' => 'consultor@ong.com'],
            [
                'first_name' => 'Dr. Patricia',
                'last_name' => 'Silva',
                'email' => 'consultor@ong.com',
                'password' => Hash::make('password123'),
                'phone' => '+1234567896',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::updateOrCreate(
            ['user_id' => $consultant->id],
            [
                'date_of_birth' => '1980-07-30',
                'gender' => 'female',
                'bio' => 'Consultora externa especializada en desarrollo social',
                'address' => 'Torre Consultores 987',
                'city' => 'Ciudad Capital',
                'state' => 'Estado Principal',
                'postal_code' => '12350',
                'country' => 'México',
            ]
        );

        $consultantRole = Role::where('slug', 'consultant')->first();
        if ($consultantRole) {
            $consultant->roles()->syncWithoutDetaching([$consultantRole->id]);
        }
    }
}