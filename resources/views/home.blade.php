<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coyzon - Professional Overseas Recruitment Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <style>
        @keyframes fadeSlide {

            0%,
            100% {
                opacity: 0.3;
            }

            50% {
                opacity: 1;
            }
        }

        .hero-image {
            animation: fadeSlide 6s ease-in-out infinite;
        }

        .hero-image:nth-child(2) {
            animation-delay: 2s;
        }

        .hero-image:nth-child(3) {
            animation-delay: 4s;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</head>

<body class="bg-white text-gray-900">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-20 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">Coyzon</span>
                    </a>
                </div>
                <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                    <a href="{{ route('about') }}" class="text-blue-600 hover:text-blue-800 font-bold">About Us</a>
                    <a href="{{ route('public.jobs.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Find Candidate</a>
                    <a href="{{ route('candidate.consultations.create') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Book Appointment</a>
                    <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 font-bold">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Dynamic Hero Carousel -->
    <section class="relative h-[85vh] min-h-[600px] w-full overflow-hidden bg-slate-900" 
             x-data="{ activeSlide: 0, slidesCount: 4 }"
             x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slidesCount }, 6000)">
        
        <!-- Background Slides -->
        <div class="absolute inset-0 z-0">
            <!-- Slide 0: Agriculture -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="activeSlide === 0 ? 'opacity-100' : 'opacity-0'">
                <img src="{{ asset('hero_agriculture_workers_1768667381546.png') }}" class="h-full w-full object-cover" alt="Agriculture">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>
            
            <!-- Slide 1: Construction -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="activeSlide === 1 ? 'opacity-100' : 'opacity-0'" x-cloak>
                <img src="{{ asset('hero_construction_workers_1768667395123.png') }}" class="h-full w-full object-cover" alt="Construction">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>

            <!-- Slide 2: Logistics -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="activeSlide === 2 ? 'opacity-100' : 'opacity-0'" x-cloak>
                <img src="{{ asset('hero_logistics_warehouse_1768667413235.png') }}" class="h-full w-full object-cover" alt="Logistics">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>

            <!-- Slide 3: HR & Recruitment -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out" :class="activeSlide === 3 ? 'opacity-100' : 'opacity-0'" x-cloak>
                <img src="{{ asset('hero_hr_interviews_1768667429733.png') }}" class="h-full w-full object-cover" alt="HR & Recruitment">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>
        </div>

        <!-- Content Overlay -->
        <div class="relative z-10 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
            <div class="max-w-3xl space-y-8">
                <!-- Hero Headline -->
                <div class="space-y-2">
                    <p class="text-blue-400 font-bold uppercase tracking-widest text-sm">
                        Section: Home / Hero Visuals
                    </p>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight">
                        Connecting Global Employers <br> 
                        <span class="text-blue-500">with Qualified Talent</span>
                    </h1>
                </div>

                <!-- Category Spotlight -->
                <div class="relative h-24 flex items-center">
                    <!-- Agriculture Label -->
                    <div x-show="activeSlide === 0" 
                         x-transition:enter="transition ease-out duration-1000 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-500 transform absolute"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4"
                         class="flex flex-col">
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90" style="font-family: 'Dancing Script', cursive;">Agriculture</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Feeding the world with skilled hands.</p>
                    </div>
                    <!-- Construction Label -->
                    <div x-show="activeSlide === 1" 
                         x-transition:enter="transition ease-out duration-1000 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-500 transform absolute"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4"
                         class="flex flex-col" x-cloak>
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90" style="font-family: 'Dancing Script', cursive;">Construction</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Building foundations for a better future.</p>
                    </div>
                    <!-- Logistics Label -->
                    <div x-show="activeSlide === 2" 
                         x-transition:enter="transition ease-out duration-1000 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-500 transform absolute"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4"
                         class="flex flex-col" x-cloak>
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90" style="font-family: 'Dancing Script', cursive;">Logistics</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Connecting markets with seamless flow.</p>
                    </div>
                    <!-- HR Label -->
                    <div x-show="activeSlide === 3" 
                         x-transition:enter="transition ease-out duration-1000 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-500 transform absolute"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4"
                         class="flex flex-col" x-cloak>
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90" style="font-family: 'Dancing Script', cursive;">HR & Recruitment</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Connecting global talent with opportunity.</p>
                    </div>
                </div>

                <!-- Sub-headline -->
                <p class="text-lg md:text-xl text-slate-300 max-w-2xl leading-relaxed">
                    Coyzon is a licensed recruitment agency specializing in sourcing, screening, and placing qualified candidates for employers across diverse sectors worldwide.
                </p>

                <!-- Primary CTA (Buttons) -->
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('public.jobs.index') }}"
                        class="px-8 py-4 bg-blue-600 text-white text-lg font-bold rounded-xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 transition-all hover:-translate-y-1">
                        Find a Job
                    </a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="px-8 py-4 bg-white text-slate-900 text-lg font-bold rounded-xl hover:bg-slate-100 shadow-xl transition-all hover:-translate-y-1">
                        Find a Candidate
                    </a>
                </div>

                <!-- Quick Stats / Trust Indicators -->
                <div class="pt-8 flex items-center gap-8 text-white/60 text-sm font-semibold uppercase tracking-wider">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="h-5 w-5 text-blue-500"></i>
                        Licensed Agency
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="globe" class="h-5 w-5 text-blue-500"></i>
                        Global Reach
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="users" class="h-5 w-5 text-blue-500"></i>
                        Verified Talent
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <div class="absolute bottom-10 right-10 flex gap-2 z-20">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="h-1.5 transition-all duration-300 rounded-full"
                        :class="activeSlide === index ? 'w-12 bg-blue-500' : 'w-4 bg-white/30 hover:bg-white/50'">
                </button>
            </template>
        </div>
    </section>



    <!-- About Us Section -->
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div>
                        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">ABOUT US</h2>
                    </div>
                    
                    <div class="space-y-6 text-lg text-slate-600 leading-relaxed">
                        <p>
                            At Coyzon, we believe in connecting people to the right opportunities. Built on professionalism, transparency, and trust, we specialize in delivering reliable recruitment solutions that bridge employers with skilled and verified talent locally and internationally.
                        </p>
                        <p>
                            We understand that every organization has unique workforce needs. That's why our approach is tailored, strategic, and results-oriented. From sourcing top candidates to conducting thorough screenings and ensuring seamless placements, we streamline the entire recruitment process with precision and integrity.
                        </p>
                        <p>
                            Beyond serving employers, Coyzon is equally committed to supporting job seekers. We guide candidates through credible career opportunities, ensure fair recruitment practices, and connect them with employers who value their skills and potential. Our goal is to create long-term success for both talent and organizations.
                        </p>
                        <p>
                            Our team of HR and talent acquisition specialists is dedicated to delivering qualified professionals who bring real value to businesses, while helping individuals access meaningful employment opportunities worldwide.
                        </p>
                        <p class="text-slate-900 font-bold">
                            Professional. Transparent. Reliable.<br>
                            Coyzon — Your trusted partner in global recruitment excellence.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div class="bg-blue-600 aspect-square rounded-3xl flex flex-col items-center justify-center text-white p-8 text-center shadow-2xl shadow-blue-500/20">
                            <i data-lucide="eye" class="h-12 w-12 mb-4"></i>
                            <h3 class="text-xl font-bold mb-2 uppercase tracking-wider">OUR VISION</h3>
                        </div>
                        <div class="bg-slate-100 aspect-square rounded-3xl p-8 flex flex-col justify-center">
                            <p class="text-slate-900 font-bold leading-tight">To become the leading global recruitment gateway connecting organizations with exceptional talent through professionalism, integrity, and an impactful workforce Solutions.</p>
                        </div>
                    </div>
                    <div class="space-y-6 pt-12">
                        <div class="bg-indigo-600 aspect-square rounded-3xl flex flex-col items-center justify-center text-white p-8 text-center shadow-2xl shadow-indigo-500/20">
                            <i data-lucide="target" class="h-12 w-12 mb-4"></i>
                            <h3 class="text-xl font-bold mb-2 uppercase tracking-wider">OUR MISSION</h3>
                        </div>
                        <div class="bg-slate-100 aspect-square rounded-3xl p-8 flex flex-col justify-center">
                            <p class="text-slate-900 font-bold leading-tight">To deliver trusted, efficient, and transparent recruitment services that empower employers to build strong teams and help candidates access real, life-changing career opportunities across the world.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-slate-900 mb-4">OUR CORE VALUES</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Professionalism -->
                <div class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors duration-500">
                        <i data-lucide="award" class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">1. Professionalism</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We maintain the highest standards in every step of the recruitment process.
                    </p>
                </div>

                <!-- Integrity -->
                <div class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-500">
                        <i data-lucide="shield-check" class="h-8 w-8 text-emerald-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">2. Integrity</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We operate with honesty, transparency, and accountability, ensuring trust for both employers and candidates.
                    </p>
                </div>

                <!-- Reliability -->
                <div class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 transition-colors duration-500">
                        <i data-lucide="clock" class="h-8 w-8 text-amber-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">3. Reliability</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We deliver consistent results, offering timely and dependable recruitment solutions.
                    </p>
                </div>

                <!-- Partnership -->
                <div class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-500">
                        <i data-lucide="handshake" class="h-8 w-8 text-indigo-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">4. Partnership</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We work closely with employers and agencies to understand their needs and provide tailored workforce solutions through matching organizations with verified, skilled, and committed candidates who add real value.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Do (Short) Overview -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] p-10 md:p-16 shadow-2xl border border-slate-100 flex flex-col lg:flex-row items-center gap-12">
                <div class="flex-1 space-y-6">
                    <h2 class="text-4xl font-extrabold text-slate-900">What We Do</h2>
                    <p class="text-xl text-slate-600 leading-relaxed">
                        <span class="text-blue-600 font-bold">Coyzon</span> is a licensed recruitment agency specializing in sourcing, screening, and placing qualified candidates for employers across diverse sectors worldwide. 
                        We ensure every match drives professional growth and organizational success through compliant and ethical processes.
                    </p>
                    <div class="flex flex-wrap gap-8 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i data-lucide="globe" class="h-5 w-5 text-blue-600"></i>
                            </div>
                            <span class="font-bold text-slate-700">Global Reach</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                <i data-lucide="shield-check" class="h-5 w-5 text-emerald-600"></i>
                            </div>
                            <span class="font-bold text-slate-700">Verified Talent</span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0 grid grid-cols-2 gap-6 w-full lg:w-auto">
                    <div class="bg-blue-600 p-8 rounded-[2rem] text-center text-white shadow-xl shadow-blue-500/20">
                        <p class="text-5xl font-black mb-1">500+</p>
                        <p class="text-sm font-bold opacity-80 uppercase tracking-widest text-blue-100">Placements</p>
                    </div>
                    <div class="bg-slate-900 p-8 rounded-[2rem] text-center text-white shadow-xl">
                        <p class="text-5xl font-black mb-1">15+</p>
                        <p class="text-sm font-bold opacity-80 uppercase tracking-widest text-slate-400">Countries</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Recruitment Process -->
    <section class="py-24 bg-white relative overflow-hidden">
        <!-- Premium Background Accents -->
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-20 px-4">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Our Recruitment Process</h2>
                <p class="text-lg text-slate-600 font-medium">A complete, circular hiring journey designed for excellence.</p>
                <div class="w-24 h-1.5 bg-blue-600 mx-auto rounded-full mt-6 shadow-sm"></div>
            </div>

            <!-- Recruitment Process Container -->
            <div class="relative max-w-5xl mx-auto h-[700px] flex items-center justify-center">
                <!-- Desktop View (Circular Loop) -->
                <div class="hidden lg:block relative w-full h-full">
                    
                    <!-- Animated SVG Orbital Path -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <svg class="w-[520px] h-[520px] animate-[spin_30s_linear_infinite]" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="48" fill="none" stroke="url(#circleGradient)" stroke-width="0.4" stroke-dasharray="2 4" stroke-linecap="round" opacity="0.5" />
                            <defs>
                                <linearGradient id="circleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#3b82f6" />
                                    <stop offset="100%" stop-color="#06b6d4" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>

                    <!-- Step 1: Top Center -->
                    <div class="absolute top-[2%] left-1/2 -translate-x-1/2 w-72 text-center group z-10">
                        <div class="w-36 h-36 mx-auto rounded-full border-[5px] border-blue-500 bg-white shadow-2xl flex flex-col items-center justify-center p-4 group-hover:scale-110 transition-all duration-500 group-hover:border-blue-600 group-hover:shadow-blue-200">
                            <i data-lucide="target" class="w-10 h-10 text-blue-600 mb-1"></i>
                            <span class="font-black text-slate-800 text-[10px] uppercase tracking-tighter text-center leading-tight">1. Needs Assessment</span>
                        </div>
                        <p class="mt-3 text-slate-600 font-bold text-xs px-2 group-hover:text-slate-900 transition-colors">Understanding our role requirements and company culture.</p>
                    </div>

                    <!-- Step 2: Right Top -->
                    <div class="absolute top-[22%] right-[5%] w-72 text-center group z-10">
                        <div class="w-36 h-36 mx-auto rounded-full border-[5px] border-teal-500 bg-white shadow-2xl flex flex-col items-center justify-center p-4 group-hover:scale-110 transition-all duration-500 group-hover:border-teal-600 group-hover:shadow-teal-200">
                            <i data-lucide="search" class="w-10 h-10 text-teal-600 mb-1"></i>
                            <span class="font-black text-slate-800 text-[10px] uppercase tracking-tighter text-center leading-tight">2. Candidate Sourcing</span>
                        </div>
                        <p class="mt-3 text-slate-600 font-bold text-xs px-2 group-hover:text-slate-900 transition-colors">Leveraging networks, job boards, and headhunting for specialized roles</p>
                    </div>

                    <!-- Step 3: Right Bottom -->
                    <div class="absolute bottom-[22%] right-[5%] w-72 text-center group z-10">
                        <div class="w-36 h-36 mx-auto rounded-full border-[5px] border-indigo-500 bg-white shadow-2xl flex flex-col items-center justify-center p-4 group-hover:scale-110 transition-all duration-500 group-hover:border-indigo-600 group-hover:shadow-indigo-200">
                            <i data-lucide="user-check" class="w-10 h-10 text-indigo-600 mb-1"></i>
                            <span class="font-black text-slate-800 text-[10px] uppercase tracking-tighter text-center leading-tight text-center">3. Screening & Verification</span>
                        </div>
                        <p class="mt-3 text-slate-600 font-bold text-xs px-2 group-hover:text-slate-900 transition-colors">Checking qualifications, references, and skills assessments.</p>
                    </div>

                    <!-- Step 4: Bottom Center -->
                    <div class="absolute bottom-[2%] left-1/2 -translate-x-1/2 w-72 text-center group z-10">
                        <div class="w-36 h-36 mx-auto rounded-full border-[5px] border-rose-500 bg-white shadow-2xl flex flex-col items-center justify-center p-4 group-hover:scale-110 transition-all duration-500 group-hover:border-rose-600 group-hover:shadow-rose-200">
                            <i data-lucide="message-square-more" class="w-10 h-10 text-rose-600 mb-1"></i>
                            <span class="font-black text-slate-800 text-[10px] uppercase tracking-tighter text-center leading-tight">4. Interviews</span>
                        </div>
                        <p class="mt-3 text-slate-600 font-bold text-xs px-2 group-hover:text-slate-900 transition-colors">Organizing structured interviews and evaluations.</p>
                    </div>

                    <!-- Step 5: Left Bottom -->
                    <div class="absolute bottom-[22%] left-[5%] w-72 text-center group z-10">
                        <div class="w-36 h-36 mx-auto rounded-full border-[5px] border-amber-500 bg-white shadow-2xl flex flex-col items-center justify-center p-4 group-hover:scale-110 transition-all duration-500 group-hover:border-amber-600 group-hover:shadow-amber-200 focus-within:ring-rose-500">
                            <i data-lucide="handshake" class="w-10 h-10 text-amber-600 mb-1"></i>
                            <span class="font-black text-slate-800 text-[10px] uppercase tracking-tighter text-center leading-tight text-center">5. Placement & Onboarding Support</span>
                        </div>
                        <p class="mt-3 text-slate-600 font-bold text-xs px-2 group-hover:text-slate-900 transition-colors">Presenting verified candidates, assisting in contract negotiations, and onboarding</p>
                    </div>

                    <!-- Step 6: Left Top -->
                    <div class="absolute top-[22%] left-[5%] w-72 text-center group z-10">
                        <div class="w-36 h-36 mx-auto rounded-full border-[5px] border-emerald-500 bg-white shadow-2xl flex flex-col items-center justify-center p-4 group-hover:scale-110 transition-all duration-500 group-hover:border-emerald-600 group-hover:shadow-emerald-200">
                            <i data-lucide="trending-up" class="w-10 h-10 text-emerald-600 mb-1"></i>
                            <span class="font-black text-slate-800 text-[10px] uppercase tracking-tighter text-center leading-tight text-center">6. Post-Hire Follow-up</span>
                        </div>
                        <p class="mt-3 text-slate-600 font-bold text-xs px-2 group-hover:text-slate-900 transition-colors">Monitoring performance and ensuring a smooth transition.</p>
                    </div>
                </div>

                <!-- Mobile View -->
                <div class="lg:hidden space-y-12">
                    @foreach([
                        ['t' => 'Needs Assessment', 'd' => 'Understanding our role requirements and company culture.', 'c' => 'blue', 'i' => 'target'],
                        ['t' => 'Candidate Sourcing', 'd' => 'Leveraging networks, job boards, and headhunting for specialized roles', 'c' => 'teal', 'i' => 'search'],
                        ['t' => 'Screening & Verification', 'd' => 'Checking qualifications, references, and skills assessments.', 'c' => 'indigo', 'i' => 'user-check'],
                        ['t' => 'Interviews', 'd' => 'Organizing structured interviews and evaluations.', 'c' => 'rose', 'i' => 'message-square'],
                        ['t' => 'Placement & Onboarding Support', 'd' => 'Presenting verified candidates, assisting in contract negotiations, and onboarding', 'c' => 'amber', 'i' => 'handshake'],
                        ['t' => 'Post-Hire Follow-up', 'd' => 'Monitoring performance and ensuring a smooth transition.', 'c' => 'emerald', 'i' => 'trending-up']
                    ] as $index => $step)
                    <div class="flex flex-col items-center text-center px-4">
                        <div class="w-32 h-32 rounded-full border-[5px] border-{{$step['c']}}-500 bg-white shadow-xl flex items-center justify-center mb-4">
                            <i data-lucide="{{$step['i']}}" class="w-10 h-10 text-{{$step['c']}}-600"></i>
                        </div>
                        <h3 class="font-black text-slate-900 text-lg mb-2">{{$index + 1}}. {{$step['t']}}</h3>
                        <p class="text-slate-600 font-medium">{{$step['d']}}</p>
                    </div>
                    @endforeach
                </div>

            </div>

            <div class="mt-20 text-center">
                <a href="{{ route('public.jobs.index') }}" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-black rounded-full hover:scale-105 transition-all shadow-2xl hover:shadow-blue-200 group">
                    EXPLORE GLOBAL ROLES
                    
                   <i data-lucide="sparkles" class="ml-3 w-6
                h
-6 animate-pulse"></i>
                </a>

               
                   
            </div>

                   
               
        </div>

                   
               

        <style>
            @keyframes blob {
             
   0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
             
   100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </section>

    <!-- Industries We Serve Section -->
    <section class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 px-4">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight uppercase">Industries We Serve</h2>
                <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed">
                    Our focus is to connect employers with the right talent and provide job seekers with meaningful opportunities that match their skills and aspirations. Especially in our Industry-focused
                </p>
                <div class="w-24 h-1.5 bg-blue-600 mx-auto rounded-full mt-6"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                <!-- 1. conatruction Industry -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('hero_construction_workers_1768667395123.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Construction Industry">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">1. conatruction Industry</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic">"we connect qualified and hardworking professionals with trusted employers in the construction Industry."</p>
                        <div class="grid grid-cols-2 gap-y-3 gap-x-6">
                            @foreach(['General Laborer', 'Construction Helper', 'Mason / Bricklayer', 'Plumber Assistant', 'Carpenter', 'Steel Fixer', 'Scaffolder', 'Painter', 'Tiler', 'Electrician Helper'] as $role)
                            <div class="flex items-center gap-3">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-blue-500 flex-shrink-0"></i>
                                <span class="text-slate-700 font-medium text-sm">{{ $role }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 2. Hospitality Industry -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('hero_hr_interviews_1768667429733.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Hospitality Industry" onerror="this.src='https://images.unsplash.com/photo-1540541338287-41700207dee6?q=80&w=1000&auto=format&fit=crop'">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">2. Hospitality Industry</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic">"we place professionals in top restaurants, resorts, and hospitality companies worldwide. In the following position"</p>
                        <div class="grid grid-cols-2 gap-y-3 gap-x-6">
                            @foreach(['Housekeeping Attendant', 'Laundry Attendant', 'Waiter / Waitress', 'Cook / Assistant Cook', 'Kitchen Helper', 'Security Gurd', 'Cleaner'] as $role)
                            <div class="flex items-center gap-3">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-indigo-500 flex-shrink-0"></i>
                                <span class="text-slate-700 font-medium text-sm">{{ $role }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 3. Logistics & Transport -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('hero_logistics_warehouse_1768667413235.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Logistics & Transport">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">3. Logistics & Transport</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic uppercase tracking-widest text-xs opacity-50">"We are recruiting for"</p>
                        <div class="grid grid-cols-2 gap-y-3 gap-x-6">
                            @foreach(['drivers', 'Warehouse Worker Warehouse Assistant', 'Delivery Driver / Van Driver', 'Forklift Operator', 'Storekeeper', 'Packing & Sorting Staff', 'Loader / Unloader', 'Vehicle Mechanic'] as $role)
                            <div class="flex items-center gap-3">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-teal-500 flex-shrink-0"></i>
                                <span class="text-slate-700 font-medium text-sm">{{ $role }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 4. Agriculture Industry -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('hero_agriculture_workers_1768667381546.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Agriculture Industry">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">4. Agriculture Industry</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic">"We recruits qualified and reliable agricultural workers across various levels, including:"</p>
                        <div class="space-y-3">
                            @foreach(['Farm & Field Workers', 'Machinery & Technical Roles', 'Livestock & Animal Care', 'Skilled & Supervisory Roles', 'Post-Harvest & Agri-Processing'] as $role)
                            <div class="flex items-center gap-3">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
                                <span class="text-slate-700 font-medium text-sm">{{ $role }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us? (Verbatim & Premium) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight uppercase">Why Choose Us?</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
                <p class="mt-6 text-slate-500 max-w-2xl mx-auto">Discover the Coyzon advantage in global recruitment.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['t' => 'Experienced HR professionals with industry knowledge', 'i' => 'award', 'c' => 'blue'],
                    ['t' => 'International job placement (Including visa and relocation guidance)', 'i' => 'globe-2', 'c' => 'emerald'],
                    ['t' => 'Tailored recruitment that matches talent with your business needs', 'i' => 'target', 'c' => 'amber'],
                    ['t' => 'Full compliance with national and international labor laws', 'i' => 'shield-check', 'c' => 'indigo'],
                    ['t' => 'Post-placement support to ensure successful integration', 'i' => 'heart-handshake', 'c' => 'rose']
                ] as $item)
                <div class="group p-8 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                        <i data-lucide="{{$item['i']}}" class="w-7 h-7 text-{{$item['c']}}-600"></i>
                    </div>
                    <p class="text-lg font-bold text-slate-800 leading-tight">{{$item['t']}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- OUR TARGET CLIENTS (Verbatim & Premium) -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight uppercase">OUR TARGET CLIENTS</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-5 gap-6">
                @foreach([
                    ['t' => 'Employers & Companies seeking skilled and reliable candidates', 'i' => 'building-2', 'c' => 'blue'],
                    ['t' => 'Recruitment & Placement Agencies (local & international)', 'i' => 'users-2', 'c' => 'indigo'],
                    ['t' => 'SMEs & Corporate organizations', 'i' => 'briefcase', 'c' => 'emerald'],
                    ['t' => 'Institutions requiring verified and compliant workforce solutions', 'i' => 'landmark', 'c' => 'amber'],
                    ['t' => 'Companies with short-term and long-term staffing needs', 'i' => 'timer', 'c' => 'rose']
                ] as $client)
                <div class="bg-white p-8 rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-{{$client['c']}}-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-{{$client['c']}}-600 transition-colors duration-500">
                        <i data-lucide="{{$client['i']}}" class="w-8 h-8 text-{{$client['c']}}-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <p class="font-black text-slate-900 leading-tight text-sm uppercase tracking-tighter">{{$client['t']}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>



    <!-- Global Reach & Industry Focus Summary -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <h2 class="text-4xl font-extrabold text-slate-900 leading-tight">Industry Focus & <br><span class="text-blue-600">Global Presence</span></h2>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        We connect candidates from <span class="font-bold text-slate-900 text-600">East Africa</span> with high-tier employment opportunities across Europe, the Middle East, and North America. Our focus spans critical sectors where we have built a reputation for excellence.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <i data-lucide="building-2" class="h-8 w-8 text-blue-600 mb-2"></i>
                            <h4 class="font-bold text-slate-900">Construction</h4>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <i data-lucide="utensils" class="h-8 w-8 text-orange-600 mb-2"></i>
                            <h4 class="font-bold text-slate-900">Hospitality</h4>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <i data-lucide="sprout" class="h-8 w-8 text-emerald-600 mb-2"></i>
                            <h4 class="font-bold text-slate-900">Agriculture</h4>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <i data-lucide="truck" class="h-8 w-8 text-indigo-600 mb-2"></i>
                            <h4 class="font-bold text-slate-900">Logistics</h4>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center">
                                <i data-lucide="globe" class="h-8 w-8"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold font-serif underline decoration-blue-400">95% Success Rate</h3>
                                <p class="text-blue-100">In visa processing & placement</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h4 class="text-xl font-bold">Why Trust Us?</h4>
                            <p class="text-blue-100 italic leading-relaxed">
                                "We ensure every worker receives accurate job descriptions, fair contracts, and support throughout their overseas journey."
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-6 pt-4">
                            <div>
                                <p class="text-3xl font-black">2,000+</p>
                                <p class="text-xs uppercase font-bold tracking-widest text-blue-200">Global Applicants</p>
                            </div>
                            <div>
                                <p class="text-3xl font-black">500+</p>
                                <p class="text-xs uppercase font-bold tracking-widest text-blue-200">Verified Employers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>







    <!-- Target Destinations (Premium Ely Design - Fluid) -->
    <section class="py-24 bg-white relative overflow-hidden">
        <!-- Artistic Background Accents -->
        <div class="absolute top-0 left-1/2 -translate-x-full w-[500px] h-[500px] bg-blue-50/40 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-[#A52A2A]/5 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="px-4 sm:px-6 lg:px-12 relative z-10 w-full">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 text-center md:text-left max-w-7xl mx-auto">
                <div class="max-w-2xl">
                    <h2 class="text-indigo-600 font-bold tracking-[0.2em] uppercase text-sm mb-4">Global Network</h2>
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight uppercase tracking-tighter">
                        Target <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-[#A52A2A] to-slate-900">Destinations</span>
                    </h1>
                    <p class="mt-6 text-lg text-slate-600 leading-relaxed font-medium">
                        Connecting Tanzanian talent to the world's leading economic hubs with end-to-end support and ethical placement.
                    </p>
                </div>
                <div class="hidden lg:block text-right">
                    <div class="inline-flex items-center gap-4 bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="flex -space-x-2">
                            @foreach(['TZ', 'DE', 'QA', 'AU'] as $flag)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-500 overflow-hidden shadow-sm">
                                    <img src="https://flagcdn.com/w40/{{ strtolower($flag) }}.png" class="w-full h-full object-cover" alt="{{ $flag }}">
                                </div>
                            @endforeach
                        </div>
                        <span class="text-sm font-bold text-slate-700">Expanding Globally</span>
                    </div>
                </div>
            </div>

            <!-- Styled Map Visualization Area (Simplified/Removed Container) -->
            <div class="relative w-full aspect-[21/9] mb-24 group overflow-hidden">
                <!-- Base Map Image -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg" class="absolute inset-0 w-full h-full object-contain p-4 opacity-40 grayscale hover:opacity-50 transition-all duration-1000" alt="Global Reach Map">
                
                <!-- SVG Overlay for Animated Paths From Tanzania Source -->
                <svg viewBox="0 0 1000 500" class="absolute inset-0 w-full h-full pointer-events-none">
                    <defs>
                        <linearGradient id="pathGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#A52A2A" stop-opacity="0" />
                            <stop offset="50%" stop-color="#A52A2A" stop-opacity="0.6" />
                            <stop offset="100%" stop-color="#A52A2A" stop-opacity="0" />
                        </linearGradient>
                        <filter id="glow">
                            <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                            <feMerge>
                                <feMergeNode in="coloredBlur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    
                    <!-- Dynamic Paths from Tanzania (Approx 580, 310) -->
                    <g filter="url(#glow)">
                        <path d="M580,310 Q450,200 350,150" fill="none" stroke="url(#pathGrad)" stroke-width="2.5" class="animate-travel-long" stroke-dasharray="1000" />
                        <path d="M580,310 Q600,250 620,180" fill="none" stroke="url(#pathGrad)" stroke-width="2.5" class="animate-travel-short" stroke-dasharray="1000" />
                        <path d="M580,310 Q350,250 150,130" fill="none" stroke="url(#pathGrad)" stroke-width="2.5" class="animate-travel-long" stroke-dasharray="1000" />
                        <path d="M580,310 Q750,380 920,410" fill="none" stroke="url(#pathGrad)" stroke-width="2.5" class="animate-travel-med" stroke-dasharray="1000" />
                    </g>
                </svg>

                <div class="relative w-full h-full pointer-events-none">
                    <!-- Tanzania Source Pin -->
                    <div class="absolute top-[62%] left-[58%]">
                        <div class="w-6 h-6 bg-[#A52A2A] rounded-full animate-ping opacity-20 absolute"></div>
                        <div class="w-4 h-4 bg-[#A52A2A] rounded-full border-2 border-white shadow-xl relative z-10"></div>
                        <div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow-lg border border-slate-100 whitespace-nowrap">
                            <span class="text-[9px] font-black text-slate-800 uppercase tracking-widest">Base: Tanzania</span>
                        </div>
                    </div>

                    <!-- Europe Region Marker -->
                    <div class="absolute top-[32%] left-[48%] group/pin pointer-events-auto cursor-pointer">
                        <div class="w-3.5 h-3.5 bg-slate-900 rounded-full border-2 border-white shadow-lg group-hover/pin:scale-150 transition-transform"></div>
                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-3 py-1.5 rounded-xl text-[10px] font-bold opacity-0 group-hover/pin:opacity-100 transition-opacity translate-y-2 group-hover/pin:translate-y-0 shadow-2xl">Europe</div>
                    </div>

                    <!-- Middle East Region Marker -->
                    <div class="absolute top-[42%] left-[60%] group/pin pointer-events-auto cursor-pointer">
                        <div class="w-3.5 h-3.5 bg-slate-900 rounded-full border-2 border-white shadow-lg group-hover/pin:scale-150 transition-transform"></div>
                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-3 py-1.5 rounded-xl text-[10px] font-bold opacity-0 group-hover/pin:opacity-100 transition-opacity translate-y-2 group-hover/pin:translate-y-0 shadow-2xl">Middle East</div>
                    </div>
                </div>
            </div>

            <!-- Region Cards Section -->
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Tanzania -->
                <div class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 transition-colors duration-500">
                        <i data-lucide="map-pin" class="w-7 h-7 text-orange-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tighter uppercase">Tanzania</h3>
                    <p class="text-slate-600 text-sm font-medium leading-relaxed mb-6">Nationwide recruitment & local candidate placement services across all sectors.</p>
                </div>

                <!-- Middle East -->
                <div class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-emerald-600 transition-colors duration-500">
                        <i data-lucide="globe" class="w-7 h-7 text-emerald-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tighter uppercase">Middle East</h3>
                    <p class="text-slate-600 text-sm font-medium leading-relaxed mb-6">Expert placement in UAE, Saudi Arabia, Qatar, Oman, and Kuwait markets.</p>
                </div>

                <!-- Europe -->
                <div class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 transition-colors duration-500">
                        <i data-lucide="compass" class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tighter uppercase">Europe</h3>
                    <p class="text-slate-600 text-[11px] font-medium leading-relaxed mb-6 italic opacity-80">Germany, Poland, Romania, Lithuania, Czech Republic, Malta, and UK.</p>
                </div>

                <!-- Global Expansion -->
                <div class="group bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl flex flex-col hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#A52A2A]/20 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-white transition-colors duration-500">
                        <i data-lucide="send" class="w-7 h-7 text-white group-hover:text-slate-900 transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-4 tracking-tighter uppercase">Global Expansion</h3>
                    <div class="mt-auto">
                        <span class="inline-flex items-center text-[10px] font-bold text-white uppercase tracking-widest bg-[#A52A2A] px-4 py-1.5 rounded-full">Canada & Australia</span>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes travel {
                from { stroke-dashoffset: 1000; }
                to { stroke-dashoffset: 0; }
            }
            .animate-travel-long { animation: travel 8s linear infinite; }
            .animate-travel-med { animation: travel 6s linear infinite; }
            .animate-travel-short { animation: travel 4s linear infinite; }
        </style>
    </section>






    <!-- FAQs - Frequently Asked Questions -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">FAQs – Frequently Asked Questions</h2>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="1">
                        <span class="font-bold text-gray-900 text-lg">What services do you offer to employers?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We provide talent sourcing, screening, onboarding, temporary/contract
                            staffing, and full-payroll HR support for both local and international placement.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="2">
                        <span class="font-bold text-gray-900 text-lg">How are you different from other agencies?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We're focused on ethical placement, cultural sensitivity, and
                            end-to-end compliance. Our rigorous screening ensures you get candidates who match both
                            skills and organizational fit.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="3">
                        <span class="font-bold text-gray-900 text-lg">How do you vet qualified candidates?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We evaluate by educational background, work experience, skill tests,
                            references, and background checks to ensure both quality and safety.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="4">
                        <span class="font-bold text-gray-900 text-lg">Can you provide temporary staff for short-term
                            needs?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">Yes, we offer temporary and contract staffing to meet immediate
                            workforce gaps and project-based demands.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="5">
                        <span class="font-bold text-gray-900 text-lg">Can you provide payroll services for deployed
                            staff?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">Yes, we manage payroll including workers & benefits, tax &
                            documentation for a streamlined, beneficial administrative workload and HR compliance.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="6">
                        <span class="font-bold text-gray-900 text-lg">Do you offer candidate training?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">Yes, we are experts at preparing workers for training to enhance
                            workforce competencies for their tasks.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button
                        class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors"
                        data-faq="7">
                        <span class="font-bold text-gray-900 text-lg">How do you support overseas with cultural
                            barriers?</span>
                        <i data-lucide="chevron-down"
                            class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We have international partnership with locals and embassies & other who
                            help maintain a stable cultural relationship/orientation on main destinations.</p>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <!-- Our Team -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Team</h2>
                <p class="text-lg text-gray-600">Meet the dedicated professionals driving COYZON's success</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-blue-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user1.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">John Doe</h3>
                    <p class="text-blue-600 font-semibold mb-2">CEO & Founder</p>
                    <p class="text-sm text-gray-600">20+ years in recruitment industry</p>
                </div>

                <!-- Team Member 2 -->
                <div
                    class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-green-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user2.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Jane Smith</h3>
                    <p class="text-green-600 font-semibold mb-2">Head of Operations</p>
                    <p class="text-sm text-gray-600">Expert in global talent placement</p>
                </div>

                <!-- Team Member 3 -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-purple-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user3.jpeg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Michael Johnson</h3>
                    <p class="text-purple-600 font-semibold mb-2">HR Director</p>
                    <p class="text-sm text-gray-600">Compliance and ethical recruitment specialist</p>
                </div>

                <!-- Team Member 4 -->
                <div
                    class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-orange-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user1.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Sarah Williams</h3>
                    <p class="text-orange-600 font-semibold mb-2">Client Relations Manager</p>
                    <p class="text-sm text-gray-600">Building lasting employer partnerships</p>
                </div>
            </div>
        </div>
    </section>



    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // FAQ Accordion
            const faqButtons = document.querySelectorAll('.faq-button');
            faqButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const faqItem = button.closest('.faq-item');
                    const content = faqItem.querySelector('.faq-content');
                    const icon = button.querySelector('.faq-icon');
                    const isOpen = !content.classList.contains('hidden');

                    // Close all FAQs
                    document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                    document.querySelectorAll('.faq-icon').forEach(i => {
                        i.style.transform = 'rotate(0deg)';
                    });

                    // Toggle current FAQ
                    if (isOpen) {
                        content.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        content.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                        lucide.createIcons(); // Re-render icons
                    }
                });
            });
        });
    </script>
</body>

</html>