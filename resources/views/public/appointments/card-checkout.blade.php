@extends('layouts.app')

@section('title', 'Card Payment - COYZON')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-br from-emerald-950 to-emerald-900 px-6 py-6 text-white text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-green-500/20 blur-3xl"></div>
                <h1 class="text-xl font-bold uppercase tracking-wide relative z-10">Card Payment</h1>
                <p class="text-emerald-100/80 text-sm mt-1 relative z-10">Enter your card details to complete payment</p>
            </div>

            <div class="p-6 md:p-8">
                <!-- Amount Summary -->
                <div class="mb-6 bg-emerald-50 rounded-xl p-4 border border-emerald-100 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-emerald-800 font-bold uppercase">Amount Due</p>
                        <p class="text-2xl font-black text-emerald-600">
                            @php
                                $priceTsh = $appointment->amount ?? \App\Models\Setting::get('consultation_price', 30000);
                                $priceUsd = \App\Helpers\CurrencyHelper::convertTshToUsd($priceTsh);
                            @endphp
                            @if($priceUsd)
                                {{ \App\Helpers\CurrencyHelper::formatUsd($priceUsd) }} ≈
                            @endif
                            {{ number_format($priceTsh, 0) }} TZS
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>

                <!-- Card Form -->
                <form method="POST" action="{{ route('azampay.card.checkout.process', $appointment) }}">
                    @csrf

                    @if($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm">
                            @foreach($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Card Number -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="cardNumber">
                            Card Number
                        </label>
                        <input
                            type="text"
                            id="cardNumber"
                            name="cardNumber"
                            value="{{ old('cardNumber') }}"
                            placeholder="1234 5678 9012 3456"
                            maxlength="19"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('cardNumber') border-red-300 @enderror"
                            oninput="formatCardNumber(this)"
                            required
                        >
                    </div>

                    <!-- Cardholder Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="cardHolderName">
                            Cardholder Name
                        </label>
                        <input
                            type="text"
                            id="cardHolderName"
                            name="cardHolderName"
                            value="{{ old('cardHolderName', auth()->user()->name ?? '') }}"
                            placeholder="John Doe"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('cardHolderName') border-red-300 @enderror"
                            required
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Expiry Date -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="cardExpiry">
                                Expiry (MM/YY)
                            </label>
                            <input
                                type="text"
                                id="cardExpiry"
                                name="cardExpiry"
                                value="{{ old('cardExpiry') }}"
                                placeholder="12/25"
                                maxlength="7"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('cardExpiry') border-red-300 @enderror"
                                oninput="formatExpiry(this)"
                                required
                            >
                        </div>

                        <!-- CVV -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="cardCvv">
                                CVV
                            </label>
                            <input
                                type="text"
                                id="cardCvv"
                                name="cardCvv"
                                value="{{ old('cardCvv') }}"
                                placeholder="123"
                                maxlength="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('cardCvv') border-red-300 @enderror"
                                oninput="this.value = this.value.replace(/\D/g, '')"
                                required
                            >
                        </div>
                    </div>

                    <!-- Warning -->
                    <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl p-3 text-xs">
                        <p>
                            <strong>Security Notice:</strong> Your card details are sent directly to AzamPay's secure payment gateway.
                            We do not store your card information.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-green-600 text-white font-bold py-3 px-4 rounded-xl hover:from-emerald-700 hover:to-green-700 transition-all duration-200 shadow-lg"
                    >
                        Pay {{ number_format($priceTsh, 0) }} TZS
                    </button>

                    <p class="text-center text-gray-500 text-xs mt-4">
                        By proceeding, you agree to the payment terms and conditions.
                    </p>
                </form>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ url()->previous() ?? route('candidate.consultations.index') }}" class="text-emerald-700 hover:text-emerald-800 text-sm font-medium">
                ← Back
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function formatCardNumber(input) {
    let value = input.value.replace(/\D/g, '');
    let formatted = value.match(/.{1,4}/g)?.join(' ') || '';
    input.value = formatted;
}

function formatExpiry(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2);
    }
    input.value = value;
}
</script>
@endsection
