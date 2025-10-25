<!DOCTYPE html>
<html lang="es">
@php
  use Illuminate\Support\Str;
  use Illuminate\Support\Facades\Route as R;

  // Traducciones auxiliares
  $statusTranslations = [
    'draft'     => 'Borrador',
    'published' => 'Publicado',
    'cancelled' => 'Cancelado',
    'completed' => 'Completado'
  ];
  $statusText = $statusTranslations[$event->status] ?? 'Activo';

  $typeTranslations = [
    'fundraising' => 'Recaudación de Fondos',
    'volunteer'   => 'Voluntariado',
    'awareness'   => 'Concientización',
    'community'   => 'Comunitario',
    'training'    => 'Capacitación',
    'other'       => 'Otro'
  ];
  $typeText = $typeTranslations[$event->event_type] ?? ($event->event_type ? ucfirst($event->event_type) : null);

  // Paleta dorada
  $goldDark = '#b8860b';   // darkgoldenrod
  $gold     = '#f1c40f';   // amarillo dorado
@endphp

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $event->title }} - Evento | Habitat Guatemala</title>
  <meta name="description" content="{{ Str::limit(strip_tags($event->description ?? 'Conoce más sobre este evento de Habitat Guatemala'), 160) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS (tema) -->
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS del tema -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

  <style>
    /* —— Ajustes específicos para página de evento con look & feel del tema —— */
    body.event-page { background-color: var(--background-color, #fff); }

    /* Hero dorado */
    .hero-gold-fallback {
      background:
        radial-gradient(1200px 600px at 15% 15%, rgba(212,175,55,.35), transparent),
        linear-gradient(135deg, {{ $goldDark }} 0%, {{ $gold }} 100%);
      opacity: .9;
    }

    .text-white-75 { color: rgba(255,255,255,.78) !important; }

    .event-quick-info .info-item {
      background: rgba(255,255,255,.12);
      color: rgba(255,255,255,.95);
      padding: .5rem 1rem;
      border-radius: 25px;
      border: 1px solid rgba(255,255,255,.25);
      backdrop-filter: blur(8px);
    }

    .service-card {
      background: #fff;
      border-radius: 12px;
      padding: 1.25rem;
      box-shadow: 0 6px 16px rgba(0,0,0,.06);
    }

    .service-details .detail-item { margin-bottom: 1.1rem; padding-bottom: .75rem; border-bottom: 1px solid #eee; }
    .service-details .detail-item:last-child { border-bottom: none; }

    /* Botón primario con dorado */
    .btn-gold {
      background: {{ $goldDark }};
      color: #fff;
      border: none;
    }
    .btn-gold:hover { filter: brightness(.95); color:#fff; }
    .btn-outline-gold {
      border: 1px solid {{ $goldDark }};
      color: {{ $goldDark }};
      background: transparent;
    }
    .btn-outline-gold:hover {
      background: {{ $goldDark }};
      color: #fff;
    }

    /* Badges */
    .badge-gold { background: {{ $gold }}; color: #111; }
    .badge-gold-dark { background: {{ $goldDark }}; color: #fff; }

    /* Separadores */
    .divider-soft { border-color: var(--accent-color, {{ $goldDark }}); opacity:.25; }

    /* Carrusel (si se usa en galería secundaria) */
    .carousel-control-prev-icon, .carousel-control-next-icon {
      background-color: #000 !important;
      border: 2px solid #fff !important;
      border-radius: 50% !important;
      width: 44px !important; height: 44px !important;
      opacity: .9 !important;
      background-size: 60% 60%;
    }
    .carousel-control-prev, .carousel-control-next { width: 80px !important; opacity: 1 !important; }

    /* Fix clics en footer (tema) */
    .footer::before { pointer-events: none !important; }
    footer, .footer, #footer { position: relative !important; z-index: 10 !important; pointer-events: auto !important; }
    footer a, .footer a { pointer-events: auto !important; }
  </style>
</head>

<body class="event-page index-page d-flex flex-column min-vh-100">

  <!-- Header del tema -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">Habitat Guatemala</h1><span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}">Inicio</a></li>
          <li><a href="{{ url('/#about') }}">Quiénes Somos</a></li>
          <li><a href="{{ url('/#services') }}" class="active">Eventos</a></li>
          <li><a href="{{ url('/#projects') }}">Proyectos</a></li>
          <li><a href="{{ url('/#get-started') }}">Donaciones</a></li>

          <li class="dropdown">
            <a href="#"><span>Más</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ url('/#testimonios') }}">Testimonios</a></li>
              <li><a href="{{ url('/#patrocinadores') }}">Patrocinadores</a></li>
              <li><a href="{{ url('/#contact') }}">Contacto</a></li>
            </ul>
          </li>

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

          <li><a href="{{ route('products.public.index') }}">Productos</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <!-- /Header -->

  <main class="main flex-grow-1">

    <!-- HERO del Evento -->
    <section id="event-hero" class="hero section dark-background position-relative" style="min-height:56vh; padding: 140px 0 60px; overflow:hidden;">
      <div class="hero-bg position-absolute top-0 start-0 w-100 h-100">
        @if($event->image_url)
          <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-100 h-100" style="object-fit:cover; filter: brightness(.45);">
        @else
          <div class="w-100 h-100 hero-gold-fallback"></div>
        @endif
      </div>

      <div class="info position-relative text-white">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-right" data-aos-delay="150">
              <!-- Estado -->
              <span class="d-inline-block mb-3 px-3 py-1 rounded-pill" style="background: rgba(255,255,255,.2); backdrop-filter: blur(8px);">
                <i class="bi bi-calendar-event me-2"></i>{{ $statusText }}
              </span>

              <h1 class="fw-bold text-white mb-2">{{ $event->title }}</h1>

              @if($event->subtitle)
                <p class="lead text-white-75 mb-3">{{ $event->subtitle }}</p>
              @endif

              <p class="text-white-75 mb-4">{{ $event->description ?? 'Evento organizado por Habitat Guatemala' }}</p>

              <!-- Info rápida -->
              <div class="event-quick-info d-flex flex-wrap gap-3">
                @if($event->start_date)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-calendar-check me-2"></i><span>{{ $event->start_date->format('d/m/Y') }}</span></div>
                @endif
                @if($event->location)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-geo-alt me-2"></i><span>{{ $event->location }}</span></div>
                @endif
                @if($event->start_time)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-clock me-2"></i><span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span></div>
                @endif
                @if($event->cost > 0)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-currency-dollar me-2"></i><span>Q{{ number_format($event->cost, 2) }}</span></div>
                @endif
                @if($event->max_participants)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-people me-2"></i><span>{{ $event->current_participants }}/{{ $event->max_participants }} participantes</span></div>
                @endif
              </div>
            </div>

            <div class="col-lg-4 text-center" data-aos="fade-left" data-aos-delay="220">
              @if($typeText)
                <div class="mb-3">
                  <span class="badge badge-gold-dark px-3 py-2 rounded-pill"><i class="bi bi-tag me-1"></i> {{ $typeText }}</span>
                </div>
              @endif
              @if($event->image_url)
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded shadow" style="max-height: 240px; object-fit: cover;">
              @else
                <i class="bi bi-calendar-event" style="font-size: 4rem; color: rgba(255,255,255,.35);"></i>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /HERO -->

    <!-- Separador -->
    <div class="container"><hr class="my-5 divider-soft"></div>

    <!-- Detalles del Evento -->
    <section id="event-details" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="section-title">
          <h2>Detalles del Evento</h2>
          <p>Información completa sobre este evento organizado por Habitat Guatemala</p>
        </div>

        @if($event->image_url)
          <div class="row mb-4">
            <div class="col-12" data-aos="fade-up" data-aos-delay="130">
              <div class="text-center">
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded shadow" style="max-height: 420px; object-fit: cover;">
              </div>
            </div>
          </div>
        @endif

        <div class="row gy-4">
          <!-- Col 1: Información General -->
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="160">
            <div class="service-card h-100">
              <h3 class="mb-3">Información General</h3>
              <div class="service-features">
                @if($event->location)
                  <div class="mb-2"><i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong><br><span class="ms-3">{{ $event->location }}</span></div>
                @endif
                @if($event->start_date)
                  <div class="mb-2"><i class="bi bi-calendar-check"></i> <strong>Inicio:</strong><br><span class="ms-3">{{ $event->start_date->format('d/m/Y') }}</span></div>
                @endif
                @if($event->end_date)
                  <div class="mb-2"><i class="bi bi-calendar-x"></i> <strong>Fin:</strong><br><span class="ms-3">{{ $event->end_date->format('d/m/Y') }}</span></div>
                @endif
                @if($event->start_time)
                  <div class="mb-2"><i class="bi bi-clock"></i> <strong>Hora:</strong><br><span class="ms-3">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span></div>
                @endif
                @if($typeText)
                  <div class="mb-2"><i class="bi bi-tag"></i> <strong>Tipo:</strong><br><span class="ms-3">{{ $typeText }}</span></div>
                @endif
                @if($event->cost > 0)
                  <div class="mb-2"><i class="bi bi-currency-dollar"></i> <strong>Costo:</strong><br><span class="ms-3">Q{{ number_format($event->cost, 2) }}</span></div>
                @endif
                @if($event->max_participants)
                  <div class="mb-2"><i class="bi bi-people"></i> <strong>Cupos:</strong><br><span class="ms-3">{{ $event->current_participants }}/{{ $event->max_participants }}</span></div>
                @endif
              </div>
            </div>
          </div>

          <!-- Col 2: Detalles adicionales -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="190">
            <div class="service-card h-100">
              <h3 class="mb-3">Detalles Adicionales</h3>
              <div class="service-details">
                @if($event->requirements)
                  <div class="detail-item">
                    <h5 class="mb-1"><i class="bi bi-list-check me-2"></i><strong>Requisitos</strong></h5>
                    <p class="ms-1">{{ $event->requirements }}</p>
                  </div>
                @endif
                @if($event->address)
                  <div class="detail-item">
                    <h5 class="mb-1"><i class="bi bi-geo-alt-fill me-2"></i><strong>Dirección</strong></h5>
                    <p class="ms-1">{{ $event->address }}</p>
                  </div>
                @endif
                @if($event->contact_email || $event->contact_phone)
                  <div class="detail-item">
                    <h5 class="mb-1"><i class="bi bi-envelope me-2"></i><strong>Contacto</strong></h5>
                    <p class="ms-1">
                      @if($event->contact_email)
                        <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                      @endif
                      @if($event->contact_phone)
                        <br><a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                      @endif
                    </p>
                  </div>
                @endif

                @if($event->registration_required)
                  <div class="detail-item">
                    <h5 class="mb-1"><i class="bi bi-person-plus me-2"></i><strong>Registro</strong></h5>
                    <p class="ms-1 mb-0">Registro requerido</p>
                    @if($event->registration_deadline)
                      <small class="text-muted ms-1">Fecha límite: {{ $event->registration_deadline->format('d/m/Y H:i') }}</small>
                    @endif
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Proyecto asociado -->
        @if($event->project)
          <div class="row mt-5">
            <div class="col-12"><hr class="my-4 divider-soft"></div>
          </div>

          <div class="row mt-2" data-aos="fade-up" data-aos-delay="240">
            <div class="col-12">
              <div class="service-card">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <i class="bi bi-building"></i>
                  <h3 class="m-0">Proyecto Asociado</h3>
                </div>

                <div class="row g-3">
                  <div class="col-md-8">
                    <div class="service-features">
                      <div class="mb-2"><i class="bi bi-tag"></i> <strong>Proyecto:</strong><br><span class="ms-3">{{ $event->project->nombre }}</span></div>
                      @if($event->project->categoria)
                        <div class="mb-2"><i class="bi bi-folder"></i> <strong>Categoría:</strong><br><span class="ms-3">{{ $event->project->categoria }}</span></div>
                      @endif
                      @if($event->project->ubicacion)
                        <div class="mb-2"><i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong><br><span class="ms-3">{{ $event->project->ubicacion }}</span></div>
                      @endif
                      @if($event->project->estado)
                        <div class="mb-2"><i class="bi bi-check-circle"></i> <strong>Estado:</strong><br><span class="ms-3">{{ ucfirst($event->project->estado) }}</span></div>
                      @endif
                    </div>

                    @if($event->project->descripcion)
                      <p class="mt-2 text-muted">{{ Str::limit(strip_tags($event->project->descripcion), 220) }}</p>
                    @endif

                    <a href="{{ route('projects.public.show', $event->project) }}" class="btn btn-outline-gold mt-1">
                      Ver Proyecto <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                  </div>

                  <div class="col-md-4 text-center">
                    @if($event->project->imagen)
                      <img src="{{ asset('storage/'.$event->project->imagen) }}" class="img-fluid rounded shadow" alt="{{ $event->project->nombre }}" style="max-height: 180px; object-fit: cover;">
                    @endif
                  </div>
                </div>

              </div>
            </div>
          </div>
        @endif

      </div>
    </section>

    <!-- Separador -->
    <div class="container"><hr class="my-5 divider-soft"></div>

    <!-- CTA -->
    <section id="event-cta" class="call-to-action section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center g-3">
          <div class="col-lg-8">
            <div class="content">
              <h3 class="mb-2">¿Te interesa participar en este evento?</h3>
              <p class="mb-0">Únete y forma parte de la transformación de comunidades en Guatemala. Cada evento es una oportunidad para hacer la diferencia.</p>

              @if($event->registration_required)
                <div class="alert alert-info mt-3 mb-0">
                  <i class="bi bi-info-circle me-2"></i>
                  <strong>Registro requerido:</strong>
                  @if($event->registration_deadline)
                    Regístrate antes del {{ $event->registration_deadline->format('d/m/Y H:i') }}.
                  @else
                    Este evento requiere registro previo.
                  @endif
                  @if($event->contact_email)
                    <br>Contacto: <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                  @endif
                </div>
              @endif

              @if($event->max_participants && $event->current_participants >= $event->max_participants)
                <div class="alert alert-warning mt-3 mb-0">
                  <i class="bi bi-exclamation-triangle me-2"></i>
                  <strong>Cupos completos:</strong> No hay cupos disponibles.
                </div>
              @endif
            </div>
          </div>
          <div class="col-lg-4 text-center text-lg-end">
            <a href="{{ route('home') }}#services" class="btn btn-outline-gold">
              <i class="bi bi-arrow-left me-1"></i> Ver más eventos
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer del tema -->
  <footer id="footer" class="footer dark-background w-100 mt-auto" style="padding: 0;">
    <div class="container-fluid footer-top" style="padding: 2rem 1rem;">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <span class="sitename">Habitat Guatemala</span>
          </a>
          <p>Construyendo esperanza desde 1995. Trabajamos para que las familias guatemaltecas tengan acceso a vivienda segura y un entorno digno.</p>
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
