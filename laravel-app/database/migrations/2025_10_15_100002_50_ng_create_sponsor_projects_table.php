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
        Schema::create('rel_sponsor_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('ng_sponsors')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('ng_projects')->onDelete('cascade');
            $table->decimal('contribution_amount', 15, 2)->nullable();
            $table->enum('contribution_type', ['monetary', 'materials', 'services', 'volunteer', 'mixed'])->default('monetary');
            $table->date('sponsorship_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Índices
            $table->unique(['sponsor_id', 'project_id']);
            $table->index('sponsorship_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_sponsor_projects');
    }
};
