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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, email, payment, etc.
            $table->string('type')->default('text'); // text, email, boolean, json
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'hr_email',
                'value' => null,
                'group' => 'email',
                'type' => 'email',
                'label' => 'HR Email',
                'description' => 'Email address to receive all interview requests from employers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'notification_email',
                'value' => null,
                'group' => 'email',
                'type' => 'email',
                'label' => 'Notification Email',
                'description' => 'Email address for system notifications',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'email_notifications_enabled',
                'value' => '1',
                'group' => 'email',
                'type' => 'boolean',
                'label' => 'Enable Email Notifications',
                'description' => 'Enable or disable all email notifications',
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
        Schema::dropIfExists('settings');
    }
};
