<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ConsultationRequest; // We will create this model
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAppointmentNotification;
use App\Services\AzamPayService;
use App\Services\SelcomService;
use Illuminate\Support\Facades\Log;

class PublicAppointmentController extends Controller
{
    protected $azampayService;
    protected $selcomService;

    public function __construct(AzamPayService $azampayService, SelcomService $selcomService)
    {
        $this->azampayService = $azampayService;
        $this->selcomService = $selcomService;
    }
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
            'phone' => 'required|string|max:50',
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
            'phone' => $validated['phone'],
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'nationality' => 'required|string|max:255',
            'consultation_type' => 'required|string|max:255',
            'consultation_mode' => 'required|string|max:255',
            // Payment fields removed - moved to step 2
            'destination' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $amount = (int) \App\Models\Setting::get('consultation_price', 30000);
        $orderId = 'CONSULT-' . time() . '-' . rand(100, 999);

        // Store into DB with status 'pending_payment'
        $id = DB::table('consultation_requests')->insertGetId([
            'type' => 'job_seeker',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['nationality'],
            'amount' => $amount,
            'payment_status' => 'pending',
            'status' => 'pending_payment',
            'meta_data' => json_encode([
                'consultation_type' => $validated['consultation_type'],
                'consultation_mode' => $validated['consultation_mode'],
                'destination' => $validated['destination'] ?? null,
                'message' => $validated['message'] ?? null,
                'order_id' => $orderId,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect to Step 2: Payment Gateway Selection
        return redirect()->route('public.appointments.jobSeeker.payment', ['id' => $id]);
    }

    public function paymentForm($id)
    {
        $request = DB::table('consultation_requests')->where('id', $id)->first();
        if (!$request || $request->status !== 'pending_payment') {
            // If already paid or invalid, redirect appropriately
             if ($request && $request->payment_status === 'paid') {
                 return redirect()->route('public.appointments.calendar', ['id' => $id]);
             }
             abort(404);
        }

        return view('public.appointments.payment', compact('request'));
    }

    public function processPayment(Request $request, $id)
    {
        $consultationRequest = DB::table('consultation_requests')->where('id', $id)->first();
        if (!$consultationRequest) abort(404);

        $validated = $request->validate([
            'payment_gateway' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'payment_phone' => 'nullable|string|max:255',
        ]);

        $amount = $consultationRequest->amount;
        $metaData = json_decode($consultationRequest->meta_data, true);
        $orderId = $metaData['order_id']; // Reuse existing order ID

        // Update with selected payment method
        DB::table('consultation_requests')->where('id', $id)->update([
            'payment_gateway' => $validated['payment_gateway'],
            'meta_data' => json_encode(array_merge($metaData, [
                'payment_method' => $validated['payment_method'],
                'payment_phone' => $validated['payment_phone'] ?? null,
            ])),
             'updated_at' => now(),
        ]);

        // Proceed with payment logic
        $paymentGateway = $validated['payment_gateway'];
        $paymentMethod = $validated['payment_method'];
        $paymentPhone = $validated['payment_phone'] ?? $consultationRequest->phone;

        $paymentError = null;
        $paymentErrorDetails = null;

        try {
            if ($paymentGateway === 'azampay') {
                if ($paymentMethod === 'mobile_money') {
                    $response = $this->azampayService->mobileCheckout([
                        'amount' => $amount,
                        'accountNumber' => $paymentPhone,
                        'externalId' => $orderId,
                        'provider' => 'Mpesa',
                    ]);

                    if (isset($response['success']) && $response['success'] === true) {
                        DB::table('consultation_requests')->where('id', $id)->update([
                            'payment_status' => 'processing',
                        ]);

                        return view('public.appointments.confirmation', [
                            'request' => $consultationRequest,
                            'message' => 'Payment initiated! Please check your phone and enter your PIN to complete the payment.',
                            'status' => 'pending_payment'
                        ]);
                    } else {
                        $paymentError = 'AzamPay checkout failed';
                        $paymentErrorDetails = $response['message'] ?? 'Unknown error';
                    }
                }
            } else {
                // Selcom
                if ($paymentMethod === 'card') {
                    $checkout = $this->selcomService->cardCheckout([
                        'name' => $consultationRequest->name,
                        'email' => $consultationRequest->email,
                        'phone' => $consultationRequest->phone,
                        'amount' => $amount,
                        'transaction_id' => $orderId,
                    ]);
                } else {
                    $checkout = $this->selcomService->checkout([
                        'name' => $consultationRequest->name,
                        'email' => $consultationRequest->email,
                        'phone' => $paymentPhone,
                        'amount' => $amount,
                        'transaction_id' => $orderId,
                    ]);
                }

                if (isset($checkout['data'][0]['payment_gateway_url'])) {
                    $paymentUrl = base64_decode($checkout['data'][0]['payment_gateway_url']);
                    DB::table('consultation_requests')->where('id', $id)->update([
                        'payment_status' => 'processing',
                    ]);
                    return redirect($paymentUrl);
                } else {
                    $paymentError = 'Selcom payment URL not found';
                    $paymentErrorDetails = json_encode($checkout);
                }
            }
        } catch (\Exception $e) {
            $paymentError = 'Payment gateway error';
            $paymentErrorDetails = $e->getMessage();
        }

        if ($paymentError) {
             DB::table('consultation_requests')->where('id', $id)->update([
                'payment_status' => 'failed',
                'meta_data' => json_encode(array_merge(json_decode($consultationRequest->meta_data, true), [
                    'payment_error' => $paymentError,
                    'payment_error_details' => $paymentErrorDetails,
                ])),
            ]);

            return view('public.appointments.confirmation', [
                'request' => $consultationRequest,
                'message' => $paymentError,
                'error_details' => $paymentErrorDetails,
                'status' => 'payment_failed'
            ]);
        }

        return redirect()->route('public.appointments.calendar', ['id' => $id])->with('success', 'Payment initiated successfully.');
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
        
        // Get consultation request
        $consultationRequest = DB::table('consultation_requests')->where('id', $id)->first();
        if (!$consultationRequest) {
            abort(404);
        }

        // Update with scheduled date/time
        DB::table('consultation_requests')->where('id', $id)->update([
            'requested_date' => $requestedAt,
            'updated_at' => now(),
        ]);

        // Update with scheduled date/time and valid status
        DB::table('consultation_requests')->where('id', $id)->update([
            'requested_date' => $requestedAt,
            'status' => 'pending_confirmation', // Or whatever final status is preferred
            'updated_at' => now(),
        ]);

        // Send Email Notification (Re-implemented here if it was missing or moved)
        try {
            $hrEmail = \App\Models\Setting::getHrEmail() ?? 'hr@coyzon.com';
            Mail::to($hrEmail)->send(new NewAppointmentNotification((object) $consultationRequest));
        } catch (\Exception $e) {
            // Log error
        }

        return view('public.appointments.confirmation', [
            'request' => $consultationRequest,
            'message' => 'Appointment scheduled successfully!',
            'status' => 'success'
        ]);

        // Fallback
        return view('public.appointments.confirmation', [
            'request' => DB::table('consultation_requests')->where('id', $id)->first(),
            'message' => 'Booking created. Payment processing.',
            'status' => 'processing'
        ]);
    }
}
