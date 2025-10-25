@extends('layouts.tabler')

@section('page-title', 'Mensajes de Contacto')
@section('page-description', 'Gestionar mensajes recibidos del formulario de contacto')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope me-2"></i>
                        Mensajes de Contacto
                    </h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Asunto</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr class="{{ $message->is_read ? '' : 'table-warning' }}">
                                            <td>
                                                @if($message->is_read)
                                                    <span class="badge bg-success">Leído</span>
                                                @else
                                                    <span class="badge bg-warning">Nuevo</span>
                                                @endif
                                            </td>
                                            <td>{{ $message->name }}</td>
                                            <td>
                                                <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                            </td>
                                            <td>{{ Str::limit($message->subject, 50) }}</td>
                                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.contact-messages.show', $message) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                    @if(!$message->is_read)
                                                        <button type="button" 
                                                                class="btn btn-sm btn-success mark-read-btn"
                                                                data-id="{{ $message->id }}">
                                                            <i class="fas fa-check"></i> Leído
                                                        </button>
                                                    @endif
                                                    <form action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar este mensaje?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay mensajes de contacto</h4>
                            <p class="text-muted">Los mensajes del formulario de contacto aparecerán aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Marcar como leído
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const messageId = this.getAttribute('data-id');
            
            fetch(`/admin/contact-messages/${messageId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endsection
