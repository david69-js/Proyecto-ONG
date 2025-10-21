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
        Schema::create('ng_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('beneficiary_type')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key para project_id
            $table->foreign('project_id')
                  ->references('id')
                  ->on('ng_projects')
                  ->onDelete('set null');
        });

        // Agregar foreign key de user_id después de crear la tabla
        // Esto se hace por separado para evitar problemas de orden
        if (Schema::hasTable('users')) {
            Schema::table('ng_beneficiaries', function (Blueprint $table) {
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ng_beneficiaries');
    }
};