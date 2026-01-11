<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\Document;
use Illuminate\Http\Request;

class CandidateManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'candidate')
            ->with('candidateProfile');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Verification status filter
        if ($request->filled('verification_status')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('verification_status', $request->verification_status);
            });
        }

        $candidates = $query->latest()->paginate(20);

        return view('admin.candidates.index', compact('candidates'));
    }

    public function show(User $candidate)
    {
        if ($candidate->role !== 'candidate') {
            abort(404);
        }

        $candidate->load(['candidateProfile', 'documents']);
        
        return view('admin.candidates.show', compact('candidate'));
    }

    public function updateStatus(Request $request, User $candidate)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $candidate->update([
            'is_active' => $request->is_active,
        ]);

        return back()->with('success', 'Candidate status updated successfully.');
    }
}
