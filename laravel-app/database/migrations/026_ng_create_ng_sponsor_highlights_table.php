<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ng_sponsor_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('ng_sponsors')->cascadeOnDelete();
            $table->string('title')->nullable();          // Texto visible (opcional)
            $table->string('category')->nullable();       // “Gestión de Calidad”, etc.
            $table->text('description')->nullable();      // Texto de apoyo
            $table->string('logo_path')->nullable();      // logo/badge mostrado en tarjeta
            $table->boolean('is_featured')->default(false); // para el bloque “Patrocinador Destacado”
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);    // ordenar tarjetas
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['is_published','is_featured','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ng_sponsor_highlights');
    }
};
