<!DOCTYPE html>
<html lang="es">
@php
    use Illuminate\Support\Str;
@endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Productos | Habitat Guatemala</title>
  <meta name="description" content="Compra productos que apoyan directamente los proyectos de Habitat Guatemala.">
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

    /* ---------- HERO ---------- */
    #products-hero.hero{
      min-height: 60vh;
      padding: 140px 0 60px;
      position: relative;
      overflow: hidden;
    }
    #products-hero .hero-bg{
      position:absolute;inset:0;
    }
    #products-hero .hero-bg img{
      width:100%;height:100%;object-fit:cover;filter:brightness(.55);
    }
    #products-hero .overlay{
      position:absolute;inset:0;
      background:
        radial-gradient(1200px 600px at 15% 15%, rgba(212,175,55,.28), transparent 60%),
        linear-gradient(135deg, rgba(184,134,11,.55) 0%, rgba(241,196,15,.35) 100%);
      opacity:.9;
    }
    #products-hero .subtitle{
      background: rgba(255,255,255,.18);
      border:1px solid rgba(255,255,255,.25);
      color:#fff; padding:.35rem .9rem; border-radius:999px;
      backdrop-filter: blur(8px);
      display:inline-flex; align-items:center; gap:.5rem;
      font-weight:600;
    }
    #products-hero h1{ color:#fff; }
    #products-hero p{ color:rgba(255,255,255,.9); }
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

    /* ---------- GRID / CARD DE PRODUCTO ---------- */
    .product-card{
      background:#fff; border-radius:14px; overflow:hidden;
      box-shadow:0 6px 16px rgba(0,0,0,.06);
      height:100%; display:flex; flex-direction:column; border:2px solid transparent;
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .product-card:hover{
      transform: translateY(-4px);
      box-shadow:0 12px 26px rgba(0,0,0,.12);
    }
    .product-card.featured{ border-color: var(--accent-color-2); box-shadow:0 8px 20px rgba(241,196,15,.25); }
    .product-badge{
      position:absolute; top:12px; left:12px;
      background: var(--accent-color-2); color:#1a1a1a;
      padding:.35rem .7rem; border-radius:999px; font-size:.8rem; font-weight:700; z-index:2;
      box-shadow:0 2px 10px rgba(241,196,15,.35);
    }

    .product-media{ position:relative; overflow:hidden; }
    .product-media img{
      width:100%; height:220px; object-fit:cover; display:block;
      transition: transform .4s ease, filter .3s ease; backface-visibility:hidden;
    }
    .product-card:hover .product-media img{ transform: scale(1.04); filter:brightness(1.06) contrast(1.04); }
    .shine::after{
      content:''; position:absolute; inset:0;
      background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,.14) 50%, transparent 70%);
      transform: translateX(-100%); transition: transform .7s ease;
    }
    .product-card:hover .shine::after{ transform: translateX(100%); }

    .product-body{ padding:1rem 1rem 1.1rem; display:flex; flex-direction:column; flex:1; }
    .product-title{ font-size:1.05rem; font-weight:700; color:#222; margin: .25rem 0 .35rem; }
    .product-desc{ color:#6b7280; font-size:.95rem; margin-bottom:.75rem; }
    .product-meta{ display:grid; grid-template-columns:1fr 1fr; gap:.35rem .75rem; font-size:.9rem; color:#444; margin-bottom: .75rem; }
    .product-meta i{ color: var(--accent-color); margin-right:.4rem; }

    .price-bubble{
      display:inline-flex; align-items:center; gap:.35rem; font-weight:800;
      padding:.35rem .6rem; border-radius:10px; background:#f8fafc; border:1px solid #eef2f7;
      color:#111827;
    }

    .condition-badge{
      display:inline-flex; align-items:center; gap:.4rem;
      border-radius:999px; padding:.2rem .6rem; font-size:.8rem; font-weight:600; border:1px solid #e5e7eb;
      background:#fff;
    }

    .product-actions{ margin-top:auto; display:flex; gap:.5rem; flex-wrap:wrap; }
    .product-actions .btn{ border-radius:10px; font-weight:600; }

    .btn-outline-amber{
      border-color: var(--accent-color); color: var(--accent-color);
    }
    .btn-outline-amber:hover{
      background: var(--accent-color); color:#fff; border-color: var(--accent-color);
    }

    /* ---------- PAGINACIÓN ---------- */
    .pagination .page-link{
      border-radius:10px; margin:0 .2rem; color:#111; border:1px solid #e5e7eb;
    }
    .pagination .page-item.active .page-link{
      background: var(--accent-color); border-color: var(--accent-color); color:#fff;
    }

    /* ---------- CTA ---------- */
    #products-cta.call-to-action{
      background:#fff;
      border-top:1px solid #f0f2f6;
    }
    #products-cta .btn{
      border-radius:999px; padding:.7rem 1.2rem; font-weight:700;
    }

    /* Footer click fix */
    .footer::before{ pointer-events:none!important; }
    footer, .footer, #footer{ position:relative!important; z-index:10!important; pointer-events:auto!important; }
    footer a, .footer a{ pointer-events:auto!important; }

    @media (max-width: 768px){
      #products-hero{ padding:120px 0 40px; }
      .product-media img{ height:200px; }
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

          <li><a href="{{ route('products.public.index2') }}" class="active">Productos</a></li>
        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <!-- /Header -->

  <main class="main flex-grow-1">

    <!-- HERO productos (imagen + dorado) -->
    <section id="products-hero" class="hero section">
      <div class="hero-bg">
        <img src="{{ asset('assets/img/apoyo.png') }}" alt="Apóyanos comprando">
        <div class="overlay"></div>
      </div>

      <div class="info position-relative">
        <div class="container" data-aos="fade-up" data-aos-delay="80">
          <div class="row align-items-center g-4">
            <div class="col-lg-7" data-aos="fade-right" data-aos-delay="120">
              <span class="subtitle">
                <i class="bi bi-bag-heart-fill"></i> Apóyanos comprando
              </span>
              <h1 class="mt-3">Nuestros Productos</h1>
              <p class="lead text-white-75 mb-4">
                Cada compra contribuye directamente a construir hogares seguros y dignos para familias guatemaltecas.
              </p>

              <div class="hero-buttons d-flex flex-wrap gap-2">
                <a href="#products-list" class="btn btn-amber">
                  Ver productos <i class="bi bi-arrow-down-short ms-1"></i>
                </a>
                <a href="{{ url('/#get-started') }}" class="btn btn-outline-light">
                  Donar ahora
                </a>
              </div>

              <div class="trust-badges">
                <div class="badge-item">
                  <i class="bi bi-box"></i>
                  <div class="badge-text">
                    <span class="count">{{ $products->total() ?? $products->count() }}</span>
                    <span class="label">Productos disponibles</span>
                  </div>
                </div>
                <div class="badge-item">
                  <i class="bi bi-tags"></i>
                  <div class="badge-text">
                    <span class="count">{{ ($categories ?? collect())->count() }}</span>
                    <span class="label">Categorías</span>
                  </div>
                </div>
                <div class="badge-item">
                  <i class="bi bi-star-fill"></i>
                  <div class="badge-text">
                    <span class="count">{{ ($featuredCount ?? ($products->where('is_featured', true)->count() ?? 0)) }}</span>
                    <span class="label">Destacados</span>
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
            <form method="GET" action="{{ route('products.public.index2') }}" class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Buscar</label>
                <input type="text" class="form-control" name="search" placeholder="Buscar productos..."
                       value="{{ request('search') }}">
              </div>
              <div class="col-md-3">
                <label class="form-label">Categoría</label>
                <select class="form-select" name="category">
                  <option value="">Todas</option>
                  @foreach(($categories ?? collect()) as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                      {{ $category }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Condición</label>
                <select class="form-select" name="condition">
                  <option value="">Todas</option>
                  <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Nuevo</option>
                  <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Como Nuevo</option>
                  <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Bueno</option>
                  <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Regular</option>
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

    <!-- GRID DE PRODUCTOS -->
    <section id="products-list" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="120">
        <div class="row gy-4">
          @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 150 + $loop->index*60 }}">
              <div class="product-card {{ $product->is_featured ? 'featured' : '' }}">
                <div class="product-media shine">
                  @if($product->is_featured)
                    <span class="product-badge"><i class="bi bi-star-fill me-1"></i> Destacado</span>
                  @endif
                  <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="product-body">
                  <div class="d-flex align-items-center justify-content-between gap-2">
                    <h3 class="product-title mb-0">{{ $product->name }}</h3>
                    @if($product->suggested_price)
                      <div class="price-bubble">
                        <i class="bi bi-cash-coin"></i> {{ $product->formatted_suggested_price }}
                      </div>
                    @endif
                  </div>

                  <p class="product-desc">
                    {{ Str::limit($product->short_description ?? $product->description, 110) }}
                  </p>

                  <div class="product-meta">
                    <div><i class="bi bi-tag"></i> {{ $product->category }}</div>
                    <div><i class="bi bi-box"></i> {{ $product->stock_quantity }} uds</div>
                    @if($product->condition_formatted)
                      <div class="mt-1">
                        <span class="condition-badge"><i class="bi bi-shield-check"></i> {{ $product->condition_formatted }}</span>
                      </div>
                    @endif
                    @if($product->is_digital)
                      <div class="mt-1">
                        <span class="badge bg-info text-dark rounded-pill">Digital</span>
                      </div>
                    @endif
                  </div>

                  <div class="product-actions">
                    <a href="{{ route('products.public.show2', $product) }}" class="btn btn-outline-amber">
                      Ver detalle <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="#products-cta" class="btn btn-outline-secondary">
                      Contactar
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="text-center py-5">
                <i class="bi bi-box fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No se encontraron productos</h4>
                <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
              </div>
            </div>
          @endforelse
        </div>

        <!-- Paginación -->
        @if(method_exists($products, 'links'))
          <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links() }}
          </div>
        @endif
      </div>
    </section>

    <!-- Separador -->
    <div class="container"><hr class="my-5" style="border-color: var(--accent-color); opacity:.25;"></div>

    <!-- CTA -->
    <section id="products-cta" class="call-to-action section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <div class="content">
              <h3>¿Necesitas ayuda para encontrar el producto adecuado?</h3>
              <p>Nuestro equipo puede orientarte para elegir los materiales perfectos para tu proyecto.</p>
            </div>
          </div>
          <div class="col-lg-4 text-center text-lg-end">
            @if(Route::has('contact'))
              <a href="{{ route('contact') }}" class="btn btn-amber">Contactar</a>
            @else
              <a href="{{ url('/#contact') }}" class="btn btn-amber">Contactar</a>
            @endif
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer (igual al tema) -->
  <footer id="footer" class="footer dark-background w-100 mt-auto" style="padding: 0;">
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
