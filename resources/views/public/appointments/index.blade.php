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
                    class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative overflow-hidden">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Employer or Client</h3>
                    <p class="text-gray-600 mb-8 flex-grow text-sm leading-relaxed italic">
                        Looking to hire qualified candidates or outsource recruitment support?<br>
                        Schedule a consultation with us to discuss your staffing needs, hiring plans, and how we can
                        deliver reliable, results-driven solutions for your business.
                    </p>
                    <a href="{{ route('public.appointments.employer') }}"
                        class="block w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
                        Book Employer Meeting
                    </a>
                </div>

                <!-- 2. Partnership / Collaboration -->
                <div
                    class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative overflow-hidden">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Partnership Meeting</h3>
                    <p class="text-gray-600 mb-8 flex-grow text-sm leading-relaxed italic">
                        Interested in collaborating, expanding opportunities, or building strategic partnerships?<br>
                        Book a partnership meeting to explore mutually beneficial opportunities and long-term collaboration
                        with our organization.
                    </p>
                    <a href="{{ route('public.appointments.partnership') }}"
                        class="block w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
                        Schedule Partnership Call
                    </a>
                </div>

                <!-- 3. Job Seekers & Travel Abroad -->
                <div
                    class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative overflow-hidden">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Job Seekers & Travel Abroad</h3>
                    <p class="text-gray-600 mb-8 flex-grow text-sm leading-relaxed italic">
                        Searching for job opportunities or planning to work or travel abroad?<br>
                        Book a professional consultation to receive expert guidance on job placement, recruitment processes,
                        and international travel support.
                    </p>
                    <a href="{{ route('public.appointments.jobSeeker') }}"
                        class="block w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
                        Book Career Consultation
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection