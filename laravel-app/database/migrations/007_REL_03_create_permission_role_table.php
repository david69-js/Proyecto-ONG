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
        Schema::create('rel_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('cfg_roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('cfg_permissions')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure a role can't have the same permission twice
            $table->unique(['role_id', 'permission_id']);
            $table->index('role_id');
            $table->index('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_role_permissions');
    }
};