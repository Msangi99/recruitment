@extends('layouts.public')

@section('title', 'Select Payment Method - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Header -->
                <div
                    class="bg-gradient-to-br from-emerald-950 to-emerald-900 px-6 py-6 text-white text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-green-500/20 blur-3xl"></div>
                    <h1 class="text-xl font-bold uppercase tracking-wide relative z-10">Complete Your Payment</h1>
                    <p class="text-emerald-100/80 text-sm mt-1 relative z-10">Choose a method to pay the consultation fee
                    </p>
                </div>

                <div class="p-6 md:p-8">
                    <div
                        class="mb-6 bg-emerald-50 rounded-xl p-4 border border-emerald-100 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-emerald-800 font-bold uppercase">Amount Due</p>
                            <p class="text-2xl font-black text-emerald-600">
                                @php
                                    $priceTsh = \App\Models\Setting::get('consultation_price', 30000);
                                    $priceUsd = \App\Helpers\CurrencyHelper::convertTshToUsd($priceTsh);
                                @endphp
                                @if($priceUsd)
                                    {{ \App\Helpers\CurrencyHelper::formatUsd($priceUsd) }} ≈
                                @endif
                                TZS {{ number_format($priceTsh) }}
                            </p>
                        </div>
                        <div class="bg-white p-2 rounded-lg shadow-sm">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <form action="{{ route('public.appointments.jobSeeker.payment.process', ['id' => $request->id]) }}"
                        method="POST" class="space-y-6" x-data="{ payment_gateway: '', payment_method: '' }">
                        @csrf

                        <!-- Gateway Selection -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Payment
                                Gateway</label>
                            <div class="grid grid-cols-2 gap-3">
                                {{-- <label class="cursor-pointer relative">
                                    <input type="radio" name="payment_gateway" value="selcom" x-model="payment_gateway"
                                        class="peer sr-only" required>
                                    <div
                                        class="p-4 rounded-xl border-2 border-gray-100 hover:border-emerald-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                                        <div class="font-bold text-slate-700">Selcom</div>
                                        <span class="text-[10px] text-slate-400 font-medium">Card / Mobile / USSD</span>
                                    </div>
                                    <div
                                        class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label> --}}

                                <label class="cursor-pointer relative">
                                    <input type="radio" name="payment_gateway" value="azampay" x-model="payment_gateway"
                                        class="peer sr-only" required>
                                    <div
                                        class="p-4 rounded-xl border-2 border-gray-100 hover:border-emerald-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                                        <div class="font-bold text-slate-700">AzamPay</div>
                                        <span class="text-[10px] text-slate-400 font-medium">Card / M-Pesa / Tigo /
                                            Airtel</span>
                                    </div>
                                    <div
                                        class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Method Selection -->
                        <div x-show="payment_gateway" x-transition class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Payment
                                    Method</label>
                                <select name="payment_method" required x-model="payment_method"
                                    class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 text-sm border bg-white font-medium text-slate-700">
                                    <option value="">Select Method</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <template x-if="payment_gateway === 'selcom' || payment_gateway === 'azampay'">
                                        <option value="card">Card (Visa/MasterCard)</option>
                                    </template>
                                </select>
                            </div>

                            <!-- Mobile Number -->
                            <div x-show="payment_method === 'mobile_money'" x-transition>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Mobile
                                    Number <span class="text-red-500">*</span></label>
                                <input type="text" name="payment_phone" :required="payment_method === 'mobile_money'"
                                    placeholder="e.g 2557..." value="{{ $request->phone ?? '' }}"
                                    class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 text-sm border font-medium text-slate-700">
                                <p class="text-[10px] text-slate-400 mt-1">Please ensure this number has sufficient balance.
                                </p>
                            </div>
                        </div>


                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all text-sm tracking-wide uppercase flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Pay & Initiate
                            </button>
                            <div class="mt-4 text-center">
                                <a href="{{ route('public.appointments.jobSeeker.form') }}"
                                    class="text-xs text-slate-400 hover:text-slate-600 font-medium">Cancel and go back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection