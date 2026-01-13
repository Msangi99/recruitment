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

        return view('public.candidates.index', compact('candidates'));
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
        
        return view('public.candidates.show', compact('candidate'));
    }

    public function interviewForm(User $candidate)
    {
        // Only show verified candidates
        if ($candidate->role !== 'candidate' || 
            !$candidate->candidateProfile || 
            $candidate->candidateProfile->verification_status !== 'approved') {
            abort(404);
        }

        return view('public.candidates.interview', compact('candidate'));
    }

    public function submitInterview(Request $request, User $candidate)
    {
        // Verify candidate is verified
        if ($candidate->role !== 'candidate' || 
            !$candidate->candidateProfile || 
            $candidate->candidateProfile->verification_status !== 'approved') {
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
