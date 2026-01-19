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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // e.g., USD, TZS
            $table->string('name'); // e.g., US Dollar, Tanzanian Shilling
            $table->string('symbol', 10)->nullable(); // e.g., $, TZS
            $table->decimal('exchange_rate', 15, 8)->default(1.00000000); // Conversion rate relative to base currency
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // Seed default currencies
        DB::table('currencies')->insert([
            [
                'code' => 'TZS',
                'name' => 'Tanzanian Shilling',
                'symbol' => 'TZS',
                'exchange_rate' => 1.00000000,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate' => 0.0004, // Approx 1 TZS = 0.0004 USD (or 1 USD = 2500 TZS) - needs dynamic update logic ideally
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
