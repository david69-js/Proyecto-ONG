<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ng_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->enum('beneficiary_type', ['Person', 'Family', 'Community'])->default('Person');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('project_id')
                  ->references('id')
                  ->on('proyectos') 
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ng_beneficiaries');
    }
};
