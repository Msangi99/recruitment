<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * These columns were shadowing the BelongsToMany relationships for skills and languages.
     * Skills and languages are now stored in separate pivot tables:
     * - candidate_profile_skill
     * - candidate_profile_language
     */
    public function up(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            // Drop the old columns that were shadowing the relationships
            if (Schema::hasColumn('candidate_profiles', 'skills')) {
                $table->dropColumn('skills');
            }
            if (Schema::hasColumn('candidate_profiles', 'languages')) {
                $table->dropColumn('languages');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            // Re-add the columns if needed (as JSON for compatibility)
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
        });
    }
};
