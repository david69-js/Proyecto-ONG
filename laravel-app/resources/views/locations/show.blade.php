@extends('layouts.app')

@section('content')
<h1>Detalle de Ubicación</h1>

<p><strong>Nombre:</strong> {{ $location->nombre }}</p>
<p><strong>Dirección:</strong> {{ $location->direccion }}</p>
<p><strong>Ciudad:</strong> {{ $location->ciudad }}</p>
<p><strong>País:</strong> {{ $location->pais }}</p>
<p><strong>Latitud:</strong> {{ $location->latitud }}</p>
<p><strong>Longitud:</strong> {{ $location->longitud }}</p>

<a href="{{ route('location.index') }}" class="btn btn-secondary">Volver</a>
@endsection
