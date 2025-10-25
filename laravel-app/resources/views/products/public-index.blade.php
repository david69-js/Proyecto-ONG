<x-head>
  <link rel="stylesheet" href="assets/css/donadores.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</x-head>

<body class="index-page d-flex flex-column min-vh-100">
<x-header />
<main class="main flex-grow-1">

<!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content" data-aos="fade-right" data-aos-delay="200">
          <!-- Subtítulo -->
          <span class="subtitle">Materiales y herramientas disponibles</span>
          
          <!-- Título principal -->
          <h1>Productos para Construir Hogares</h1>
          
          <!-- Descripción -->
          <p>Explora los materiales de construcción, herramientas y suministros disponibles para las familias que construyen sus hogares con Habitat Guatemala.</p>
          
          <!-- Botones -->
          <div class="hero-buttons">
            <a href="#products" class="btn-primary">
              Ver Productos Disponibles
            </a>
          </div>
          
          <!-- Logros numéricos -->
          <div class="trust-badges">
            <div class="badge-item">
              <i class="bi bi-box"></i>
              <div class="badge-text">
                <span class="count">{{ $products->count() }}</span>
                <span class="label">Productos disponibles</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-tags"></i>
              <div class="badge-text">
                <span class="count">{{ $categories->count() ?? '0' }}</span>
                <span class="label">Categorías</span>
              </div>
            </div>
            <div class="badge-item">
              <i class="bi bi-star"></i>
              <div class="badge-text">
                <span class="count">{{ $products->where('is_featured', true)->count() }}</span>
                <span class="label">Productos destacados</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="hero-image">
          <!-- Imagen principal -->
          <img src="{{ asset('assets/img/construction/showcase-3.webp') }}" alt="Materiales de construcción" class="img-fluid">
          
          <!-- Badge de la imagen -->
          <div class="image-badge">
            <span>Materiales de calidad</span>
            <p>Para construir hogares seguros</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Sección Hero -->

<!-- Sección de Productos -->
<section id="products" class="products section">
  <div class="container section-title">
    <h2>Nuestros Productos</h2>
    <p>Materiales de construcción, herramientas y suministros disponibles para las familias que construyen sus hogares con Habitat Guatemala</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    
    <!-- Filtros -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form method="GET" action="{{ route('products.public.index') }}" class="row g-3">
              <div class="col-md-4">
                <input type="text" class="form-control" name="search" 
                       placeholder="Buscar productos..." value="{{ request('search') }}">
              </div>
              <div class="col-md-3">
                <select class="form-select" name="category">
                  <option value="">Todas las categorías</option>
                  @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                      {{ $category }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-select" name="condition">
                  <option value="">Todas las condiciones</option>
                  <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Nuevo</option>
                  <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Como Nuevo</option>
                  <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Bueno</option>
                  <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Regular</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-search"></i> Buscar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Grid de productos -->
    <div class="row gy-4">
      @forelse($products as $product)
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="service-card {{ $product->is_featured ? 'featured' : '' }}">
            @if($product->is_featured)
              <div class="service-badge">Destacado</div>
            @endif
            <div class="service-icon">
              <img src="{{ $product->main_image_url }}" 
                   class="img-fluid product-image" 
                   alt="{{ $product->name }}"
                   style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"
                   loading="lazy">
            </div>
            <h3>{{ $product->name }}</h3>
            <p>{{ Str::limit($product->short_description ?? $product->description, 100) }}</p>
            <div class="service-features">
              <span><i class="bi bi-tag"></i> {{ $product->category }}</span>
              <span><i class="bi bi-box"></i> {{ $product->stock_quantity }} unidades</span>
              @if($product->suggested_price)
                <span><i class="bi bi-currency-dollar"></i> {{ $product->formatted_suggested_price }}</span>
              @endif
            </div>
            <a href="{{ route('products.public.show', $product) }}" class="btn btn-outline-primary mt-auto">
              Ver más <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center py-5">
            <i class="bi bi-box fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No se encontraron productos</h4>
            <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
          </div>
        </div>
      @endforelse
    </div>

    

<!-- Call to Action -->
<section id="cta" class="cta">
  <div class="container" data-aos="zoom-in">
    <div class="row">
      <div class="col-lg-9 text-center text-lg-start">
        <h3>¿Necesitas ayuda para encontrar el producto adecuado?</h3>
        <p>Nuestro equipo está aquí para ayudarte a encontrar los materiales perfectos para tu proyecto de construcción.</p>
      </div>
      <div class="col-lg-3 cta-btn-container text-center">
        <a class="cta-btn align-middle" href="#contact">Contactar</a>
      </div>
    </div>
  </div>
</section>

</main>

<style>
.product-image {
  image-rendering: -webkit-optimize-contrast;
  image-rendering: crisp-edges;
  image-rendering: pixelated;
  -ms-interpolation-mode: nearest-neighbor;
  transition: transform 0.3s ease, filter 0.3s ease;
}

.product-image:hover {
  transform: scale(1.05);
  filter: brightness(1.1) contrast(1.1);
}

.service-card {
  overflow: hidden;
  transition: box-shadow 0.3s ease;
}

.service-card:hover {
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.service-icon {
  position: relative;
  overflow: hidden;
  border-radius: 10px;
}

.service-icon::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
  transform: translateX(-100%);
  transition: transform 0.6s ease;
}

.service-card:hover .service-icon::after {
  transform: translateX(100%);
}

/* Mejoras adicionales para imágenes */
.service-card .service-icon img {
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  transform: translateZ(0);
  -webkit-transform: translateZ(0);
}

/* Optimización para diferentes tipos de imagen */
.product-image[src*=".jpg"], 
.product-image[src*=".jpeg"] {
  image-rendering: auto;
}

.product-image[src*=".png"] {
  image-rendering: crisp-edges;
}

.product-image[src*=".webp"] {
  image-rendering: -webkit-optimize-contrast;
}

/* Padding-top para elementos flex en móvil */
@media (max-width: 768px) {
  .d-flex.justify-content-between.align-items-center {
    padding-top: 1rem;
  }
}

/* Padding-top para breadcrumbs solo en móvil */
@media (max-width: 768px) {
  .breadcrumbs {
    padding-top: 80px !important;
  }
}
</style>

<x-footer />