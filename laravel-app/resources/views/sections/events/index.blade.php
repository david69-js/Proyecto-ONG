@extends('layouts.tabler')

@section('title', 'Publicar Eventos en el Index')
@section('page-title', 'Publicar Eventos en el Index')
@section('page-description', 'Gestiona qué eventos aparecen en la página principal')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Eventos en Página Principal</h3>
                </div>
                <div class="card-body">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-3">
                <div class="card {{ $event->show_in_index ? 'border-success' : '' }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="text-muted">{{ Str::limit($event->description, 100) }}</p>

                        <div class="d-flex flex-wrap gap-1 mb-2">
                           <!-- Ver Evento (ADMIN) -->
<a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-info">
    <i class="fas fa-eye"></i> Ver
</a>

                            <!-- Destacar -->
                           <form action="{{ route('admin.events.toggle-featured', $event) }}" method="POST">
  @csrf
  <button type="submit"
          class="btn btn-sm {{ $event->featured ? 'btn-warning' : 'btn-outline-warning' }}">
    <i class="fas fa-star"></i> {{ $event->featured ? 'Quitar Destacado' : 'Destacar' }}
  </button>
</form>

                        </div>

                        <div class="mt-1 d-flex flex-wrap gap-1">
                            @if($event->show_in_index)
                                <span class="badge bg-success">Publicado en el Index</span>
                            @endif
                            @if($event->featured)
                                <span class="badge bg-warning">Destacado</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection