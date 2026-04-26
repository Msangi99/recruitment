<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting.{$key}");
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group)
    {
        return self::where('group', $group)->get();
    }

    /**
     * Get HR email for interview notifications
     */
    public static function getHrEmail(): ?string
    {
        return self::get('hr_email');
    }

    /**
     * Check if email notifications are enabled
     */
    public static function emailNotificationsEnabled(): bool
    {
        return (bool) self::get('email_notifications_enabled', true);
    }

    /**
     * Decrypt SMTP password stored in settings (if present).
     */
    public static function getDecryptedMailPassword(): ?string
    {
        $raw = self::get('mail_password');
        if (!is_string($raw) || $raw === '') {
            return null;
        }
        try {
            return Crypt::decryptString($raw);
        } catch (\Throwable) {
            return null;
        }
    }

    public static function isMailConfigFromDatabaseEnabled(): bool
    {
        return self::get('mail_config_enabled', '0') === '1';
    }
}
