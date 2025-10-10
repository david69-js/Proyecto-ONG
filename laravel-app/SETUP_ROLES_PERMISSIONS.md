# Configuración del Sistema de Roles y Permisos

## Resumen de Cambios

Se ha implementado un sistema completo de control de acceso basado en roles (RBAC) con las siguientes características:

### 1. Nuevo Rol: Beneficiario
- Rol con acceso limitado solo a sus propios datos
- Solo puede ver proyectos a los que está asignado
- No puede ver lista de usuarios ni crear/editar proyectos

### 2. Políticas de Autorización (Policies)
Se han creado políticas para:
- **ProjectPolicy**: Control de acceso a proyectos
- **UserPolicy**: Control de acceso a usuarios
- **BeneficiaryPolicy**: Control de acceso a beneficiarios
- **LocationPolicy**: Control de acceso a ubicaciones

### 3. Nuevos Permisos
- `projects.view.own` - Ver solo proyectos asignados
- `profile.view.own` - Ver solo perfil propio
- `profile.edit.own` - Editar solo perfil propio
- `benefits.view.own` - Ver solo beneficios propios

### 4. Relación User-Beneficiary
- Agregado campo `user_id` en la tabla de beneficiarios
- Relación uno a uno entre User y Beneficiary
- Permite vincular un usuario del sistema con un registro de beneficiario

## Instrucciones de Instalación

### Paso 1: Ejecutar Migraciones

Ejecuta la nueva migración para agregar el campo `user_id` a la tabla de beneficiarios:

```bash
php artisan migrate
```

Esto ejecutará:
- `2025_10_10_000001_add_user_id_to_beneficiaries_table.php`

### Paso 2: Ejecutar Seeders

Ejecuta los seeders en el siguiente orden:

```bash
# Ejecutar todos los seeders
php artisan db:seed

# O ejecutarlos individualmente:
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RolePermissionSeeder
```

Esto creará:
- El nuevo rol "Beneficiario"
- Los nuevos permisos específicos
- Las asignaciones de permisos a cada rol

### Paso 3: Verificar Configuración

Verifica que todo esté correcto:

```bash
php artisan tinker

# Verificar roles
\App\Models\Role::all(['name', 'slug']);

# Verificar permisos
\App\Models\Permission::all(['name', 'slug']);

# Verificar permisos del rol beneficiario
\App\Models\Role::where('slug', 'beneficiary')->first()->permissions->pluck('name');
```

## Distribución de Permisos por Rol

### Super Administrador
- ✅ **Acceso completo** a todo el sistema

### Administrador
- ✅ Gestión de usuarios, proyectos, beneficiarios, ubicaciones
- ✅ Ver reportes y exportar datos
- ❌ No puede gestionar roles ni configuración del sistema

### Coordinador de Proyectos
- ✅ Ver, crear y editar proyectos
- ✅ Ver, crear y editar beneficiarios
- ✅ Ver usuarios y ubicaciones
- ✅ Ver reportes
- ❌ No puede eliminar proyectos ni gestionar usuarios

### Coordinador de Beneficiarios
- ✅ Gestión completa de beneficiarios (CRUD)
- ✅ Ver proyectos y usuarios
- ✅ Ver reportes
- ❌ No puede gestionar proyectos

### Voluntario
- ✅ Ver usuarios, proyectos, beneficiarios y ubicaciones
- ❌ Solo lectura, no puede crear ni editar nada

### Consultor
- ✅ Ver usuarios, proyectos, beneficiarios, ubicaciones
- ✅ Ver reportes
- ❌ Solo lectura

### Donante
- ✅ Ver proyectos
- ✅ Ver reportes
- ❌ Acceso muy limitado

### Beneficiario (NUEVO)
- ✅ Ver solo sus proyectos asignados
- ✅ Ver y editar solo su perfil
- ✅ Ver solo sus beneficios
- ❌ No puede ver otros usuarios ni gestionar nada

## Uso en Controladores

Los controladores ya han sido actualizados con autorización:

```php
// Verificar si el usuario puede ver todos los proyectos
$this->authorize('viewAny', Project::class);

// Verificar si el usuario puede ver un proyecto específico
$this->authorize('view', $project);

// Verificar si el usuario puede crear un proyecto
$this->authorize('create', Project::class);

// Verificar si el usuario puede actualizar un proyecto
$this->authorize('update', $project);

// Verificar si el usuario puede eliminar un proyecto
$this->authorize('delete', $project);
```

## Uso en Vistas (Blade)

Usa las directivas personalizadas en tus vistas:

```blade
@role('super-admin')
    <a href="{{ route('users.index') }}">Gestionar Usuarios</a>
@endrole

@permission('projects.create')
    <a href="{{ route('projects.create') }}">Crear Proyecto</a>
@endpermission

@hasanyrole('super-admin', 'admin', 'project-coordinator')
    <a href="{{ route('projects.index') }}">Ver Proyectos</a>
@endhasanyrole

@can('update', $project)
    <a href="{{ route('projects.edit', $project) }}">Editar</a>
@endcan
```

Ver `BLADE_DIRECTIVES_GUIDE.md` para más ejemplos.

## Crear un Usuario Beneficiario

Para crear un usuario con rol de beneficiario y vincularlo a un beneficiario:

```php
// 1. Crear el usuario
$user = User::create([
    'first_name' => 'Juan',
    'last_name' => 'Pérez',
    'email' => 'juan.perez@example.com',
    'password' => Hash::make('password'),
    'is_active' => true,
]);

// 2. Asignar el rol de beneficiario
$beneficiaryRole = Role::where('slug', 'beneficiary')->first();
$user->roles()->attach($beneficiaryRole->id, [
    'assigned_at' => now(),
    'assigned_by' => auth()->id(),
]);

// 3. Crear o vincular el registro de beneficiario
$beneficiary = Beneficiary::create([
    'user_id' => $user->id,
    'name' => 'Juan Pérez',
    'email' => 'juan.perez@example.com',
    'project_id' => 1, // ID del proyecto asignado
    'status' => 'active',
]);
```

## Testing

Para probar el sistema de permisos:

```bash
# Crear un usuario de prueba con rol beneficiario
php artisan tinker

$user = \App\Models\User::factory()->create([
    'email' => 'beneficiary@test.com'
]);
$user->assignRole('beneficiary');

# Crear un beneficiario vinculado
$beneficiary = \App\Models\Beneficiary::create([
    'user_id' => $user->id,
    'name' => 'Test Beneficiary',
    'project_id' => 1,
]);

# Verificar permisos
$user->hasRole('beneficiary'); // true
$user->hasPermission('projects.view.own'); // true
$user->hasPermission('projects.create'); // false
```

## Solución de Problemas

### Error: "This action is unauthorized"

Si recibes un error 403, verifica:

1. El usuario tiene el rol correcto:
```php
$user->roles->pluck('slug');
```

2. El rol tiene los permisos correctos:
```php
$role = Role::where('slug', 'your-role')->first();
$role->permissions->pluck('slug');
```

3. Las policies están registradas en `AppServiceProvider.php`

### Los permisos no se actualizan

Si cambias permisos, recuerda ejecutar:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

## Próximos Pasos

1. Actualizar las vistas existentes para usar las directivas de Blade
2. Agregar tests automatizados para las policies
3. Crear middleware personalizado si se necesita lógica adicional
4. Implementar logs de auditoría para cambios de permisos

## Soporte

Para más información, consulta:
- `BLADE_DIRECTIVES_GUIDE.md` - Guía de uso en vistas
- `ROLES_PERMISSIONS_GUIDE.md` - Guía general del sistema
- Laravel Policies: https://laravel.com/docs/11.x/authorization#creating-policies

