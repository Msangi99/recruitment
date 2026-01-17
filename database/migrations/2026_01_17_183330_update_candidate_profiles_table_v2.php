<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            // New fields
            $table->string('title')->nullable()->after('user_id');
            $table->text('description')->nullable()->after('title');
            $table->string('location')->nullable()->after('description');
            $table->text('experience_description')->nullable()->after('years_of_experience');

            // Drop removed fields
            $table->dropColumn(['citizenship', 'residency_status', 'marital_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            // Re-add removed fields
            $table->string('citizenship')->nullable();
            $table->string('residency_status')->nullable();
            $table->string('marital_status')->nullable();

            // Drop new fields
            $table->dropColumn(['title', 'description', 'location', 'experience_description']);
        });
    }
};
