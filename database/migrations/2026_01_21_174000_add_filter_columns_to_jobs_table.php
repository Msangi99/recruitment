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
        Schema::table('job_listings', function (Blueprint $table) {
            // Add new filter fields
            $table->string('working_mode')->nullable()->after('employment_type'); // On-site, Remote, Hybrid
            $table->string('industry')->nullable()->after('category_id'); // Construction, Healthcare, Manufacturing, etc.
            $table->boolean('visa_sponsorship')->default(false)->after('languages'); // Yes/No
            $table->string('experience_level')->nullable()->after('experience_required'); // No Experience, Mid-level, Senior
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn(['working_mode', 'industry', 'visa_sponsorship', 'experience_level']);
        });
    }
};
