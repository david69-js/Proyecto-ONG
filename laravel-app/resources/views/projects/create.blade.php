@extends('layouts.tabler')

@section('title', 'Crear Proyecto')
@section('page-title', 'Crear Nuevo Proyecto')
@section('page-description', 'Registrar un nuevo proyecto en el sistema')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del Proyecto</h3>
            </div>
            <div class="card-body">

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        {{-- Pasamos $project y $usuarios al formulario --}}
        @include('projects.partials.form', ['project' => $project, 'usuarios' => $usuarios])

        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>
@endsection
