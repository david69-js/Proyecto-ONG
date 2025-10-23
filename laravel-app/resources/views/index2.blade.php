<!DOCTYPE html>
<html lang="es">

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

  <!-- Main CSS File -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: UpConstruction
  * Template URL: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>


<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets2/img/logo.png" alt=""> -->
        <h1 class="sitename">Habitat Guatemala</h1> <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html" class="active">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="projects.html">Projects</a></li>
          <li><a href="blog.html">Blog</a></li>
          <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact</a></li>
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
          <a href="{{ optional($hero)->button_secondary_link ?? '#' }}" class="btn btn-outline-light">
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




   @php
  // Credenciales de PayPal desde config/services.php o .env
  $paypalClientId = config('services.paypal.client_id', env('PAYPAL_CLIENT_ID'));
  $paypalCurrency = config('services.paypal.currency', env('PAYPAL_CURRENCY', 'USD'));

  use Illuminate\Support\Facades\Route as R;

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
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="100">100 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="200">200 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="500">500 {{ $paypalCurrency }}</button>
                <button type="button" class="btn btn-outline-primary btn-sm quick-amt" data-amount="1000">1000 {{ $paypalCurrency }}</button>
              </div>
            </div>

            <div class="col-md-6">
              <input type="number" min="1" step="0.01" name="amount" class="form-control" placeholder="Monto ({{ $paypalCurrency }})" required>
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
</section><!-- /Get Started Section -->

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
<section id="beneficiarios" class="beneficiarios section">

  <!-- Título de la sección -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Beneficiarios</h2>
    <p>Transformamos vidas a través de la construcción de viviendas seguras y comunidades sostenibles.</p>
  </div>
  <!-- /Fin título -->

  @if(($testimonials ?? collect())->count())
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="beneficiarios-slider swiper init-swiper">

      <!-- Configuración del Swiper -->
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {"delay": 5000},
          "slidesPerView": 1,
          "spaceBetween": 30,
          "pagination": {"el": ".swiper-pagination", "type": "bullets", "clickable": true},
          "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"}
        }
      </script>

      <!-- Slides -->
      <div class="swiper-wrapper">
        @forelse($testimonials as $t)
          <div class="swiper-slide">
            <div class="beneficiario-slide card border-0 shadow-sm p-4" data-aos="fade-up" data-aos-delay="200">
              
              <!-- Cabecera con estrellas -->
              <div class="beneficiario-header mb-3 d-flex align-items-center justify-content-between">
                <div class="stars-rating text-warning">
                  @for($i=1; $i<=5; $i++)
                    <i class="bi {{ $i <= ($t->rating ?? 5) ? 'bi-star-fill' : 'bi-star' }}"></i>
                  @endfor
                </div>
                <div class="quote-icon text-primary"><i class="bi bi-quote fs-2"></i></div>
              </div>

              <!-- Cuerpo del testimonio -->
              <div class="beneficiario-body mb-4">
                <p class="text-muted fst-italic">{{ $t->body }}</p>
              </div>

              <!-- Pie con autor -->
              <div class="beneficiario-footer d-flex align-items-center">
                @php
                  $avatar = $t->avatar_path ? asset('storage/'.$t->avatar_path) : asset('assets2/img/team/team-1.jpg');
                @endphp
                <img src="{{ $avatar }}" alt="Beneficiario" class="rounded-circle me-3" style="width:60px; height:60px; object-fit:cover;">
                
                <div class="author-details">
                  <h5 class="mb-0">{{ $t->author_name ?? optional($t->beneficiary)->name ?? 'Beneficiario Anónimo' }}</h5>
                  @if($t->role)<small class="text-secondary d-block">{{ $t->role }}</small>@endif
                  @if($t->company)<small class="text-secondary d-block">{{ $t->company }}</small>@endif
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="swiper-slide">
            <div class="beneficiario-slide card border-0 text-center p-5">
              <p class="text-muted">Aún no hay testimonios publicados.</p>
            </div>
          </div>
        @endforelse
      </div>

      <!-- Controles -->
      <div class="swiper-navigation-wrapper mt-3">
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
      </div>

    </div>
  </div>
  @else
    <div class="container text-center py-5">
      <p class="text-muted">Aún no hay beneficiarios registrados.</p>
    </div>
  @endif

</section>
<!-- /Fin Sección de Beneficiarios -->


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
            <a href="{{ route('events.public.show', $event->id) }}" class="readmore stretched-link fw-semibold text-primary">
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

    {{-- Bloque destacado --}}
    @php
      $featured = ($sponsors ?? collect())->firstWhere('is_featured', true);
    @endphp

    @if($featured)
      <div class="row align-items-center mb-5">
        <div class="col-lg-6 order-2 order-lg-1 mt-4 mt-lg-0" data-aos="fade-right" data-aos-delay="200">
          <h3 class="fw-bold mb-3">
            {{ $featured->title ?? ($featured->sponsor?->name ?? 'Patrocinador Destacado') }}
          </h3>
          <p class="text-muted mb-4">
            {{ $featured->description ?? 'Patrocinador con apoyo constante a nuestros proyectos comunitarios.' }}
          </p>

          @if($featured->category)
            <p><i class="bi bi-award text-primary me-2"></i> <strong>{{ $featured->category }}</strong></p>
          @endif
        </div>

        <div class="col-lg-6 order-1 order-lg-2 text-center" data-aos="fade-left" data-aos-delay="300">
          <div class="position-relative d-inline-block rounded overflow-hidden shadow" style="max-width:400px;">
            <img src="{{ $featured->logo_path ? asset('storage/'.$featured->logo_path) : asset('assets2/img/constructions-1.jpg') }}"
                 alt="Logo de patrocinador destacado"
                 class="img-fluid w-100 rounded" style="object-fit:cover;">

            <!-- Overlay elegante -->
            <div class="position-absolute bottom-0 start-0 w-100 text-white p-3"
                 style="background: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0.2));">
              <h5 class="mb-1 fw-semibold">{{ $featured->sponsor?->name ?? 'Patrocinador destacado' }}</h5>
              <small>{{ $featured->category ?? 'Colaborador principal' }}</small>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- Grid de patrocinadores --}}
    <div class="row gy-4">
      @forelse(($sponsors ?? collect()) as $sp)
        @if(!$featured || $featured->id !== $sp->id)
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
        @endif
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">Pronto anunciaremos nuestros patrocinadores.</p>
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

            <!-- Imagen del proyecto -->
            <div class="project-image position-relative">
              <img src="{{ $project->imagen ? asset('storage/'.$project->imagen) : asset('assets2/img/projects/construction-1.jpg') }}"
                   alt="{{ $project->nombre }}"
                   class="img-fluid w-100" style="object-fit: cover; height: 220px;">

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
              <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary mt-auto">
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

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">UpConstruction</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="#">Molestiae accusamus iure</a></li>
            <li><a href="#">Excepturi dignissimos</a></li>
            <li><a href="#">Suscipit distinctio</a></li>
            <li><a href="#">Dilecta</a></li>
            <li><a href="#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="#">Ipsam</a></li>
            <li><a href="#">Laudantium dolorum</a></li>
            <li><a href="#">Dinera</a></li>
            <li><a href="#">Trodelas</a></li>
            <li><a href="#">Flexo</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">UpConstruction</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets2/vendor/php-email-form/validate.js"></script>
  <script src="assets2/vendor/aos/aos.js"></script>
  <script src="assets2/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets2/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets2/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets2/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets2/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets2/js/main.js"></script>

</body>

</html>