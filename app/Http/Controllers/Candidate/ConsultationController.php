<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AzamPayService;
use App\Services\SelcomService;
use Bryceandy\Selcom\Facades\Selcom;
use Illuminate\Http\Request;

class ConsultationController extends Controller
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
        $candidate = auth()->user();

        $consultations = Appointment::where('user_id', $candidate->id)
            ->where('appointment_type', 'consultation')
            ->latest()
            ->paginate(20);

        return view('candidate.consultations.index', compact('consultations'));
    }

    public function create()
    {
        $candidate = auth()->user();
        
        // Check if profile is verified (as per documentation requirement)
        if (!$candidate->candidateProfile || $candidate->candidateProfile->verification_status !== 'approved') {
            return redirect()->route('candidate.profile.create')
                ->with('error', 'Your profile must be verified before booking a consultation. Please complete and submit your profile for verification.');
        }

        return view('candidate.consultations.create');
    }

    public function store(Request $request)
    {
        $candidate = auth()->user();
        
        // Verify profile is approved (security check)
        if (!$candidate->candidateProfile || $candidate->candidateProfile->verification_status !== 'approved') {
            return back()->with('error', 'Your profile must be verified before booking a consultation.')->withInput();
        }

        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'meeting_mode' => 'required|in:online,in-person',
            'duration_minutes' => 'required|integer|min:15|max:120',
            'meeting_link' => 'required_if:meeting_mode,online|nullable|url',
            'meeting_location' => 'required_if:meeting_mode,in-person|nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_gateway' => 'required|in:selcom,azampay',
            'payment_method' => 'required|in:mobile,card',
            'mobile_provider' => 'required_if:payment_method,mobile|nullable|in:Mpesa,Tigo Pesa,Airtel Money,Halopesa,Azampay',
            'account_number' => 'required_if:payment_method,mobile|nullable|string|max:20',
        ], [
            'payment_method.required' => 'Please select a payment method.',
            'mobile_provider.required_if' => 'Please select a mobile money provider.',
            'account_number.required_if' => 'Please enter your mobile money number.',
        ]);

        // Create appointment
        $appointment = Appointment::create([
            'user_id' => $candidate->id,
            'employer_id' => null,
            'appointment_type' => 'consultation',
            'meeting_mode' => $validated['meeting_mode'],
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => $validated['duration_minutes'],
            'meeting_link' => $validated['meeting_link'] ?? null,
            'meeting_location' => $validated['meeting_location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'amount' => \App\Models\Setting::get('consultation_price', 30000), // TZS
            'currency' => 'TZS',
            'payment_status' => 'pending',
            'status' => 'pending',
            'order_id' => 'CONSULT-' . time() . '-' . $candidate->id,
        ]);

        // Initiate payment based on selected gateway
        try {
            if ($validated['payment_gateway'] === 'azampay') {
                // Validate AzamPay specific fields
                if (empty($validated['payment_method'])) {
                    $appointment->delete();
                    return back()->withErrors(['payment_method' => 'Payment method is required for AzamPay.'])->withInput();
                }
                
                if ($validated['payment_method'] === 'mobile') {
                    if (empty($validated['mobile_provider']) || empty($validated['account_number'])) {
                        $appointment->delete();
                        return back()->withErrors([
                            'mobile_provider' => empty($validated['mobile_provider']) ? 'Mobile provider is required.' : null,
                            'account_number' => empty($validated['account_number']) ? 'Mobile number is required.' : null,
                        ])->withInput();
                    }
                }
                
                return $this->initiateAzamPayPayment($appointment, $candidate, $validated);
            } else {
                // Validate Selcom specific fields
                if (empty($validated['payment_method'])) {
                    $appointment->delete();
                    return back()->withErrors(['payment_method' => 'Payment method is required for Selcom.'])->withInput();
                }
                
                if ($validated['payment_method'] === 'mobile') {
                    if (empty($validated['mobile_provider']) || empty($validated['account_number'])) {
                        $appointment->delete();
                        return back()->withErrors([
                            'mobile_provider' => empty($validated['mobile_provider']) ? 'Mobile provider is required.' : null,
                            'account_number' => empty($validated['account_number']) ? 'Mobile number is required.' : null,
                        ])->withInput();
                    }
                }
                
                return $this->initiateSelcomPayment($appointment, $candidate, $validated);
            }
        } catch (\Exception $e) {
            $appointment->delete();
            return back()->with('error', 'Payment initialization failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Initiate Selcom payment
     */
    protected function initiateSelcomPayment($appointment, $candidate, $validated)
    {
        $paymentMethod = $validated['payment_method'] ?? 'mobile';
        
        try {
            if ($paymentMethod === 'card') {
                // Use card checkout for card payments
                $checkout = $this->selcomService->cardCheckout([
                    'name' => $candidate->name,
                    'email' => $candidate->email,
                    'phone' => $candidate->phone ?? '255000000000',
                    'amount' => $appointment->amount,
                    'transaction_id' => $appointment->order_id,
                    'address' => $candidate->address ?? '',
                    'postcode' => $candidate->postcode ?? '',
                    'city' => $candidate->city ?? 'Dar Es Salaam',
                    'country_code' => $candidate->country ?? 'TZ',
                ]);
            } else {
                // Use mobile checkout for mobile money
                $checkout = $this->selcomService->checkout([
                    'name' => $candidate->name,
                    'email' => $candidate->email,
                    'phone' => $validated['account_number'] ?? $candidate->phone ?? '255000000000',
                    'amount' => $appointment->amount,
                    'transaction_id' => $appointment->order_id,
                    'no_redirection' => false,
                ]);
            }

            // Handle Selcom response format
            // Response format: {"data": [{"payment_gateway_url": "base64_encoded_url"}]}
            if (isset($checkout['data'][0]['payment_gateway_url'])) {
                $paymentUrl = base64_decode($checkout['data'][0]['payment_gateway_url']);
                return redirect($paymentUrl);
            }
            
            // Fallback to other possible formats
            if (isset($checkout['data']['payment_url'])) {
                return redirect($checkout['data']['payment_url']);
            } elseif (isset($checkout['data']['url'])) {
                return redirect($checkout['data']['url']);
            } elseif (isset($checkout['payment_url'])) {
                return redirect($checkout['payment_url']);
            } elseif (isset($checkout['url'])) {
                return redirect($checkout['url']);
            }

            throw new \Exception('Payment URL not found in response: ' . json_encode($checkout));
        } catch (\Exception $e) {
            // Fallback to original Selcom facade if custom service fails
            try {
                if ($paymentMethod === 'card') {
                    $checkout = Selcom::cardCheckout([
                        'name' => $candidate->name,
                        'email' => $candidate->email,
                        'phone' => $candidate->phone ?? '255000000000',
                        'amount' => $appointment->amount,
                        'transaction_id' => $appointment->order_id,
                        'address' => $candidate->address ?? '',
                        'postcode' => $candidate->postcode ?? '',
                    ]);
                } else {
                    $checkout = Selcom::checkout([
                        'name' => $candidate->name,
                        'email' => $candidate->email,
                        'phone' => $validated['account_number'] ?? $candidate->phone ?? '255000000000',
                        'amount' => $appointment->amount,
                        'transaction_id' => $appointment->order_id,
                        'no_redirection' => false,
                    ]);
                }

                if (isset($checkout['data'][0]['payment_gateway_url'])) {
                    return redirect(base64_decode($checkout['data'][0]['payment_gateway_url']));
                }
                
                return redirect($checkout['payment_url'] ?? $checkout['url']);
            } catch (\Exception $fallbackError) {
                throw new \Exception('Selcom payment failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Initiate AzamPay payment
     */
    protected function initiateAzamPayPayment($appointment, $candidate, $validated)
    {
        $paymentMethod = $validated['payment_method'] ?? 'mobile';
        
        if ($paymentMethod === 'mobile') {
            $response = $this->azampayService->mobileCheckout([
                'amount' => $appointment->amount,
                'currency' => 'TZS',
                'accountNumber' => $validated['account_number'],
                'externalId' => $appointment->order_id,
                'provider' => $validated['mobile_provider'] ?? 'Mpesa',
                'additionalProperties' => [
                    'appointment_id' => $appointment->id,
                    'user_id' => $candidate->id,
                ],
            ]);

            if ($response && isset($response['success']) && $response['success']) {
                // Update appointment with transaction details
                $appointment->update([
                    'transaction_id' => $response['transactionId'] ?? $appointment->order_id,
                ]);

                return redirect()->route('candidate.consultations.show', $appointment)
                    ->with('success', 'Payment initiated. Please complete the payment on your mobile device.');
            }

            throw new \Exception('Failed to initiate AzamPay mobile checkout');
        } elseif ($paymentMethod === 'bank') {
            // Bank checkout implementation
            $response = $this->azampayService->bankCheckout([
                'amount' => $appointment->amount,
                'currency' => 'TZS',
                'merchantAccountNumber' => config('azampay.merchant_account_number'),
                'merchantMobileNumber' => $candidate->phone ?? '255000000000',
                'merchantName' => config('azampay.app_name'),
                'externalId' => $appointment->order_id,
            ]);

            if ($response && isset($response['success']) && $response['success']) {
                return redirect()->route('candidate.consultations.show', $appointment)
                    ->with('success', 'Bank payment initiated. Please complete the transaction.');
            }

            throw new \Exception('Failed to initiate AzamPay bank checkout');
        } else {
            // Card checkout - redirect to card payment page
            return redirect()->route('azampay.card.checkout', [
                'appointment' => $appointment->id,
            ]);
        }
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->user_id !== auth()->id() || $appointment->appointment_type !== 'consultation') {
            abort(403);
        }

        return view('candidate.consultations.show', compact('appointment'));
    }
}
