@extends('layouts.tabler')

@section('title', 'Seleccionar Página Pública Predeterminada')

@section('content')
<div class="container-xl py-5">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
      <h3 class="card-title mb-0">
        <i class="fas fa-globe me-2"></i> Página pública predeterminada
      </h3>
    </div>

    <div class="card-body">
      @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
      @endif

      <form method="POST" action="{{ route('admin.public.index-selector.update') }}">
        @csrf
        <div class="mb-4">
          <label class="form-label fw-bold">Elige cuál index se cargará al entrar al sitio:</label>
          <select name="home_index" class="form-select form-select-lg">
            @foreach($options as $key => $label)
              <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
        </div>

        <button class="btn btn-primary w-100">
          <i class="fas fa-save me-2"></i> Guardar selección
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
