<?php
/**
 * Script para actualizar clases CSS de AdminLTE a Tabler
 */

$viewsDirectory = 'resources/views/';
$updatedFiles = 0;

function updateFile($filePath) {
    global $updatedFiles;
    
    if (!file_exists($filePath)) {
        return false;
    }
    
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Actualizar clases de tabla
    $content = str_replace('table table-striped table-hover', 'table table-vcenter card-table', $content);
    $content = str_replace('table table-hover', 'table table-vcenter card-table', $content);
    $content = str_replace('thead-dark', '', $content);
    $content = str_replace('table-dark', '', $content);
    
    // Actualizar badges
    $content = str_replace('badge badge-', 'badge bg-', $content);
    
    // Actualizar botones
    $content = str_replace('btn btn-sm btn-outline-info', 'btn btn-sm btn-outline-primary', $content);
    $content = str_replace('btn btn-sm btn-outline-secondary', 'btn btn-sm btn-outline-warning', $content);
    
    // Actualizar contenedores
    $content = str_replace('<div class="container-fluid">', '<div class="row">', $content);
    $content = str_replace('<div class="container">', '<div class="row">', $content);
    
    // Actualizar alertas
    $content = str_replace('alert alert-success alert-dismissible fade show', 'alert alert-success alert-dismissible', $content);
    $content = str_replace('alert alert-danger alert-dismissible fade show', 'alert alert-danger alert-dismissible', $content);
    $content = str_replace('alert alert-warning alert-dismissible fade show', 'alert alert-warning alert-dismissible', $content);
    $content = str_replace('alert alert-info alert-dismissible fade show', 'alert alert-info alert-dismissible', $content);
    
    // Actualizar botones de cerrar alertas
    $content = str_replace('data-dismiss="alert"', 'data-bs-dismiss="alert"', $content);
    $content = str_replace('class="close"', 'class="btn-close"', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        $updatedFiles++;
        return true;
    }
    
    return false;
}

// Obtener todos los archivos .blade.php
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsDirectory)
);

$bladeFiles = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
        $bladeFiles[] = $file->getPathname();
    }
}

echo "=== ACTUALIZANDO CLASES CSS A TABLER ===\n";
echo "Archivos encontrados: " . count($bladeFiles) . "\n\n";

foreach ($bladeFiles as $file) {
    $relativePath = str_replace($viewsDirectory, '', $file);
    if (updateFile($file)) {
        echo "✅ Actualizado: {$relativePath}\n";
    }
}

echo "\n=== ACTUALIZACIÓN COMPLETADA ===\n";
echo "Total de archivos actualizados: {$updatedFiles}\n";
?>
