<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileSettingsController extends Controller
{
    /**
     * Show the profile settings page.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Return appropriate view based on user role
        switch ($user->role) {
            case 'admin':
                return view('admin.profile.settings', compact('user'));
            case 'candidate':
                return view('candidate.profile.settings', compact('user'));
            case 'employer':
                return view('employer.profile.settings', compact('user'));
            default:
                abort(403, 'Unauthorized access');
        }
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Update user email.
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['required', 'current_password'],
        ]);

        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Email updated successfully!');
    }

    /**
     * Update user phone.
     */
    public function updatePhone(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'current_password' => ['required', 'current_password'],
        ]);

        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Phone number updated successfully!');
    }
}
