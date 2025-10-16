<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ng_beneficiaries', function (Blueprint $table) {
            if (!Schema::hasColumn('ng_beneficiaries', 'gender')) {
                $table->string('gender', 20)->nullable();
            } else {
                $table->string('gender', 20)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ng_beneficiaries', function (Blueprint $table) {
            if (Schema::hasColumn('ng_beneficiaries', 'gender')) {
                $table->string('gender', 10)->nullable()->change();
            }
        });
    }
};
