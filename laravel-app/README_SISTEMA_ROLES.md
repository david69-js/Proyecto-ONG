# 🎯 Sistema de Roles y Permisos - Implementado

## ✅ ¿Qué se implementó?

Se ha implementado un **sistema completo de control de acceso basado en roles (RBAC)** que resuelve tu problema:

### El Problema Original
> "supongamos que super admin y un beneficiario no pueden ver las mismas vistas o tener los mismos permisos, ejemplo que beneficiarios, solo pueda ver a que proyecto está asignado o beneficio y que no pueda ver quizá /users o /projects(o quizá si pero solo al proyectos asignado)"

### ✅ Solución Implementada

Ahora **cada rol tiene permisos específicos** y los usuarios **solo ven lo que les corresponde**:

#### 🔐 Super Admin
- ✅ Acceso completo a TODO

#### 👤 Beneficiario (NUEVO ROL)
- ✅ Puede ver **SOLO su proyecto asignado**
- ✅ Puede ver y editar **SOLO su perfil**
- ❌ **NO** puede ver `/users`
- ❌ **NO** puede ver todos los `/projects` (solo el suyo)
- ❌ **NO** puede ver otros beneficiarios
- ❌ **NO** puede crear ni editar nada

## 🚀 Instalación en 30 Segundos

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

## 📝 Ejemplo Práctico

### Crear un Beneficiario

```bash
php artisan tinker
```

```php
// 1. Crear usuario
$user = \App\Models\User::create([
    'first_name' => 'María',
    'last_name' => 'González',
    'email' => 'maria@example.com',
    'password' => \Hash::make('password123'),
    'is_active' => true,
]);

// 2. Asignar rol beneficiario
$user->assignRole('beneficiary');

// 3. Vincular con un proyecto
$beneficiary = \App\Models\Beneficiary::create([
    'user_id' => $user->id,
    'name' => 'María González',
    'email' => 'maria@example.com',
    'project_id' => 1, // Solo verá este proyecto
    'status' => 'active',
]);
```

### ¿Qué puede hacer María?

```php
// ✅ Ver su proyecto
GET /projects/1          → Permitido
GET /projects            → Solo ve proyecto #1

// ✅ Ver y editar su perfil
GET /users/X/edit        → Solo si X = ID de María

// ❌ NO puede ver otros proyectos
GET /projects/2          → Error 403

// ❌ NO puede ver usuarios
GET /users               → Error 403

// ❌ NO puede crear nada
GET /projects/create     → Error 403
```

## 🎨 Usar en tus Vistas

En tus archivos `.blade.php`:

```blade
{{-- Solo super-admin y admin ven esto --}}
@hasanyrole('super-admin', 'admin')
    <a href="{{ route('users.index') }}">Gestionar Usuarios</a>
@endhasanyrole

{{-- Solo quien pueda crear proyectos ve esto --}}
@permission('projects.create')
    <a href="{{ route('projects.create') }}">Crear Proyecto</a>
@endpermission

{{-- Beneficiarios ven esto --}}
@role('beneficiary')
    <p>Tu proyecto: {{ auth()->user()->beneficiary->project->nombre }}</p>
@endrole

{{-- Verificar si puede editar un proyecto específico --}}
@can('update', $project)
    <a href="{{ route('projects.edit', $project) }}">Editar</a>
@endcan
```

## 📊 ¿Cómo Funciona?

### 1. En los Controladores
Los controladores verifican permisos automáticamente:

```php
// ProjectController@index
public function index()
{
    // Verifica si puede ver proyectos
    $this->authorize('viewAny', Project::class);
    
    // Filtra según el rol:
    // - Super Admin/Admin: Ve TODOS
    // - Beneficiario: Ve SOLO su proyecto
    $query = Project::with('responsable');
    $projects = ProjectPolicy::scopeForUser(auth()->user(), $query)->get();
    
    return view('projects.index', compact('projects'));
}
```

### 2. En las Vistas
Las vistas muestran/ocultan elementos según permisos:

```blade
@permission('projects.create')
    <a href="{{ route('projects.create') }}">Crear Proyecto</a>
@endpermission
```

### 3. En las Rutas
Las rutas están protegidas con middleware:

```php
Route::get('/users', [UserController::class, 'index'])
    ->middleware('permission:users.view');
```

## 📚 Documentación Completa

- **GUIA_RAPIDA_ROLES.md** ⭐ - Empieza aquí
- **RESUMEN_IMPLEMENTACION_ROLES.md** - Detalles de lo implementado
- **BLADE_DIRECTIVES_GUIDE.md** - Cómo usar en vistas
- **SETUP_ROLES_PERMISSIONS.md** - Instalación detallada

## 🎭 Todos los Roles

| Rol | Slug | Acceso |
|-----|------|--------|
| Super Administrador | `super-admin` | Todo ✅ |
| Administrador | `admin` | Casi todo (no gestión de roles) |
| Coordinador de Proyectos | `project-coordinator` | Proyectos y beneficiarios |
| Coordinador de Beneficiarios | `beneficiary-coordinator` | Gestión de beneficiarios |
| Voluntario | `volunteer` | Solo lectura |
| Consultor | `consultant` | Solo lectura + reportes |
| Donante | `donor` | Ver proyectos y reportes |
| **Beneficiario** ⭐ | `beneficiary` | Solo sus datos |

## 🔍 Verificar que Funciona

```bash
php artisan tinker
```

```php
// Ver todos los roles
\App\Models\Role::all(['name', 'slug']);

// Ver permisos del beneficiario
$role = \App\Models\Role::where('slug', 'beneficiary')->first();
$role->permissions->pluck('name', 'slug');

// Resultado esperado:
// [
//   'profile.view.own' => 'Ver Perfil Propio',
//   'profile.edit.own' => 'Editar Perfil Propio',
//   'projects.view.own' => 'Ver Solo Proyectos Asignados',
//   'benefits.view.own' => 'Ver Beneficios Propios'
// ]
```

## 💡 Casos de Uso Resueltos

### ✅ Beneficiario solo ve su proyecto
```php
$beneficiario = User::find(X); // Usuario con rol 'beneficiary'
$proyectos = $beneficiario->getProyectos(); 
// Retorna SOLO el proyecto asignado (project_id en tabla beneficiaries)
```

### ✅ Super Admin ve todo
```php
$superAdmin = User::find(Y); // Usuario con rol 'super-admin'
$proyectos = $superAdmin->getProyectos();
// Retorna TODOS los proyectos
```

### ✅ Beneficiario NO puede ver /users
```php
// Intenta acceder
GET /users

// La policy verifica:
// - ¿Tiene 'users.view'? No
// - Resultado: Error 403 "No tienes permisos"
```

## 🐛 Solución de Problemas

### Error: "This action is unauthorized"

```bash
# 1. Verificar rol del usuario
php artisan tinker
$user = \App\Models\User::where('email', 'EMAIL')->first();
$user->roles->pluck('slug');

# 2. Verificar permisos del rol
$role = \App\Models\Role::where('slug', 'SLUG')->first();
$role->permissions->pluck('slug');

# 3. Re-ejecutar seeders si es necesario
php artisan db:seed --class=RolePermissionSeeder
```

### Los cambios no se aplican

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## 🎯 Resumen de Archivos Modificados/Creados

### ✅ Creados (9 archivos)
- `app/Policies/ProjectPolicy.php`
- `app/Policies/UserPolicy.php`
- `app/Policies/BeneficiaryPolicy.php`
- `app/Policies/LocationPolicy.php`
- `database/migrations/2025_10_10_000001_add_user_id_to_beneficiaries_table.php`
- `RESUMEN_IMPLEMENTACION_ROLES.md`
- `BLADE_DIRECTIVES_GUIDE.md`
- `SETUP_ROLES_PERMISSIONS.md`
- `GUIA_RAPIDA_ROLES.md`

### ✅ Modificados (11 archivos)
- `database/seeders/RoleSeeder.php` (+ rol Beneficiario)
- `database/seeders/PermissionSeeder.php` (+ 4 permisos)
- `database/seeders/RolePermissionSeeder.php` (+ asignación beneficiario)
- `app/Models/User.php` (+ relación beneficiary)
- `app/Models/Beneficiary.php` (+ relación user y project)
- `app/Models/Project.php` (+ relación beneficiaries)
- `app/Providers/AppServiceProvider.php` (+ policies + directivas Blade)
- `app/Http/Controllers/ProjectController.php` (+ autorización)
- `app/Http/Controllers/UserController.php` (+ autorización)
- `app/Http/Controllers/BeneficiaryController.php` (+ autorización)
- `app/Http/Controllers/LocationController.php` (+ autorización)

## ✨ Próximos Pasos Recomendados

1. **Ejecutar la instalación** (setup-roles.bat / setup-roles.sh)
2. **Crear un usuario de prueba** con rol beneficiario
3. **Actualizar las vistas** para usar las nuevas directivas
4. **Probar el sistema** con diferentes roles

---

**🎉 Tu problema está resuelto!** Ahora cada usuario solo ve lo que le corresponde según su rol.

