<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'employer']);

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('appointment_type', $request->type);
        }

        $appointments = $query->latest()->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'employer']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'confirmed') {
            $updateData['confirmed_at'] = now();
        } elseif ($request->status === 'completed') {
            $updateData['completed_at'] = now();
        } elseif ($request->status === 'cancelled') {
            $updateData['cancelled_at'] = now();
            $updateData['cancellation_reason'] = $request->notes;
        }

        if ($request->filled('notes') && $request->status !== 'cancelled') {
            $updateData['notes'] = $request->notes;
        }

        $appointment->update($updateData);

        return back()->with('success', 'Appointment status updated successfully.');
    }
}
