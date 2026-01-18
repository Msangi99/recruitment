<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Show pending verifications
     */
    public function pending()
    {
        $pendingProfiles = CandidateProfile::where('verification_status', 'pending')
            ->with(['user', 'user.documents'])
            ->latest()
            ->paginate(20);

        return view('admin.verification.pending', compact('pendingProfiles'));
    }

    /**
     * Verify candidate profile
     */
    public function verifyProfile(Request $request, CandidateProfile $profile)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $profile->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
            'admin_notes' => $request->admin_notes,
            'is_public' => true,
        ]);

        return back()->with('success', 'Candidate profile verified successfully.');
    }

    /**
     * Reject candidate profile
     */
    public function rejectProfile(Request $request, CandidateProfile $profile)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $profile->update([
            'verification_status' => 'rejected',
            'admin_notes' => $request->rejection_reason,
            'is_public' => false,
        ]);

        return back()->with('success', 'Candidate profile rejected.');
    }

    /**
     * Verify document
     */
    public function verifyDocument(Request $request, Document $document)
    {
        $document->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        return back()->with('success', 'Document verified successfully.');
    }

    /**
     * Reject document
     */
    public function rejectDocument(Request $request, Document $document)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $document->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Document rejected.');
    }

    /**
     * Update document status
     */
    public function updateDocumentStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $status = $request->status;
        $data = ['verification_status' => $status];

        if ($status === 'approved') {
            $data['verified_at'] = now();
            $data['verified_by'] = auth()->id();
            $data['rejection_reason'] = null;
        } elseif ($status === 'rejected') {
            // If rejected, we might want a reason, but from a simple select, maybe not mandatory or needs a separate input.
            // keeping it optional for now or clearing it if previously approved.
             $data['verified_at'] = null;
             $data['verified_by'] = null;
        } else {
             $data['verified_at'] = null;
             $data['verified_by'] = null;
             $data['rejection_reason'] = null;
        }

        $document->update($data);

        return back()->with('success', 'Document status updated to ' . ucfirst($status) . '.');
    }

    /**
     * View document (for admins)
     */
    public function viewDocument(Document $document)
    {
        \Log::info('Admin viewing document', [
            'admin_id' => auth()->id(),
            'admin_role' => auth()->user()->role,
            'document_id' => $document->id,
            'document_path' => $document->file_path,
            'user_id' => $document->user_id,
        ]);

        // Redirect to public URL (like profile pictures)
        return redirect(asset($document->file_path));
    }
}
