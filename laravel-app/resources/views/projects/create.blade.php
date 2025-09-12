@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Crear Proyecto</h3>

    <form action="{{ route('proyectos.store') }}" method="POST">
        @csrf
        @include('proyectos.partials.form', ['proyecto' => new App\Models\Proyecto])
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('proyectos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
