<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            [
                'key' => 'mail_config_enabled',
                'value' => '0',
                'group' => 'email',
                'type' => 'boolean',
                'label' => 'Use admin SMTP',
                'description' => 'When enabled, the mail transport options below override .env values at runtime',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_mailer',
                'value' => 'smtp',
                'group' => 'email',
                'type' => 'text',
                'label' => 'Default mailer',
                'description' => 'Laravel mail driver (smtp, log, array)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_host',
                'value' => null,
                'group' => 'email',
                'type' => 'text',
                'label' => 'SMTP host',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_port',
                'value' => '587',
                'group' => 'email',
                'type' => 'text',
                'label' => 'SMTP port',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_username',
                'value' => null,
                'group' => 'email',
                'type' => 'text',
                'label' => 'SMTP username',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_password',
                'value' => null,
                'group' => 'email',
                'type' => 'text',
                'label' => 'SMTP password',
                'description' => 'Stored encrypted when saved from admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'group' => 'email',
                'type' => 'text',
                'label' => 'Encryption',
                'description' => 'tls, ssl, or empty for none',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_from_address',
                'value' => null,
                'group' => 'email',
                'type' => 'email',
                'label' => 'From address',
                'description' => 'Default sender address',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_from_name',
                'value' => null,
                'group' => 'email',
                'type' => 'text',
                'label' => 'From name',
                'description' => 'Default sender name',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($rows as $row) {
            if (!DB::table('settings')->where('key', $row['key'])->exists()) {
                DB::table('settings')->insert($row);
            }
        }
    }

    public function down(): void
    {
        $keys = [
            'mail_config_enabled', 'mail_mailer', 'mail_host', 'mail_port', 'mail_username',
            'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name',
        ];
        DB::table('settings')->whereIn('key', $keys)->delete();
    }
};
