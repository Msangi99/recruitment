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
        Schema::table('candidate_profile_language', function (Blueprint $table) {
            $table->string('proficiency')->default('Basic')->after('language_id'); // Basic, Conversational, Fluent, Native
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profile_language', function (Blueprint $table) {
            //
        });
    }
};
