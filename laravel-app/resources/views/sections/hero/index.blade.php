@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Editar Sección "Hero"</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Título y descripciones -->
        <div class="mb-3">
            <label>Subtítulo</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $hero->subtitle) }}">
        </div>

        <div class="mb-3">
            <label>Título principal</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title) }}">
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $hero->description) }}</textarea>
        </div>

        <hr class="my-4">

        <!-- Botones -->
        <h4>Botones</h4>
        <div class="row g-3">
            <div class="col-md-6">
                <label>Texto botón principal</label>
                <input type="text" name="button_primary_text" class="form-control" value="{{ old('button_primary_text', $hero->button_primary_text) }}">
            </div>
            <div class="col-md-6">
                <label>Link botón principal</label>
                <input type="text" name="button_primary_link" class="form-control" value="{{ old('button_primary_link', $hero->button_primary_link) }}">
            </div>
            <div class="col-md-6">
                <label>Texto botón secundario</label>
                <input type="text" name="button_secondary_text" class="form-control" value="{{ old('button_secondary_text', $hero->button_secondary_text) }}">
            </div>
            <div class="col-md-6">
                <label>Link botón secundario</label>
                <input type="text" name="button_secondary_link" class="form-control" value="{{ old('button_secondary_link', $hero->button_secondary_link) }}">
            </div>
        </div>

        <hr class="my-4">

        <!-- Logros numéricos -->
        <h4>Logros</h4>
        <div class="row g-3">
            @foreach(['anios_servicio' => 'Años de servicio', 'viviendas_construidas' => 'Viviendas construidas', 'familias_beneficiadas' => 'Familias beneficiadas'] as $field => $label)
            <div class="col-md-4">
                <label>{{ $label }}</label>
                <input type="number" name="{{ $field }}" class="form-control" value="{{ old($field, $hero->$field) }}">
            </div>
            @endforeach
        </div>

        <hr class="my-4">

        <!-- Imagen principal -->
        <div class="mb-3">
            <label>Imagen principal</label><br>
            @if(!empty($hero->image_main))
                <img src="{{ asset('storage/'.$hero->image_main) }}" alt="Imagen principal" class="img-fluid rounded mb-2" width="200">
            @endif
            <input type="file" name="image_main" class="form-control">
        </div>

        <hr class="my-4">

        <!-- Badge de imagen -->
        <h4>Badge de Imagen</h4>
        <div class="mb-3">
            <label>Texto badge</label>
            <input type="text" name="image_badge_text" class="form-control" value="{{ old('image_badge_text', $hero->image_badge_text) }}">
        </div>
        <div class="mb-3">
            <label>Subtexto badge</label>
            <input type="text" name="image_badge_subtext" class="form-control" value="{{ old('image_badge_subtext', $hero->image_badge_subtext) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Guardar cambios</button>
    </form>
</div>
@endsection
