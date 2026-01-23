@extends('layouts.public')

@section('title', 'Partnership Request - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('public.appointments.index') }}"
                    class="text-green-600 hover:text-green-800 font-bold flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Options
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-br from-emerald-950 to-emerald-900 px-8 py-10 relative overflow-hidden">
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-40 w-40 bg-green-500/20 rounded-full blur-3xl"></div>

                    <div class="relative z-10">
                        <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-4">
                            Partnership Collaboration
                        </h1>
                        <div class="space-y-4">
                            <p class="text-emerald-100 text-lg font-bold leading-tight">
                                Let’s explore opportunities to work together.
                            </p>
                            <p class="text-emerald-50/70 text-sm leading-relaxed max-w-2xl">
                                Kindly complete the form below to share details about your organization and partnership
                                interests. This will help us prepare for a meaningful and strategic discussion.
                            </p>
                            <div class="text-emerald-400 text-xs font-bold uppercase tracking-wider pt-2">
                                All information shared is handled with professionalism and confidentiality.
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('public.appointments.storePartnership') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" required
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company / Agency Name</label>
                            <input type="text" name="company_name" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-3 border">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" required
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" required placeholder="e.g. +255 123 456 789"
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input type="text" name="country" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website / LinkedIn (Optional)</label>
                        <input type="url" name="website" placeholder="https://"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type of Partnership</label>
                        <select name="partnership_type" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            <option value="">Select Partnership Type</option>
                            <option value="Employer">Employer</option>
                            <option value="Recruitment Agency">Recruitment Agency</option>
                            <option value="Travel & Visa">Travel & Visa</option>
                            <option value="Training Institution">Training Institution</option>
                            <option value="NGO">NGO</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Experience in Recruitment</label>
                        <select name="experience" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            <option value="">Select Experience</option>
                            <option value="0-2">0-2 Years</option>
                            <option value="3-5">3-5 Years</option>
                            <option value="5-10">5-10 Years</option>
                            <option value="10+">10+ Years</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-lg font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                            Request Schedule Partnership Call
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
@endsection