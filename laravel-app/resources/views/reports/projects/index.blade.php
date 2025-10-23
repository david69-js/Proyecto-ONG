@extends('layouts.tabler')

@section('title', 'Reportes de Proyectos - Sistema ONG')
@section('page-title', 'Reportes de Proyectos')
@section('page-description', 'Estadísticas e informes detallados de proyectos')

@section('content')
<div class="row row-deck row-cards">
    <!-- Estadísticas Generales -->
    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-primary">
                        <i class="fas fa-project-diagram me-2"></i>Total Proyectos
                    </div>
                </div>
                <div class="h1 mb-3">{{ $totalProjects }}</div>
                <div class="d-flex mb-2">
                    <div>Proyectos registrados</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-success">
                        <i class="fas fa-play-circle me-2"></i>Proyectos Activos
                    </div>
                </div>
                <div class="h1 mb-3">{{ $activeProjects }}</div>
                <div class="d-flex mb-2">
                    <div>En progreso</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            {{ $totalProjects > 0 ? round(($activeProjects / $totalProjects) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: {{ $totalProjects > 0 ? round(($activeProjects / $totalProjects) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-info">
                        <i class="fas fa-check-circle me-2"></i>Completados
                    </div>
                </div>
                <div class="h1 mb-3">{{ $completedProjects }}</div>
                <div class="d-flex mb-2">
                    <div>Proyectos finalizados</div>
                    <div class="ms-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                            {{ $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-info" style="width: {{ $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-warning">
                        <i class="fas fa-clock me-2"></i>Planificados
                    </div>
                </div>
                <div class="h1 mb-3">{{ $plannedProjects }}</div>
                <div class="d-flex mb-2">
                    <div>En planificación</div>
                    <div class="ms-auto">
                        <span class="text-warning d-inline-flex align-items-center lh-1">
                            {{ $totalProjects > 0 ? round(($plannedProjects / $totalProjects) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: {{ $totalProjects > 0 ? round(($plannedProjects / $totalProjects) * 100) : 0 }}%" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de Presupuesto -->
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie me-2"></i>Estadísticas de Presupuesto
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h2 text-primary">Q{{ number_format($totalBudget, 2) }}</div>
                            <div class="text-muted">Presupuesto Total</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h2 text-info">Q{{ number_format($totalAssigned, 2) }}</div>
                            <div class="text-muted">Fondos Asignados</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h2 text-success">Q{{ number_format($totalExecuted, 2) }}</div>
                            <div class="text-muted">Fondos Ejecutados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros y Acciones -->
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter me-2"></i>Filtros y Acciones
                </h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.projects.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="planificado" {{ $filters['status'] == 'planificado' ? 'selected' : '' }}>Planificado</option>
                            <option value="en_progreso" {{ $filters['status'] == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="finalizado" {{ $filters['status'] == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            <option value="cancelado" {{ $filters['status'] == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fase</label>
                        <select name="phase" class="form-select">
                            <option value="">Todas las fases</option>
                            <option value="diagnostico" {{ $filters['phase'] == 'diagnostico' ? 'selected' : '' }}>Diagnóstico</option>
                            <option value="formulacion" {{ $filters['phase'] == 'formulacion' ? 'selected' : '' }}>Formulación</option>
                            <option value="financiacion" {{ $filters['phase'] == 'financiacion' ? 'selected' : '' }}>Financiación</option>
                            <option value="ejecucion" {{ $filters['phase'] == 'ejecucion' ? 'selected' : '' }}>Ejecución</option>
                            <option value="evaluacion" {{ $filters['phase'] == 'evaluacion' ? 'selected' : '' }}>Evaluación</option>
                            <option value="cierre" {{ $filters['phase'] == 'cierre' ? 'selected' : '' }}>Cierre</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Desde</label>
                        <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Filtrar
                            </button>
                            <a href="{{ route('admin.reports.projects.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Limpiar
                            </a>
                        </div>
                    </div>
                </form>
                
                <div class="mt-3">
                    @permission('reports.export')
                    <a href="{{ route('admin.reports.projects.export', request()->query()) }}" class="btn btn-success">
                        <i class="fas fa-download me-1"></i>Exportar PDF
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proyectos por Fase -->
<div class="row row-deck row-cards mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar me-2"></i>Proyectos por Fase
                </h3>
            </div>
            <div class="card-body">
                @if($projectsByPhase->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Fase</th>
                                    <th>Cantidad</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projectsByPhase as $phase => $data)
                                <tr>
                                    <td>{{ ucfirst(str_replace('_', ' ', $phase)) }}</td>
                                    <td>{{ $data->count }}</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: {{ $totalProjects > 0 ? round(($data->count / $totalProjects) * 100) : 0 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $totalProjects > 0 ? round(($data->count / $totalProjects) * 100, 1) : 0 }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="fas fa-chart-bar fa-3x text-muted"></i>
                        </div>
                        <p class="empty-title">No hay datos</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie me-2"></i>Proyectos por Estado
                </h3>
            </div>
            <div class="card-body">
                @if($projectsByStatus->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projectsByStatus as $status => $data)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $status === 'en_progreso' ? 'success' : ($status === 'finalizado' ? 'primary' : ($status === 'planificado' ? 'info' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $data->count }}</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: {{ $totalProjects > 0 ? round(($data->count / $totalProjects) * 100) : 0 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $totalProjects > 0 ? round(($data->count / $totalProjects) * 100, 1) : 0 }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="fas fa-chart-pie fa-3x text-muted"></i>
                        </div>
                        <p class="empty-title">No hay datos</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Proyectos Recientes -->
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock me-2"></i>Proyectos Recientes (Últimos 6 meses)
                </h3>
                <div class="card-actions">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentProjects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Fase</th>
                                    <th>Beneficiarios</th>
                                    <th>Presupuesto</th>
                                    <th>Fecha Inicio</th>
                                    <th class="w-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProjects as $project)
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
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst(str_replace('_', ' ', $project->fase)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $project->beneficiaries_count ?? 0 }}</td>
                                    <td class="text-muted">Q{{ number_format($project->presupuesto_total, 2) }}</td>
                                    <td class="text-muted">{{ $project->fecha_inicio ? \Carbon\Carbon::parse($project->fecha_inicio)->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reports.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-chart-line"></i>
                                            </a>
                                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
                        <p class="empty-subtitle text-muted">Los proyectos aparecerán aquí cuando se creen</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Top Proyectos por Beneficiarios -->
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users me-2"></i>Top Proyectos por Beneficiarios
                </h3>
            </div>
            <div class="card-body">
                @if($beneficiariesStats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Beneficiarios</th>
                                    <th>Estado</th>
                                    <th>Presupuesto</th>
                                    <th class="w-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($beneficiariesStats as $project)
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
                                        <span class="badge bg-primary">{{ $project->beneficiaries_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $project->estado === 'en_progreso' ? 'success' : ($project->estado === 'finalizado' ? 'primary' : ($project->estado === 'planificado' ? 'info' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">Q{{ number_format($project->presupuesto_total, 2) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reports.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-chart-line"></i>
                                            </a>
                                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
                        <p class="empty-title">No hay datos de beneficiarios</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
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
</style>
@endpush
