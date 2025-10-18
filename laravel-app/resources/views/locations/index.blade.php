@extends('layouts.tabler')

@section('page-title', 'Gestión de Ubicaciones')
@section('page-description', 'Administrar ubicaciones del sistema')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span><i class="fas fa-map-marked-alt"></i> Ubicaciones</span>
                    <a href="{{ route('locations.create') }}" class="btn btn-success btn-sm">+ Nueva</a>
                </div>
                <div class="card-body p-0" style="height: 600px; position: relative;">
                    <div id="main-map" style="width: 100%; height: 100%;"></div>

                    <div class="map-toggle" onclick="toggleMap()">
                        <span id="map-icon">🌍</span> <span id="map-text">Predeterminado</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Derecho: Lista -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-users"></i> Miembros / Ubicaciones
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($locations as $location)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $location->nombre }}</strong><br>
                                <small class="text-muted">{{ $location->ciudad }}, {{ $location->pais }}</small>
                            </div>
                            <div>
                                <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar ubicación?')">X</button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    /* Botón flotante personalizado */
    .map-toggle {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1000;
        background: #fff;
        border-radius: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.3s;
    }

    .map-toggle:hover {
        background: #f0f0f0;
    }

    .map-toggle span {
        font-size: 18px;
    }
</style>

<script>
    var mainMap = L.map('main-map');

    var streetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    });

    var satelliteMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri'
    });

    streetMap.addTo(mainMap);

    var isSatellite = false;

    function toggleMap() {
        if (isSatellite) {
            mainMap.removeLayer(satelliteMap);
            streetMap.addTo(mainMap);
            document.getElementById("map-icon").textContent = "🌍";
            document.getElementById("map-text").textContent = "Predeterminado";
            isSatellite = false;
        } else {
            mainMap.removeLayer(streetMap);
            satelliteMap.addTo(mainMap);
            document.getElementById("map-icon").textContent = "🛰";
            document.getElementById("map-text").textContent = "Satelital";
            isSatellite = true;
        }
    }

    // Array para almacenar coordenadas
    var bounds = [];

    @foreach($locations as $location)
        var marker = L.marker([{{ $location->latitud }}, {{ $location->longitud }}])
            .addTo(mainMap)
            .bindPopup("<strong>{{ $location->nombre }}</strong><br>{{ $location->direccion }}<br>{{ $location->ciudad }}, {{ $location->pais }}");

        bounds.push([{{ $location->latitud }}, {{ $location->longitud }}]);
    @endforeach

    if (bounds.length > 0) {
        mainMap.fitBounds(bounds);
    } else {
        mainMap.setView([15.7835, -90.2308], 6); 
    }
</script>
@endsection
