<<<<<<< HEAD
@extends('layouts.tabler')

@section('title', 'Crear Producto')
@section('page-title', 'Crear Nuevo Producto')
@section('page-description', 'Registrar un nuevo producto en el catálogo')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus text-primary me-2"></i>
                    Crear Nuevo Producto
                </h3>
            </div>
=======
@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus text-primary"></i>
                        Crear Nuevo Producto
                    </h3>
                </div>
>>>>>>> e01843ec9f377deb58012498fa849d92f4995205

                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Información Básica -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-info-circle"></i> Información Básica
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del Producto *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Descripción Corta</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              id="short_description" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Categoría *</label>
                                            <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                                   id="category" name="category" value="{{ old('category') }}" required>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="subcategory" class="form-label">Subcategoría</label>
                                            <input type="text" class="form-control @error('subcategory') is-invalid @enderror" 
                                                   id="subcategory" name="subcategory" value="{{ old('subcategory') }}">
                                            @error('subcategory')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Etiquetas</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                           id="tags" name="tags" value="{{ old('tags') }}"
                                           placeholder="Separadas por comas (ej: donación, ropa, niños)">
                                    <div class="form-text">Separa las etiquetas con comas</div>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Inventario y Precios -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-warehouse"></i> Inventario y Precios
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock_quantity" class="form-label">Cantidad en Stock</label>
                                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0">
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock_status" class="form-label">Estado del Stock *</label>
                                            <select class="form-select @error('stock_status') is-invalid @enderror" 
                                                    id="stock_status" name="stock_status" required>
                                                <option value="">Seleccionar estado</option>
                                                <option value="in_stock" {{ old('stock_status') == 'in_stock' ? 'selected' : '' }}>En Stock</option>
                                                <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Agotado</option>
                                                <option value="low_stock" {{ old('stock_status') == 'low_stock' ? 'selected' : '' }}>Stock Bajo</option>
                                                <option value="discontinued" {{ old('stock_status') == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
                                            </select>
                                            @error('stock_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="manage_stock" name="manage_stock" 
                                               value="1" {{ old('manage_stock') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="manage_stock">
                                            Gestionar stock automáticamente
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cost_price" class="form-label">Precio de Costo</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('cost_price') is-invalid @enderror" 
                                                       id="cost_price" name="cost_price" value="{{ old('cost_price') }}">
                                                <select class="form-select" id="currency" name="currency">
                                                    <option value="GTQ" {{ old('currency', 'GTQ') == 'GTQ' ? 'selected' : '' }}>GTQ</option>
                                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                    <option value="MXN" {{ old('currency') == 'MXN' ? 'selected' : '' }}>MXN</option>
                                                </select>
                                            </div>
                                            @error('cost_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="suggested_price" class="form-label">Precio Sugerido</label>
                                            <input type="number" step="0.01" min="0" 
                                                   class="form-control @error('suggested_price') is-invalid @enderror" 
                                                   id="suggested_price" name="suggested_price" value="{{ old('suggested_price') }}">
                                            @error('suggested_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Características Físicas -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-ruler"></i> Características Físicas
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="weight" class="form-label">Peso (kg)</label>
                                            <input type="number" step="0.01" min="0" 
                                                   class="form-control @error('weight') is-invalid @enderror" 
                                                   id="weight" name="weight" value="{{ old('weight') }}">
                                            @error('weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="length" class="form-label">Largo (cm)</label>
                                            <input type="number" step="0.01" min="0" 
                                                   class="form-control @error('length') is-invalid @enderror" 
                                                   id="length" name="length" value="{{ old('length') }}">
                                            @error('length')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="width" class="form-label">Ancho (cm)</label>
                                            <input type="number" step="0.01" min="0" 
                                                   class="form-control @error('width') is-invalid @enderror" 
                                                   id="width" name="width" value="{{ old('width') }}">
                                            @error('width')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="height" class="form-label">Alto (cm)</label>
                                            <input type="number" step="0.01" min="0" 
                                                   class="form-control @error('height') is-invalid @enderror" 
                                                   id="height" name="height" value="{{ old('height') }}">
                                            @error('height')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_digital" name="is_digital" 
                                               value="1" {{ old('is_digital') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_digital">
                                            Producto digital
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="requires_shipping" name="requires_shipping" 
                                               value="1" {{ old('requires_shipping', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_shipping">
                                            Requiere envío
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado y Configuración -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-cog"></i> Estado y Configuración
                                </h5>

                                <div class="mb-3">
                                    <label for="condition" class="form-label">Condición *</label>
                                    <select class="form-select @error('condition') is-invalid @enderror" 
                                            id="condition" name="condition" required>
                                        <option value="">Seleccionar condición</option>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Nuevo</option>
                                        <option value="like_new" {{ old('condition') == 'like_new' ? 'selected' : '' }}>Como Nuevo</option>
                                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Bueno</option>
                                        <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Regular</option>
                                        <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Malo</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Producto activo
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                               value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Producto destacado
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Imágenes -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-images"></i> Imágenes
                                </h5>

                                <div class="mb-3">
                                    <label for="main_image" class="form-label">Imagen Principal</label>
                                    <input type="file" class="form-control @error('main_image') is-invalid @enderror" 
                                           id="main_image" name="main_image" accept="image/*">
                                    <div class="form-text">Formatos: JPG, PNG, GIF (máx. 2MB)</div>
                                    @error('main_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gallery_images" class="form-label">Galería de Imágenes</label>
                                    <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" 
                                           id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                                    <div class="form-text">Puedes seleccionar múltiples imágenes</div>
                                    @error('gallery_images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información ONG -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-info-circle"></i> Información ONG
                                </h5>

                                <div class="mb-3">
                                    <label for="donation_source" class="form-label">Fuente de Donación</label>
                                    <input type="text" class="form-control @error('donation_source') is-invalid @enderror" 
                                           id="donation_source" name="donation_source" value="{{ old('donation_source') }}">
                                    @error('donation_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="received_date" class="form-label">Fecha de Recepción</label>
                                    <input type="date" class="form-control @error('received_date') is-invalid @enderror" 
                                           id="received_date" name="received_date" value="{{ old('received_date') }}">
                                    @error('received_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ngo_notes" class="form-label">Notas Internas</label>
                                    <textarea class="form-control @error('ngo_notes') is-invalid @enderror" 
                                              id="ngo_notes" name="ngo_notes" rows="3">{{ old('ngo_notes') }}</textarea>
                                    @error('ngo_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Instrucciones y Especificaciones -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-book"></i> Instrucciones
                                </h5>

                                <div class="mb-3">
                                    <label for="usage_instructions" class="form-label">Instrucciones de Uso</label>
                                    <textarea class="form-control @error('usage_instructions') is-invalid @enderror" 
                                              id="usage_instructions" name="usage_instructions" rows="3">{{ old('usage_instructions') }}</textarea>
                                    @error('usage_instructions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="care_instructions" class="form-label">Instrucciones de Cuidado</label>
                                    <textarea class="form-control @error('care_instructions') is-invalid @enderror" 
                                              id="care_instructions" name="care_instructions" rows="3">{{ old('care_instructions') }}</textarea>
                                    @error('care_instructions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-list"></i> Especificaciones
                                </h5>

                                <div class="mb-3">
                                    <label for="specifications" class="form-label">Especificaciones Técnicas</label>
                                    <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                              id="specifications" name="specifications" rows="6" 
                                              placeholder="Formato: Clave: Valor (una por línea)&#10;Ejemplo:&#10;Material: Algodón&#10;Talla: M&#10;Color: Azul">{{ old('specifications') }}</textarea>
                                    <div class="form-text">Una especificación por línea, formato: Clave: Valor</div>
                                    @error('specifications')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Crear Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
