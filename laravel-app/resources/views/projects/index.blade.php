@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Proyectos</h3>
    <a href="{{ route('proyectos.create') }}" class="btn btn-primary mb-3">+ Nuevo Proyecto</a>

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
                    @foreach($proyectos as $proyecto)
                        <tr>
                            <td>{{ $proyecto->nombre }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($proyecto->estado) }}</span>
                            </td>
                            <td>{{ $proyecto->responsable?->first_name }} {{ $proyecto->responsable?->last_name }}</td>
                            <td>{{ $proyecto->fecha_inicio }}</td>
                            <td>
                                <a href="{{ route('proyectos.show',$proyecto) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('proyectos.edit',$proyecto) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('proyectos.destroy',$proyecto) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proyecto?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
