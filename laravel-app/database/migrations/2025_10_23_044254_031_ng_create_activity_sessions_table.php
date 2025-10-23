<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   // migration: create_activity_sessions_table
    Schema::create('activity_sessions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('session_key')->index(); // identificador único por navegador (cookie/localStorage)
        $table->ipAddress('ip')->nullable();
        $table->string('user_agent')->nullable();
        $table->string('current_path')->nullable();
        $table->timestamp('started_at')->nullable();
        $table->timestamp('last_seen_at')->nullable();
        $table->integer('accumulated_seconds')->default(0); // total de tiempo activo
        $table->json('page_times')->nullable(); // {"/home": 32, "/prod/1": 120}
        $table->timestamps();
    });


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
