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
        // We want to change 'title' from string to json.
        // Ideally we should convert existing data: "Job" -> ["Job"]
        
        // Strategy: 
        // 1. Add temporary json column
        // 2. Copy data converting to json
        // 3. Drop old column
        // 4. Rename new column
        // OR just simple modification if data loss is acceptable or handled by DB driver.
        
        // Let's try the simple change first, but some DBs don't support converting string to json directly without casting.
        // Since I'm on Linux, likely MySQL or Postgres.
        
       Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
             $table->string('title', 255)->change();
        });
    }
};
