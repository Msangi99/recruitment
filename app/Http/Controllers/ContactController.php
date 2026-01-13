<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Save to database
            $contactMessage = ContactMessage::create($validated);

            // Log the contact message
            Log::info('Contact form submission', [
                'id' => $contactMessage->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
            ]);

            // Try to send email notification to admin (optional, won't fail if mail not configured)
            try {
                Mail::send('emails.contact', $validated, function ($message) use ($validated) {
                    $message->to(config('mail.admin_email', 'info@implore.com'))
                        ->subject('Contact Form: ' . $validated['subject'])
                        ->replyTo($validated['email'], $validated['name']);
                });
            } catch (\Exception $e) {
                // Email failed but message is saved in database, so just log
                Log::warning('Contact email notification failed: ' . $e->getMessage());
            }

            return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred. Please try again or email us directly at info@implore.com')->withInput();
        }
    }
}
