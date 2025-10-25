@extends('layouts.tabler')

@section('page-title', 'Gestión de Productos')
@section('page-description', 'Administrar productos del sistema')

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
                    <div class="row row-deck row-cards">
                        @forelse($products as $product)
                        <div class="col-md-4 col-lg-4 col-xl-4">
                            <div class="card card-sm border-{{ $loop->index % 6 == 0 ? 'primary' : ($loop->index % 6 == 1 ? 'success' : ($loop->index % 6 == 2 ? 'info' : ($loop->index % 6 == 3 ? 'warning' : ($loop->index % 6 == 4 ? 'danger' : 'secondary')))) }}">
                                <div class="position-relative">
                                    <img src="{{ $product->main_image_url }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->name }}"
                                         style="height: 180px; object-fit: cover;">
                                    
                                    <!-- Badges -->
                                    <div class="position-absolute top-0 start-0 p-2">
                                        @if($product->is_featured)
                                            <span class="badge bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                </svg>
                                                Destacado
                                            </span>
                                        @endif
                                        @if($product->is_digital)
                                            <span class="badge bg-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                                </svg>
                                                Digital
                                            </span>
                                        @endif
                                    </div>
                                    

                                    <!-- Indicador de categoría con color -->
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2">
                                        <span class="badge bg-{{ $loop->index % 6 == 0 ? 'primary' : ($loop->index % 6 == 1 ? 'success' : ($loop->index % 6 == 2 ? 'info' : ($loop->index % 6 == 3 ? 'warning' : ($loop->index % 6 == 4 ? 'danger' : 'secondary')))) }}">
                                            {{ $product->category }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column p-3">
                                    <!-- Título del producto -->
                                    <h3 class="card-title mb-2">{{ $product->name }}</h3>
                                    
                                    <!-- Descripción -->
                                    <p class="text-muted mb-3 description-text">
                                        {{ Str::limit($product->short_description ?? $product->description, 80) }}
                                    </p>
                                    
                                </div>

                                <div class="card-footer bg-transparent p-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                                Ver
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            @can('update', $product)
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                    <path d="M16 5l3 3"/>
                                                </svg>
                                                Editar
                                            </a>
                                            @else
                                            <button class="btn btn-outline-secondary w-100" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                    <path d="M16 5l3 3"/>
                                                </svg>
                                                Editar
                                            </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 3h10l4 7l-10 13h-4l-10 -13z"/>
                                        <path d="M12 3v18"/>
                                        <path d="M7 8l5 5l5 -5"/>
                                    </svg>
                                </div>
                                <p class="empty-title">No se encontraron productos</p>
                                <p class="empty-subtitle text-muted">
                                    Intenta ajustar los filtros de búsqueda o crear un nuevo producto.
                                </p>
                                @can('create', App\Models\Product::class)
                                <div class="empty-action">
                                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 5l0 14"/>
                                            <path d="M5 12l14 0"/>
                                        </svg>
                                        Crear Primer Producto
                                    </a>
                                </div>
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
/* Estilos con colores de Tabler */
.card {
    transition: box-shadow 0.15s ease-in-out, transform 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

/* Bordes de colores más prominentes */
.border-primary {
    border-color: var(--tblr-primary) !important;
    border-width: 2px !important;
}

.border-success {
    border-color: var(--tblr-success) !important;
    border-width: 2px !important;
}

.border-info {
    border-color: var(--tblr-info) !important;
    border-width: 2px !important;
}

.border-warning {
    border-color: var(--tblr-warning) !important;
    border-width: 2px !important;
}

.border-danger {
    border-color: var(--tblr-danger) !important;
    border-width: 2px !important;
}

.border-secondary {
    border-color: var(--tblr-secondary) !important;
    border-width: 2px !important;
}

/* Efectos hover específicos por color */
.border-primary:hover {
    box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.25);
}

.border-success:hover {
    box-shadow: 0 0.5rem 1rem rgba(25, 135, 84, 0.25);
}

.border-info:hover {
    box-shadow: 0 0.5rem 1rem rgba(13, 202, 240, 0.25);
}

.border-warning:hover {
    box-shadow: 0 0.5rem 1rem rgba(255, 193, 7, 0.25);
}

.border-danger:hover {
    box-shadow: 0 0.5rem 1rem rgba(220, 53, 69, 0.25);
}

.border-secondary:hover {
    box-shadow: 0 0.5rem 1rem rgba(108, 117, 125, 0.25);
}

/* Mejoras para el estado vacío */
.empty {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-icon {
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    margin-bottom: 1.5rem;
}

.empty-action {
    margin-top: 1rem;
}

/* Mejoras para tarjetas más cuadradas */
.card-sm {
    height: 380px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Estilo para la descripción */
.description-text {
    color: #000 !important;
}

.card-sm .card-img-top {
    height: 180px;
    object-fit: cover;
    flex-shrink: 0;
}

.card-sm .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 0.75rem;
    min-height: 0;
}

.card-sm .card-title {
    font-size: 0.9rem;
    line-height: 1.2;
    margin-bottom: 0.5rem;
    flex-shrink: 0;
}

.card-sm .text-muted {
    font-size: 0.75rem;
    line-height: 1.2;
    margin-bottom: 0.5rem;
    flex: 1;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.card-sm .card-footer {
    padding: 0.5rem 0.75rem;
    flex-shrink: 0;
    margin-top: auto;
}

.card-sm .btn {
    font-size: 0.75rem;
    padding: 0.35rem 0.5rem;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .card-sm {
        height: auto;
    }
    
    .card-sm .card-body {
        padding: 0.75rem !important;
    }
    
    .card-sm .card-footer {
        padding: 0.75rem !important;
    }
}

@media (max-width: 576px) {
    .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}
</style>
@endsection
