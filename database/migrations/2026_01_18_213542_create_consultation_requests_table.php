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
        Schema::create('consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // employer, partnership, job_seeker
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            
            // Contextual fields
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            
            // Meta data for flexible fields (JSON)
            // For Job Seeker forms, this will hold work history, goals, etc.
            // For Employer: worker types, numbers, etc.
            $table->json('meta_data')->nullable();
            
            // Scheduling
            $table->dateTime('requested_date')->nullable();
            $table->integer('duration_minutes')->nullable();
            
            // Status tracking
            $table->string('status')->default('pending'); // pending, approved, completed, rejected
            
            // Payment (mainly for Job Seeker)
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency')->default('TZS');
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('payment_gateway')->nullable(); // Azampay, Selcom
            $table->string('transaction_reference')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_requests');
    }
};
