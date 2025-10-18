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
        Schema::create('ng_sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->enum('sponsor_type', ['individual', 'corporate', 'foundation', 'ngo', 'government', 'international'])->default('individual');
            $table->enum('contribution_type', ['monetary', 'materials', 'services', 'volunteer', 'mixed'])->default('monetary');
            $table->decimal('contribution_amount', 15, 2)->nullable();
            $table->text('contribution_description')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending', 'suspended'])->default('active');
            $table->date('partnership_start_date')->nullable();
            $table->date('partnership_end_date')->nullable();
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('priority_level')->default(1);
            $table->timestamps();

            // Índices
            $table->index(['status', 'is_featured']);
            $table->index(['sponsor_type', 'contribution_type']);
            $table->index('priority_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ng_sponsors');
    }
};
