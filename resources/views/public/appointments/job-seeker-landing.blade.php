@extends('layouts.public')

@section('title', 'Job Seeker Consultation - Coyzon')

@section('content')
    <div class="bg-white min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-slate-950 pt-24 pb-32 overflow-hidden">
            <!-- Background Effects -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-emerald-900/20 rounded-full blur-[120px]"></div>
                <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-blue-900/20 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-10%] left-[20%] w-[30%] h-[30%] bg-emerald-500/10 rounded-full blur-[100px]"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8 pt-4">
                    <a href="{{ route('public.appointments.index') }}"
                        class="text-gray-50 font-bold flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Badge -->
                

                <!-- Headline -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-8 leading-tight">
                    Your journey <br class="hidden md:block" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">
                        starts here.
                    </span>
                </h1>

                <!-- Subheading -->
                <p class="mt-6 text-xl text-slate-400 max-w-3xl mx-auto mb-12 leading-relaxed">
                    Whether you are looking for a job opportunity or planning to work or travel abroad, this is the right place to begin.
                    We provide professional guidance, transparent processes, and personalized support to help you make informed decisions and move forward with confidence.
                </p>

                <!-- CTA and Assurance Grid -->
                <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto items-stretch">
                    <!-- CTA Card -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 flex flex-col justify-center items-center text-center hover:bg-white/10 transition-colors group">
                        <h3 class="text-2xl font-bold text-white mb-3">Ready to Start?</h3>
                        <p class="text-slate-400 mb-6 text-sm">Book your 90-minute expert consultation today.</p>
                         <a href="{{ route('public.appointments.jobSeeker.form') }}"
                            class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-slate-900 bg-emerald-400 rounded-xl hover:bg-emerald-300 transition-all transform group-hover:-translate-y-1 shadow-lg shadow-emerald-500/20 w-full md:w-auto">
                            Start Booking Consultation
                        </a>
                    </div>

                    <!-- Assurance Card -->
                    <div class="bg-gradient-to-br from-emerald-950/50 to-slate-900/50 backdrop-blur-sm border border-emerald-500/20 rounded-3xl p-8 flex flex-col justify-center text-left hover:border-emerald-500/40 transition-colors">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-emerald-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Ethical & Structured</h3>
                        </div>
                        <p class="text-slate-300 text-lg leading-relaxed italic">
                            "Our approach is structured, ethical, and focused on aligning your profile with genuine opportunities. Every consultation is handled with care, clarity, and professionalism."
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
                            For <span class="text-gray-600 font-bold">TZS
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
                                ['title' => 'Personalized Career Consultation', 'desc' => 'Assess your skills, experience, and career goals to identify suitable overseas job opportunities.'],
                                ['title' => 'Job Matching & Industry Insights', 'desc' => 'Get advice on high-demand sectors, regions, and employers for your profile.'],
                                ['title' => 'Application & Document Guidance', 'desc' => 'Learn how to prepare CVs, cover letters, and necessary documents for international job applications.'],
                                ['title' => 'Work Abroad Visa Guidance', 'desc' => 'Understand visa requirements, processes, and documentation for working legally abroad.'],
                                ['title' => 'Interview & Recruitment Support', 'desc' => 'Receive practical tips for interviews, assessments, and employer expectations abroad.'],
                                ['title' => 'Professional & Confidential Handling', 'desc' => 'Your information is managed with care, professionalism, and full confidentiality.']
                            ],
                            'footer' => 'Book a Work Abroad consultation today and take the first step toward securing international employment opportunities.',
                            'color' => 'slate'
                        ],
                        [
                            'title' => 'STUDY ABROAD GUIDANCE',
                            'img' => 'study_abroad_consultation_new.jpg',
                            'desc' => 'Your Global Education Journey Starts Here. Planning to study abroad can be exciting but complex. From choosing the right program to understanding admission and visa requirements, there’s a lot to navigate. We provide professional, step-by-step guidance to help you secure the best study opportunities, prepare your application, and confidently take the next step in your academic journey.',
                            'features' => [
                                ['title' => 'Personalized Academic Consultation', 'desc' => 'Assess your qualifications, interests, and academic goals to identify the best study programs and countries for you.'],
                                ['title' => 'University & Program Selection Guidance', 'desc' => 'Receive advice on suitable universities, courses, scholarships, and admission criteria.'],
                                ['title' => 'Application & Document Support', 'desc' => 'Guidance on preparing admission applications, transcripts, recommendation letters, and personal statements.'],
                                ['title' => 'Study Visa Guidance', 'desc' => 'Step-by-step instructions on visa requirements, supporting documents, and submission processes to ensure compliance and success.'],
                                ['title' => 'Interview & Admission Preparation', 'desc' => 'Tips for university interviews, assessments, and other admission requirements.'],
                                ['title' => 'Professional & Confidential Handling', 'desc' => 'All information shared is handled with professionalism, care, and full confidentiality.']
                            ],
                            'footer' => 'Book a Study Abroad consultation today and start your journey toward an international education opportunity.',
                            'color' => 'slate'
                        ],
                        [
                            'title' => 'VISA APPLICATION GUIDANCE',
                            'img' => 'visa_guidance_consultation.png',
                            'desc' => 'Navigating visa applications can be complicated, stressful, and time-consuming but it doesn’t have to be. We provide professional guidance on how to successfully apply for a wide range of visas, including work, study, travel, and relocation visas.',
                            'features' => [
                                ['title' => 'Step-by-Step Guidance', 'desc' => 'Learn the complete process from eligibility checks to document preparation and submission.'],
                                ['title' => 'Document Preparation Support', 'desc' => 'Ensure all forms, supporting documents, and requirements are correctly completed.'],
                                ['title' => 'Visa Type Insights', 'desc' => 'Receive advice on different visa categories (work, student, skilled, travel, relocation) to select the one that fits your goals.'],
                                ['title' => 'Application Review & Strategy', 'desc' => 'Professional review of your application to minimize errors and maximize approval chances.'],
                                ['title' => 'Up-to-Date Information', 'desc' => 'Stay informed about changing visa regulations, embassy requirements, and processing timelines.'],
                                ['title' => 'Confidential & Professional Handling', 'desc' => 'Your personal information and application details are treated with the utmost confidentiality.']
                            ],
                            'footer' => 'Book a dedicated session with our visa specialists today and receive personalized guidance to confidently navigate your visa application.',
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
                            
                            <div class="space-y-4" x-data="{ expanded: false }">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">What You Will Get:</p>
                                <div class="grid gap-4">
                                    @foreach($card['features'] as $index => $feature)
                                    <div class="flex items-start gap-3" 
                                         @if($index >= 2) x-show="expanded" x-collapse x-cloak @endif>
                                        <span class="text-emerald-600 font-bold mt-1.5 leading-none">•</span>
                                        <div class="text-sm text-gray-800">
                                            <strong class="font-bold block mb-0.5 text-gray-900">{{ $feature['title'] }}</strong>
                                            <span class="text-gray-600 leading-snug">{{ $feature['desc'] }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @if(count($card['features']) > 2)
                                <button @click="expanded = !expanded" 
                                        class="text-emerald-600 text-sm font-bold flex items-center gap-1 hover:text-emerald-700 transition-colors mt-2">
                                    <span x-text="expanded ? 'View Less' : 'View More'">View More</span>
                                    <svg x-bind:class="expanded ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                @endif
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-200 italic text-xs text-gray-500">
                                {{ $card['footer'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Booking Flow Steps -->
        <div class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
                    <p class="text-lg text-slate-600">Your 90-minute expert consultation in 4 simple steps.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="relative p-6 pt-12 bg-slate-50 rounded-2xl border border-slate-100 h-full group hover:bg-emerald-50/50 hover:border-emerald-100 transition-colors duration-300">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-slate-950 text-white text-xl font-bold rounded-xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform">1</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3 mt-2">Fill the Form</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Complete our consultation request form with your details so we can understand your goals.</p>
                    </div>

                     <!-- Step 2 -->
                    <div class="relative p-6 pt-12 bg-slate-50 rounded-2xl border border-slate-100 h-full group hover:bg-emerald-50/50 hover:border-emerald-100 transition-colors duration-300">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-slate-950 text-white text-xl font-bold rounded-xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform">2</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3 mt-2">Choose & Pay</h3>
                         <p class="text-sm text-slate-600 leading-relaxed mb-3">Secure your session with <span class="font-bold text-emerald-700">TZS 30,000</span>.</p>
                         <div class="flex flex-wrap gap-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                            <span class="bg-white px-2 py-1 rounded border border-slate-200">Visa/MC</span>
                            <span class="bg-white px-2 py-1 rounded border border-slate-200">Mobile Money</span>
                         </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative p-6 pt-12 bg-slate-50 rounded-2xl border border-slate-100 h-full group hover:bg-emerald-50/50 hover:border-emerald-100 transition-colors duration-300">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-slate-950 text-white text-xl font-bold rounded-xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform">3</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3 mt-2">Expert Review</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Our team reviews your details to prepare for a strategic, high-value discussion.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative p-6 pt-12 bg-slate-50 rounded-2xl border border-slate-100 h-full group hover:bg-emerald-50/50 hover:border-emerald-100 transition-colors duration-300">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-slate-950 text-white text-xl font-bold rounded-xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform">4</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3 mt-2">Consultation</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">We verify your appointment and you join the professional session for actionable insights.</p>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <a href="{{ route('public.appointments.jobSeeker.form') }}"
                        class="inline-block px-10 py-5 bg-slate-950 hover:bg-slate-800 text-white font-bold rounded-full shadow-xl transition-all hover:-translate-y-1 text-xl ring-4 ring-emerald-100">
                        Start Booking Consultation 
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection