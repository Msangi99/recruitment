<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;

class CandidateBrowseController extends Controller
{
    public function index(Request $request)
    {
        // Only show verified candidates
        $query = User::where('role', 'candidate')
            ->whereHas('candidateProfile', function($q) {
                $q->where('verification_status', 'approved')
                  ->where('is_public', true);
            })
            ->with(['candidateProfile.skills', 'candidateProfile.languages']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('candidateProfile.skills', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Education filter
        if ($request->filled('education_level')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('education_level', $request->education_level);
            });
        }

        // Experience filter
        if ($request->filled('min_experience')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('years_of_experience', '>=', $request->min_experience);
            });
        }

        $candidates = $query->latest()->paginate(20);

        return view('employer.candidates.index', compact('candidates'));
    }

    public function show(User $candidate)
    {
        // Only show verified candidates
        if ($candidate->role !== 'candidate' || 
            !$candidate->candidateProfile || 
            $candidate->candidateProfile->verification_status !== 'approved' ||
            !$candidate->candidateProfile->is_public) {
            abort(404);
        }

        $candidate->load(['candidateProfile.skills', 'candidateProfile.languages']);
        
        return view('employer.candidates.show', compact('candidate'));
    }
}
