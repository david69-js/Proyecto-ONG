@extends('layouts.tabler')

@section('page-title', 'Detalles del Proyecto')
@section('page-description', 'Información completa del proyecto')

@section('content')
<div class="container-fluid">
    <h3>Detalles del Proyecto</h3>

    <div class="card">
        <div class="card-body">
            <h4>{{ $project->nombre }}</h4>
            <p>{{ $project->descripcion ?? 'Sin descripción' }}</p>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Estado:</strong> 
                        <span class="badge bg-primary">{{ ucfirst($project->estado) }}</span>
                    </p>
                    <p><strong>Responsable:</strong> 
                        {{ $project->responsable?->first_name }} {{ $project->responsable?->last_name ?? '' }}
                    </p>
                    <p><strong>Ubicación:</strong> {{ $project->ubicacion ?? 'No definida' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha Inicio:</strong> {{ $project->fecha_inicio }}</p>
                    <p><strong>Fecha Fin:</strong> {{ $project->fecha_fin ?? 'No definida' }}</p>
                    <p><strong>Presupuesto:</strong> 
                        Q.{{ $project->presupuesto_total ? number_format($project->presupuesto_total, 2) : '0.00' }}
                    </p>
                </div>
            </div>

            <!-- Fases del Proyecto -->
            <div class="mt-4">
                <h5 class="text-primary">Fases del Proyecto</h5>
                <hr>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="progress progress-lg mb-3">
                            <div class="progress-bar" style="width: {{ $project->total_progress }}%"></div>
                        </div>
                        <div class="text-muted">
                            Progreso total: <strong>{{ number_format($project->total_progress, 1) }}%</strong>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-muted">Fase actual:</div>
                        <h4 class="text-primary">{{ $project->fase_actual_nombre }}</h4>
                    </div>
                </div>

                <div class="row mt-3">
                    @foreach($project->fases_con_porcentajes as $key => $fase)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $fase['nombre'] }}</h6>
                                    <div class="progress progress-sm mb-2">
                                        <div class="progress-bar" style="width: {{ $fase['porcentaje'] }}%"></div>
                                    </div>
                                    <div class="text-muted small">{{ $fase['porcentaje'] }}% completado</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Gestión de Fases -->
            <div class="mt-4">
                <h5 class="text-primary">Gestión de Fases</h5>
                <hr>
                
                <!-- Formulario para actualizar fases -->
                <form action="{{ route('projects.update-phases', $project) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Fase Actual</label>
                            <select name="fase_actual" class="form-select">
                                @foreach(['diagnostico' => 'Diagnóstico', 'formulacion' => 'Formulación', 'financiacion' => 'Financiación', 'ejecucion' => 'Ejecución', 'evaluacion' => 'Evaluación', 'cierre' => 'Cierre'] as $key => $nombre)
                                    <option value="{{ $key }}" {{ $project->fase_actual == $key ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        @foreach($project->fases_con_porcentajes as $key => $fase)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $fase['nombre'] }}</h6>
                                        <div class="mb-2">
                                            <input type="number" 
                                                   name="porcentaje_{{ $key }}" 
                                                   class="form-control form-control-sm" 
                                                   min="0" 
                                                   max="100" 
                                                   value="{{ $fase['porcentaje'] }}"
                                                   placeholder="0-100%">
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: {{ $fase['porcentaje'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l5 5l10 -10"/>
                                </svg>
                                Actualizar Fases
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Gestión de Imágenes por Fase -->
                <div class="mt-4">
                    <h6 class="text-secondary">Imágenes por Fase</h6>
                    
                    @foreach($project->fases_con_porcentajes as $key => $fase)
                        <div class="mb-4">
                            <h6>{{ $fase['nombre'] }}</h6>
                            
                            <!-- Upload Form for this phase -->
                            <form action="{{ route('projects.upload-phase-image', $project) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                                @csrf
                                <input type="hidden" name="fase" value="{{ $key }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="imagen" class="form-control form-control-sm" accept="image/*" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="titulo" class="form-control form-control-sm" placeholder="Título">
                                    </div>
                                    <div class="col-md-4">
                                        <textarea name="descripcion" class="form-control form-control-sm" placeholder="Descripción" rows="1"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success btn-sm w-100">Subir</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Images for this phase -->
                            <div class="row">
                                @php
                                    $phaseImages = $project->getPhaseImages($key);
                                @endphp
                                
                                @if($phaseImages->count() > 0)
                                    @foreach($phaseImages as $image)
                                        <div class="col-md-3 mb-2">
                                            <div class="card">
                                                <img src="{{ $image->imagen_url }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                                <div class="card-body p-2">
                                                    @if($image->titulo)
                                                        <h6 class="card-title small">{{ $image->titulo }}</h6>
                                                    @endif
                                                    <form action="{{ route('projects.delete-phase-image', $image) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('¿Eliminar imagen?')">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="text-muted small">No hay imágenes para esta fase</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
