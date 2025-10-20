<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', $product->name)
@section('page-title', 'Detalles del Producto')
@section('page-description', 'Información completa del producto: ' . $product->name)

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
=======
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-box text-primary"></i>
                            {{ $product->name }}
                        </h3>
                        <div class="d-flex gap-2">
                            @can('update', $product)
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            @endcan
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Imágenes del producto -->
                        <div class="col-md-6">
                            <div class="product-images">
                                <!-- Imagen principal -->
                                <div class="main-image mb-3">
                                    <img src="{{ $product->main_image_url }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $product->name }}"
                                         style="max-height: 400px; width: 100%; object-fit: cover;">
                                </div>

                                <!-- Galería de imágenes -->
                                @if($product->gallery_images && count($product->gallery_images) > 0)
                                <div class="gallery-images">
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
                        <div class="col-md-6">
                            <div class="product-info">
                                <!-- Badges de estado -->
                                <div class="mb-3">
                                    @if($product->is_featured)
                                        <span class="badge bg-warning me-1">Destacado</span>
                                    @endif
                                    @if($product->is_digital)
                                        <span class="badge bg-info me-1">Digital</span>
                                    @endif
                                    <span class="badge 
                                        @if($product->stock_status == 'in_stock') bg-success
                                        @elseif($product->stock_status == 'out_of_stock') bg-danger
                                        @elseif($product->stock_status == 'low_stock') bg-warning
                                        @else bg-secondary
                                        @endif">
                                        {{ $product->stock_status_formatted }}
                                    </span>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-4">
                                    <h6>Descripción</h6>
                                    <p class="text-muted">{{ $product->description }}</p>
                                </div>

                                <!-- Información básica -->
                                <div class="row mb-4">
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
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <strong>Subcategoría:</strong><br>
                                        <span class="text-muted">{{ $product->subcategory }}</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Condición:</strong><br>
                                        <span class="text-muted">{{ $product->condition_formatted }}</span>
                                    </div>
                                </div>
                                @endif

                                <!-- Precios -->
                                @if($product->suggested_price || $product->cost_price)
                                <div class="row mb-4">
                                    @if($product->suggested_price)
                                    <div class="col-6">
                                        <strong>Precio Sugerido:</strong><br>
                                        <span class="h5 text-primary">{{ $product->formatted_suggested_price }}</span>
                                    </div>
                                    @endif
                                    @if($product->cost_price)
                                    <div class="col-6">
                                        <strong>Precio de Costo:</strong><br>
                                        <span class="text-muted">{{ $product->formatted_cost_price }}</span>
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Stock -->
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <strong>Stock Disponible:</strong><br>
                                        <span class="text-muted">{{ $product->stock_quantity }} unidades</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Gestiona Stock:</strong><br>
                                        <span class="text-muted">{{ $product->manage_stock ? 'Sí' : 'No' }}</span>
                                    </div>
                                </div>

                                <!-- Tags -->
                                @if($product->tags && count($product->tags) > 0)
                                <div class="mb-4">
                                    <strong>Etiquetas:</strong><br>
                                    @foreach($product->tags as $tag)
                                        <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Pestañas de información adicional -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                                        <i class="fas fa-cogs"></i> Especificaciones
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="physical-tab" data-bs-toggle="tab" data-bs-target="#physical" type="button" role="tab">
                                        <i class="fas fa-ruler"></i> Dimensiones
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions" type="button" role="tab">
                                        <i class="fas fa-book"></i> Instrucciones
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="ngo-tab" data-bs-toggle="tab" data-bs-target="#ngo" type="button" role="tab">
                                        <i class="fas fa-info-circle"></i> Información ONG
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="productTabsContent">
                                <!-- Especificaciones -->
                                <div class="tab-pane fade show active" id="specs" role="tabpanel">
                                    <div class="p-3">
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
                                    <div class="p-3">
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
                                    <div class="p-3">
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
                                    <div class="p-3">
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
        </div>
    </div>
</div>

<script>
function changeMainImage(imageUrl) {
    document.querySelector('.main-image img').src = imageUrl;
}
</script>
@endsection
