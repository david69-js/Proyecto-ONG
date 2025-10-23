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
        Schema::create('visitor_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('ip_address', 45)->index();
            $table->string('user_agent')->nullable();
            $table->string('page_url');
            $table->string('page_title')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('visit_start')->nullable();
            $table->timestamp('visit_end')->nullable();
            $table->integer('time_spent')->default(0); // en segundos
            $table->json('page_data')->nullable(); // datos adicionales de la página
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->timestamps();
            
            $table->index(['session_id', 'page_url']);
            $table->index(['ip_address', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_tracking');
    }
};
