<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ConsultationRequest; // We will create this model
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAppointmentNotification;

class PublicAppointmentController extends Controller
{
    public function index()
    {
        return view('public.appointments.index');
    }

    // Employer Consultations
    public function employerForm()
    {
        return view('public.appointments.employer');
    }

    public function storeEmployer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'worker_type' => 'required|string|max:255',
            'worker_count' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'requested_date' => 'required|date',
            'requested_time' => 'required',
        ]);

        $requestedAt = $validated['requested_date'] . ' ' . $validated['requested_time'];

        DB::table('consultation_requests')->insert([
            'type' => 'employer',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company_name'],
            'country' => $validated['country'],
            'requested_date' => $requestedAt,
            'duration_minutes' => 45,
            'meta_data' => json_encode([
                'worker_type' => $validated['worker_type'],
                'worker_count' => $validated['worker_count'],
                'message' => $validated['message'] ?? '',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send Email Notification
        try {
            $hrEmail = \App\Models\Setting::getHrEmail() ?? 'hr@coyzon.com';
            $appointmentData = DB::table('consultation_requests')->where('email', $validated['email'])->orderBy('id', 'desc')->first();
            Mail::to($hrEmail)->send(new NewAppointmentNotification($appointmentData));
        } catch (\Exception $e) {
            // Log error or ignore for now to preventing blocking the flow
        }

        return redirect()->route('public.appointments.index')->with('success', 'Your employer consultation request has been submitted. We will confirm your appointment shortly via email.');
    }

    // Partnership
    public function partnershipForm()
    {
        return view('public.appointments.partnership');
    }

    public function storePartnership(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'partnership_type' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        DB::table('consultation_requests')->insert([
            'type' => 'partnership',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company_name'],
            'country' => $validated['country'],
            'meta_data' => json_encode([
                'website' => $validated['website'],
                'partnership_type' => $validated['partnership_type'],
                'experience' => $validated['experience'],
                'message' => $validated['message'] ?? '',
            ]),
            'status' => 'pending_review',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send Email Notification
        try {
            $hrEmail = \App\Models\Setting::getHrEmail() ?? 'hr@coyzon.com';
            $appointmentData = DB::table('consultation_requests')->where('email', $validated['email'])->orderBy('id', 'desc')->first();
            Mail::to($hrEmail)->send(new NewAppointmentNotification($appointmentData));
        } catch (\Exception $e) {
            // Log error
        }

        return redirect()->route('public.appointments.index')->with('success', 'Your partnership request has been submitted for review. We will contact you shortly.');
    }

    // Job Seeker (Paid)
    public function jobSeekerLanding()
    {
        return view('public.appointments.job-seeker-landing');
    }

    public function jobSeekerForm()
    {
        return view('public.appointments.job-seeker-form');
    }

    public function storeJobSeeker(Request $request)
    {
        // This is a big form. 
        // We will validate and store in session or DB as 'pending_payment'
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'nationality' => 'required|string|max:255',
            'residence' => 'required|string|max:255',
            // ... more validations for all fields
            // 'payment_gateway' => 'required|in:selcom,azampay', // Removed as per user request
        ]);

        // Store into DB with status 'pending_payment'
        $id = DB::table('consultation_requests')->insertGetId([
            'type' => 'job_seeker',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['nationality'], // or residence
            'amount' => \App\Models\Setting::get('consultation_price', 30000), // Dynamic fees
            'payment_status' => 'pending',
            'payment_gateway' => 'azampay', // Default to azampay since selection is removed

            'meta_data' => json_encode($request->except(['_token', 'name', 'email', 'phone', 'payment_gateway'])),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect to Payment Logic
        // For now, mockup success and redirect to Calendar
        
        // This should actually redirect to a payment processor
        // For this task, I will redirect to a mockup payment/calendar page
        return redirect()->route('public.appointments.calendar', ['id' => $id]);
    }

    public function calendar($id)
    {
        $request = DB::table('consultation_requests')->where('id', $id)->first();
        if (!$request) abort(404);
        
        return view('public.appointments.calendar', compact('request'));
    }

    public function storeSchedule(Request $request, $id)
    {
        $request->validate([
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $requestedAt = $request->scheduled_date . ' ' . $request->scheduled_time;

        DB::table('consultation_requests')->where('id', $id)->update([
            'requested_date' => $requestedAt,
            'status' => 'confirmed',
            'payment_status' => 'paid', // Mockup
            'updated_at' => now(),
        ]);

        // Send Email Notification
        try {
            $hrEmail = \App\Models\Setting::getHrEmail() ?? 'hr@coyzon.com';
            $appointmentData = DB::table('consultation_requests')->where('id', $id)->first();
            Mail::to($hrEmail)->send(new NewAppointmentNotification($appointmentData));
        } catch (\Exception $e) {
            // Log error
        }

        return view('public.appointments.confirmation', ['request' => DB::table('consultation_requests')->where('id', $id)->first()]);
    }
}
