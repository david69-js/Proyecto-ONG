<!DOCTYPE html>
<html lang="es">
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route as R;
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $project->nombre }} - Proyecto | Habitat Guatemala</title>
  <meta name="description" content="{{ Str::limit($project->descripcion ?? 'Conoce más sobre este proyecto de Habitat Guatemala', 160) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files (estilo del segundo archivo) -->
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS del tema -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

  <style>
    .footer .footer-links ul a,.footer-contact,.footer-about,.Copyright 
{
    z-index:1;
    }
    /* Ajustes específicos para esta página de proyecto con el estilo del tema */
    body.project-page { background-color: var(--background-color, #ffffff); }

    .project-quick-info .info-item {
      background: rgba(255,255,255,0.1);
      padding: 0.5rem 1rem;
      border-radius: 25px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
      color: rgba(255,255,255,0.95);
    }

    .text-white-75 { color: rgba(255,255,255,0.75) !important; }

    .service-details .detail-item { margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee; }
    .service-details .detail-item:last-child { border-bottom: none; }

    /* Controles de carrusel oscuros (coherentes con el tema) */
    .carousel-control-prev-icon, .carousel-control-next-icon {
      background-color: #000 !important;
      border: 2px solid #fff !important;
      border-radius: 50% !important;
      width: 44px !important; height: 44px !important;
      opacity: .9 !important;
      background-size: 60% 60%;
    }
    .carousel-control-prev, .carousel-control-next {
      width: 80px !important;
      opacity: 1 !important;
    }

    /* Filtro de fases */
    .phase-filter {
      background: rgba(255,255,255,0.5);
      border-radius: 15px;
      padding: 1rem;
      backdrop-filter: blur(8px);
      border: 1px solid rgba(0,0,0,0.05);
    }
    .phase-filter-btn { border-radius: 25px !important; font-weight: 500; transition: all .2s; }
    .phase-filter-btn.active { background: var(--accent-color, #0d6efd) !important; border-color: var(--accent-color, #0d6efd) !important; color: #fff !important; }

    /* Indicadores cíclicos del carrusel */
    .carousel-indicators-custom { position: relative; z-index: 10; }
    .carousel-indicator-dot {
      width: 12px; height: 12px; border-radius: 50%;
      background: rgba(0,0,0,0.2); border: 2px solid rgba(0,0,0,0.35);
      cursor: pointer; transition: all .2s;
    }
    .carousel-indicator-dot.active { background: var(--accent-color, #0d6efd); border-color: var(--accent-color, #0d6efd); transform: scale(1.15); }

    /* Bloques tipo “service-card” (coherentes con cards del tema) */
    .service-card { background: #fff; border-radius: 12px; padding: 1.25rem; box-shadow: 0 6px 16px rgba(0,0,0,.06); }
  </style>
  <style>
  /* 🔧 FIX FINAL: habilita clics en el footer */
  .footer::before {
    pointer-events: none !important;
  }

  footer, .footer, #footer {
    position: relative !important;
    z-index: 10 !important;
    pointer-events: auto !important;
  }

  footer a, .footer a {
    pointer-events: auto !important;
  }
</style>
</head>

<body class="project-page index-page d-flex flex-column min-vh-100">

  <!-- Header del sitio (del segundo archivo) -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">Habitat Guatemala</h1><span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}">Inicio</a></li>
          <li><a href="{{ url('/#about') }}">Quiénes Somos</a></li>
          <li><a href="{{ url('/#services') }}">Eventos</a></li>
          <li><a href="{{ url('/#projects') }}" class="active">Proyectos</a></li>
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

    <!-- Hero del Proyecto (con look & feel del tema) -->
    <section id="project-hero" class="hero section dark-background position-relative" style="min-height: 60vh; padding: 140px 0 60px; overflow: hidden;">
      <!-- Fondo: usa imagen del proyecto si hay; si no, un degradado sutil -->
      <div class="hero-bg position-absolute top-0 start-0 w-100 h-100">
        @if($project->imagen)
          <img src="{{ asset('storage/'.$project->imagen) }}" alt="{{ $project->nombre }}" class="w-100 h-100"
               style="object-fit: cover; filter: brightness(.45);">
        @else
<div class="w-100 h-100"
     style="background: radial-gradient(1200px 600px at 15% 15%, rgba(212, 175, 55, 0.35), transparent),
            linear-gradient(135deg, #b8860b 0%, #f1c40f 100%);
            opacity:.9;">
</div>
        @endif
      </div>

      <div class="info position-relative text-white">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-right" data-aos-delay="150">
              @php
                $statusTranslations = [
                  'planning' => 'Planificación',
                  'en progreso' => 'En Progreso',
                  'completado' => 'Completado',
                  'pausado' => 'Pausado',
                  'cancelado' => 'Cancelado',
                ];
                $statusText = $statusTranslations[$project->estado] ?? 'Activo';
              @endphp

              <!-- Badge de estado -->
              <span class="d-inline-block mb-3 px-3 py-1 rounded-pill"
                    style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);">
                <i class="bi bi-building me-2"></i>{{ $statusText }}
              </span>

              <!-- Título -->
              <h1 class="text-white fw-bold mb-3">{{ $project->nombre }}</h1>

              <!-- Descripción -->
              <p class="text-white-75 mb-4">{{ $project->descripcion ?? 'Proyecto organizado por Habitat Guatemala' }}</p>

              <!-- Info rápida -->
              <div class="project-quick-info d-flex flex-wrap gap-3">
                @if($project->ubicacion)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-geo-alt me-2"></i><span>{{ $project->ubicacion }}</span></div>
                @endif
                @if($project->duracion_meses)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-calendar-check me-2"></i><span>{{ $project->duracion_meses }} meses</span></div>
                @endif
                @if($project->presupuesto_total)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-currency-dollar me-2"></i><span>Q{{ number_format($project->presupuesto_total, 2) }}</span></div>
                @endif
                @if($project->viviendas)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-house me-2"></i><span>{{ $project->viviendas }} viviendas</span></div>
                @endif
                @if($project->porcentaje)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-graph-up me-2"></i><span>{{ $project->porcentaje }}% completado</span></div>
                @endif
              </div>
            </div>

            <!-- Lateral: categoría / imagen mini -->
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="250">
              <div class="text-center">
                @if($project->categoria)
                  <span class="badge bg-white text-dark px-3 py-2 rounded-pill mb-3">{{ ucfirst($project->categoria) }}</span>
                @endif
                @if($project->imagen)
                  <img src="{{ asset('storage/'.$project->imagen) }}" alt="{{ $project->nombre }}" class="img-fluid rounded shadow"
                       style="max-height: 260px; object-fit: cover;">
                @else
                  <i class="bi bi-building" style="font-size:4rem; color: rgba(255,255,255,0.35);"></i>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /Hero -->

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color,#0d6efd); opacity:.25;"></div>

    <!-- Detalles del Proyecto -->
    <section id="project-details" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Título de sección -->
        <div class="section-title">
          <h2>Detalles del Proyecto</h2>
          <p>Información completa sobre este proyecto organizado por Habitat Guatemala</p>
        </div>

        <!-- Imagen principal (grande) si existe -->
        @if($project->imagen)
          <div class="row mb-4">
            <div class="col-12" data-aos="fade-up" data-aos-delay="100">
              <div class="text-center">
                <img src="{{ asset('storage/'.$project->imagen) }}" alt="{{ $project->nombre }}" class="img-fluid rounded shadow" style="max-height: 420px; object-fit: cover;">
              </div>
            </div>
          </div>
        @endif

        <!-- Carrusel de fases (con filtro e indicadores cíclicos) -->
        @php
          $phaseImages = $project->phaseImages ?? collect();
        @endphp
        @if($phaseImages->count() > 0)
          @php
            $phaseOrder = ['diagnostico','formulacion','financiacion','ejecucion','evaluacion','cierre'];
            $phaseNames = [
              'diagnostico'  => 'Diagnóstico',
              'formulacion'  => 'Formulación',
              'financiacion' => 'Financiación',
              'ejecucion'    => 'Ejecución',
              'evaluacion'   => 'Evaluación',
              'cierre'       => 'Cierre',
            ];
            $availablePhases = $phaseImages->pluck('fase')->unique();
          @endphp

          <div class="row mb-4">
            <div class="col-12" data-aos="fade-up" data-aos-delay="150">
              <h4 class="text-center mb-3">Fases del Proyecto</h4>

              <!-- Filtro -->
              <div class="phase-filter mb-4">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                  <button class="btn btn-outline-primary btn-sm phase-filter-btn active" data-phase="all">
                    <i class="bi bi-grid me-1"></i>Todas las Fases
                  </button>
                  @foreach($phaseOrder as $phase)
                    @if($availablePhases->contains($phase))
                      <button class="btn btn-outline-secondary btn-sm phase-filter-btn" data-phase="{{ $phase }}">
                        <i class="bi bi-circle-fill me-1"></i>{{ $phaseNames[$phase] }}
                      </button>
                    @endif
                  @endforeach
                </div>
              </div>

              <div id="carouselProject{{ $project->id }}" class="carousel slide shadow" data-bs-ride="false" data-bs-interval="false">
                <div class="carousel-inner rounded">
                  @foreach($phaseImages as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-phase="{{ $image->fase }}">
                      <img src="{{ asset('storage/'.$image->image_path) }}" class="d-block w-100"
                           alt="{{ $image->description ?? $project->nombre }}" style="object-fit: cover; height: 420px;">
                      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded px-3 py-1">
                        <small class="text-white">
                          Fase: {{ $phaseNames[$image->fase] ?? ucfirst($image->fase) }}
                          @if($image->description) — {{ $image->description }} @endif
                        </small>
                      </div>
                    </div>
                  @endforeach
                </div>

                @if($phaseImages->count() > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                  </button>

                  <!-- Indicadores personalizados -->
                  <div class="carousel-indicators-custom">
                    <div id="carouselIndicators{{ $project->id }}" class="d-flex justify-content-center gap-2 mt-3"></div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endif

        <div class="row gy-4">
          <!-- Info general -->
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="service-card h-100">
              <h3>Información General</h3>
              <div class="service-features">
                @if($project->ubicacion)
                  <div class="mb-2"><i class="bi bi-geo-alt"></i> <strong>Ubicación:</strong><br><span class="ms-3">{{ $project->ubicacion }}</span></div>
                @endif
                @if(optional($project->responsable)->first_name || optional($project->responsable)->last_name)
                  <div class="mb-2"><i class="bi bi-person-badge"></i> <strong>Responsable:</strong><br>
                    <span class="ms-3">{{ optional($project->responsable)->first_name }} {{ optional($project->responsable)->last_name }}</span>
                  </div>
                @endif
                @if($project->presupuesto_total)
                  <div class="mb-2"><i class="bi bi-currency-dollar"></i> <strong>Presupuesto:</strong><br><span class="ms-3">Q{{ number_format($project->presupuesto_total, 2) }}</span></div>
                @endif
                @if($project->duracion_meses)
                  <div class="mb-2"><i class="bi bi-calendar-check"></i> <strong>Duración:</strong><br><span class="ms-3">{{ $project->duracion_meses }} meses</span></div>
                @endif
                @if($project->fecha_inicio)
                  <div class="mb-2"><i class="bi bi-calendar-event"></i> <strong>Fecha Inicio:</strong><br><span class="ms-3">{{ \Carbon\Carbon::parse($project->fecha_inicio)->format('d/m/Y') }}</span></div>
                @endif
                @if($project->fecha_fin)
                  <div class="mb-2"><i class="bi bi-calendar-x"></i> <strong>Fecha Fin:</strong><br><span class="ms-3">{{ \Carbon\Carbon::parse($project->fecha_fin)->format('d/m/Y') }}</span></div>
                @endif
                @if($project->viviendas)
                  <div class="mb-2"><i class="bi bi-house"></i> <strong>Viviendas:</strong><br><span class="ms-3">{{ $project->viviendas }}</span></div>
                @endif
                @if($project->beneficiarios)
                  <div class="mb-2"><i class="bi bi-people"></i> <strong>Beneficiarios:</strong><br><span class="ms-3">{{ $project->beneficiarios }}</span></div>
                @endif
              </div>
            </div>
          </div>

          <!-- Progreso y fases -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="250">
            <div class="service-card h-100">
              <h3>Progreso y Fases</h3>
              <div class="service-details">
                @if($project->porcentaje)
                  <div class="detail-item">
                    <h5 class="mb-2"><i class="bi bi-graph-up me-2"></i><strong>Progreso del Proyecto:</strong></h5>
                    <div class="ms-1">
                      <div class="progress mb-2" style="height: 24px;">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: {{ $project->porcentaje }}%"
                             aria-valuenow="{{ $project->porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                          {{ $project->porcentaje }}%
                        </div>
                      </div>
                      <small class="text-muted">Proyecto completado al {{ $project->porcentaje }}%</small>
                    </div>
                  </div>
                @endif

                @if($project->fase)
                  @php
                    $PHASES = \App\Models\Project::PHASES ?? [];
                    $faseLabel = $PHASES[$project->fase]['name'] ?? ucfirst($project->fase);
                  @endphp
                  <div class="detail-item">
                    <h5 class="mb-2"><i class="bi bi-list-check me-2"></i><strong>Fase Actual:</strong></h5>
                    <p class="ms-1"><span class="badge bg-success">{{ $faseLabel }}</span></p>
                  </div>
                @endif

                @if($project->resultados_esperados)
                  <div class="detail-item">
                    <h5 class="mb-2"><i class="bi bi-bullseye me-2"></i><strong>Resultados Esperados:</strong></h5>
                    <p class="ms-1">{{ $project->resultados_esperados }}</p>
                  </div>
                @endif

                @if($project->resultados_obtenidos)
                  <div class="detail-item">
                    <h5 class="mb-2"><i class="bi bi-trophy me-2"></i><strong>Resultados Obtenidos:</strong></h5>
                    <p class="ms-1">{{ $project->resultados_obtenidos }}</p>
                  </div>
                @endif

                @if($project->categoria)
                  <div class="detail-item">
                    <h5 class="mb-2"><i class="bi bi-tag me-2"></i><strong>Categoría:</strong></h5>
                    <p class="ms-1">{{ ucfirst($project->categoria) }}</p>
                  </div>
                @endif

                @if($project->area_km)
                  <div class="detail-item">
                    <h5 class="mb-2"><i class="bi bi-rulers me-2"></i><strong>Área:</strong></h5>
                    <p class="ms-1">{{ $project->area_km }} km²</p>
                  </div>
                @endif
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color,#0d6efd); opacity:.25;"></div>

    <!-- CTA simple -->
    <section id="project-cta" class="call-to-action section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <div class="content">
              <h3>¿Te interesa apoyar este proyecto?</h3>
              <p>Únete a nosotros y forma parte de la transformación de comunidades en Guatemala. Cada proyecto es una oportunidad para hacer la diferencia.</p>
            </div>
          </div>
          <div class="col-lg-4 text-center text-lg-end">
            @if(R::has('home'))
              <a href="{{ route('home') }}#get-started" class="btn btn-primary">Donar ahora</a>
            @else
              <a href="{{ url('/#get-started') }}" class="btn btn-primary">Donar ahora</a>
            @endif
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer del tema (del segundo archivo) -->
  <footer id="footer" class="footer dark-background w-100 mt-auto" style="padding: 0;">
    <div class="container-fluid footer-top" style="padding: 2rem 1rem;">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <span class="sitename">Habitat Guatemala</span>
          </a>
          <p>Construyendo esperanza desde 1995. Trabajamos cada día para que las familias guatemaltecas tengan acceso a una vivienda segura y un entorno digno.</p>
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

  <!-- Lógica del filtro/indicadores del carrusel de fases -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const filterButtons = document.querySelectorAll('.phase-filter-btn');
      const carousel = document.querySelector('#carouselProject{{ $project->id }}');
      const carouselItems = carousel ? carousel.querySelectorAll('.carousel-item') : [];
      let currentFilter = 'all';
      let visibleItems = [];

      function updateVisibleItems() {
        visibleItems = Array.from(carouselItems).filter(item => {
          const phase = item.getAttribute('data-phase');
          return currentFilter === 'all' || phase === currentFilter;
        });
      }

      function setActiveOnly(el) {
        carouselItems.forEach(i => { i.classList.remove('active'); i.style.display = 'none'; });
        if (el) { el.classList.add('active'); el.style.display = 'block'; }
      }

      function goToNextVisible() {
        updateVisibleItems();
        if (visibleItems.length === 0) return;
        const currentActive = document.querySelector('.carousel-item.active');
        const currentIndex = visibleItems.indexOf(currentActive);
        const nextIndex = (currentIndex + 1) % visibleItems.length;
        setActiveOnly(visibleItems[nextIndex]);
        updateActiveIndicator();
      }

      function goToPrevVisible() {
        updateVisibleItems();
        if (visibleItems.length === 0) return;
        const currentActive = document.querySelector('.carousel-item.active');
        const currentIndex = visibleItems.indexOf(currentActive);
        let prevIndex = currentIndex - 1;
        if (prevIndex < 0) prevIndex = visibleItems.length - 1;
        setActiveOnly(visibleItems[prevIndex]);
        updateActiveIndicator();
      }

      filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          currentFilter = this.getAttribute('data-phase');
          filterButtons.forEach(b => { b.classList.remove('active','btn-primary'); b.classList.add('btn-outline-secondary'); });
          this.classList.add('active','btn-primary'); this.classList.remove('btn-outline-secondary');

          carouselItems.forEach(item => {
            const phase = item.getAttribute('data-phase');
            const show = (currentFilter === 'all' || phase === currentFilter);
            item.style.display = show ? 'block' : 'none';
            if (!show) item.classList.remove('active');
          });

          updateVisibleItems();
          if (visibleItems.length > 0) setActiveOnly(visibleItems[0]);
          updateIndicators();
        });
      });

      const prevButton = carousel?.querySelector('.carousel-control-prev');
      const nextButton = carousel?.querySelector('.carousel-control-next');

      prevButton?.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); goToPrevVisible(); return false; });
      nextButton?.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); goToNextVisible(); return false; });

      if (carousel) {
        carousel.setAttribute('data-bs-ride', 'false');
        carousel.setAttribute('data-bs-interval', 'false');
        carousel.setAttribute('data-bs-pause', 'true');
      }

      function updateIndicators() {
        const container = document.getElementById('carouselIndicators{{ $project->id }}');
        if (!container) return;
        updateVisibleItems();
        container.innerHTML = '';
        visibleItems.forEach((item, idx) => {
          const dot = document.createElement('div');
          dot.className = 'carousel-indicator-dot';
          dot.dataset.index = idx;
          dot.addEventListener('click', () => goToSlide(idx));
          container.appendChild(dot);
        });
        updateActiveIndicator();
      }

      function goToSlide(idx) {
        updateVisibleItems();
        if (!visibleItems[idx]) return;
        setActiveOnly(visibleItems[idx]);
        updateActiveIndicator();
      }

      function updateActiveIndicator() {
        const dots = document.querySelectorAll('.carousel-indicator-dot');
        const currentActive = document.querySelector('.carousel-item.active');
        const idx = visibleItems.indexOf(currentActive);
        dots.forEach((d, i) => d.classList.toggle('active', i === idx));
      }

      document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') { e.preventDefault(); goToPrevVisible(); }
        if (e.key === 'ArrowRight') { e.preventDefault(); goToNextVisible(); }
      });

      // Inicializar: asegurar visibilidad inicial y crear indicadores
      carouselItems.forEach((item, i) => { item.style.display = i === 0 ? 'block' : 'none'; });
      updateIndicators();
    });
  </script>
</body>
</html>
