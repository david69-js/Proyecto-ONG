@extends('layouts.tabler')

@section('page-title', 'Mensaje de Contacto')
@section('page-description', 'Ver detalles del mensaje de contacto')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-envelope me-2"></i>
                        Mensaje de Contacto
                    </h3>
                    <div>
                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h4>{{ $message->subject }}</h4>
                                <p class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $message->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <h5>Información del Contacto</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nombre:</strong> {{ $message->name }}</p>
                                        <p><strong>Email:</strong> 
                                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Teléfono:</strong> {{ $message->phone ?? 'No proporcionado' }}</p>
                                        <p><strong>Estado:</strong> 
                                            @if($message->is_read)
                                                <span class="badge bg-success">Leído</span>
                                            @else
                                                <span class="badge bg-warning">Nuevo</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5>Mensaje</h5>
                                <div class="border p-3 rounded bg-light">
                                    {!! nl2br(e($message->message)) !!}
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5>Información Técnica</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>IP:</strong> {{ $message->ip ?? 'No disponible' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>User Agent:</strong> {{ Str::limit($message->user_agent ?? 'No disponible', 50) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Acciones</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-reply me-1"></i> Responder
                                        </a>
                                        
                                        @if(!$message->is_read)
                                            <form action="{{ route('admin.contact-messages.mark-read', $message) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fas fa-check me-1"></i> Marcar como Leído
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('¿Eliminar este mensaje?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5>Estadísticas</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Recibido:</strong> {{ $message->created_at->diffForHumans() }}</p>
                                    <p><strong>Longitud del mensaje:</strong> {{ strlen($message->message) }} caracteres</p>
                                    <p><strong>Palabras:</strong> {{ str_word_count($message->message) }} palabras</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
