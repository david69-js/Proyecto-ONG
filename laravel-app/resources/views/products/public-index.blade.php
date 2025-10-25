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
          <span class="subtitle">Apóyanos comprando</span>
          
          <!-- Título principal -->
          <h1>Nuestros Productos</h1>
          
          <!-- Descripción -->
          <p>Estos productos nos ayudan a mantener nuestra labor solidaria. Cada compra contribuye directamente a nuestros proyectos de construcción de hogares para familias necesitadas en Guatemala.</p>
          
          <!-- Botones -->
          <div class="hero-buttons">
            <a href="#products" class="btn-primary">
              Apóyanos
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
          <img src="{{ asset('assets/img/apoyo.png') }}" alt="Apóyanos comprando" class="img-fluid">
          
      
        </div>
      </div>
    </div>
  </div>
</section><!-- /Sección Hero -->

<!-- Sección de Productos -->
<section id="products" class="products section">
  <div class="container section-title">
    <h2>Nuestros Productos</h2>
    <p>Con cada producto que adquieres, apoyas directamente nuestra misión de construir hogares seguros y dignos para familias guatemaltecas que más lo necesitan</p>
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
          <div class="service-card {{ $product->is_featured ? 'featured' : '' }} product-card">
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
            <div class="product-content">
              <h3>{{ $product->name }}</h3>
              <p>{{ Str::limit($product->short_description ?? $product->description, 100) }}</p>
                  <div class="service-features">
                    <span><i class="bi bi-tag {{ $product->is_featured ? 'product-icon' : '' }}"></i> {{ $product->category }}</span>
                    <span><i class="bi bi-box {{ $product->is_featured ? 'product-icon' : '' }}"></i> {{ $product->stock_quantity }} unidades</span>
                    @if($product->suggested_price)
                      <span><i class="bi bi-currency-dollar {{ $product->is_featured ? 'product-icon' : '' }}"></i> {{ $product->formatted_suggested_price }}</span>
                    @endif
                  </div>
                  <a href="{{ route('products.public.show', $product) }}" class="btn btn-outline-primary {{ $product->is_featured ? 'product-btn' : '' }} mt-auto">
                    Ver más <i class="bi bi-arrow-right ms-1 {{ $product->is_featured ? 'product-icon' : '' }}"></i>
                  </a>
            </div>
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
        <a class="cta-btn align-middle" href="{{ route('contact') }}">Contactar</a>
      </div>
    </div>
  </div>
</section>

</main>

<style>
/* Estilos para tarjetas de productos */
.product-card {
  background: #fff;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  border: 2px solid transparent;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

        /* Borde naranja para productos destacados */
        .product-card.featured {
          border-color: #ff8c00;
          box-shadow: 0 5px 15px rgba(255, 140, 0, 0.2);
        }

        .product-card.featured:hover {
          box-shadow: 0 15px 35px rgba(255, 140, 0, 0.3);
        }

/* Contenido con padding */
.product-content {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.product-content h3 {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
  color: #333;
  line-height: 1.3;
}

.product-content p {
  color: #666;
  font-size: 0.9rem;
  line-height: 1.5;
  margin-bottom: 1rem;
  flex: 1;
}

/* Características del producto */
.service-features {
  margin-bottom: 1rem;
}

.service-features span {
  display: block;
  font-size: 0.85rem;
  color: #555;
  margin-bottom: 0.5rem;
  padding: 0.25rem 0;
}

        .service-features i {
          color: #007bff;
          margin-right: 0.5rem;
          width: 16px;
        }

        /* Iconos de productos en naranja */
        .product-icon {
          color: #ff8c00 !important;
        }

        /* Botón */
        .product-content .btn {
          margin-top: auto;
          font-size: 0.9rem;
          padding: 0.6rem 1.2rem;
          border-radius: 8px;
          font-weight: 500;
          transition: all 0.3s ease;
        }

        .product-content .btn:hover {
          transform: translateY(-2px);
          box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        /* Botón de productos en naranja */
        .product-btn {
          border-color: #ff8c00 !important;
          color: #ff8c00 !important;
        }

        .product-btn:hover {
          background-color: #ff8c00 !important;
          border-color: #ff8c00 !important;
          color: white !important;
          box-shadow: 0 5px 15px rgba(255, 140, 0, 0.3) !important;
        }

/* Imagen del producto */
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

        /* Badge destacado */
        .service-badge {
          position: absolute;
          top: 10px;
          right: 10px;
          background: #ff8c00;
          color: white;
          padding: 0.4rem 0.8rem;
          border-radius: 20px;
          font-size: 0.75rem;
          font-weight: 600;
          z-index: 2;
          box-shadow: 0 2px 8px rgba(255, 140, 0, 0.3);
        }

/* Responsive */
@media (max-width: 768px) {
  .product-content {
    padding: 1rem;
  }
  
  .product-content h3 {
    font-size: 1.1rem;
  }
  
  .product-content p {
    font-size: 0.85rem;
  }
  
  .service-features span {
    font-size: 0.8rem;
  }
  
  .d-flex.justify-content-between.align-items-center {
    padding-top: 1rem;
  }
}

@media (max-width: 576px) {
  .product-content {
    padding: 0.75rem;
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