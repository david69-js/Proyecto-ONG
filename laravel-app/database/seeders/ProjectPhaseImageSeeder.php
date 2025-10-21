<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectPhaseImage;
use Illuminate\Support\Facades\Storage;

class ProjectPhaseImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener proyectos existentes
        $projects = Project::all();

        // Imágenes de ejemplo para diferentes fases
        $sampleImages = [
            'diagnostico' => [
                [
                    'path' => 'projects/phase-images/diagnostico-1.jpg',
                    'description' => 'Reunión inicial con la comunidad para identificar necesidades'
                ],
                [
                    'path' => 'projects/phase-images/diagnostico-2.jpg', 
                    'description' => 'Encuestas realizadas a los beneficiarios'
                ]
            ],
            'formulacion' => [
                [
                    'path' => 'projects/phase-images/formulacion-1.jpg',
                    'description' => 'Diseño de la propuesta del proyecto'
                ],
                [
                    'path' => 'projects/phase-images/formulacion-2.jpg',
                    'description' => 'Planificación de actividades y cronograma'
                ]
            ],
            'financiacion' => [
                [
                    'path' => 'projects/phase-images/financiacion-1.jpg',
                    'description' => 'Presentación a donantes y patrocinadores'
                ],
                [
                    'path' => 'projects/phase-images/financiacion-2.jpg',
                    'description' => 'Firma de convenios de financiamiento'
                ]
            ],
            'ejecucion' => [
                [
                    'path' => 'projects/phase-images/ejecucion-1.jpg',
                    'description' => 'Implementación de actividades del proyecto'
                ],
                [
                    'path' => 'projects/phase-images/ejecucion-2.jpg',
                    'description' => 'Trabajo en campo con la comunidad'
                ],
                [
                    'path' => 'projects/phase-images/ejecucion-3.jpg',
                    'description' => 'Capacitaciones y talleres realizados'
                ]
            ],
            'evaluacion' => [
                [
                    'path' => 'projects/phase-images/evaluacion-1.jpg',
                    'description' => 'Medición de resultados e indicadores'
                ],
                [
                    'path' => 'projects/phase-images/evaluacion-2.jpg',
                    'description' => 'Entrevistas con beneficiarios para evaluación'
                ]
            ],
            'cierre' => [
                [
                    'path' => 'projects/phase-images/cierre-1.jpg',
                    'description' => 'Ceremonia de cierre del proyecto'
                ],
                [
                    'path' => 'projects/phase-images/cierre-2.jpg',
                    'description' => 'Entrega de resultados finales a la comunidad'
                ],
                [
                    'path' => 'projects/phase-images/cierre-3.jpg',
                    'description' => 'Documentación de lecciones aprendidas'
                ]
            ]
        ];

        foreach ($projects as $project) {
            // Crear imágenes para múltiples fases de cada proyecto
            $phasesToCreate = [];
            
            // Determinar qué fases crear basado en la fase actual del proyecto
            switch ($project->fase) {
                case 'diagnostico':
                    $phasesToCreate = ['diagnostico'];
                    break;
                case 'formulacion':
                    $phasesToCreate = ['diagnostico', 'formulacion'];
                    break;
                case 'financiacion':
                    $phasesToCreate = ['diagnostico', 'formulacion', 'financiacion'];
                    break;
                case 'ejecucion':
                    $phasesToCreate = ['diagnostico', 'formulacion', 'financiacion', 'ejecucion'];
                    break;
                case 'evaluacion':
                    $phasesToCreate = ['diagnostico', 'formulacion', 'financiacion', 'ejecucion', 'evaluacion'];
                    break;
                case 'cierre':
                    $phasesToCreate = ['diagnostico', 'formulacion', 'financiacion', 'ejecucion', 'evaluacion', 'cierre'];
                    break;
            }
            
            foreach ($phasesToCreate as $phase) {
                $phaseImages = $sampleImages[$phase] ?? [];
                
                foreach ($phaseImages as $imageData) {
                    // Crear la imagen de ejemplo (en un entorno real, estas serían imágenes reales)
                    $this->createSampleImage($imageData['path']);
                    
                    ProjectPhaseImage::create([
                        'project_id' => $project->id,
                        'fase' => $phase,
                        'image_path' => $imageData['path'],
                        'original_name' => basename($imageData['path']),
                        'mime_type' => 'image/jpeg',
                        'file_size' => 1024000, // 1MB aproximado
                        'description' => $imageData['description'],
                    ]);
                }
            }
        }
    }

    /**
     * Crear una imagen de ejemplo para testing
     */
    private function createSampleImage(string $path): void
    {
        // Crear el directorio si no existe
        $directory = dirname(storage_path('app/public/' . $path));
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Crear una imagen simple de ejemplo (1x1 pixel)
        $image = imagecreate(1, 1);
        $color = imagecolorallocate($image, 200, 200, 200);
        imagefill($image, 0, 0, $color);
        
        // Guardar la imagen
        $fullPath = storage_path('app/public/' . $path);
        imagejpeg($image, $fullPath, 80);
        imagedestroy($image);
    }
}