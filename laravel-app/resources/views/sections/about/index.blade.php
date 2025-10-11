@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Editar Sección "Sobre Nosotros"</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Título y descripciones -->
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $about->titulo) }}">
        </div>

        <div class="mb-3">
            <label>Descripción principal</label>
            <textarea name="descripcion_principal" class="form-control" rows="3">{{ old('descripcion_principal', $about->descripcion_principal) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Descripción secundaria</label>
            <textarea name="descripcion_secundaria" class="form-control" rows="3">{{ old('descripcion_secundaria', $about->descripcion_secundaria) }}</textarea>
        </div>

        <hr class="my-4">

        <!-- Logros numéricos -->
        <h4>Logros</h4>
        <div class="row g-3">
            @foreach(['anios_servicio' => 'Años de servicio', 'hogares_construidos' => 'Hogares construidos', 'compromiso_social' => 'Compromiso social', 'colaboradores_activos' => 'Colaboradores activos'] as $field => $label)
            <div class="col-md-3">
                <label>{{ $label }}</label>
                <input type="number" name="{{ $field }}" class="form-control" value="{{ old($field, $about->$field) }}">
            </div>
            @endforeach
        </div>

        <hr class="my-4">

        <!-- Imágenes generales -->
        @foreach(['imagen_principal' => 'Imagen principal', 'imagen_secundaria' => 'Imagen secundaria', 'imagen_extra' => 'Imagen extra'] as $field => $label)
        <div class="mb-3">
            <label>{{ $label }}</label><br>
            @if(!empty($about->$field))
                <img src="{{ asset('storage/'.$about->$field) }}" alt="{{ $label }}" class="img-fluid rounded mb-2" width="200">
            @endif
            <input type="file" name="{{ $field }}" class="form-control">
        </div>
        @endforeach

        <hr class="my-4">

        <!-- Badges de Alianzas y Reconocimientos -->
        <h4 class="mt-4">Alianzas y Reconocimientos</h4>
        @foreach(['badge_1' => 'Badge 1', 'badge_2' => 'Badge 2', 'badge_3' => 'Badge 3'] as $field => $label)
        <div class="mb-3">
            <label>{{ $label }}</label><br>
            @if(!empty($about->$field))
                <img src="{{ asset('storage/'.$about->$field) }}" alt="{{ $label }}" class="img-fluid mb-2" width="150">
            @endif
            <input type="file" name="{{ $field }}" class="form-control">
        </div>
        @endforeach

        <hr class="my-4">

        <!-- Enlace “Conoce más” -->
        <div class="mb-3">
            <label>Enlace "Conoce más"</label>
            <input type="text" name="link_conoce_mas" class="form-control" value="{{ old('link_conoce_mas', $about->link_conoce_mas) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Guardar cambios</button>
    </form>
</div>
@endsection
