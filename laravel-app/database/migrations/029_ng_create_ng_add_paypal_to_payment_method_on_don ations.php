<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Agregamos 'paypal' al ENUM
        DB::statement("
            ALTER TABLE donations 
            MODIFY COLUMN payment_method 
            ENUM('transfer','cash','check','kind','other','paypal') 
            DEFAULT 'transfer'
        ");
    }

    public function down(): void
    {
        // Primero limpiamos los valores 'paypal' existentes
        DB::table('donations')
            ->where('payment_method', 'paypal')
            ->update(['payment_method' => 'transfer']);

        // Luego revertimos el ENUM a la versión anterior
        DB::statement("
            ALTER TABLE donations 
            MODIFY COLUMN payment_method 
            ENUM('transfer','cash','check','kind','other') 
            DEFAULT 'transfer'
        ");
    }
};
