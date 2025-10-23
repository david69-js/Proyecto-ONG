<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $project->nombre }} - Proyecto</title>

  {{-- Estilos base --}}
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
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
      filter: brightness(60%);
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

    {{-- Imagen principal --}}
    <div class="text-center mb-4">
      <img src="{{ $project->imagen ? asset('storage/' . $project->imagen) : asset('assets2/img/projects/construction-1.jpg') }}"
           alt="{{ $project->nombre }}" class="hero-image shadow">
    </div>

    {{-- Título y descripción --}}
    <div class="section-title" data-aos="fade-up">
      <h2>{{ $project->nombre }}</h2>
      <p class="text-muted">{{ $project->descripcion ?? 'Proyecto en ejecución' }}</p>
      <span class="badge bg-success fs-6">{{ ucfirst($project->estado ?? 'Activo') }}</span>
    </div>

    {{-- Carrusel de imágenes de fases --}}
    @if($project->phaseImages->count() > 0)
      <div id="carouselProject{{ $project->id }}" class="carousel slide mb-5 shadow" data-bs-ride="carousel">
        <div class="carousel-inner rounded">
          @foreach($project->phaseImages as $index => $image)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
              <img src="{{ asset('storage/' . $image->image_path) }}"
                   class="d-block w-100"
                   alt="{{ $image->description ?? $project->nombre }}"
                   style="object-fit: cover; height: 400px;">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded px-3 py-1">
                <small class="text-white">
                  Fase: {{ ucfirst($image->fase) }}
                  @if($image->description)
                    — {{ $image->description }}
                  @endif
                </small>
              </div>
            </div>
          @endforeach
        </div>

        @if($project->phaseImages->count() > 1)
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        @endif
      </div>
    @endif

    {{-- Detalles del proyecto --}}
    <div class="row gy-4">
      <div class="col-lg-6">
        <h4 class="fw-bold text-primary mb-3">Detalles del Proyecto</h4>
        <ul class="list-group list-group-flush shadow-sm rounded">
          <li class="list-group-item"><strong>Ubicación:</strong> {{ $project->ubicacion ?? 'No definida' }}</li>
          <li class="list-group-item"><strong>Responsable:</strong> {{ $project->responsable?->first_name }} {{ $project->responsable?->last_name }}</li>
          <li class="list-group-item"><strong>Presupuesto:</strong> Q.{{ number_format($project->presupuesto_total ?? 0, 2) }}</li>
          <li class="list-group-item"><strong>Duración:</strong> {{ $project->duracion_meses ?? 'N/D' }} meses</li>
          <li class="list-group-item"><strong>Beneficiarios:</strong> {{ $project->beneficiarios ?? 'No especificados' }}</li>
        </ul>
      </div>

      <div class="col-lg-6">
        <h4 class="fw-bold text-primary mb-3">Resultados</h4>
        <p><strong>Esperados:</strong> {{ $project->resultados_esperados ?? 'Sin información' }}</p>
        <p><strong>Obtenidos:</strong> {{ $project->resultados_obtenidos ?? 'Aún no disponibles' }}</p>
      </div>
    </div>

    {{-- Botón de regreso --}}
    <div class="mt-5 text-center">
      <a href="{{ route('home.alt') }}#projects" class="btn btn-outline-primary px-4 py-2">
        <i class="bi bi-arrow-left"></i> Volver a Proyectos
      </a>
    </div>
  </main>

  {{-- Scripts --}}
  <script src="{{ asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets2/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
