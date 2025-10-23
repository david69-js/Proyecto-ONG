<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $event->title }} - Evento</title>

  {{-- Estilos base --}}
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <style>
    body {
      background-color: #f8fafc;
      color: #1e293b;
      font-family: "Poppins", sans-serif;
    }
    .hero-image {
      height: 350px;
      width: 100%;
      object-fit: cover;
      filter: brightness(65%);
      border-radius: 8px;
    }
    .section-title {
      text-align: center;
      margin-bottom: 40px;
    }
    .section-title h2 {
      font-weight: 700;
      color: #0f172a;
    }
    .list-group-item strong {
      color: #0f172a;
    }
  </style>
</head>

<body>

  <main class="container py-5">

    {{-- Título y descripción --}}
    <div class="section-title" data-aos="fade-up">
      <h2>{{ $event->title }}</h2>
      <p class="text-muted">{{ $event->subtitle ?? 'Evento institucional' }}</p>
      <span class="badge {{ $event->status == 'finalizado' ? 'bg-secondary' : 'bg-success' }} fs-6 px-3 py-2">
        {{ ucfirst($event->status ?? 'Activo') }}
      </span>
    </div>

    {{-- Descripción principal --}}
    <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
      <p class="lead text-center">{{ $event->description ?? 'Sin descripción disponible' }}</p>
    </div>

    {{-- Detalles del evento --}}
    <div class="row gy-4" data-aos="fade-up" data-aos-delay="150">
      <div class="col-lg-6">
        <h4 class="fw-bold text-primary mb-3">Detalles del Evento</h4>
        <ul class="list-group list-group-flush shadow-sm rounded">
          <li class="list-group-item"><strong>Ubicación:</strong> {{ $event->location ?? 'No definida' }}</li>
          <li class="list-group-item"><strong>Fecha de inicio:</strong> {{ optional($event->start_date)->format('d/m/Y') ?? 'N/D' }}</li>
          <li class="list-group-item"><strong>Fecha de finalización:</strong> {{ optional($event->end_date)->format('d/m/Y') ?? 'N/D' }}</li>
          <li class="list-group-item"><strong>Hora:</strong> {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : 'N/D' }}</li>
          <li class="list-group-item"><strong>Tipo de evento:</strong> {{ ucfirst($event->event_type ?? 'General') }}</li>
        </ul>
      </div>

      <div class="col-lg-6">
        <h4 class="fw-bold text-primary mb-3">Información adicional</h4>
        @if($event->goals)
          <p><strong>Objetivos:</strong> {{ $event->goals }}</p>
        @endif
        @if($event->results)
          <p><strong>Resultados:</strong> {{ $event->results }}</p>
        @endif
        @if($event->organizer)
          <p><strong>Organizador:</strong> {{ $event->organizer }}</p>
        @endif
      </div>
    </div>

    {{-- Botón de regreso --}}
    <div class="mt-5 text-center">
      <a href="{{ route('home') }}#events" class="btn btn-outline-primary px-4 py-2">
        <i class="bi bi-arrow-left"></i> Volver a Eventos
      </a>
    </div>

  </main>

  {{-- Scripts --}}
  <script src="{{ asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/aos/aos.js') }}"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
