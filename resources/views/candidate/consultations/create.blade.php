@extends('layouts.app')

@section('title', 'Book Consultation - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="lg:ml-64 pt-16 lg:pt-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.consultations.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Consultations</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Book Career Consultation</h2>
                <p class="mt-1 text-sm text-gray-500">Schedule a paid consultation with our career advisors (TZS 30,000 or $12)</p>
            </div>

            <form method="POST" action="{{ route('candidate.consultations.store') }}" class="bg-white shadow-lg rounded-lg p-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="meeting_mode" class="block text-sm font-medium text-gray-700 mb-2">Meeting Mode *</label>
                        <select id="meeting_mode" name="meeting_mode" required 
                                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('meeting_mode') border-red-300 @enderror">
                            <option value="">Select Mode</option>
                            <option value="online" {{ old('meeting_mode') == 'online' ? 'selected' : '' }}>Online (Zoom/Google Meet)</option>
                            <option value="in-person" {{ old('meeting_mode') == 'in-person' ? 'selected' : '' }}>In-Person</option>
                        </select>
                        @error('meeting_mode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Preferred Date & Time *</label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" required min="{{ date('Y-m-d\TH:i') }}" 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('scheduled_at') border-red-300 @enderror">
                        @error('scheduled_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes) *</label>
                        <select id="duration_minutes" name="duration_minutes" required 
                                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('duration_minutes') border-red-300 @enderror">
                            <option value="30" {{ old('duration_minutes') == '30' ? 'selected' : '' }}>30 minutes</option>
                            <option value="45" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                            <option value="60" {{ old('duration_minutes') == '60' ? 'selected' : '' }}>1 hour</option>
                        </select>
                        @error('duration_minutes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="meeting_link_field" style="display: none;">
                        <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">Meeting Link (if available)</label>
                        <input type="url" id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/..." 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('meeting_link') border-red-300 @enderror">
                        @error('meeting_link')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="meeting_location_field" style="display: none;">
                        <label for="meeting_location" class="block text-sm font-medium text-gray-700 mb-2">Preferred Location</label>
                        <input type="text" id="meeting_location" name="meeting_location" value="{{ old('meeting_location') }}" placeholder="Office address..." 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('meeting_location') border-red-300 @enderror">
                        @error('meeting_location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="What would you like to discuss?" 
                                  class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Gateway Selection -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h3>
                        
                        <div class="mb-4">
                            <label for="payment_gateway" class="block text-sm font-medium text-gray-700 mb-2">Select Payment Gateway *</label>
                            <select id="payment_gateway" name="payment_gateway" required 
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('payment_gateway') border-red-300 @enderror">
                                <option value="">Choose Payment Gateway</option>
                                <option value="selcom" {{ old('payment_gateway') == 'selcom' ? 'selected' : '' }}>Selcom (M-Pesa, Tigo Pesa, Airtel Money, Halopesa, Card)</option>
                                <option value="azampay" {{ old('payment_gateway') == 'azampay' ? 'selected' : '' }}>AzamPay (M-Pesa, Tigo Pesa, Airtel, Bank, Card)</option>
                            </select>
                            @error('payment_gateway')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method Selection (for both gateways) -->
                        <div id="payment_method_section" style="display: none;">
                            <div class="mb-4">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                                <select id="payment_method" name="payment_method" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('payment_method') border-red-300 @enderror">
                                    <option value="">Select Method</option>
                                    <option value="mobile" {{ old('payment_method') == 'mobile' ? 'selected' : '' }}>Mobile Money</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card Payment</option>
                                    <span id="bank_option" style="display: none;">
                                        <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                    </span>
                                </select>
                                @error('payment_method')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mobile Money Provider -->
                            <div id="mobile_provider_field" style="display: none;" class="mb-4">
                                <label for="mobile_provider" class="block text-sm font-medium text-gray-700 mb-2">Mobile Provider *</label>
                                <select id="mobile_provider" name="mobile_provider" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('mobile_provider') border-red-300 @enderror">
                                    <option value="">Select Provider</option>
                                    <span id="selcom_providers">
                                        <option value="Mpesa" {{ old('mobile_provider') == 'Mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                        <option value="Tigo Pesa" {{ old('mobile_provider') == 'Tigo Pesa' ? 'selected' : '' }}>Tigo Pesa</option>
                                        <option value="Airtel Money" {{ old('mobile_provider') == 'Airtel Money' ? 'selected' : '' }}>Airtel Money</option>
                                        <option value="Halopesa" {{ old('mobile_provider') == 'Halopesa' ? 'selected' : '' }}>Halopesa</option>
                                    </span>
                                    <span id="azampay_providers" style="display: none;">
                                        <option value="Mpesa" {{ old('mobile_provider') == 'Mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                        <option value="Tigo Pesa" {{ old('mobile_provider') == 'Tigo Pesa' ? 'selected' : '' }}>Tigo Pesa</option>
                                        <option value="Airtel" {{ old('mobile_provider') == 'Airtel' ? 'selected' : '' }}>Airtel Money</option>
                                        <option value="Azampay" {{ old('mobile_provider') == 'Azampay' ? 'selected' : '' }}>Azampay</option>
                                    </span>
                                </select>
                                @error('mobile_provider')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Account Number for Mobile Money -->
                            <div id="account_number_field" style="display: none;" class="mb-4">
                                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}" 
                                       placeholder="e.g., 0625933171" 
                                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('account_number') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Enter your mobile money number</p>
                                @error('account_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                            <div class="mb-4">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                                <select id="payment_method" name="payment_method" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('payment_method') border-red-300 @enderror">
                                    <option value="">Select Method</option>
                                    <option value="mobile" {{ old('payment_method') == 'mobile' ? 'selected' : '' }}>Mobile Money</option>
                                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card Payment</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mobile Money Provider -->
                            <div id="mobile_provider_field" style="display: none;" class="mb-4">
                                <label for="mobile_provider" class="block text-sm font-medium text-gray-700 mb-2">Mobile Provider *</label>
                                <select id="mobile_provider" name="mobile_provider" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('mobile_provider') border-red-300 @enderror">
                                    <option value="">Select Provider</option>
                                    <option value="Mpesa" {{ old('mobile_provider') == 'Mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                    <option value="Tigo Pesa" {{ old('mobile_provider') == 'Tigo Pesa' ? 'selected' : '' }}>Tigo Pesa</option>
                                    <option value="Airtel" {{ old('mobile_provider') == 'Airtel' ? 'selected' : '' }}>Airtel Money</option>
                                    <option value="Azampay" {{ old('mobile_provider') == 'Azampay' ? 'selected' : '' }}>Azampay</option>
                                </select>
                                @error('mobile_provider')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Account Number for Mobile Money -->
                            <div id="account_number_field" style="display: none;" class="mb-4">
                                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}" 
                                       placeholder="e.g., 0625933171" 
                                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('account_number') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Enter your mobile money number</p>
                                @error('account_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-50 border border-indigo-200 rounded-md p-4">
                        <p class="text-sm text-indigo-800">
                            <strong>Payment Required:</strong> This consultation costs TZS 30,000 (or $12). You will be redirected to payment after submitting this form.
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('candidate.consultations.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Proceed to Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Meeting mode toggle
document.getElementById('meeting_mode').addEventListener('change', function() {
    const meetingLinkField = document.getElementById('meeting_link_field');
    const meetingLocationField = document.getElementById('meeting_location_field');
    
    if (this.value === 'online') {
        meetingLinkField.style.display = 'block';
        meetingLocationField.style.display = 'none';
    } else if (this.value === 'in-person') {
        meetingLinkField.style.display = 'none';
        meetingLocationField.style.display = 'block';
    } else {
        meetingLinkField.style.display = 'none';
        meetingLocationField.style.display = 'none';
    }
});

// Payment gateway toggle
const paymentGatewaySelect = document.getElementById('payment_gateway');
if (paymentGatewaySelect) {
    const paymentMethodSection = document.getElementById('payment_method_section');
    const selcomProviders = document.getElementById('selcom_providers');
    const azampayProviders = document.getElementById('azampay_providers');
    const bankOption = document.getElementById('bank_option');
    const paymentMethod = document.getElementById('payment_method');
    
    // Initialize on page load
    if (paymentGatewaySelect.value === 'selcom' || paymentGatewaySelect.value === 'azampay') {
        paymentMethodSection.style.display = 'block';
        
        if (paymentGatewaySelect.value === 'selcom') {
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
    
    paymentGatewaySelect.addEventListener('change', function() {
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
            const mobileProviderField = document.getElementById('mobile_provider_field');
            const accountNumberField = document.getElementById('account_number_field');
            if (mobileProviderField) mobileProviderField.style.display = 'none';
            if (accountNumberField) accountNumberField.style.display = 'none';
        } else {
            paymentMethodSection.style.display = 'none';
        }
    });
}

// Payment method toggle
const paymentMethodSelect = document.getElementById('payment_method');
if (paymentMethodSelect) {
    // Initialize on page load
    if (paymentMethodSelect.value === 'mobile') {
        const mobileProviderField = document.getElementById('mobile_provider_field');
        const accountNumberField = document.getElementById('account_number_field');
        if (mobileProviderField) mobileProviderField.style.display = 'block';
        if (accountNumberField) accountNumberField.style.display = 'block';
    }
    
    paymentMethodSelect.addEventListener('change', function() {
        const mobileProviderField = document.getElementById('mobile_provider_field');
        const accountNumberField = document.getElementById('account_number_field');
        
        if (this.value === 'mobile') {
            if (mobileProviderField) mobileProviderField.style.display = 'block';
            if (accountNumberField) accountNumberField.style.display = 'block';
        } else {
            if (mobileProviderField) mobileProviderField.style.display = 'none';
            if (accountNumberField) accountNumberField.style.display = 'none';
        }
    });
}

// Initialize meeting mode on page load
const meetingModeSelect = document.getElementById('meeting_mode');
if (meetingModeSelect && meetingModeSelect.value) {
    meetingModeSelect.dispatchEvent(new Event('change'));
}
</script>
        </div>
    </div>
    </div>
</div>
@endsection