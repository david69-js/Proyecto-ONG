<<<<<<< HEAD
@extends('layouts.tabler')

@section('page-title', 'Detalles del Proyecto')
@section('page-description', 'Información completa del proyecto')
=======
@extends('layouts.app')
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

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

            <div class="mt-3">
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
