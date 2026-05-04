<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Services\AzamPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AzamPayController extends Controller
{
    protected $azampayService;

    public function __construct(AzamPayService $azampayService)
    {
        $this->azampayService = $azampayService;
    }

    /**
     * Handle AzamPay webhook
     * 
     * Callback fields per API docs:
     *   utilityref, externalreference, transactionstatus, operator,
     *   reference, transid, msisdn, amount, message, signature
     */
    public function webhook(Request $request)
    {
        try {
            $data = $request->all();
            $requestLogContext = $this->buildCallbackLogContext($request, $data);
            Log::info('AzamPay webhook received', $requestLogContext);

            // Optional shared-secret validation for callback endpoint.
            // Some AzamPay callbacks do not include token fields.
            $expectedToken = $this->azampayService->getCallbackToken();
            if ($expectedToken) {
                $providedToken = $request->header('X-AzamPay-Token')
                    ?? $request->header('X-Callback-Token')
                    ?? ($data['token'] ?? null);

                if (is_string($providedToken) && $providedToken !== '') {
                    if (!hash_equals($expectedToken, $providedToken)) {
                        Log::warning('AzamPay webhook: invalid callback token', $requestLogContext);
                        return response()->json(['error' => 'Invalid callback token'], 401);
                    }
                } else {
                    Log::notice('AzamPay webhook: callback token missing, continuing with signature checks', $requestLogContext);
                }
            }

            // Verify RSA signature if present
            $signature = $data['signature'] ?? null;
            $utilityref = $data['utilityref'] ?? null;
            $externalreference = $data['externalreference'] ?? null;
            $transactionstatus = $data['transactionstatus'] ?? null;
            $operator = $data['operator'] ?? null;

            if ($signature && $utilityref && $externalreference && $transactionstatus && $operator) {
                $isValid = $this->azampayService->verifyWebhookSignature(
                    $utilityref,
                    $externalreference,
                    $transactionstatus,
                    $operator,
                    $signature
                );

                if (!$isValid) {
                    Log::warning('AzamPay webhook: Invalid signature', [
                        'utilityref' => $utilityref,
                        'externalreference' => $externalreference,
                        'request' => $requestLogContext,
                    ]);
                    return response()->json(['error' => 'Invalid signature'], 401);
                }
            } else {
                Log::warning('AzamPay webhook: Missing signature fields (allowing in sandbox)', [
                    'data_keys' => array_keys($data),
                    'request' => $requestLogContext,
                ]);
            }

            // Resolve the partner record to update
            $resolved = $this->resolvePaymentRecord($utilityref, $externalreference, $data);
            if (!$resolved) {
                Log::warning('AzamPay webhook: Could not resolve payment record', [
                    'utilityref' => $utilityref,
                    'externalreference' => $externalreference,
                    'request' => $requestLogContext,
                ]);
                return response()->json(['error' => 'Payment record not found'], 404);
            }

            $type = $resolved['type']; // 'appointment' or 'consultation_request'
            $record = $resolved['record'];

            // Process based on transaction status
            if ($transactionstatus === 'success') {
                $this->markAsPaid($type, $record, $data);

                Log::info('AzamPay payment processed successfully', [
                    'type' => $type,
                    'id' => $record->id,
                    'transid' => $data['transid'] ?? null,
                    'amount' => $data['amount'] ?? null,
                ]);
            } elseif ($transactionstatus === 'failed' || $transactionstatus === 'cancelled') {
                $this->markAsFailed($type, $record, $data);

                Log::info('AzamPay payment failed', [
                    'type' => $type,
                    'id' => $record->id,
                    'status' => $transactionstatus,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('AzamPay webhook exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $this->buildCallbackLogContext($request, $request->all()),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Build a complete callback request context for diagnostics.
     */
    protected function buildCallbackLogContext(Request $request, array $data): array
    {
        return [
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'method' => $request->method(),
            'query' => $request->query(),
            'body' => $data,
            'headers' => $request->headers->all(),
            'raw_body' => $request->getContent(),
            'route_parameters' => $request->route()?->parameters() ?? [],
            'ip' => $request->ip(),
            'ips' => $request->ips(),
            'user_agent' => $request->userAgent(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'received_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Resolve a payment record using AzamPay webhook identifiers
     */
    protected function resolvePaymentRecord(?string $utilityref, ?string $externalreference, array $data)
    {
        // Per AzamPay docs:
        // - utilityref: partner reference (our order_id)
        // - externalreference: AzamPay reference
        // Try both when resolving local records.
        if ($externalreference) {
            $appointment = $this->findAppointment($externalreference);
            if ($appointment) {
                return ['type' => 'appointment', 'record' => $appointment];
            }

            // Check if it's a public consultation request stored in consultation_requests table
            $consultationRequest = DB::table('consultation_requests')
                ->where('meta_data', 'like', "%\"order_id\":\"{$externalreference}\"%")
                ->orWhere('meta_data', 'like', "%\"order_id\":\"{$utilityref}\"%")
                ->first();
            if ($consultationRequest) {
                return ['type' => 'consultation_request', 'record' => $consultationRequest];
            }
        }

        if ($utilityref) {
            $appointment = $this->findAppointment($utilityref);
            if ($appointment) {
                return ['type' => 'appointment', 'record' => $appointment];
            }

            $consultationRequest = DB::table('consultation_requests')
                ->where('meta_data', 'like', "%\"order_id\":\"{$utilityref}\"%")
                ->first();
            if ($consultationRequest) {
                return ['type' => 'consultation_request', 'record' => $consultationRequest];
            }
        }

        return null;
    }

    /**
     * Find an appointment by order_id or transaction_id
     */
    protected function findAppointment(string $reference)
    {
        return Appointment::where('order_id', $reference)
            ->orWhere('transaction_id', $reference)
            ->first();
    }

    /**
     * Mark a record as paid
     */
    protected function markAsPaid(string $type, $record, array $data)
    {
        $transid = $data['transid'] ?? $data['reference'] ?? null;
        $amount = $data['amount'] ?? null;

        if ($type === 'appointment') {
            $record->update([
                'payment_status' => 'completed',
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'transaction_id' => $transid ?? $record->transaction_id,
            ]);

            if ($amount !== null) {
                $record->update(['amount' => $amount]);
            }

            event(new \App\Events\AppointmentPaid($record));
        } else {
            // Public consultation request via consultation_requests table
            $meta = json_decode($record->meta_data, true) ?? [];
            DB::table('consultation_requests')->where('id', $record->id)->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'meta_data' => json_encode(array_merge($meta, [
                    'transid' => $transid,
                    'operator' => $data['operator'] ?? null,
                    'msisdn' => $data['msisdn'] ?? null,
                    'paid_at' => now()->toDateTimeString(),
                ])),
                'updated_at' => now(),
            ]);

            // Optionally send email
            try {
                Mail::to($record->email)->send(
                    new \App\Mail\AppointmentConfirmed($record)
                );
            } catch (\Throwable $e) {
                Log::error('Failed to send confirmation email', ['message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Mark a record as failed/cancelled
     */
    protected function markAsFailed(string $type, $record, array $data)
    {
        if ($type === 'appointment') {
            $record->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        } else {
            $meta = json_decode($record->meta_data, true) ?? [];
            DB::table('consultation_requests')->where('id', $record->id)->update([
                'payment_status' => 'failed',
                'meta_data' => json_encode(array_merge($meta, [
                    'payment_failed_at' => now()->toDateTimeString(),
                    'failure_message' => $data['message'] ?? null,
                ])),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Handle payment redirect
     */
    public function redirect(Request $request)
    {
        // The redirect may carry back the order id via various query params
        $externalId = $request->query('externalId')
            ?? $request->query('externalreference')
            ?? $request->query('transactionId')
            ?? $request->query('utilityref');

        if (!$externalId) {
            return redirect()->route('candidate.consultations.index')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        $appointment = $this->findAppointment($externalId);

        if (!$appointment) {
            return redirect()->route('candidate.consultations.index')
                ->with('error', 'Payment record not found.');
        }

        // If already confirmed, skip API call
        if ($appointment->payment_status === 'completed') {
            return redirect()->route('candidate.consultations.show', $appointment)
                ->with('success', 'Payment completed successfully! Your appointment has been confirmed.');
        }

        // Query the AzamPay API for the current status
        $paymentStatus = $this->azampayService->verifyPayment($externalId);

        if ($paymentStatus && isset($paymentStatus['success']) && $paymentStatus['success'] === true) {
            $appointment->update([
                'payment_status' => 'completed',
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            event(new \App\Events\AppointmentPaid($appointment));

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
        $externalId = $request->query('externalId')
            ?? $request->query('externalreference')
            ?? $request->query('transactionId');

        if ($externalId) {
            $appointment = $this->findAppointment($externalId);

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

    /**
     * Card checkout page – renders a form to collect card details
     * and submits them to AzamPay's /azampay/card/checkout endpoint
     */
    public function cardCheckout(Request $request, Appointment $appointment)
    {
        // Security check
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.appointments.card-checkout', compact('appointment'));
    }

    /**
     * Process card checkout via AzamPay API
     */
    public function processCardCheckout(Request $request, Appointment $appointment)
    {
        // Security check
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'cardNumber' => 'required|string|max:20',
            'cardHolderName' => 'required|string|max:100',
            'cardExpiry' => 'required|string|max:7',
            'cardCvv' => 'required|string|max:4',
        ]);

        try {
            $response = $this->azampayService->cardCheckout([
                'amount' => $appointment->amount,
                'currency' => 'TZS',
                'cardNumber' => $validated['cardNumber'],
                'cardHolderName' => $validated['cardHolderName'],
                'cardExpiry' => $validated['cardExpiry'],
                'cardCvv' => $validated['cardCvv'],
                'externalId' => $appointment->order_id,
                'additionalProperties' => [
                    'appointment_id' => $appointment->id,
                    'user_id' => $appointment->user_id,
                ],
            ]);

            if ($response && isset($response['success']) && $response['success'] === true) {
                $appointment->update([
                    'transaction_id' => $response['transactionId'] ?? $appointment->order_id,
                ]);

                if ($appointment->appointment_type === 'consultation') {
                    return redirect()->route('candidate.consultations.show', $appointment)
                        ->with('success', 'Card payment initiated successfully.');
                }

                return redirect()->route('candidate.billing.index')
                    ->with('success', 'Card payment initiated successfully.');
            }

            return back()->withErrors(['payment' => 'Card payment failed: ' . ($response['message'] ?? 'Unknown error')])->withInput();
        } catch (\Exception $e) {
            Log::error('AzamPay card checkout exception', [
                'message' => $e->getMessage(),
                'appointment_id' => $appointment->id,
            ]);

            return back()->withErrors(['payment' => 'Card payment failed: ' . $e->getMessage()])->withInput();
        }
    }
}
