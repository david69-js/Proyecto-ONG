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
            <a href="{{ route('products.public.index') }}" class="btn btn-outline-secondary btn-lg">
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
/* ===== ESTILOS ELEGANTES PARA PÁGINA DE PRODUCTOS ===== */

/* Layout principal */
.product-details {
  padding: 40px 0;
  background: linear-gradient(135deg, #fafbfc 0%, #f1f3f4 100%);
  min-height: 100vh;
}

/* Breadcrumbs elegantes */
.breadcrumbs {
  padding: 30px 0;
  background: linear-gradient(135deg, #102a49 0%, #1a365d 100%);
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
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.06)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.06)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
  opacity: 0.3;
}

.breadcrumbs h2 {
  font-size: 1.8rem;
  font-weight: 600;
  color: white;
  margin: 0;
  position: relative;
  z-index: 2;
  letter-spacing: -0.02em;
}

.breadcrumbs ol {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  gap: 12px;
  position: relative;
  z-index: 2;
}

.breadcrumbs ol li {
  color: rgba(255, 255, 255, 0.85);
  font-size: 0.95rem;
}

.breadcrumbs ol li:not(:last-child)::after {
  content: "›";
  margin-left: 12px;
  color: rgba(255, 255, 255, 0.6);
  font-weight: 300;
}

.breadcrumbs ol li a {
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  transition: all 0.3s ease;
  padding: 6px 12px;
  border-radius: 6px;
  font-weight: 500;
}

.breadcrumbs ol li a:hover {
  color: white;
  background: rgba(255, 255, 255, 0.08);
}

/* Galería de productos */
.product-gallery .main-image {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
  transition: all 0.4s ease;
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.product-gallery .main-image:hover {
  transform: translateY(-5px);
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
}

.gallery-thumbnails {
  margin-top: 30px;
}

.gallery-thumbnails h6 {
  color: #102a49;
  font-weight: 600;
  margin-bottom: 18px;
  font-size: 1rem;
  letter-spacing: -0.01em;
}

.gallery-thumb {
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  border-radius: 6px;
  overflow: hidden;
}

.gallery-thumb:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  border-color: #e2e8f0;
}

/* Información del producto */
.product-info {
  background: white;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
  height: fit-content;
  border: 2px solid #102a49;
}

.product-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 30px;
}

.product-badges .badge {
  font-size: 0.85rem;
  padding: 10px 16px;
  border-radius: 6px;
  font-weight: 500;
  letter-spacing: 0.01em;
}

.product-title {
  font-size: 2.4rem;
  font-weight: 600;
  color: #102a49;
  margin-bottom: 30px;
  line-height: 1.2;
  letter-spacing: -0.02em;
}

.product-description p {
  font-size: 1.1rem;
  line-height: 1.7;
  color: #102a49;
  margin-bottom: 0;
  font-weight: 400;
}

.product-details-grid {
  padding: 30px;
  background: white;
  border-radius: 8px;
  border: 2px solid #102a49;
  margin: 30px 0;
  position: relative;
}

.product-details-grid::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 60px;
  height: 60px;
  background: #102a49;
  border-radius: 0 8px 0 8px;
  opacity: 0.1;
}

.product-details-grid strong {
  color: #102a49;
  font-weight: 600;
  font-size: 0.95rem;
}

.product-details-grid .text-muted {
  color: #102a49 !important;
  font-size: 0.9rem;
  opacity: 0.7;
}

.product-details-grid .text-success {
  color: #38a169 !important;
  font-weight: 600;
}

/* Precios elegantes */
.pricing {
  background: white;
  color: #102a49;
  padding: 35px;
  border-radius: 8px;
  text-align: center;
  margin: 30px 0;
  position: relative;
  overflow: hidden;
  border: 2px solid #102a49;
}

.pricing::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(16, 42, 73, 0.05) 0%, transparent 70%);
  animation: float 8s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-15px) rotate(180deg); }
}

.price-display .h3 {
  color: #102a49;
  font-size: 2.8rem;
  font-weight: 600;
  margin-bottom: 8px;
  letter-spacing: -0.02em;
}

.price-display small {
  color: #102a49;
  font-size: 1rem;
  font-weight: 400;
  opacity: 0.7;
}

/* Tags elegantes */
.product-tags {
  margin: 30px 0;
}

.product-tags strong {
  color: #102a49;
  font-weight: 600;
  margin-bottom: 12px;
  display: block;
  font-size: 1rem;
}

.tags-list .badge {
  background: white;
  color: #102a49;
  border: 2px solid #102a49;
  font-size: 0.85rem;
  padding: 8px 16px;
  margin: 3px;
  border-radius: 6px;
  font-weight: 500;
  letter-spacing: 0.01em;
}

/* Pestañas elegantes */
.product-tabs {
  margin-top: 60px;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
  border: 2px solid #102a49;
}

.nav-tabs {
  border-bottom: 2px solid #102a49;
  background: white;
  padding: 0;
  margin: 0;
}

.nav-tabs .nav-link {
  border: none;
  color: #102a49;
  font-weight: 500;
  padding: 24px 30px;
  margin: 0;
  border-radius: 0;
  transition: all 0.3s ease;
  background: transparent;
  font-size: 0.95rem;
  letter-spacing: -0.01em;
}

.nav-tabs .nav-link:hover {
  background: rgba(16, 42, 73, 0.1);
  color: #102a49;
}

.nav-tabs .nav-link.active {
  background: #102a49;
  color: white;
  border: none;
  font-weight: 600;
}

.nav-tabs .nav-link i {
  margin-right: 10px;
  font-size: 1.1rem;
}

.tab-content-body {
  padding: 45px;
  background: white;
  border-radius: 0;
  box-shadow: none;
}

.tab-content-body h6 {
  color: #102a49;
  font-weight: 600;
  margin-bottom: 18px;
  font-size: 1.1rem;
}

.tab-content-body strong {
  color: #102a49;
  font-weight: 600;
}

/* Acciones del producto */
.product-actions {
  display: flex;
  gap: 18px;
  flex-wrap: wrap;
  margin-top: 40px;
  padding-top: 30px;
  border-top: 2px solid #f1f5f9;
}

.product-actions .btn {
  border-radius: 6px;
  padding: 14px 32px;
  font-weight: 500;
  transition: all 0.3s ease;
  font-size: 1rem;
  letter-spacing: -0.01em;
}

.product-actions .btn-outline-secondary {
  padding: 14px 32px;
  font-size: 1rem;
}

.product-actions .btn-primary {
  background: linear-gradient(135deg, #102a49 0%, #1a365d 100%);
  border: none;
  color: white;
  box-shadow: 0 4px 15px rgba(16, 42, 73, 0.2);
  padding: 14px 32px !important;
  font-size: 1rem !important;
  line-height: 1.5 !important;
  margin: auto !important;
}

.product-actions .btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(16, 42, 73, 0.25);
  background: linear-gradient(135deg, #0a1a2e 0%, #102a49 100%);
}

.product-actions .btn-outline-secondary {
  border: 2px solid #102a49;
  color: #102a49;
  background: transparent;
  font-weight: 500;
  padding: 14px 50px !important;
  font-size: 1rem !important;
  line-height: 1.5 !important;
  margin: auto !important;
}

.product-actions .btn-outline-secondary:hover {
  background: #102a49;
  border-color: #102a49;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(16, 42, 73, 0.2);
}

/* Call to Action elegante */
.cta {
  background: linear-gradient(135deg, #102a49 0%, #1a365d 100%);
  color: white;
  padding: 70px 0;
  margin-top: 60px;
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
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.06)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
  opacity: 0.2;
}

.cta h3 {
  color: white;
  font-weight: 600;
  margin-bottom: 18px;
  position: relative;
  z-index: 2;
  font-size: 2rem;
  letter-spacing: -0.02em;
}

.cta p {
  color: rgba(255, 255, 255, 0.85);
  font-size: 1.1rem;
  margin-bottom: 0;
  position: relative;
  z-index: 2;
  font-weight: 400;
  line-height: 1.6;
}

.cta-btn {
  background: linear-gradient(135deg, #102a49, #1a365d);
  color: white;
  padding: 18px 40px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
  display: inline-block;
  position: relative;
  z-index: 2;
  border: none;
  font-size: 1rem;
  letter-spacing: -0.01em;
  box-shadow: 0 4px 15px rgba(16, 42, 73, 0.2);
}

.cta-btn:hover {
  background: linear-gradient(135deg, #0a1a2e, #102a49);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(16, 42, 73, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
  .product-details {
    padding: 25px 0;
  }
  
  .product-info {
    padding: 25px;
    margin-top: 25px;
  }
  
  .product-title {
    font-size: 2rem;
  }
  
  .product-actions {
    flex-direction: column;
  }
  
  .product-actions .btn {
    width: 100%;
    text-align: center;
  }
  
  .tab-content-body {
    padding: 30px;
  }
  
  .nav-tabs .nav-link {
    padding: 18px 20px;
    font-size: 0.9rem;
  }
  
  .cta {
    padding: 50px 0;
  }
  
  .cta h3 {
    font-size: 1.6rem;
  }
}

@media (max-width: 576px) {
  .breadcrumbs h2 {
    font-size: 1.5rem;
  }
  
  .product-title {
    font-size: 1.7rem;
  }
  
  .price-display .h3 {
    font-size: 2.2rem;
  }
  
  .product-info {
    padding: 20px;
  }
  
  .tab-content-body {
    padding: 25px;
  }
}
</style>

</main>
<x-footer />