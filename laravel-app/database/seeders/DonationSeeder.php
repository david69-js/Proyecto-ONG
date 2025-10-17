<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use App\Models\Sponsor;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos proyectos y usuarios para las donaciones
        $projects = Project::take(3)->get();
        $users = User::take(5)->get();
        $sponsors = Sponsor::take(3)->get();

        $donations = [
            // Donaciones monetarias
            [
                'donation_type' => 'monetary',
                'amount' => 500.00,
                'currency' => 'USD',
                'description' => 'Donación para el proyecto de construcción de viviendas',
                'donor_name' => 'María González',
                'donor_email' => 'maria.gonzalez@email.com',
                'donor_phone' => '+1234567890',
                'donor_address' => '123 Main St, Ciudad',
                'donor_type' => 'individual',
                'is_anonymous' => false,
                'user_id' => $users->random()->id,
                'project_id' => $projects->random()->id,
                'payment_method' => 'transfer',
                'payment_reference' => 'TXN-001234',
                'status' => 'processed',
                'confirmed_at' => now()->subDays(5),
                'processed_at' => now()->subDays(3),
                'is_tax_deductible' => true,
                'tax_receipt_number' => 'TR-2024-001',
            ],
            [
                'donation_type' => 'monetary',
                'amount' => 1000.00,
                'currency' => 'USD',
                'description' => 'Aporte para programa de educación',
                'donor_name' => 'Corporación ABC',
                'donor_email' => 'donaciones@abc.com',
                'donor_phone' => '+1234567891',
                'donor_address' => '456 Business Ave, Ciudad',
                'donor_type' => 'corporate',
                'is_anonymous' => false,
                'project_id' => $projects->random()->id,
                'sponsor_id' => $sponsors->random()->id,
                'payment_method' => 'check',
                'payment_reference' => 'CHK-789012',
                'status' => 'confirmed',
                'confirmed_at' => now()->subDays(2),
                'is_tax_deductible' => true,
            ],
            [
                'donation_type' => 'monetary',
                'amount' => 250.00,
                'currency' => 'USD',
                'description' => 'Donación anónima para ayuda alimentaria',
                'donor_name' => 'Donante Anónimo',
                'donor_email' => null,
                'donor_phone' => null,
                'donor_address' => null,
                'donor_type' => 'individual',
                'is_anonymous' => true,
                'project_id' => $projects->random()->id,
                'payment_method' => 'cash',
                'status' => 'pending',
                'is_tax_deductible' => false,
            ],
            // Donación en materiales
            [
                'donation_type' => 'materials',
                'amount' => null,
                'currency' => 'USD',
                'description' => 'Materiales de construcción: 50 sacos de cemento, 100 ladrillos',
                'donor_name' => 'Constructora XYZ',
                'donor_email' => 'donaciones@xyz.com',
                'donor_phone' => '+1234567892',
                'donor_address' => '789 Construction St, Ciudad',
                'donor_type' => 'corporate',
                'is_anonymous' => false,
                'project_id' => $projects->random()->id,
                'payment_method' => 'kind',
                'status' => 'processed',
                'confirmed_at' => now()->subDays(7),
                'processed_at' => now()->subDays(5),
                'is_tax_deductible' => true,
                'tax_receipt_number' => 'TR-2024-002',
            ],
            // Donación de servicios
            [
                'donation_type' => 'services',
                'amount' => null,
                'currency' => 'USD',
                'description' => 'Servicios de consultoría legal por 20 horas',
                'donor_name' => 'Bufete Legal DEF',
                'donor_email' => 'pro-bono@def.com',
                'donor_phone' => '+1234567893',
                'donor_address' => '321 Legal Plaza, Ciudad',
                'donor_type' => 'corporate',
                'is_anonymous' => false,
                'project_id' => $projects->random()->id,
                'payment_method' => 'kind',
                'status' => 'confirmed',
                'confirmed_at' => now()->subDays(1),
                'is_tax_deductible' => true,
            ],
            // Donación de voluntariado
            [
                'donation_type' => 'volunteer',
                'amount' => null,
                'currency' => 'USD',
                'description' => 'Voluntariado en actividades de limpieza y mantenimiento',
                'donor_name' => 'Grupo de Voluntarios Comunitarios',
                'donor_email' => 'voluntarios@comunidad.com',
                'donor_phone' => '+1234567894',
                'donor_address' => '654 Community Center, Ciudad',
                'donor_type' => 'ngo',
                'is_anonymous' => false,
                'user_id' => $users->random()->id,
                'project_id' => $projects->random()->id,
                'payment_method' => 'kind',
                'status' => 'processed',
                'confirmed_at' => now()->subDays(10),
                'processed_at' => now()->subDays(8),
                'is_tax_deductible' => false,
            ],
            // Donación mixta
            [
                'donation_type' => 'mixed',
                'amount' => 750.00,
                'currency' => 'USD',
                'description' => 'Donación mixta: $500 en efectivo + materiales escolares',
                'donor_name' => 'Fundación Educativa GHI',
                'donor_email' => 'donaciones@ghi.org',
                'donor_phone' => '+1234567895',
                'donor_address' => '987 Education Blvd, Ciudad',
                'donor_type' => 'foundation',
                'is_anonymous' => false,
                'project_id' => $projects->random()->id,
                'sponsor_id' => $sponsors->random()->id,
                'payment_method' => 'transfer',
                'payment_reference' => 'TXN-002345',
                'status' => 'pending',
                'is_tax_deductible' => true,
            ],
            // Donación gubernamental
            [
                'donation_type' => 'monetary',
                'amount' => 5000.00,
                'currency' => 'USD',
                'description' => 'Subsidio gubernamental para programa de salud',
                'donor_name' => 'Ministerio de Salud Pública',
                'donor_email' => 'subsidios@salud.gob',
                'donor_phone' => '+1234567896',
                'donor_address' => '555 Government Building, Ciudad',
                'donor_type' => 'government',
                'is_anonymous' => false,
                'project_id' => $projects->random()->id,
                'payment_method' => 'transfer',
                'payment_reference' => 'GOV-2024-001',
                'status' => 'processed',
                'confirmed_at' => now()->subDays(15),
                'processed_at' => now()->subDays(12),
                'is_tax_deductible' => false,
            ],
            // Donación rechazada
            [
                'donation_type' => 'monetary',
                'amount' => 100.00,
                'currency' => 'USD',
                'description' => 'Donación con información incompleta',
                'donor_name' => 'Juan Pérez',
                'donor_email' => 'juan@email.com',
                'donor_phone' => '+1234567897',
                'donor_type' => 'individual',
                'is_anonymous' => false,
                'payment_method' => 'transfer',
                'status' => 'rejected',
                'status_notes' => 'Información del donante incompleta, no se pudo verificar identidad',
                'is_tax_deductible' => false,
            ],
            // Donación cancelada
            [
                'donation_type' => 'monetary',
                'amount' => 300.00,
                'currency' => 'USD',
                'description' => 'Donación cancelada por el donante',
                'donor_name' => 'Ana López',
                'donor_email' => 'ana@email.com',
                'donor_phone' => '+1234567898',
                'donor_type' => 'individual',
                'is_anonymous' => false,
                'user_id' => $users->random()->id,
                'payment_method' => 'transfer',
                'status' => 'cancelled',
                'status_notes' => 'Cancelada por solicitud del donante',
                'is_tax_deductible' => false,
            ],
        ];

        foreach ($donations as $donationData) {
            // Asignar usuarios para confirmación y procesamiento si aplica
            if ($donationData['status'] === 'confirmed' || $donationData['status'] === 'processed') {
                $donationData['confirmed_by'] = $users->random()->id;
            }
            
            if ($donationData['status'] === 'processed') {
                $donationData['processed_by'] = $users->random()->id;
            }

            // Asignar usuario creador
            $donationData['created_by'] = $users->random()->id;
            $donationData['updated_by'] = $users->random()->id;

            Donation::create($donationData);
        }

        $this->command->info('Donaciones de prueba creadas exitosamente.');
    }
}
