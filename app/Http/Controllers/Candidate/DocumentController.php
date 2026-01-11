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

        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/' . $candidate->id, $fileName, 'private');

        Document::create([
            'user_id' => $candidate->id,
            'document_type' => $validated['document_type'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'verification_status' => 'pending',
        ]);

        return back()->with('success', 'Document uploaded successfully. Waiting for admin verification.');
    }

    public function show(Document $document)
    {
        // Ensure user owns the document
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

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
