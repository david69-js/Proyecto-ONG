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
        Schema::table('ng_beneficiaries', function (Blueprint $table) {
            // Cambiar la columna gender para que acepte valores más largos
            $table->string('gender', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ng_beneficiaries', function (Blueprint $table) {
            // Revertir a un tamaño más pequeño si es necesario
            $table->string('gender', 10)->nullable()->change();
        });
    }
};