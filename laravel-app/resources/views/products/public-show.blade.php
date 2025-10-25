<x-head>
  <link rel="stylesheet" href="assets/css/donadores.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</x-head>

<body class="index-page d-flex flex-column min-vh-100">
<x-header />
<main class="main flex-grow-1">

<!-- Breadcrumb -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>{{ $product->name }}</h2>
      <ol>
        <li><a href="{{ route('home') }}"></a></li>
        <li><a href="{{ route('products.public.index') }}"></a></li>
      </ol>
    </div>
  </div>
</section>

<!-- Product Details -->
<section class="product-details section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row">
      <!-- Imágenes del producto -->
      <div class="col-lg-6">
        <div class="product-gallery" data-aos="fade-right" data-aos-delay="200">
          <!-- Imagen principal -->
          <div class="main-image mb-3">
            <img src="{{ $product->main_image_url }}" 
                 class="img-fluid rounded" 
                 alt="{{ $product->name }}"
                 id="mainImage"
                 style="max-height: 400px; width: 100%; object-fit: cover;">
          </div>

          <!-- Galería de imágenes -->
          @if($product->gallery_images && count($product->gallery_images) > 0)
          <div class="gallery-thumbnails">
            <h6>Galería de Imágenes</h6>
            <div class="row">
              @foreach($product->gallery_urls as $index => $imageUrl)
              <div class="col-3 mb-2">
                <img src="{{ $imageUrl }}" 
                     class="img-thumbnail gallery-thumb" 
                     alt="Imagen {{ $index + 1 }}"
                     style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                     onclick="changeMainImage('{{ $imageUrl }}')">
              </div>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Información del producto -->
      <div class="col-lg-6">
        <div class="product-info" data-aos="fade-left" data-aos-delay="300">
          <!-- Badges de estado -->
          <div class="product-badges mb-3">
            @if($product->is_featured)
              <span class="badge bg-warning">⭐ Destacado</span>
            @endif
            @if($product->is_digital)
              <span class="badge bg-info">💻 Digital</span>
            @endif
            <span class="badge 
              @if($product->condition == 'new') bg-success
              @elseif($product->condition == 'like_new') bg-primary
              @elseif($product->condition == 'good') bg-info
              @elseif($product->condition == 'fair') bg-warning
              @else bg-secondary
              @endif">
              {{ $product->condition_formatted }}
            </span>
          </div>

          <h1 class="product-title">{{ $product->name }}</h1>
          
          <!-- Descripción -->
          <div class="product-description mb-4">
            <p>{{ $product->description }}</p>
          </div>

          <!-- Información básica -->
          <div class="product-details-grid mb-4">
            <div class="row">
              <div class="col-6">
                <strong>SKU:</strong><br>
                <span class="text-muted">{{ $product->sku }}</span>
              </div>
              <div class="col-6">
                <strong>Categoría:</strong><br>
                <span class="text-muted">{{ $product->category }}</span>
              </div>
            </div>
            
            @if($product->subcategory)
            <div class="row mt-3">
              <div class="col-6">
                <strong>Subcategoría:</strong><br>
                <span class="text-muted">{{ $product->subcategory }}</span>
              </div>
              <div class="col-6">
                <strong>Disponible:</strong><br>
                <span class="text-success fw-bold">{{ $product->stock_quantity }} unidades</span>
              </div>
            </div>
            @endif
          </div>

          <!-- Precios -->
          @if($product->suggested_price)
          <div class="pricing mb-4">
            <div class="price-display text-center">
              <span class="h3 text-primary">{{ $product->formatted_suggested_price }}</span>
              <small class="text-muted d-block">Precio sugerido</small>
            </div>
          </div>
          @endif

          <!-- Tags -->
          @if($product->tags && count($product->tags) > 0)
          <div class="product-tags mb-4">
            <strong>Etiquetas:</strong>
            <div class="tags-list mt-2">
              @foreach($product->tags as $tag)
                <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Acciones -->
          <div class="product-actions">
            <a href="#contact" class="btn btn-primary btn-lg">
              <i class="bi bi-telephone"></i> Consultar Disponibilidad
            </a>
            <a href="{{ route('products.public.index') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Volver a Productos
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Pestañas de información adicional -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="product-tabs" data-aos="fade-up" data-aos-delay="400">
          <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                <i class="bi bi-gear"></i> Especificaciones
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="physical-tab" data-bs-toggle="tab" data-bs-target="#physical" type="button" role="tab">
                <i class="bi bi-rulers"></i> Dimensiones
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions" type="button" role="tab">
                <i class="bi bi-book"></i> Instrucciones
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="ngo-tab" data-bs-toggle="tab" data-bs-target="#ngo" type="button" role="tab">
                <i class="bi bi-info-circle"></i> Información ONG
              </button>
            </li>
          </ul>

          <div class="tab-content" id="productTabsContent">
            <!-- Especificaciones -->
            <div class="tab-pane fade show active" id="specs" role="tabpanel">
              <div class="tab-content-body">
                @if($product->specifications && count($product->specifications) > 0)
                  <div class="row">
                    @foreach($product->specifications as $key => $value)
                    <div class="col-md-6 mb-2">
                      <strong>{{ $key }}:</strong> {{ $value }}
                    </div>
                    @endforeach
                  </div>
                @else
                  <p class="text-muted">No hay especificaciones disponibles.</p>
                @endif
              </div>
            </div>

            <!-- Dimensiones -->
            <div class="tab-pane fade" id="physical" role="tabpanel">
              <div class="tab-content-body">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Peso:</strong><br>
                    <span class="text-muted">{{ $product->formatted_weight }}</span>
                  </div>
                  <div class="col-md-3">
                    <strong>Dimensiones:</strong><br>
                    <span class="text-muted">{{ $product->formatted_dimensions }}</span>
                  </div>
                  <div class="col-md-3">
                    <strong>Requiere Envío:</strong><br>
                    <span class="text-muted">{{ $product->requires_shipping ? 'Sí' : 'No' }}</span>
                  </div>
                  <div class="col-md-3">
                    <strong>Tipo:</strong><br>
                    <span class="text-muted">{{ $product->is_digital ? 'Digital' : 'Físico' }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Instrucciones -->
            <div class="tab-pane fade" id="instructions" role="tabpanel">
              <div class="tab-content-body">
                @if($product->usage_instructions)
                <div class="mb-3">
                  <h6>Instrucciones de Uso</h6>
                  <p class="text-muted">{{ $product->usage_instructions }}</p>
                </div>
                @endif

                @if($product->care_instructions)
                <div class="mb-3">
                  <h6>Instrucciones de Cuidado</h6>
                  <p class="text-muted">{{ $product->care_instructions }}</p>
                </div>
                @endif

                @if(!$product->usage_instructions && !$product->care_instructions)
                <p class="text-muted">No hay instrucciones disponibles.</p>
                @endif
              </div>
            </div>

            <!-- Información ONG -->
            <div class="tab-pane fade" id="ngo" role="tabpanel">
              <div class="tab-content-body">
                <div class="row">
                  @if($product->donation_source)
                  <div class="col-md-6 mb-3">
                    <strong>Fuente de Donación:</strong><br>
                    <span class="text-muted">{{ $product->donation_source }}</span>
                  </div>
                  @endif
                  @if($product->received_date)
                  <div class="col-md-6 mb-3">
                    <strong>Fecha de Recepción:</strong><br>
                    <span class="text-muted">{{ $product->received_date->format('d/m/Y') }}</span>
                  </div>
                  @endif
                </div>

                @if($product->ngo_notes)
                <div class="mb-3">
                  <strong>Notas Internas:</strong><br>
                  <p class="text-muted">{{ $product->ngo_notes }}</p>
                </div>
                @endif

                <div class="row">
                  <div class="col-md-6">
                    <strong>Creado por:</strong><br>
                    <span class="text-muted">{{ $product->creator->name ?? 'N/A' }}</span>
                  </div>
                  <div class="col-md-6">
                    <strong>Última actualización:</strong><br>
                    <span class="text-muted">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section id="cta" class="cta">
  <div class="container" data-aos="zoom-in">
    <div class="row">
      <div class="col-lg-9 text-center text-lg-start">
        <h3>¿Interesado en este producto?</h3>
        <p>Contacta con nosotros para conocer la disponibilidad y coordinar la entrega de este producto.</p>
      </div>
      <div class="col-lg-3 cta-btn-container text-center">
      <a class="cta-btn align-middle" href="{{ route('contact') }}">Contactar</a>
      </div>
    </div>
  </div>
</section>

<script>
function changeMainImage(imageUrl) {
  document.getElementById('mainImage').src = imageUrl;
}
</script>

<style>
.product-details {
  padding: 60px 0;
}

.breadcrumbs {
  padding: 0px ;
  background: #f8f9fa;
}

.breadcrumbs h2 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #333;
}

.product-gallery .main-image {
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.gallery-thumbnails {
  margin-top: 20px;
}

.gallery-thumb {
  cursor: pointer;
  transition: all 0.3s ease;
}

.gallery-thumb:hover {
  transform: scale(1.05);
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

.product-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 20px;
}

.product-title {
  font-size: 2rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 20px;
}

.product-description p {
  font-size: 1.1rem;
  line-height: 1.6;
  color: #666;
}

.product-details-grid {
  padding: 20px;
  background: #f8f9fa;
  border-radius: 10px;
}

.product-tabs {
  margin-top: 40px;
}

.nav-tabs {
  border-bottom: 2px solid #dee2e6;
}

.nav-tabs .nav-link {
  border: none;
  color: #666;
  font-weight: 500;
  padding: 15px 20px;
  margin-right: 10px;
  border-radius: 10px 10px 0 0;
}

.nav-tabs .nav-link.active {
  background: #007bff;
  color: #fff;
  border: none;
}

.tab-content-body {
  padding: 30px;
  background: #fff;
  border-radius: 0 0 10px 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.product-actions {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  margin-top: 30px;
}

@media (max-width: 768px) {
  .product-actions {
    flex-direction: column;
  }
  
  .product-actions .btn {
    width: 100%;
  }
}
</style>

</main>
<x-footer />