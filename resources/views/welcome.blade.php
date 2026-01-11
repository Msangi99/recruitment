<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'COYZON') }} - Talent meets opportunity</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
   
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50"></div>
        <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-blue-100 blur-3xl opacity-50"></div>
        <div class="absolute -left-32 top-40 h-96 w-96 rounded-full bg-indigo-100 blur-3xl opacity-50"></div>

        <header class="relative z-10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="COYZON Logo" class="h-11 w-auto">
                    </a>
                    <div>
                        <p class="text-xs uppercase tracking-[3px] text-slate-500 font-semibold">Coyzon</p>
                        <p class="text-lg font-bold text-slate-900">Recruitment Platform</p>
                    </div>
                </div>

                <div class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                    <a href="#how-it-works" class="hover:text-slate-900">How it works</a>
                    <a href="#industries" class="hover:text-slate-900">Industries</a>
                    <a href="#solutions" class="hover:text-slate-900">Solutions</a>
                    <a href="#testimonials" class="hover:text-slate-900">Stories</a>
                    <a href="#faq" class="hover:text-slate-900">FAQ</a>
                    <a href="#team" class="hover:text-slate-900">Team</a>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="hidden rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-blue-200 hover:text-blue-700 md:inline-flex">Go to dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-blue-200 hover:text-blue-700 md:inline-flex">Sign in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700">
                                    Get started
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <main class="relative z-10">
            <!-- Hero with Image Carousel -->
            <section class="mx-auto max-w-7xl px-6 pb-16 pt-6 lg:flex lg:items-center lg:gap-12">
                <div class="flex-1 space-y-6">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/60 px-4 py-2 text-xs font-semibold uppercase tracking-[2px] text-blue-700 ring-1 ring-blue-100 shadow-sm">
                        <i data-lucide="sparkles" class="h-4 w-4"></i> Smarter hiring for modern teams
                    </span>
                    <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                        Connect ambitious talent with employers who are ready to hire.
                    </h1>
                    <p class="max-w-2xl text-lg text-slate-600">
                        Coyzon streamlines recruiting with verified candidates, structured profiles, and guided workflows for both job seekers and hiring teams.
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-xl shadow-blue-500/30 hover:bg-blue-700">
                            Create free account
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:border-blue-200 hover:text-blue-700 shadow-sm">
                            Sign in
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-6 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <i data-lucide="badge-check" class="h-4 w-4 text-emerald-500"></i>
                            Verified candidate profiles
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="clock-3" class="h-4 w-4 text-amber-500"></i>
                            Faster shortlisting
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="h-4 w-4 text-blue-500"></i>
                            Secure & compliant
                        </div>
                    </div>
                </div>

                <div class="relative mt-10 flex-1 lg:mt-0">
                    <!-- Hero Image Carousel -->
                    <div class="relative h-96 rounded-3xl overflow-hidden shadow-2xl">
                        <div id="hero-carousel" class="relative h-full">
                            <div class="hero-slide active absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100">
                                <img src="{{ asset('user1.jpg') }}" alt="Recruitment" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            </div>
                            <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0">
                                <img src="{{ asset('user2.jpg') }}" alt="Teamwork" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            </div>
                            <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0">
                                <img src="{{ asset('user3.jpeg') }}" alt="Success" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            </div>
                        </div>
                        <!-- Carousel Indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                            <button class="carousel-indicator active w-2 h-2 rounded-full bg-white transition-all duration-300" data-slide="0"></button>
                            <button class="carousel-indicator w-2 h-2 rounded-full bg-white/50 transition-all duration-300" data-slide="1"></button>
                            <button class="carousel-indicator w-2 h-2 rounded-full bg-white/50 transition-all duration-300" data-slide="2"></button>
                        </div>
                    </div>
                    
                    <!-- Stats Card Overlay -->
                    <div class="absolute -bottom-6 left-6 right-6 rounded-3xl border border-white/80 bg-white/90 p-6 shadow-2xl backdrop-blur">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-slate-100 bg-gradient-to-br from-blue-50 to-white p-4 shadow-sm">
                                <p class="text-xs uppercase tracking-[2px] text-slate-500 font-semibold mb-2">Employers</p>
                                <p class="text-2xl font-bold text-slate-900">2.1K+</p>
                                <p class="text-sm text-slate-500">active companies</p>
                            </div>
                            <div class="rounded-2xl border border-slate-100 bg-gradient-to-br from-indigo-50 to-white p-4 shadow-sm">
                                <p class="text-xs uppercase tracking-[2px] text-slate-500 font-semibold mb-2">Talent</p>
                                <p class="text-2xl font-bold text-slate-900">18K+</p>
                                <p class="text-sm text-slate-500">verified candidates</p>
                            </div>
                            <div class="col-span-2 rounded-2xl border border-slate-100 bg-gradient-to-r from-blue-600 to-indigo-600 p-5 text-white shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm uppercase tracking-[2px] text-blue-100">Placement speed</p>
                                        <p class="text-3xl font-bold">8 days</p>
                                        <p class="text-sm text-blue-100">average from shortlist to offer</p>
                                    </div>
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20">
                                        <i data-lucide="timer" class="h-6 w-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Industry Cards -->
            @if($categories && $categories->count() > 0)
            <section id="industries" class="mx-auto max-w-7xl px-6 pb-14">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">Industries We Serve</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Connecting talent across diverse sectors</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($categories->take(8) as $category)
                    <div class="group rounded-2xl border border-slate-100 bg-white p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            @if($category->icon)
                                <i data-lucide="{{ $category->icon }}" class="h-6 w-6"></i>
                            @else
                                <i data-lucide="briefcase" class="h-6 w-6"></i>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $category->name }}</h3>
                        @if($category->description)
                        <p class="text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($category->description, 80) }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Circular Recruitment Process -->
            <section class="mx-auto max-w-7xl px-6 pb-14">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">Our Process</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">A circular journey from talent to opportunity</h2>
                </div>
                <div class="relative flex items-center justify-center py-12">
                    <!-- Circular Process Visualization -->
                    <div class="relative w-96 h-96">
                        <!-- Circle -->
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 400 400">
                            <circle cx="200" cy="200" r="180" fill="none" stroke="#e2e8f0" stroke-width="2"/>
                            <circle cx="200" cy="200" r="180" fill="none" stroke="#3b82f6" stroke-width="3" stroke-dasharray="1130" stroke-dashoffset="0" class="process-circle"/>
                        </svg>
                        
                        <!-- Process Steps -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="grid grid-cols-2 gap-8 w-full h-full p-12">
                                <!-- Step 1: Register -->
                                <div class="process-step flex flex-col items-center justify-start text-center" data-step="1">
                                    <div class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center mb-3 shadow-lg">
                                        <span class="text-xl font-bold">1</span>
                                    </div>
                                    <h4 class="font-semibold text-sm text-slate-900">Register</h4>
                                    <p class="text-xs text-slate-600 mt-1">Create profile</p>
                                </div>
                                
                                <!-- Step 2: Verify -->
                                <div class="process-step flex flex-col items-center justify-start text-center" data-step="2">
                                    <div class="w-16 h-16 rounded-full bg-emerald-600 text-white flex items-center justify-center mb-3 shadow-lg">
                                        <span class="text-xl font-bold">2</span>
                                    </div>
                                    <h4 class="font-semibold text-sm text-slate-900">Verify</h4>
                                    <p class="text-xs text-slate-600 mt-1">Admin approval</p>
                                </div>
                                
                                <!-- Step 3: Match -->
                                <div class="process-step flex flex-col items-center justify-end text-center" data-step="3">
                                    <div class="w-16 h-16 rounded-full bg-indigo-600 text-white flex items-center justify-center mb-3 shadow-lg">
                                        <span class="text-xl font-bold">3</span>
                                    </div>
                                    <h4 class="font-semibold text-sm text-slate-900">Match</h4>
                                    <p class="text-xs text-slate-600 mt-1">Find opportunities</p>
                                </div>
                                
                                <!-- Step 4: Connect -->
                                <div class="process-step flex flex-col items-center justify-end text-center" data-step="4">
                                    <div class="w-16 h-16 rounded-full bg-amber-600 text-white flex items-center justify-center mb-3 shadow-lg">
                                        <span class="text-xl font-bold">4</span>
                                    </div>
                                    <h4 class="font-semibold text-sm text-slate-900">Connect</h4>
                                    <p class="text-xs text-slate-600 mt-1">Interview & hire</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Interactive World Map -->
            <section class="mx-auto max-w-7xl px-6 pb-14">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">Global Reach</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Connecting talent worldwide</h2>
                </div>
                <div class="relative rounded-3xl border border-slate-100 bg-white p-8 shadow-lg overflow-hidden">
                    <div id="world-map" class="relative h-96 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center">
                        <!-- Simplified World Map SVG -->
                        <svg viewBox="0 0 1000 500" class="w-full h-full">
                            <!-- Continents simplified -->
                            <g class="continent" data-region="africa">
                                <path d="M450 200 L480 180 L500 200 L510 250 L500 300 L480 320 L450 310 L440 280 L440 240 Z" 
                                      fill="#3b82f6" opacity="0.3" class="hover:opacity-60 cursor-pointer transition-opacity"/>
                                <circle cx="470" cy="250" r="8" fill="#3b82f6" class="pulse-dot"/>
                            </g>
                            <g class="continent" data-region="europe">
                                <path d="M480 100 L520 90 L540 120 L530 150 L510 160 L490 140 L480 120 Z" 
                                      fill="#6366f1" opacity="0.3" class="hover:opacity-60 cursor-pointer transition-opacity"/>
                                <circle cx="510" cy="120" r="8" fill="#6366f1" class="pulse-dot"/>
                            </g>
                            <g class="continent" data-region="asia">
                                <path d="M600 120 L700 100 L720 150 L710 200 L680 220 L650 200 L620 180 L600 150 Z" 
                                      fill="#8b5cf6" opacity="0.3" class="hover:opacity-60 cursor-pointer transition-opacity"/>
                                <circle cx="660" cy="160" r="8" fill="#8b5cf6" class="pulse-dot"/>
                            </g>
                            <g class="continent" data-region="americas">
                                <path d="M200 150 L250 140 L280 180 L270 250 L240 280 L210 260 L190 220 L190 180 Z" 
                                      fill="#ec4899" opacity="0.3" class="hover:opacity-60 cursor-pointer transition-opacity"/>
                                <circle cx="230" cy="200" r="8" fill="#ec4899" class="pulse-dot"/>
                            </g>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center bg-white/90 backdrop-blur px-8 py-6 rounded-2xl shadow-lg">
                                <p class="text-2xl font-bold text-slate-900 mb-2">50+ Countries</p>
                                <p class="text-sm text-slate-600">Active recruitment partnerships</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How it works -->
            <section id="how-it-works" class="mx-auto max-w-7xl px-6 pb-14">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">How it works</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">A guided path for both candidates and employers.</h2>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 mb-4">
                            <i data-lucide="file-check" class="h-5 w-5"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Structured profiles</h3>
                        <p class="mt-2 text-sm text-slate-600">Candidates showcase skills, documents, and verifications in one place. Employers see clean, comparable profiles.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 mb-4">
                            <i data-lucide="sparkles" class="h-5 w-5"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Smart matching</h3>
                        <p class="mt-2 text-sm text-slate-600">Use filters, categories, and status tags to shortlist faster. Built-in notes keep hiring teams aligned.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 mb-4">
                            <i data-lucide="calendar-clock" class="h-5 w-5"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Appointments & follow-ups</h3>
                        <p class="mt-2 text-sm text-slate-600">Schedule interviews or consultations, track application status, and keep candidates informed automatically.</p>
                    </div>
                </div>
            </section>

            <!-- Solutions -->
            <section id="solutions" class="mx-auto max-w-7xl px-6 pb-14">
                <div class="grid gap-8 lg:grid-cols-2">
                    <div class="rounded-3xl border border-slate-100 bg-white p-8 shadow-sm">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-[2px] font-semibold text-blue-700">
                            <i data-lucide="users" class="h-4 w-4"></i> For candidates
                        </div>
                        <h3 class="mt-3 text-2xl font-bold text-slate-900">Land roles that fit your ambition.</h3>
                        <ul class="mt-4 space-y-3 text-sm text-slate-600">
                            <li class="flex items-start gap-2"><i data-lucide="shield-check" class="mt-0.5 h-4 w-4 text-emerald-500"></i> Verified profile and document uploads keep you trusted with employers.</li>
                            <li class="flex items-start gap-2"><i data-lucide="layout-dashboard" class="mt-0.5 h-4 w-4 text-blue-500"></i> Dashboard view of applications, status, and upcoming appointments.</li>
                            <li class="flex items-start gap-2"><i data-lucide="messages-square" class="mt-0.5 h-4 w-4 text-indigo-500"></i> Guided consultations to get interview-ready.</li>
                        </ul>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700">Create candidate profile</a>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:border-blue-200 hover:text-blue-700">Sign in</a>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-100 bg-white p-8 shadow-sm">
                        <div class="flex items-center gap-2 text-xs uppercase tracking-[2px] font-semibold text-amber-700">
                            <i data-lucide="briefcase" class="h-4 w-4"></i> For employers
                        </div>
                        <h3 class="mt-3 text-2xl font-bold text-slate-900">Hire faster with verified talent.</h3>
                        <ul class="mt-4 space-y-3 text-sm text-slate-600">
                            <li class="flex items-start gap-2"><i data-lucide="filter" class="mt-0.5 h-4 w-4 text-blue-500"></i> Filter by categories, status, and readiness to interview.</li>
                            <li class="flex items-start gap-2"><i data-lucide="files" class="mt-0.5 h-4 w-4 text-indigo-500"></i> View candidate documents, profiles, and verification badges in one view.</li>
                            <li class="flex items-start gap-2"><i data-lucide="calendar" class="mt-0.5 h-4 w-4 text-emerald-500"></i> Request interviews and manage appointments inside the platform.</li>
                        </ul>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 hover:bg-slate-800">Create employer account</a>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:border-blue-200 hover:text-blue-700">Sign in</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials -->
            <section id="testimonials" class="mx-auto max-w-7xl px-6 pb-16">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">Customer stories</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">Trusted by growing companies and ambitious talent.</h2>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-700 font-bold">AM</div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Amrita, HR Lead</p>
                                <p class="text-xs text-slate-500">Fintech, 200+ hires</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-slate-600">“Shortlists that used to take two weeks now take two days. Verification badges give our team confidence to move forward faster.”</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700 font-bold">DK</div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Daniel, Product Designer</p>
                                <p class="text-xs text-slate-500">Candidate</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-slate-600">“I loved seeing my profile score improve with each document and step. Interviews were scheduled without endless email back-and-forth.”</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-700 font-bold">SO</div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Sara, Talent Ops</p>
                                <p class="text-xs text-slate-500">Healthcare hiring</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-slate-600">“Centralizing documents and appointments removed a ton of manual follow-up. Candidates feel guided; we feel in control.”</p>
                    </div>
                </div>
            </section>

            <!-- FAQ Accordion -->
            <section id="faq" class="mx-auto max-w-4xl px-6 pb-14">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">Frequently Asked Questions</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Everything you need to know</h2>
                </div>
                <div class="space-y-4">
                    <div class="faq-item rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                        <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 transition-colors" data-faq="1">
                            <span class="font-semibold text-slate-900">How does the verification process work?</span>
                            <i data-lucide="chevron-down" class="h-5 w-5 text-slate-400 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-sm text-slate-600">Candidates submit their profiles with required documents. Our admin team reviews and verifies all information, including ID, passport, CV, and professional credentials. Once approved, profiles become visible to employers.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                        <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 transition-colors" data-faq="2">
                            <span class="font-semibold text-slate-900">What payment methods are accepted?</span>
                            <i data-lucide="chevron-down" class="h-5 w-5 text-slate-400 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-sm text-slate-600">We accept M-Pesa, Tigo Pesa, Airtel Money, Halopesa, and credit/debit cards through our secure payment gateway. All payments are processed securely and are required before booking consultations.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                        <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 transition-colors" data-faq="3">
                            <span class="font-semibold text-slate-900">Can employers see my contact information?</span>
                            <i data-lucide="chevron-down" class="h-5 w-5 text-slate-400 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-sm text-slate-600">No, your contact information is kept private. Employers can only see your verified profile, skills, and professional information. Contact details are only shared after you accept an interview request.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                        <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 transition-colors" data-faq="4">
                            <span class="font-semibold text-slate-900">How long does profile verification take?</span>
                            <i data-lucide="chevron-down" class="h-5 w-5 text-slate-400 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-sm text-slate-600">Typically, profile verification is completed within 24-48 hours after submission. You'll receive email notifications at each stage of the process.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                        <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-slate-50 transition-colors" data-faq="5">
                            <span class="font-semibold text-slate-900">Is there a fee for employers to post jobs?</span>
                            <i data-lucide="chevron-down" class="h-5 w-5 text-slate-400 faq-icon transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-sm text-slate-600">Job posting is free for employers. However, consultations with candidates require payment. Employers can browse verified candidates and request interviews at no cost.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Team Section -->
            <section id="team" class="mx-auto max-w-7xl px-6 pb-14">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[2px] text-blue-700 font-semibold">Our Team</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Meet the people behind COYZON</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 justify-items-center">
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-2 ring-white">
                            <img src="{{ asset('user1.jpg') }}" alt="John Doe" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-slate-900">John Doe</h3>
                        <p class="text-sm text-slate-600">CEO & Founder</p>
                        <p class="text-xs text-slate-500 mt-2">20+ years in recruitment</p>
                    </div>
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-2 ring-white">
                            <img src="{{ asset('user2.jpg') }}" alt="Jane Smith" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-slate-900">Jane Smith</h3>
                        <p class="text-sm text-slate-600">Head of Operations</p>
                        <p class="text-xs text-slate-500 mt-2">Expert in talent matching</p>
                    </div>
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-2 ring-white">
                            <img src="{{ asset('user3.jpeg') }}" alt="Mike Wilson" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-slate-900">Mike Wilson</h3>
                        <p class="text-sm text-slate-600">Tech Lead</p>
                        <p class="text-xs text-slate-500 mt-2">Building the platform</p>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="mx-auto max-w-6xl px-6 pb-20">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-900 to-blue-700 px-8 py-10 shadow-2xl">
                    <div class="grid gap-6 lg:grid-cols-2 lg:items-center">
                        <div class="space-y-4">
                            <p class="text-xs uppercase tracking-[2px] text-blue-100 font-semibold">Ready to begin?</p>
                            <h3 class="text-3xl font-bold text-white">Build your profile or publish your next role in minutes.</h3>
                            <p class="text-sm text-blue-100 max-w-xl">Join the Coyzon community and move from search to shortlist faster. No setup fees. Guided onboarding.</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg hover:bg-slate-100">
                                    Start for free
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/30 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/10">Sign in</a>
                            </div>
                        </div>
                        <div class="hidden justify-end lg:flex">
                            <div class="rounded-2xl bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur">
                                <div class="flex items-center gap-3 text-white">
                                    <div class="h-12 w-12 rounded-2xl bg-white/20 flex items-center justify-center">
                                        <i data-lucide="zap" class="h-6 w-6"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-100">Average time to shortlist</p>
                                        <p class="text-2xl font-bold">Under 48 hours</p>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm text-blue-100">
                                    Transparent workflows, built-in verifications, and clear communication keep every stakeholder aligned.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            
            // Hero Image Carousel
            let currentSlide = 0;
            const slides = document.querySelectorAll('.hero-slide');
            const indicators = document.querySelectorAll('.carousel-indicator');
            const totalSlides = slides.length;
            
            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.remove('active');
                    slide.style.opacity = i === index ? '1' : '0';
                });
                indicators.forEach((indicator, i) => {
                    indicator.classList.toggle('active', i === index);
                    indicator.style.opacity = i === index ? '1' : '0.5';
                });
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            }
            
            // Auto-advance carousel
            setInterval(nextSlide, 5000);
            
            // Manual indicator clicks
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentSlide = index;
                    showSlide(currentSlide);
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
                    }
                });
            });
            
            // World Map Interactions
            const continents = document.querySelectorAll('.continent');
            continents.forEach(continent => {
                continent.addEventListener('mouseenter', function() {
                    const region = this.getAttribute('data-region');
                    // Add hover effect
                });
            });
            
            // Process Circle Animation
            const processCircle = document.querySelector('.process-circle');
            if (processCircle) {
                let progress = 0;
                setInterval(() => {
                    progress = (progress + 1) % 100;
                    const offset = 1130 - (1130 * progress / 100);
                    processCircle.style.strokeDashoffset = offset;
                }, 50);
            }
        });
    </script>
    
    <style>
        .hero-slide {
            transition: opacity 1s ease-in-out;
        }
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.2); }
        }
        .faq-content {
            transition: all 0.3s ease;
        }
    </style>
</body>
</html>
