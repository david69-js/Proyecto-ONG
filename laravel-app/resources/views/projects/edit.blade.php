<<<<<<< HEAD
@extends('layouts.tabler')

@section('page-title', 'Editar Proyecto')
@section('page-description', 'Modificar información del proyecto')
=======
@extends('layouts.app')
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

@section('content')
<div class="container">
    <h3>Editar Proyecto</h3>

    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf 
        @method('PUT')

        {{-- Pasamos $project y $usuarios al formulario --}}
        @include('projects.partials.form', ['project' => $project, 'usuarios' => $usuarios])

        <button type="submit" class="btn btn-success mt-3">Actualizar</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
