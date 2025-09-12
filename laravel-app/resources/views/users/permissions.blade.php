@extends('layouts.app')

@section('title', 'User Permissions - ' . $user->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Manage Permissions: {{ $user->full_name }}</h3>
                    <div>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info me-2">
                            <i class="fas fa-user"></i> View User
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('users.update-permissions', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- User Info -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h5 class="alert-heading">User Information</h5>
                                    <p class="mb-1"><strong>Name:</strong> {{ $user->full_name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                    <p class="mb-0"><strong>Current Roles:</strong> 
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} me-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Permissions by Module -->
                        <div class="row">
                            @foreach($permissions as $module => $modulePermissions)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0 text-capitalize">
                                                {{ $module }} Permissions
                                                <span class="badge badge-secondary float-right">
                                                    {{ $modulePermissions->count() }} permissions
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
                                                        Select All {{ ucfirst($module) }} Permissions
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
                        
                        <!-- Role-based Permissions Info -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Role-based Permissions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-info-circle"></i>
                                            <strong>Note:</strong> The user also has permissions through their assigned roles. 
                                            Direct permission assignments will be added to role-based permissions.
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
                                                                    <p class="text-muted mb-0">No permissions assigned to this role.</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No roles assigned to this user.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Permissions
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

// Initialize select all checkboxes on page load
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
        font-size: 0.75em;
    }
    .card {
        margin-bottom: 1rem;
    }
    .custom-control-label {
        cursor: pointer;
    }
    .alert {
        border-left: 4px solid #007bff;
    }
    .alert-warning {
        border-left-color: #ffc107;
    }
    .alert-info {
        border-left-color: #17a2b8;
    }
</style>
@endpush
