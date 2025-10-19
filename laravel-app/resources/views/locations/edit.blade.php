@extends('layouts.tabler')

@section('title', 'Editar Ubicación')
@section('page-title', 'Editar Ubicación')
@section('page-description', 'Modifica los datos de la ubicación seleccionada')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Editar Ubicación: {{ $location->nombre }}
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="location-form" action="{{ route('locations.update', $location->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nombre de la ubicación</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $location->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" 
                                           value="{{ old('direccion', $location->direccion) }}">
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ciudad / Departamento</label>
                                    <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" 
                                           value="{{ old('ciudad', $location->ciudad) }}">
                                    @error('ciudad')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">País</label>
                                    <input type="text" name="pais" class="form-control @error('pais') is-invalid @enderror" 
                                           value="{{ old('pais', $location->pais) }}">
                                    @error('pais')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Latitud</label>
                                    <input type="text" id="latitud" name="latitud" class="form-control @error('latitud') is-invalid @enderror" 
                                           value="{{ old('latitud', $location->latitud) }}" required>
                                    @error('latitud')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Longitud</label>
                                    <input type="text" id="longitud" name="longitud" class="form-control @error('longitud') is-invalid @enderror" 
                                           value="{{ old('longitud', $location->longitud) }}" required>
                                    @error('longitud')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" 
                                           value="{{ old('telefono', $location->telefono) }}">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $location->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción / Notas</label>
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                                      rows="3">{{ old('descripcion', $location->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="hr-text">Ubicación en el Mapa</div>

                        <div class="mb-3">
                            <label class="form-label">Selecciona la ubicación en el mapa</label>
                            <div class="card">
                                <div class="card-body p-0">
                                    <div id="map" style="height: 400px; border-radius: 6px;"></div>
                                </div>
                            </div>
                            <div class="form-text">Haz clic en el mapa para actualizar la ubicación</div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-times me-1"></i>
                            Cancelar
                        </a>
                        <button type="submit" form="location-form" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>
                            Actualizar Ubicación
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Coordenadas actuales de la ubicación
        var lat = {{ $location->latitud }};
        var lng = {{ $location->longitud }};

        // Inicializar el mapa con la ubicación actual
        var map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            attribution: '© OpenStreetMap contributors' 
        }).addTo(map);

        var marker = L.marker([lat, lng]).addTo(map);

        function updateMarker(lat, lng) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 14);
        }

        // Evento de clic en el mapa
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lng;
            updateMarker(lat, lng);
        });

        // Eventos de cambio en los campos de coordenadas
        document.getElementById('latitud').addEventListener('input', function() {
            let lat = parseFloat(this.value);
            let lng = parseFloat(document.getElementById('longitud').value);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                updateMarker(lat, lng);
            }
        });

        document.getElementById('longitud').addEventListener('input', function() {
            let lat = parseFloat(document.getElementById('latitud').value);
            let lng = parseFloat(this.value);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                updateMarker(lat, lng);
            }
        });

        // Validación del formulario
        document.getElementById('location-form').addEventListener('submit', function(e) {
            var lat = parseFloat(document.getElementById('latitud').value);
            var lng = parseFloat(document.getElementById('longitud').value);
            
            if (isNaN(lat) || isNaN(lng)) {
                e.preventDefault();
                alert('Por favor, selecciona una ubicación en el mapa o ingresa coordenadas válidas.');
                return false;
            }
            
            if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                e.preventDefault();
                alert('Las coordenadas ingresadas no son válidas.');
                return false;
            }
        });
    });
</script>
@endpush
@endsection
