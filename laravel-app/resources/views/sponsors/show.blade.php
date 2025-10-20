<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', 'Detalles del Patrocinador')
@section('page-title', 'Detalles del Patrocinador')
@section('page-description', 'Información completa del patrocinador seleccionado')

@section('content')
<div class="container-xl">
=======
@extends('layouts.app')

@section('title', 'Detalles del Patrocinador')
@section('header', 'Detalles del Patrocinador')

@section('content')
<div class="container-fluid">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
    <div class="row">
        <div class="col-12">
            <!-- Card principal -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
<<<<<<< HEAD
                        <i class="fas fa-handshake me-2"></i>
                        {{ $sponsor->name }}
                    </h3>
                    <div class="card-actions">
                        @permission('sponsors.edit')
                        <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-outline-warning" title="Editar patrocinador">
                            <i class="fas fa-edit me-1"></i>
                            Editar
                        </a>
                        @endpermission
                        <a href="{{ route('sponsors.index') }}" class="btn btn-outline-secondary" title="Volver a la lista">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
=======
                        <i class="fas fa-handshake mr-2"></i>
                        {{ $sponsor->name }}
                    </h3>
                    <div class="card-tools">
                        @permission('sponsors.edit')
                        <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-tool" data-toggle="tooltip" title="Editar patrocinador">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endpermission
                        <a href="{{ route('sponsors.index') }}" class="btn btn-tool" data-toggle="tooltip" title="Volver a la lista">
                            <i class="fas fa-arrow-left"></i>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                        </a>
                    </div>
                </div>

                <div class="card-body">
<<<<<<< HEAD
                    <!-- Información Principal -->
                    <div class="row g-4">
                        <div class="col-12">
                            <!-- Información Básica -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle me-2"></i>
=======
                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-12 col-lg-8">
                            <!-- Información Básica -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle mr-2"></i>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                        Información Básica
                                    </h3>
                                </div>
                                <div class="card-body">
<<<<<<< HEAD
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md bg-primary text-white">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Nombre</div>
                                                            <div class="fw-bold h5 mb-0">{{ $sponsor->name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @if($sponsor->company_name)
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md bg-info text-white">
                                                                <i class="fas fa-building"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Empresa</div>
                                                            <div class="fw-bold h6 mb-0">{{ $sponsor->company_name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @if($sponsor->contact_person)
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md bg-success text-white">
                                                                <i class="fas fa-user-tie"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Contacto</div>
                                                            <div class="fw-bold h6 mb-0">{{ $sponsor->contact_person }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md bg-warning text-white">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Email</div>
                                                            <div>
                                                                <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none fw-bold h6 mb-0">
                                                                    {{ $sponsor->email }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @if($sponsor->phone)
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md bg-danger text-white">
                                                                <i class="fas fa-phone"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Teléfono</div>
                                                            <div>
                                                                <a href="tel:{{ $sponsor->phone }}" class="text-decoration-none fw-bold h6 mb-0">
                                                                    {{ $sponsor->phone }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @if($sponsor->website)
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md bg-secondary text-white">
                                                                <i class="fas fa-globe"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Sitio Web</div>
                                                            <div>
                                                                <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="text-decoration-none fw-bold h6 mb-0">
                                                                    {{ $sponsor->website }}
                                                                    <i class="fas fa-external-link-alt ms-1"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información del Sistema -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-cogs me-2"></i>
                                        Información del Sistema
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <div class="avatar avatar-md bg-info text-white">
                                                        <i class="fas fa-tag"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Tipo</div>
                                                    <div class="fw-bold h6 mb-0">
                                                        <span class="badge bg-info">{{ $sponsor->sponsor_type_formatted }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    @php
                                                        $statusClasses = [
                                                            'active' => 'bg-success',
                                                            'inactive' => 'bg-secondary',
                                                            'pending' => 'bg-warning',
                                                            'suspended' => 'bg-danger'
                                                        ];
                                                    @endphp
                                                    <div class="avatar avatar-md {{ $statusClasses[$sponsor->status] ?? 'bg-secondary' }} text-white">
                                                        <i class="fas fa-power-off"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Estado</div>
                                                    <div class="fw-bold h6 mb-0">
                                                        <span class="badge {{ $statusClasses[$sponsor->status] ?? 'bg-secondary' }}">
                                                            {{ $sponsor->status_formatted }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <div class="avatar avatar-md bg-primary text-white">
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Prioridad</div>
                                                    <div class="fw-bold h6 mb-0">
                                                        <span class="badge bg-primary">{{ $sponsor->priority_level }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($sponsor->is_featured)
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <div class="avatar avatar-md bg-warning text-white">
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Destacado</div>
                                                    <div class="fw-bold h6 mb-0">
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-star me-1"></i> Sí
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
=======
                                    <!-- Vista de escritorio -->
                                    <div class="d-none d-md-block">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="text-muted"><strong>Nombre:</strong></td>
                                                        <td>{{ $sponsor->name }}</td>
                                                    </tr>
                                                        @if($sponsor->company_name)
                                                    <tr>
                                                        <td class="text-muted"><strong>Empresa:</strong></td>
                                                        <td>{{ $sponsor->company_name }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($sponsor->contact_person)
                                                    <tr>
                                                        <td class="text-muted"><strong>Contacto:</strong></td>
                                                        <td>{{ $sponsor->contact_person }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="text-muted"><strong>Email:</strong></td>
                                                        <td>
                                                            <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none">
                                                                {{ $sponsor->email }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @if($sponsor->phone)
                                                    <tr>
                                                        <td class="text-muted"><strong>Teléfono:</strong></td>
                                                        <td>
                                                            <a href="tel:{{ $sponsor->phone }}" class="text-decoration-none">
                                                                {{ $sponsor->phone }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="text-muted"><strong>Tipo:</strong></td>
                                                        <td>
                                                            <span class="badge badge-info">{{ $sponsor->sponsor_type_formatted }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted"><strong>Estado:</strong></td>
                                                        <td>
                                                            @php
                                                                $statusClasses = [
                                                                    'active' => 'badge-success',
                                                                    'inactive' => 'badge-secondary',
                                                                    'pending' => 'badge-warning',
                                                                    'suspended' => 'badge-danger'
                                                                ];
                                                            @endphp
                                                            <span class="badge {{ $statusClasses[$sponsor->status] ?? 'badge-secondary' }}">
                                                                {{ $sponsor->status_formatted }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted"><strong>Prioridad:</strong></td>
                                                        <td>
                                                            <span class="badge badge-primary">{{ $sponsor->priority_level }}</span>
                                                        </td>
                                                    </tr>
                                                    @if($sponsor->is_featured)
                                                    <tr>
                                                        <td class="text-muted"><strong>Destacado:</strong></td>
                                                        <td>
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-star"></i> Sí
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if($sponsor->website)
                                                    <tr>
                                                        <td class="text-muted"><strong>Sitio Web:</strong></td>
                                                        <td>
                                                            <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="text-decoration-none">
                                                                {{ $sponsor->website }}
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

                                    <!-- Vista móvil -->
                                    <div class="d-md-none">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Nombre</h6>
                                                        <p class="mb-0">{{ $sponsor->name }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($sponsor->company_name)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Empresa</h6>
                                                        <p class="mb-0">{{ $sponsor->company_name }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($sponsor->contact_person)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Contacto</h6>
                                                        <p class="mb-0">{{ $sponsor->contact_person }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Email</h6>
                                                        <p class="mb-0">
                                                            <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none">
                                                                {{ $sponsor->email }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($sponsor->phone)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Teléfono</h6>
                                                        <p class="mb-0">
                                                            <a href="tel:{{ $sponsor->phone }}" class="text-decoration-none">
                                                                {{ $sponsor->phone }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Tipo</h6>
                                                    </div>
<<<<<<< HEAD
                                                    <span class="badge bg-info">{{ $sponsor->sponsor_type_formatted }}</span>
=======
                                                    <span class="badge badge-info">{{ $sponsor->sponsor_type_formatted }}</span>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>

                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Estado</h6>
                                                    </div>
<<<<<<< HEAD
                                                    <span class="badge {{ $statusClasses[$sponsor->status] ?? 'bg-secondary' }}">
=======
                                                    <span class="badge {{ $statusClasses[$sponsor->status] ?? 'badge-secondary' }}">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        {{ $sponsor->status_formatted }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Prioridad</h6>
                                                    </div>
<<<<<<< HEAD
                                                    <span class="badge bg-primary">{{ $sponsor->priority_level }}</span>
=======
                                                    <span class="badge badge-primary">{{ $sponsor->priority_level }}</span>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>

                                            @if($sponsor->is_featured)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Destacado</h6>
                                                    </div>
<<<<<<< HEAD
                                                    <span class="badge bg-warning">
=======
                                                    <span class="badge badge-warning">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        <i class="fas fa-star"></i> Sí
                                                    </span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($sponsor->website)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-primary">Sitio Web</h6>
                                                        <p class="mb-0">
                                                            <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="text-decoration-none">
                                                                {{ $sponsor->website }}
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($sponsor->address)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <strong class="text-primary">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                Dirección:
                                            </strong>
                                            <p class="text-muted mb-0">{{ $sponsor->address }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Información de Patrocinio -->
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-coins mr-2"></i>
                                        Información de Patrocinio
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Vista de escritorio -->
                                    <div class="d-none d-md-block">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="text-muted"><strong>Tipo de Contribución:</strong></td>
                                                        <td>
<<<<<<< HEAD
                                                            <span class="badge bg-success">{{ $sponsor->contribution_type_formatted }}</span>
=======
                                                            <span class="badge badge-success">{{ $sponsor->contribution_type_formatted }}</span>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                        </td>
                                                    </tr>
                                                    @if($sponsor->contribution_amount)
                                                    <tr>
                                                        <td class="text-muted"><strong>Monto:</strong></td>
                                                        <td>
                                                            <span class="h5 text-success">Q{{ number_format($sponsor->contribution_amount, 2) }}</span>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if($sponsor->partnership_start_date)
                                                    <tr>
                                                        <td class="text-muted"><strong>Inicio de Colaboración:</strong></td>
                                                        <td>{{ $sponsor->partnership_start_date->format('d/m/Y') }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($sponsor->partnership_end_date)
                                                    <tr>
                                                        <td class="text-muted"><strong>Fin de Colaboración:</strong></td>
                                                        <td>{{ $sponsor->partnership_end_date->format('d/m/Y') }}</td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                @if($sponsor->contribution_description)
                                                <strong class="text-success">Descripción de la Contribución:</strong>
                                                <p class="text-muted">{{ $sponsor->contribution_description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vista móvil -->
                                    <div class="d-md-none">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 text-success">Tipo de Contribución</h6>
                                                    </div>
<<<<<<< HEAD
                                                    <span class="badge bg-success">{{ $sponsor->contribution_type_formatted }}</span>
=======
                                                    <span class="badge badge-success">{{ $sponsor->contribution_type_formatted }}</span>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                </div>
                                            </div>

                                            @if($sponsor->contribution_amount)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 text-success">Monto</h6>
                                                    </div>
                                                    <span class="h5 text-success mb-0">Q{{ number_format($sponsor->contribution_amount, 2) }}</span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($sponsor->partnership_start_date)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-success">Inicio de Colaboración</h6>
                                                        <p class="mb-0">{{ $sponsor->partnership_start_date->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($sponsor->partnership_end_date)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-success">Fin de Colaboración</h6>
                                                        <p class="mb-0">{{ $sponsor->partnership_end_date->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($sponsor->contribution_description)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-success">Descripción</h6>
                                                        <p class="mb-0 text-muted">{{ $sponsor->contribution_description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Proyectos Asociados -->
                            @if($sponsor->projects->count() > 0)
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-project-diagram mr-2"></i>
                                        Proyectos Asociados ({{ $sponsor->projects->count() }})
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Vista de escritorio -->
                                    <div class="d-none d-md-block">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Proyecto</th>
                                                        <th>Tipo de Contribución</th>
                                                        <th>Monto</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sponsor->projects as $project)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('projects.show', $project) }}" class="text-decoration-none">
                                                                {{ $project->nombre }}
                                                            </a>
                                                        </td>
                                                        <td>
<<<<<<< HEAD
                                                            <span class="badge bg-info">
=======
                                                            <span class="badge badge-info">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                                @php
                                                                    $contributionTypes = [
                                                                        'monetary' => 'Monetaria',
                                                                        'materials' => 'Materiales',
                                                                        'services' => 'Servicios',
                                                                        'volunteer' => 'Voluntariado',
                                                                        'mixed' => 'Mixta',
                                                                    ];
                                                                @endphp
                                                                {{ $contributionTypes[$project->pivot->contribution_type] ?? ucfirst($project->pivot->contribution_type) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($project->pivot->contribution_amount)
                                                                Q{{ number_format($project->pivot->contribution_amount, 2) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $project->pivot->sponsorship_date ? \Carbon\Carbon::parse($project->pivot->sponsorship_date)->format('d/m/Y') : '-' }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Vista móvil -->
                                    <div class="d-md-none">
                                        @foreach($sponsor->projects as $project)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <!-- Nombre del Proyecto -->
                                                <div class="mb-3">
                                                    <h6 class="card-title mb-2">
                                                        <a href="{{ route('projects.show', $project) }}" class="text-decoration-none">
                                                            {{ $project->nombre }}
                                                        </a>
                                                    </h6>
                                                </div>
                                                
                                                <!-- Tipo de Contribución -->
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <small class="text-muted font-weight-bold d-block mb-2">Tipo de Contribución:</small>
                                                        </div>
                                                        <div class="col-12">
<<<<<<< HEAD
                                                            <span class="badge bg-info d-block text-center" style="max-width: 100%;">
=======
                                                            <span class="badge badge-info d-block text-center" style="max-width: 100%;">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                                @php
                                                                    $contributionTypes = [
                                                                        'monetary' => 'Monetaria',
                                                                        'materials' => 'Materiales',
                                                                        'services' => 'Servicios',
                                                                        'volunteer' => 'Voluntariado',
                                                                        'mixed' => 'Mixta',
                                                                    ];
                                                                @endphp
                                                                {{ $contributionTypes[$project->pivot->contribution_type] ?? ucfirst($project->pivot->contribution_type) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Monto -->
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <small class="text-muted font-weight-bold d-block mb-2">Monto:</small>
                                                        </div>
                                                        <div class="col-12">
                                                            @if($project->pivot->contribution_amount)
                                                                <strong class="text-success h6 mb-0 d-block">Q{{ number_format($project->pivot->contribution_amount, 2) }}</strong>
                                                            @else
                                                                <span class="text-muted d-block">-</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Fecha -->
                                                @if($project->pivot->sponsorship_date)
                                                <div class="mb-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <small class="text-muted font-weight-bold d-block mb-2">Fecha:</small>
                                                        </div>
                                                        <div class="col-12">
                                                            <span class="text-muted d-block">{{ \Carbon\Carbon::parse($project->pivot->sponsorship_date)->format('d/m/Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <!-- Notas del proyecto si existen -->
                                                @if($project->pivot->notes)
                                                <div class="mt-3 pt-2 border-top">
                                                    <small class="text-muted font-weight-bold">Notas:</small>
                                                    <p class="text-muted small mb-0">{{ $project->pivot->notes }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Descripción -->
                            @if($sponsor->description)
                            <div class="card card-secondary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-align-left mr-2"></i>
                                        Descripción
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $sponsor->description }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Notas Internas -->
                            @if($sponsor->notes)
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-sticky-note mr-2"></i>
                                        Notas Internas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-0">{{ $sponsor->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Panel Lateral -->
                        <div class="col-12 col-lg-4">
                            <!-- Logo -->
                            <div class="card card-dark card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-image mr-2"></i>
                                        Logo
                                    </h3>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" 
                                         class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- Acciones Rápidas -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-tools mr-2"></i>
                                        Acciones Rápidas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @permission('sponsors.edit')
<<<<<<< HEAD
                                        <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-warning btn-lg custom">
=======
                                        <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-warning btn-lg">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <i class="fas fa-edit mr-2"></i>
                                            Editar Patrocinador
                                        </a>
                                        
                                        <form method="POST" action="{{ route('sponsors.toggle-featured', $sponsor) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
<<<<<<< HEAD
                                            <button type="submit" class="btn {{ $sponsor->is_featured ? 'btn-outline-warning' : 'btn-warning' }} btn-lg w-100 custom">
=======
                                            <button type="submit" class="btn {{ $sponsor->is_featured ? 'btn-outline-warning' : 'btn-warning' }} btn-lg w-100">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                <i class="fas fa-star mr-2"></i> 
                                                {{ $sponsor->is_featured ? 'Quitar Destacado' : 'Marcar Destacado' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('sponsors.toggle-status', $sponsor) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
<<<<<<< HEAD
                                            <button type="submit" class="btn {{ $sponsor->status === 'active' ? 'btn-outline-success' : 'btn-success' }} btn-lg w-100 custom">
=======
                                            <button type="submit" class="btn {{ $sponsor->status === 'active' ? 'btn-outline-success' : 'btn-success' }} btn-lg w-100">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                <i class="fas fa-power-off mr-2"></i> 
                                                {{ $sponsor->status === 'active' ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        @endpermission

                                        @permission('sponsors.delete')
                                        <form method="POST" action="{{ route('sponsors.destroy', $sponsor) }}" class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este patrocinador?')">
                                            @csrf
                                            @method('DELETE')
<<<<<<< HEAD
                                            <button type="submit" class="btn btn-danger btn-lg w-100 custom">
=======
                                            <button type="submit" class="btn btn-danger btn-lg w-100">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                                <i class="fas fa-trash mr-2"></i> 
                                                Eliminar Patrocinador
                                            </button>
                                        </form>
                                        @endpermission

<<<<<<< HEAD
                                        <a href="{{ route('sponsors.index') }}" class="btn btn-secondary btn-lg custom">
=======
                                        <a href="{{ route('sponsors.index') }}" class="btn btn-secondary btn-lg">
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Volver a la Lista
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del Sistema -->
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Información del Sistema
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted"><strong>Creado:</strong></td>
                                            <td>{{ $sponsor->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>Actualizado:</strong></td>
                                            <td>{{ $sponsor->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>ID:</strong></td>
                                            <td><code>{{ $sponsor->id }}</code></td>
                                        </tr>
                                    </table>
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
.card-outline {
    border-top: 3px solid;
}

.card-outline.card-primary {
    border-top-color: #007bff;
}

.card-outline.card-success {
    border-top-color: #28a745;
}

.card-outline.card-info {
    border-top-color: #17a2b8;
}

.card-outline.card-secondary {
    border-top-color: #6c757d;
}

.card-outline.card-warning {
    border-top-color: #ffc107;
}

.card-outline.card-dark {
    border-top-color: #343a40;
}

/* Mejoras para móviles */
@media (max-width: 768px) {
    .card-header .card-tools {
        margin-top: 0.5rem;
    }
    
    .btn-lg {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    
    .list-group-item {
        padding: 0.75rem 0;
    }
    
    /* Cards más grandes en móviles */
    .card {
        margin-bottom: 1.5rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .card-header {
        padding: 1rem 1.25rem;
    }
    
    /* Espaciado mejorado para elementos */
    .mb-3 {
        margin-bottom: 1.25rem !important;
    }
    
    .mb-2 {
        margin-bottom: 1rem !important;
    }
    
    /* Badges más grandes y con mejor espaciado */
    .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
        white-space: normal;
        word-wrap: break-word;
        max-width: 100%;
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 0.5rem;
        min-height: 2rem;
        line-height: 1.2;
    }
    
    .badge.text-wrap {
        white-space: normal;
        word-break: break-word;
        line-height: 1.2;
    }
    
    .card-title {
        font-size: 1.1rem;
        line-height: 1.3;
        margin-bottom: 0.75rem;
    }
    
    .h6 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    
    .small {
        font-size: 0.85rem;
    }
    
    /* Mejor espaciado para las filas */
    .row {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
    }
    
    .row > [class*="col-"] {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    /* Asegurar que los badges no se salgan en móviles */
    .col-12 .badge {
        box-sizing: border-box;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    /* Espaciado adicional para el contenido de proyectos */
    .card .card-body .row {
        margin-bottom: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush