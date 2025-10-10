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
        Schema::create('rel_project_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('sys_users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->enum('role_in_project', ['coordinator', 'volunteer', 'staff'])->default('volunteer');
            $table->date('assigned_at')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('sys_users')->onDelete('set null');
            $table->timestamps();

            // Un usuario puede estar asignado a un proyecto solo una vez
            $table->unique(['user_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_project_assignments');
    }
};

