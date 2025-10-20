<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', 'Detalles del Usuario - ' . $user->full_name)
@section('page-title', 'Detalles del Usuario')
@section('page-description', 'Información completa del usuario: ' . $user->full_name)

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user me-2"></i>
                        Detalles del Usuario: {{ $user->full_name }}
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary me-2 custom">
                            <i class="fas fa-edit me-1"></i>
                            Editar Usuario
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary custom">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver a Usuarios
=======
@extends('layouts.app')

@section('title', 'User Details - ' . $user->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">User Details: {{ $user->full_name }}</h3>
                    <div>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- User Avatar and Basic Info -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" 
                                             alt="{{ $user->full_name }}" 
                                             class="rounded-circle mb-3" 
                                             width="120" height="120">
                                    @else
<<<<<<< HEAD
                                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                             style="width: 120px; height: 120px;">
=======
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                             style="width: 120px; height: 120px; font-size: 2rem;">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <h4>{{ $user->full_name }}</h4>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    
                                    <div class="mb-3">
<<<<<<< HEAD
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} me-2">
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                        @if($user->is_verified)
                                            <span class="badge bg-info">
                                                <i class="fas fa-check-circle me-1"></i> Verificado
=======
                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }} me-2">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if($user->is_verified)
                                            <span class="badge badge-info">
                                                <i class="fas fa-check-circle"></i> Verified
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-grid gap-2">
<<<<<<< HEAD
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary custom">
                                            <i class="fas fa-edit me-1"></i> Editar Usuario
                                        </a>
                                        <a href="{{ route('users.permissions', $user) }}" class="btn btn-warning custom">
                                            <i class="fas fa-key me-1"></i> Gestionar Permisos
=======
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit User
                                        </a>
                                        <a href="{{ route('users.permissions', $user) }}" class="btn btn-warning">
                                            <i class="fas fa-key"></i> Manage Permissions
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Details -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
<<<<<<< HEAD
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Información Básica
                                            </h5>
=======
                                            <h5 class="card-title mb-0">Basic Information</h5>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Nombre:</strong>
                                                    <p>{{ $user->first_name }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Apellido:</strong>
=======
                                                    <strong>First Name:</strong>
                                                    <p>{{ $user->first_name }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Last Name:</strong>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                    <p>{{ $user->last_name }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Correo Electrónico:</strong>
                                                    <p>{{ $user->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Teléfono:</strong>
                                                    <p>{{ $user->phone ?? 'No proporcionado' }}</p>
=======
                                                    <strong>Email:</strong>
                                                    <p>{{ $user->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Phone:</strong>
                                                    <p>{{ $user->phone ?? 'Not provided' }}</p>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Estado:</strong>
                                                    <p>
                                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
=======
                                                    <strong>Status:</strong>
                                                    <p>
                                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Verificado:</strong>
                                                    <p>
                                                        @if($user->is_verified)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i> Sí
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-times-circle me-1"></i> No
=======
                                                    <strong>Verified:</strong>
                                                    <p>
                                                        @if($user->is_verified)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Yes
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-times-circle"></i> No
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Último Acceso:</strong>
                                                    <p>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Miembro Desde:</strong>
                                                    <p>{{ $user->created_at->format('d/m/Y') }}</p>
=======
                                                    <strong>Last Login:</strong>
                                                    <p>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Member Since:</strong>
                                                    <p>{{ $user->created_at->format('M d, Y') }}</p>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Profile Information -->
                                @if($user->profile)
                                    <div class="col-12 mt-3">
                                        <div class="card">
                                            <div class="card-header">
<<<<<<< HEAD
                                                <h5 class="card-title mb-0">
                                                    <i class="fas fa-user-circle me-2"></i>
                                                    Información del Perfil
                                                </h5>
=======
                                                <h5 class="card-title mb-0">Profile Information</h5>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($user->profile->date_of_birth)
                                                        <div class="col-md-6">
<<<<<<< HEAD
                                                            <strong>Fecha de Nacimiento:</strong>
                                                            <p>{{ $user->profile->date_of_birth->format('d/m/Y') }} 
                                                               (Edad: {{ $user->profile->age ?? 'N/A' }} años)
=======
                                                            <strong>Date of Birth:</strong>
                                                            <p>{{ $user->profile->date_of_birth->format('M d, Y') }} 
                                                               (Age: {{ $user->profile->age }})
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if($user->profile->gender)
                                                        <div class="col-md-6">
<<<<<<< HEAD
                                                            <strong>Género:</strong>
=======
                                                            <strong>Gender:</strong>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                            <p>{{ ucfirst(str_replace('_', ' ', $user->profile->gender)) }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($user->profile->bio)
                                                    <div class="row">
                                                        <div class="col-12">
<<<<<<< HEAD
                                                            <strong>Biografía:</strong>
=======
                                                            <strong>Bio:</strong>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                            <p>{{ $user->profile->bio }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($user->profile->address || $user->profile->city || $user->profile->state)
                                                    <div class="row">
                                                        <div class="col-12">
<<<<<<< HEAD
                                                            <strong>Dirección:</strong>
                                                            <p>{{ $user->profile->full_address ?: 'No proporcionada' }}</p>
=======
                                                            <strong>Address:</strong>
                                                            <p>{{ $user->profile->full_address ?: 'Not provided' }}</p>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($user->profile->emergency_contact_name)
                                                    <div class="row">
                                                        <div class="col-md-4">
<<<<<<< HEAD
                                                            <strong>Contacto de Emergencia:</strong>
                                                            <p>{{ $user->profile->emergency_contact_name }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Teléfono de Contacto:</strong>
                                                            <p>{{ $user->profile->emergency_contact_phone }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Relación:</strong>
=======
                                                            <strong>Emergency Contact:</strong>
                                                            <p>{{ $user->profile->emergency_contact_name }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Contact Phone:</strong>
                                                            <p>{{ $user->profile->emergency_contact_phone }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Relationship:</strong>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                            <p>{{ $user->profile->emergency_contact_relationship }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Roles and Permissions -->
                                <div class="col-12 mt-3">
                                    <div class="card">
                                        <div class="card-header">
<<<<<<< HEAD
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                Roles y Permisos
                                            </h5>
=======
                                            <h5 class="card-title mb-0">Roles & Permissions</h5>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Roles Asignados:</strong>
                                                    <div class="mt-2">
                                                        @forelse($user->roles as $role)
                                                            <span class="badge bg-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} me-1 mb-1">
                                                                {{ $role->name }}
                                                            </span>
                                                        @empty
                                                            <span class="text-muted">No hay roles asignados</span>
=======
                                                    <strong>Assigned Roles:</strong>
                                                    <div class="mt-2">
                                                        @forelse($user->roles as $role)
                                                            <span class="badge badge-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} me-1 mb-1">
                                                                {{ $role->name }}
                                                            </span>
                                                        @empty
                                                            <span class="text-muted">No roles assigned</span>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
<<<<<<< HEAD
                                                    <strong>Total de Permisos:</strong>
                                                    <p>{{ $user->getAllPermissions()->count() }} permisos</p>
=======
                                                    <strong>Total Permissions:</strong>
                                                    <p>{{ $user->getAllPermissions()->count() }} permissions</p>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>
                                            
                                            @if($user->getAllPermissions()->count() > 0)
                                                <div class="row mt-3">
                                                    <div class="col-12">
<<<<<<< HEAD
                                                        <strong>Permisos por Módulo:</strong>
=======
                                                        <strong>Permissions by Module:</strong>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        <div class="mt-2">
                                                            @foreach($user->getAllPermissions()->groupBy('module') as $module => $permissions)
                                                                <div class="mb-2">
                                                                    <strong class="text-capitalize">{{ $module }}:</strong>
                                                                    <div class="mt-1">
                                                                        @foreach($permissions as $permission)
<<<<<<< HEAD
                                                                            <span class="badge bg-light text-dark me-1 mb-1">{{ $permission->name }}</span>
=======
                                                                            <span class="badge badge-light me-1 mb-1">{{ $permission->name }}</span>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
<<<<<<< HEAD
                                            @else
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Este usuario no tiene permisos específicos asignados.
                                                        </div>
                                                    </div>
                                                </div>
=======
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
<<<<<<< HEAD
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        border-radius: 0.375rem;
    }
    .card {
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.15s ease-in-out;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .card-header {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .card-body p {
        margin-bottom: 0.75rem;
        color: #495057;
    }
    .card-body strong {
        color: #212529;
        font-weight: 600;
    }
    .btn {
        border-radius: 0.375rem;
        font-weight: 500;
    }
    .avatar-placeholder {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        font-size: 2rem;
    }
    .text-muted {
        color: #6c757d !important;
=======
        font-size: 0.85em; /* Slightly larger for better readability */
        padding: 0.4em 0.6em;
    }
    .card {
        margin-bottom: 1.5rem; /* Increased spacing for better layout */
        border-radius: 0.5rem; /* Softer corners */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }
    .card-header {
        background-color: #f8f9fa; /* Light gray background for headers */
        font-weight: bold;
    }
    .card-body p {
        margin-bottom: 0.75rem; /* Increased spacing for better readability */
    }
    .btn {
        border-radius: 0.3rem; /* Consistent button styling */
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
    }
</style>
@endpush
