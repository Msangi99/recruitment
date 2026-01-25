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
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('contract_duration')->nullable()->after('employment_type');
            $table->string('job_location_type')->nullable()->after('location'); // Local / Abroad
            $table->boolean('willing_to_relocate')->default(false)->after('experience_level');
            $table->boolean('required_passport')->default(false)->after('willing_to_relocate');
            $table->boolean('medical_clearance')->default(false)->after('required_passport');
            $table->boolean('police_clearance')->default(false)->after('medical_clearance');
            $table->text('other_benefits')->nullable()->after('benefits');
            $table->integer('experience_years')->nullable()->after('experience_level');
            
            // Modify existing columns if necessary
            $table->json('benefits')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn([
                'contract_duration',
                'job_location_type',
                'willing_to_relocate',
                'required_passport',
                'medical_clearance',
                'police_clearance',
                'other_benefits',
                'experience_years',
            ]);
            $table->text('benefits')->nullable()->change();
        });
    }
};
