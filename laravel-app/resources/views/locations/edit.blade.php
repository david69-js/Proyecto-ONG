@extends('layouts.app')

@section('content')
<h1 class="mb-4">Editar Ubicación</h1>

<form action="{{ route('locations.update', $location->id) }}" method="POST" class="card shadow p-4">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nombre de la ubicación</label>
        <input type="text" name="nombre" class="form-control" value="{{ $location->nombre }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="{{ $location->direccion }}">
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Ciudad / Departamento</label>
            <input type="text" name="ciudad" class="form-control" value="{{ $location->ciudad }}">
        </div>
        <div class="col">
            <label class="form-label">País</label>
            <input type="text" name="pais" class="form-control" value="{{ $location->pais }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Latitud</label>
            <input type="text" id="latitud" name="latitud" class="form-control" value="{{ $location->latitud }}" required>
        </div>
        <div class="col">
            <label class="form-label">Longitud</label>
            <input type="text" id="longitud" name="longitud" class="form-control" value="{{ $location->longitud }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ $location->telefono }}">
        </div>
        <div class="col">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ $location->email }}">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción / Notas</label>
        <textarea name="descripcion" class="form-control" rows="3">{{ $location->descripcion }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Selecciona en el mapa</label>
        <div id="map" style="height: 350px; border:1px solid #ccc; border-radius: 6px;"></div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success me-2"> Actualizar</button>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    var lat = {{ $location->latitud }};
    var lng = {{ $location->longitud }};

    var map = L.map('map').setView([lat, lng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);

    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);
        marker.setLatLng([lat, lng]);
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
    });

    function updateMarker() {
        let lat = parseFloat(document.getElementById('latitud').value);
        let lng = parseFloat(document.getElementById('longitud').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 14);
        }
    }

    document.getElementById('latitud').addEventListener('input', updateMarker);
    document.getElementById('longitud').addEventListener('input', updateMarker);
</script>
@endsection
