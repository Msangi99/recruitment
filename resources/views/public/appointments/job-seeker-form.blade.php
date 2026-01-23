@extends('layouts.public')

@section('title', 'Consultation Request Form - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('public.appointments.jobSeeker') }}"
                    class="text-gray-950 font-bold flex items-center shadow-sm w-fit px-3 py-1.5 bg-white rounded-lg transition-all hover:bg-gray-50 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Form Header -->
                <div class="bg-gradient-to-br from-emerald-950 to-emerald-900 px-6 py-6 relative overflow-hidden">
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

                <form action="{{ route('public.appointments.jobSeeker.store') }}" method="POST" class="p-5 md:p-6 space-y-5"
                    x-data="{ consultation_type: '' }">
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
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border">
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address<span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" required placeholder="Email Address"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number<span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="phone" required placeholder="+255..."
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border">
                                <p class="text-xs text-slate-500 mt-1">Hint: Include country code if outside Tanzania</p>
                            </div>
                        </div>

                        <!-- Nationality (Single Row) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nationality <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nationality" required placeholder="Nationality"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border">
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Details Section -->
                    <div class="space-y-4">


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Type of Consultation -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Type of Consultation <span
                                        class="text-red-500">*</span></label>
                                <select name="consultation_type" required x-model="consultation_type"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border bg-white">
                                    <option value="">Select Consultation Type</option>
                                    <option value="Career / Job Seeking">Career / Job Seeking</option>
                                    <option value="Work Abroad">Work Abroad</option>
                                    <option value="Study Abroad">Study Abroad</option>
                                    <option value="Visa Guidance">Visa Guidance</option>
                                </select>
                            </div>

                            <!-- Destination (Conditional) -->
                            <div x-show="['Work Abroad', 'Study Abroad', 'Visa Guidance'].includes(consultation_type)"
                                x-transition>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Destination / Target Country
                                    <span class="text-slate-500 font-normal">(optional / conditional)</span></label>
                                <input type="text" name="destination" placeholder="Which country are you targeting?"
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border">
                                <p class="text-xs text-slate-500 mt-1">Show only if consultation involves Work Abroad, Study
                                    Abroad, or Visa</p>
                            </div>

                            <!-- Preferred Mode -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Preferred Consultation Mode <span
                                        class="text-red-500">*</span></label>
                                <select name="consultation_mode" required
                                    class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border bg-white">
                                    <option value="">Select Mode</option>
                                    <option value="In-person">In-person</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Message / Special Requests <span
                                    class="text-slate-500 font-normal">(optional)</span></label>
                            <textarea name="message" rows="3"
                                placeholder="Let us know if you'd like to be prioritized or have specific questions for the consultation"
                                class="w-full rounded-lg border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-2 text-sm border"></textarea>
                            <p class="text-xs text-slate-500 mt-1">Hint: Providing details helps us prepare a personalized
                                session</p>
                        </div>
                    </div>



                    <!-- Submit Button -->
                    <div class="pt-2 flex flex-col items-center">
                        <button type="submit"
                            class="w-auto px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all text-sm tracking-wide uppercase flex items-center gap-2">
                            <span>Next: Payment</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
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