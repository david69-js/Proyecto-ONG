@extends('layouts.tabler')

@section('title', 'Administrar Sección Hero')
@section('page-title', 'Administrar Sección Hero')
@section('page-description', 'Gestiona el contenido de la sección principal del sitio web')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Sección "Hero"</h3>
                </div>
                <div class="card-body">

                    {{-- Mensaje de éxito --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Formulario --}}
<form action="{{ route('admin.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')


                        {{-- Subtítulo --}}
                        <div class="mb-3">
                            <label class="form-label">Subtítulo</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $hero->subtitle) }}">
                        </div>

                        {{-- Título principal --}}
                        <div class="mb-3">
                            <label class="form-label">Título principal</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title) }}">
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $hero->description) }}</textarea>
                        </div>

                        <hr class="my-4">

                        {{-- Botones --}}
                        <h5>Botones</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Texto botón principal</label>
                                <input type="text" name="button_primary_text" class="form-control" value="{{ old('button_primary_text', $hero->button_primary_text) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Link botón principal</label>
                                <input type="text" name="button_primary_link" class="form-control" value="{{ old('button_primary_link', $hero->button_primary_link) }}">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Texto botón secundario</label>
                                <input type="text" name="button_secondary_text" class="form-control" value="{{ old('button_secondary_text', $hero->button_secondary_text) }}">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Link botón secundario</label>
                                <input type="text" name="button_secondary_link" class="form-control" value="{{ old('button_secondary_link', $hero->button_secondary_link) }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Logros numéricos --}}
                        <h5>Logros</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Años de servicio</label>
                                <input type="number" name="anios_servicio" class="form-control" value="{{ old('anios_servicio', $hero->anios_servicio) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Viviendas construidas</label>
                                <input type="number" name="viviendas_construidas" class="form-control" value="{{ old('viviendas_construidas', $hero->viviendas_construidas) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Familias beneficiadas</label>
                                <input type="number" name="familias_beneficiadas" class="form-control" value="{{ old('familias_beneficiadas', $hero->familias_beneficiadas) }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Imagen principal --}}
                        <h5>Imagen principal</h5>
                        <div class="mb-3">
                            @if($hero->image_main)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$hero->image_main) }}" alt="Imagen actual" class="img-fluid rounded border" style="max-width:250px">
                                </div>
                            @endif
                            <input type="file" name="image_main" class="form-control">
                            <small class="text-muted">Formatos permitidos: jpg, jpeg, png, webp (máx. 4MB)</small>
                        </div>

                        <hr class="my-4">

                        {{-- Badge de imagen --}}
                        <h5>Badge de Imagen</h5>
                        <div class="mb-3">
                            <label class="form-label">Texto badge</label>
                            <input type="text" name="image_badge_text" class="form-control" value="{{ old('image_badge_text', $hero->image_badge_text) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subtexto badge</label>
                            <input type="text" name="image_badge_subtext" class="form-control" value="{{ old('image_badge_subtext', $hero->image_badge_subtext) }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
