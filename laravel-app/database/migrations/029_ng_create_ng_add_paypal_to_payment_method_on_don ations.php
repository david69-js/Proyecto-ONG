<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // SQLite no soporta MODIFY COLUMN ni ENUM
        // En SQLite, simplemente agregamos la columna si no existe
        // Los valores se validan a nivel de aplicación
        if (!Schema::hasColumn('donations', 'payment_method')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->string('payment_method')->default('transfer');
            });
        }
    }

    public function down(): void
    {
        // Primero limpiamos los valores 'paypal' existentes
        DB::table('donations')
            ->where('payment_method', 'paypal')
            ->update(['payment_method' => 'transfer']);

        // En SQLite no podemos revertir fácilmente, pero los valores se mantienen
        // La validación se hace a nivel de aplicación
    }
};
