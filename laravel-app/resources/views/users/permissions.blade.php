@extends('layouts.tabler')

@section('title', 'Permisos del Usuario - ' . $user->full_name)
@section('page-title', 'Gestionar Permisos')
@section('page-description', 'Asignar permisos al usuario: ' . $user->full_name)

@section('content')
<div class="container-fluid">
    <!-- Navegación -->
    <x-head-admin />
    <!-- Fin Navegación -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gestionar Permisos: {{ $user->full_name }}</h3>
                    <div>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info me-2">
                            <i class="fas fa-user"></i> Ver Usuario
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Usuarios
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('users.update-permissions', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información del Usuario -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h5 class="alert-heading">Información del Usuario</h5>
                                    <p class="mb-1"><strong>Nombre:</strong> {{ $user->full_name }}</p>
                                    <p class="mb-1"><strong>Correo:</strong> {{ $user->email }}</p>
                                    <p class="mb-0"><strong>Roles Actuales:</strong> 
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} me-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Permisos por Módulo -->
                        <div class="row">
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0 text-capitalize">
                                                Permisos de {{ $module }}
                                                <span class="badge badge-secondary float-right">
                                                    {{ $modulePermissions->count() }} permisos
                                                </span>
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mb-2">
                                                    <input type="checkbox" 
                                                           class="custom-control-input" 
                                                           id="select_all_{{ $module }}" 
                                                           onchange="toggleModulePermissions('{{ $module }}', this.checked)">
                                                    <label class="custom-control-label font-weight-bold" for="select_all_{{ $module }}">
                                                        Seleccionar todos los permisos de {{ ucfirst($module) }}
                                                    </label>
                                                </div>
                                                
                                                <hr>
                                                
                                                @foreach($modulePermissions as $permission)
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" 
                                                               class="custom-control-input module-{{ $module }}" 
                                                               id="permission_{{ $permission->id }}" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}"
                                                               {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}
                                                               onchange="updateSelectAll('{{ $module }}')">
                                                        <label class="custom-control-label" for="permission_{{ $permission->id }}">
                                                            <strong>{{ $permission->name }}</strong>
                                                            @if($permission->description)
                                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Información de permisos por rol -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Permisos basados en Roles</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-info-circle"></i>
                                            <strong>Nota:</strong> El usuario también posee permisos a través de los roles asignados. 
                                            Los permisos directos se sumarán a los permisos heredados del rol.
                                        </div>
                                        
                                        @if($user->roles->count() > 0)
                                            <div class="row">
                                                @foreach($user->roles as $role)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title mb-0">{{ $role->name }}</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                @if($role->permissions->count() > 0)
                                                                    @foreach($role->permissions->groupBy('module') as $module => $permissions)
                                                                        <div class="mb-2">
                                                                            <strong class="text-capitalize">{{ $module }}:</strong>
                                                                            <div class="mt-1">
                                                                                @foreach($permissions as $permission)
                                                                                    <span class="badge badge-info me-1 mb-1">{{ $permission->name }}</span>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <p class="text-muted mb-0">Este rol no tiene permisos asignados.</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Este usuario no tiene roles asignados.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary me-2">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Permisos
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleModulePermissions(module, checked) {
    const checkboxes = document.querySelectorAll(`.module-${module}`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = checked;
    });
}

function updateSelectAll(module) {
    const checkboxes = document.querySelectorAll(`.module-${module}`);
    const selectAllCheckbox = document.getElementById(`select_all_${module}`);
    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
    
    if (checkedCount === 0) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
    } else if (checkedCount === checkboxes.length) {
        selectAllCheckbox.checked = true;
        selectAllCheckbox.indeterminate = false;
    } else {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = true;
    }
}

// Inicializar checkboxes de "Seleccionar todo" al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    @foreach($permissions as $module => $modulePermissions)
        updateSelectAll('{{ $module }}');
    @endforeach
});
</script>
@endpush

@push('styles')
<style>
    .badge {
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
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .alert {
        border-radius: 0.5rem;
        padding: 1rem;
    }
</style>
@endpush
