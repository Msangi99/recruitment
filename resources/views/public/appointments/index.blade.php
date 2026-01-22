@extends('layouts.public')

@section('title', 'Book Appointment - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Book an Appointment</h1>
                <div class="w-20 h-1.5 bg-green-600 mx-auto rounded-full mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Ready to take the next step?<br>
                    Book a one-on-one appointment with our team and get personalized guidance, clear solutions,
                    and professional support tailored to your goals.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">

                <!-- 1. Employer / Client Consultation -->
                <div
                    class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col">
                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Employer or Client</h3>
                    <p class="text-gray-600 mb-8 flex-grow">
                        Looking to hire qualified candidates or outsource recruitment support?<br>
                        Schedule a consultation with us to discuss your staffing needs, hiring plans, and how we can
                        deliver reliable, results-driven solutions for your business.
                    </p>
                    <a href="{{ route('public.appointments.employer') }}"
                        class="block w-full py-4 bg-green-600 hover:bg-green-700 text-white text-center font-bold rounded-xl transition-colors shadow-lg shadow-green-500/30">
                        Book Employer Meeting
                    </a>
                </div>

                <!-- 2. Partnership / Collaboration -->
                <div
                    class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col">
                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Partnership Meeting</h3>
                    <p class="text-gray-600 mb-8 flex-grow text-sm leading-relaxed">
                        Interested in collaborating, expanding opportunities, or building strategic partnerships?<br>
                        Book a partnership meeting to explore mutually beneficial opportunities and long-term collaboration
                        with our organization.
                    </p>
                    <a href="{{ route('public.appointments.partnership') }}"
                        class="block w-full py-4 bg-green-600 hover:bg-green-700 text-white text-center font-bold rounded-xl transition-colors shadow-lg shadow-green-500/30">
                        Schedule Partnership Call
                    </a>
                </div>

                <!-- 3. Job Seeker (Paid) -->
                <div
                    class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl shadow-xl border border-slate-700 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative overflow-hidden">

                    <div
                        class="absolute top-0 right-0 bg-yellow-500 text-xs font-bold px-3 py-1 rounded-bl-lg text-slate-900 uppercase tracking-wide">
                        Premium
                    </div>
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Job Seekers & Travel Abroad</h3>
                    <p class="text-slate-300 mb-8 flex-grow text-sm leading-relaxed">
                        Searching for job opportunities or planning to work or travel abroad?<br>
                        Book an appointment to receive professional guidance on job placement, recruitment processes, and
                        international travel support.
                    </p>
                    <a href="{{ route('public.appointments.jobSeeker') }}"
                        class="block w-full py-4 bg-yellow-500 hover:bg-yellow-400 text-slate-900 text-center font-bold rounded-xl transition-colors shadow-lg shadow-yellow-500/30">
                        Book Career Consultation
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection