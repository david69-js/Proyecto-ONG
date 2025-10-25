<x-head>
  <link rel="stylesheet" href="assets/css/donadores.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</x-head>

<body class="index-page d-flex flex-column min-vh-100">
<x-header />
<main class="main flex-grow-1">

<!-- Breadcrumbs -->
<div class="breadcrumbs">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('locations.public.index') }}">Ubicaciones</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $location->nombre }}</li>
      </ol>
    </nav>
  </div>
</div>

<!-- Sección Hero -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content" data-aos="fade-right" data-aos-delay="200">
          <span class="subtitle">Ubicación</span>
          <h1>{{ $location->nombre }}</h1>
          <p>Información detallada sobre esta ubicación donde desarrollamos nuestros proyectos de construcción y apoyo comunitario.</p>
          
          <div class="hero-buttons">
            @if($location->latitud && $location->longitud)
              <a href="https://www.google.com/maps?q={{ $location->latitud }},{{ $location->longitud }}" 
                 target="_blank" class="btn-primary">
                <i class="bi bi-map"></i> Ver en Mapa
              </a>
            @endif
            <a href="{{ route('contact') }}" class="btn-secondary">Contáctanos</a>
          </div>

          <div class="trust-badges">
            <div class="badge-item">
              <i class="bi bi-geo-alt"></i>
              <div class="badge-text">
                <span class="count">{{ $location->ciudad ?? 'N/A' }}</span>
                <span class="label">Ciudad</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-flag"></i>
              <div class="badge-text">
                <span class="count">{{ $location->pais ?? 'N/A' }}</span>
                <span class="label">País</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-crosshair"></i>
              <div class="badge-text">
                <span class="count">GPS</span>
                <span class="label">Coordenadas</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="hero-image">
          <img src="{{ asset('assets/img/construction/project-4.webp') }}" alt="{{ $location->nombre }}" class="img-fluid">
          <div class="image-badge">
            <span>{{ $location->ciudad ?? 'Ubicación' }}</span>
            <p>{{ $location->pais ?? 'Guatemala' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Detalles -->
<section id="details" class="details section">
  <div class="container section-title">
    <h2>Información de la Ubicación</h2>
    <p>Detalles completos sobre esta ubicación de trabajo</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <div class="col-lg-8">
        <div class="service-card">
          <div class="service-icon">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
          <h3>Datos de Ubicación</h3>
          <div class="service-features">
            <span><i class="bi bi-building"></i> <strong>Nombre:</strong> {{ $location->nombre }}</span>
            @if($location->direccion)
              <span><i class="bi bi-geo-alt"></i> <strong>Dirección:</strong> {{ $location->direccion }}</span>
            @endif
            @if($location->ciudad)
              <span><i class="bi bi-building"></i> <strong>Ciudad:</strong> {{ $location->ciudad }}</span>
            @endif
            @if($location->pais)
              <span><i class="bi bi-flag"></i> <strong>País:</strong> {{ $location->pais }}</span>
            @endif
            @if($location->latitud && $location->longitud)
              <span><i class="bi bi-crosshair"></i> <strong>Coordenadas:</strong> {{ $location->latitud }}, {{ $location->longitud }}</span>
            @endif
          </div>
          @if($location->latitud && $location->longitud)
            <div class="mt-4">
              <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                <a href="https://www.google.com/maps?q={{ $location->latitud }},{{ $location->longitud }}" 
                   target="_blank" class="btn btn-outline-primary btn-lg">
                  <i class="bi bi-map me-2"></i> Ver en Google Maps
                </a>
                <button onclick="copyCoordinates()" class="btn btn-outline-secondary btn-lg">
                  <i class="bi bi-clipboard me-2"></i> Copiar Coordenadas
                </button>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Proyectos Relacionados (si existen) -->
@if(isset($relatedProjects) && $relatedProjects->count() > 0)
<section id="related-projects" class="related-projects section">
  <div class="container section-title">
    <h2>Proyectos en esta Ubicación</h2>
    <p>Conoce los proyectos que hemos desarrollado en esta ubicación</p>
  </div>
  
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      @foreach($relatedProjects as $project)
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-hammer"></i>
            </div>
            <h3>{{ $project->nombre }}</h3>
            <p>{{ Str::limit($project->descripcion, 100) }}</p>
            <a href="{{ route('projects.public.show', $project) }}" class="btn btn-outline-primary">
              Ver Proyecto <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<style>
/* Estilos para la vista de detalle de ubicación - Consistente con index.blade.php */
.details {
  padding: 80px 0;
  background: #f8f9fa;
}

/* Usar los mismos estilos de service-card del index */
.service-card {
  background: #fff;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.service-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #007bff, #0056b3);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  color: #fff;
  font-size: 1.5rem;
}

.service-card h3 {
  color: #333;
  font-size: 1.3rem;
  font-weight: 600;
  margin-bottom: 20px;
  text-align: center;
}

.service-features {
  margin-bottom: 20px;
}

.service-features span {
  display: block;
  color: #666;
  margin-bottom: 10px;
  padding: 8px 0;
  border-bottom: 1px solid #f0f0f0;
}

.service-features span:last-child {
  border-bottom: none;
}

.service-features i {
  color: #007bff;
  margin-right: 8px;
  width: 16px;
}

.service-features a {
  color: #007bff;
  text-decoration: none;
}

.service-features a:hover {
  text-decoration: underline;
}

/* Estilos mejorados para botones */
.btn-lg {
  padding: 12px 24px;
  font-size: 1rem;
  font-weight: 600;
  border-radius: 8px;
  transition: all 0.3s ease;
  min-width: 200px;
}

.btn-outline-primary {
  border: 2px solid #007bff;
  color: #007bff;
  background: transparent;
}

.btn-outline-primary:hover {
  background: #007bff;
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.btn-outline-secondary {
  border: 2px solid #6c757d;
  color: #6c757d;
  background: transparent;
}

.btn-outline-secondary:hover {
  background: #6c757d;
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.btn i {
  font-size: 1.1rem;
}




.related-projects {
  padding: 80px 0;
  background: #fff;
}

/* Responsive */
@media (max-width: 768px) {
  .service-card {
    margin-bottom: 20px;
  }
  
  .btn-lg {
    min-width: 150px;
    padding: 10px 20px;
    font-size: 0.9rem;
  }
  
  .d-flex.flex-column.flex-md-row {
    gap: 1rem !important;
  }
}
</style>

<script>
function copyCoordinates() {
  const coordinates = '{{ $location->latitud }}, {{ $location->longitud }}';
  navigator.clipboard.writeText(coordinates).then(function() {
    alert('Coordenadas copiadas al portapapeles: ' + coordinates);
  }, function(err) {
    console.error('Error al copiar: ', err);
  });
}
</script>

</main>
<x-footer />

