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
        
        return view('admin.settings.index', compact('emailSettings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hr_email' => 'nullable|email|max:255',
            'notification_email' => 'nullable|email|max:255',
            'email_notifications_enabled' => 'boolean',
        ]);

        // Update HR Email
        Setting::set('hr_email', $validated['hr_email']);
        
        // Update Notification Email
        Setting::set('notification_email', $validated['notification_email']);
        
        // Update Email Notifications Enabled
        Setting::set('email_notifications_enabled', $request->has('email_notifications_enabled') ? '1' : '0');

        return back()->with('success', 'Settings updated successfully.');
    }
}
