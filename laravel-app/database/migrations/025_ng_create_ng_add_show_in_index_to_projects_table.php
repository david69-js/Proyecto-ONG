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
    Schema::table('ng_projects', function (Blueprint $table) {
        $table->boolean('show_in_index')->default(false)->after('id');
    });
}

public function down(): void
{
    Schema::table('ng_projects', function (Blueprint $table) {
        $table->dropColumn('show_in_index');
    });
}

};
