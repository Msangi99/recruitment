@extends('layouts.public')

@section('title', $status === 'payment_failed' ? 'Payment Failed' : 'Payment Status - Coyzon')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            
            @if($status === 'pending_payment')
                {{-- Payment Initiated - Waiting for User Action --}}
                <div class="bg-amber-500 px-8 py-8 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold relative z-10">Payment Pending</h1>
                    <p class="text-amber-100 mt-2 text-lg relative z-10">{{ $message ?? 'Waiting for payment confirmation' }}</p>
                </div>

                <div class="p-8 space-y-6">
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-6 rounded-r-2xl">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-bold text-amber-900 mb-2">Action Required</p>
                                <p class="text-sm text-amber-800">Complete the payment on your phone by entering your PIN. This page will automatically update once payment is confirmed.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Appointment Details</p>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date & Time:</span>
                                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y @ H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-bold text-blue-600">TZS {{ number_format($request->amount) }}</span>
                            </div>
                        </div>
                    </div>

                    <button onclick="window.location.reload()" 
                        class="w-full py-4 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-all">
                        Refresh Status
                    </button>
                </div>

            @elseif($status === 'payment_failed')
                {{-- Payment Failed --}}
                <div class="bg-red-600 px-8 py-8 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold relative z-10">Payment Failed</h1>
                    <p class="text-red-100 mt-2 text-lg relative z-10">Unable to process your payment</p>
                </div>

                <div class="p-8 space-y-6">
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-2xl">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="font-bold text-red-900 mb-2">Error Details</p>
                                <p class="text-sm text-red-800 font-semibold mb-3">{{ $message ?? 'Payment initialization failed' }}</p>
                                
                                @if(isset($error_details) && $error_details)
                                    <details class="mt-4">
                                        <summary class="text-xs font-bold text-red-700 cursor-pointer hover:text-red-900 inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Show Technical Details
                                        </summary>
                                        <div class="mt-3 p-4 bg-red-100/50 rounded-xl border border-red-200">
                                            <p class="text-xs text-red-800 font-mono break-all leading-relaxed">{{ $error_details }}</p>
                                        </div>
                                    </details>
                                @endif

                                <div class="mt-4 p-3 bg-white rounded-lg border border-red-200">
                                    <p class="text-xs font-bold text-red-900 mb-1">Common Causes:</p>
                                    <ul class="text-xs text-red-700 space-y-1 list-disc list-inside">
                                        <li>Incorrect phone number for Mobile Money</li>
                                        <li>Insufficient balance</li>
                                        <li>Gateway configuration issue (check credentials in .env)</li>
                                        <li>Network connectivity problems</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('public.appointments.jobSeeker.form') }}" 
                            class="flex-1 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all text-center inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Try Again
                        </a>
                        <a href="{{ route('home') }}" 
                            class="flex-1 py-4 border-2 border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all text-center">
                            Go Home
                        </a>
                    </div>
                </div>

            @elseif($status === 'confirmed' || $status === 'completed')
                {{-- Payment Successful --}}
                <div class="bg-green-600 px-8 py-8 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold relative z-10">Payment Successful!</h1>
                    <p class="text-green-100 mt-2 text-lg relative z-10">Your consultation is confirmed</p>
                </div>

                <div class="p-8 space-y-6">
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-2xl">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-bold text-green-900 mb-2">Booking Confirmed</p>
                                <p class="text-sm text-green-800">We've sent a confirmation email to <strong>{{ $request->email }}</strong> with your meeting details.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Appointment Details</p>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Date & Time:</span>
                                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($request->requested_date)->format('l, M d, Y @ H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Type:</span>
                                <span class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $request->type) }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                <span class="text-gray-600 text-sm">Amount Paid:</span>
                                <span class="font-bold text-green-600 text-lg">TZS {{ number_format($request->amount) }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" 
                        class="block w-full py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl transition-all text-center">
                        Back to Home
                    </a>
                </div>

            @else
                {{-- Processing/Unknown State --}}
                <div class="bg-blue-600 px-8 py-8 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold relative z-10">Processing</h1>
                    <p class="text-blue-100 mt-2 text-lg relative z-10">{{ $message ?? 'Your booking is being processed' }}</p>
                </div>

                <div class="p-8 text-center">
                    <p class="text-gray-600 mb-6">Please wait while we confirm your payment...</p>
                    <button onclick="window.location.reload()" 
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all">
                        Refresh Status
                    </button>
                </div>
            @endif

        </div>

        {{-- Debug Information (Only in Dev) --}}
        @if(config('app.debug'))
            <div class="mt-6 bg-gray-800 text-white p-6 rounded-xl text-xs font-mono">
                <p class="font-bold mb-2">Debug Info:</p>
                <p>Status: {{ $status ?? 'N/A' }}</p>
                <p>Payment Status: {{ $request->payment_status ?? 'N/A' }}</p>
                <p>Request Status: {{ $request->status ?? 'N/A' }}</p>
                <p>Message: {{ $message ?? 'N/A' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection