@extends('layouts.app')

@section('title', 'Nueva Donación')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-heart text-danger"></i>
                        Nueva Donación
                    </h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Información de la Donación -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-gift"></i> Información de la Donación
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="donation_type" class="form-label">Tipo de Donación *</label>
                                    <select class="form-select @error('donation_type') is-invalid @enderror" 
                                            id="donation_type" name="donation_type" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="monetary" {{ old('donation_type') == 'monetary' ? 'selected' : '' }}>Monetaria</option>
                                        <option value="materials" {{ old('donation_type') == 'materials' ? 'selected' : '' }}>Materiales</option>
                                        <option value="services" {{ old('donation_type') == 'services' ? 'selected' : '' }}>Servicios</option>
                                        <option value="volunteer" {{ old('donation_type') == 'volunteer' ? 'selected' : '' }}>Voluntariado</option>
                                        <option value="mixed" {{ old('donation_type') == 'mixed' ? 'selected' : '' }}>Mixta</option>
                                    </select>
                                    @error('donation_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3" id="amount-field" style="display: none;">
                                            <label for="amount" class="form-label">Monto</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('amount') is-invalid @enderror" 
                                                       id="amount" name="amount" value="{{ old('amount') }}">
                                                <select class="form-select" id="currency" name="currency">
                                                    <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                    <option value="MXN" {{ old('currency') == 'MXN' ? 'selected' : '' }}>MXN</option>
                                                </select>
                                            </div>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="project_id" class="form-label">Proyecto</label>
                                    <select class="form-select @error('project_id') is-invalid @enderror" 
                                            id="project_id" name="project_id">
                                        <option value="">Sin proyecto específico</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="sponsor_id" class="form-label">Patrocinador</label>
                                    <select class="form-select @error('sponsor_id') is-invalid @enderror" 
                                            id="sponsor_id" name="sponsor_id">
                                        <option value="">Sin patrocinador</option>
                                        @foreach($sponsors as $sponsor)
                                            <option value="{{ $sponsor->id }}" {{ old('sponsor_id') == $sponsor->id ? 'selected' : '' }}>
                                                {{ $sponsor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sponsor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información del Donante -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Información del Donante
                                </h5>

                                <div class="mb-3">
                                    <label for="donor_type" class="form-label">Tipo de Donante *</label>
                                    <select class="form-select @error('donor_type') is-invalid @enderror" 
                                            id="donor_type" name="donor_type" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="individual" {{ old('donor_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="corporate" {{ old('donor_type') == 'corporate' ? 'selected' : '' }}>Corporativo</option>
                                        <option value="foundation" {{ old('donor_type') == 'foundation' ? 'selected' : '' }}>Fundación</option>
                                        <option value="ngo" {{ old('donor_type') == 'ngo' ? 'selected' : '' }}>ONG</option>
                                        <option value="government" {{ old('donor_type') == 'government' ? 'selected' : '' }}>Gobierno</option>
                                    </select>
                                    @error('donor_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="donor_name" class="form-label">Nombre del Donante *</label>
                                    <input type="text" class="form-control @error('donor_name') is-invalid @enderror" 
                                           id="donor_name" name="donor_name" value="{{ old('donor_name') }}" required>
                                    @error('donor_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="donor_email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('donor_email') is-invalid @enderror" 
                                           id="donor_email" name="donor_email" value="{{ old('donor_email') }}">
                                    @error('donor_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="donor_phone" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('donor_phone') is-invalid @enderror" 
                                           id="donor_phone" name="donor_phone" value="{{ old('donor_phone') }}">
                                    @error('donor_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="donor_address" class="form-label">Dirección</label>
                                    <textarea class="form-control @error('donor_address') is-invalid @enderror" 
                                              id="donor_address" name="donor_address" rows="2">{{ old('donor_address') }}</textarea>
                                    @error('donor_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" 
                                               value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_anonymous">
                                            Donación anónima
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Información de Pago -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-credit-card"></i> Información de Pago
                                </h5>

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Método de Pago *</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" 
                                            id="payment_method" name="payment_method" required>
                                        <option value="">Seleccionar método</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cheque</option>
                                        <option value="kind" {{ old('payment_method') == 'kind' ? 'selected' : '' }}>En Especie</option>
                                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="payment_reference" class="form-label">Referencia de Pago</label>
                                    <input type="text" class="form-control @error('payment_reference') is-invalid @enderror" 
                                           id="payment_reference" name="payment_reference" value="{{ old('payment_reference') }}">
                                    @error('payment_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="payment_notes" class="form-label">Notas del Pago</label>
                                    <textarea class="form-control @error('payment_notes') is-invalid @enderror" 
                                              id="payment_notes" name="payment_notes" rows="2">{{ old('payment_notes') }}</textarea>
                                    @error('payment_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-alt"></i> Documentos
                                </h5>

                                <div class="mb-3">
                                    <label for="receipt" class="form-label">Comprobante</label>
                                    <input type="file" class="form-control @error('receipt') is-invalid @enderror" 
                                           id="receipt" name="receipt" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">Formatos permitidos: PDF, JPG, PNG (máx. 2MB)</div>
                                    @error('receipt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_tax_deductible" name="is_tax_deductible" 
                                               value="1" {{ old('is_tax_deductible') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_tax_deductible">
                                            Deducible de impuestos
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="special_instructions" class="form-label">Instrucciones Especiales</label>
                                    <textarea class="form-control @error('special_instructions') is-invalid @enderror" 
                                              id="special_instructions" name="special_instructions" rows="3">{{ old('special_instructions') }}</textarea>
                                    @error('special_instructions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('donations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Crear Donación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const donationTypeSelect = document.getElementById('donation_type');
    const amountField = document.getElementById('amount-field');
    
    function toggleAmountField() {
        const selectedType = donationTypeSelect.value;
        if (selectedType === 'monetary' || selectedType === 'mixed') {
            amountField.style.display = 'block';
            if (selectedType === 'monetary') {
                document.getElementById('amount').required = true;
            }
        } else {
            amountField.style.display = 'none';
            document.getElementById('amount').required = false;
        }
    }
    
    donationTypeSelect.addEventListener('change', toggleAmountField);
    toggleAmountField(); // Ejecutar al cargar la página
});
</script>
@endsection
