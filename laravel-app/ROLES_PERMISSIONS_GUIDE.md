# Guía del Sistema de Roles y Permisos - ONG

## Descripción General

Este sistema implementa un control de acceso basado en roles (RBAC) específicamente diseñado para organizaciones no gubernamentales (ONG). Permite gestionar usuarios, roles, permisos y controlar el acceso a diferentes funcionalidades del sistema.

## Roles Disponibles

### 1. Administrador del Sistema (`system-admin`)
- **Descripción**: Gestiona todo: usuarios, roles, permisos, configuraciones globales
- **Permisos**: Acceso completo a todas las funcionalidades del sistema
- **Uso típico**: Director ejecutivo, administrador de TI

### 2. Coordinador de Proyecto (`project-coordinator`)
- **Descripción**: Responsable de crear y gestionar proyectos, asignar beneficiarios, administrar recursos
- **Permisos**: Gestión completa de proyectos, beneficiarios, donaciones, productos y reportes
- **Uso típico**: Coordinadores de programas, gerentes de proyecto

### 3. Voluntario / Staff (`volunteer-staff`)
- **Descripción**: Participa en la ejecución de proyectos y actividades, registra asistencia o entregas
- **Permisos**: Acceso de lectura a la mayoría de módulos, puede registrar asistencia y entregas
- **Uso típico**: Voluntarios, personal de campo, staff operativo

### 4. Donante (`donor`)
- **Descripción**: Puede acceder a información de proyectos y registrar donaciones
- **Permisos**: Ver proyectos, registrar donaciones, ver reportes básicos
- **Uso típico**: Donantes individuales, organizaciones donantes

### 5. Beneficiario (`beneficiary`)
- **Descripción**: Puede ver información básica de su participación o recibir notificaciones
- **Permisos**: Acceso muy limitado, solo puede ver proyectos y actividades
- **Uso típico**: Personas que reciben ayuda de la ONG

## Módulos y Permisos

### Gestión de Usuarios
- `users.view` - Ver lista de usuarios
- `users.create` - Crear nuevos usuarios
- `users.edit` - Editar información de usuarios
- `users.delete` - Eliminar usuarios

### Gestión de Roles y Permisos
- `roles.manage` - Crear, editar y eliminar roles
- `permissions.manage` - Crear, editar y eliminar permisos
- `roles.assign` - Asignar roles a usuarios

### Gestión de Proyectos
- `projects.view` - Ver lista de proyectos
- `projects.create` - Crear nuevos proyectos
- `projects.edit` - Editar información de proyectos
- `projects.delete` - Eliminar proyectos
- `projects.update-status` - Actualizar estado de proyectos
- `projects.assign-beneficiaries` - Asignar beneficiarios a proyectos

### Gestión de Beneficiarios
- `beneficiaries.view` - Ver lista de beneficiarios
- `beneficiaries.create` - Crear nuevos beneficiarios
- `beneficiaries.edit` - Editar información de beneficiarios
- `beneficiaries.delete` - Eliminar beneficiarios
- `beneficiaries.link-projects` - Vincular beneficiarios a proyectos

### Gestión de Donaciones
- `donations.view` - Ver lista de donaciones
- `donations.create` - Registrar nuevas donaciones
- `donations.edit` - Editar información de donaciones
- `donations.delete` - Eliminar donaciones
- `donations.assign-projects` - Asignar donaciones a proyectos
- `donations.reports` - Consultar reportes de donaciones

### Gestión de Productos/Recursos
- `products.view` - Ver inventario de productos y recursos
- `products.register-stock` - Registrar stock de productos
- `products.assign-projects` - Asignar productos a proyectos
- `products.control-inventory` - Controlar y gestionar inventario
- `products.edit` - Editar información de productos

### Ubicaciones
- `locations.view` - Ver lista de ubicaciones
- `locations.create` - Crear nuevas ubicaciones
- `locations.edit` - Editar información de ubicaciones
- `locations.delete` - Eliminar ubicaciones

### Reportes
- `reports.view` - Ver reportes del sistema
- `reports.impact-statistics` - Generar estadísticas de impacto
- `reports.export` - Exportar informes del sistema

### Auditoría
- `audit.view-history` - Consultar historial de cambios del sistema
- `audit.view-logs` - Ver logs del sistema

### Configuración
- `settings.manage` - Modificar configuración del sistema

### Actividades y Asistencia
- `activities.view` - Ver actividades del sistema
- `activities.register-attendance` - Registrar asistencia a actividades
- `activities.register-deliveries` - Registrar entregas de productos

## Uso en el Código

### 1. Middleware en Rutas

```php
// Verificar un permiso específico
Route::get('/users', [UserController::class, 'index'])->middleware('permission:users.view');

// Verificar un rol específico
Route::get('/admin', [AdminController::class, 'index'])->middleware('role:system-admin');

// Verificar cualquiera de varios roles
Route::get('/projects', [ProjectController::class, 'index'])->middleware('any.role:system-admin,project-coordinator');

// Verificar cualquiera de varios permisos
Route::get('/reports', [ReportController::class, 'index'])->middleware('any.permission:reports.view,reports.export');
```

### 2. Verificación en Controladores

```php
public function index()
{
    // Verificar permiso
    if (!auth()->user()->hasPermission('users.view')) {
        abort(403, 'No tienes permisos para ver usuarios.');
    }
    
    // Verificar rol
    if (!auth()->user()->hasRole('system-admin')) {
        abort(403, 'Solo los administradores pueden acceder.');
    }
    
    // Verificar cualquiera de varios permisos
    if (!auth()->user()->hasAnyPermission(['projects.view', 'projects.edit'])) {
        abort(403, 'No tienes permisos para acceder a proyectos.');
    }
}
```

### 3. Directivas Blade en Vistas

```blade
{{-- Verificar rol --}}
@role('system-admin')
    <a href="/admin">Panel de Administración</a>
@endrole

{{-- Verificar permiso --}}
@permission('users.create')
    <button>Crear Usuario</button>
@endpermission

{{-- Verificar cualquiera de varios roles --}}
@anyrole(['system-admin', 'project-coordinator'])
    <a href="/projects">Gestionar Proyectos</a>
@endanyrole

{{-- Verificar cualquiera de varios permisos --}}
@anypermission(['donations.view', 'donations.create'])
    <a href="/donations">Donaciones</a>
@endanypermission

{{-- Verificar que NO tiene un rol --}}
@notrole('beneficiary')
    <a href="/admin">Acceso Administrativo</a>
@endnotrole
```

### 4. Asignación de Roles y Permisos

```php
// Asignar rol a usuario
$user->assignRole('project-coordinator');

// Remover rol de usuario
$user->removeRole('volunteer-staff');

// Verificar si usuario tiene rol
if ($user->hasRole('system-admin')) {
    // Lógica para administrador
}

// Verificar si usuario tiene permiso
if ($user->hasPermission('projects.create')) {
    // Usuario puede crear proyectos
}

// Obtener todos los permisos del usuario (incluyendo los de sus roles)
$permissions = $user->getAllPermissions();
```

## Configuración de Base de Datos

### Ejecutar Seeders

```bash
# Ejecutar todos los seeders
php artisan db:seed

# Ejecutar seeders específicos
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RolePermissionSeeder
```

### Estructura de Tablas

- `cfg_roles` - Almacena los roles del sistema
- `cfg_permissions` - Almacena los permisos del sistema
- `rel_user_roles` - Relación muchos a muchos entre usuarios y roles
- `rel_role_permissions` - Relación muchos a muchos entre roles y permisos
- `rel_user_permissions` - Relación muchos a muchos entre usuarios y permisos (asignación directa)

## Mejores Prácticas

1. **Principio de Menor Privilegio**: Asigna solo los permisos mínimos necesarios para cada rol.

2. **Verificación en Múltiples Capas**: Usa middleware en rutas, verificación en controladores y directivas en vistas.

3. **Documentación**: Mantén documentados los roles y permisos para facilitar la gestión.

4. **Auditoría**: Usa los permisos de auditoría para monitorear cambios en el sistema.

5. **Testing**: Crea tests para verificar que los permisos funcionan correctamente.

## Extensión del Sistema

Para agregar nuevos roles o permisos:

1. Actualiza `RoleSeeder.php` para nuevos roles
2. Actualiza `PermissionSeeder.php` para nuevos permisos
3. Actualiza `RolePermissionSeeder.php` para asignar permisos a roles
4. Ejecuta los seeders: `php artisan db:seed`

## Seguridad

- Los middleware verifican autenticación antes de verificar permisos
- Los errores 403 se muestran cuando no hay permisos suficientes
- El sistema soporta asignación directa de permisos a usuarios (además de través de roles)
- Los permisos pueden ser desactivados sin eliminar la estructura de base de datos
