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
                <div class="bg-green-600 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">Partnership / Agency Collaboration</h1>
                    <p class="text-green-100 mt-2">Explore recruitment partnership opportunities with us.</p>
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
                        <p class="mt-4 text-center text-sm text-gray-500 max-w-lg mx-auto">
                            <strong>Note:</strong> All partnership meeting requests are subject to review. Approved partners
                            will receive a calendar link to schedule a 30–45 minute meeting.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection