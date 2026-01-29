<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Professional Overseas Recruitment Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    }
                }
            }
        }
    </script>
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
    @include('partials.public-nav')

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

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([
                    [
                        'title' => 'Professionalism',
                        'desc' => 'We maintain the highest standards in every step of the recruitment process.',
                        'bg' => 'bg-cyan-600/20 group-hover:bg-cyan-600/30',
                        'pos' => 'top-0 right-0 -mt-10 -mr-10'
                    ],
                    [
                        'title' => 'Integrity',
                        'desc' => 'We operate with honesty, transparency, and accountability.',
                        'bg' => 'bg-blue-600/20 group-hover:bg-blue-600/30',
                        'pos' => 'bottom-0 left-0 -mb-10 -ml-10'
                    ],
                    [
                        'title' => 'Reliability',
                        'desc' => 'We deliver consistent results with timely and dependable solutions.',
                        'bg' => 'bg-cyan-600/20 group-hover:bg-cyan-600/30',
                        'pos' => 'top-0 left-0 -mt-10 -ml-10'
                    ],
                    [
                        'title' => 'Partnership',
                        'desc' => 'We match organizations with verified, skilled candidates who add real value.',
                        'bg' => 'bg-blue-600/20 group-hover:bg-blue-600/30',
                        'pos' => 'bottom-0 right-0 -mb-10 -mr-10'
                    ]
                ] as $value)
                <div class="group relative overflow-hidden rounded-2xl bg-slate-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-slate-900/30 min-h-[200px] flex flex-col justify-center">
                    <div class="absolute {{ $value['pos'] }} h-32 w-32 rounded-full {{ $value['bg'] }} blur-[40px] transition-colors duration-500"></div>
                    <div class="relative z-10 p-6 text-center">
                        <h3 class="text-lg font-bold text-white mb-2">{{ $value['title'] }}</h3>
                        <p class="text-sm text-blue-100/80 leading-relaxed">{{ $value['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>




    <!-- Our Solution Section -->
    <section class="py-16 bg-gray-50 relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tight text-slate-900 mb-8 text-center">SOLUTION</h1>

            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                <!-- TOP AREA -->
                <div class="grid md:grid-cols-[1fr_420px] gap-6 p-7 items-center">
                    <div class="flex gap-4 items-start max-w-xl">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                            <!-- Bulb/Idea icon -->
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" class="text-blue-600">
                                <path d="M9 21h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M10 17h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 2a7 7 0 0 0-4 12c.6.5 1 1.2 1.2 2h5.6c.2-.8.6-1.5 1.2-2A7 7 0 0 0 12 2Z"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <p class="text-slate-600 leading-relaxed text-sm">
                            Many companies struggle to find skilled and qualified candidates for their key positions,
                            leading to delays and increased costs. This is where Coyzon Company Limited comes in.
                            We help employers quickly and efficiently connect with the right talent, ensuring every
                            candidate is thoroughly vetted, aligned with job requirements, and ready to contribute
                            immediately. From job analysis to onboarding, we provide professional support at every step.
                        </p>
                    </div>

                    <div class="relative rounded-2xl overflow-hidden h-36 bg-slate-100">
                        <img src="{{ asset('solution_top_image.jpg') }}" alt="Top office scene" class="w-full h-full object-cover">
                        {{-- <div class="absolute right-0 top-0 w-16 h-full bg-blue-600"></div> --}}
                    </div>
                </div>

                <!-- BOTTOM AREA -->
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 grid md:grid-cols-[420px_1fr] gap-8 p-7">
                    <div class="rounded-2xl overflow-hidden h-80 bg-slate-200">
                        <img src="{{ asset('solution_bottom_image.jpg') }}" alt="Office workspace" class="w-full h-full object-cover">
                    </div>

                    <div class="space-y-3 pr-2">
                        @foreach([
                            ['title' => 'End-to-End Recruitment Solutions', 'desc' => 'From job requirement analysis, sourcing, screening, hiring, onboarding, to post-hire follow-up.'],
                            ['title' => 'Temporary & Contract Staffing', 'desc' => 'Conducting initial interviews, aptitude tests, and reference checks before presenting candidates.'],
                            ['title' => 'Payroll & HR Support', 'desc' => 'Managing salaries, benefits, and other HR matters for agency-deployed staff.'],
                            ['title' => 'Training & Upskilling', 'desc' => 'Preparing candidates with training to ensure immediate contribution to the company.'],
                            ['title' => 'Market & Salary Benchmarking', 'desc' => 'Advising on labor market trends, salary ranges, and talent competition.']
                        ] as $item)
                        <div class="grid grid-cols-[auto_1fr] gap-3 py-2">
                            <div class="w-7 h-7 rounded-lg bg-blue-500/15 flex items-center justify-center mt-0.5">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-blue-600">
                                    <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 mb-1">{{ $item['title'] }}</h3>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
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
                <img src="{{ asset('pop.png') }}" alt="Full Cycle Recruiting Process" class="w-full max-w-3xl rounded-2xl shadow-xl">
            </div>
            <div class="mt-12 text-center">
                {{-- <a href="{{ route('public.jobs.index') }}" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-black rounded-full hover:scale-105 transition-all shadow-2xl hover:shadow-blue-200 group">
                    EXPLORE GLOBAL ROLES
                    <i data-lucide="sparkles" class="ml-3 w-6 h-6 animate-pulse"></i>
                </a> --}}
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    [
                        'title' => 'Construction Industry',
                        'img' => 'industry_construction.png',
                        'desc' => '"we connect qualified and hardworking professionals with trusted employers in the construction Industry."',
                        'roles' => ['General Laborer', 'Construction Helper', 'Mason / Bricklayer', 'Plumber Assistant', 'Carpenter', 'Steel Fixer', 'Scaffolder', 'Painter', 'Tiler', 'Electrician Helper'],
                        'c' => 'blue'
                    ],
                    [
                        'title' => 'Hospitality Industry',
                        'img' => 'industry_hospitality.png',
                        'desc' => '"we place professionals in top restaurants, resorts, and hospitality companies worldwide. In the following position"',
                        'roles' => ['Housekeeping Attendant', 'Laundry Attendant', 'Waiter / Waitress', 'Cook / Assistant Cook', 'Kitchen Helper', 'Security Guard', 'Cleaner'],
                        'c' => 'indigo'
                    ],
                    [
                        'title' => 'Logistics & Transport',
                        'img' => 'industry_logistics.png',
                        'desc' => '"We are recruiting for"',
                        'roles' => ['Drivers', 'Warehouse Worker / Assistant', 'Delivery Driver / Van Driver', 'Forklift Operator', 'Storekeeper', 'Packing & Sorting Staff', 'Loader / Unloader', 'Vehicle Mechanic'],
                        'c' => 'teal'
                    ],
                    [
                        'title' => 'Agriculture Industry',
                        'img' => 'industry_agriculture.png',
                        'desc' => '"We recruits qualified and reliable agricultural workers across various levels, including:"',
                        'roles' => ['Farm & Field Workers', 'Machinery & Technical Roles', 'Livestock & Animal Care', 'Skilled & Supervisory Roles', 'Post-Harvest & Agri-Processing'],
                        'c' => 'emerald'
                    ]
                ] as $ind)
                <div class="bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-900/50 border border-slate-800 group transition-all duration-500 hover:-translate-y-2 flex flex-col">
                    <div class="h-48 relative overflow-hidden">
                        <img src="{{ asset($ind['img']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $ind['title'] }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-6 right-6">
                            <h3 class="text-xl font-black text-white uppercase tracking-tighter leading-tight">{{ $ind['title'] }}</h3>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-blue-100/80 font-medium mb-6 italic text-sm">{{ $ind['desc'] }}</p>
                        <div class="flex flex-wrap gap-2 mt-auto">
                            @foreach($ind['roles'] as $role)
                                <span class="inline-flex items-center px-2.5 py-1 bg-{{$ind['c']}}-900/30 text-{{$ind['c']}}-200 text-[10px] font-medium rounded-full border border-{{$ind['c']}}-700/50">
                                    <span class="w-1 h-1 bg-{{$ind['c']}}-400 rounded-full mr-1.5"></span>
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
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
                    <div class="bg-slate-900 p-8 rounded-[3rem] shadow-xl shadow-slate-900/20 border border-slate-800 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                        <!-- Background Glow Effect for Hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-{{$client['c']}}-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        
                        <div class="relative z-10 w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm group-hover:scale-110 transition-transform duration-500 border border-white/10">
                            <i data-lucide="{{$client['i']}}" class="w-6 h-6 text-{{$client['c']}}-400 group-hover:text-white transition-colors duration-500"></i>
                        </div>
                        <p class="relative z-10 font-medium text-blue-100/80 leading-relaxed text-xs tracking-wide">{{$client['t']}}</p>
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
                    {{-- <h2 class="text-slate-900 tracking-[0.2em] uppercase text-sm mb-4">Global Network</h2> --}}
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight uppercase tracking-tighter">
                        Target <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-[#A52A2A] to-slate-900">Destinations</span>
                    </h1>
                    <p class="mt-6 text-lg text-slate-600 leading-relaxed font-medium">
                        Connecting African to the world's leading economic hubs with end-to-end support and ethical placement.
                    </p>
                </div>
                <div class="hidden lg:flex items-center gap-4 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <!-- Africa Group -->
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Africa</span>
                        <div class="flex -space-x-2.5">
                            @foreach(['TZ', 'KE', 'UG', 'BI', 'CD', 'ZM', 'ZA'] as $flag)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center overflow-hidden shadow-sm hover:z-10 transition-all hover:scale-110">
                                    <img src="https://flagcdn.com/w40/{{ strtolower($flag) }}.png" class="w-full h-full object-cover" alt="{{ $flag }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Vector Arrow -->
                    <div class="flex items-center px-2">
                        <div class="w-10 h-px bg-gradient-to-r from-blue-400 to-indigo-600 relative">
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 w-2 h-2 border-t border-r border-indigo-600 rotate-45"></div>
                        </div>
                    </div>

                    <!-- World Group -->
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2.5">
                            @foreach(['AE', 'SA', 'OM', 'QA', 'KW', 'EU', 'CA', 'GB', 'AU'] as $flag)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center overflow-hidden shadow-sm hover:z-10 transition-all hover:scale-110">
                                    <img src="https://flagcdn.com/w40/{{ strtolower($flag) }}.png" class="w-full h-full object-cover" alt="{{ $flag }}">
                                </div>
                            @endforeach
                        </div>
                        <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em]">World</span>
                    </div>
                </div>
            </div>

            <!-- Styled Map Visualization Area -->
            <div class="relative w-full aspect-[21/9] mb-16 group overflow-hidden rounded-[2.5rem] shadow-2xl border border-slate-100">
                <img src="{{ asset('what.jpeg') }}" 
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
                <p class="mt-6 text-slate-500 max-w-2xl mx-auto">Coyzon delivers structured and reliable global recruitment solutions built on professionalism, compliance, and trust. We partner with employers to provide qualified talent through transparent processes and consistent results</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach([
                        'Experienced HR professionals with industry knowledge',
                        'International job placement (Including visa and relocation guidance)',
                        'Tailored recruitment that matches talent with your business needs',
                        'Full compliance with national and international labor laws',
                        'Post-placement support to ensure successful integration'
                    ] as $item)
                    <div class="group relative overflow-hidden rounded-2xl bg-slate-900 p-5 text-center shadow-lg border border-slate-800 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                        <!-- Hover Effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <p class="relative z-10 text-xs font-medium text-blue-100/80 leading-relaxed">{{$item}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>






    <!-- FAQs - Frequently Asked Questions -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">FAQs – Frequently Asked Questions</h2>
            </div>

            <div class="space-y-4">
                @foreach([
                    ['q' => 'What services do you offer to employers?', 'a' => 'We provide talent sourcing, screening, onboarding, temporary/contract staffing, and full-payroll HR support for both local and international placement.'],
                    ['q' => 'How are you different from other agencies?', 'a' => "We're focused on ethical placement, cultural sensitivity, and end-to-end compliance. Our rigorous screening ensures you get candidates who match both skills and organizational fit."],
                    ['q' => 'How do you vet qualified candidates?', 'a' => 'We evaluate by educational background, work experience, skill tests, references, and background checks to ensure both quality and safety.'],
                    ['q' => 'Can you provide temporary staff for short-term needs?', 'a' => 'Yes, we offer temporary and contract staffing to meet immediate workforce gaps and project-based demands.'],
                    ['q' => 'Can you provide payroll services for deployed staff?', 'a' => 'Yes, we manage payroll including workers & benefits, tax & documentation for a streamlined, beneficial administrative workload and HR compliance.'],
                    ['q' => 'Do you offer candidate training?', 'a' => 'Yes, we are experts at preparing workers for training to enhance workforce competencies for their tasks.'],
                    ['q' => 'How do you support overseas with cultural barriers?', 'a' => 'We have international partnership with locals and embassies & other who help maintain a stable cultural relationship/orientation on main destinations.']
                ] as $index => $faq)
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="{{ $index + 1 }}">
                        <span class="font-bold text-gray-900 text-sm">{{ $faq['q'] }}</span>
                        <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-700 text-xs">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
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