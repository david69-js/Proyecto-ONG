<!DOCTYPE html>
<html lang="es">
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route as R;
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $product->name }} - Producto | Habitat Guatemala</title>
  <meta name="description" content="{{ Str::limit($product->description ?? 'Conoce más sobre este producto de Habitat Guatemala', 160) }}">
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
    /* Página de producto con estilo del tema */
    body.product-page { background-color: var(--background-color, #ffffff); }

    /* Hero */
    #product-hero .hero-bg img { object-fit: cover; filter: brightness(.45); }
    .text-white-75 { color: rgba(255,255,255,.75) !important; }

    .product-quick-info .info-item {
      background: rgba(255,255,255,0.1);
      padding: .5rem 1rem;
      border-radius: 25px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.25);
      color: rgba(255,255,255,0.95);
    }

    /* Cards coherentes con el tema */
    .service-card { background:#fff; border-radius:12px; padding:1.25rem; box-shadow:0 6px 16px rgba(0,0,0,.06); }

    /* Galería */
    .main-image { border-radius: 12px; overflow: hidden; box-shadow: 0 6px 16px rgba(0,0,0,.08); }
    .gallery-thumbnails .thumb {
      height: 80px; width: 100%; object-fit: cover; border-radius:8px; cursor:pointer;
      transition: transform .2s, box-shadow .2s; border:2px solid transparent;
    }
    .gallery-thumbnails .thumb:hover { transform: scale(1.03); box-shadow:0 6px 16px rgba(0,0,0,.15); }
    .gallery-thumbnails .thumb.active { border-color: var(--accent-color,#b8860b); }

    /* Tabs */
    .nav-tabs { border-bottom: 2px solid #e9ecef; }
    .nav-tabs .nav-link { border:none; color:#666; font-weight:500; padding:14px 18px; margin-right:10px; border-radius:10px 10px 0 0; }
    .nav-tabs .nav-link.active { background:#b8860b; color:#fff; }

    /* Precio destacado */
    .price-bubble {
      display:inline-block; padding:.35rem .75rem; border-radius:999px;
      background: rgba(255,255,255,.2); border:1px solid rgba(255,255,255,.35);
      backdrop-filter: blur(8px);
    }

    /* Botones CTA */
    .cta-buttons .btn { margin-bottom:.5rem; }

    /* Breadcrumbs minimal */
    .breadcrumbs { padding: 0; background: transparent; }
    .breadcrumbs ol { margin:0; }

    /* Footer click fix */
    .footer::before { pointer-events: none !important; }
    footer, .footer, #footer { position:relative !important; z-index:10 !important; pointer-events:auto !important; }
    footer a, .footer a { pointer-events:auto !important; }

    /* Dorado (acento) cuando no hay imagen */
    .gold-hero-bg {
      background:
        radial-gradient(1200px 600px at 15% 15%, rgba(212, 175, 55, 0.35), transparent),
        linear-gradient(135deg, #b8860b 0%, #f1c40f 100%);
      opacity: .9;
    }
  </style>
</head>

<body class="product-page index-page d-flex flex-column min-vh-100">

  <!-- Header del tema -->
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

          <li><a href="{{ route('products.public.index2') }}" class="active">Productos</a></li>
        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <!-- /Header -->

  <main class="main flex-grow-1">

    <!-- Hero del Producto -->
    <section id="product-hero" class="hero section dark-background position-relative" style="min-height: 50vh; padding: 140px 0 60px; overflow: hidden;">
      <div class="hero-bg position-absolute top-0 start-0 w-100 h-100">
        @if($product->main_image_url)
          <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-100 h-100">
        @else
          <div class="w-100 h-100 gold-hero-bg"></div>
          <h1 class="sitename">Habitat Guatemala</h1> <span>.</span>
        @endif
      </div>

      <div class="info position-relative text-white">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-right" data-aos-delay="150">

              <!-- Badges -->
              <div class="d-flex flex-wrap gap-2 mb-3">
                @if($product->is_featured)
                  <span class="price-bubble"><i class="bi bi-star me-1"></i> Destacado</span>
                @endif
                <span class="price-bubble"><i class="bi bi-box-seam me-1"></i> {{ $product->is_digital ? 'Digital' : 'Físico' }}</span>
                @if($product->condition_formatted)
                  <span class="price-bubble"><i class="bi bi-tag me-1"></i> {{ $product->condition_formatted }}</span>
                @endif>
              </div>

              <!-- Título -->
              <h1 class="text-white fw-bold mb-2">{{ $product->name }}</h1>

              <!-- Descripción corta -->
              @if($product->description)
                <p class="text-white-75 mb-4">{{ Str::limit(strip_tags($product->description), 200) }}</p>
              @endif

              <!-- Info rápida -->
              <div class="product-quick-info d-flex flex-wrap gap-3">
                @if($product->sku)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-upc me-2"></i><span>SKU: {{ $product->sku }}</span></div>
                @endif
                @if($product->category)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-collection me-2"></i><span>{{ $product->category }}</span></div>
                @endif
                @if($product->stock_quantity !== null)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-box2-heart me-2"></i><span>{{ $product->stock_quantity }} en stock</span></div>
                @endif
                @if($product->suggested_price)
                  <div class="info-item d-flex align-items-center"><i class="bi bi-currency-dollar me-2"></i><span>{{ $product->formatted_suggested_price }}</span></div>
                @endif
              </div>
            </div>

            <!-- Lateral -->
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="250">
              <div class="text-center">
                @if($product->suggested_price)
                  <div class="display-6 fw-bold mb-2">
                    {{ $product->formatted_suggested_price }}
                  </div>
                  <small class="text-white-75 d-block mb-3">Precio sugerido</small>
                @endif

                <a href="{{ route('products.public.index') }}" class="btn btn-outline-light">
                  <i class="bi bi-arrow-left me-1"></i> Ver más productos
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- /Hero -->

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color,#b8860b); opacity:.25;"></div>

    <!-- Detalles del Producto -->
    <section id="product-details" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Breadcrumbs -->
        <div class="breadcrumbs mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $product->name }}</h2>
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('products.public.index') }}">Productos</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 32) }}</li>
            </ol>
          </div>
        </div>

        <div class="row gy-4">
          <!-- Galería -->
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="150">
            <div class="main-image mb-3">
              <img src="{{ $product->main_image_url ?? asset('assets2/img/projects/construction-1.jpg') }}"
                   alt="{{ $product->name }}"
                   id="mainImage"
                   class="img-fluid w-100"
                   style="max-height:420px; object-fit:cover;">
            </div>

            @if(!empty($product->gallery_urls) && is_array($product->gallery_urls) && count($product->gallery_urls) > 0)
              <div class="gallery-thumbnails">
                <div class="row g-2">
                  @foreach($product->gallery_urls as $idx => $url)
                    <div class="col-3">
                      <img src="{{ $url }}" alt="Imagen {{ $idx+1 }}"
                           class="thumb {{ $idx===0 ? 'active' : '' }}"
                           data-url="{{ $url }}">
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          </div>

          <!-- Info -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="service-card h-100">
              <h3 class="mb-3">Información del Producto</h3>

              <div class="row mb-3">
                <div class="col-6">
                  <strong>SKU:</strong><br><span class="text-muted">{{ $product->sku ?? 'N/A' }}</span>
                </div>
                <div class="col-6">
                  <strong>Categoría:</strong><br><span class="text-muted">{{ $product->category ?? 'N/A' }}</span>
                </div>
              </div>

              @if($product->subcategory || $product->stock_quantity !== null)
              <div class="row mb-3">
                @if($product->subcategory)
                  <div class="col-6">
                    <strong>Subcategoría:</strong><br><span class="text-muted">{{ $product->subcategory }}</span>
                  </div>
                @endif
                @if($product->stock_quantity !== null)
                  <div class="col-6">
                    <strong>Disponible:</strong><br><span class="text-success fw-bold">{{ $product->stock_quantity }} unidades</span>
                  </div>
                @endif
              </div>
              @endif

              @if($product->description)
                <div class="mb-3">
                  <strong>Descripción:</strong>
                  <p class="text-muted mb-0">{{ $product->description }}</p>
                </div>
              @endif

              @if(!empty($product->tags) && is_array($product->tags))
                <div class="mb-3">
                  <strong>Etiquetas:</strong>
                  <div class="mt-2 d-flex flex-wrap gap-2">
                    @foreach($product->tags as $tag)
                      <span class="badge bg-light text-dark">{{ $tag }}</span>
                    @endforeach
                  </div>
                </div>
              @endif

              <div class="cta-buttons mt-3">
                <a href="{{ url('/#contact') }}" class="btn btn-primary me-2">
                  <i class="bi bi-telephone me-1"></i> Consultar Disponibilidad
                </a>
                <a href="{{ route('products.public.index') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left me-1"></i> Volver a Productos
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="row mt-5">
          <div class="col-12" data-aos="fade-up" data-aos-delay="250">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                  <i class="bi bi-gear me-1"></i> Especificaciones
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="physical-tab" data-bs-toggle="tab" data-bs-target="#physical" type="button" role="tab">
                  <i class="bi bi-rulers me-1"></i> Dimensiones
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions" type="button" role="tab">
                  <i class="bi bi-book me-1"></i> Instrucciones
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="ngo-tab" data-bs-toggle="tab" data-bs-target="#ngo" type="button" role="tab">
                  <i class="bi bi-info-circle me-1"></i> Información ONG
                </button>
              </li>
            </ul>

            <div class="tab-content" id="productTabsContent">
              <!-- Especificaciones -->
              <div class="tab-pane fade show active" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                <div class="tab-content-body">
                  @if(!empty($product->specifications) && is_array($product->specifications) && count($product->specifications) > 0)
                    <div class="row">
                      @foreach($product->specifications as $key => $value)
                        <div class="col-md-6 mb-2">
                          <strong>{{ $key }}:</strong> {{ $value }}
                        </div>
                      @endforeach
                    </div>
                  @else
                    <p class="text-muted mb-0">No hay especificaciones disponibles.</p>
                  @endif
                </div>
              </div>

              <!-- Dimensiones -->
              <div class="tab-pane fade" id="physical" role="tabpanel" aria-labelledby="physical-tab">
                <div class="tab-content-body">
                  <div class="row">
                    <div class="col-md-3 mb-2">
                      <strong>Peso:</strong><br>
                      <span class="text-muted">{{ $product->formatted_weight ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3 mb-2">
                      <strong>Dimensiones:</strong><br>
                      <span class="text-muted">{{ $product->formatted_dimensions ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3 mb-2">
                      <strong>Requiere Envío:</strong><br>
                      <span class="text-muted">{{ ($product->requires_shipping ?? false) ? 'Sí' : 'No' }}</span>
                    </div>
                    <div class="col-md-3 mb-2">
                      <strong>Tipo:</strong><br>
                      <span class="text-muted">{{ $product->is_digital ? 'Digital' : 'Físico' }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Instrucciones -->
              <div class="tab-pane fade" id="instructions" role="tabpanel" aria-labelledby="instructions-tab">
                <div class="tab-content-body">
                  @php
                    $hasUsage = !empty($product->usage_instructions);
                    $hasCare  = !empty($product->care_instructions);
                  @endphp
                  @if($hasUsage)
                    <div class="mb-3">
                      <h6>Instrucciones de Uso</h6>
                      <p class="text-muted mb-0">{{ $product->usage_instructions }}</p>
                    </div>
                  @endif
                  @if($hasCare)
                    <div class="mb-3">
                      <h6>Instrucciones de Cuidado</h6>
                      <p class="text-muted mb-0">{{ $product->care_instructions }}</p>
                    </div>
                  @endif
                  @if(!$hasUsage && !$hasCare)
                    <p class="text-muted mb-0">No hay instrucciones disponibles.</p>
                  @endif
                </div>
              </div>

              <!-- Información ONG -->
              <div class="tab-pane fade" id="ngo" role="tabpanel" aria-labelledby="ngo-tab">
                <div class="tab-content-body">
                  <div class="row">
                    @if(!empty($product->donation_source))
                      <div class="col-md-6 mb-3">
                        <strong>Fuente de Donación:</strong><br>
                        <span class="text-muted">{{ $product->donation_source }}</span>
                      </div>
                    @endif
                    @if(!empty($product->received_date))
                      <div class="col-md-6 mb-3">
                        <strong>Fecha de Recepción:</strong><br>
                        <span class="text-muted">{{ optional($product->received_date)->format('d/m/Y') }}</span>
                      </div>
                    @endif
                  </div>

                  @if(!empty($product->ngo_notes))
                    <div class="mb-3">
                      <strong>Notas Internas:</strong><br>
                      <p class="text-muted mb-0">{{ $product->ngo_notes }}</p>
                    </div>
                  @endif

                  <div class="row">
                    <div class="col-md-6">
                      <strong>Creado por:</strong><br>
                      <span class="text-muted">{{ $product->creator->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                      <strong>Última actualización:</strong><br>
                      <span class="text-muted">{{ optional($product->updated_at)->format('d/m/Y H:i') }}</span>
                    </div>
                  </div>
                </div>
              </div>

            </div> <!-- /tab-content -->
          </div>
        </div>

      </div>
    </section>

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color,#b8860b); opacity:.25;"></div>

    <!-- CTA -->
    <section id="product-cta" class="call-to-action section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <div class="content">
              <h3>¿Interesado en este producto?</h3>
              <p>Contáctanos para conocer la disponibilidad y coordinar la entrega. Tu compra apoya nuestra misión.</p>
            </div>
          </div>
          <div class="col-lg-4 text-center text-lg-end">
            <a href="{{ url('/#contact') }}" class="btn btn-primary">Contactar</a>
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

  <!-- Lógica para galería -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const main = document.getElementById('mainImage');
      const thumbs = document.querySelectorAll('.gallery-thumbnails .thumb');
      thumbs.forEach(t => {
        t.addEventListener('click', () => {
          thumbs.forEach(x => x.classList.remove('active'));
          t.classList.add('active');
          const url = t.getAttribute('data-url');
          if (url && main) main.src = url;
        });
      });
    });
  </script>
</body>
</html>
