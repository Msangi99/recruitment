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

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

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
                        <form method="POST" action="{{ route('candidate.billing.subscribe') }}" id="subscribe-form-{{ $plan['id'] }}">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                            
                            <!-- Payment Gateway Selection -->
                            <div class="mb-4 border-t border-gray-200 pt-4">
                                <label for="payment_gateway_{{ $plan['id'] }}" class="block text-sm font-medium text-gray-700 mb-2">Payment Gateway *</label>
                                <select id="payment_gateway_{{ $plan['id'] }}" name="payment_gateway" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('payment_gateway') border-red-300 @enderror">
                                    <option value="">Choose Gateway</option>
                                    <option value="selcom" {{ old('payment_gateway') == 'selcom' ? 'selected' : '' }}>Selcom (M-Pesa, Tigo Pesa, Airtel Money, Halopesa, Card)</option>
                                    <option value="azampay" {{ old('payment_gateway') == 'azampay' ? 'selected' : '' }}>AzamPay (M-Pesa, Tigo Pesa, Airtel, Bank, Card)</option>
                                </select>
                                @error('payment_gateway')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method Selection (for both gateways) -->
                            <div id="payment_method_section_{{ $plan['id'] }}" style="display: none;" class="mb-4">
                                <div class="mb-3">
                                    <label for="payment_method_{{ $plan['id'] }}" class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                                    <select id="payment_method_{{ $plan['id'] }}" name="payment_method" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('payment_method') border-red-300 @enderror">
                                        <option value="">Select Method</option>
                                        <option value="mobile" {{ old('payment_method') == 'mobile' ? 'selected' : '' }}>Mobile Money</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card Payment</option>
                                        <span id="bank_option_{{ $plan['id'] }}" style="display: none;">
                                            <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                        </span>
                                    </select>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mobile Money Provider -->
                                <div id="mobile_provider_field_{{ $plan['id'] }}" style="display: none;" class="mb-3">
                                    <label for="mobile_provider_{{ $plan['id'] }}" class="block text-sm font-medium text-gray-700 mb-2">Mobile Provider *</label>
                                    <select id="mobile_provider_{{ $plan['id'] }}" name="mobile_provider" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('mobile_provider') border-red-300 @enderror">
                                        <option value="">Select Provider</option>
                                        <span id="selcom_providers_{{ $plan['id'] }}">
                                            <option value="Mpesa" {{ old('mobile_provider') == 'Mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                            <option value="Tigo Pesa" {{ old('mobile_provider') == 'Tigo Pesa' ? 'selected' : '' }}>Tigo Pesa</option>
                                            <option value="Airtel Money" {{ old('mobile_provider') == 'Airtel Money' ? 'selected' : '' }}>Airtel Money</option>
                                            <option value="Halopesa" {{ old('mobile_provider') == 'Halopesa' ? 'selected' : '' }}>Halopesa</option>
                                        </span>
                                        <span id="azampay_providers_{{ $plan['id'] }}" style="display: none;">
                                            <option value="Mpesa" {{ old('mobile_provider') == 'Mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                            <option value="Tigo Pesa" {{ old('mobile_provider') == 'Tigo Pesa' ? 'selected' : '' }}>Tigo Pesa</option>
                                            <option value="Airtel" {{ old('mobile_provider') == 'Airtel' ? 'selected' : '' }}>Airtel Money</option>
                                            <option value="Azampay" {{ old('mobile_provider') == 'Azampay' ? 'selected' : '' }}>Azampay</option>
                                        </span>
                                    </select>
                                    @error('mobile_provider')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Account Number for Mobile Money -->
                                <div id="account_number_field_{{ $plan['id'] }}" style="display: none;" class="mb-3">
                                    <label for="account_number_{{ $plan['id'] }}" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                                    <input type="text" id="account_number_{{ $plan['id'] }}" name="account_number" value="{{ old('account_number') }}"
                                           placeholder="e.g., 0625933171" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('account_number') border-red-300 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Enter your mobile money number</p>
                                    @error('account_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full px-4 py-2 {{ $plan['id'] == 'premium' ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white rounded-md">
                                Subscribe Now
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle payment gateway selection for each plan
    ['basic', 'premium'].forEach(function(planId) {
        const gatewaySelect = document.getElementById('payment_gateway_' + planId);
        const paymentMethodSection = document.getElementById('payment_method_section_' + planId);
        const selcomProviders = document.getElementById('selcom_providers_' + planId);
        const azampayProviders = document.getElementById('azampay_providers_' + planId);
        const bankOption = document.getElementById('bank_option_' + planId);
        const paymentMethod = document.getElementById('payment_method_' + planId);
        const mobileProviderField = document.getElementById('mobile_provider_field_' + planId);
        const accountNumberField = document.getElementById('account_number_field_' + planId);
        
        if (gatewaySelect) {
            // Initialize on page load
            if (gatewaySelect.value === 'selcom' || gatewaySelect.value === 'azampay') {
                paymentMethodSection.style.display = 'block';
                
                if (gatewaySelect.value === 'selcom') {
                    if (selcomProviders) selcomProviders.style.display = 'inline';
                    if (azampayProviders) azampayProviders.style.display = 'none';
                    if (bankOption) bankOption.style.display = 'none';
                    // Remove bank option if exists
                    const bankOpt = paymentMethod.querySelector('option[value="bank"]');
                    if (bankOpt) bankOpt.remove();
                } else {
                    if (selcomProviders) selcomProviders.style.display = 'none';
                    if (azampayProviders) azampayProviders.style.display = 'inline';
                    if (bankOption) bankOption.style.display = 'inline';
                    // Add bank option if not exists
                    if (!paymentMethod.querySelector('option[value="bank"]')) {
                        const bankOpt = document.createElement('option');
                        bankOpt.value = 'bank';
                        bankOpt.textContent = 'Bank Transfer';
                        paymentMethod.appendChild(bankOpt);
                    }
                }
            }
            
            gatewaySelect.addEventListener('change', function() {
                if (this.value === 'selcom' || this.value === 'azampay') {
                    paymentMethodSection.style.display = 'block';
                    
                    // Show/hide providers based on gateway
                    if (this.value === 'selcom') {
                        if (selcomProviders) selcomProviders.style.display = 'inline';
                        if (azampayProviders) azampayProviders.style.display = 'none';
                        if (bankOption) bankOption.style.display = 'none';
                        // Remove bank option if exists
                        const bankOpt = paymentMethod.querySelector('option[value="bank"]');
                        if (bankOpt) bankOpt.remove();
                    } else {
                        if (selcomProviders) selcomProviders.style.display = 'none';
                        if (azampayProviders) azampayProviders.style.display = 'inline';
                        if (bankOption) bankOption.style.display = 'inline';
                        // Add bank option if not exists
                        if (!paymentMethod.querySelector('option[value="bank"]')) {
                            const bankOpt = document.createElement('option');
                            bankOpt.value = 'bank';
                            bankOpt.textContent = 'Bank Transfer';
                            paymentMethod.appendChild(bankOpt);
                        }
                    }
                    
                    // Clear fields when switching gateways
                    if (paymentMethod) paymentMethod.value = '';
                    if (mobileProviderField) mobileProviderField.style.display = 'none';
                    if (accountNumberField) accountNumberField.style.display = 'none';
                } else {
                    paymentMethodSection.style.display = 'none';
                }
            });
        }
        
        if (paymentMethod) {
            // Initialize on page load
            if (paymentMethod.value === 'mobile') {
                if (mobileProviderField) mobileProviderField.style.display = 'block';
                if (accountNumberField) accountNumberField.style.display = 'block';
            }
            
            paymentMethod.addEventListener('change', function() {
                if (this.value === 'mobile') {
                    if (mobileProviderField) mobileProviderField.style.display = 'block';
                    if (accountNumberField) accountNumberField.style.display = 'block';
                } else {
                    if (mobileProviderField) mobileProviderField.style.display = 'none';
                    if (accountNumberField) accountNumberField.style.display = 'none';
                }
            });
        }
    });
});
</script>
@endsection