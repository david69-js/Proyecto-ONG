<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ng_beneficiary_testimonials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficiary_id');
            $table->string('title')->nullable();
            $table->text('body');
            $table->tinyInteger('rating')->default(5);
            $table->string('role')->nullable();
            $table->string('company')->nullable();
            $table->string('author_name')->nullable();
            $table->string('avatar_path')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('beneficiary_id')
                  ->references('id')->on('ng_beneficiaries')
                  ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ng_beneficiary_testimonials');
    }
};
