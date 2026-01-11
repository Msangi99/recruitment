@extends('layouts.app')

@section('title', 'Billing & Subscription - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Billing & Subscription</h2>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Current Plan -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Current Plan</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $currentPlan['name'] }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('candidate.billing.upgrade') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Upgrade Plan
                        </a>
                        @if($currentPlan['type'] !== 'free')
                            <a href="{{ route('candidate.billing.cancel') }}" class="px-4 py-2 border border-red-300 text-red-700 rounded-md hover:bg-red-50">
                                Cancel Subscription
                            </a>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Consultations Used</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $currentPlan['consultations_used'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Spent</p>
                        <p class="text-2xl font-semibold text-gray-900">TZS {{ number_format($totalSpent, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment History</h3>
                    @if($payments->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction ID</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $payment->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($payment->appointment_type == 'subscription')
                                                {{ $payment->notes ?? 'Subscription' }}
                                            @else
                                                {{ ucfirst($payment->appointment_type) }} Consultation
                                            @endif
                                            @if($payment->scheduled_at)
                                                <div class="text-xs text-gray-500">
                                                    @if($payment->appointment_type == 'subscription')
                                                        Expires: {{ $payment->scheduled_at->format('M d, Y') }}
                                                    @else
                                                        {{ $payment->scheduled_at->format('M d, Y h:i A') }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $payment->payment_status == 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($payment->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->transaction_id ?? $payment->order_id ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No payment history yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection