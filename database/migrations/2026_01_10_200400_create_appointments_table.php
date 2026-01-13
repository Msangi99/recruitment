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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Candidate
            $table->foreignId('employer_id')->nullable()->constrained('users')->nullOnDelete(); // Optional employer
            
            // Appointment Details
            $table->string('title')->nullable(); // Interview title/position
            $table->enum('appointment_type', ['consultation', 'counselling', 'interview', 'other']);
            $table->enum('meeting_mode', ['online', 'in-person']);
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(30);
            
            // Company/Employer Details
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable(); // Interviewer's job title
            $table->string('interviewer_email')->nullable();
            
            // Meeting Information
            $table->string('meeting_link')->nullable(); // Zoom/Google Meet link
            $table->string('meeting_location')->nullable(); // For in-person meetings
            $table->text('notes')->nullable();
            $table->text('requirements')->nullable(); // Additional requirements/qualifications needed
            
            // Payment Information
            $table->decimal('amount', 10, 2); // TZS 30,000 or $12
            $table->string('currency')->default('TZS');
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('transaction_id')->nullable(); // Selcom transaction ID
            $table->string('order_id')->nullable(); // Selcom order ID
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'no-show'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
