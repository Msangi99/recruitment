<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // Search by name, email, or subject
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(20);
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contact-messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display a specific contact message.
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewing
        if (!$contactMessage->is_read) {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Send reply to the contact message
     */
    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'reply_subject' => 'required|string|max:255',
            'reply_message' => 'required|string|max:5000',
        ]);

        try {
            // Send reply email
            Mail::send('emails.contact-reply', [
                'recipientName' => $contactMessage->name,
                'originalSubject' => $contactMessage->subject,
                'originalMessage' => $contactMessage->message,
                'replyMessage' => $validated['reply_message'],
            ], function ($message) use ($contactMessage, $validated) {
                $message->to($contactMessage->email, $contactMessage->name)
                    ->subject($validated['reply_subject']);
            });

            // Mark as replied
            $contactMessage->markAsReplied();

            // Add to admin notes
            $noteTimestamp = now()->format('M d, Y h:i A');
            $newNote = "--- Reply sent on {$noteTimestamp} ---\n";
            $newNote .= "Subject: {$validated['reply_subject']}\n";
            $newNote .= "Message: {$validated['reply_message']}\n";
            $newNote .= "---\n\n";
            
            $contactMessage->update([
                'admin_notes' => $newNote . ($contactMessage->admin_notes ?? ''),
            ]);

            Log::info('Contact reply sent', [
                'message_id' => $contactMessage->id,
                'to' => $contactMessage->email,
                'subject' => $validated['reply_subject'],
            ]);

            return back()->with('success', 'Reply sent successfully to ' . $contactMessage->email);
        } catch (\Exception $e) {
            Log::error('Failed to send contact reply: ' . $e->getMessage());
            return back()->with('error', 'Failed to send reply. Please check mail configuration. Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update admin notes
     */
    public function updateNotes(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $contactMessage->update($validated);

        return back()->with('success', 'Notes updated successfully.');
    }

    /**
     * Delete a contact message.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
