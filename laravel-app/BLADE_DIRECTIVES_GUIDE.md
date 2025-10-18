# Guía de Directivas de Blade para Permisos y Roles

Este documento explica cómo usar las directivas personalizadas de Blade para controlar el acceso a elementos de la interfaz según los roles y permisos del usuario.

## Directivas Disponibles

### @role()
Verifica si el usuario tiene un rol específico.

```blade
@role('super-admin')
    <a href="{{ route('users.index') }}">Gestionar Usuarios</a>
@endrole

@role('beneficiary')
    <p>Bienvenido, este es tu panel de beneficiario</p>
@endrole
```

### @hasanyrole()
Verifica si el usuario tiene cualquiera de los roles especificados.

```blade
@hasanyrole('super-admin', 'admin', 'project-coordinator')
    <a href="{{ route('projects.create') }}">Crear Proyecto</a>
@endhasanyrole
```

### @permission()
Verifica si el usuario tiene un permiso específico.

```blade
@permission('users.create')
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        Nuevo Usuario
    </a>
@endpermission

@permission('projects.edit')
    <button class="btn btn-warning">Editar</button>
@endpermission
```

### @hasanypermission()
Verifica si el usuario tiene cualquiera de los permisos especificados.

```blade
@hasanypermission('projects.view', 'projects.view.own')
    <a href="{{ route('projects.index') }}">Ver Proyectos</a>
@endhasanypermission
```

## Uso con @can (Policies)

También puedes usar las directivas de Laravel para verificar políticas:

```blade
@can('update', $project)
    <a href="{{ route('projects.edit', $project) }}">Editar</a>
@endcan

@can('delete', $beneficiary)
    <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
@endcan
```

## Ejemplos Completos

### Menú de Navegación

```blade
<nav>
    <ul>
        @hasanyrole('super-admin', 'admin', 'project-coordinator')
            <li>
                <a href="{{ route('projects.index') }}">Proyectos</a>
            </li>
        @endhasanyrole

        @hasanyrole('super-admin', 'admin', 'beneficiary-coordinator')
            <li>
                <a href="{{ route('beneficiaries.index') }}">Beneficiarios</a>
            </li>
        @endhasanyrole

        @role('beneficiary')
            <li>
                <a href="{{ route('beneficiaries.show', auth()->user()->beneficiary) }}">
                    Mis Beneficios
                </a>
            </li>
        @endrole

        @permission('users.view')
            <li>
                <a href="{{ route('users.index') }}">Usuarios</a>
            </li>
        @endpermission
    </ul>
</nav>
```

### Tabla con Acciones Condicionales

```blade
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            @hasanypermission('projects.edit', 'projects.delete')
                <th>Acciones</th>
            @endhasanypermission
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->nombre }}</td>
                <td>{{ $project->descripcion }}</td>
                @hasanypermission('projects.edit', 'projects.delete')
                    <td>
                        @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}">Editar</a>
                        @endcan
                        
                        @can('delete', $project)
                            <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        @endcan
                    </td>
                @endhasanypermission
            </tr>
        @endforeach
    </tbody>
</table>
```

### Panel de Dashboard según Rol

```blade
<div class="dashboard">
    @role('super-admin')
        <div class="admin-panel">
            <h2>Panel de Administrador</h2>
            <!-- Widgets administrativos -->
        </div>
    @endrole

    @role('beneficiary')
        <div class="beneficiary-panel">
            <h2>Mi Panel</h2>
            <p>Proyecto asignado: {{ auth()->user()->beneficiary->project->nombre ?? 'N/A' }}</p>
            <!-- Información del beneficiario -->
        </div>
    @endrole

    @hasanyrole('project-coordinator', 'beneficiary-coordinator')
        <div class="coordinator-panel">
            <h2>Panel de Coordinación</h2>
            <!-- Widgets de coordinador -->
        </div>
    @endhasanyrole
</div>
```

## Roles Disponibles en el Sistema

- `super-admin` - Super Administrador (acceso completo)
- `admin` - Administrador
- `project-coordinator` - Coordinador de Proyectos
- `beneficiary-coordinator` - Coordinador de Beneficiarios
- `volunteer` - Voluntario
- `consultant` - Consultor
- `donor` - Donante
- `beneficiary` - Beneficiario (acceso limitado)

## Permisos Comunes

### Usuarios
- `users.view` - Ver lista de usuarios
- `users.create` - Crear usuarios
- `users.edit` - Editar usuarios
- `users.delete` - Eliminar usuarios

### Proyectos
- `projects.view` - Ver todos los proyectos
- `projects.view.own` - Ver solo proyectos asignados (beneficiarios)
- `projects.create` - Crear proyectos
- `projects.edit` - Editar proyectos
- `projects.delete` - Eliminar proyectos

### Beneficiarios
- `beneficiaries.view` - Ver lista de beneficiarios
- `beneficiaries.create` - Crear beneficiarios
- `beneficiaries.edit` - Editar beneficiarios
- `beneficiaries.delete` - Eliminar beneficiarios
- `benefits.view.own` - Ver solo beneficios propios

### Perfil
- `profile.view.own` - Ver perfil propio
- `profile.edit.own` - Editar perfil propio

## Notas Importantes

1. El `super-admin` siempre tiene acceso a todo, incluso sin permisos específicos.
2. Los beneficiarios solo pueden ver proyectos a los que están asignados.
3. Usa `@can` con policies para verificaciones más complejas.
4. Combina roles y permisos para un control granular del acceso.

