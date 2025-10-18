<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventRegistration;

class EventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::where('registration_required', true)->get();
        
        if ($events->count() == 0) {
            return;
        }

        $sampleRegistrations = [
            [
                'name' => 'María Elena González',
                'email' => 'maria.gonzalez@email.com',
                'phone' => '+502 5555-1111',
                'notes' => 'Interesada en participar en la carrera solidaria',
                'status' => 'confirmed',
            ],
            [
                'name' => 'Carlos Roberto Martínez',
                'email' => 'carlos.martinez@email.com',
                'phone' => '+502 5555-2222',
                'notes' => 'Constructor con 5 años de experiencia',
                'status' => 'confirmed',
            ],
            [
                'name' => 'Ana Patricia López',
                'email' => 'ana.lopez@email.com',
                'phone' => '+502 5555-3333',
                'notes' => 'Estudiante de arquitectura interesada en construcción sostenible',
                'status' => 'pending',
            ],
            [
                'name' => 'Roberto Carlos Silva',
                'email' => 'roberto.silva@email.com',
                'phone' => '+502 5555-4444',
                'notes' => 'Voluntario experimentado en proyectos sociales',
                'status' => 'confirmed',
            ],
            [
                'name' => 'Sofia Alejandra Ramírez',
                'email' => 'sofia.ramirez@email.com',
                'phone' => '+502 5555-5555',
                'notes' => 'Líder comunitaria de Aldea San Juan',
                'status' => 'confirmed',
            ],
            [
                'name' => 'Miguel Ángel Castillo',
                'email' => 'miguel.castillo@email.com',
                'phone' => '+502 5555-6666',
                'notes' => 'Ingeniero civil especializado en vivienda social',
                'status' => 'pending',
            ],
            [
                'name' => 'Laura Beatriz Morales',
                'email' => 'laura.morales@email.com',
                'phone' => '+502 5555-7777',
                'notes' => 'Arquitecta con interés en construcción comunitaria',
                'status' => 'confirmed',
            ],
            [
                'name' => 'José Antonio Pérez',
                'email' => 'jose.perez@email.com',
                'phone' => '+502 5555-8888',
                'notes' => 'Estudiante de ingeniería civil',
                'status' => 'pending',
            ],
            [
                'name' => 'Carmen Rosa Vásquez',
                'email' => 'carmen.vasquez@email.com',
                'phone' => '+502 5555-9999',
                'notes' => 'Voluntaria internacional con experiencia en ONGs',
                'status' => 'confirmed',
            ],
            [
                'name' => 'Diego Fernando Herrera',
                'email' => 'diego.herrera@email.com',
                'phone' => '+502 5555-0000',
                'notes' => 'Constructor local interesado en técnicas sostenibles',
                'status' => 'confirmed',
            ],
        ];

        foreach ($events as $event) {
            // Crear entre 3-8 inscripciones por evento
            $numRegistrations = rand(3, min(8, $event->max_participants));
            $selectedRegistrations = collect($sampleRegistrations)->random($numRegistrations);
            
            foreach ($selectedRegistrations as $registrationData) {
                EventRegistration::create([
                    'event_id' => $event->id,
                    'name' => $registrationData['name'],
                    'email' => $registrationData['email'],
                    'phone' => $registrationData['phone'],
                    'notes' => $registrationData['notes'],
                    'status' => $registrationData['status'],
                    'registered_at' => now()->subDays(rand(1, 30)),
                ]);
            }
            
            // Actualizar el contador de participantes actuales
            $event->update([
                'current_participants' => $event->registrations()->where('status', 'confirmed')->count()
            ]);
        }
    }
}
