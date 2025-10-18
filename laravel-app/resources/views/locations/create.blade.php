@extends('layouts.app')

@section('content')
<h1 class="mb-4">Crear Ubicación</h1>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<form action="{{ route('locations.store') }}" method="POST" class="card shadow p-4">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nombre de la ubicación</label>
        <input type="text" name="nombre" class="form-control" placeholder="Bodega Central" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" placeholder="Avenida Reforma 5-55, Zona 9">
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Ciudad / Departamento</label>
            <input type="text" name="ciudad" class="form-control" placeholder="Guatemala">
        </div>
        <div class="col">
            <label class="form-label">País</label>
            <input type="text" name="pais" class="form-control" placeholder="Guatemala">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Latitud</label>
            <input type="text" id="latitud" name="latitud" class="form-control" required>
        </div>
        <div class="col">
            <label class="form-label">Longitud</label>
            <input type="text" id="longitud" name="longitud" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" placeholder="+502 0000 0000">
        </div>
        <div class="col">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" placeholder="nombre@empresa.com">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción / Notas</label>
        <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalles adicionales sobre la ubicación..."></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Selecciona en el mapa</label>
        <div id="map" style="height: 350px; border:1px solid #ccc; border-radius: 6px;"></div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success me-2">Guardar</button>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([14.6349, -90.5069], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

    var marker = L.marker([14.6349, -90.5069]).addTo(map);

    function updateMarker(lat, lng) {
        if(marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 14);
    }

    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        updateMarker(lat, lng);
    });

    document.getElementById('latitud').addEventListener('input', function() {
        let lat = parseFloat(this.value);
        let lng = parseFloat(document.getElementById('longitud').value);
        if (!isNaN(lat) && !isNaN(lng)) updateMarker(lat, lng);
    });

    document.getElementById('longitud').addEventListener('input', function() {
        let lat = parseFloat(document.getElementById('latitud').value);
        let lng = parseFloat(this.value);
        if (!isNaN(lat) && !isNaN(lng)) updateMarker(lat, lng);
    });
</script>
@endsection
