<?php
/**
 * Script para migrar vistas de AdminLTE a Tabler
 * Este script actualiza automáticamente las vistas más comunes
 */

$viewsToMigrate = [
    // Usuarios
    'users/create.blade.php',
    'users/edit.blade.php', 
    'users/show.blade.php',
    'users/permissions.blade.php',
    
    // Proyectos
    'projects/create.blade.php',
    'projects/edit.blade.php',
    'projects/show.blade.php',
    
    // Beneficiarios
    'beneficiaries/create.blade.php',
    'beneficiaries/edit.blade.php',
    'beneficiaries/show.blade.php',
    'beneficiaries/index.blade.php',
    
    // Ubicaciones
    'locations/create.blade.php',
    'locations/edit.blade.php',
    'locations/show.blade.php',
    'locations/index.blade.php',
    
    // Patrocinadores
    'sponsors/create.blade.php',
    'sponsors/edit.blade.php',
    'sponsors/show.blade.php',
    'sponsors/index.blade.php',
    
    // Eventos
    'events/create.blade.php',
    'events/edit.blade.php',
    'events/show.blade.php',
    'events/index.blade.php',
    
    // Donaciones
    'donations/create.blade.php',
    'donations/edit.blade.php',
    'donations/show.blade.php',
    'donations/index.blade.php',
    'donations/reports.blade.php',
    
    // Productos
    'products/create.blade.php',
    'products/edit.blade.php',
    'products/show.blade.php',
    'products/index.blade.php',
    'products/catalog.blade.php',
    'products/statistics.blade.php',
];

echo "=== MIGRACIÓN DE VISTAS A TABLER ===\n";
echo "Total de vistas a migrar: " . count($viewsToMigrate) . "\n\n";

foreach ($viewsToMigrate as $view) {
    $filePath = "resources/views/{$view}";
    
    if (!file_exists($filePath)) {
        echo "❌ Archivo no encontrado: {$filePath}\n";
        continue;
    }
    
    $content = file_get_contents($filePath);
    
    // Verificar si ya está migrado
    if (strpos($content, "@extends('layouts.tabler')") !== false) {
        echo "✅ Ya migrado: {$view}\n";
        continue;
    }
    
    // Migrar de AdminLTE a Tabler
    $content = str_replace("@extends('layouts.app')", "@extends('layouts.tabler')", $content);
    
    // Agregar secciones de página si no existen
    if (strpos($content, "@section('page-title')") === false) {
        // Extraer título de la sección title existente
        preg_match("/@section\('title',\s*['\"]([^'\"]+)['\"]/", $content, $matches);
        $pageTitle = $matches[1] ?? 'Página';
        
        // Agregar secciones de página
        $content = str_replace(
            "@section('content')",
            "@section('page-title', '{$pageTitle}')\n@section('page-description', 'Administración del sistema')\n\n@section('content')",
            $content
        );
    }
    
    // Limpiar contenedores innecesarios
    $content = str_replace('<div class="container-fluid">', '', $content);
    $content = str_replace('<div class="container">', '', $content);
    
    // Actualizar clases de tabla
    $content = str_replace('table table-striped table-hover', 'table table-vcenter card-table', $content);
    $content = str_replace('table table-hover', 'table table-vcenter card-table', $content);
    $content = str_replace('thead-dark', '', $content);
    
    // Actualizar badges
    $content = str_replace('badge badge-', 'badge bg-', $content);
    
    // Actualizar botones
    $content = str_replace('btn btn-sm btn-outline-info', 'btn btn-sm btn-outline-primary', $content);
    
    // Escribir archivo actualizado
    file_put_contents($filePath, $content);
    
    echo "✅ Migrado: {$view}\n";
}

echo "\n=== MIGRACIÓN COMPLETADA ===\n";
echo "Todas las vistas han sido migradas a Tabler.\n";
echo "Revisa manualmente los archivos para ajustes específicos.\n";
?>
