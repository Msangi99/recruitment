@extends('layouts.public')

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

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                            Your journey <br>
                            <span class="text-yellow-400">starts here.</span>
                        </h1>
                        <p class="text-xl text-slate-300 mb-8 leading-relaxed">
                            Whether you are looking for a job opportunity or planning to work or travel abroad, this is the
                            right place to begin.
                            We provide professional guidance, transparent processes, and personalized support to help you
                            make informed decisions and move forward with confidence.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('public.appointments.jobSeeker.form') }}"
                                class="px-8 py-4 bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-bold rounded-xl shadow-lg shadow-yellow-500/20 transition-all transform hover:-translate-y-1 text-lg text-center">
                                Start Booking Consultation
                            </a>

                        </div>
                    </div>

                    <div class="bg-white/5 backdrop-blur-md rounded-3xl p-8 border border-white/10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Professional Assurance</h3>
                        </div>
                        <p class="text-slate-300 text-lg leading-relaxed italic">
                            "Our approach is structured, ethical, and focused on aligning your profile with genuine
                            opportunities. Every consultation is handled with care, clarity, and professionalism."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- What You Get Section -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900">What You Get</h2>
                    <div class="max-w-3xl mx-auto">
                        <p class="text-xl font-bold text-slate-800 mb-2">90-Minute Expert Consultation – Professional,
                            Personalized, Confidential</p>
                        <p class="text-gray-600">
                            Get clear guidance on career, work abroad, study abroad, or visa matters.
                            Every session is designed to deliver actionable insights with the highest level of
                            professionalism and privacy.
                            For <span class="text-blue-600 font-bold">TZS
                                {{ number_format(\App\Models\Setting::get('consultation_price', 30000), 0) }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach([
                        [
                            'title' => 'WORK ABROAD GUIDANCE',
                            'img' => 'work_abroad_consultation.png',
                            'desc' => 'Looking for meaningful work opportunities abroad? Navigating international employment can be challenging, from understanding job requirements to securing the right visa. We provide professional guidance, step-by-step support, and personalized advice to help you take your career or labor journey abroad with confidence.',
                            'features' => [
                                'Personalized Career Consultation',
                                'Job Matching & Industry Insights',
                                'Application & Document Guidance',
                                'Work Abroad Visa Guidance',
                                'Interview & Recruitment Support',
                                'Professional & Confidential Handling'
                            ],
                            'color' => 'slate'
                        ],
                        [
                            'title' => 'STUDY ABROAD GUIDANCE',
                            'img' => 'study_abroad_consultation.png',
                            'desc' => 'Your Global Education Journey Starts Here. Planning to study abroad can be exciting but complex. From choosing the right program to understanding admission and visa requirements, there’s a lot to navigate. We provide professional, step-by-step guidance to help you secure the best study opportunities, prepare your application, and confidently take the next step in your academic journey.',
                            'features' => [
                                'Personalized Academic Consultation',
                                'University & Program Selection Guidance',
                                'Application & Document Support',
                                'Study Visa Guidance',
                                'Interview & Admission Preparation',
                                'Professional & Confidential Handling'
                            ],
                            'color' => 'slate'
                        ],
                        [
                            'title' => 'VISA APPLICATION GUIDANCE',
                            'img' => 'visa_guidance_consultation.png',
                            'desc' => 'Navigating visa applications can be complicated, stressful, and time-consuming but it doesn’t have to be. We provide professional guidance on how to successfully apply for a wide range of visas, including work, study, travel, and relocation visas.',
                            'features' => [
                                'Step-by-Step Guidance',
                                'Document Preparation Support',
                                'Visa Type Insights',
                                'Application Review & Strategy',
                                'Up-to-Date Information',
                                'Confidential & Professional Handling'
                            ],
                            'color' => 'slate'
                        ]
                    ] as $card)
                    <div class="bg-gray-100/50 rounded-[2.5rem] overflow-hidden shadow-xl border border-gray-200 group transition-all duration-500 hover:-translate-y-2 flex flex-col">
                        <div class="h-64 relative overflow-hidden">
                            <img src="{{ asset($card['img']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $card['title'] }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent"></div>
                            <div class="absolute bottom-6 left-8 right-8">
                                <h3 class="text-xl font-bold text-white uppercase tracking-tighter leading-tight">{{ $card['title'] }}</h3>
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <p class="text-gray-700 text-sm mb-6 leading-relaxed">
                                {{ $card['desc'] }}
                            </p>
                            
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">What You Will Get:</p>
                                <div class="grid gap-3">
                                    @foreach($card['features'] as $feature)
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-800">{{ $feature }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-200 italic text-xs text-gray-500">
                                Book a consultation today and take the first step toward your global goals.
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Booking Flow Steps -->
        <div class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900">How It Works – 90-Minute Expert Consultation</h2>
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
                            <h3 class="text-xl font-bold text-gray-900">Fill the Form</h3>
                            <p class="mt-2 text-gray-600">Complete our consultation request form with your details and the type of session you need (Career, Work Abroad, Study Abroad, or Visa Guidance). This helps us tailor the session to your goals.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            2</div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-blue-600 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Make Your Payment</h3>
                            <p class="mt-2 text-gray-600">Secure your 90-minute consultation by paying <span class="font-bold text-slate-800">$12 or 30,000 TZS</span>. We accept:</p>
                            <div class="mt-3 flex flex-wrap gap-4 text-sm font-medium text-slate-600">
                                <span class="bg-slate-100 px-3 py-1 rounded-md">Visa & MasterCard</span>
                                <span class="bg-slate-100 px-3 py-1 rounded-md">Mobile Money: M-Pesa, Airtel Money, HaloPesa, AzamPay</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            3</div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-blue-600 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Choose Your Slot</h3>
                            <p class="mt-2 text-gray-600">Select a date and time that works best for you from the available slots.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            4</div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-blue-600 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Receive Confirmation</h3>
                            <p class="mt-2 text-gray-600">Once payment is complete and your slot is chosen, you will receive a confirmation email or SMS with your consultation details.</p>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="relative flex items-start">
                        <div
                            class="hidden md:flex items-center justify-center w-16 h-16 rounded-full bg-green-500 text-white font-bold text-xl border-4 border-white shadow-lg absolute -left-8 z-10">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4 md:ml-16 pl-4 border-l-2 border-green-500 md:border-l-0">
                            <h3 class="text-xl font-bold text-gray-900">Attend Your Session</h3>
                            <p class="mt-2 text-gray-600">Join your 90-minute professional consultation. Get personalized guidance, actionable insights, and confidentiality guaranteed.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    
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