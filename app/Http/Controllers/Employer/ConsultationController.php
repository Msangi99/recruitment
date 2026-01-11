<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $employer = auth()->user();

        $consultations = Appointment::where('employer_id', $employer->id)
            ->where('appointment_type', 'consultation')
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('employer.consultations.index', compact('consultations'));
    }

    public function create()
    {
        return view('employer.consultations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'meeting_mode' => 'required|in:online,in-person',
            'duration_minutes' => 'required|integer|min:15|max:120',
            'meeting_link' => 'required_if:meeting_mode,online|nullable|url',
            'meeting_location' => 'required_if:meeting_mode,in-person|nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create([
            'user_id' => null, // No specific candidate for free consultation
            'employer_id' => auth()->id(),
            'appointment_type' => 'consultation',
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

        return redirect()->route('employer.consultations.index')
            ->with('success', 'Free consultation requested. Waiting for admin approval.');
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->employer_id !== auth()->id() || $appointment->appointment_type !== 'consultation') {
            abort(403);
        }

        return view('employer.consultations.show', compact('appointment'));
    }
}
