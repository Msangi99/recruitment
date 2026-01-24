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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('candidate_profiles', 'headline')) {
                $table->string('headline')->nullable()->after('title');
            }
            if (!Schema::hasColumn('candidate_profiles', 'passport_status')) {
                $table->string('passport_status')->nullable();
            }
            if (!Schema::hasColumn('candidate_profiles', 'willing_to_relocate')) {
                $table->boolean('willing_to_relocate')->default(false);
            }
            if (!Schema::hasColumn('candidate_profiles', 'availability_status')) {
                $table->string('availability_status')->nullable();
            }
            if (!Schema::hasColumn('candidate_profiles', 'medical_clearance')) {
                $table->string('medical_clearance')->nullable();
            }
            if (!Schema::hasColumn('candidate_profiles', 'police_clearance')) {
                $table->string('police_clearance')->nullable();
            }
            if (!Schema::hasColumn('candidate_profiles', 'preferred_job_titles')) {
                $table->json('preferred_job_titles')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'headline',
                'passport_status',
                'willing_to_relocate',
                'availability_status',
                'medical_clearance',
                'police_clearance',
                'preferred_job_titles'
            ]);
        });
    }
};
