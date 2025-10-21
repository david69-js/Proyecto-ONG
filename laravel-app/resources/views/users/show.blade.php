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
                                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                                             alt="{{ $user->full_name }}" 
                                             class="rounded-circle mb-3" 
                                             width="120" height="120"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                             style="width: 120px; height: 120px;">
                                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <h4>{{ $user->full_name }}</h4>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} me-2">
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                        @if($user->is_verified)
                                            <span class="badge bg-info">
                                                <i class="fas fa-check-circle me-1"></i> Verificado
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary custom">
                                            <i class="fas fa-edit me-1"></i> Editar Usuario
                                        </a>
                                        <a href="{{ route('users.permissions', $user) }}" class="btn btn-warning custom">
                                            <i class="fas fa-key me-1"></i> Gestionar Permisos
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
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Información Básica
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Nombre:</strong>
                                                    <p>{{ $user->first_name }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Apellido:</strong>
                                                    <p>{{ $user->last_name }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Correo Electrónico:</strong>
                                                    <p>{{ $user->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Teléfono:</strong>
                                                    <p>{{ $user->phone ?? 'No proporcionado' }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Estado:</strong>
                                                    <p>
                                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Verificado:</strong>
                                                    <p>
                                                        @if($user->is_verified)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i> Sí
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-times-circle me-1"></i> No
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Último Acceso:</strong>
                                                    <p>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Miembro Desde:</strong>
                                                    <p>{{ $user->created_at->format('d/m/Y') }}</p>
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
                                                <h5 class="card-title mb-0">
                                                    <i class="fas fa-user-circle me-2"></i>
                                                    Información del Perfil
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($user->profile->date_of_birth)
                                                        <div class="col-md-6">
                                                            <strong>Fecha de Nacimiento:</strong>
                                                            <p>{{ $user->profile->date_of_birth->format('d/m/Y') }} 
                                                               (Edad: {{ $user->profile->age ?? 'N/A' }} años)
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if($user->profile->gender)
                                                        <div class="col-md-6">
                                                            <strong>Género:</strong>
                                                            <p>{{ ucfirst(str_replace('_', ' ', $user->profile->gender)) }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if($user->profile->bio)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Biografía:</strong>
                                                            <p>{{ $user->profile->bio }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($user->profile->address || $user->profile->city || $user->profile->state)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Dirección:</strong>
                                                            <p>{{ $user->profile->full_address ?: 'No proporcionada' }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($user->profile->emergency_contact_name)
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Contacto de Emergencia:</strong>
                                                            <p>{{ $user->profile->emergency_contact_name }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Teléfono de Contacto:</strong>
                                                            <p>{{ $user->profile->emergency_contact_phone }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>Relación:</strong>
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
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                Roles y Permisos
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Roles Asignados:</strong>
                                                    <div class="mt-2">
                                                        @forelse($user->roles as $role)
                                                            <span class="badge bg-{{ $role->slug === 'super_admin' ? 'danger' : ($role->slug === 'admin' ? 'warning' : ($role->slug === 'coordinator' ? 'info' : 'secondary')) }} me-1 mb-1">
                                                                {{ $role->name }}
                                                            </span>
                                                        @empty
                                                            <span class="text-muted">No hay roles asignados</span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Total de Permisos:</strong>
                                                    <p>{{ $user->getAllPermissions()->count() }} permisos</p>
                                                </div>
                                            </div>
                                            
                                            @if($user->getAllPermissions()->count() > 0)
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <strong>Permisos por Módulo:</strong>
                                                        <div class="mt-2">
                                                            @foreach($user->getAllPermissions()->groupBy('module') as $module => $permissions)
                                                                <div class="mb-2">
                                                                    <strong class="text-capitalize">{{ $module }}:</strong>
                                                                    <div class="mt-1">
                                                                        @foreach($permissions as $permission)
                                                                            <span class="badge bg-light text-dark me-1 mb-1">{{ $permission->name }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Este usuario no tiene permisos específicos asignados.
                                                        </div>
                                                    </div>
                                                </div>
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
    }
</style>
@endpush
