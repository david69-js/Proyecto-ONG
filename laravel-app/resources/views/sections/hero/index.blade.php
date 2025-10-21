@extends('layouts.tabler')

@section('title', 'Administrar Sección Hero')
@section('page-title', 'Administrar Sección Hero')
@section('page-description', 'Gestiona el contenido de la sección principal del sitio web')

@section('content')
<div class="container-xl">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Sección "Hero"</h3></div>
        <div class="card-body">

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form action="{{ route('admin.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Subtítulo --}}
            <div class="mb-3">
              <label class="form-label">Subtítulo</label>
              <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                     value="{{ old('subtitle', $hero->subtitle) }}">
              @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Título principal --}}
            <div class="mb-3">
              <label class="form-label">Título principal</label>
              <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                     value="{{ old('title', $hero->title) }}">
              @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $hero->description) }}</textarea>
              @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="hr-text">Botones</div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Texto botón principal</label>
                <input type="text" name="button_primary_text" class="form-control"
                       value="{{ old('button_primary_text', $hero->button_primary_text) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Link botón principal</label>
                <input type="text" name="button_primary_link" class="form-control"
                       value="{{ old('button_primary_link', $hero->button_primary_link) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Texto botón secundario</label>
                <input type="text" name="button_secondary_text" class="form-control"
                       value="{{ old('button_secondary_text', $hero->button_secondary_text) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Link botón secundario</label>
                <input type="text" name="button_secondary_link" class="form-control"
                       value="{{ old('button_secondary_link', $hero->button_secondary_link) }}">
              </div>
            </div>

            <hr class="my-4">

            {{-- Logros numéricos --}}
            <h5 class="mb-3">Logros</h5>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Años de servicio</label>
                <input type="number" name="anios_servicio" class="form-control"
                       value="{{ old('anios_servicio', $hero->anios_servicio) }}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Viviendas construidas</label>
                <input type="number" name="viviendas_construidas" class="form-control"
                       value="{{ old('viviendas_construidas', $hero->viviendas_construidas) }}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Familias beneficiadas</label>
                <input type="number" name="familias_beneficiadas" class="form-control"
                       value="{{ old('familias_beneficiadas', $hero->familias_beneficiadas) }}">
              </div>
            </div>

            <hr class="my-4">

            {{-- Imagen principal --}}
            <div class="mb-3">
              <label class="form-label">Imagen principal</label>
              <input type="file" name="image_main" class="form-control @error('image_main') is-invalid @enderror">
              @error('image_main') <div class="invalid-feedback">{{ $message }}</div> @enderror

              @if($hero->image_main)
                <div class="mt-2">
                  <img src="{{ asset('storage/'.$hero->image_main) }}" alt="Hero actual" style="max-height: 120px;">
                </div>
              @endif
            </div>

            {{-- Badge sobre la imagen --}}
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Badge: texto</label>
                <input type="text" name="image_badge_text" class="form-control"
                       value="{{ old('image_badge_text', $hero->image_badge_text) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Badge: subtexto</label>
                <input type="text" name="image_badge_subtext" class="form-control"
                       value="{{ old('image_badge_subtext', $hero->image_badge_subtext) }}">
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
