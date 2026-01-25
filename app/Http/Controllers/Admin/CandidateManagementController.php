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

        // Job Title filter
        if ($request->filled('job_title')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->job_title}%")
                  ->orWhere('headline', 'like', "%{$request->job_title}%");
            });
        }

        // Skills filter
        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
            $query->whereHas('candidateProfile.skills', function ($q) use ($skills) {
                $q->whereIn('name', $skills);
            });
        }

        // Experience Level filter
        if ($request->filled('experience_level')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('experience_level', $request->experience_level);
            });
        }

        // Current Location filter
        if ($request->filled('country')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('candidateProfile', function($sq) use ($request) {
                    $sq->where('location', 'like', "%{$request->country}%");
                })->orWhere('country', 'like', "%{$request->country}%");
            });
        }

        // Target Destination filter
        if ($request->filled('target_destination')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('target_destination', 'like', "%{$request->target_destination}%");
            });
        }

        // Availability Status filter
        if ($request->filled('availability_status')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('availability_status', $request->availability_status);
            });
        }

        // Verification status filter
        if ($request->filled('verification_status')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('verification_status', $request->verification_status);
            });
        }

        // Status (active/inactive) filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $candidates = $query->latest()->paginate(20)->withQueryString();

        return view('admin.candidates.index', compact('candidates'));
    }

    public function show(User $candidate)
    {
        if ($candidate->role !== 'candidate') {
            abort(404);
        }

        $candidate->load(['candidateProfile.experienceCategory', 'candidateProfile.skills', 'candidateProfile.languages', 'documents']);
        
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
