@extends('layouts.app')

@section('title', 'Upgrade Plan - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.billing.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Billing</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Upgrade Your Plan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white shadow rounded-lg p-6 {{ $plan['id'] == 'premium' ? 'ring-2 ring-indigo-500' : '' }}">
                        @if($plan['id'] == 'premium')
                            <div class="mb-4">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">POPULAR</span>
                            </div>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                        <div class="mb-4">
                            <span class="text-3xl font-bold text-gray-900">{{ $plan['currency'] }} {{ number_format($plan['price'], 0) }}</span>
                            <span class="text-gray-500">/month</span>
                        </div>
                        <ul class="space-y-2 mb-6">
                            @foreach($plan['features'] as $feature)
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <form method="POST" action="{{ route('candidate.billing.subscribe') }}">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                            <button type="submit" class="w-full px-4 py-2 {{ $plan['id'] == 'premium' ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white rounded-md">
                                Subscribe Now
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>Note:</strong> Subscription plans are coming soon. Currently, you can book consultations individually. 
                    Each consultation costs TZS 30,000 (or $12).
                </p>
            </div>
        </div>
    </div>
</div>
@endsection