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
        DB::table('settings')->insert([
            [
                'key' => 'package_basic_price',
                'value' => '50000',
                'group' => 'payment',
                'type' => 'number',
                'label' => 'Basic Plan Price',
                'description' => 'The monthly price for the Basic subscription plan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'package_premium_price',
                'value' => '100000',
                'group' => 'payment',
                'type' => 'number',
                'label' => 'Premium Plan Price',
                'description' => 'The monthly price for the Premium subscription plan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['package_basic_price', 'package_premium_price'])->delete();
    }
};
