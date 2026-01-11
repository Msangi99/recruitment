<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::whereNotNull('amount')
            ->with(['user', 'employer']);

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total_revenue' => Appointment::where('payment_status', 'completed')->sum('amount'),
            'pending_payments' => Appointment::where('payment_status', 'pending')->count(),
            'completed_payments' => Appointment::where('payment_status', 'completed')->count(),
            'failed_payments' => Appointment::where('payment_status', 'failed')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'employer']);
        return view('admin.payments.show', compact('appointment'));
    }
}
