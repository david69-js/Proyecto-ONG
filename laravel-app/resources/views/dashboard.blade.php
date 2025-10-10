@extends('layouts.app')

@section('title', 'Dashboard - Sistema ONG')
@section('header', 'Panel Principal')

@section('content')
<div class="row">
    <!-- Tarjetas de Estadísticas -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_projects'] ?? 0 }}</h4>
                        <p class="card-text">Proyectos Activos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-project-diagram fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('projects.index') }}" class="text-white text-decoration-none">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_beneficiaries'] ?? 0 }}</h4>
                        <p class="card-text">Beneficiarios</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('beneficiaries.index') }}" class="text-white text-decoration-none">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_donations'] ?? 0 }}</h4>
                        <p class="card-text">Donaciones</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-hand-holding-heart fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="#" class="text-white text-decoration-none">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_volunteers'] ?? 0 }}</h4>
                        <p class="card-text">Voluntarios</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-hands-helping fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('users.index') }}" class="text-white text-decoration-none">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Acciones Rápidas -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt"></i> Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @permission('projects.create')
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('projects.create') }}" class="btn btn-outline-primary w-100 p-3">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                            <strong>Crear Proyecto</strong><br>
                            <small>Iniciar un nuevo proyecto</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('beneficiaries.create')
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('beneficiaries.create') }}" class="btn btn-outline-success w-100 p-3">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            <strong>Registrar Beneficiario</strong><br>
                            <small>Agregar nueva persona</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('donations.create')
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-warning w-100 p-3">
                            <i class="fas fa-hand-holding-heart fa-2x mb-2"></i><br>
                            <strong>Registrar Donación</strong><br>
                            <small>Nueva donación recibida</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('users.create')
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-info w-100 p-3">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            <strong>Crear Usuario</strong><br>
                            <small>Agregar nuevo usuario</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('reports.view')
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-secondary w-100 p-3">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                            <strong>Ver Reportes</strong><br>
                            <small>Estadísticas e informes</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('activities.register-attendance')
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-dark w-100 p-3">
                            <i class="fas fa-clipboard-check fa-2x mb-2"></i><br>
                            <strong>Registrar Asistencia</strong><br>
                            <small>Control de asistencia</small>
                        </a>
                    </div>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Usuario -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user"></i> Mi Perfil
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                             class="rounded-circle" 
                             width="80" 
                             height="80" 
                             alt="Avatar">
                    @else
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    @endif
                </div>
                
                <h6 class="card-title">{{ auth()->user()->full_name }}</h6>
                <p class="text-muted">{{ auth()->user()->email }}</p>
                
                <div class="mb-3">
                    @foreach(auth()->user()->roles as $role)
                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                    @endforeach
                </div>

                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit"></i> Editar Perfil
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-cog"></i> Configuración
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proyectos Recientes -->
@permission('projects.view')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-project-diagram"></i> Proyectos Recientes
                </h5>
            </div>
            <div class="card-body">
                @if(isset($recent_projects) && $recent_projects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Beneficiarios</th>
                                    <th>Fecha Inicio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_projects as $project)
                                <tr>
                                    <td>
                                        <strong>{{ $project->name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $project->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $project->beneficiaries_count ?? 0 }}</td>
                                    <td>{{ $project->start_date ? $project->start_date->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @permission('projects.edit')
                                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endpermission
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay proyectos recientes</p>
                        @permission('projects.create')
                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Primer Proyecto
                        </a>
                        @endpermission
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endpermission
@endsection

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-warning:hover,
    .btn-outline-info:hover,
    .btn-outline-secondary:hover,
    .btn-outline-dark:hover {
        transform: translateY(-1px);
    }
</style>
@endpush
