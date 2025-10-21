@extends('layouts.tabler')

@section('title', 'Dashboard - Sistema ONG')
@section('page-title', 'Panel Principal')
@section('page-description', 'Resumen general del sistema de gestión de ONG')

@section('content')
<!-- Header del Dashboard -->


<div class="row row-deck row-cards">
    <!-- Tarjetas de Estadísticas -->
    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-primary">
                        <i class="fas fa-project-diagram me-2"></i>Proyectos
                    </div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Activos</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Activos</a>
                                <a class="dropdown-item" href="#">Todos</a>
                                <a class="dropdown-item" href="#">Completados</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['active_projects'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Proyectos activos</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['total_projects'] > 0 ? round(($stats['active_projects'] / $stats['total_projects']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: {{ $stats['total_projects'] > 0 ? round(($stats['active_projects'] / $stats['total_projects']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-info">
                        <i class="fas fa-users me-2"></i>Beneficiarios
                    </div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Activos</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#" onclick="updateBeneficiariesCard('active')">Activos</a>
                                <a class="dropdown-item" href="#" onclick="updateBeneficiariesCard('total')">Todos</a>
                                <a class="dropdown-item" href="#" onclick="updateBeneficiariesCard('children')">Niños</a>
                                <a class="dropdown-item" href="#" onclick="updateBeneficiariesCard('adults')">Adultos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3" id="beneficiaries-count">{{ $stats['active_beneficiaries'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div id="beneficiaries-label">Beneficiarios activos</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            <span id="beneficiaries-percentage">{{ $stats['total_beneficiaries'] > 0 ? round(($stats['active_beneficiaries'] / $stats['total_beneficiaries']) * 100, 1) : 0 }}%</span>
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-info" id="beneficiaries-progress" style="width: {{ $stats['total_beneficiaries'] > 0 ? round(($stats['active_beneficiaries'] / $stats['total_beneficiaries']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-success">
                        <i class="fas fa-heart me-2"></i>Donaciones
                    </div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Este mes</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Este mes</a>
                                <a class="dropdown-item" href="#">Últimos 3 meses</a>
                                <a class="dropdown-item" href="#">Este año</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['donations_this_month'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Donaciones este mes</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['total_donations'] > 0 ? round(($stats['donations_this_month'] / $stats['total_donations']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: {{ $stats['total_donations'] > 0 ? round(($stats['donations_this_month'] / $stats['total_donations']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-warning">
                        <i class="fas fa-box me-2"></i>Productos
                    </div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Disponibles</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Disponibles</a>
                                <a class="dropdown-item" href="#">Todos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['available_products'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Productos disponibles</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['total_products'] > 0 ? round(($stats['available_products'] / $stats['total_products']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: {{ $stats['total_products'] > 0 ? round(($stats['available_products'] / $stats['total_products']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Segunda fila de estadísticas -->
<div class="row row-deck row-cards mt-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-primary">
                        <i class="fas fa-handshake me-2"></i>Patrocinadores
                    </div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Activos</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item active" href="#">Activos</a>
                                <a class="dropdown-item" href="#">Todos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['active_sponsors'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Patrocinadores activos</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['total_sponsors'] > 0 ? round(($stats['active_sponsors'] / $stats['total_sponsors']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: {{ $stats['total_sponsors'] > 0 ? round(($stats['active_sponsors'] / $stats['total_sponsors']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-success">
                        <i class="fas fa-check-circle me-2"></i>Donaciones Confirmadas
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['confirmed_donations'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Donaciones confirmadas</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="fas fa-check me-1"></i>
                            Q{{ number_format($stats['total_donation_amount'] ?? 0, 2) }}
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: {{ $stats['total_donations'] > 0 ? round(($stats['confirmed_donations'] / $stats['total_donations']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-warning">
                        <i class="fas fa-clock me-2"></i>Donaciones Pendientes
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['pending_donations'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Donaciones pendientes</div>
                    <div class="ms-auto">
                        <span class="text-warning d-inline-flex align-items-center lh-1">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Requieren atención
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: {{ $stats['total_donations'] > 0 ? round(($stats['pending_donations'] / $stats['total_donations']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-info">
                        <i class="fas fa-calendar-alt me-2"></i>Eventos Próximos
                    </div>
                </div>
                <div class="h1 mb-3">{{ $stats['upcoming_events'] ?? 0 }}</div>
                <div class="d-flex mb-2">
                    <div>Eventos próximos</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $stats['total_events'] ?? 0 }} total
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-info" style="width: {{ $stats['total_events'] > 0 ? round(($stats['upcoming_events'] / $stats['total_events']) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-deck row-cards mt-4">
    <!-- Acciones Rápidas -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @permission('projects.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('projects.create') }}" class="btn btn-outline-primary w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <strong>Crear Proyecto</strong>
                            <small class="text-muted">Iniciar un nuevo proyecto</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('beneficiaries.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('beneficiaries.create') }}" class="btn btn-outline-success w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                            <strong>Registrar Beneficiario</strong>
                            <small class="text-muted">Agregar nueva persona</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('donations.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('admin.donations.create') }}" class="btn btn-outline-warning w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-hand-holding-heart fa-2x mb-2"></i>
                            <strong>Registrar Donación</strong>
                            <small class="text-muted">Nueva donación recibida</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('users.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-info w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                            <strong>Crear Usuario</strong>
                            <small class="text-muted">Agregar nuevo usuario</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('reports.view')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('admin.donations.reports') }}" class="btn btn-outline-secondary w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <strong>Ver Reportes</strong>
                            <small class="text-muted">Estadísticas e informes</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('sponsors.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('sponsors.create') }}" class="btn btn-outline-primary w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-handshake fa-2x mb-2"></i>
                            <strong>Registrar Patrocinador</strong>
                            <small class="text-muted">Nuevo patrocinador</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('events.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('admin.events.create') }}" class="btn btn-outline-info w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                            <strong>Crear Evento</strong>
                            <small class="text-muted">Nuevo evento</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('locations.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('locations.create') }}" class="btn btn-outline-success w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                            <strong>Agregar Ubicación</strong>
                            <small class="text-muted">Nueva ubicación</small>
                        </a>
                    </div>
                    @endpermission

                    @permission('products.create')
                    <div class="col-md-6 col-lg-4 mb-3">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-warning w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <strong>Agregar Producto</strong>
                            <small class="text-muted">Nuevo producto</small>
                        </a>
                    </div>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Usuario -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user me-2"></i>Mi Perfil
                </h3>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                 class="avatar avatar-lg" 
                                 alt="Avatar">
                        @else
                            <span class="avatar avatar-lg" style="background-image: url({{ asset('assets/img/default-avatar.png') }})"></span>
                        @endif
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">{{ auth()->user()->full_name }}</div>
                        <div class="text-muted">{{ auth()->user()->email }}</div>
                        <div class="mt-2">
                            @foreach(auth()->user()->roles as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            @can('update', auth()->user())
                            <a href="{{ route('users.permissions', auth()->user()) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Editar Perfil
                            </a>
                            @endcan
                            @can('update', auth()->user())
                            <a href="{{ route('users.edit', auth()->user()) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-cog me-1"></i>Configuración
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proyectos Recientes -->
@permission('projects.view')
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-project-diagram me-2"></i>Proyectos Recientes
                </h3>
                <div class="card-actions">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($recent_projects) && $recent_projects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Beneficiarios</th>
                                    <th>Fecha Inicio</th>
                                    <th class="w-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_projects as $project)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $project->nombre }}</div>
                                                <div class="text-muted">{{ Str::limit($project->descripcion, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $project->estado === 'en_progreso' ? 'success' : ($project->estado === 'finalizado' ? 'primary' : ($project->estado === 'planificado' ? 'info' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $project->beneficiaries_count ?? 0 }}</td>
                                    <td class="text-muted">{{ $project->fecha_inicio ? \Carbon\Carbon::parse($project->fecha_inicio)->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @permission('projects.edit')
                                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="fas fa-project-diagram fa-3x text-muted"></i>
                        </div>
                        <p class="empty-title">No hay proyectos recientes</p>
                        <p class="empty-subtitle text-muted">Comienza creando tu primer proyecto</p>
                        @permission('projects.create')
                        <div class="empty-action">
                            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Crear Primer Proyecto
                            </a>
                        </div>
                        @endpermission
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endpermission

<!-- Beneficiarios Recientes -->
@permission('beneficiaries.view')
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users me-2"></i>Beneficiarios Recientes
                </h3>
                <div class="card-actions">
                    <a href="{{ route('beneficiaries.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($recent_beneficiaries) && $recent_beneficiaries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Beneficiario</th>
                                    <th>Edad</th>
                                    <th>Género</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th class="w-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_beneficiaries as $beneficiary)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $beneficiary->first_name }} {{ $beneficiary->last_name }}</div>
                                                <div class="text-muted">{{ $beneficiary->email ?? 'Sin email' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $beneficiary->age ?? 'N/A' }} años</td>
                                    <td>
                                        <span class="badge bg-{{ $beneficiary->gender === 'male' ? 'primary' : 'pink' }}">
                                            {{ $beneficiary->gender === 'male' ? 'Masculino' : 'Femenino' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $beneficiary->is_active ? 'success' : 'secondary' }}">
                                            {{ $beneficiary->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $beneficiary->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @permission('beneficiaries.edit')
                                            <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="fas fa-users fa-3x text-muted"></i>
                        </div>
                        <p class="empty-title">No hay beneficiarios recientes</p>
                        <p class="empty-subtitle text-muted">Comienza registrando tu primer beneficiario</p>
                        @permission('beneficiaries.create')
                        <div class="empty-action">
                            <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Registrar Primer Beneficiario
                            </a>
                        </div>
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
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.15s ease-in-out;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-warning:hover,
    .btn-outline-info:hover,
    .btn-outline-secondary:hover,
    .btn-outline-dark:hover {
        transform: translateY(-1px);
    }
    
    .avatar {
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .avatar-lg {
        width: 3rem;
        height: 3rem;
    }
    
    .empty {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-icon {
        margin-bottom: 1rem;
    }
    
    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .empty-subtitle {
        margin-bottom: 1.5rem;
    }
    
    .empty-action {
        margin-top: 1rem;
    }
</style>
@endpush

@push('scripts')
<script>
// Datos de beneficiarios para el card interactivo
const beneficiariesData = {
    active: {
        count: {{ $stats['active_beneficiaries'] ?? 0 }},
        label: 'Beneficiarios activos',
        percentage: {{ $stats['total_beneficiaries'] > 0 ? round(($stats['active_beneficiaries'] / $stats['total_beneficiaries']) * 100, 1) : 0 }},
        total: {{ $stats['total_beneficiaries'] ?? 0 }}
    },
    total: {
        count: {{ $stats['total_beneficiaries'] ?? 0 }},
        label: 'Total de beneficiarios',
        percentage: 100,
        total: {{ $stats['total_beneficiaries'] ?? 0 }}
    },
    children: {
        count: {{ $stats['child_beneficiaries'] ?? 0 }},
        label: 'Beneficiarios niños',
        percentage: {{ $stats['total_beneficiaries'] > 0 ? round(($stats['child_beneficiaries'] / $stats['total_beneficiaries']) * 100, 1) : 0 }},
        total: {{ $stats['total_beneficiaries'] ?? 0 }}
    },
    adults: {
        count: {{ $stats['adult_beneficiaries'] ?? 0 }},
        label: 'Beneficiarios adultos',
        percentage: {{ $stats['total_beneficiaries'] > 0 ? round(($stats['adult_beneficiaries'] / $stats['total_beneficiaries']) * 100, 1) : 0 }},
        total: {{ $stats['total_beneficiaries'] ?? 0 }}
    }
};

function updateBeneficiariesCard(type) {
    const data = beneficiariesData[type];
    if (!data) return;
    
    // Actualizar elementos del DOM
    document.getElementById('beneficiaries-count').textContent = data.count;
    document.getElementById('beneficiaries-label').textContent = data.label;
    document.getElementById('beneficiaries-percentage').textContent = data.percentage + '%';
    document.getElementById('beneficiaries-progress').style.width = data.percentage + '%';
    
    // Actualizar dropdown activo
    const dropdownItems = document.querySelectorAll('.dropdown-menu a[onclick*="updateBeneficiariesCard"]');
    dropdownItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('onclick').includes(`'${type}'`)) {
            item.classList.add('active');
        }
    });
    
    // Actualizar texto del dropdown toggle
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    dropdownToggle.textContent = data.label.split(' ')[0]; // Tomar primera palabra
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Hacer funcional el dropdown de beneficiarios
    updateBeneficiariesCard('active');
});
</script>
@endpush
