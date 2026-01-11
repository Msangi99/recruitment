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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Personal Information
            $table->date('date_of_birth')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('residency_status')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            
            // Professional Information
            $table->string('education_level')->nullable();
            $table->json('skills')->nullable(); // Array of skills
            $table->json('languages')->nullable(); // Array of languages
            $table->integer('years_of_experience')->default(0);
            $table->decimal('expected_salary', 10, 2)->nullable();
            $table->string('currency')->default('TZS');
            $table->string('target_destination')->nullable(); // Target country/region
            
            // Verification Status
            $table->enum('verification_status', ['pending', 'approved', 'rejected', 'revise'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            
            // Profile Visibility
            $table->boolean('is_public')->default(false);
            $table->boolean('is_available')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
