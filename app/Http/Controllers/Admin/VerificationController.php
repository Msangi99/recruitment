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
     * View document (for admins)
     */
    public function viewDocument(Document $document)
    {
        // Check if file exists
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'Document not found');
        }

        // Get file path and determine if it should be displayed inline or downloaded
        $filePath = Storage::disk('private')->path($document->file_path);
        $mimeType = Storage::disk('private')->mimeType($document->file_path);
        
        // For images and PDFs, display inline; for other files, force download
        $disposition = in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']) 
            ? 'inline' 
            : 'attachment';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . $document->file_name . '"',
        ]);
    }
}
