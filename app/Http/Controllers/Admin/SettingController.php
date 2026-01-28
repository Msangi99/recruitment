<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $emailSettings = Setting::getByGroup('email');
        $skills = \App\Models\Skill::orderBy('name')->get();
        $languages = \App\Models\Language::orderBy('name')->get();
        $currencies = \App\Models\Currency::orderBy('code')->get();
        $jobTitles = \App\Models\JobTitle::orderBy('name')->get();

        return view('admin.settings.index', compact('emailSettings', 'skills', 'languages', 'currencies', 'jobTitles'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hr_email' => 'nullable|email|max:255',
            'notification_email' => 'nullable|email|max:255',
            'email_notifications_enabled' => 'boolean',
            'package_basic_price' => 'nullable|numeric|min:0',
            'package_premium_price' => 'nullable|numeric|min:0',
            'consultation_price' => 'nullable|numeric|min:0',
            'google_calendar_id' => 'nullable|string|max:255',
            'google_client_id' => 'nullable|string|max:255',
            'google_client_secret' => 'nullable|string|max:255',
            'google_refresh_token' => 'nullable|string',
        ]);

        // Update HR Email
        Setting::set('hr_email', $validated['hr_email']);

        // Update Notification Email
        Setting::set('notification_email', $validated['notification_email']);

        // Update Email Notifications Enabled
        Setting::set('email_notifications_enabled', $request->has('email_notifications_enabled') ? '1' : '0');

        // Update Package Prices
        if ($request->has('package_basic_price')) {
            Setting::set('package_basic_price', $request->package_basic_price);
        }
        if ($request->has('package_premium_price')) {
            Setting::set('package_premium_price', $request->package_premium_price);
        }

        // Update Consultation Price
        if ($request->has('consultation_price')) {
            Setting::set('consultation_price', $request->consultation_price);
        }

        // Update Google Calendar Settings
        if ($request->has('google_calendar_id')) Setting::set('google_calendar_id', $request->google_calendar_id);
        if ($request->has('google_client_id')) Setting::set('google_client_id', $request->google_client_id);
        if ($request->has('google_client_secret')) Setting::set('google_client_secret', $request->google_client_secret);
        if ($request->has('google_refresh_token')) Setting::set('google_refresh_token', $request->google_refresh_token);

        return back()->with('success', 'Settings updated successfully.');
    }

    public function addSkill(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:skills,name']);
        \App\Models\Skill::create($request->only('name'));
        return back()->with('success', 'Skill added successfully.');
    }

    public function deleteSkill(\App\Models\Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill removed successfully.');
    }

    public function addJobTitle(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:job_titles,name']);
        \App\Models\JobTitle::create($request->only('name'));
        return back()->with('success', 'Job title added successfully.');
    }

    public function deleteJobTitle(\App\Models\JobTitle $jobTitle)
    {
        $jobTitle->delete();
        return back()->with('success', 'Job title removed successfully.');
    }

    public function addLanguage(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:languages,name']);
        \App\Models\Language::create($request->only('name'));
        return back()->with('success', 'Language added successfully.');
    }
    public function deleteLanguage(\App\Models\Language $language)
    {
        $language->delete();
        return back()->with('success', 'Language removed successfully.');
    }

    // Currency Management Methods

    public function addCurrency(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code',
            'name' => 'required|string|max:100',
            'symbol' => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        \App\Models\Currency::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'symbol' => $validated['symbol'],
            'exchange_rate' => $validated['exchange_rate'],
            'is_default' => false, // New currencies are not default by default
        ]);

        return back()->with('success', 'Currency added successfully.');
    }

    public function deleteCurrency(\App\Models\Currency $currency)
    {
        if ($currency->is_default) {
            return back()->with('error', 'Cannot delete the default currency.');
        }

        $currency->delete();
        return back()->with('success', 'Currency removed successfully.');
    }

    public function setDefaultCurrency(\App\Models\Currency $currency)
    {
        // Unset current default
        \App\Models\Currency::where('is_default', true)->update(['is_default' => false]);

        // Set new default
        $currency->update(['is_default' => true]);

        return back()->with('success', 'Default currency updated successfully.');
    }

    public function updateCurrencyRate(Request $request, \App\Models\Currency $currency)
    {
        $request->validate(['exchange_rate' => 'required|numeric|min:0']);
        $currency->update(['exchange_rate' => $request->exchange_rate]);
        return back()->with('success', 'Exchange rate updated successfully.');
    }

    public function updateExchangeRates()
    {
        $defaultCurrency = \App\Models\Currency::where('is_default', true)->first();
        if (!$defaultCurrency) {
            return back()->with('error', 'No default currency set. Please set a default currency first.');
        }

        $code = strtolower($defaultCurrency->code);
        $url = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/{$code}.json";

        try {
            $response = \Illuminate\Support\Facades\Http::get($url);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (!isset($data[$code])) {
                     return back()->with('error', "Invalid API response. Could not find rates for {$code}.");
                }

                $rates = $data[$code];
                $updatedCount = 0;

                // Get all non-default currencies
                $currencies = \App\Models\Currency::where('id', '!=', $defaultCurrency->id)->get();
                
                foreach ($currencies as $currency) {
                    $currencyCodeLower = strtolower($currency->code);
                    if (isset($rates[$currencyCodeLower])) {
                        // The API returns "how much of target currency for 1 base currency"
                        // My DB stores "exchange_rate" as value relative to base.
                        // Example: Base TZS. Target USD.
                        // API TZS->USD: 0.0004.
                        // DB: TZS is default (1.0). USD row exchange_rate should be 0.0004.
                        // So direct assignment is correct.
                        $currency->update(['exchange_rate' => $rates[$currencyCodeLower]]);
                        $updatedCount++;
                    }
                }

                return back()->with('success', "Exchange rates updated successfully via API. ({$updatedCount} currencies updated)");
            }
            
            return back()->with('error', 'Failed to fetch exchange rates from API. Status: ' . $response->status());
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating exchange rates: ' . $e->getMessage());
        }
    }
}
