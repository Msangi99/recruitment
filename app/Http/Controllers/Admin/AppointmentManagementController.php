<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
        $oldStatus = $appointment->status;

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

        // Send email notifications
        if (Setting::emailNotificationsEnabled()) {
            try {
                if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
                    $this->sendConfirmationEmails($appointment);
                } elseif ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
                    $this->sendCancellationEmail($appointment, $request->notes);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send appointment notification email', [
                    'appointment_id' => $appointment->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return back()->with('success', 'Appointment status updated successfully.');
    }

    /**
     * Send confirmation emails to both employer and candidate
     */
    protected function sendConfirmationEmails(Appointment $appointment)
    {
        $hrEmail = Setting::getHrEmail();
        
        // Email data
        $emailData = [
            'candidateName' => $appointment->user->name ?? 'Candidate',
            'companyName' => $appointment->company_name ?? 'Company',
            'jobTitle' => $appointment->job_title ?? $appointment->title ?? 'Position',
            'scheduledAt' => $appointment->scheduled_at->format('l, F j, Y \a\t g:i A'),
            'duration' => $appointment->duration_minutes ?? 30,
            'meetingMode' => $appointment->meeting_mode ?? 'online',
            'meetingLink' => $appointment->meeting_link,
            'meetingLocation' => $appointment->meeting_location,
            'requirements' => $appointment->requirements,
            'notes' => $appointment->notes,
            'hrEmail' => $hrEmail,
        ];
        
        // Send email to employer
        $employerEmail = $appointment->interviewer_email;
        if ($employerEmail) {
            $emailData['employerName'] = $appointment->company_name;
            
            Mail::send('emails.appointment-approved', $emailData, function ($message) use ($employerEmail, $appointment) {
                $message->to($employerEmail)
                        ->subject('Interview Request Approved - ' . ($appointment->user->name ?? 'Candidate'));
            });
            
            Log::info('Sent appointment confirmation email to employer', [
                'appointment_id' => $appointment->id,
                'email' => $employerEmail
            ]);
        }
        
        // Send email to candidate
        $candidateEmail = $appointment->user->email ?? null;
        if ($candidateEmail) {
            Mail::send('emails.appointment-candidate-notification', $emailData, function ($message) use ($candidateEmail, $appointment) {
                $message->to($candidateEmail)
                        ->subject('🎉 Interview Scheduled with ' . ($appointment->company_name ?? 'Employer'));
            });
            
            Log::info('Sent appointment confirmation email to candidate', [
                'appointment_id' => $appointment->id,
                'email' => $candidateEmail
            ]);
        }
        
        // Send notification to HR email if set
        if ($hrEmail) {
            Mail::send('emails.appointment-approved', array_merge($emailData, ['employerName' => 'HR Team']), function ($message) use ($hrEmail, $appointment) {
                $message->to($hrEmail)
                        ->subject('[Admin] Interview Confirmed - ' . ($appointment->user->name ?? 'Candidate') . ' with ' . ($appointment->company_name ?? 'Employer'));
            });
        }
    }

    /**
     * Send cancellation email to employer with reason
     */
    protected function sendCancellationEmail(Appointment $appointment, $cancellationReason = null)
    {
        $hrEmail = Setting::getHrEmail();
        
        // Email data
        $emailData = [
            'employerName' => $appointment->company_name ?? 'Employer',
            'candidateName' => $appointment->user->name ?? 'Candidate',
            'companyName' => $appointment->company_name ?? 'Company',
            'jobTitle' => $appointment->job_title ?? $appointment->title ?? 'Position',
            'scheduledAt' => $appointment->scheduled_at->format('l, F j, Y \a\t g:i A'),
            'cancellationReason' => $cancellationReason ?? $appointment->cancellation_reason,
            'hrEmail' => $hrEmail,
        ];
        
        // Send email to employer
        $employerEmail = $appointment->interviewer_email;
        if ($employerEmail) {
            Mail::send('emails.appointment-cancelled-employer', $emailData, function ($message) use ($employerEmail, $appointment) {
                $message->to($employerEmail)
                        ->subject('Interview Request Cancelled - ' . ($appointment->user->name ?? 'Candidate'));
            });
            
            Log::info('Sent appointment cancellation email to employer', [
                'appointment_id' => $appointment->id,
                'email' => $employerEmail,
                'reason' => $emailData['cancellationReason']
            ]);
        }
    }
}
