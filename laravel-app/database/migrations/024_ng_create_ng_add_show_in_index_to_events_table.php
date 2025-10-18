<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ng_events', function (Blueprint $table) {
            $table->boolean('show_in_index')->default(false)->after('featured'); // o después de la columna que quieras
        });
    }

    public function down(): void
    {
        Schema::table('ng_events', function (Blueprint $table) {
            $table->dropColumn('show_in_index');
        });
    }
};
