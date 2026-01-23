@extends('layouts.public')

@section('title', 'Consultation Request Form - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('public.appointments.jobSeeker') }}"
                    class="text-blue-600 hover:text-blue-800 font-bold flex items-center shadow-sm w-fit px-3 py-1.5 bg-white rounded-lg transition-all hover:bg-gray-50 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Details
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Form Header -->
                <div class="bg-gradient-to-br from-emerald-950 to-emerald-900 px-6 py-10 relative overflow-hidden">
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-green-500/20 blur-3xl"></div>

                    <div class="relative z-10">
                        <h1 class="text-2xl font-black text-white uppercase tracking-tight mb-4">
                            Career Consultation
                        </h1>
                        <div class="space-y-4">
                            <p class="text-emerald-100 text-lg font-bold leading-tight">
                                Take the first step toward your career or international opportunity.
                            </p>
                            <p class="text-emerald-50/70 text-sm leading-relaxed">
                                Please fill in the form below to help us understand your job interests, career background,
                                or travel plans. This enables us to provide personalized guidance during your appointment.
                            </p>
                            <div class="text-emerald-400 text-xs font-bold uppercase tracking-wider pt-2">
                                All information shared is handled with professionalism and confidentiality.
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('public.appointments.jobSeeker.store') }}" method="POST" class="p-6 md:p-8 space-y-6"
                    x-data="{ consultation_type: '', payment_gateway: '', payment_method: '' }">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="space-y-4">
                        <div class="pb-2 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-tight">Personal Information</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Full Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" required placeholder="Full Name"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border">
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" required placeholder="Email Address"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Phone <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="phone" required placeholder="+255..."
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border">
                            </div>
                        </div>

                        <!-- Nationality (Single Row) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nationality <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nationality" required placeholder="Nationality"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border">
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Details Section -->
                    <div class="space-y-4">
                        <div class="pb-2 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-tight">Consultation Details</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Type of Consultation -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Type <span
                                        class="text-red-500">*</span></label>
                                <select name="consultation_type" required x-model="consultation_type"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border bg-white">
                                    <option value="">Select Option</option>
                                    <option value="Career / Job Seeking">Career / Job Seeking</option>
                                    <option value="Work Abroad">Work Abroad</option>
                                    <option value="Study Abroad">Study Abroad</option>
                                    <option value="Visa Guidance">Visa Guidance</option>
                                </select>
                            </div>

                            <!-- Preferred Mode -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Mode <span
                                        class="text-red-500">*</span></label>
                                <select name="consultation_mode" required
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border bg-white">
                                    <option value="">Select Mode</option>
                                    <option value="Online">Online (Zoom/Google Meet)</option>
                                    <option value="In-person">In-person</option>
                                </select>
                            </div>
                        </div>

                        <!-- Destination (Conditional) -->
                        <div x-show="['Work Abroad', 'Study Abroad', 'Visa Guidance'].includes(consultation_type)"
                            x-transition>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Target Country</label>
                            <input type="text" name="destination" placeholder="Target Country"
                                class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border">
                        </div>

                        <!-- Special Requests -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Message (Optional)</label>
                            <textarea name="message" rows="2" placeholder="Briefly explain your needs..."
                                class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border"></textarea>
                        </div>
                    </div>

                    <!-- Payment Section (Compact) -->
                    <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-200 space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Payment Selection</h2>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Fee: TZS
                                {{ number_format(\App\Models\Setting::get('consultation_price', 30000)) }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 1st Select: Gateway -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Gateway <span
                                        class="text-red-500">*</span></label>
                                <select name="payment_gateway" required x-model="payment_gateway"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border bg-white">
                                    <option value="">Select Gateway</option>
                                    <option value="selcom">Selcom</option>
                                    <option value="azampay">Azampay</option>
                                </select>
                            </div>

                            <!-- 2nd Select: Payment Method -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Method <span
                                        class="text-red-500">*</span></label>
                                <select name="payment_method" required x-model="payment_method"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border bg-white">
                                    <option value="">Select Method</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="card">Card (Visa/MasterCard)</option>
                                </select>
                            </div>
                        </div>

                        <!-- 3rd Field: Mobile Number (Conditional) -->
                        <div x-show="payment_method === 'mobile_money'" x-transition>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Payment Number <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="payment_phone" :required="payment_method === 'mobile_money'"
                                placeholder="Enter mobile number for payment"
                                class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2.5 text-sm border">
                        </div>

                        <label class="flex items-start text-xs text-slate-500 cursor-pointer">
                            <input type="checkbox" required
                                class="form-checkbox h-4 w-4 text-emerald-600 rounded border-gray-300 mt-0.5 mr-2">
                            <span>I confirm details are correct. Payment is non-refundable.</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all text-lg tracking-wide uppercase">
                            Pay & Book Now
                        </button>
                        <div class="mt-4 px-1 text-left">
                            <p class="text-xs text-gray-500 leading-relaxed italic">
                                Our team will review your request and confirm the appointment via email or phone.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
@endsection