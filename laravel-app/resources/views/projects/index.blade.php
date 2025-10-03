@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Proyectos</h3>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">+ Nuevo Proyecto</a>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Responsable</th>
                        <th>Fecha Inicio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->nombre }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($project->estado) }}</span>
                            </td>
                            <td>
                                {{ $project->responsable?->first_name }} {{ $project->responsable?->last_name }}
                            </td>
                            <td>{{ $project->fecha_inicio }}</td>
                            <td>
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proyecto?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay proyectos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
