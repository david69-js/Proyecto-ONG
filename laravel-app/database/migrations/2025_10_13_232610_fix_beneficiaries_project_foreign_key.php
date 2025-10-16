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
            // Add the new foreign key constraint referencing the correct table
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ng_beneficiaries', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['project_id']);
        });
    }
};