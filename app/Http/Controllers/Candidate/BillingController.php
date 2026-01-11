<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $candidate = auth()->user();
        
        // Get payment history from appointments
        $payments = Appointment::where('user_id', $candidate->id)
            ->where('appointment_type', 'consultation')
            ->whereNotNull('amount')
            ->latest()
            ->paginate(10);
        
        // Calculate total spent
        $totalSpent = Appointment::where('user_id', $candidate->id)
            ->where('appointment_type', 'consultation')
            ->where('payment_status', 'completed')
            ->sum('amount');
        
        // Get current plan status (for now, based on consultations)
        // In future, this can be linked to a subscription model
        $currentPlan = [
            'name' => 'Free Plan',
            'type' => 'free',
            'consultations_used' => Appointment::where('user_id', $candidate->id)
                ->where('appointment_type', 'consultation')
                ->where('payment_status', 'completed')
                ->count(),
            'consultations_limit' => null, // Unlimited for now
        ];
        
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
        ]);
        
        $candidate = auth()->user();
        
        // Get plan details
        $plans = [
            'basic' => ['price' => 50000, 'name' => 'Basic Plan'],
            'premium' => ['price' => 100000, 'name' => 'Premium Plan'],
        ];
        
        $plan = $plans[$validated['plan_id']];
        
        // Create subscription appointment/transaction
        // In a real system, you'd create a subscription record here
        // For now, redirect to payment
        
        return redirect()->route('candidate.billing.index')
            ->with('info', 'Subscription feature coming soon. For now, you can book consultations individually.');
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
