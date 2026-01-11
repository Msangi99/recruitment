<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AzamPayService;
use App\Services\SelcomService;
use Bryceandy\Selcom\Facades\Selcom;
use Illuminate\Http\Request;

class BillingController extends Controller
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
        
        // Get payment history from appointments (both consultations and subscriptions)
        $payments = Appointment::where('user_id', $candidate->id)
            ->whereNotNull('amount')
            ->latest()
            ->paginate(10);
        
        // Calculate total spent
        $totalSpent = Appointment::where('user_id', $candidate->id)
            ->where('payment_status', 'completed')
            ->sum('amount');
        
        // Get current plan status
        $subscription = Appointment::where('user_id', $candidate->id)
            ->where('appointment_type', 'subscription')
            ->where('payment_status', 'completed')
            ->where('status', 'confirmed')
            ->latest()
            ->first();
        
        if ($subscription) {
            $currentPlan = [
                'name' => $subscription->notes ?? 'Premium Plan', // Store plan name in notes
                'type' => 'premium',
                'consultations_used' => Appointment::where('user_id', $candidate->id)
                    ->where('appointment_type', 'consultation')
                    ->where('payment_status', 'completed')
                    ->count(),
                'consultations_limit' => null,
                'expires_at' => $subscription->scheduled_at ?? null,
            ];
        } else {
            $currentPlan = [
                'name' => 'Free Plan',
                'type' => 'free',
                'consultations_used' => Appointment::where('user_id', $candidate->id)
                    ->where('appointment_type', 'consultation')
                    ->where('payment_status', 'completed')
                    ->count(),
                'consultations_limit' => null,
            ];
        }
        
        return view('candidate.billing.index', compact('payments', 'totalSpent', 'currentPlan'));
    }
    
    public function upgrade()
    {
        // Show upgrade plans page
        $plans = [
            [
                'id' => 'basic',
                'name' => 'Basic Plan',
                'price' => 50000, // TZS
                'currency' => 'TZS',
                'consultations' => 5,
                'features' => ['5 consultations per month', 'Priority support', 'Profile boost'],
            ],
            [
                'id' => 'premium',
                'name' => 'Premium Plan',
                'price' => 100000, // TZS
                'currency' => 'TZS',
                'consultations' => 'Unlimited',
                'features' => ['Unlimited consultations', 'Priority support', 'Profile boost', 'Job application tracking'],
            ],
        ];
        
        return view('candidate.billing.upgrade', compact('plans'));
    }
    
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|in:basic,premium',
            'payment_gateway' => 'required|in:selcom,azampay',
            'payment_method' => 'required|in:mobile,card,bank',
            'mobile_provider' => 'required_if:payment_method,mobile|nullable|in:Mpesa,"Tigo Pesa","Airtel Money",Halopesa,Azampay',
            'account_number' => 'required_if:payment_method,mobile|nullable|string|max:20',
        ], [
            'payment_gateway.required' => 'Please select a payment gateway.',
            'payment_method.required' => 'Please select a payment method.',
            'mobile_provider.required_if' => 'Please select a mobile money provider.',
            'account_number.required_if' => 'Please enter your mobile money number.',
        ]);
        
        $candidate = auth()->user();
        
        // Get plan details
        $plans = [
            'basic' => [
                'price' => 50000,
                'name' => 'Basic Plan',
                'consultations' => 5,
            ],
            'premium' => [
                'price' => 100000,
                'name' => 'Premium Plan',
                'consultations' => 'Unlimited',
            ],
        ];
        
        $plan = $plans[$validated['plan_id']];
        
        // Create subscription appointment/transaction
        $appointment = Appointment::create([
            'user_id' => $candidate->id,
            'employer_id' => null,
            'appointment_type' => 'subscription',
            'meeting_mode' => 'online',
            'scheduled_at' => now()->addMonth(), // Subscription expires in 1 month
            'duration_minutes' => 0,
            'notes' => $plan['name'], // Store plan name
            'amount' => $plan['price'],
            'currency' => 'TZS',
            'payment_status' => 'pending',
            'status' => 'pending',
            'order_id' => 'SUB-' . time() . '-' . $candidate->id,
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
                    'plan_type' => 'subscription',
                ],
            ]);

            if ($response && isset($response['success']) && $response['success']) {
                $appointment->update([
                    'transaction_id' => $response['transactionId'] ?? $appointment->order_id,
                ]);

                return redirect()->route('candidate.billing.index')
                    ->with('success', 'Payment initiated. Please complete the payment on your mobile device.');
            }

            throw new \Exception('Failed to initiate AzamPay mobile checkout');
        } elseif ($paymentMethod === 'bank') {
            $response = $this->azampayService->bankCheckout([
                'amount' => $appointment->amount,
                'currency' => 'TZS',
                'merchantAccountNumber' => config('azampay.merchant_account_number'),
                'merchantMobileNumber' => $candidate->phone ?? '255000000000',
                'merchantName' => config('azampay.app_name'),
                'externalId' => $appointment->order_id,
            ]);

            if ($response && isset($response['success']) && $response['success']) {
                return redirect()->route('candidate.billing.index')
                    ->with('success', 'Bank payment initiated. Please complete the transaction.');
            }

            throw new \Exception('Failed to initiate AzamPay bank checkout');
        } else {
            // Card checkout
            return redirect()->route('azampay.card.checkout', [
                'appointment' => $appointment->id,
            ]);
        }
    }
    
    public function cancel()
    {
        $candidate = auth()->user();
        
        // Cancel subscription logic
        // For now, just show confirmation
        
        return view('candidate.billing.cancel');
    }
    
    public function cancelConfirm(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);
        
        $candidate = auth()->user();
        
        // Cancel subscription
        // In a real system, you'd update subscription status here
        
        return redirect()->route('candidate.billing.index')
            ->with('success', 'Subscription cancelled successfully.');
    }
}
