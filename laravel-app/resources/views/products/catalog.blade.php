@extends('layouts.tabler')

@section('title', 'Catálogo de Productos')
@section('page-title', 'Catálogo de Productos')
@section('page-description', 'Explorar todos los productos disponibles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-store text-primary me-2"></i>
                        Catálogo de Productos
                    </h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-cog"></i> Administrar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" action="{{ route('products.catalog') }}" class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Buscar productos..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="category">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="condition">
                                        <option value="">Todas las condiciones</option>
                                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Nuevo</option>
                                        <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Como Nuevo</option>
                                        <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Bueno</option>
                                        <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Regular</option>
                                        <option value="poor" {{ request('condition') == 'poor' ? 'selected' : '' }}>Malo</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="featured">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Destacados</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="sort_by">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Más recientes</option>
                                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                                        <option value="suggested_price" {{ request('sort_by') == 'suggested_price' ? 'selected' : '' }}>Precio</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Lista de productos -->
                    <div class="row">
                        @forelse($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 product-card">
                                <div class="position-relative">
                                    <img src="{{ $product->main_image_url }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->name }}"
                                         style="height: 250px; object-fit: cover;">
                                    
                                    <!-- Badges -->
                                    <div class="position-absolute top-0 start-0 p-2">
                                        @if($product->is_featured)
                                            <span class="badge bg-warning">⭐ Destacado</span>
                                        @endif
                                        @if($product->is_digital)
                                            <span class="badge bg-info">💻 Digital</span>
                                        @endif
                                    </div>
                                    
                                    <div class="position-absolute top-0 end-0 p-2">
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
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($product->short_description ?? $product->description, 120) }}
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="row text-center mb-2">
                                            <div class="col-6">
                                                <small class="text-muted">Categoría</small>
                                                <div class="fw-bold">{{ $product->category }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Stock</small>
                                                <div class="fw-bold">{{ $product->stock_quantity }} unidades</div>
                                            </div>
                                        </div>
                                        
                                        @if($product->suggested_price)
                                        <div class="text-center mb-2">
                                            <span class="h5 text-primary">{{ $product->formatted_suggested_price }}</span>
                                            <small class="text-muted d-block">Precio sugerido</small>
                                        </div>
                                        @endif
                                        
                                        @if($product->tags && count($product->tags) > 0)
                                        <div class="mb-2">
                                            @foreach(array_slice($product->tags, 0, 3) as $tag)
                                                <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Ver Detalles
                                        </a>
                                        <small class="text-muted align-self-center">
                                            SKU: {{ $product->sku }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No se encontraron productos</h4>
                                <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Paginación -->
                    @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}

.badge {
    font-size: 0.75em;
}

@media (max-width: 768px) {
    .product-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
