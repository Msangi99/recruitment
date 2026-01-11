<?php

namespace App\Listeners;

use App\Events\AppointmentPaid;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAppointmentConfirmation
{
    /**
     * Handle the event.
     */
    public function handle(AppointmentPaid $event): void
    {
        $appointment = $event->appointment;
        
        // Handle subscription vs consultation differently
        if ($appointment->appointment_type === 'subscription') {
            // Send subscription confirmation email
            if ($appointment->user) {
                try {
                    Mail::send('emails.subscription-confirmed', [
                        'appointment' => $appointment,
                        'user' => $appointment->user,
                    ], function ($message) use ($appointment) {
                        $message->to($appointment->user->email, $appointment->user->name)
                                ->subject('Subscription Activated - COYZON');
                    });
                } catch (\Exception $e) {
                    Log::error('Failed to send subscription confirmation email: ' . $e->getMessage());
                }
            }
        } else {
            // Send confirmation email to candidate for consultations
            if ($appointment->user) {
                try {
                    Mail::send('emails.appointment-confirmed', [
                        'appointment' => $appointment,
                        'user' => $appointment->user,
                    ], function ($message) use ($appointment) {
                        $message->to($appointment->user->email, $appointment->user->name)
                                ->subject('Appointment Confirmed - COYZON');
                    });
                } catch (\Exception $e) {
                    Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
                }
            }
            
            // Send notification to employer if applicable
            if ($appointment->employer) {
                try {
                    Mail::send('emails.appointment-notification', [
                        'appointment' => $appointment,
                        'employer' => $appointment->employer,
                    ], function ($message) use ($appointment) {
                        $message->to($appointment->employer->email, $appointment->employer->name)
                                ->subject('New Appointment Scheduled - COYZON');
                    });
                } catch (\Exception $e) {
                    Log::error('Failed to send employer notification email: ' . $e->getMessage());
                }
            }
        }
    }
}
