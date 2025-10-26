<!DOCTYPE html>
<html lang="es">
@php
    use Illuminate\Support\Str;
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ubicaciones | Habitat Guatemala</title>
  <meta name="description" content="Conoce las ubicaciones donde desarrollamos nuestros proyectos de construcción en Guatemala.">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files (mismo tema de eventos/proyectos) -->
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS del tema -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

  <style>
    :root{
      --accent-color: #b8860b;   /* dorado oscuro */
      --accent-color-2: #f1c40f; /* dorado claro */
    }
    .footer .footer-links ul a,.footer-contact,.footer-about,.Copyright 
{
    z-index:1;
    }

    /* ---------- HERO ---------- */
    #locations-hero.hero{
      min-height: 60vh;
      padding: 140px 0 60px;
      position: relative;
      overflow: hidden;
    }
    #locations-hero .hero-bg{
      position:absolute;inset:0;
    }
    #locations-hero .hero-bg img{
      width:100%;height:100%;object-fit:cover;filter:brightness(.55);
    }
    #locations-hero .overlay{
      position:absolute;inset:0;
      background:
        radial-gradient(1200px 600px at 15% 15%, rgba(212,175,55,.28), transparent 60%),
        linear-gradient(135deg, rgba(184,134,11,.55) 0%, rgba(241,196,15,.35) 100%);
      opacity:.9;
    }
    #locations-hero .subtitle{
      background: rgba(255,255,255,.18);
      border:1px solid rgba(255,255,255,.25);
      color:#fff; padding:.35rem .9rem; border-radius:999px;
      backdrop-filter: blur(8px);
      display:inline-flex; align-items:center; gap:.5rem;
      font-weight:600;
    }
    #locations-hero h1{ color:#fff; }
    #locations-hero p{ color:rgba(255,255,255,.9); }
    .text-white-75{ color:rgba(255,255,255,.75)!important; }

    .trust-badges{ display:flex; gap:1rem; flex-wrap:wrap; margin-top:1.25rem; }
    .badge-item{
      display:flex; align-items:center; gap:.75rem;
      background: rgba(255,255,255,.15);
      border:1px solid rgba(255,255,255,.25);
      padding:.6rem .9rem; border-radius:16px; backdrop-filter:blur(8px);
      color:#fff;
    }
    .badge-item i{ font-size:1.1rem; color:#fff; opacity:.9; }
    .badge-text .count{ font-weight:700; display:block; line-height:1; }
    .badge-text .label{ font-size:.85rem; opacity:.9; }

    .hero-buttons .btn{
      border-radius:999px; padding:.7rem 1.2rem; font-weight:600;
    }
    .btn-amber{
      background: var(--accent-color);
      border-color: var(--accent-color);
      color:#fff;
    }
    .btn-amber:hover{
      background: var(--accent-color-2); border-color: var(--accent-color-2); color:#1a1a1a;
    }

    /* ---------- FILTROS ---------- */
    .filter-card{
      border-radius:14px; box-shadow:0 6px 16px rgba(0,0,0,.06); border:0;
    }
    .filter-card .form-control, .filter-card .form-select{ border-radius:12px; }
    .filter-card .btn{ border-radius:12px; }

    /* ---------- GRID / CARD DE UBICACIÓN ---------- */
    .location-card{
      background:#fff; border-radius:14px; overflow:hidden;
      box-shadow:0 6px 16px rgba(0,0,0,.06);
      height:100%; display:flex; flex-direction:column; border:2px solid transparent;
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .location-card:hover{
      transform: translateY(-4px);
      box-shadow:0 12px 26px rgba(0,0,0,.12);
    }
    .location-card.featured{ border-color: var(--accent-color-2); box-shadow:0 8px 20px rgba(241,196,15,.25); }
    .location-badge{
      position:absolute; top:12px; left:12px;
      background: var(--accent-color-2); color:#1a1a1a;
      padding:.35rem .7rem; border-radius:999px; font-size:.8rem; font-weight:700; z-index:2;
      box-shadow:0 2px 10px rgba(241,196,15,.35);
    }

    .location-media{ position:relative; overflow:hidden; }
    .location-media img{
      width:100%; height:220px; object-fit:cover; display:block;
      transition: transform .4s ease, filter .3s ease; backface-visibility:hidden;
    }
    .location-card:hover .location-media img{ transform: scale(1.04); filter:brightness(1.06) contrast(1.04); }
    .shine::after{
      content:''; position:absolute; inset:0;
      background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,.14) 50%, transparent 70%);
      transform: translateX(-100%); transition: transform .7s ease;
    }
    .location-card:hover .shine::after{ transform: translateX(100%); }

    .location-body{ padding:1rem 1rem 1.1rem; display:flex; flex-direction:column; flex:1; }
    .location-title{ font-size:1.05rem; font-weight:700; color:#222; margin: .25rem 0 .35rem; }
    .location-desc{ color:#6b7280; font-size:.95rem; margin-bottom:.75rem; }
    .location-meta{ display:grid; grid-template-columns:1fr 1fr; gap:.35rem .75rem; font-size:.9rem; color:#444; margin-bottom: .75rem; }
    .location-meta i{ color: var(--accent-color); margin-right:.4rem; }

    .location-actions{ margin-top:auto; display:flex; gap:.5rem; flex-wrap:wrap; }
    .location-actions .btn{ border-radius:10px; font-weight:600; }

    .btn-outline-amber{
      border-color: var(--accent-color); color: var(--accent-color);
    }
    .btn-outline-amber:hover{
      background: var(--accent-color); color:#fff; border-color: var(--accent-color);
    }

    /* ---------- CTA ---------- */
    #locations-cta.call-to-action{
      background:#fff;
      border-top:1px solid #f0f2f6;
    }
    #locations-cta .btn{
      border-radius:999px; padding:.7rem 1.2rem; font-weight:700;
    }

    /* Footer click fix */
    .footer::before{ pointer-events:none!important; }
    footer, .footer, #footer{ position:relative!important; z-index:10!important; pointer-events:auto!important; }
    footer a, .footer a{ pointer-events:auto!important; }
    
    /* Clase margen */
    .margen {
      margin: auto !important;
    }

    @media (max-width: 768px){
      #locations-hero{ padding:120px 0 40px; }
      .location-media img{ height:200px; }
    }
  </style>
</head>

<body class="index-page d-flex flex-column min-vh-100">

  <!-- Header (igual al tema de eventos/proyectos) -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">Habitat Guatemala</h1> <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}">Inicio</a></li>
          <li><a href="{{ url('/#about') }}">Quiénes Somos</a></li>
          <li><a href="{{ url('/#services') }}">Eventos</a></li>
          <li><a href="{{ url('/#projects') }}">Proyectos</a></li>
          <li><a href="{{ route('contact.index2') }}">Contacto</a></li>
          <li><a href="{{ route('locations.public.index2') }}" class="active">Ubicaciones</a></li>

          @auth
            <li class="dropdown">
              <a href="#"><i class="fas fa-user"></i> {{ auth()->user()->first_name }} <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul class="dropdown-menu">
                <li><a href="/users" class="dropdown-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li><a href="{{ route('login') }}">Ingresar</a></li>
          @endauth

          <li><a href="{{ route('products.public.index2') }}">Productos</a></li>
        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <!-- /Header -->

  <main class="main flex-grow-1">

    <!-- HERO ubicaciones (imagen + dorado) -->
    <section id="locations-hero" class="hero section">
      <div class="hero-bg">
        <img src="{{ asset('assets/img/construction/project-3.webp') }}" alt="Nuestras ubicaciones">
        <div class="overlay"></div>
      </div>

      <div class="info position-relative">
        <div class="container" data-aos="fade-up" data-aos-delay="80">
          <div class="row align-items-center g-4">
            <div class="col-lg-7" data-aos="fade-right" data-aos-delay="120">
              <span class="subtitle">
                <i class="bi bi-geo-alt-fill"></i> Nuestras ubicaciones
              </span>
              <h1 class="mt-3">Conoce dónde trabajamos</h1>
              <p class="lead text-white-75 mb-4">
                Descubre las diferentes ubicaciones donde desarrollamos nuestros proyectos de construcción y apoyo comunitario en Guatemala.
              </p>

              <div class="hero-buttons d-flex flex-wrap gap-2">
                <a href="#locations-list" class="btn btn-amber">
                  Ver ubicaciones <i class="bi bi-arrow-down-short ms-1"></i>
                </a>
                <a href="{{ url('/#get-started') }}" class="btn btn-outline-light">
                  Donar ahora
                </a>
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

            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="160">
              <!-- espacio para imagen lateral si se desea -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /HERO -->

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color); opacity:.25;"></div>

    <!-- FILTROS -->
    <section class="section pt-0">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="card filter-card">
          <div class="card-body">
            <form method="GET" action="{{ route('locations.public.index2') }}" class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Buscar</label>
                <input type="text" class="form-control" name="search" placeholder="Buscar ubicaciones..."
                       value="{{ request('search') }}">
              </div>
              <div class="col-md-3">
                <label class="form-label">Ciudad</label>
                <select class="form-select" name="ciudad">
                  <option value="">Todas</option>
                  @foreach($ciudades as $ciudad)
                    <option value="{{ $ciudad }}" {{ request('ciudad') == $ciudad ? 'selected' : '' }}>
                      {{ $ciudad }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">País</label>
                <select class="form-select" name="pais">
                  <option value="">Todos</option>
                  @foreach($paises as $pais)
                    <option value="{{ $pais }}" {{ request('pais') == $pais ? 'selected' : '' }}>
                      {{ $pais }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-amber w-100">
                  <i class="bi bi-search"></i> Buscar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- GRID DE UBICACIONES -->
    <section id="locations-list" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="120">
        <div class="row gy-4">
          @forelse($locations as $location)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 150 + $loop->index*60 }}">
              <div class="location-card">
                <div class="location-media shine">
                  <span class="location-badge">{{ $location->ciudad ?? 'Ubicación' }}</span>
                  <img src="{{ asset('assets/img/construction/project-4.webp') }}" alt="{{ $location->nombre }}" loading="lazy">
                </div>
                <div class="location-body">
                  <div class="d-flex align-items-center justify-content-between gap-2">
                    <h3 class="location-title mb-0">{{ $location->nombre }}</h3>
                    @if($location->pais)
                      <div class="price-bubble">
                        <i class="bi bi-flag"></i> {{ $location->pais }}
                      </div>
                    @endif
                  </div>

                  <p class="location-desc">
                    {{ Str::limit($location->direccion ?? 'Ubicación de trabajo', 110) }}
                  </p>

                  <div class="location-meta">
                    @if($location->direccion)
                      <div><i class="bi bi-geo-alt"></i> {{ Str::limit($location->direccion, 20) }}</div>
                    @endif
                    @if($location->ciudad)
                      <div><i class="bi bi-building"></i> {{ $location->ciudad }}</div>
                    @endif
                    @if($location->telefono)
                      <div><i class="bi bi-telephone"></i> {{ $location->telefono }}</div>
                    @endif
                    @if($location->email)
                      <div><i class="bi bi-envelope"></i> {{ Str::limit($location->email, 15) }}</div>
                    @endif
                  </div>

                  <div class="location-actions">
                    <a href="{{ route('locations.public.show2', $location) }}" class="btn btn-outline-amber">
                      Ver detalle <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    @if($location->latitud && $location->longitud)
                      <a href="https://www.google.com/maps?q={{ $location->latitud }},{{ $location->longitud }}" 
                         target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-map"></i> Mapa
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="text-center py-5">
                <i class="bi bi-geo-alt fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No se encontraron ubicaciones</h4>
                <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color); opacity:.25;"></div>

    <!-- CTA -->
    <section id="locations-cta" class="call-to-action section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <div class="content">
              <h3>¿Necesitas información sobre alguna ubicación específica?</h3>
              <p>Nuestro equipo puede brindarte detalles adicionales sobre nuestros proyectos en cada ubicación.</p>
            </div>
          </div>
          <div class="col-lg-4 text-center text-lg-end">
            <a href="{{ route('contact.index2') }}" class="btn btn-amber">Contactar</a>
          </div>
        </div>
      </div>
    </section>

<style>
:root{
  --accent-color: #b8860b;   /* dorado oscuro */
  --accent-color-2: #f1c40f; /* dorado claro */
}

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
  background: linear-gradient(135deg, var(--accent-color), var(--accent-color-2));
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
  color: var(--accent-color);
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
  background: linear-gradient(135deg, var(--accent-color), var(--accent-color-2));
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

<footer id="footer" class="footer dark-background w-100" style="margin-top: auto; padding: 0;">
  <div class="container-fluid footer-top" style="padding: 2rem 1rem;">
    <div class="row gy-4">

      {{-- Columna 1: Descripción --}}
      <div class="col-lg-5 col-md-12 footer-about">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          <span class="sitename">Habitat Guatemala</span>
        </a>
        <p>
          Construyendo esperanza desde 1995. Trabajamos cada día para que las familias guatemaltecas 
          tengan acceso a una vivienda segura y un entorno digno.
        </p>
        <div class="social-links d-flex mt-4">
          <a href="https://twitter.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter-x"></i></a>
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
          <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      {{-- Columna 2: Enlaces útiles --}}
      <div class="col-lg-2 col-6 footer-links">
        <h4>Enlaces Útiles</h4>
        <ul>
          <li><a href="{{ route('home') }}">Inicio</a></li>
          <li><a href="{{ url('/#about') }}">Quiénes Somos</a></li>
          <li><a href="{{ url('/#services') }}">Eventos</a></li>
          <li><a href="{{ url('/#projects') }}">Proyectos</a></li>
          <li><a href="{{ url('/#get-started') }}">Donar</a></li>
        </ul>
      </div>

      {{-- Columna 3: Otros Enlaces --}}
      <div class="col-lg-2 col-6 footer-links">
        <h4>Otros Enlaces</h4>
        <ul>
          <li>
            <a href="tel:+50235957273" class="text-decoration-none">
              📞 +502 35957273
            </a>
          </li>
          <li>
            <a href="mailto:info@habitatguatemala.org" class="text-decoration-none">
              ✉️ info@habitatguatemala.org
            </a>
          </li>
          <li>
            <a href="https://www.facebook.com/habitatguatemala" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <i class="bi bi-facebook me-1"></i> Facebook
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/habitatguatemala" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <i class="bi bi-instagram me-1"></i> Instagram
            </a>
          </li>
          <li>
            <a href="https://www.linkedin.com/company/habitatguatemala" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
              <i class="bi bi-linkedin me-1"></i> LinkedIn
            </a>
          </li>
        </ul>
      </div>

      {{-- Columna 4: Contacto --}}
      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contáctanos</h4>
        <p>Santa Cruz del Quiché</p>
        <p>Guatemala, Centroamérica</p>
        <p>América Central</p>
        <p class="mt-4"><strong>Teléfono:</strong> <span>+502 1234-5678</span></p>
        <p><strong>Email:</strong> <span>info@habitatguatemala.org</span></p>
      </div>

    </div>
  </div>

  {{-- Derechos de autor --}}
  <div class="container-fluid copyright text-center mt-4" style="padding: 1rem;">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Habitat ong-umg</strong></p>
  </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS con helpers Laravel -->
<script src="{{ asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets2/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets2/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets2/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets2/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets2/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets2/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets2/vendor/purecounter/purecounter_vanilla.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets2/js/main.js') }}"></script>

<style>
/* ===== Footer Mejorado ===== */
.footer.dark-background {
  background: linear-gradient(180deg, #2d2d2d 0%, #444 100%) !important;
  color: #fff !important;
  border-top: 3px solid #b8860b;
  box-shadow: inset 0 10px 30px rgba(0,0,0,0.3);
}

/* Títulos */
.footer h4 {
  color: #ffd700 !important;
  font-weight: 700;
  margin-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Textos generales */
.footer p,
.footer span,
.footer a {
  color: #f5f5f5 !important;
  font-size: 1.05rem;
  line-height: 1.6;
  transition: all 0.3s ease;
}

/* Enlaces */
.footer a:hover {
  color: #ffd700 !important;
  text-decoration: underline;
}

/* Íconos de redes sociales */
.footer .social-links a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: rgba(255, 215, 0, 0.25);
  color: #ffd700 !important;
  font-size: 1.5rem;
  margin-right: 12px;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 215, 0, 0.4);
}

.footer .social-links a:hover {
  background: #ffd700 !important;
  color: #2d2d2d !important;
  transform: translateY(-4px);
  box-shadow: 0 5px 12px rgba(255, 215, 0, 0.5);
}

/* Copyright */
.footer .copyright {
  background: #2b2b2b !important;
  color: #eee;
  font-size: 1rem;
  letter-spacing: 0.3px;
}

.footer .copyright strong {
  color: #ffd700 !important;
}
</style>

</body>
</html>
