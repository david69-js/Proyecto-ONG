@extends('layouts.tabler')

@section('page-title', 'Gestión de Publicaciones de Proyectos')
@section('page-description', 'Publica o despublica los proyectos que aparecen en la página principal')

@section('content')
<div class="container-fluid">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center my-4">
        <h2 class="mb-0">Proyectos del Sistema</h2>
    </div>

    {{-- Tabla --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Responsable</th>
                            <th>Publicado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $index => $project)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $project->nombre }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($project->descripcion, 60) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        match($project->estado) {
                                            'planificado' => 'secondary',
                                            'en_progreso' => 'info',
                                            'pausado' => 'warning',
                                            'finalizado' => 'success',
                                            'cancelado' => 'danger',
                                            default => 'secondary'
                                        }
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $project->responsable?->first_name ?? 'Sin asignar' }}
                                    {{ $project->responsable?->last_name ?? '' }}
                                </td>
                                <td>
                                    @if($project->is_published)
                                        <span class="badge bg-success">Publicado</span>
                                    @else
                                        <span class="badge bg-secondary">No publicado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Publicar / Despublicar --}}
                                    @permission('projects.edit')
                                        <form action="{{ route('projects.toggle-publish', $project) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($project->is_published)
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Despublicar">
                                                    <i class="fas fa-eye-slash"></i> Despublicar
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Publicar">
                                                    <i class="fas fa-upload"></i> Publicar
                                                </button>
                                            @endif
                                        </form>
                                    @endpermission
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                    No hay proyectos registrados aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
