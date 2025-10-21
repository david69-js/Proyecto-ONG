# Módulo de Fases de Proyecto

## Descripción
Este módulo permite gestionar las 6 fases principales de un proyecto con sus respectivos porcentajes de avance y la capacidad de subir imágenes para documentar cada fase.

## Fases del Proyecto
1. **Diagnóstico** - Análisis inicial y evaluación de necesidades
2. **Formulación** - Diseño y planificación del proyecto
3. **Financiación** - Búsqueda y gestión de recursos económicos
4. **Ejecución** - Implementación del proyecto
5. **Evaluación** - Seguimiento y evaluación de resultados
6. **Cierre** - Finalización y documentación del proyecto

## Características Implementadas

### 1. Base de Datos
- **Tabla `ng_projects`**: Campos agregados para cada fase con porcentajes (0-100%)
- **Tabla `project_phase_images`**: Almacenamiento de imágenes por fase
- **Campos de fechas**: Para inicio y fin de cada fase (opcional)

### 2. Modelos
- **Project**: Métodos para calcular progreso total y gestionar fases
- **ProjectPhaseImage**: Gestión de imágenes con metadatos (título, descripción)

### 3. Controladores
- **ProjectController**: Métodos para actualizar fases y gestionar imágenes
- **Validaciones**: Porcentajes entre 0-100%, tipos de archivo de imagen

### 4. Vistas
- **Formulario de edición**: Campos para todas las fases y porcentajes
- **Vista de detalle**: Visualización del progreso general y por fase
- **Gestión de fases**: Interfaz completa para administrar fases e imágenes

### 5. Funcionalidades

#### Gestión de Porcentajes
- Cada fase puede tener un porcentaje de 0 a 100%
- Cálculo automático del progreso total del proyecto
- Visualización con barras de progreso

#### Gestión de Imágenes
- Subida de imágenes por fase
- Metadatos: título y descripción
- Ordenamiento de imágenes
- Eliminación de imágenes

#### Navegación
- Botón "Gestionar Fases" en la vista de detalle del proyecto
- Interfaz intuitiva para administrar todas las fases

## Rutas Agregadas

```php
// Gestión de fases
Route::get('/{project}/phases', [ProjectController::class, 'phases'])->name('phases');
Route::put('/{project}/phases', [ProjectController::class, 'updatePhases'])->name('update-phases');
Route::post('/{project}/phases/upload-image', [ProjectController::class, 'uploadPhaseImage'])->name('upload-phase-image');
Route::delete('/phases/{phaseImage}', [ProjectController::class, 'deletePhaseImage'])->name('delete-phase-image');
```

## Uso

### 1. Crear/Editar Proyecto
- Los campos de fases están disponibles en el formulario de creación y edición
- Seleccionar la fase actual del proyecto
- Establecer porcentajes para cada fase

### 2. Gestionar Fases
- Acceder desde la vista de detalle del proyecto
- Actualizar porcentajes de todas las fases
- Cambiar la fase actual del proyecto

### 3. Subir Imágenes
- Seleccionar la fase correspondiente
- Subir imagen con título y descripción opcionales
- Las imágenes se almacenan en `storage/app/public/project-phases/`

### 4. Visualizar Progreso
- Barra de progreso general en la vista de detalle
- Tarjetas individuales para cada fase con su porcentaje
- Indicador de la fase actual

## Archivos Modificados

### Migraciones
- `011_create_ng_projects_table.php` - Campos de fases agregados
- `028_create_project_phase_images_table.php` - Nueva tabla para imágenes

### Modelos
- `Project.php` - Métodos para fases y progreso
- `ProjectPhaseImage.php` - Nuevo modelo para imágenes

### Controladores
- `ProjectController.php` - Métodos para gestión de fases

### Vistas
- `projects/partials/form.blade.php` - Campos de fases en formularios
- `projects/show.blade.php` - Visualización de progreso
- `projects/phases.blade.php` - Gestión completa de fases

### Seeders
- `ProjectPhaseSeeder.php` - Valores por defecto para proyectos existentes

## Permisos Requeridos
- `projects.edit` - Para gestionar fases e imágenes
- `projects.view` - Para visualizar información de fases

## Consideraciones Técnicas

### Almacenamiento de Imágenes
- Las imágenes se almacenan en `storage/app/public/project-phases/`
- Tamaño máximo: 2MB
- Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP
- Enlace simbólico requerido: `php artisan storage:link`

### Validaciones
- Porcentajes deben estar entre 0 y 100
- Fase actual debe ser una de las 6 fases válidas
- Imágenes deben ser archivos válidos de imagen

### Rendimiento
- Las consultas incluyen relaciones para evitar N+1
- Las imágenes se cargan bajo demanda por fase
- Cálculo de progreso total se hace en el modelo

## Próximos Pasos Sugeridos
1. Implementar notificaciones cuando se complete una fase
2. Agregar fechas de inicio y fin para cada fase
3. Crear reportes de progreso por fase
4. Implementar comentarios o notas por fase
5. Agregar validaciones de flujo (no se puede avanzar sin completar fases anteriores)
