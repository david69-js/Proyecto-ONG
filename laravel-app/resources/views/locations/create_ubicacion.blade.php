<x-head-admin />

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Nueva Ubicación</h2>
        <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Datos de la Ubicación</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ubicaciones.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del lugar</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="pais" class="form-label">País</label>
                        <input type="text" name="pais" id="pais" class="form-control">
                    </div>
                </div>

                <!-- Campos ocultos para lat/lng -->
                <input type="hidden" id="latitud" name="latitud">
                <input type="hidden" id="longitud" name="longitud">

                <label class="form-label fw-bold">Ubicación en el mapa</label>
                <div id="map" class="mb-3" style="height: 400px; border:1px solid #ccc; border-radius:6px;"></div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Guardar Ubicación
                </button>
                <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([14.6349, -90.5069], 13); // Guatemala por defecto
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker;
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        if (marker) { map.removeLayer(marker); }
        marker = L.marker([lat, lng]).addTo(map);

        document.getElementById("latitud").value = lat;
        document.getElementById("longitud").value = lng;
    });
</script>

<x-footer-admin />
