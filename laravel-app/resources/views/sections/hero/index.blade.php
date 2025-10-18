@extends('layouts.app')

@section('title', 'Administrar Sección Hero')

@section('content')
<div class="container">
    <h3 class="mb-4">Administrar Sección "Hero"</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Si existe $hero -> edita; si no, crea --}}
    @if($hero)
        <form action="{{ route('admin.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data" class="card p-3">
            @csrf
            @method('PUT')
    @else
        <form action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data" class="card p-3">
            @csrf
    @endif

        {{-- Subtítulo --}}
        <div class="mb-3">
            <label class="form-label">Subtítulo</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', optional($hero)->subtitle) }}">
            @error('subtitle') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Título principal --}}
        <div class="mb-3">
            <label class="form-label">Título principal</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', optional($hero)->title) }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', optional($hero)->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <hr class="my-4">

        {{-- Botones --}}
        <h5 class="mb-3">Botones</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Texto botón principal</label>
                <input type="text" name="button_primary_text" class="form-control" value="{{ old('button_primary_text', optional($hero)->button_primary_text) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Link botón principal</label>
                <input type="text" name="button_primary_link" class="form-control" value="{{ old('button_primary_link', optional($hero)->button_primary_link) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Texto botón secundario</label>
                <input type="text" name="button_secondary_text" class="form-control" value="{{ old('button_secondary_text', optional($hero)->button_secondary_text) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Link botón secundario</label>
                <input type="text" name="button_secondary_link" class="form-control" value="{{ old('button_secondary_link', optional($hero)->button_secondary_link) }}">
            </div>
        </div>

        <hr class="my-4">

        {{-- Logros numéricos --}}
        <h5 class="mb-3">Logros</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Años de servicio</label>
                <input type="number" name="anios_servicio" class="form-control" value="{{ old('anios_servicio', optional($hero)->anios_servicio) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Viviendas construidas</label>
                <input type="number" name="viviendas_construidas" class="form-control" value="{{ old('viviendas_construidas', optional($hero)->viviendas_construidas) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Familias beneficiadas</label>
                <input type="number" name="familias_beneficiadas" class="form-control" value="{{ old('familias_beneficiadas', optional($hero)->familias_beneficiadas) }}">
            </div>
        </div>

        <hr class="my-4">

        {{-- Imagen principal --}}
        <div class="mb-3">
            <label class="form-label">Imagen principal</label>
            @if(optional($hero)->image_main)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.optional($hero)->image_main) }}" alt="Imagen actual" class="img-fluid rounded" style="max-width:200px">
                </div>
            @endif
            <input type="file" name="image_main" class="form-control">
            @error('image_main') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <hr class="my-4">

        {{-- Badge de imagen --}}
        <h5 class="mb-3">Badge de Imagen</h5>
        <div class="mb-3">
            <label class="form-label">Texto badge</label>
            <input type="text" name="image_badge_text" class="form-control" value="{{ old('image_badge_text', optional($hero)->image_badge_text) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Subtexto badge</label>
            <input type="text" name="image_badge_subtext" class="form-control" value="{{ old('image_badge_subtext', optional($hero)->image_badge_subtext) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            {{ $hero ? 'Guardar cambios' : 'Crear Hero' }}
        </button>
    </form>
</div>
@endsection
