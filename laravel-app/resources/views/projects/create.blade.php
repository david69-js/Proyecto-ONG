<<<<<<< HEAD
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
=======
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Crear Proyecto</h3>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        {{-- Pasamos $project y $usuarios al formulario --}}
        @include('projects.partials.form', ['project' => $project, 'usuarios' => $usuarios])

        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
