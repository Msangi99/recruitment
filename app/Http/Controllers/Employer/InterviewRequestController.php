<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class InterviewRequestController extends Controller
{
    public function index()
    {
        $employer = auth()->user();

        $interviewRequests = Appointment::where('employer_id', $employer->id)
            ->where('appointment_type', 'interview')
            ->with(['user', 'user.candidateProfile'])
            ->latest()
            ->paginate(20);

        return view('employer.interviews.index', compact('interviewRequests'));
    }

    public function create(User $candidate)
    {
        // Verify candidate is verified
        if ($candidate->role !== 'candidate' || 
            !$candidate->candidateProfile || 
            $candidate->candidateProfile->verification_status !== 'approved') {
            abort(404);
        }

        return view('employer.interviews.create', compact('candidate'));
    }

    public function store(Request $request, User $candidate)
    {
        // Verify candidate is verified
        if ($candidate->role !== 'candidate' || 
            !$candidate->candidateProfile || 
            $candidate->candidateProfile->verification_status !== 'approved') {
            abort(404);
        }

        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'meeting_mode' => 'required|in:online,in-person',
            'duration_minutes' => 'required|integer|min:15|max:120',
            'meeting_link' => 'required_if:meeting_mode,online|nullable|url',
            'meeting_location' => 'required_if:meeting_mode,in-person|nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create([
            'user_id' => $candidate->id,
            'employer_id' => auth()->id(),
            'appointment_type' => 'interview',
            'meeting_mode' => $validated['meeting_mode'],
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => $validated['duration_minutes'],
            'meeting_link' => $validated['meeting_link'] ?? null,
            'meeting_location' => $validated['meeting_location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'amount' => 0, // Free for employers
            'currency' => 'TZS',
            'payment_status' => 'completed', // Free
            'status' => 'pending', // Waiting for admin approval
        ]);

        return redirect()->route('employer.interviews.index')
            ->with('success', 'Interview request submitted. Waiting for admin approval.');
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->employer_id !== auth()->id() || $appointment->appointment_type !== 'interview') {
            abort(403);
        }

        $appointment->load(['user', 'user.candidateProfile']);
        return view('employer.interviews.show', compact('appointment'));
    }
}
