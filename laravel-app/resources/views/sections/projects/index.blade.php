@extends('layouts.tabler')

@section('title', 'Administrar Proyectos')
@section('page-title', 'Administrar Proyectos')
@section('page-description', 'Gestiona qué proyectos aparecen en la página principal')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Proyectos en Página Principal</h3>
                </div>
                <div class="card-body">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $project->nombre }}</td>
                <td>{{ $project->categoria ?? '-' }}</td>
                <td>{{ ucfirst($project->estado) }}</td>
                <td>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
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
@endsection
