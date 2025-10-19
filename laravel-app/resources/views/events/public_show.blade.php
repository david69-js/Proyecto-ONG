@extends('layouts.app')

@section('content')
<section class="event-details section">
  <div class="container" data-aos="fade-up">
    <h2 class="mb-3">{{ $event->title }}</h2>

    <div class="event-meta mb-3">
      <span class="badge bg-{{ $event->event_type_color }}">{{ $event->event_type_formatted }}</span>
      <span class="badge bg-{{ $event->status_color }}">{{ $event->status_formatted }}</span>
    </div>

    @if($event->image_path)
      <img src="{{ asset('storage/'.$event->image_path) }}" 
           class="img-fluid rounded mb-4" 
           alt="{{ $event->title }}">
    @endif

    <p class="lead">{{ $event->description }}</p>

    <ul class="list-unstyled mt-4">
      <li><i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong> {{ $event->location ?? 'Sin ubicación' }}</li>
      <li><i class="bi bi-clock"></i> <strong>Inicio:</strong> {{ $event->start_date->format('d/m/Y H:i') }}</li>
      @if($event->end_date)
        <li><i class="bi bi-clock-history"></i> <strong>Fin:</strong> {{ $event->end_date->format('d/m/Y H:i') }}</li>
      @endif
      @if($event->cost > 0)
        <li><i class="bi bi-cash"></i> <strong>Costo:</strong> Q{{ number_format($event->cost, 2) }}</li>
      @endif
      @if($event->contact_email)
        <li><i class="bi bi-envelope"></i> <strong>Contacto:</strong> {{ $event->contact_email }}</li>
      @endif
      @if($event->contact_phone)
        <li><i class="bi bi-telephone"></i> <strong>Teléfono:</strong> {{ $event->contact_phone }}</li>
      @endif
    </ul>

    @if($event->registration_required && $event->is_registration_open)
      <a href="#registro" class="btn btn-primary mt-4">Registrarme</a>
    @endif
  </div>
</section>
@endsection
