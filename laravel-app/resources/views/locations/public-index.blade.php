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
        <li class="breadcrumb-item active" aria-current="page">Ubicaciones</li>
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
          <span class="subtitle">Nuestras Ubicaciones</span>
          <h1>Conoce dónde trabajamos</h1>
          <p>Descubre las diferentes ubicaciones donde desarrollamos nuestros proyectos de construcción y apoyo comunitario en Guatemala.</p>
          
          <div class="hero-buttons">
            <a href="#locations" class="btn-primary">Ver Ubicaciones</a>
            <a href="{{ route('contact') }}" class="btn-secondary">Contáctanos</a>
          </div>

          <div class="trust-badges">
            <div class="badge-item">
              <i class="bi bi-geo-alt"></i>
              <div class="badge-text">
                <span class="count">{{ $locations->count() }}</span>
                <span class="label">Ubicaciones</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-building"></i>
              <div class="badge-text">
                <span class="count">{{ $paises->count() }}</span>
                <span class="label">Países</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-house-heart"></i>
              <div class="badge-text">
                <span class="count">{{ $ciudades->count() }}</span>
                <span class="label">Ciudades</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="hero-image">
          <img src="{{ asset('assets/img/construction/project-3.webp') }}" alt="Ubicaciones de trabajo" class="img-fluid">
          <div class="image-badge">
            <span>Presencia Nacional</span>
            <p>Construyendo en toda Guatemala</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Ubicaciones -->
<section id="locations" class="locations section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    
    <!-- Filtros -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="filter-section">
          <form method="GET" class="row g-3">
            <div class="col-md-4">
              <input type="text" name="search" class="form-control" placeholder="Buscar ubicación..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
              <select name="ciudad" class="form-control">
                <option value="">Todas las ciudades</option>
                @foreach($ciudades as $ciudad)
                  <option value="{{ $ciudad }}" {{ request('ciudad') == $ciudad ? 'selected' : '' }}>{{ $ciudad }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <select name="pais" class="form-control">
                <option value="">Todos los países</option>
                @foreach($paises as $pais)
                  <option value="{{ $pais }}" {{ request('pais') == $pais ? 'selected' : '' }}>{{ $pais }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Grid de Ubicaciones -->
    <div class="row gy-4">
      @forelse($locations as $location)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="location-card">
            <div class="location-header">
              <div class="location-icon">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <div class="location-badge">
                <span>{{ $location->ciudad ?? 'Sin ciudad' }}</span>
              </div>
            </div>

            <div class="location-content">
              <h3>{{ $location->nombre }}</h3>
              
              <div class="location-details">
                @if($location->direccion)
                  <div class="detail-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $location->direccion }}</span>
                  </div>
                @endif
                
                @if($location->ciudad)
                  <div class="detail-item">
                    <i class="bi bi-building"></i>
                    <span>{{ $location->ciudad }}</span>
                  </div>
                @endif
                
                @if($location->pais)
                  <div class="detail-item">
                    <i class="bi bi-flag"></i>
                    <span>{{ $location->pais }}</span>
                  </div>
                @endif
              </div>

              <div class="location-coordinates">
                <small class="text-muted">
                  <i class="bi bi-crosshair"></i>
                  {{ $location->latitud }}, {{ $location->longitud }}
                </small>
              </div>
            </div>

            <div class="location-actions">
              <a href="{{ route('locations.public.show', $location) }}" class="btn btn-outline-primary">
                Ver Detalles <i class="bi bi-arrow-right ms-1"></i>
              </a>
              @if($location->latitud && $location->longitud)
                <a href="https://www.google.com/maps?q={{ $location->latitud }},{{ $location->longitud }}" 
                   target="_blank" class="btn btn-outline-secondary">
                  <i class="bi bi-map"></i> Ver en Mapa
                </a>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center py-5">
            <i class="bi bi-geo-alt display-1 text-muted"></i>
            <h3 class="mt-3">No se encontraron ubicaciones</h3>
            <p class="text-muted">No hay ubicaciones que coincidan con los filtros aplicados.</p>
            <a href="{{ route('locations.public.index') }}" class="btn btn-primary">Ver Todas</a>
          </div>
        </div>
      @endforelse
    </div>

    <!-- Información adicional -->
   
  </div>
</section>

<style>
/* Estilos para la sección de ubicaciones */
.locations {
  padding: 80px 0;
  background: #f8f9fa;
}

.filter-section {
  background: #fff;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  margin-bottom: 40px;
}

.location-card {
  background: #fff;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
}

.location-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.location-header {
  position: relative;
  padding: 20px 20px 10px;
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: #fff;
}

.location-icon {
  width: 50px;
  height: 50px;
  background: rgba(255,255,255,0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 15px;
  font-size: 1.5rem;
}

.location-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: rgba(255,255,255,0.2);
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.location-content {
  padding: 20px;
}

.location-content h3 {
  color: #333;
  font-size: 1.3rem;
  font-weight: 600;
  margin-bottom: 15px;
}

.location-details {
  margin-bottom: 15px;
}

.detail-item {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
  color: #666;
  font-size: 0.9rem;
}

.detail-item i {
  color: #007bff;
  margin-right: 10px;
  width: 16px;
}

.location-coordinates {
  padding: 10px;
  background: #f8f9fa;
  border-radius: 8px;
  text-align: center;
}

.location-actions {
  padding: 20px;
  border-top: 1px solid #eee;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.location-actions .btn {
  flex: 1;
  min-width: 120px;
}

.info-section {
  background: #fff;
  padding: 40px 30px;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.info-card {
  padding: 20px;
  transition: transform 0.3s ease;
}

.info-card:hover {
  transform: translateY(-5px);
}

.info-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #28a745, #20c997);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 15px;
  color: #fff;
  font-size: 1.5rem;
}

.info-card h5 {
  color: #333;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 10px;
}

.info-card p {
  color: #666;
  margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
  .location-actions {
    flex-direction: column;
  }
  
  .location-actions .btn {
    flex: none;
  }
  
  .filter-section {
    padding: 20px;
  }
}
</style>

</main>
<x-footer />
