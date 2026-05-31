<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ConsultationRequest;
use App\Support\AdminPaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentManagementController extends Controller
{
    public function index(Request $request)
    {
        $appointmentQuery = Appointment::whereNotNull('amount')
            ->with(['user', 'employer']);

        $consultationQuery = ConsultationRequest::query()
            ->whereNotNull('amount')
            ->where('amount', '>', 0);

        if ($request->filled('payment_status')) {
            $appointmentStatuses = AdminPaymentTransaction::appointmentStatusFilter($request->payment_status);
            $consultationStatuses = AdminPaymentTransaction::consultationStatusFilter($request->payment_status);

            if ($appointmentStatuses) {
                $appointmentQuery->whereIn('payment_status', $appointmentStatuses);
            }

            if ($consultationStatuses) {
                $consultationQuery->whereIn('payment_status', $consultationStatuses);
            }
        }

        if ($request->filled('date_from')) {
            $appointmentQuery->whereDate('created_at', '>=', $request->date_from);
            $consultationQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $appointmentQuery->whereDate('created_at', '<=', $request->date_to);
            $consultationQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $appointmentQuery->get()
            ->map(fn (Appointment $appointment) => AdminPaymentTransaction::fromAppointment($appointment))
            ->concat(
                $consultationQuery->get()
                    ->map(fn (ConsultationRequest $consultation) => AdminPaymentTransaction::fromConsultationRequest($consultation))
            )
            ->sortByDesc(fn (AdminPaymentTransaction $transaction) => $transaction->created_at)
            ->values();

        $page = max(1, (int) $request->get('page', 1));
        $perPage = 20;
        $payments = new LengthAwarePaginator(
            $transactions->slice(($page - 1) * $perPage, $perPage)->values(),
            $transactions->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $stats = [
            'total_revenue' => Appointment::where('payment_status', 'completed')->sum('amount')
                + ConsultationRequest::where('payment_status', 'paid')->sum('amount'),
            'pending_payments' => Appointment::where('payment_status', 'pending')->count()
                + ConsultationRequest::whereIn('payment_status', ['pending', 'processing'])->count(),
            'completed_payments' => Appointment::where('payment_status', 'completed')->count()
                + ConsultationRequest::where('payment_status', 'paid')->count(),
            'failed_payments' => Appointment::where('payment_status', 'failed')->count()
                + ConsultationRequest::where('payment_status', 'failed')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function show(string $source, int $id)
    {
        if ($source === 'appointment') {
            $record = Appointment::with(['user', 'employer'])->findOrFail($id);
            $transaction = AdminPaymentTransaction::fromAppointment($record);

            return view('admin.payments.show', compact('transaction', 'record', 'source'));
        }

        if ($source === 'consultation') {
            $record = ConsultationRequest::findOrFail($id);
            $transaction = AdminPaymentTransaction::fromConsultationRequest($record);

            return view('admin.payments.show', compact('transaction', 'record', 'source'));
        }

        abort(404);
    }
}
