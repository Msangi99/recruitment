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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employer_id')->constrained('users')->cascadeOnDelete();
            
            // Job Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            
            // Company Information
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('location');
            $table->string('country')->default('Tanzania');
            
            // Job Details
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'temporary', 'internship']);
            $table->string('education_level')->nullable();
            $table->integer('experience_required')->default(0); // years
            $table->json('required_skills')->nullable();
            $table->json('languages')->nullable();
            
            // Salary Information
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency')->default('TZS');
            $table->enum('salary_period', ['hourly', 'daily', 'weekly', 'monthly', 'yearly'])->default('monthly');
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->integer('positions_available')->default(1);
            $table->date('application_deadline')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
