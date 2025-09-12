@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Editar Proyecto</h3>

    <form action="{{ route('proyectos.update',$proyecto) }}" method="POST">
        @csrf @method('PUT')
        @include('proyectos.partials.form', ['proyecto' => $proyecto])
        <button type="submit" class="btn btn-success mt-3">Actualizar</button>
        <a href="{{ route('proyectos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
