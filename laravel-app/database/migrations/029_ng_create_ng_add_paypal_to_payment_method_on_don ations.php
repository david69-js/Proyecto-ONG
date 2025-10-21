<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // MySQL: cambia el ENUM para incluir 'paypal'
        DB::statement("ALTER TABLE donations MODIFY COLUMN payment_method 
            ENUM('transfer','cash','check','kind','other','paypal') DEFAULT 'transfer'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE donations MODIFY COLUMN payment_method 
            ENUM('transfer','cash','check','kind','other') DEFAULT 'transfer'");
    }
};