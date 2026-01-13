<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'document_type' => 'required|in:cv,id,passport,certificate,other',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
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

            Document::create([
                'user_id' => $candidate->id,
                'document_type' => $validated['document_type'],
                'file_name' => $cleanName,
                'file_path' => $filePath,
                'file_type' => $mimeType,
                'file_size' => $fileSize,
                'verification_status' => 'pending',
            ]);

            return back()->with('success', 'Document uploaded successfully. Waiting for admin verification.');
            
        } catch (\Exception $e) {
            \Log::error('Document upload failed', [
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

        // Delete file from storage
        if (Storage::disk('private')->exists($document->file_path)) {
            Storage::disk('private')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
