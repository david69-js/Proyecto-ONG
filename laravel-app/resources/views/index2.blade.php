<!DOCTYPE html>
<html lang="es">
@php
    use App\Models\SponsorHighlight;

    // Trae solo los patrocinadores publicados
    $sponsors = SponsorHighlight::with('sponsor')
        ->where('is_published', true)
        ->whereNotNull('published_at')
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get();
@endphp

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Habitat Guatemala</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <style>
    /* --- FIX: enlaces no presionables en el footer --- */
    footer, .footer, #footer {
      position: relative !important;
      z-index: 10 !important;
    }

    /* Asegura que ningún overlay tape el footer */
    section, .section, .hero, .hero-bg, .dark-background {
      z-index: 1 !important;
    }

    /* Rehabilita clics dentro del footer */
    footer a, .footer a {
      pointer-events: auto !important;
    }

    /* Evita que capas del hero o fondo bloqueen los clics */
    .hero .hero-bg,
    .hero.section.dark-background.position-relative {
      pointer-events: none !important;
    }
    
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




  <!-- Main CSS File -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">
  

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      {{-- Logo principal --}}
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <!-- Si deseas usar imagen -->
        <!-- <img src="{{ asset('assets2/img/logo.png') }}" alt=""> -->
        <h1 class="sitename">Habitat Guatemala</h1> <span>.</span>
      </a>

      {{-- Menú de navegación --}}
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Inicio</a></li>
          <li><a href="#about">Quiénes Somos</a></li>
          <li><a href="#services">Eventos</a></li>
          <li><a href="#projects">Proyectos</a></li>
          <li><a href="#get-started">Donaciones</a></li>
          <li><a href="{{ route('contact.index2') }}">Contacto</a></li>

       

          {{-- Si el usuario está autenticado --}}
          @auth
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user"></i> {{ auth()->user()->first_name }}
                <i class="bi bi-chevron-down toggle-dropdown"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/users" class="dropdown-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                      <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            {{-- Si no ha iniciado sesión --}}
            <li><a href="{{ route('login') }}">Ingresar</a></li>
          @endauth

          {{--Enlace público a productos --}}
          <li><a href="{{ route('products.public.index2') }}">Productos</a></li>
        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">



<!-- Hero Section -->
<section id="hero" class="hero section dark-background position-relative" style="height: 100vh; overflow: hidden;">

  <!-- Imagen de fondo -->
  <div class="hero-bg position-absolute top-0 start-0 w-100 h-100">
    <img
      src="{{ optional($hero)->image_main ? asset('storage/' . optional($hero)->image_main) : asset('assets2/img/hero-carousel/hero-carousel-2.jpg') }}"
      alt="Imagen principal del héroe"
      class="w-100 h-100 object-fit-cover"
      style="object-fit: cover; filter: brightness(0.4);"
    >
  </div>

  <!-- Contenido -->
  <div class="info position-relative d-flex align-items-center justify-content-center text-center h-100">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-8 mx-auto">

        <!-- Subtítulo -->
        <span class="subtitle text-uppercase text-light d-block mb-2">
          {{ optional($hero)->subtitle ?? 'Construyendo esperanza' }}
        </span>

        <!-- Título -->
        <h2 class="text-white fw-bold display-5 mb-3">
          {{ optional($hero)->title ?? 'Juntos construimos hogares, comunidades y futuro' }}
        </h2>

        <!-- Descripción -->
        <p class="text-light mb-4 fs-5">
          {{ optional($hero)->description ?? 'Trabajamos cada día para mejorar la calidad de vida de las familias guatemaltecas más necesitadas.' }}
        </p>
<!-- Botones -->
<div class="d-flex justify-content-center gap-3 flex-wrap">
  <a href="{{ optional($hero)->button_primary_link ?? '#' }}" class="btn-get-started">
    {{ optional($hero)->button_primary_text ?? 'Haz tu donación' }}
  </a>
  
  <a href="{{ optional($hero)->button_secondary_link ?? '#' }}" class="btn-get-started">
    {{ optional($hero)->button_secondary_text ?? 'Conoce nuestros proyectos' }}
  </a>
</div>

        <!-- Logros -->
        <div class="d-flex justify-content-center mt-5 text-white small gap-4 flex-wrap" data-aos="fade-up" data-aos-delay="300">
          <div class="text-center">
            <i class="bi bi-people fs-4"></i>
            <div class="fw-bold">{{ optional($hero)->anios_servicio ?? '25+' }}</div>
            <div>Años de servicio</div>
          </div>
          <div class="text-center">
            <i class="bi bi-house-heart fs-4"></i>
            <div class="fw-bold">{{ optional($hero)->viviendas_construidas ?? '500+' }}</div>
            <div>Viviendas construidas</div>
          </div>
          <div class="text-center">
            <i class="bi bi-person-hearts fs-4"></i>
            <div class="fw-bold">{{ optional($hero)->familias_beneficiadas ?? '300+' }}</div>
            <div>Familias beneficiadas</div>
          </div>
        </div>

      </div>
    </div>
  </div>

</section>
<!-- /Hero Section -->
<!-- Sección Misión, Visión y Valores (corregido y completo) -->
<section id="mission-vision" class="mission-vision section py-5" 
  style="background: linear-gradient(180deg, #fff8e1 0%, #ffffff 100%); position: relative; overflow-x: hidden;">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <!-- Encabezado -->
    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase" style="color:#b8860b;">Misión, Visión y Valores</h2>
      <p class="text-muted">Descubre los principios que inspiran cada acción de Habitat Guatemala</p>
    </div>

    <!-- Carrusel -->
    <div id="missionVisionCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="9000">
      <div class="carousel-inner" style="min-height: 550px;"> <!-- 🔹 Aumentamos altura -->
        
        <!-- Misión -->
        <div class="carousel-item active">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 550px;"> <!-- 🔹 Centrado vertical -->
            <div class="card border-0 shadow-lg rounded-4 p-5 w-100" style="max-width:1000px; background:#fff;">
              <div class="text-center mb-4">
                <i class="bi bi-heart-fill fs-1" style="color:#b8860b;"></i>
                <h3 class="fw-bold mt-3" style="color:#b8860b;">Nuestra Misión</h3>
              </div>
              <p class="text-center text-muted mb-5 fs-5 px-3">
                Construir viviendas seguras y dignas para familias guatemaltecas de escasos recursos, 
                promoviendo el desarrollo comunitario sostenible y fortaleciendo los lazos sociales 
                a través del trabajo voluntario y la solidaridad.
              </p>
              <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                  <i class="bi bi-check-circle-fill text-warning fs-3"></i>
                  <p class="mt-2 mb-0 fw-semibold">Viviendas seguras y dignas</p>
                </div>
                <div class="col-md-4 text-center">
                  <i class="bi bi-check-circle-fill text-warning fs-3"></i>
                  <p class="mt-2 mb-0 fw-semibold">Desarrollo sostenible</p>
                </div>
                <div class="col-md-4 text-center">
                  <i class="bi bi-check-circle-fill text-warning fs-3"></i>
                  <p class="mt-2 mb-0 fw-semibold">Solidaridad y voluntariado</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Visión -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 550px;">
            <div class="card border-0 shadow-lg rounded-4 p-5 w-100" style="max-width:1000px; background:#fff;">
              <div class="text-center mb-4">
                <i class="bi bi-eye-fill fs-1" style="color:#f1c40f;"></i>
                <h3 class="fw-bold mt-3" style="color:#b8860b;">Nuestra Visión</h3>
              </div>
              <p class="text-center text-muted mb-5 fs-5 px-3">
                Ser la organización líder en Guatemala en la construcción de viviendas sociales, 
                creando comunidades prósperas donde cada familia tenga un hogar digno 
                y las oportunidades necesarias para su desarrollo integral.
              </p>
              <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                  <i class="bi bi-star-fill text-warning fs-3"></i>
                  <p class="mt-2 mb-0 fw-semibold">Liderazgo en vivienda social</p>
                </div>
                <div class="col-md-4 text-center">
                  <i class="bi bi-star-fill text-warning fs-3"></i>
                  <p class="mt-2 mb-0 fw-semibold">Comunidades prósperas</p>
                </div>
                <div class="col-md-4 text-center">
                  <i class="bi bi-star-fill text-warning fs-3"></i>
                  <p class="mt-2 mb-0 fw-semibold">Desarrollo familiar integral</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--Valores -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 550px;">
            <div class="card border-0 shadow-lg rounded-4 p-5 w-100" style="max-width:1000px; background:#fff;">
              <div class="text-center mb-4">
                <i class="bi bi-gem fs-1" style="color:#b8860b;"></i>
                <h3 class="fw-bold mt-3" style="color:#b8860b;">Nuestros Valores</h3>
              </div>
              <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3 text-center">
                  <i class="bi bi-people-fill fs-3 text-warning"></i>
                  <h6 class="fw-bold mt-2">Solidaridad</h6>
                </div>
                <div class="col-6 col-md-3 text-center">
                  <i class="bi bi-shield-check fs-3 text-warning"></i>
                  <h6 class="fw-bold mt-2">Transparencia</h6>
                </div>
                <div class="col-6 col-md-3 text-center">
                  <i class="bi bi-award-fill fs-3 text-warning"></i>
                  <h6 class="fw-bold mt-2">Excelencia</h6>
                </div>
                <div class="col-6 col-md-3 text-center">
                  <i class="bi bi-heart-pulse fs-3 text-warning"></i>
                  <h6 class="fw-bold mt-2">Compasión</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Controles -->
      <button class="carousel-control-prev" type="button" data-bs-target="#missionVisionCarousel" data-bs-slide="prev"
        style="left:-60px;">
        <span class="carousel-control-prev-icon bg-warning rounded-circle p-4 shadow" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#missionVisionCarousel" data-bs-slide="next"
        style="right:-60px;">
        <span class="carousel-control-next-icon bg-warning rounded-circle p-4 shadow" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>

      <!-- Indicadores -->
      <div class="carousel-indicators mt-4">
        <button type="button" data-bs-target="#missionVisionCarousel" data-bs-slide-to="0" class="active bg-warning"></button>
        <button type="button" data-bs-target="#missionVisionCarousel" data-bs-slide-to="1" class="bg-warning"></button>
        <button type="button" data-bs-target="#missionVisionCarousel" data-bs-slide-to="2" class="bg-warning"></button>
      </div>

    </div>
  </div>
</section>




  @php
  // Credenciales de PayPal desde config/services.php o .env
  use Illuminate\Support\Facades\Route as R;

  $paypalClientId = config('services.paypal.client_id', env('PAYPAL_CLIENT_ID'));
  $paypalCurrency = config('services.paypal.currency', env('PAYPAL_CURRENCY', 'USD'));

  $paypalCreateUrl = R::has('donations.paypal.create')
      ? route('donations.paypal.create')
      : (R::has('admin.donations.paypal.create')
          ? route('admin.donations.paypal.create')
          : url('/donations/paypal/create-order'));

  $paypalCaptureUrl = R::has('donations.paypal.capture')
      ? route('donations.paypal.capture')
      : (R::has('admin.donations.paypal.capture')
          ? route('admin.donations.paypal.capture')
          : url('/donations/paypal/capture-order'));
@endphp

<!-- SDK de PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $paypalCurrency }}&intent=capture"></script>

<!-- Get Started / Donaciones -->
<section id="get-started" class="get-started section">
  <div class="container">

    <div class="row justify-content-between gy-4">

      <!-- Texto lateral izquierdo -->
      <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
        <div class="content">
          <h3>Apoya la construcción de hogares dignos en Guatemala</h3>
          <p>Tu donación contribuye directamente a proyectos que transforman comunidades, brindando acceso a viviendas seguras y programas de desarrollo humano sostenible.</p>
          <p>Haz tu aporte hoy y forma parte del cambio.</p>
        </div>
      </div>

      <!-- Formulario PayPal -->
      <div class="col-lg-5" data-aos="zoom-out" data-aos-delay="200">
        <form id="donation-form" class="php-email-form" onsubmit="return false;">
          @csrf
          <h3>Haz tu Donación</h3>
          <p>Completa tus datos y realiza tu aporte seguro con PayPal.</p>

          <div class="row gy-3">

            <div class="col-12">
              <input type="text" name="donor_name" class="form-control" placeholder="Tu Nombre" required>
            </div>

            <div class="col-12">
              <input type="email" name="donor_email" class="form-control" placeholder="Tu Correo (opcional)">
            </div>

            <div class="col-12">
              <label class="form-label mb-1">Selecciona un monto o escribe el tuyo</label>
              <div class="d-flex flex-wrap gap-2 mb-2">
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt active" data-amount="10">10 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="100">100 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="200">200 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="500">500 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="1000">1000 {{ $paypalCurrency }}</button>
              </div>
            </div>

            <div class="col-md-6">
              <input type="number" min="1" step="0.01" name="amount" class="form-control" value="10" required>
            </div>

            <div class="col-md-6">
              <select name="currency" class="form-control" required>
                <option value="{{ $paypalCurrency }}" selected>{{ $paypalCurrency }}</option>
              </select>
            </div>

            @isset($projects)
              <div class="col-12">
                <select name="project_id" class="form-control">
                  <option value="">Apoyar a la ONG (sin proyecto)</option>
                  @foreach($projects as $p)
                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                  @endforeach
                </select>
              </div>
            @endisset

            <div class="col-12">
              <input type="text" name="notes" class="form-control" placeholder="Motivo / Programa (opcional)">
            </div>

            <div class="col-12 text-center">
              <div class="loading" style="display:none">Cargando...</div>
              <div class="error-message alert alert-danger py-2 px-3 my-2" style="display:none"></div>
              <div class="sent-message alert alert-success py-2 px-3 my-2" style="display:none">¡Gracias! Tu donación fue procesada.</div>

              <!-- Botón PayPal -->
              <div id="paypal-button-container" class="mt-2"></div>
            </div>
          </div>
        </form>
      </div><!-- End Quote Form -->
    </div>
  </div>
</section>

<!-- Script para monto inicial y botones -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const amountInput = document.querySelector('#get-started input[name="amount"]');
  const quickBtns = document.querySelectorAll('#get-started .quick-amt');

  // Establecer monto inicial 10 USD
  if (amountInput) amountInput.value = 10;

  quickBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      quickBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      amountInput.value = btn.dataset.amount;
    });
  });
});
</script>

<!-- Estilo visual del botón activo -->
<style>
.quick-amt.active {
  background: linear-gradient(135deg, #b8860b, #f1c40f);
  color: #fff !important;
  border-color: #b8860b !important;
  font-weight: 600;
}
</style>
<!-- /Get Started Section -->

<!-- Script de integración con PayPal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('donation-form');
  const loadingEl = form.querySelector('.loading');
  const errorEl = form.querySelector('.error-message');
  const okEl = form.querySelector('.sent-message');
  const amountInput = form.amount;

  function showLoading(show) { loadingEl.style.display = show ? '' : 'none'; }
  function showError(msg) { errorEl.textContent = msg || ''; errorEl.style.display = msg ? '' : 'none'; }
  function showOk() { okEl.style.display = ''; }
  function validAmount() {
    const val = parseFloat(amountInput.value);
    return !isNaN(val) && val >= 1;
  }

  document.querySelectorAll('.quick-amt').forEach(btn => {
    btn.addEventListener('click', () => {
      amountInput.value = parseFloat(btn.dataset.amount).toFixed(2);
    });
  });

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
               form.querySelector('input[name="_token"]')?.value;

  if (window.paypal && typeof window.paypal.Buttons === 'function') {
    paypal.Buttons({
      style: { layout: 'horizontal', label: 'donate', shape: 'pill' },

      createOrder: async () => {
        showError('');
        if (!validAmount()) throw new Error('Monto inválido');
        showLoading(true);

        const payload = {
          amount: form.amount.value,
          donor_name: form.donor_name.value,
          donor_email: form.donor_email.value || null,
          project_id: form.project_id ? (form.project_id.value || null) : null,
          notes: form.notes.value || null,
          currency: form.currency.value
        };

        const res = await fetch('{{ $paypalCreateUrl }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        showLoading(false);
        if (!res.ok) {
          showError('Error al crear la orden en PayPal.');
          throw new Error('paypal_create_error');
        }
        const data = await res.json();
        form.dataset.donationId = data.donation_id;
        return data.id;
      },

      onApprove: async (data) => {
        showError('');
        showLoading(true);

        const res = await fetch('{{ $paypalCaptureUrl }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID,
            donation_id: form.dataset.donationId || null
          })
        });

        showLoading(false);
        if (!res.ok) {
          showError('No se pudo capturar el pago en PayPal.');
          return;
        }

        showOk();
        form.reset();
      },

      onError: (err) => {
        console.error(err);
        showError('Ocurrió un error con PayPal. Inténtalo nuevamente.');
      }
    }).render('#paypal-button-container');
  } else {
    console.warn('PayPal SDK no se cargó correctamente.');
  }
});
</script>


  <!-- Sección de Beneficiarios -->
<section id="beneficiarios" class="beneficiarios section py-5">

  <!-- Título de la sección -->
  <div class="container section-title text-center mb-5" data-aos="fade-up">
    <h2 class="fw-bold text-gold">Beneficiarios</h2>
    <p class="text-muted">Transformamos vidas a través de la construcción de viviendas seguras y comunidades sostenibles.</p>
  </div>

  @if(($testimonials ?? collect())->count())
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="beneficiarios-slider swiper init-swiper">

      <!-- Configuración del Swiper -->
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 700,
          "autoplay": {"delay": 6000},
          "slidesPerView": 1,
          "spaceBetween": 30,
          "pagination": {"el": ".swiper-pagination", "type": "bullets", "clickable": true}
        }
      </script>

      <!-- Slides -->
      <div class="swiper-wrapper">
        @foreach($testimonials as $t)
          <div class="swiper-slide">
            <div class="beneficiario-slide card border-0 shadow-lg p-4 position-relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
              
              <!-- Efecto dorado de fondo -->
              <div class="gold-gradient-overlay"></div>

              <!-- Cabecera con estrellas -->
              <div class="beneficiario-header mb-3 d-flex align-items-center justify-content-between position-relative">
                <div class="stars-rating text-gold">
                  @for($i=1; $i<=5; $i++)
                    <i class="bi {{ $i <= ($t->rating ?? 5) ? 'bi-star-fill' : 'bi-star' }}"></i>
                  @endfor
                </div>
                <div class="quote-icon text-gold"><i class="bi bi-quote fs-2"></i></div>
              </div>

              <!-- Cuerpo del testimonio -->
              <div class="beneficiario-body mb-4 position-relative">
                <p class="text-dark fst-italic">{{ $t->body }}</p>
              </div>

              <!-- Pie con autor -->
              <div class="beneficiario-footer d-flex align-items-center position-relative">
                @php
                  $avatar = $t->avatar_path ? asset('storage/'.$t->avatar_path) : asset('assets/img/person/person-f-12.webp');
                @endphp
                <img src="{{ $avatar }}" alt="Beneficiario" class="rounded-circle me-3 border border-2 border-gold" style="width:60px; height:60px; object-fit:cover;">
                
                <div class="author-details">
                  <h5 class="mb-0 text-dark">{{ $t->author_name ?? optional($t->beneficiary)->name ?? 'Beneficiario Anónimo' }}</h5>
                  @if($t->role)<small class="text-gold d-block">{{ $t->role }}</small>@endif
                  @if($t->company)<small class="text-secondary d-block">{{ $t->company }}</small>@endif
                </div>
              </div>

            </div>
          </div>
        @endforeach
      </div>

      <!-- Paginación (bolitas) -->
      <div class="swiper-pagination mt-4"></div>

    </div>
  </div>
  @else
    <div class="container text-center py-5">
      <p class="text-muted">Aún no hay beneficiarios registrados.</p>
    </div>
  @endif

</section>

<!-- Estilos -->
<style>

  .text-gold {
    color: #b8860b !important;
  }
  .border-gold {
    border-color: #d4af37 !important;
  }


  .gold-gradient-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top left, rgba(255, 215, 0, 0.15), transparent 70%),
                linear-gradient(135deg, rgba(255, 215, 0, 0.08), rgba(218,165,32,0.05));
    pointer-events: none;
    border-radius: 1rem;
  }

  .beneficiario-slide {
    border-radius: 1rem;
    background: #fffdf8;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .beneficiario-slide:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
  }


  .stars-rating i {
    font-size: 1.2rem;
    color: #daa520;
  }


  .quote-icon i {
    opacity: 0.9;
  }


  .author-details h5 {
    font-weight: 600;
  }
  .author-details small {
    font-size: 0.85rem;
  }

  .swiper-pagination-bullet {
    background: #d4af37 !important;
    opacity: 0.6;
  }
  .swiper-pagination-bullet-active {
    opacity: 1;
    background: #b8860b !important;
  }


  .beneficiarios .swiper-button-next,
  .beneficiarios .swiper-button-prev {
    display: none !important;
  }

  @media (max-width: 768px) {
    .beneficiario-slide {
      padding: 1.5rem;
    }
  }
</style>



   <!-- Sección de Eventos -->
<section id="services" class="services section light-background">

  <!-- Título de sección -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Eventos</h2>
    <p>Conoce los eventos que tenemos disponibles y participa activamente en nuestras actividades.</p>
  </div>
  <!-- /Fin título -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">

      @forelse(\App\Models\Event::published()->latest()->take(6)->get() as $event)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="service-item position-relative card border-0 shadow-sm h-100">

            {{-- Badge de evento destacado --}}
            @if($event->featured)
              <div class="position-absolute top-0 end-0 bg-warning text-dark fw-semibold px-3 py-1 rounded-start">
                Destacado
              </div>
            @endif

            {{-- Icono principal --}}
            <div class="icon mb-3 text-primary">
              <i class="bi bi-calendar-event fs-2"></i>
            </div>

            {{-- Título del evento --}}
            <h3 class="h5 fw-bold text-dark">{{ $event->title }}</h3>

            {{-- Descripción corta --}}
            <p class="text-muted small mb-3">
              {{ Str::limit(strip_tags($event->description), 120, '...') }}
            </p>

            {{-- Detalles --}}
            <ul class="list-unstyled small text-secondary mb-3">
              @if($event->location)
                <li><i class="bi bi-geo-alt me-1 text-primary"></i> {{ $event->location }}</li>
              @endif
              @if($event->start_date)
                <li><i class="bi bi-clock me-1 text-primary"></i> Inicio: {{ $event->start_date->format('d/m/Y H:i') }}</li>
              @endif
              @if($event->end_date)
                <li><i class="bi bi-clock-history me-1 text-primary"></i> Fin: {{ $event->end_date->format('d/m/Y H:i') }}</li>
              @endif
            </ul>

            {{-- Botón Ver más --}}
            <a href="{{ route('events.public.show2', $event) }}" class="btn btn-outline-primary mt-auto">
  Ver más <i class="bi bi-arrow-right ms-1"></i>
</a>


          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">No hay eventos publicados actualmente.</p>
        </div>
      @endforelse

    </div>
  </div>
</section>
<!-- /Sección de Eventos -->


   

   <!-- Sección de Patrocinadores -->
<section id="patrocinadores" class="patrocinadores section">

  <!-- Título de la sección -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Patrocinadores &amp; Colaboradores</h2>
    <p>Empresas y organizaciones que apoyan nuestra misión y contribuyen al bienestar de la comunidad.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    @php
      // Asegurar que sponsors sea una colección válida
      $validSponsors = $sponsors instanceof \Illuminate\Support\Collection ? $sponsors : collect();

      // Separar los destacados del resto
      $featuredSponsors = $validSponsors->where('is_featured', true);
      $normalSponsors = $validSponsors->where('is_featured', false);
    @endphp

    {{-- 🟢 Bloque de patrocinadores destacados --}}
    @if($featuredSponsors->count() > 0)
      <div class="row mb-5 gy-4">
        @foreach($featuredSponsors as $sp)
          <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
            <div class="d-flex flex-column flex-md-row align-items-center bg-white rounded shadow-sm p-3 h-100">
              <div class="text-center me-md-4 mb-3 mb-md-0">
                <img src="{{ $sp->logo_path ? asset('storage/'.$sp->logo_path) : asset('assets2/img/constructions-1.jpg') }}"
                     alt="{{ $sp->title ?? $sp->sponsor?->name }}"
                     class="img-fluid rounded" style="max-height:120px; object-fit:contain;">
              </div>
              <div>
                <h4 class="fw-bold mb-2">{{ $sp->title ?? $sp->sponsor?->name ?? 'Patrocinador destacado' }}</h4>
                @if($sp->category)
                  <p class="mb-1"><i class="bi bi-award text-primary me-2"></i> <strong>{{ $sp->category }}</strong></p>
                @endif
                <p class="text-muted small mb-0">{{ $sp->description ?? 'Apoyo constante a nuestros proyectos comunitarios.' }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    {{-- 🔵 Grid de patrocinadores normales --}}
    <div class="row gy-4">
      @forelse($normalSponsors as $sp)
        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
          <div class="patro-card text-center p-4 border rounded shadow-sm bg-white h-100">
            <div class="patro-icon mb-3">
              <img src="{{ $sp->logo_path ? asset('storage/'.$sp->logo_path) : asset('assets2/img/constructions-2.jpg') }}"
                   alt="{{ $sp->title ?? $sp->sponsor?->name }}"
                   class="img-fluid" style="max-height:80px; object-fit:contain;">
            </div>
            <h5 class="fw-bold mb-1">{{ $sp->title ?? $sp->sponsor?->name }}</h5>
            @if($sp->category)
              <span class="badge bg-light text-dark mb-2">{{ $sp->category }}</span>
            @endif
            @if($sp->description)
              <p class="text-muted small">{{ Str::limit($sp->description, 100) }}</p>
            @endif
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">No hay patrocinadores registrados aún.</p>
        </div>
      @endforelse
    </div>

  </div>
</section>


<!-- Sección de Proyectos -->
<section id="projects" class="projects section">

  <!-- Título de sección -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Proyectos</h2>
    <p>Transformamos vidas a través de la construcción de viviendas seguras y comunidades sostenibles.</p>
  </div>
  <!-- /Fin título -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
      @forelse($projects as $project)
        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
          <div class="card project-card h-100 border-0 shadow-sm rounded overflow-hidden">

            <!-- Carrusel de imágenes de fases -->
            <div id="carouselProject{{ $project->id }}" class="carousel slide position-relative" data-bs-ride="carousel">
              <div class="carousel-inner">

                @forelse($project->phaseImages as $index => $image)
                  <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                         class="d-block w-100"
                         alt="{{ $image->description ?? $project->nombre }}"
                         style="object-fit: cover; height: 220px;">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded px-2 py-1">
                      <small class="text-white">
                        Fase: {{ ucfirst($image->fase) }}
                        @if($image->description)
                          — {{ Str::limit($image->description, 50) }}
                        @endif
                      </small>
                    </div>
                  </div>
                @empty
                  <div class="carousel-item active">
                    <img src="{{ $project->imagen ? asset('storage/'.$project->imagen) : asset('assets2/img/projects/construction-1.jpg') }}"
                         class="d-block w-100"
                         alt="{{ $project->nombre }}"
                         style="object-fit: cover; height: 220px;">
                  </div>
                @endforelse

              </div>

              {{-- Controles solo si hay más de una imagen --}}
              @if($project->phaseImages->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselProject{{ $project->id }}" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Siguiente</span>
                </button>
              @endif

              <!-- Etiquetas sobre la imagen -->
              <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                {{ $project->categoria ?? 'Proyecto' }}
              </span>

              @if($project->estado)
                <span class="badge position-absolute bottom-0 end-0 m-2
                  {{ $project->estado == 'completado' ? 'bg-success' : ($project->estado == 'en progreso' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                  {{ ucfirst($project->estado) }}
                </span>
              @endif
            </div>

            <!-- Contenido -->
            <div class="card-body d-flex flex-column">
              <h5 class="fw-bold mb-2">{{ $project->nombre }}</h5>
              <p class="text-muted small flex-grow-1">{{ Str::limit($project->descripcion ?? 'Sin descripción', 120) }}</p>

              <!-- Datos del proyecto -->
              <ul class="list-unstyled small text-secondary mb-3">
                @if($project->viviendas)
                  <li><i class="bi bi-house-door text-primary me-1"></i> {{ $project->viviendas }} viviendas</li>
                @endif
                @if($project->duracion_meses)
                  <li><i class="bi bi-calendar-check text-primary me-1"></i> {{ $project->duracion_meses }} meses</li>
                @endif
                @if($project->area_km)
                  <li><i class="bi bi-rulers text-primary me-1"></i> {{ $project->area_km }} km²</li>
                @endif
                @if($project->ubicacion)
                  <li><i class="bi bi-geo-alt text-primary me-1"></i> {{ $project->ubicacion }}</li>
                @endif
              </ul>

              <!-- Botón Ver más -->
<a href="{{ route('projects.public.show2', $project) }}" class="project-link">
                Ver proyecto <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>

          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">No hay proyectos publicados por el momento.</p>
        </div>
      @endforelse
    </div>

  </div>
</section>
<!-- /Sección de Proyectos -->



   <!-- Sección de Donadores -->
<section id="donadores" class="donadores section">

  <!-- ======= Estilos internos ======= -->
  <style>
    /* Título */
    .donadores .section-title h2 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
      text-align: center;
    }
    .donadores .section-title p {
      text-align: center;
      color: #666;
      margin-bottom: 2rem;
    }

    /* --- Tarjetas destacadas --- */
    .donador-card.featured {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .donador-card.featured:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
    }
    .donador-header {
      display: flex;
      align-items: center;
      padding: 1rem;
      gap: 1rem;
    }
    .donador-image {
      position: relative;
      flex-shrink: 0;
    }
    .donador-image img {
      border-radius: 12px;
      width: 150px;
      height: 150px;
      object-fit: cover;
    }
    .experience-badge {
      position: absolute;
      bottom: 0;
      left: 0;
      background: #10b981;
      color: #fff;
      font-weight: bold;
      padding: 0.3rem 0.6rem;
      border-radius: 0 12px 12px 0;
      font-size: 0.8rem;
    }
    .donador-info h4 {
      margin: 0;
      font-size: 1.2rem;
    }
    .donador-info .position {
      font-size: 0.9rem;
      color: #888;
    }
    .contact-info a {
      display: block;
      font-size: 0.85rem;
      color: #555;
      text-decoration: none;
      margin-top: 0.2rem;
    }
    .donador-details {
      padding: 1rem;
      border-top: 1px solid #eee;
    }
    .credentials {
      display: flex;
      gap: 1rem;
      margin-top: 0.5rem;
      flex-wrap: wrap;
    }
    .cred-item {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.85rem;
      color: #555;
    }
    .social-links a {
      display: inline-block;
      margin-right: 0.5rem;
      color: #555;
      font-size: 1rem;
      transition: color 0.3s;
    }
    .social-links a:hover {
      color: #10b981;
    }

    /* --- Tarjetas compactas --- */
    .donador-card.compact {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
    }
    .donador-card.compact:hover {
      transform: translateY(-5px) scale(1.03);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .member-photo {
      position: relative;
      overflow: hidden;
    }
    .member-photo img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s;
    }
    .donador-card.compact:hover .member-photo img {
      transform: scale(1.05);
    }
    .hover-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      color: #fff;
      opacity: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      transition: opacity 0.3s;
      flex-direction: column;
      padding: 1rem;
      border-radius: 0 0 12px 12px;
    }
    .donador-card.compact:hover .hover-overlay {
      opacity: 1;
    }
    .member-summary {
      padding: 0.8rem;
      text-align: center;
    }
    .member-summary h5 {
      margin: 0;
      font-size: 1rem;
    }
    .member-summary span {
      font-size: 0.85rem;
      color: #888;
      display: block;
      margin-bottom: 0.5rem;
    }
    .skills {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0.3rem;
    }
    .skill-tag {
      background: #10b981;
      color: #fff;
      font-size: 0.75rem;
      padding: 0.2rem 0.5rem;
      border-radius: 8px;
    }
.footer .footer-links ul a,.footer-contact,.footer-about,.Copyright 
{
    z-index:1;
    }
  </style>
  <!-- ======= Contenido ======= -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Donadores</h2>
    <p>Personas y organizaciones que transforman vidas apoyando nuestra misión social y comunitaria.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">

      {{-- Donadores destacados (tarjetas grandes) --}}
      @foreach(($donors ?? collect())->where('is_featured', true) as $d)
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
          <div class="donador-card featured">
            <div class="donador-header">
              <div class="donador-image">
                <img src="{{ $d->avatar_path ? asset('storage/'.$d->avatar_path) : asset('assets2/img/testimonials/testimonials-1.jpg') }}"
                     alt="{{ $d->name }}">
                @if($d->badge_text)
                  <div class="experience-badge">{{ $d->badge_text }}</div>
                @endif
              </div>
              <div class="donador-info">
                <h4>{{ $d->name }}</h4>
                @if($d->position)
                  <span class="position">{{ $d->position }}</span>
                @endif
                <div class="contact-info">
                  @if($d->email)
                    <a href="mailto:{{ $d->email }}"><i class="bi bi-envelope"></i> {{ $d->email }}</a>
                  @endif
                  @if($d->phone)
                    <a href="tel:{{ $d->phone }}"><i class="bi bi-telephone"></i> {{ $d->phone }}</a>
                  @endif
                </div>
              </div>
            </div>

            <div class="donador-details">
              @if($d->bio)
                <p>{{ $d->bio }}</p>
              @endif

              <div class="credentials">
                @foreach($d->skills_array as $skill)
                  <div class="cred-item">
                    <i class="bi bi-award"></i> <span>{{ $skill }}</span>
                  </div>
                @endforeach
              </div>

              <div class="social-links mt-3">
                @if($d->linkedin_url)<a href="{{ $d->linkedin_url }}"><i class="bi bi-linkedin"></i></a>@endif
                @if($d->twitter_url)<a href="{{ $d->twitter_url }}"><i class="bi bi-twitter-x"></i></a>@endif
                @if($d->facebook_url)<a href="{{ $d->facebook_url }}"><i class="bi bi-facebook"></i></a>@endif
                @if($d->instagram_url)<a href="{{ $d->instagram_url }}"><i class="bi bi-instagram"></i></a>@endif
                @if($d->website_url)<a href="{{ $d->website_url }}"><i class="bi bi-globe2"></i></a>@endif
              </div>
            </div>
          </div>
        </div>
      @endforeach

      {{-- Donadores compactos (tarjetas pequeñas) --}}
      @foreach(($donors ?? collect())->where('is_featured', false) as $d)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 300 + ($loop->index * 80) }}">
          <div class="donador-card compact">
            <div class="member-photo">
              <img src="{{ $d->avatar_path ? asset('storage/'.$d->avatar_path) : asset('assets2/img/testimonials/testimonials-2.jpg') }}"
                   alt="{{ $d->name }}">
              <div class="hover-overlay">
                <h5>{{ $d->name }}</h5>
                @if($d->position)<span>{{ $d->position }}</span>@endif
                <div class="quick-contact mt-2">
                  @if($d->email)<a href="mailto:{{ $d->email }}" class="text-white mx-1"><i class="bi bi-envelope"></i></a>@endif
                  @if($d->phone)<a href="tel:{{ $d->phone }}" class="text-white mx-1"><i class="bi bi-telephone"></i></a>@endif
                  @if($d->linkedin_url)<a href="{{ $d->linkedin_url }}" class="text-white mx-1"><i class="bi bi-linkedin"></i></a>@endif
                </div>
              </div>
            </div>
            <div class="member-summary">
              <h5>{{ $d->name }}</h5>
              @if($d->position)<span>{{ $d->position }}</span>@endif
              @if($d->skills_array)
                <div class="skills">
                  @foreach($d->skills_array as $skill)
                    <span class="skill-tag">{{ $skill }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>
   <!--/fin Sección de Donadores -->

 <!-- Sección Sobre Nosotros -->

   <div class="container section-title" data-aos="fade-up">
    <h2>Sobre Nosotros</h2>
<section id="about" class="about section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center g-5">

      <!-- Contenido de texto -->
      <div class="col-lg-6">
        <div class="about-content" data-aos="fade-right" data-aos-delay="200">

          <h2>{{ $about->titulo ?? 'Construyendo esperanza desde 1995' }}</h2>

          <p class="lead">
            {{ $about->descripcion_principal ?? 'Desde nuestros inicios hemos trabajado para que las familias guatemaltecas tengan acceso a una vivienda segura y un entorno digno.' }}
          </p>

          <p>
            {{ $about->descripcion_secundaria ?? 'Gracias al apoyo de donantes, voluntarios y aliados, hemos construido y mejorado cientos de hogares.' }}
          </p>

          <!-- Logros con imágenes -->
          @php
            $logros = [
              'anios_servicio' => 'Años de servicio',
              'hogares_construidos' => 'Hogares construidos',
              'compromiso_social' => 'Compromiso social',
              'colaboradores_activos' => 'Colaboradores activos',
            ];
          @endphp
          <div class="achievement-boxes row g-4 mt-4">
            @foreach($logros as $field => $label)
            @php $imgField = 'imagen_'.$field; @endphp
            <div class="col-6 col-md-3 text-center" data-aos="fade-up">
                @if(!empty($about->$imgField))
                    <img src="{{ asset('storage/'.$about->$imgField) }}" alt="{{ $label }}" class="img-fluid mb-2" width="50">
                @endif
                <h3>{{ $about->$field ?? '' }}</h3>
                <p>{{ $label }}</p>
            </div>
            @endforeach
          </div>
          <!-- Certificaciones -->
<div class="certifications mt-5" data-aos="fade-up" data-aos-delay="700">
    <h5>Alianzas y Reconocimientos</h5>
    <div class="row g-3 align-items-center">
        @foreach(['badge_1', 'badge_2', 'badge_3'] as $badge)
            <div class="col-4 col-md-3">
                @if(!empty($about->$badge))
                    <img src="{{ asset('storage/'.$about->$badge) }}" alt="Certificación" class="img-fluid">
                @else
                    <!-- Imagen por defecto si no hay badge -->
                    <img src="{{ asset('assets/img/construction/default-badge.webp') }}" alt="Certificación" class="img-fluid">
                @endif
            </div>
        @endforeach
    </div>
</div>
          <!-- Botón -->
          <div class="cta-container mt-5" data-aos="fade-up" data-aos-delay="800">
            <a href="{{ $about->link_conoce_mas ?? '#' }}" class="btn btn-primary">Conoce más sobre nosotros</a>
          </div>
        </div>
      </div>

      <!-- Imágenes principales -->
      <div class="col-lg-6">
        <div class="about-image position-relative" data-aos="fade-left" data-aos-delay="200">

          @if(!empty($about->imagen_principal))
            <img src="{{ asset('storage/'.$about->imagen_principal) }}" alt="Equipo de voluntarios" class="img-fluid main-image rounded">
          @else
            <img src="{{ asset('assets/img/construction/project-3.webp') }}" alt="Equipo de voluntarios" class="img-fluid main-image rounded">
          @endif

          <div class="image-overlay">
            @if(!empty($about->imagen_secundaria))
              <img src="{{ asset('storage/'.$about->imagen_secundaria) }}" alt="Familia beneficiada" class="img-fluid rounded">
            @else
              <img src="{{ asset('assets/img/construction/project-7.webp') }}" alt="Familia beneficiada" class="img-fluid rounded">
            @endif
          </div>

          <div class="experience-badge" data-aos="zoom-in" data-aos-delay="500">
            <span>{{ $about->anios_servicio ?? '25+' }}</span>
            <p>Años de experiencia</p>
          </div>

        </div>
      </div>

    </div>
  </div>

</section>
<!-- /Sección Sobre Nosotros -->

  </main>

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
          <li><a href="#about">Quiénes Somos</a></li>
          <li><a href="#services">Eventos</a></li>
          <li><a href="#projects">Proyectos</a></li>
          <li><a href="#get-started">Donar</a></li>
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
  font-size: 1.05rem; /* 🔹 Más grandes */
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
  width: 50px; /* 🔹 Más grandes */
  height: 50px; /* 🔹 Más grandes */
  border-radius: 50%;
  background: rgba(255, 215, 0, 0.25);
  color: #ffd700 !important;
  font-size: 1.5rem; /* 🔹 Íconos más grandes */
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

/* Quitar flechas del carrusel de beneficiarios/testimoniales */
.beneficiarios .swiper-button-next,
.beneficiarios .swiper-button-prev {
  display: none !important;
  visibility: hidden !important;
}
</style>

</body>
</html>


</html>