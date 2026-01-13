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
            // Course studied - what the candidate learned in their education
            $table->string('course_studied')->nullable()->after('education_level');
            
            // Experience category - which job category the candidate has experience in
            $table->foreignId('experience_category_id')->nullable()->after('years_of_experience')
                  ->constrained('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropForeign(['experience_category_id']);
            $table->dropColumn(['course_studied', 'experience_category_id']);
        });
    }
};
