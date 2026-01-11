<?php

namespace App\Listeners;

use App\Models\Appointment;
use Bryceandy\Selcom\Events\CheckoutWebhookReceived;
use Illuminate\Support\Facades\Log;

class ProcessAppointmentPayment
{
    /**
     * Handle the event.
     */
    public function handle(CheckoutWebhookReceived $event): void
    {
        try {
            $orderId = $event->orderId;
            
            // Find appointment by order_id
            $appointment = Appointment::where('order_id', $orderId)->first();
            
            if (!$appointment) {
                Log::warning('Appointment not found for order ID: ' . $orderId);
                return;
            }
            
            // Update appointment payment status
            $appointment->update([
                'payment_status' => 'completed',
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'transaction_id' => $event->transactionId ?? $appointment->transaction_id,
            ]);
            
            // Trigger appointment paid event (sends emails)
            event(new \App\Events\AppointmentPaid($appointment));
            
            Log::info('Appointment payment processed successfully', [
                'appointment_id' => $appointment->id,
                'order_id' => $orderId,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error processing appointment payment webhook: ' . $e->getMessage(), [
                'order_id' => $event->orderId ?? 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
