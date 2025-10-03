@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Crear Proyecto</h3>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        {{-- Pasamos $project y $usuarios al formulario --}}
        @include('projects.partials.form', ['project' => $project, 'usuarios' => $usuarios])

        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
