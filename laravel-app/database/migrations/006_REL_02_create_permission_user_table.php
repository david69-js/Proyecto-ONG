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
        Schema::create('rel_user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('sys_users')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('cfg_permissions')->onDelete('cascade');
            $table->boolean('is_granted')->default(true); // true = granted, false = denied
            $table->timestamp('granted_at')->useCurrent();
            $table->foreignId('granted_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('permission_id');
            $table->index(['user_id', 'is_granted']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_user_permissions');
    }
};