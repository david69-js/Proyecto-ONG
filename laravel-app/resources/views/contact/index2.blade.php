<!DOCTYPE html>
<html lang="es">
@php
  use Illuminate\Support\Str;
  use Illuminate\Support\Facades\Route as R;
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Contáctanos | Habitat Guatemala</title>
  <meta name="description" content="¿Tienes preguntas o deseas más información? Contáctanos y únete a nuestra misión de construir esperanza en Guatemala.">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/logo-pestañas.ico') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

  <style>
    :root {
      --gold-dark: #b8860b;
      --gold-light: #f1c40f;
    }

    body.contact-page { background-color: #fffaf0; }

    /* Hero dorado */
    #hero-contact {
      position: relative;
      min-height: 60vh;
      padding: 150px 0 100px;
      color: #fff;
      text-align: center;
      overflow: hidden;
    }

    #hero-contact::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(900px 500px at 10% 10%, rgba(241,196,15,0.25), transparent),
                  linear-gradient(135deg, #b8860b 0%, #d4af37 100%);
      z-index: 0;
    }

    #hero-contact .container {
      position: relative;
      z-index: 2;
    }

    #hero-contact h1 {
      font-weight: 800;
      font-size: 3rem;
    }

    #hero-contact p {
      max-width: 800px;
      margin: 0 auto;
      color: rgba(255,255,255,0.9);
      font-size: 1.2rem;
    }

    /* Formulario */
    .contact-form {
      padding: 100px 0;
    }

    .contact-form .card {
      border: none;
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 10px 40px rgba(184,134,11,0.1);
    }

    .contact-form .card:hover {
      box-shadow: 0 15px 45px rgba(184,134,11,0.15);
    }

    .contact-form .form-control,
    .contact-form .form-select {
      border: 2px solid #eee;
      border-radius: 10px;
      padding: 12px 15px;
    }

    .contact-form .form-control:focus,
    .contact-form .form-select:focus {
      border-color: var(--gold-light);
      box-shadow: 0 0 0 0.2rem rgba(241,196,15,0.25);
    }

    .contact-form .btn-primary {
      background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
      border: none;
      border-radius: 10px;
      padding: 12px 30px;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
    }

    .contact-form .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(184,134,11,0.4);
    }

    /* CTA final */
    .cta {
      background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
      color: white;
      padding: 80px 0;
      text-align: center;
    }

    .cta h3 { font-weight: 700; margin-bottom: 10px; }
    .cta .cta-btn {
      background: white;
      color: var(--gold-dark);
      padding: 10px 25px;
      border-radius: 25px;
      font-weight: 600;
      transition: 0.3s;
    }
    .cta .cta-btn:hover {
      background: var(--gold-light);
      color: white;
    }
  </style>
</head>

<body class="contact-page index-page d-flex flex-column min-vh-100">

  <!-- Header -->
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
          <li><a href="{{ url('/#projects') }}">Proyectos</a></li>
          <li><a href="{{ url('/#get-started') }}">Donaciones</a></li>
          <li><a href="{{ route('contact.index2') }}" class="active">Contacto</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <!-- /Header -->

  <main class="main flex-grow-1">

    <!-- Hero -->
    <section id="hero-contact" class="hero section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <span class="d-block mb-2 text-white-75">Estamos aquí para ayudarte</span>
        <h1>Contáctanos</h1>
        <p class="mt-3">¿Tienes alguna pregunta o necesitas información sobre nuestros programas? Escríbenos y con gusto te atenderemos.</p>
      </div>
    </section>

    <!-- Formulario -->
    <section id="contact-form" class="contact-form section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card shadow-lg">
              <div class="card-body p-5">
                <div class="text-center mb-4">
                  <h2 class="fw-bold" style="color: var(--gold-dark);">Envíanos un Mensaje</h2>
                  <p class="text-muted">Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>
                </div>

                <form action="{{ route('contact.send2') }}" method="POST" novalidate>
                  @csrf
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label for="name" class="form-label"><i class="bi bi-person me-1"></i> Nombre *</label>
                      <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6">
                      <label for="email" class="form-label"><i class="bi bi-envelope me-1"></i> Correo *</label>
                      <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                    </div>

                    <div class="col-md-6">
                      <label for="phone" class="form-label"><i class="bi bi-telephone me-1"></i> Teléfono</label>
                      <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6">
                      <label for="subject" class="form-label"><i class="bi bi-tag me-1"></i> Asunto *</label>
                      <select id="subject" name="subject" class="form-select" required>
                        <option value="">Selecciona un asunto</option>
                        <option value="Información general">Información general</option>
                        <option value="Voluntariado">Voluntariado</option>
                        <option value="Donaciones">Donaciones</option>
                        <option value="Proyectos">Proyectos</option>
                        <option value="Productos">Productos</option>
                        <option value="Otro">Otro</option>
                      </select>
                    </div>

                    <div class="col-12">
                      <label for="message" class="form-label"><i class="bi bi-chat-dots me-1"></i> Mensaje *</label>
                      <textarea id="message" name="message" rows="6" class="form-control" required placeholder="Escribe tu mensaje aquí...">{{ old('message') }}</textarea>
                    </div>

                    <div class="col-12 text-center mt-4">
                      <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-send me-2"></i> Enviar Mensaje
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta">
      <div class="container" data-aos="fade-up">
        <h3>¿Prefieres hablar directamente?</h3>
        <p>Llámanos o visítanos — estaremos encantados de atenderte.</p>
        <a href="tel:+50235957273" class="cta-btn mt-3"><i class="bi bi-telephone me-1"></i> Llamar Ahora</a>
      </div>
    </section>

  </main>

  <!-- Footer del tema -->
  <x-footer />
  
  <!-- JS del tema -->
  <script src="{{ asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets2/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets2/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets2/js/main.js') }}"></script>
</body>
</html>
