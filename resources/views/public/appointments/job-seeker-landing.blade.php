@extends('layouts.app')

@section('title', 'Job Seeker Consultation - Coyzon')

@section('content')
    <div class="bg-white min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-slate-900 py-24 overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 to-slate-800 opacity-90"></div>
                <!-- Decorative touches -->
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform translate-x-1/2 -translate-y-1/2">
                </div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                    Job Seeker & <br>
                    <span class="text-yellow-400">Overseas Work Consultation</span>
                </h1>
                <p class="mt-4 text-xl text-slate-300 max-w-2xl">
                    Get professional guidance on finding legal, safe, and suitable work opportunities abroad. We review your
                    profile, optimize your CV, and chart your career path.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('public.appointments.jobSeeker.form') }}"
                        class="px-8 py-4 bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-bold rounded-xl shadow-lg shadow-yellow-500/20 transition-all transform hover:-translate-y-1 text-lg text-center">
                        Start Booking Consultation
                    </a>
                    <span class="flex items-center justify-center text-slate-400 text-sm font-medium">
                        Fee: TZS 30,000 or $12
                    </span>
                </div>
            </div>
        </div>

        <!-- What You Get Section -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900">What You Get</h2>
                    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">This 60-75 minute session covers everything you need to
                        kickstart your international career.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Profile Assessment</h3>
                        <p class="text-gray-600 text-sm">We analyze your skills and experience to find the best countries
                            and job types for you.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Legal Pathways</h3>
                        <p class="text-gray-600 text-sm">Expert advice on visa requirements, legal processes, and avoiding
                            scams.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">CV Optimization</h3>
                        <p class="text-gray-600 text-sm">Review your CV to ensure it meets international standards and gets
                            you noticed.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Application Strategy</h3>
                        <p class="text-gray-600 text-sm">Learn where to apply, how to use job boards, and how to approach
                            international recruiters.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Flow Steps -->
        <div class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900">How It Works</h2>
                </div>

                <div class="space-y-12 relative">
                    <!-- Line -->
                    <div class="absolute left-8 top-8 bottom-8 w-0.5 bg-gray-200 hidden md:block"></div>

                    <!-- Step 1 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            1</div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-blue-600 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Fill the Consultation Form</h3>
                            <p class="mt-2 text-gray-600">Provide your details, work background, and goals so we can prepare
                                for your session.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            2</div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-blue-600 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Make Payment</h3>
                            <p class="mt-2 text-gray-600">Securely pay the consultation fee (TZS 30,000 or $12) via Mobile
                                Money or Card.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            3</div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-blue-600 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Book Your Slot</h3>
                            <p class="mt-2 text-gray-600">Choose a convenient date and time from our calendar.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-green-500 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-green-500 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Get Confirmation</h3>
                            <p class="mt-2 text-gray-600">Receive an email with your meeting link (Zoom/Google Meet) and
                                receipt.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <div
                        class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8 inline-block text-left text-sm text-yellow-800">
                        <strong>Disclaimer:</strong> We provide advice, guidance, and optimization. We do NOT guarantee
                        employment or visa approval, as these decisions lie with employers and government authorities.
                    </div>
                    <br>
                    <a href="{{ route('public.appointments.jobSeeker.form') }}"
                        class="inline-block px-10 py-5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-xl transition-transform hover:-translate-y-1 text-xl">
                        Proceed to Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection