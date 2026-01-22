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
            'payment_gateway' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'payment_phone' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $amount = (int) \App\Models\Setting::get('consultation_price', 30000);
        $orderId = 'CONSULT-' . time() . '-' . rand(100, 999);

        // Store into DB with status 'pending'
        $id = DB::table('consultation_requests')->insertGetId([
            'type' => 'job_seeker',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['nationality'],
            'amount' => $amount,
            'payment_status' => 'pending',
            'payment_gateway' => $validated['payment_gateway'],
            'status' => 'pending',
            'meta_data' => json_encode([
                'consultation_type' => $validated['consultation_type'],
                'consultation_mode' => $validated['consultation_mode'],
                'destination' => $validated['destination'] ?? null,
                'message' => $validated['message'] ?? null,
                'payment_phone' => $validated['payment_phone'] ?? null,
                'payment_method' => $validated['payment_method'],
                'order_id' => $orderId,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect to calendar for slot selection
        return redirect()->route('public.appointments.calendar', ['id' => $id])
            ->with('info', 'Please select your preferred date and time. Payment will be processed after confirmation.');
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

        // Extract payment details from meta_data
        $metaData = json_decode($consultationRequest->meta_data, true);
        $paymentGateway = $consultationRequest->payment_gateway;
        $paymentMethod = $metaData['payment_method'] ?? 'mobile_money';
        $paymentPhone = $metaData['payment_phone'] ?? $consultationRequest->phone;
        $orderId = $metaData['order_id'] ?? 'CONSULT-' . $id;
        $amount = $consultationRequest->amount;

        $paymentError = null;
        $paymentErrorDetails = null;

        // Initiate Payment
        try {
            // Check if gateway credentials are configured
            if ($paymentGateway === 'azampay') {
                $azamPayConfigured = config('azampay.client_id') && config('azampay.client_secret');
                if (!$azamPayConfigured) {
                    throw new \Exception('AzamPay credentials not configured in .env file. Please set AZAMPAY_CLIENT_ID and AZAMPAY_CLIENT_SECRET.');
                }
            } else {
                $selcomConfigured = config('selcom.vendor') && config('selcom.key') && config('selcom.secret');
                if (!$selcomConfigured) {
                    throw new \Exception('Selcom credentials not configured in .env file. Please set SELCOM_VENDOR_ID, SELCOM_API_KEY, and SELCOM_API_SECRET.');
                }
            }

            if ($paymentGateway === 'azampay') {
                if ($paymentMethod === 'mobile_money') {
                    Log::info('=== AZAMPAY PAYMENT INITIATION ===', [
                        'order_id' => $orderId,
                        'amount' => $amount,
                        'phone' => $paymentPhone,
                        'consultation_id' => $id,
                        'gateway' => 'azampay',
                        'method' => 'mobile_money',
                        'timestamp' => now()->toDateTimeString(),
                    ]);

                    $response = $this->azampayService->mobileCheckout([
                        'amount' => $amount,
                        'accountNumber' => $paymentPhone,
                        'externalId' => $orderId,
                        'provider' => 'Mpesa',
                    ]);

                    Log::info('=== AZAMPAY API RESPONSE ===', [
                        'order_id' => $orderId,
                        'response' => $response,
                        'is_array' => is_array($response),
                        'has_success_key' => isset($response['success']),
                        'success_value' => $response['success'] ?? null,
                    ]);

                    if (!$response) {
                        $paymentError = 'AzamPay returned no response';
                        $paymentErrorDetails = 'The payment gateway did not return any response. This usually indicates a network error or the API is down.';
                    } elseif (isset($response['success']) && $response['success'] === true) {
                        // Success!
                        DB::table('consultation_requests')->where('id', $id)->update([
                            'payment_status' => 'processing',
                            'status' => 'pending_payment',
                        ]);

                        Log::info('=== PAYMENT INITIATED SUCCESSFULLY ===', [
                            'order_id' => $orderId,
                            'gateway' => 'azampay',
                        ]);

                        return view('public.appointments.confirmation', [
                            'request' => DB::table('consultation_requests')->where('id', $id)->first(),
                            'message' => 'Payment initiated! Please check your phone and enter your PIN to complete the payment.',
                            'status' => 'pending_payment'
                        ]);
                    } else {
                        $paymentError = 'AzamPay mobile checkout failed';
                        $paymentErrorDetails = $response['message'] ?? json_encode($response);
                        
                        Log::error('=== AZAMPAY CHECKOUT FAILED ===', [
                            'order_id' => $orderId,
                            'error_message' => $paymentErrorDetails,
                            'full_response' => $response,
                        ]);
                    }
                } else {
                    $paymentError = 'AzamPay card payment not yet implemented';
                    $paymentErrorDetails = 'Card payments via AzamPay are not yet implemented. Please use Mobile Money or select Selcom for card payments.';
                    
                    Log::warning('=== UNSUPPORTED PAYMENT METHOD ===', [
                        'gateway' => 'azampay',
                        'method' => $paymentMethod,
                        'order_id' => $orderId,
                    ]);
                }
            } else {
                // Selcom
                Log::info('=== SELCOM PAYMENT INITIATION ===', [
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'method' => $paymentMethod,
                    'consultation_id' => $id,
                    'gateway' => 'selcom',
                    'timestamp' => now()->toDateTimeString(),
                ]);

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

                Log::info('=== SELCOM API RESPONSE ===', [
                    'order_id' => $orderId,
                    'response' => $checkout,
                    'is_array' => is_array($checkout),
                    'has_data_key' => isset($checkout['data']),
                    'data_is_array' => isset($checkout['data']) && is_array($checkout['data']),
                ]);

                if (!$checkout) {
                    $paymentError = 'Selcom returned no response';
                    $paymentErrorDetails = 'The payment gateway did not return any response. Check network connectivity and API credentials.';
                } elseif (isset($checkout['data'][0]['payment_gateway_url'])) {
                    $paymentUrl = base64_decode($checkout['data'][0]['payment_gateway_url']);
                    
                    Log::info('=== REDIRECTING TO SELCOM PAYMENT PAGE ===', [
                        'order_id' => $orderId,
                        'url' => $paymentUrl,
                    ]);
                    
                    // Update status before redirect
                    DB::table('consultation_requests')->where('id', $id)->update([
                        'payment_status' => 'processing',
                        'status' => 'pending_payment',
                    ]);
                    
                    return redirect($paymentUrl);
                } else {
                    $paymentError = 'Selcom payment URL not found in response';
                    $paymentErrorDetails = 'Expected payment_gateway_url in response but it was missing. Full response: ' . json_encode($checkout);
                    
                    Log::error('=== SELCOM URL MISSING ===', [
                        'order_id' => $orderId,
                        'response' => $checkout,
                        'expected_key' => 'data[0][payment_gateway_url]',
                    ]);
                }
            }
        } catch (\Exception $e) {
            $paymentError = 'Payment gateway error';
            $paymentErrorDetails = $e->getMessage();
            
            Log::error('Payment Initiation Exception (storeSchedule)', [
                'consultation_id' => $id,
                'order_id' => $orderId,
                'gateway' => $paymentGateway,
                'method' => $paymentMethod,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Store error in meta_data if payment failed
        if ($paymentError) {
            DB::table('consultation_requests')->where('id', $id)->update([
                'meta_data' => json_encode(array_merge(
                    $metaData,
                    [
                        'payment_error' => $paymentError,
                        'payment_error_details' => $paymentErrorDetails,
                        'payment_attempted_at' => now()->toDateTimeString(),
                    ]
                )),
                'payment_status' => 'failed',
                'status' => 'payment_failed',
            ]);

            return view('public.appointments.confirmation', [
                'request' => DB::table('consultation_requests')->where('id', $id)->first(),
                'message' => $paymentError,
                'error_details' => $paymentErrorDetails,
                'status' => 'payment_failed'
            ]);
        }

        // Fallback
        return view('public.appointments.confirmation', [
            'request' => DB::table('consultation_requests')->where('id', $id)->first(),
            'message' => 'Booking created. Payment processing.',
            'status' => 'processing'
        ]);
    }
}
