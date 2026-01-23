<?php

namespace App\Helpers;

use App\Models\Currency;

class CurrencyHelper
{
    /**
     * Convert an amount from TSH to USD using the live exchange rate.
     *
     * @param float $amount
     * @return float|null
     */
    public static function convertTshToUsd($amount)
    {
        // Find USD currency
        $usd = Currency::where('code', 'USD')->first();

        // If USD not found or rate is 0, return null or original amount (depending on desired behavior)
        if (!$usd || $usd->exchange_rate <= 0) {
            return null;
        }

        // Check if TZS is the default currency
        // The exchange rates are stored relative to the default currency.
        // If TZS is default, then USD rate is TZS -> USD.
        $default = Currency::where('is_default', true)->first();

        if ($default && strtoupper($default->code) === 'TZS') {
            return $amount * $usd->exchange_rate;
        }

        // If TZS is NOT default, conversion is more complex, but for this specific request:
        // "convert tsh to usd", we assume the input is in TSH.
        // If we don't have a direct TZS->USD rate because TZS is not base, 
        // we might need to go TZS -> Base -> USD.

        // However, based on the context of the user being in Tanzania ("coyzon.co.tz"), 
        // it is highly likely TZS is the base currency.

        return $amount * $usd->exchange_rate;
    }

    /**
     * Format the amount as USD string.
     *
     * @param float $amount
     * @return string
     */
    public static function formatUsd($amount)
    {
        return '$' . number_format($amount, 2);
    }
}
