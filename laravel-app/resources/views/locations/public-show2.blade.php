<!DOCTYPE html>
<html lang="es">
@php
    use Illuminate\Support\Str;
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $location->nombre }} | Habitat Guatemala</title>
  <meta name="description" content="Conoce más sobre {{ $location->nombre }} y nuestros proyectos en esta ubicación.">
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
    #location-hero.hero{
      min-height: 60vh;
      padding: 140px 0 60px;
      position: relative;
      overflow: hidden;
    }
    #location-hero .hero-bg{
      position:absolute;inset:0;
    }
    #location-hero .hero-bg img{
      width:100%;height:100%;object-fit:cover;filter:brightness(.55);
    }
    #location-hero .overlay{
      position:absolute;inset:0;
      background:
        radial-gradient(1200px 600px at 15% 15%, rgba(212,175,55,.28), transparent 60%),
        linear-gradient(135deg, rgba(184,134,11,.55) 0%, rgba(241,196,15,.35) 100%);
      opacity:.9;
    }
    #location-hero .subtitle{
      background: rgba(255,255,255,.18);
      border:1px solid rgba(255,255,255,.25);
      color:#fff; padding:.35rem .9rem; border-radius:999px;
      backdrop-filter: blur(8px);
      display:inline-flex; align-items:center; gap:.5rem;
      font-weight:600;
    }
    #location-hero h1{ color:#fff; }
    #location-hero p{ color:rgba(255,255,255,.9); }
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

    /* ---------- DETAILS ---------- */
    .details-card{
      background:#fff; border-radius:14px; overflow:hidden;
      box-shadow:0 6px 16px rgba(0,0,0,.06);
      border:2px solid transparent;
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .details-card:hover{
      transform: translateY(-4px);
      box-shadow:0 12px 26px rgba(0,0,0,.12);
    }

    .details-body{ padding:2rem; }
    .details-title{ font-size:1.3rem; font-weight:700; color:#222; margin-bottom:1.5rem; }
    .details-meta{ display:grid; grid-template-columns:1fr; gap:.75rem; font-size:.95rem; color:#444; margin-bottom:1.5rem; }
    .details-meta i{ color: var(--accent-color); margin-right:.5rem; width:20px; }

    .btn-outline-amber{
      border-color: var(--accent-color); color: var(--accent-color);
    }
    .btn-outline-amber:hover{
      background: var(--accent-color); color:#fff; border-color: var(--accent-color);
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
      #location-hero{ padding:120px 0 40px; }
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
          <li><a href="{{ route('locations.public.index2') }}">Ubicaciones</a></li>

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

    <!-- HERO ubicación (imagen + dorado) -->
    <section id="location-hero" class="hero section">
      <div class="hero-bg">
        <img src="{{ asset('assets/img/construction/project-4.webp') }}" alt="{{ $location->nombre }}">
        <div class="overlay"></div>
      </div>

      <div class="info position-relative">
        <div class="container" data-aos="fade-up" data-aos-delay="80">
          <div class="row align-items-center g-4">
            <div class="col-lg-7" data-aos="fade-right" data-aos-delay="120">
              <span class="subtitle">
                <i class="bi bi-geo-alt-fill"></i> Ubicación
              </span>
              <h1 class="mt-3">{{ $location->nombre }}</h1>
              <p class="lead text-white-75 mb-4">
                Información detallada sobre esta ubicación donde desarrollamos nuestros proyectos de construcción y apoyo comunitario.
              </p>

              <div class="hero-buttons d-flex flex-wrap gap-2">
                @if($location->latitud && $location->longitud)
                  <a href="https://www.google.com/maps?q={{ $location->latitud }},{{ $location->longitud }}" 
                     target="_blank" class="btn btn-amber">
                    <i class="bi bi-map"></i> Ver en Mapa
                  </a>
                @endif
                <a href="{{ route('contact.index2') }}" class="btn btn-outline-light">
                  Contactar
                </a>
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

    <!-- DETALLES -->
    <section class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="details-card">
              <div class="details-body">
                <h2 class="details-title text-center">
                  <i class="bi bi-geo-alt-fill me-2"></i>Datos de Ubicación
                </h2>
                
                <div class="details-meta">
                  <div><i class="bi bi-building"></i> <strong>Nombre:</strong> {{ $location->nombre }}</div>
                  @if($location->direccion)
                    <div><i class="bi bi-geo-alt"></i> <strong>Dirección:</strong> {{ $location->direccion }}</div>
                  @endif
                  @if($location->ciudad)
                    <div><i class="bi bi-building"></i> <strong>Ciudad:</strong> {{ $location->ciudad }}</div>
                  @endif
                  @if($location->pais)
                    <div><i class="bi bi-flag"></i> <strong>País:</strong> {{ $location->pais }}</div>
                  @endif
                  @if($location->telefono)
                    <div><i class="bi bi-telephone"></i> <strong>Teléfono:</strong> {{ $location->telefono }}</div>
                  @endif
                  @if($location->email)
                    <div><i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $location->email }}</div>
                  @endif
                  @if($location->horario)
                    <div><i class="bi bi-clock"></i> <strong>Horario:</strong> {{ $location->horario }}</div>
                  @endif
                  @if($location->latitud && $location->longitud)
                    <div><i class="bi bi-crosshair"></i> <strong>Coordenadas:</strong> {{ $location->latitud }}, {{ $location->longitud }}</div>
                  @endif
                </div>

                @if($location->latitud && $location->longitud)
                  <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                    <a href="https://www.google.com/maps?q={{ $location->latitud }},{{ $location->longitud }}" 
                       target="_blank" class="btn btn-outline-amber">
                      <i class="bi bi-map me-2"></i> Ver en Google Maps
                    </a>
                    <button onclick="copyCoordinates()" class="btn btn-outline-secondary">
                      <i class="bi bi-clipboard me-2"></i> Copiar Coordenadas
                    </button>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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

  <!-- Footer (igual al tema) -->
  <footer id="footer" class="footer dark-background margen w-100 mt-auto" style="padding: 0;">
    <div class="container-fluid footer-top" style="padding: 2rem 1rem;">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <span class="sitename">Habitat Guatemala</span>
          </a>
          <p>Construyendo esperanza desde 1995. Trabajamos para que las familias guatemaltecas tengan acceso a una vivienda segura y un entorno digno.</p>
          <div class="social-links d-flex mt-4">
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter-x"></i></a>
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

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

        <div class="col-lg-2 col-6 footer-links">
          <h4>Otros Enlaces</h4>
          <ul>
            <li><a href="tel:+50235957273">📞 +502 35957273</a></li>
            <li><a href="mailto:info@habitatguatemala.org">✉️ info@habitatguatemala.org</a></li>
            <li><a href="https://www.facebook.com/habitatguatemala" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook me-1"></i> Facebook</a></li>
            <li><a href="https://www.instagram.com/habitatguatemala" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram me-1"></i> Instagram</a></li>
            <li><a href="https://www.linkedin.com/company/habitatguatemala" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin me-1"></i> LinkedIn</a></li>
          </ul>
        </div>

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

  <!-- Vendor JS -->
  <script src="{{ asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets2/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets2/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <!-- Main JS del tema -->
  <script src="{{ asset('assets2/js/main.js') }}"></script>
</body>
</html>
