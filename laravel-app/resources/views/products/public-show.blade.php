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
/* ===== ESTILOS ESPECÍFICOS PARA PÁGINA DE PRODUCTOS ===== */

/* Layout principal */
.product-details {
  padding: 40px 0;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  min-height: 100vh;
}

/* Breadcrumbs con personalidad propia */
.breadcrumbs {
  padding: 25px 0;
  background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
  color: white;
  margin-bottom: 0;
  position: relative;
  overflow: hidden;
}

.breadcrumbs::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.08)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.08)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.04)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.04)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.04)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
  opacity: 0.4;
}

.breadcrumbs h2 {
  font-size: 1.8rem;
  font-weight: 700;
  color: white;
  margin: 0;
  position: relative;
  z-index: 2;
}

.breadcrumbs ol {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  gap: 10px;
  position: relative;
  z-index: 2;
}

.breadcrumbs ol li {
  color: rgba(255, 255, 255, 0.9);
}

.breadcrumbs ol li:not(:last-child)::after {
  content: "›";
  margin-left: 10px;
  color: rgba(255, 255, 255, 0.7);
}

.breadcrumbs ol li a {
  color: rgba(255, 255, 255, 0.95);
  text-decoration: none;
  transition: all 0.3s ease;
  padding: 5px 10px;
  border-radius: 15px;
}

.breadcrumbs ol li a:hover {
  color: white;
  background: rgba(255, 255, 255, 0.1);
}

/* Galería de productos */
.product-gallery .main-image {
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(16, 42, 73, 0.15);
  transition: transform 0.3s ease;
}

.product-gallery .main-image:hover {
  transform: scale(1.02);
}

.gallery-thumbnails {
  margin-top: 25px;
}

.gallery-thumbnails h6 {
  color: #495057;
  font-weight: 600;
  margin-bottom: 15px;
  font-size: 1rem;
}

.gallery-thumb {
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  border-radius: 8px;
  overflow: hidden;
}

.gallery-thumb:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(73, 80, 87, 0.2);
  border-color: #495057;
}

/* Información del producto */
.product-info {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(16, 42, 73, 0.1);
  height: fit-content;
}

.product-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 25px;
}

.product-badges .badge {
  font-size: 0.85rem;
  padding: 8px 12px;
  border-radius: 20px;
  font-weight: 600;
}

.product-title {
  font-size: 2.2rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 25px;
  line-height: 1.3;
}

.product-description p {
  font-size: 1.1rem;
  line-height: 1.7;
  color: #555;
  margin-bottom: 0;
}

.product-details-grid {
  padding: 25px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 12px;
  border-left: 4px solid #495057;
  margin: 25px 0;
  position: relative;
}

.product-details-grid::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, #495057, #6c757d);
  border-radius: 0 12px 0 12px;
  opacity: 0.1;
}

.product-details-grid strong {
  color: #495057;
  font-weight: 600;
}

.product-details-grid .text-muted {
  color: #666 !important;
}

.product-details-grid .text-success {
  color: #28a745 !important;
  font-weight: 600;
}

/* Precios */
.pricing {
  background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
  color: white;
  padding: 25px;
  border-radius: 12px;
  text-align: center;
  margin: 25px 0;
  position: relative;
  overflow: hidden;
}

.pricing::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

.price-display .h3 {
  color: white;
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 5px;
}

.price-display small {
  color: rgba(255, 255, 255, 0.8);
  font-size: 1rem;
}

/* Tags */
.product-tags {
  margin: 25px 0;
}

.product-tags strong {
  color: #2c3e50;
  font-weight: 600;
  margin-bottom: 10px;
  display: block;
}

.tags-list .badge {
  background: linear-gradient(135deg, #495057, #6c757d);
  color: white;
  border: none;
  font-size: 0.85rem;
  padding: 6px 12px;
  margin: 2px;
  border-radius: 15px;
  font-weight: 500;
}

/* Pestañas mejoradas */
.product-tabs {
  margin-top: 50px;
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(16, 42, 73, 0.1);
}

.nav-tabs {
  border-bottom: none;
  background: #f8f9fa;
  padding: 0;
  margin: 0;
}

.nav-tabs .nav-link {
  border: none;
  color: #666;
  font-weight: 600;
  padding: 20px 25px;
  margin: 0;
  border-radius: 0;
  transition: all 0.3s ease;
  background: transparent;
}

.nav-tabs .nav-link:hover {
  background: #e9ecef;
  color: #495057;
}

.nav-tabs .nav-link.active {
  background: linear-gradient(135deg, #495057, #6c757d);
  color: white;
  border: none;
}

.nav-tabs .nav-link i {
  margin-right: 8px;
  font-size: 1.1rem;
}

.tab-content-body {
  padding: 40px;
  background: white;
  border-radius: 0;
  box-shadow: none;
}

.tab-content-body h6 {
  color: #495057;
  font-weight: 600;
  margin-bottom: 15px;
}

.tab-content-body strong {
  color: #495057;
  font-weight: 600;
}

/* Acciones del producto */
.product-actions {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  margin-top: 35px;
  padding-top: 25px;
  border-top: 2px solid #f8f9fa;
}

.product-actions .btn {
  border-radius: 25px;
  padding: 12px 30px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.product-actions .btn-primary {
  background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
  border: none;
  color: white;
}

.product-actions .btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(73, 80, 87, 0.3);
  background: linear-gradient(135deg, #343a40 0%, #495057 100%);
}

.product-actions .btn-outline-secondary {
  border: 2px solid #495057;
  color: #495057;
  background: transparent;
}

.product-actions .btn-outline-secondary:hover {
  background: #495057;
  border-color: #495057;
  color: white;
  transform: translateY(-2px);
}

/* Call to Action */
.cta {
  background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
  color: white;
  padding: 60px 0;
  margin-top: 50px;
  position: relative;
  overflow: hidden;
}

.cta::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
  opacity: 0.3;
}

.cta h3 {
  color: white;
  font-weight: 700;
  margin-bottom: 15px;
  position: relative;
  z-index: 2;
}

.cta p {
  color: rgba(255, 255, 255, 0.9);
  font-size: 1.1rem;
  margin-bottom: 0;
  position: relative;
  z-index: 2;
}

.cta-btn {
  background: linear-gradient(135deg, #495057, #6c757d);
  color: white;
  padding: 15px 35px;
  border-radius: 25px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
  display: inline-block;
  position: relative;
  z-index: 2;
  border: none;
}

.cta-btn:hover {
  background: linear-gradient(135deg, #343a40, #495057);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(73, 80, 87, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
  .product-details {
    padding: 20px 0;
  }
  
  .product-info {
    padding: 20px;
    margin-top: 20px;
  }
  
  .product-title {
    font-size: 1.8rem;
  }
  
  .product-actions {
    flex-direction: column;
  }
  
  .product-actions .btn {
    width: 100%;
    text-align: center;
  }
  
  .tab-content-body {
    padding: 25px;
  }
  
  .nav-tabs .nav-link {
    padding: 15px 20px;
    font-size: 0.9rem;
  }
}

@media (max-width: 576px) {
  .breadcrumbs h2 {
    font-size: 1.5rem;
  }
  
  .product-title {
    font-size: 1.6rem;
  }
  
  .price-display .h3 {
    font-size: 2rem;
  }
}
</style>

</main>
<x-footer />