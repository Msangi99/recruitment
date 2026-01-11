<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Bryceandy\Selcom\Facades\Selcom;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $candidate = auth()->user();

        $consultations = Appointment::where('user_id', $candidate->id)
            ->where('appointment_type', 'consultation')
            ->latest()
            ->paginate(20);

        return view('candidate.consultations.index', compact('consultations'));
    }

    public function create()
    {
        return view('candidate.consultations.create');
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

        $candidate = auth()->user();

        // Create appointment
        $appointment = Appointment::create([
            'user_id' => $candidate->id,
            'employer_id' => null,
            'appointment_type' => 'consultation',
            'meeting_mode' => $validated['meeting_mode'],
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => $validated['duration_minutes'],
            'meeting_link' => $validated['meeting_link'] ?? null,
            'meeting_location' => $validated['meeting_location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'amount' => 30000, // TZS 30,000 or $12
            'currency' => 'TZS',
            'payment_status' => 'pending',
            'status' => 'pending',
            'order_id' => 'CONSULT-' . time() . '-' . $candidate->id,
        ]);

        // Initiate payment
        try {
            $checkout = Selcom::checkout([
                'name' => $candidate->name,
                'email' => $candidate->email,
                'phone' => $candidate->phone ?? '255000000000',
                'amount' => 30000,
                'transaction_id' => $appointment->order_id,
                'no_redirection' => false,
            ]);

            return redirect($checkout['payment_url']);
        } catch (\Exception $e) {
            $appointment->delete();
            return back()->with('error', 'Payment initialization failed. Please try again.');
        }
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->user_id !== auth()->id() || $appointment->appointment_type !== 'consultation') {
            abort(403);
        }

        return view('candidate.consultations.show', compact('appointment'));
    }
}
