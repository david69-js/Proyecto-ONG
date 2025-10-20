<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'Gestión de Usuarios')
@section('page-description', 'Administrar usuarios del sistema')

@section('page-actions')
@permission('users.create')
<a href="{{ route('users.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Agregar Nuevo Usuario
</a>
@endpermission
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Filtros de Búsqueda</h3>
            </div>
=======
@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gestión de Usuarios</h3>
                    @permission('users.create')
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Agregar Nuevo Usuario
                    </a>
                    @endpermission
                </div>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                
                <div class="card-body">
                    <!-- Formulario de búsqueda y filtros -->
                    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search">Buscar</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="search" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Buscar por nombre o correo...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="role">Rol</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="">Todos los roles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->slug }}" 
                                                    {{ request('role') == $role->slug ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Estado</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Todos los estados</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Limpiar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de usuarios -->
                    <div class="table-responsive">
<<<<<<< HEAD
                        <table class="table table-vcenter card-table">
                            <thead>
=======
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Roles</th>
                                    <th>Estado</th>
                                    <th>Último acceso</th>
<<<<<<< HEAD
                                    <th class="w-1">Acciones</th>
=======
                                    <th>Acciones</th>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar }}" 
                                                         alt="{{ $user->full_name }}" 
                                                         class="rounded-circle me-2" 
                                                         width="32" height="32">
                                                @else
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                         style="width: 32px; height: 32px;">
                                                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $user->full_name }}</strong>
                                                    @if($user->is_verified)
                                                        <i class="fas fa-check-circle text-success ms-1" title="Verificado"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
<<<<<<< HEAD
                                                <span class="badge bg-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} text-white">
=======
                                                <span class="badge badge-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }}">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
<<<<<<< HEAD
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} text-white">
=======
                                            <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->diffForHumans() }}
                                            @else
                                                Nunca
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @can('view', $user)
                                                <a href="{{ route('users.show', $user) }}" 
<<<<<<< HEAD
                                                   class="btn btn-sm btn-outline-primary" 
=======
                                                   class="btn btn-sm btn-outline-info" 
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                   title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @endcan
                                                
                                                @can('update', $user)
                                                <a href="{{ route('users.edit', $user) }}" 
<<<<<<< HEAD
                                                   class="btn btn-sm btn-outline-warning" 
=======
                                                   class="btn btn-sm btn-outline-primary" 
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                
                                                @can('managePermissions', $user)
                                                <a href="{{ route('users.permissions', $user) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Permisos">
                                                    <i class="fas fa-key"></i>
                                                </a>
                                                @endcan
                                                
                                                @can('update', $user)
                                                <form action="{{ route('users.toggle-status', $user) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Seguro que deseas {{ $user->is_active ? 'desactivar' : 'activar' }} este usuario?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                            title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                                
                                                @can('delete', $user)
                                                <form action="{{ route('users.destroy', $user) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3"></i>
                                                <p>No se encontraron usuarios.</p>
                                                @permission('users.create')
                                                <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Primer Usuario</a>
                                                @endpermission
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($users->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======
</div>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
@endsection

@push('styles')
<style>
    .badge {
<<<<<<< HEAD
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.375rem 0.75rem;
    }
    .btn-group .btn {
        margin-right: 0.25rem;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
=======
        font-size: 0.85em;
        padding: 0.4em 0.6em;
    }
    .card {
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .btn {
        border-radius: 0.3rem;
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
    }
    .table th, .table td {
        vertical-align: middle;
    }
<<<<<<< HEAD
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }
=======
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
</style>
@endpush
