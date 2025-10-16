<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en el orden correcto
        $this->call([
            // 1. Primero crear roles y permisos
            RoleSeeder::class,
            PermissionSeeder::class,
            $this->call(CreatePermissionsSeeder::class);
            
            // 2. Luego asignar permisos a roles
            RolePermissionSeeder::class,
            
            // 3. Crear usuarios con sus perfiles
            UserSeeder::class,
            
            // 4. Crear ubicaciones
            LocationSeeder::class,
            
            // 5. Crear proyectos
            ProjectSeeder::class,
            
            // 6. Crear patrocinadores
            SponsorSeeder::class,
            
            // 7. Crear eventos
            EventSeeder::class,
            
            // 8. Crear inscripciones de eventos
            EventRegistrationSeeder::class,
            
            // 9. Finalmente crear beneficiarios
            BeneficiarySeeder::class,
            $this->call(AssignBeneficiaryPermissionsSeeder::class);
        ]);
    }
}
