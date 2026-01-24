<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PublicCandidateController extends Controller
{
    public function index(Request $request)
    {
        // Only show verified candidates
        $query = User::where('role', 'candidate')
            ->whereHas('candidateProfile', function ($q) {
                $q->where('verification_status', 'approved')
                    ->where('is_public', true);
            })
            ->with(['candidateProfile.categories', 'candidateProfile.skills', 'candidateProfile.languages', 'documents' => function($q) {
                $q->where('verification_status', 'approved');
            }]);

        // Search filter (name, skills, or target destination)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('candidateProfile', function ($q) use ($search) {
                        $q->where('target_destination', 'like', "%{$search}%");
                    })
                    ->orWhereHas('candidateProfile.skills', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Job Title filter (matches title or preferred titles)
        if ($request->filled('job_title')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->job_title}%")
                  ->orWhere('headline', 'like', "%{$request->job_title}%")
                  ->orWhereJsonContains('preferred_job_titles', $request->job_title);
            });
        }

        // Skills filter (comma separated)
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
            $query->whereHas('candidateProfile', function($q) use ($request) {
                $q->where('location', 'like', "%{$request->country}%");
            })->orWhere('country', 'like', "%{$request->country}%");
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

        // Passport Status filter
        if ($request->filled('passport_status')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('passport_status', $request->passport_status);
            });
        }

        // Willing to Relocate filter
        if ($request->filled('willing_to_relocate')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('willing_to_relocate', (bool)$request->willing_to_relocate);
            });
        }

        // Language filter
        if ($request->filled('language')) {
            $query->whereHas('candidateProfile.languages', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->language . '%');
            });
        }

        // Medical & Police Clearance filter
        if ($request->filled('clearance_status')) {
            $query->whereHas('candidateProfile', function ($q) use ($request) {
                $q->where('medical_clearance', $request->clearance_status)
                  ->orWhere('police_clearance', $request->clearance_status);
            });
        }

        $candidates = $query->latest()->paginate(20);

        return view('public.candidates.index', compact('candidates'));
    }

    public function searchSkills(Request $request)
    {
        $search = $request->get('q');
        if (strlen($search) < 2) {
            return response()->json([]);
        }
        
        $skills = \App\Models\Skill::where('name', 'like', "%{$search}%")
            ->select('name')
            ->distinct()
            ->limit(10)
            ->get()
            ->pluck('name');
            
        return response()->json($skills);
    }

    public function show(User $candidate)
    {
        // Only show verified candidates
        if (
            $candidate->role !== 'candidate' ||
            !$candidate->candidateProfile ||
            $candidate->candidateProfile->verification_status !== 'approved' ||
            !$candidate->candidateProfile->is_public
        ) {
            abort(404);
        }

        $candidate->load(['candidateProfile.categories', 'candidateProfile.skills', 'candidateProfile.workExperiences', 'candidateProfile.educations', 'candidateProfile.languages', 'documents' => function($q) {
            $q->where('verification_status', 'approved');
        }]);

        return view('public.candidates.show', compact('candidate'));
    }

    public function interviewForm(User $candidate)
    {
        // Only show verified candidates
        if (
            $candidate->role !== 'candidate' ||
            !$candidate->candidateProfile ||
            $candidate->candidateProfile->verification_status !== 'approved'
        ) {
            abort(404);
        }

        return view('public.candidates.interview', compact('candidate'));
    }

    public function submitInterview(Request $request, User $candidate)
    {
        // Verify candidate is verified
        if (
            $candidate->role !== 'candidate' ||
            !$candidate->candidateProfile ||
            $candidate->candidateProfile->verification_status !== 'approved'
        ) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'interviewer_email' => 'required|email|max:255',
            'interviewer_phone' => 'nullable|string|max:20',
            'scheduled_at' => 'required|date|after:now',
            'meeting_mode' => 'required|in:online,in-person',
            'duration_minutes' => 'required|integer|min:15|max:120',
            'meeting_link' => 'required_if:meeting_mode,online|nullable|url',
            'meeting_location' => 'required_if:meeting_mode,in-person|nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'requirements' => 'nullable|string|max:2000',
        ]);

        $appointment = Appointment::create([
            'user_id' => $candidate->id,
            'employer_id' => null, // No employer account needed
            'appointment_type' => 'interview',
            'title' => $validated['title'],
            'company_name' => $validated['company_name'],
            'job_title' => $validated['job_title'],
            'interviewer_email' => $validated['interviewer_email'],
            'interviewer_phone' => $validated['interviewer_phone'] ?? null,
            'meeting_mode' => $validated['meeting_mode'],
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => $validated['duration_minutes'],
            'meeting_link' => $validated['meeting_link'] ?? null,
            'meeting_location' => $validated['meeting_location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'amount' => 0, // Free for employers
            'currency' => 'TZS',
            'payment_status' => 'completed', // Free
            'status' => 'pending', // Waiting for admin approval
        ]);

        return redirect()->route('public.candidates.index')
            ->with('success', 'Interview request submitted successfully! Our admin team will review and contact you at ' . $validated['interviewer_email']);
    }
}
