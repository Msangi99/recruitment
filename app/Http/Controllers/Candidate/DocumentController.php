<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function index()
    {
        $candidate = auth()->user();
        $documents = $candidate->documents()->latest()->get();

        return view('candidate.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:cv,id,passport,certificate,video_cv,other',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mov,avi,wmv|max:20480', // 20MB max
        ]);

        $candidate = auth()->user();

        if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
            return back()->withErrors(['document' => 'Invalid file upload. Please try again.'])->withInput();
        }

        $file = $request->file('document');
        
        // Get file info before moving
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();
        
        // Clean filename - replace spaces and special characters with underscores
        $cleanName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName);
        $fileName = time() . '_' . $cleanName;
        
        // Store in public/documents folder (like profile pictures)
        $destinationPath = public_path('documents/' . $candidate->id);
        
        // Create directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        try {
            // Move file to public folder
            $file->move($destinationPath, $fileName);
            
            // Store relative path for database (without public/)
            $filePath = 'documents/' . $candidate->id . '/' . $fileName;

            // Handle Video CV special case - sync with CandidateProfile
            if ($validated['document_type'] === 'video_cv') {
                // Change destination path for Video CV to match Wizard
                $videoPath = public_path('uploads/video_cvs');
                if (!file_exists($videoPath)) {
                    mkdir($videoPath, 0755, true);
                }
                
                // If it was already moved to documents/, move it to uploads/video_cvs/
                rename($destinationPath . '/' . $fileName, $videoPath . '/' . $fileName);
                $filePath = 'uploads/video_cvs/' . $fileName;

                // Update the candidate profile field
                if ($candidate->candidateProfile) {
                    $candidate->candidateProfile->update(['video_cv' => $fileName]);
                }
            }

            Document::create([
                'user_id' => $candidate->id,
                'document_type' => $validated['document_type'],
                'file_name' => $cleanName,
                'file_path' => $filePath,
                'file_type' => $mimeType,
                'file_size' => $fileSize,
                'verification_status' => 'pending',
            ]);

            // Auto-link to profile if it is a Video CV
            if ($validated['document_type'] === 'video_cv') {
                $candidate->candidateProfile()->update([
                    'video_cv' => $filePath
                ]);
            }


            return back()->with('success', 'Document uploaded successfully. Waiting for admin verification.');
            
        } catch (\Exception $e) {
            Log::error('Document upload failed', [
                'user_id' => $candidate->id,
                'error' => $e->getMessage(),
                'file_name' => $originalName,
            ]);
            
            return back()->withErrors(['document' => 'Failed to upload document. Please try again.'])->withInput();
        }
    }

    public function show(Document $document)
    {
        // Ensure user owns the document
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        // Redirect to public URL (like profile pictures)
        return redirect(asset($document->file_path));
    }

    public function destroy(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete file from public storage
        $absolutePath = public_path($document->file_path);
        if (file_exists($absolutePath)) {
            unlink($absolutePath);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
