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
            ->with('candidateProfile');

        // Search filter (name or skills)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('candidateProfile', function($q) use ($search) {
                $q->where('skills', 'like', "%{$search}%")
                  ->orWhere('target_destination', 'like', "%{$search}%");
            });
        }

        // Country filter
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Target destination filter (where they want to work)
        if ($request->filled('target_destination')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('target_destination', 'like', "%{$request->target_destination}%");
            });
        }

        // Education level filter
        if ($request->filled('education_level')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('education_level', $request->education_level);
            });
        }

        // Language spoken filter
        if ($request->filled('language')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->whereJsonContains('languages', $request->language);
            });
        }

        // Years of experience filter (min)
        if ($request->filled('min_experience')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('years_of_experience', '>=', $request->min_experience);
            });
        }

        // Years of experience filter (max)
        if ($request->filled('max_experience')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('years_of_experience', '<=', $request->max_experience);
            });
        }

        // Availability status filter
        if ($request->filled('availability')) {
            $isAvailable = $request->availability === 'available';
            $query->whereHas('candidateProfile', function($q) use ($isAvailable) {
                $q->where('is_available', $isAvailable);
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        // Age range filter
        if ($request->filled('min_age') || $request->filled('max_age')) {
            $query->whereHas('candidateProfile', function($q) use ($request) {
                if ($request->filled('min_age')) {
                    $maxDate = now()->subYears($request->min_age)->format('Y-m-d');
                    $q->where('date_of_birth', '<=', $maxDate);
                }
                if ($request->filled('max_age')) {
                    $minDate = now()->subYears($request->max_age + 1)->addDay()->format('Y-m-d');
                    $q->where('date_of_birth', '>=', $minDate);
                }
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

        $candidate->load('candidateProfile');
        
        return view('employer.candidates.show', compact('candidate'));
    }
}
