@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-box text-primary"></i>
                            Gestión de Productos
                        </h3>
                        @can('create', App\Models\Product::class)
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nuevo Producto
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
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
                                    <select class="form-select" name="stock_status">
                                        <option value="">Todos los estados</option>
                                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>En Stock</option>
                                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Agotado</option>
                                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stock Bajo</option>
                                        <option value="discontinued" {{ request('stock_status') == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
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
                                    <select class="form-select" name="is_active">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Activos</option>
                                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactivos</option>
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
                                         style="height: 200px; object-fit: cover;">
                                    
                                    <!-- Badges -->
                                    <div class="position-absolute top-0 start-0 p-2">
                                        @if($product->is_featured)
                                            <span class="badge bg-warning">Destacado</span>
                                        @endif
                                        @if($product->is_digital)
                                            <span class="badge bg-info">Digital</span>
                                        @endif
                                    </div>
                                    
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge 
                                            @if($product->stock_status == 'in_stock') bg-success
                                            @elseif($product->stock_status == 'out_of_stock') bg-danger
                                            @elseif($product->stock_status == 'low_stock') bg-warning
                                            @else bg-secondary
                                            @endif">
                                            {{ $product->stock_status_formatted }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($product->short_description ?? $product->description, 100) }}
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="row text-center mb-2">
                                            <div class="col-6">
                                                <small class="text-muted">Categoría</small>
                                                <div class="fw-bold">{{ $product->category }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Condición</small>
                                                <div class="fw-bold">{{ $product->condition_formatted }}</div>
                                            </div>
                                        </div>
                                        
                                        @if($product->suggested_price)
                                        <div class="text-center mb-2">
                                            <span class="h5 text-primary">{{ $product->formatted_suggested_price }}</span>
                                        </div>
                                        @endif
                                        
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">
                                                SKU: {{ $product->sku }}
                                            </small>
                                            <small class="text-muted">
                                                Stock: {{ $product->stock_quantity }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        @can('update', $product)
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        @endcan
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
                                @can('create', App\Models\Product::class)
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Crear Primer Producto
                                </a>
                                @endcan
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
    transition: transform 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
