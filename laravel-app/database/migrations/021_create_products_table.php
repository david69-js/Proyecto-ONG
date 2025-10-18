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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Información básica del producto
            $table->string('name'); // Nombre del producto
            $table->string('slug')->unique(); // URL amigable
            $table->text('description'); // Descripción detallada
            $table->text('short_description')->nullable(); // Descripción corta
            $table->string('sku')->unique(); // Código único del producto
            
            // Categorización
            $table->string('category'); // Categoría principal
            $table->string('subcategory')->nullable(); // Subcategoría
            $table->json('tags')->nullable(); // Etiquetas para búsqueda
            
            // Información de inventario (solo para muestra)
            $table->integer('stock_quantity')->default(0); // Cantidad en stock
            $table->string('stock_status')->default('in_stock'); // Estado del stock
            $table->boolean('manage_stock')->default(false); // Si se gestiona stock
            
            // Precios (solo informativos, no para venta)
            $table->decimal('cost_price', 10, 2)->nullable(); // Precio de costo
            $table->decimal('suggested_price', 10, 2)->nullable(); // Precio sugerido
            $table->string('currency', 3)->default('GTQ'); // Moneda
            
            // Características físicas
            $table->decimal('weight', 8, 2)->nullable(); // Peso en kg
            $table->decimal('length', 8, 2)->nullable(); // Largo en cm
            $table->decimal('width', 8, 2)->nullable(); // Ancho en cm
            $table->decimal('height', 8, 2)->nullable(); // Alto en cm
            
            // Imágenes
            $table->string('main_image')->nullable(); // Imagen principal
            $table->json('gallery_images')->nullable(); // Galería de imágenes
            
            // Estado y visibilidad
            $table->boolean('is_active')->default(true); // Si está activo
            $table->boolean('is_featured')->default(false); // Si es destacado
            $table->boolean('is_digital')->default(false); // Si es producto digital
            $table->boolean('requires_shipping')->default(true); // Si requiere envío
            
            // Información de la ONG
            $table->text('ngo_notes')->nullable(); // Notas internas de la ONG
            $table->string('donation_source')->nullable(); // Fuente de la donación
            $table->date('received_date')->nullable(); // Fecha de recepción
            $table->string('condition')->default('new'); // Estado del producto
            
            // Metadatos
            $table->json('specifications')->nullable(); // Especificaciones técnicas
            $table->text('usage_instructions')->nullable(); // Instrucciones de uso
            $table->text('care_instructions')->nullable(); // Instrucciones de cuidado
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimización
            $table->index(['category', 'is_active']);
            $table->index(['is_featured', 'is_active']);
            $table->index(['stock_status', 'is_active']);
            $table->index(['created_at', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
