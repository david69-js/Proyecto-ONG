@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Detalles del Proyecto</h3>

    <div class="card">
        <div class="card-body">
            <h4>{{ $proyecto->nombre }}</h4>
            <p>{{ $proyecto->descripcion }}</p>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Estado:</strong> <span class="badge bg-primary">{{ ucfirst($proyecto->estado) }}</span></p>
                    <p><strong>Responsable:</strong> {{ $proyecto->responsable?->first_name }} {{ $proyecto->responsable?->last_name }}</p>
                    <p><strong>Ubicación:</strong> {{ $proyecto->ubicacion }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha Inicio:</strong> {{ $proyecto->fecha_inicio }}</p>
                    <p><strong>Fecha Fin:</strong> {{ $proyecto->fecha_fin }}</p>
                    <p><strong>Presupuesto:</strong> ${{ number_format($proyecto->presupuesto_total,2) }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('proyectos.edit',$proyecto) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('proyectos.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
