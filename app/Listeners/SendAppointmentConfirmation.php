<?php

namespace App\Listeners;

use App\Events\AppointmentPaid;
use App\Services\NotificationMailService;
use Illuminate\Support\Facades\Mail;

class SendAppointmentConfirmation
{
    public function handle(AppointmentPaid $event): void
    {
        $appointment = $event->appointment;

        if ($appointment->appointment_type === 'subscription') {
            if ($appointment->user) {
                NotificationMailService::sendIfEnabled(function () use ($appointment) {
                    Mail::send('emails.subscription-confirmed', [
                        'appointment' => $appointment,
                        'user' => $appointment->user,
                    ], function ($message) use ($appointment) {
                        $message->to($appointment->user->email, $appointment->user->name)
                                ->subject('Subscription Activated - ' . config('app.name'));
                    });
                }, 'subscription_confirmed');
            }

            return;
        }

        if ($appointment->user) {
            NotificationMailService::sendIfEnabled(function () use ($appointment) {
                Mail::send('emails.appointment-confirmed', [
                    'appointment' => $appointment,
                    'user' => $appointment->user,
                ], function ($message) use ($appointment) {
                    $message->to($appointment->user->email, $appointment->user->name)
                            ->subject('Appointment Confirmed - ' . config('app.name'));
                });
            }, 'appointment_confirmed_candidate');
        }

        if ($appointment->employer) {
            NotificationMailService::sendIfEnabled(function () use ($appointment) {
                Mail::send('emails.appointment-notification', [
                    'appointment' => $appointment,
                    'employer' => $appointment->employer,
                ], function ($message) use ($appointment) {
                    $message->to($appointment->employer->email, $appointment->employer->name)
                            ->subject('New Appointment Scheduled - ' . config('app.name'));
                });
            }, 'appointment_confirmed_employer');
        }
    }
}
