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
        $table->foreignId('project_id')->nullable()->after('id')->constrained('proyectos')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('ng_beneficiaries', function (Blueprint $table) {
        $table->dropForeign(['project_id']);
        $table->dropColumn('project_id');
    });
}

};
