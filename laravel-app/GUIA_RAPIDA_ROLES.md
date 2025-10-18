# 🚀 Guía Rápida - Sistema de Roles y Permisos

## ⚡ Instalación Rápida

### Windows
```bash
cd laravel-app
setup-roles.bat
```

### Linux/Mac
```bash
cd laravel-app
chmod +x setup-roles.sh
./setup-roles.sh
```

### Manual
```bash
php artisan migrate
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RolePermissionSeeder
```

## 🎭 Roles Disponibles

| Rol | Slug | Permisos |
|-----|------|----------|
| Super Administrador | `super-admin` | Todo ✅ |
| Administrador | `admin` | Casi todo (no gestión de roles) |
| Coordinador de Proyectos | `project-coordinator` | Proyectos y beneficiarios |
| Coordinador de Beneficiarios | `beneficiary-coordinator` | Beneficiarios principalmente |
| Voluntario | `volunteer` | Solo lectura |
| Consultor | `consultant` | Solo lectura + reportes |
| Donante | `donor` | Ver proyectos y reportes |
| **Beneficiario** ⭐ | `beneficiary` | Solo sus datos |

## 🔐 Usar en Vistas (Blade)

### Por Rol
```blade
@role('beneficiary')
    <p>Contenido solo para beneficiarios</p>
@endrole

@hasanyrole('admin', 'super-admin')
    <button>Gestionar</button>
@endhasanyrole
```

### Por Permiso
```blade
@permission('projects.create')
    <a href="{{ route('projects.create') }}">Crear Proyecto</a>
@endpermission

@hasanypermission('projects.edit', 'projects.delete')
    <div class="actions">...</div>
@endhasanypermission
```

### Con Policies
```blade
@can('update', $project)
    <a href="{{ route('projects.edit', $project) }}">Editar</a>
@endcan

@cannot('delete', $user)
    <p>No puedes eliminar este usuario</p>
@endcannot
```

## 🎯 Usar en Controladores

### Verificar Autorización
```php
// Al inicio del método
public function index()
{
    $this->authorize('viewAny', Project::class);
    // ... resto del código
}

public function update(Request $request, Project $project)
{
    $this->authorize('update', $project);
    // ... resto del código
}
```

### Filtrar Datos por Rol
```php
// En ProjectController
use App\Policies\ProjectPolicy;

public function index()
{
    $this->authorize('viewAny', Project::class);
    
    $query = Project::with('responsable');
    $projects = ProjectPolicy::scopeForUser(auth()->user(), $query)->get();
    
    return view('projects.index', compact('projects'));
}
```

## 👤 Crear Usuario Beneficiario

### Opción 1: Por código
```php
use App\Models\User;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Hash;

// Crear usuario
$user = User::create([
    'first_name' => 'Juan',
    'last_name' => 'Pérez',
    'email' => 'juan@example.com',
    'password' => Hash::make('password123'),
    'is_active' => true,
]);

// Asignar rol
$user->assignRole('beneficiary');

// Crear beneficiario vinculado
$beneficiary = Beneficiary::create([
    'user_id' => $user->id,
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'project_id' => 1, // Proyecto asignado
    'status' => 'active',
]);
```

### Opción 2: Con Tinker
```bash
php artisan tinker
```

```php
$user = \App\Models\User::factory()->create(['email' => 'test@example.com']);
$user->assignRole('beneficiary');
$beneficiary = \App\Models\Beneficiary::create([
    'user_id' => $user->id,
    'name' => 'Test User',
    'project_id' => 1
]);
```

## 🔍 Verificar Permisos

### En Código
```php
// Verificar rol
if (auth()->user()->hasRole('beneficiary')) {
    // Es beneficiario
}

// Verificar permiso
if (auth()->user()->hasPermission('projects.create')) {
    // Puede crear proyectos
}

// Verificar múltiples roles
if (auth()->user()->hasAnyRole(['admin', 'super-admin'])) {
    // Es admin o super-admin
}
```

### En Tinker
```bash
php artisan tinker
```

```php
// Ver todos los roles
\App\Models\Role::all(['name', 'slug']);

// Ver permisos de un rol
$role = \App\Models\Role::where('slug', 'beneficiary')->first();
$role->permissions->pluck('name', 'slug');

// Ver roles de un usuario
$user = \App\Models\User::find(1);
$user->roles->pluck('name');

// Ver permisos de un usuario
$user->getAllPermissions()->pluck('name', 'slug');
```

## 📊 Matriz de Permisos Rápida

### Proyectos
| Rol | Ver Todos | Ver Propios | Crear | Editar | Eliminar |
|-----|-----------|-------------|-------|--------|----------|
| super-admin | ✅ | ✅ | ✅ | ✅ | ✅ |
| admin | ✅ | ✅ | ✅ | ✅ | ✅ |
| project-coordinator | ✅ | ✅ | ✅ | ✅ | ❌ |
| beneficiary | ❌ | ✅ | ❌ | ❌ | ❌ |

### Usuarios
| Rol | Ver | Crear | Editar | Eliminar |
|-----|-----|-------|--------|----------|
| super-admin | ✅ | ✅ | ✅ | ✅ |
| admin | ✅ | ✅ | ✅ | ✅ (no admins) |
| beneficiary | ❌ | ❌ | ✅ (solo propio) | ❌ |

### Beneficiarios
| Rol | Ver Todos | Ver Propios | Crear | Editar | Eliminar |
|-----|-----------|-------------|-------|--------|----------|
| super-admin | ✅ | ✅ | ✅ | ✅ | ✅ |
| admin | ✅ | ✅ | ✅ | ✅ | ✅ |
| beneficiary-coordinator | ✅ | ✅ | ✅ | ✅ | ✅ |
| beneficiary | ❌ | ✅ | ❌ | ✅ (solo propio) | ❌ |

## 🐛 Troubleshooting

### Error 403 "Unauthorized"
```bash
# Verificar rol del usuario
php artisan tinker
$user = \App\Models\User::find(ID);
$user->roles->pluck('slug');

# Verificar permisos del rol
$role = \App\Models\Role::where('slug', 'ROLE')->first();
$role->permissions->pluck('slug');

# Re-ejecutar seeders
php artisan db:seed --class=RolePermissionSeeder
```

### Los cambios no se aplican
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Ver errores en logs
```bash
tail -f storage/logs/laravel.log
```

## 📚 Documentación Completa

- **RESUMEN_IMPLEMENTACION_ROLES.md** - Resumen completo de cambios
- **SETUP_ROLES_PERMISSIONS.md** - Guía detallada de instalación
- **BLADE_DIRECTIVES_GUIDE.md** - Ejemplos de uso en vistas
- **ROLES_PERMISSIONS_GUIDE.md** - Documentación original

## 🎓 Ejemplos Comunes

### Menú de Navegación
```blade
<nav>
    @hasanyrole('super-admin', 'admin', 'project-coordinator')
        <a href="{{ route('projects.index') }}">Proyectos</a>
    @endhasanyrole
    
    @role('beneficiary')
        <a href="{{ route('projects.show', auth()->user()->beneficiary->project_id) }}">
            Mi Proyecto
        </a>
    @endrole
    
    @permission('users.view')
        <a href="{{ route('users.index') }}">Usuarios</a>
    @endpermission
</nav>
```

### Botones de Acción
```blade
<div class="actions">
    @can('update', $project)
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">
            Editar
        </a>
    @endcan
    
    @can('delete', $project)
        <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    @endcan
</div>
```

### Dashboard Condicional
```blade
@role('super-admin')
    @include('dashboards.admin')
@endrole

@role('beneficiary')
    @include('dashboards.beneficiary')
@endrole

@hasanyrole('project-coordinator', 'beneficiary-coordinator')
    @include('dashboards.coordinator')
@endhasanyrole
```

## ⚙️ Configuración Avanzada

### Crear Nuevo Permiso
```php
use App\Models\Permission;

Permission::create([
    'name' => 'Exportar Reportes',
    'slug' => 'reports.export',
    'description' => 'Puede exportar reportes del sistema',
    'module' => 'reports',
    'is_active' => true,
]);
```

### Asignar Permiso a Rol
```php
use App\Models\Role;
use App\Models\Permission;

$role = Role::where('slug', 'consultant')->first();
$permission = Permission::where('slug', 'reports.export')->first();
$role->permissions()->attach($permission->id);
```

### Crear Nuevo Rol
```php
use App\Models\Role;

$role = Role::create([
    'name' => 'Editor',
    'slug' => 'editor',
    'description' => 'Puede editar contenido',
    'is_active' => true,
    'sort_order' => 9,
]);
```

---

**💡 Tip:** Usa siempre `@can` con policies para verificaciones específicas de un modelo, y `@permission` para verificaciones generales.

