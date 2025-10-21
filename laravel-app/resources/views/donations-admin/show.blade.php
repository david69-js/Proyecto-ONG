@extends('layouts.tabler')

@section('title', 'Detalle de Donación')
@section('page-title', 'Detalle de Donación')
@section('page-description', 'Información completa de la donación: ' . $donation->donation_code)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-heart text-danger me-2"></i>
                    Donación: {{ $donation->donation_code }}
                </h3>
                    <div>
                        @permission('donations.edit')
                        <a href="{{ route('admin.donations-admin.edit', $donation) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        @endpermission
                        
                        <a href="{{ route('admin.donations-admin.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Información de la Donación -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-gift"></i> Información de la Donación
                                    </h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Código:</strong></td>
                                            <td><code>{{ $donation->donation_code }}</code></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo:</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $donation->donation_type_formatted }}</span>
                                            </td>
                                        </tr>
                                        @if($donation->isMonetary())
                                        <tr>
                                            <td><strong>Monto:</strong></td>
                                            <td>
                                                <strong class="text-success fs-5">{{ $donation->formatted_amount }}</strong>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Descripción:</strong></td>
                                            <td>{{ $donation->description }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Estado:</strong></td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'warning',
                                                        'confirmed' => 'info',
                                                        'processed' => 'success',
                                                        'rejected' => 'danger',
                                                        'cancelled' => 'secondary'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusClasses[$donation->status] ?? 'secondary' }} fs-6">
                                                    {{ $donation->status_formatted }}
                                                </span>
                                            </td>
                                        </tr>
                                        @if($donation->status_notes)
                                        <tr>
                                            <td><strong>Notas del Estado:</strong></td>
                                            <td>{{ $donation->status_notes }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>

                                <!-- Información del Donante -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-user"></i> Información del Donante
                                    </h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nombre:</strong></td>
                                            <td>
                                                {{ $donation->donor_display_name }}
                                                @if($donation->is_anonymous)
                                                    <i class="fas fa-user-secret text-muted" title="Donación anónima"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo:</strong></td>
                                            <td>{{ $donation->donor_type_formatted }}</td>
                                        </tr>
                                        @if($donation->donor_email)
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <a href="mailto:{{ $donation->donor_email }}">{{ $donation->donor_email }}</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($donation->donor_phone)
                                        <tr>
                                            <td><strong>Teléfono:</strong></td>
                                            <td>
                                                <a href="tel:{{ $donation->donor_phone }}">{{ $donation->donor_phone }}</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($donation->donor_address)
                                        <tr>
                                            <td><strong>Dirección:</strong></td>
                                            <td>{{ $donation->donor_address }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- Información de Pago -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-credit-card"></i> Información de Pago
                                    </h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Método:</strong></td>
                                            <td>{{ $donation->payment_method_formatted }}</td>
                                        </tr>
                                        @if($donation->payment_reference)
                                        <tr>
                                            <td><strong>Referencia:</strong></td>
                                            <td><code>{{ $donation->payment_reference }}</code></td>
                                        </tr>
                                        @endif
                                        @if($donation->payment_notes)
                                        <tr>
                                            <td><strong>Notas:</strong></td>
                                            <td>{{ $donation->payment_notes }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Deducible:</strong></td>
                                            <td>
                                                @if($donation->is_tax_deductible)
                                                    <span class="badge bg-success">Sí</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($donation->tax_receipt_number)
                                        <tr>
                                            <td><strong>Recibo Fiscal:</strong></td>
                                            <td><code>{{ $donation->tax_receipt_number }}</code></td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>

                                <!-- Proyecto y Patrocinador -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-project-diagram"></i> Vinculaciones
                                    </h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Proyecto:</strong></td>
                                            <td>
                                                @if($donation->project)
                                                    <a href="{{ route('projects.show', $donation->project) }}" class="text-decoration-none">
                                                        {{ $donation->project->nombre }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin proyecto</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Patrocinador:</strong></td>
                                            <td>
                                                @if($donation->sponsor)
                                                    <a href="{{ route('sponsors.show', $donation->sponsor) }}" class="text-decoration-none">
                                                        {{ $donation->sponsor->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin patrocinador</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($donation->user)
                                        <tr>
                                            <td><strong>Usuario:</strong></td>
                                            <td>
                                                <a href="{{ route('users.show', $donation->user) }}" class="text-decoration-none">
                                                    {{ $donation->user->first_name }} {{ $donation->user->last_name }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- Instrucciones Especiales -->
                            @if($donation->special_instructions)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-sticky-note"></i> Instrucciones Especiales
                                    </h5>
                                    <div class="alert alert-info">
                                        {{ $donation->special_instructions }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Panel Lateral -->
                        <div class="col-md-4">
                            <!-- Acciones -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs"></i> Acciones
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @permission('donations.confirm')
                                    @if($donation->status === 'pending')
                                    <form method="POST" action="{{ route('admin.donations-admin.confirm', $donation) }}" class="mb-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100" 
                                                onclick="return confirm('¿Confirmar esta donación?')">
                                            <i class="fas fa-check"></i> Confirmar
                                        </button>
                                    </form>
                                    @endif
                                    @endpermission

                                    @permission('donations.process')
                                    @if($donation->status === 'confirmed')
                                    <form method="POST" action="{{ route('admin.donations-admin.process', $donation) }}" class="mb-2">
                                        @csrf
                                        <button type="submit" class="btn btn-info w-100" 
                                                onclick="return confirm('¿Procesar esta donación?')">
                                            <i class="fas fa-cogs"></i> Procesar
                                        </button>
                                    </form>
                                    @endif
                                    @endpermission

                                    @permission('donations.edit')
                                    @if(in_array($donation->status, ['pending', 'confirmed']))
                                    <button type="button" class="btn btn-warning w-100 mb-2" 
                                            data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                    @endif
                                    @endpermission

                                    @if(in_array($donation->status, ['pending', 'confirmed']))
                                    <button type="button" class="btn btn-secondary w-100" 
                                            data-bs-toggle="modal" data-bs-target="#cancelModal">
                                        <i class="fas fa-ban"></i> Cancelar
                                    </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Documentos -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-file-alt"></i> Documentos
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if($donation->receipt_path)
                                    <div class="mb-2">
                                        <a href="{{ $donation->receipt_url }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-file-pdf"></i> Ver Comprobante
                                        </a>
                                    </div>
                                    @endif

                                    @if($donation->tax_receipt_path)
                                    <div class="mb-2">
                                        <a href="{{ $donation->tax_receipt_url }}" target="_blank" class="btn btn-outline-success btn-sm w-100">
                                            <i class="fas fa-file-invoice"></i> Ver Recibo Fiscal
                                        </a>
                                    </div>
                                    @endif

                                    @if(!$donation->receipt_path && !$donation->tax_receipt_path)
                                    <p class="text-muted text-center mb-0">Sin documentos adjuntos</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Historial -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-history"></i> Historial
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Creada</h6>
                                                <p class="timeline-text">{{ $donation->created_at->format('d/m/Y H:i') }}</p>
                                                @if($donation->createdBy)
                                                <small class="text-muted">Por: {{ $donation->createdBy->first_name }} {{ $donation->createdBy->last_name }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        @if($donation->confirmed_at)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-info"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Confirmada</h6>
                                                <p class="timeline-text">{{ $donation->confirmed_at->format('d/m/Y H:i') }}</p>
                                                @if($donation->confirmedBy)
                                                <small class="text-muted">Por: {{ $donation->confirmedBy->first_name }} {{ $donation->confirmedBy->last_name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endif

                                        @if($donation->processed_at)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Procesada</h6>
                                                <p class="timeline-text">{{ $donation->processed_at->format('d/m/Y H:i') }}</p>
                                                @if($donation->processedBy)
                                                <small class="text-muted">Por: {{ $donation->processedBy->first_name }} {{ $donation->processedBy->last_name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Rechazar -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rechazar Donación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.donations-admin.reject', $donation) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_notes" class="form-label">Motivo del rechazo *</label>
                        <textarea class="form-control" id="status_notes" name="status_notes" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Rechazar Donación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Cancelar -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar Donación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.donations-admin.cancel', $donation) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_notes" class="form-label">Motivo de la cancelación</label>
                        <textarea class="form-control" id="status_notes" name="status_notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Cancelar Donación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 5px;
}
</style>
@endsection
