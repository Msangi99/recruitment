<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AzamPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AzamPayController extends Controller
{
    protected $azampayService;

    public function __construct(AzamPayService $azampayService)
    {
        $this->azampayService = $azampayService;
    }

    /**
     * Handle AzamPay webhook
     */
    public function webhook(Request $request)
    {
        try {
            $data = $request->all();
            
            Log::info('AzamPay webhook received', $data);

            // Extract external ID from webhook data
            $externalId = $data['externalId'] ?? $data['transactionId'] ?? null;
            
            if (!$externalId) {
                Log::warning('AzamPay webhook missing external ID', $data);
                return response()->json(['error' => 'Missing external ID'], 400);
            }

            // Find appointment by order_id (which should match externalId)
            $appointment = Appointment::where('order_id', $externalId)
                ->orWhere('transaction_id', $externalId)
                ->first();

            if (!$appointment) {
                Log::warning('Appointment not found for AzamPay webhook', [
                    'externalId' => $externalId,
                    'data' => $data,
                ]);
                return response()->json(['error' => 'Appointment not found'], 404);
            }

            // Check payment status
            $status = $data['status'] ?? $data['transactionStatus'] ?? null;
            
            if ($status === 'SUCCESS' || $status === 'COMPLETED') {
                $appointment->update([
                    'payment_status' => 'completed',
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                    'transaction_id' => $externalId,
                ]);

                // Trigger appointment paid event (sends emails)
                event(new \App\Events\AppointmentPaid($appointment));

                Log::info('AzamPay payment processed successfully', [
                    'appointment_id' => $appointment->id,
                    'externalId' => $externalId,
                ]);
            } elseif ($status === 'FAILED' || $status === 'CANCELLED') {
                $appointment->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);

                Log::info('AzamPay payment failed', [
                    'appointment_id' => $appointment->id,
                    'externalId' => $externalId,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('AzamPay webhook exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle payment redirect
     */
    public function redirect(Request $request)
    {
        $externalId = $request->query('externalId') ?? $request->query('transactionId');
        
        if (!$externalId) {
            return redirect()->route('candidate.consultations.index')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        // Verify payment status
        $paymentStatus = $this->azampayService->verifyPayment($externalId);
        
        $appointment = Appointment::where('order_id', $externalId)
            ->orWhere('transaction_id', $externalId)
            ->first();

        if (!$appointment) {
            return redirect()->route('candidate.consultations.index')
                ->with('error', 'Appointment not found.');
        }

        if ($paymentStatus && ($paymentStatus['status'] === 'SUCCESS' || $paymentStatus['status'] === 'COMPLETED')) {
            return redirect()->route('candidate.consultations.show', $appointment)
                ->with('success', 'Payment completed successfully! Your appointment has been confirmed.');
        }

        return redirect()->route('candidate.consultations.show', $appointment)
            ->with('error', 'Payment verification pending. Please wait a moment and refresh.');
    }

    /**
     * Handle payment cancellation
     */
    public function cancel(Request $request)
    {
        $externalId = $request->query('externalId') ?? $request->query('transactionId');
        
        if ($externalId) {
            $appointment = Appointment::where('order_id', $externalId)
                ->orWhere('transaction_id', $externalId)
                ->first();

            if ($appointment) {
                $appointment->update([
                    'payment_status' => 'cancelled',
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
            }
        }

        return redirect()->route('candidate.consultations.index')
            ->with('error', 'Payment was cancelled. You can try again when ready.');
    }
}
