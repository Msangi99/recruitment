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
    <nav class="sticky top-0 z-50 bg-gray-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-16 w-auto">
                        <span class="ml-3 text-xl font-bold text-white">Coyzon</span>
                    </a>
                </div>
                <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                    <a href="{{ route('about') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">About Us</a>
                    <a href="{{ route('public.jobs.index') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Find Candidate</a>
                    <a href="{{ route('public.appointments.index') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Book Appointment</a>
                    <a href="{{ route('contact') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-white border border-white/30 rounded-lg hover:bg-white/10 transition-colors">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Dashboard</a>
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
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="activeSlide === 0 ? 'opacity-100' : 'opacity-0'">
                <img src="{{ asset('hero_agriculture_workers_1768667381546.png') }}" class="h-full w-full object-cover"
                    alt="Agriculture">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>

            <!-- Slide 1: Construction -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="activeSlide === 1 ? 'opacity-100' : 'opacity-0'" x-cloak>
                <img src="{{ asset('hero_construction_workers_1768667395123.png') }}" class="h-full w-full object-cover"
                    alt="Construction">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>

            <!-- Slide 2: Logistics -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="activeSlide === 2 ? 'opacity-100' : 'opacity-0'" x-cloak>
                <img src="{{ asset('hero_logistics_warehouse_1768667413235.png') }}" class="h-full w-full object-cover"
                    alt="Logistics">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>

            <!-- Slide 3: HR & Recruitment -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="activeSlide === 3 ? 'opacity-100' : 'opacity-0'" x-cloak>
                <img src="{{ asset('hero_hr_interviews_1768667429733.png') }}" class="h-full w-full object-cover"
                    alt="HR & Recruitment">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent"></div>
            </div>
        </div>

        <!-- Content Overlay -->
        <div class="relative z-10 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
            <div class="max-w-3xl space-y-8">
                <!-- Hero Headline -->
                <div class="space-y-2">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
                        We Connect Global Employers <br>
                        <span class="text-blue-500">with Qualified Talent</span>
                    </h1>
                </div>

                <!-- Category Spotlight -->
                <div class="relative h-24 flex items-center">
                    <!-- Agriculture Label -->
                    <div x-show="activeSlide === 0" x-transition:enter="transition ease-out duration-1000 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-500 transform absolute"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4" class="flex flex-col">
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90"
                            style="font-family: 'Dancing Script', cursive;">Agriculture</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Feeding the world with skilled hands.
                        </p>
                    </div>
                    <!-- Construction Label -->
                    <div x-show="activeSlide === 1" x-transition:enter="transition ease-out duration-1000 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-500 transform absolute"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4" class="flex flex-col" x-cloak>
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90"
                            style="font-family: 'Dancing Script', cursive;">Construction</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Building foundations for a better
                            future.</p>
                    </div>
                    <!-- Logistics Label -->
                    <div x-show="activeSlide === 2" x-transition:enter="transition ease-out duration-1000 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-500 transform absolute"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4" class="flex flex-col" x-cloak>
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90"
                            style="font-family: 'Dancing Script', cursive;">Logistics</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Connecting markets with seamless
                            flow.</p>
                    </div>
                    <!-- HR Label -->
                    <div x-show="activeSlide === 3" x-transition:enter="transition ease-out duration-1000 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-500 transform absolute"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4" class="flex flex-col" x-cloak>
                        <span class="text-6xl md:text-7xl font-serif italic text-white/90"
                            style="font-family: 'Dancing Script', cursive;">HR & Recruitment</span>
                        <p class="text-blue-200/60 font-medium tracking-wide mt-1">Connecting global talent with
                            opportunity.</p>
                    </div>
                </div>

                <!-- Sub-headline -->
                <p class="text-lg md:text-xl text-slate-300 max-w-2xl leading-relaxed">
                    Coyzon is a licensed recruitment agency specializing in sourcing, screening, and placing qualified
                    candidates for employers across diverse sectors worldwide.
                </p>

                <!-- Primary CTA (Buttons) -->
                <div class="flex flex-wrap gap-3 pt-4">
                    <a href="{{ route('public.jobs.index') }}"
                        class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                        Find a Job
                    </a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="px-5 py-2.5 bg-white text-slate-900 text-sm font-semibold rounded-lg hover:bg-slate-100 shadow-lg transition-all hover:-translate-y-0.5">
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
                <button @click="activeSlide = index" class="h-1.5 transition-all duration-300 rounded-full"
                    :class="activeSlide === index ? 'w-12 bg-blue-500' : 'w-4 bg-white/30 hover:bg-white/50'">
                </button>
            </template>
        </div>
    </section>






    <!-- Vision & Mission Section -->
    <section class="py-16 bg-white relative overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute top-1/2 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Vision Card -->
                <div
                    class="group relative overflow-hidden rounded-[2.5rem] bg-slate-900 p-6 lg:p-8 text-white shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30">
                    <div
                        class="absolute top-0 right-0 -mt-20 -mr-20 h-80 w-80 rounded-full bg-blue-600/20 blur-[80px] group-hover:bg-blue-600/30 transition-colors duration-500">
                    </div>

                    <div class="relative z-10 flex flex-col h-full">
                        <h3 class="mb-6 text-xl font-black uppercase tracking-tight">Our Vision</h3>

                        <p class="text-sm leading-relaxed text-blue-100/80 font-medium">
                            To become the leading global recruitment gateway connecting organizations with exceptional
                            talent through professionalism, integrity, and an impactful workforce Solutions.
                        </p>
                    </div>
                </div>

                <!-- Mission Card -->
                <div
                    class="group relative overflow-hidden rounded-[2.5rem] bg-slate-900 p-6 lg:p-8 text-white shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30">
                    <div
                        class="absolute bottom-0 left-0 -mb-20 -ml-20 h-80 w-80 rounded-full bg-white/10 blur-[80px] group-hover:bg-white/20 transition-colors duration-500">
                    </div>

                    <div class="relative z-10 flex flex-col h-full">
                        <h3 class="mb-6 text-xl font-black uppercase tracking-tight">Our Mission</h3>

                        <p class="text-sm leading-relaxed text-blue-100/80 font-medium">
                            To deliver trusted, efficient, and transparent recruitment services that empower employers
                            to build strong teams and help candidates access real, life-changing career opportunities
                            across the world.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Core Values Section -->
    <section class="py-16 bg-white relative overflow-hidden">
        <!-- Background Blur Effects -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3 tracking-tight uppercase">Our Core
                    Values</h2>
                <div class="w-16 h-1 bg-cyan-500 mx-auto rounded-full"></div>
            </div>

            <!-- Values Grid - Step Card Layout -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Value 1: Professionalism -->
                <div
                    class="group relative overflow-hidden rounded-2xl bg-slate-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30">
                    <div
                        class="absolute top-0 right-0 -mt-10 -mr-10 h-32 w-32 rounded-full bg-cyan-600/20 blur-[40px] group-hover:bg-cyan-600/30 transition-colors duration-500">
                    </div>
                    <div class="h-32 overflow-hidden">
                        <img src="{{ asset('hero_hr_interviews_1768667429733.png') }}" alt="Professionalism"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="relative z-10 p-5">
                        <span class="text-cyan-400 text-xs font-bold uppercase tracking-wider">Value 1</span>
                        <h3 class="text-base font-bold text-white mt-2 mb-2">Professionalism</h3>
                        <p class="text-xs text-blue-100/80 leading-relaxed">We maintain the highest standards in every
                            step of the recruitment process.</p>
                    </div>
                </div>

                <!-- Value 2: Integrity -->
                <div
                    class="group relative overflow-hidden rounded-2xl bg-slate-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30">
                    <div
                        class="absolute bottom-0 left-0 -mb-10 -ml-10 h-32 w-32 rounded-full bg-blue-600/20 blur-[40px] group-hover:bg-blue-600/30 transition-colors duration-500">
                    </div>
                    <div class="h-32 overflow-hidden">
                        <img src="{{ asset('hero_agriculture_workers_1768667381546.png') }}" alt="Integrity"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="relative z-10 p-5">
                        <span class="text-cyan-400 text-xs font-bold uppercase tracking-wider">Value 2</span>
                        <h3 class="text-base font-bold text-white mt-2 mb-2">Integrity</h3>
                        <p class="text-xs text-blue-100/80 leading-relaxed">We operate with honesty, transparency, and
                            accountability.</p>
                    </div>
                </div>

                <!-- Value 3: Reliability -->
                <div
                    class="group relative overflow-hidden rounded-2xl bg-slate-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30">
                    <div
                        class="absolute top-0 left-0 -mt-10 -ml-10 h-32 w-32 rounded-full bg-cyan-600/20 blur-[40px] group-hover:bg-cyan-600/30 transition-colors duration-500">
                    </div>
                    <div class="h-32 overflow-hidden">
                        <img src="{{ asset('hero_construction_workers_1768667395123.png') }}" alt="Reliability"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="relative z-10 p-5">
                        <span class="text-cyan-400 text-xs font-bold uppercase tracking-wider">Value 3</span>
                        <h3 class="text-base font-bold text-white mt-2 mb-2">Reliability</h3>
                        <p class="text-xs text-blue-100/80 leading-relaxed">We deliver consistent results with timely
                            and dependable solutions.</p>
                    </div>
                </div>

                <!-- Value 4: Partnership -->
                <div
                    class="group relative overflow-hidden rounded-2xl bg-slate-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30">
                    <div
                        class="absolute bottom-0 right-0 -mb-10 -mr-10 h-32 w-32 rounded-full bg-blue-600/20 blur-[40px] group-hover:bg-blue-600/30 transition-colors duration-500">
                    </div>
                    <div class="h-32 overflow-hidden">
                        <img src="{{ asset('hero_logistics_warehouse_1768667413235.png') }}" alt="Partnership"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="relative z-10 p-5">
                        <span class="text-cyan-400 text-xs font-bold uppercase tracking-wider">Value 4</span>
                        <h3 class="text-base font-bold text-white mt-2 mb-2">Partnership</h3>
                        <p class="text-xs text-blue-100/80 leading-relaxed">We match organizations with verified,
                            skilled candidates who add real value.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- Our Solution Section -->
    <section class="py-16 bg-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <img src="{{ asset('solution_section.png') }}" alt="Our Solution - Recruitment Services" class="w-full max-w-4xl rounded-2xl shadow-xl">
            </div>
        </div>
    </section>

    <!-- Our Recruitment Process -->
    <section class="py-16 bg-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Our Recruitment Process</h2>
                <p class="text-lg text-slate-600 font-medium">A complete, circular hiring journey designed for excellence.</p>
                <div class="w-24 h-1.5 bg-blue-600 mx-auto rounded-full mt-6 shadow-sm"></div>
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('recruitment_process.jpg') }}" alt="Full Cycle Recruiting Process" class="w-full max-w-3xl rounded-2xl shadow-xl">
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('public.jobs.index') }}" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-black rounded-full hover:scale-105 transition-all shadow-2xl hover:shadow-blue-200 group">
                    EXPLORE GLOBAL ROLES
                    <i data-lucide="sparkles" class="ml-3 w-6 h-6 animate-pulse"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Industries We Serve Section -->










    <!-- Industries We Serve Section -->
    <section class="py-16 bg-slate-50 relative overflow-hidden">
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
                        <img src="{{ asset('industry_construction.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Construction Industry">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">construction Industry</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic">"we connect qualified and hardworking professionals with trusted employers in the construction Industry."</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['General Laborer', 'Construction Helper', 'Mason / Bricklayer', 'Plumber Assistant', 'Carpenter', 'Steel Fixer', 'Scaffolder', 'Painter', 'Tiler', 'Electrician Helper'] as $role)
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-full border border-blue-100">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-2"></span>
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 2. Hospitality Industry -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('industry_hospitality.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Hospitality Industry">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Hospitality Industry</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic">"we place professionals in top restaurants, resorts, and hospitality companies worldwide. In the following position"</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Housekeeping Attendant', 'Laundry Attendant', 'Waiter / Waitress', 'Cook / Assistant Cook', 'Kitchen Helper', 'Security Guard', 'Cleaner'] as $role)
                                <span class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-full border border-indigo-100">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></span>
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 3. Logistics & Transport -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('industry_logistics.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Logistics & Transport">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Logistics & Transport</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic uppercase tracking-widest text-xs opacity-50">"We are recruiting for"</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Drivers', 'Warehouse Worker / Assistant', 'Delivery Driver / Van Driver', 'Forklift Operator', 'Storekeeper', 'Packing & Sorting Staff', 'Loader / Unloader', 'Vehicle Mechanic'] as $role)
                                <span class="inline-flex items-center px-3 py-1.5 bg-teal-50 text-teal-700 text-xs font-medium rounded-full border border-teal-100">
                                    <span class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-2"></span>
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 4. Agriculture Industry -->
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="{{ asset('industry_agriculture.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Agriculture Industry">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Agriculture Industry</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-slate-600 font-bold mb-8 italic">"We recruits qualified and reliable agricultural workers across various levels, including:"</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Farm & Field Workers', 'Machinery & Technical Roles', 'Livestock & Animal Care', 'Skilled & Supervisory Roles', 'Post-Harvest & Agri-Processing'] as $role)
                                <span class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-full border border-emerald-100">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span>
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- OUR TARGET CLIENTS (Verbatim & Premium) -->
    <section class="py-16 bg-slate-50">
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
    {{-- <section class="py-16 bg-white">
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
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Target Destinations (Premium Ely Design - Fluid) -->
    <section class="py-16 bg-white relative overflow-hidden">
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

            <!-- Styled Map Visualization Area -->
            <div class="relative w-full aspect-[21/9] mb-16 group overflow-hidden rounded-[2.5rem] shadow-2xl border border-slate-100">
                <img src="{{ asset('global_reach_map.png') }}" 
                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000" 
                     alt="Global Reach Map - Local, Europe, Middle East">
                
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent pointer-events-none"></div>
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

    <!-- Why Choose Us? (Verbatim & Premium) -->
    <section class="py-16 bg-white">
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






    <!-- FAQs - Frequently Asked Questions -->
    <section class="py-16 bg-gray-50">
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