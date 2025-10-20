<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ng_donor_highlights', function (Blueprint $table) {
            $table->id();

            // opcionalmente vinculado a una donation o sponsor
            $table->foreignId('donation_id')->nullable()->constrained('donations')->nullOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained('ng_sponsors')->nullOnDelete();

            // datos para mostrar en el home
            $table->string('name');                 // Marcus Thompson
            $table->string('position')->nullable(); // Donador Principal
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar_path')->nullable(); // foto del donador
            $table->string('badge_text')->nullable();  // “15+ Años Apoyando”
            $table->text('bio')->nullable();           // texto descriptivo
            $table->string('skills')->nullable();      // etiquetas (csv): "Educación,Salud"

            // sociales
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('website_url')->nullable();

            // flags de publicación y orden
            $table->boolean('is_featured')->default(false); // destacado (tarjeta grande)
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();

            // auditoría
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['is_published','is_featured','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ng_donor_highlights');
    }
};
