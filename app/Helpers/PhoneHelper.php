<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * Normalize a Tanzania mobile number to local format (starting with 0).
     */
    public static function toLocalFormat(?string $phone): ?string
    {
        if ($phone === null || trim($phone) === '') {
            return $phone;
        }

        $digits = preg_replace('/\D/', '', $phone);

        if ($digits === '') {
            return $phone;
        }

        if (str_starts_with($digits, '255')) {
            return '0' . substr($digits, 3);
        }

        if (! str_starts_with($digits, '0') && strlen($digits) === 9) {
            return '0' . $digits;
        }

        return $digits;
    }
}
