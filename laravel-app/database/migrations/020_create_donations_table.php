<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            
            // Información básica de la donación
            $table->string('donation_code')->unique(); // Código único de donación
            $table->enum('donation_type', ['monetary', 'materials', 'services', 'volunteer', 'mixed'])->default('monetary');
            $table->decimal('amount', 15, 2)->nullable(); // Monto en caso de donación monetaria
            $table->string('currency', 3)->default('USD'); // Moneda
            $table->text('description'); // Descripción de la donación
            
            // Información del donante
            $table->string('donor_name'); // Nombre del donante
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->text('donor_address')->nullable();
            $table->enum('donor_type', ['individual', 'corporate', 'foundation', 'ngo', 'government'])->default('individual');
            $table->boolean('is_anonymous')->default(false); // Donación anónima
            
            // Vinculación con el sistema
            $table->foreignId('user_id')->nullable()->constrained('sys_users')->onDelete('set null'); // Usuario registrado
            $table->foreignId('project_id')->nullable()->constrained('ng_projects')->onDelete('set null'); // Proyecto específico
            $table->foreignId('sponsor_id')->nullable()->constrained('ng_sponsors')->onDelete('set null'); // Patrocinador relacionado
            
            // Método de pago y procesamiento
            $table->enum('payment_method', ['transfer', 'cash', 'check', 'kind', 'other'])->default('transfer');
            $table->string('payment_reference')->nullable(); // Referencia de pago
            $table->text('payment_notes')->nullable(); // Notas adicionales del pago
            
            // Estado y seguimiento
            $table->enum('status', ['pending', 'confirmed', 'processed', 'rejected', 'cancelled'])->default('pending');
            $table->text('status_notes')->nullable(); // Notas del estado actual
            $table->timestamp('confirmed_at')->nullable(); // Fecha de confirmación
            $table->timestamp('processed_at')->nullable(); // Fecha de procesamiento
            $table->foreignId('confirmed_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->foreignId('processed_by')->nullable()->constrained('sys_users')->onDelete('set null');
            
            // Información adicional
            $table->text('special_instructions')->nullable(); // Instrucciones especiales
            $table->json('metadata')->nullable(); // Datos adicionales en JSON
            $table->boolean('is_tax_deductible')->default(false); // Deducible de impuestos
            $table->string('tax_receipt_number')->nullable(); // Número de recibo fiscal
            
            // Archivos adjuntos
            $table->string('receipt_path')->nullable(); // Ruta del comprobante
            $table->string('tax_receipt_path')->nullable(); // Ruta del recibo fiscal
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->timestamps();
            
            // Índices para optimización
            $table->index(['donation_type', 'status']);
            $table->index(['donor_type', 'status']);
            $table->index(['project_id', 'status']);
            $table->index(['created_at', 'status']);
            $table->index('donation_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
