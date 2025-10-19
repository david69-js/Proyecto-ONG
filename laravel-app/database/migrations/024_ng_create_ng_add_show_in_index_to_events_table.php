<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ng_events', function (Blueprint $table) {
            $table->boolean('show_in_index')->default(false)->after('featured');
        });
    }

    public function down(): void
    {
        // Verificar que la tabla existe antes de intentar modificarla
        if (Schema::hasTable('ng_events') && Schema::hasColumn('ng_events', 'show_in_index')) {
            Schema::table('ng_events', function (Blueprint $table) {
                $table->dropColumn('show_in_index');
            });
        }
    }
};