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
        // Eliminar tablas duplicadas que ya no son necesarias
        // Las nuevas tablas con jerarquía ya están creadas
        
        // Primero eliminar tablas de relaciones (que tienen claves foráneas)
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('user_permissions');
        
        // Luego eliminar tablas que dependen de otras
        Schema::dropIfExists('user_profiles');
        
        // Después eliminar tablas principales
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        
        // Eliminar tablas de sesiones, cache y jobs duplicadas
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se puede revertir esta migración ya que elimina tablas
        // Si necesitas revertir, tendrías que recrear las tablas manualmente
        throw new Exception('This migration cannot be reversed as it drops tables permanently.');
    }
};