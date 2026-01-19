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

        return view('admin.settings.index', compact('emailSettings', 'skills', 'languages'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hr_email' => 'nullable|email|max:255',
            'notification_email' => 'nullable|email|max:255',
            'email_notifications_enabled' => 'boolean',
            'package_basic_price' => 'nullable|numeric|min:0',
            'package_premium_price' => 'nullable|numeric|min:0',
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
}
