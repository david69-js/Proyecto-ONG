<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', 'Proyectos')
@section('page-title', 'Gestión de Proyectos')
@section('page-description', 'Administrar proyectos del sistema')

@section('page-actions')
@permission('projects.create')
<a href="{{ route('projects.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i>Nuevo Proyecto
</a>
@endpermission
@endsection

@section('content')
=======
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Proyectos</h3>
    
    @permission('projects.create')
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Proyecto
    </a>
    @endpermission
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

    @role('beneficiary')
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Estás viendo tu proyecto asignado
    </div>
    @endrole

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
                                @can('view', $project)
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                @endcan
                                
                                @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                @endcan
                                
                                @can('delete', $project)
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proyecto?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                                @endcan

                                @if(!auth()->user()->can('view', $project) && !auth()->user()->can('update', $project) && !auth()->user()->can('delete', $project))
                                <span class="text-muted">Sin acceso</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                @role('beneficiary')
                                    No tienes proyectos asignados.
                                @else
                                    No hay proyectos registrados.
                                @endrole
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
