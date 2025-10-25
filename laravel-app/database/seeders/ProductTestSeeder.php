<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Cemento Portland',
                'description' => 'Cemento de alta calidad para construcción de viviendas. Ideal para cimientos, muros y estructuras.',
                'short_description' => 'Cemento de alta calidad para construcción',
                'category' => 'Materiales de Construcción',
                'subcategory' => 'Cementos',
                'stock_quantity' => 50,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'suggested_price' => 25.00,
                'currency' => 'GTQ',
                'weight' => 50.0,
                'is_active' => true,
                'is_featured' => true,
                'is_digital' => false,
                'requires_shipping' => true,
                'condition' => 'new',
                'tags' => ['cemento', 'construcción', 'materiales'],
                'specifications' => [
                    'Tipo' => 'Portland Tipo I',
                    'Resistencia' => '28 MPa',
                    'Peso' => '50 kg por bolsa'
                ],
                'usage_instructions' => 'Mezclar con agua y arena en proporción 1:3:1',
                'donation_source' => 'Donación de empresa constructora',
                'ngo_notes' => 'Producto donado en excelente estado'
            ],
            [
                'name' => 'Ladrillos de Arcilla',
                'description' => 'Ladrillos de arcilla cocida para construcción de muros. Material tradicional y duradero.',
                'short_description' => 'Ladrillos de arcilla para construcción',
                'category' => 'Materiales de Construcción',
                'subcategory' => 'Ladrillos',
                'stock_quantity' => 200,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'suggested_price' => 0.50,
                'currency' => 'GTQ',
                'weight' => 2.5,
                'is_active' => true,
                'is_featured' => false,
                'is_digital' => false,
                'requires_shipping' => true,
                'condition' => 'good',
                'tags' => ['ladrillos', 'arcilla', 'muros'],
                'specifications' => [
                    'Dimensiones' => '12x6x25 cm',
                    'Material' => 'Arcilla cocida',
                    'Color' => 'Rojo tradicional'
                ],
                'donation_source' => 'Donación de alfarería local',
                'ngo_notes' => 'Ladrillos de producción local'
            ],
            [
                'name' => 'Martillo de Construcción',
                'description' => 'Martillo pesado para trabajos de construcción. Ideal para demolición y construcción.',
                'short_description' => 'Martillo para trabajos de construcción',
                'category' => 'Herramientas',
                'subcategory' => 'Martillos',
                'stock_quantity' => 15,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'suggested_price' => 45.00,
                'currency' => 'GTQ',
                'weight' => 1.2,
                'is_active' => true,
                'is_featured' => false,
                'is_digital' => false,
                'requires_shipping' => false,
                'condition' => 'like_new',
                'tags' => ['martillo', 'herramientas', 'construcción'],
                'specifications' => [
                    'Peso' => '1.2 kg',
                    'Material' => 'Acero forjado',
                    'Mango' => 'Madera de nogal'
                ],
                'usage_instructions' => 'Usar con protección ocular y guantes',
                'donation_source' => 'Donación de voluntarios',
                'ngo_notes' => 'Herramientas en excelente estado'
            ],
            [
                'name' => 'Planos de Construcción',
                'description' => 'Planos técnicos para construcción de vivienda básica. Incluye especificaciones y medidas.',
                'short_description' => 'Planos técnicos para construcción',
                'category' => 'Documentación',
                'subcategory' => 'Planos',
                'stock_quantity' => 5,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'suggested_price' => 0.00,
                'currency' => 'GTQ',
                'is_active' => true,
                'is_featured' => true,
                'is_digital' => true,
                'requires_shipping' => false,
                'condition' => 'new',
                'tags' => ['planos', 'documentación', 'técnico'],
                'specifications' => [
                    'Formato' => 'PDF digital',
                    'Escala' => '1:100',
                    'Idioma' => 'Español'
                ],
                'usage_instructions' => 'Imprimir en papel A1 para mejor visualización',
                'donation_source' => 'Donación de arquitecto voluntario',
                'ngo_notes' => 'Planos diseñados específicamente para proyectos de Habitat'
            ],
            [
                'name' => 'Pintura Exterior',
                'description' => 'Pintura de alta calidad para exteriores. Resistente a la intemperie y durabilidad prolongada.',
                'short_description' => 'Pintura para exteriores',
                'category' => 'Acabados',
                'subcategory' => 'Pinturas',
                'stock_quantity' => 8,
                'stock_status' => 'in_stock',
                'manage_stock' => true,
                'suggested_price' => 85.00,
                'currency' => 'GTQ',
                'weight' => 4.0,
                'is_active' => true,
                'is_featured' => false,
                'is_digital' => false,
                'requires_shipping' => true,
                'condition' => 'new',
                'tags' => ['pintura', 'exterior', 'acabados'],
                'specifications' => [
                    'Capacidad' => '4 litros',
                    'Color' => 'Blanco',
                    'Tipo' => 'Acrílica exterior'
                ],
                'usage_instructions' => 'Aplicar en dos capas con brocha o rodillo',
                'care_instructions' => 'Almacenar en lugar fresco y seco',
                'donation_source' => 'Donación de empresa de pinturas',
                'ngo_notes' => 'Pintura de primera calidad donada'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}