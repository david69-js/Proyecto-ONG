@extends('layouts.tabler')

@section('title', 'Reporte de Proyecto - ' . $project->nombre)
@section('page-title', 'Reporte Detallado')
@section('page-description', 'Información completa del proyecto: ' . $project->nombre)

@section('content')
<div class="row row-deck row-cards">
    <!-- Información General del Proyecto -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle me-2"></i>Información General
                </h3>
                <div class="card-actions">
                    @permission('reports.export')
                    <a href="{{ route('admin.reports.projects.export-project', $project) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-download me-1"></i>Exportar PDF
                    </a>
                    @endpermission
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Proyecto
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="mb-3">{{ $project->nombre }}</h2>
                        <p class="text-muted mb-4">{{ $project->descripcion }}</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Objetivo</h4>
                                <p>{{ $project->objetivo }}</p>
                            </div>
                            <div class="col-md-6">
                                <h4>Resultados Esperados</h4>
                                <p>{{ $project->resultados_esperados }}</p>
                            </div>
                        </div>
                        
                        @if($project->resultados_obtenidos)
                        <div class="row">
                            <div class="col-12">
                                <h4>Resultados Obtenidos</h4>
                                <p>{{ $project->resultados_obtenidos }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Estado del Proyecto</h5>
                                <div class="mb-3">
                                    <span class="badge bg-{{ $project->estado === 'en_progreso' ? 'success' : ($project->estado === 'finalizado' ? 'primary' : ($project->estado === 'planificado' ? 'info' : 'warning')) }} fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                                    </span>
                                </div>
                                
                                <h5 class="card-title">Fase Actual</h5>
                                <div class="mb-3">
                                    <span class="badge bg-secondary fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $project->fase)) }}
                                    </span>
                                </div>
                                
                                <h5 class="card-title">Progreso</h5>
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%">
                                        {{ $progress }}%
                                    </div>
                                </div>
                                
                                <h5 class="card-title">Responsable</h5>
                                <p class="text-muted">
                                    @if($project->responsable)
                                        {{ $project->responsable->full_name }}
                                    @else
                                        No asignado
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas del Proyecto -->
<div class="row row-deck row-cards mt-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-primary">
                        <i class="fas fa-users me-2"></i>Beneficiarios
                    </div>
                </div>
                <div class="h1 mb-3">{{ $beneficiariesCount }}</div>
                <div class="d-flex mb-2">
                    <div>Personas beneficiadas</div>
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
                </div>
                <div class="h1 mb-3">{{ $donationsCount }}</div>
                <div class="d-flex mb-2">
                    <div>Donaciones recibidas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-info">
                        <i class="fas fa-dollar-sign me-2"></i>Monto Donado
                    </div>
                </div>
                <div class="h1 mb-3">Q{{ number_format($donationsAmount, 2) }}</div>
                <div class="d-flex mb-2">
                    <div>Total recaudado</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card stats-card border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader text-warning">
                        <i class="fas fa-percentage me-2"></i>Progreso
                    </div>
                </div>
                <div class="h1 mb-3">{{ $progress }}%</div>
                <div class="d-flex mb-2">
                    <div>Completado</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Información Financiera -->
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line me-2"></i>Información Financiera
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <div class="h2 text-primary">Q{{ number_format($project->presupuesto_total, 2) }}</div>
                            <div class="text-muted">Presupuesto Total</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <div class="h2 text-info">Q{{ number_format($project->fondos_asignados, 2) }}</div>
                            <div class="text-muted">Fondos Asignados</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <div class="h2 text-success">Q{{ number_format($project->fondos_ejecutados, 2) }}</div>
                            <div class="text-muted">Fondos Ejecutados</div>
                        </div>
                    </div>
                </div>
                
                @if($project->presupuesto_total > 0)
                <div class="mt-4">
                    <h5>Distribución de Fondos</h5>
                    <div class="progress mb-2" style="height: 25px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ ($project->fondos_asignados / $project->presupuesto_total) * 100 }}%">
                            Asignados: {{ round(($project->fondos_asignados / $project->presupuesto_total) * 100, 1) }}%
                        </div>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($project->fondos_ejecutados / $project->presupuesto_total) * 100 }}%">
                            Ejecutados: {{ round(($project->fondos_ejecutados / $project->presupuesto_total) * 100, 1) }}%
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Información de Fechas -->
<div class="row row-deck row-cards mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar me-2"></i>Fechas Importantes
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5>Fecha de Inicio</h5>
                        <p class="text-muted">
                            @if($startDate)
                                {{ $startDate->format('d/m/Y') }}
                            @else
                                No definida
                            @endif
                        </p>
                    </div>
                    <div class="col-6">
                        <h5>Fecha de Fin</h5>
                        <p class="text-muted">
                            @if($endDate)
                                {{ $endDate->format('d/m/Y') }}
                            @else
                                No definida
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($duration)
                <div class="row">
                    <div class="col-12">
                        <h5>Duración</h5>
                        <p class="text-muted">{{ $duration }} días</p>
                    </div>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-12">
                        <h5>Fecha de Creación</h5>
                        <p class="text-muted">{{ $project->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    @if($project->ubicacion)
                        {{ $project->ubicacion }}
                    @else
                        No especificada
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Beneficiarios del Proyecto -->
@if($beneficiariesCount > 0)
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users me-2"></i>Beneficiarios ({{ $beneficiariesCount }})
                </h3>
                <div class="card-actions">
                    <a href="{{ route('beneficiaries.index', ['project' => $project->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Género</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->beneficiaries->take(10) as $beneficiary)
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($beneficiariesCount > 10)
                <div class="text-center mt-3">
                    <p class="text-muted">Mostrando 10 de {{ $beneficiariesCount }} beneficiarios</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<!-- Imágenes de Fases -->
@if($project->phaseImages->count() > 0)
<div class="row row-deck row-cards mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-images me-2"></i>Imágenes del Proyecto
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($project->phaseImages->take(6) as $image)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Imagen de fase" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ ucfirst(str_replace('_', ' ', $image->phase)) }}</h6>
                                <p class="card-text text-muted">{{ $image->description ?? 'Sin descripción' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
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
    
    .stats-card {
        transition: transform 0.2s ease-in-out;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush
