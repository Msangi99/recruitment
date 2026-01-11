<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update appointment_type enum to include 'subscription'
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_type ENUM('consultation', 'counselling', 'interview', 'subscription', 'other') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_type ENUM('consultation', 'counselling', 'interview', 'other') NOT NULL");
    }
};
