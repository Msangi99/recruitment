<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Implore - Professional Overseas Recruitment Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @keyframes fadeSlide {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }
        .hero-image {
            animation: fadeSlide 6s ease-in-out infinite;
        }
        .hero-image:nth-child(2) { animation-delay: 2s; }
        .hero-image:nth-child(3) { animation-delay: 4s; }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Implore Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">Implore</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about" class="text-gray-600 hover:text-blue-600 font-medium">About Us</a>
                    <a href="{{ route('public.jobs.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Book Appointment</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 font-medium">Contact Us</a>
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-20 overflow-hidden">
        <!-- Background Images with Fade Transition -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('user1.jpg') }}" class="hero-image absolute inset-0 w-full h-full object-cover opacity-30" alt="Hero 1">
            <img src="{{ asset('user2.jpg') }}" class="hero-image absolute inset-0 w-full h-full object-cover opacity-0" alt="Hero 2">
            <img src="{{ asset('user3.jpeg') }}" class="hero-image absolute inset-0 w-full h-full object-cover opacity-0" alt="Hero 3">
            <div class="absolute inset-0 bg-gradient-to-r from-white/90 via-white/80 to-white/70"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Hero Headline -->
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Connecting Global <span class="text-blue-600">Opportunities</span> with <span class="text-indigo-600">Qualified Talent</span>
                </h1>
                
                <!-- Sub-headline -->
                <p class="text-xl md:text-2xl text-gray-700 mb-8 max-w-3xl mx-auto">
                    We bridge talent and employers across multiple industries, delivering ethical, transparent, and culturally-based services that empower workers and build strong hiring relationships
                </p>

                <!-- Primary CTA (Buttons) -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                    <a href="{{ route('public.jobs.index') }}" class="px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all">
                        Find a Job
                    </a>
                    <a href="{{ route('public.candidates.index') }}" class="px-8 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-xl hover:bg-indigo-700 shadow-lg hover:shadow-xl transition-all">
                        Book Appointment
                    </a>
                </div>

                <!-- What We Do (Short) -->
                <div class="bg-white/80 backdrop-blur rounded-2xl p-8 shadow-xl">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">What We Do</h2>
                    <p class="text-lg text-gray-600">
                        Implore is a licensed recruitment agency specializing in sourcing, screening, and placing candidates into overseas employment opportunities that match their qualifications and career ambitions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Focus -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Industry Focus</h2>
                <p class="text-lg text-gray-600">We recruit talent across key industries including:</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <div class="bg-blue-50 rounded-xl p-6 text-center hover:bg-blue-100 transition-colors">
                    <i data-lucide="building-2" class="h-12 w-12 mx-auto mb-3 text-blue-600"></i>
                    <h3 class="font-semibold text-gray-900">Construction & Real Estate</h3>
                </div>
                <div class="bg-green-50 rounded-xl p-6 text-center hover:bg-green-100 transition-colors">
                    <i data-lucide="sprout" class="h-12 w-12 mx-auto mb-3 text-green-600"></i>
                    <h3 class="font-semibold text-gray-900">Agriculture & Farm Work</h3>
                </div>
                <div class="bg-purple-50 rounded-xl p-6 text-center hover:bg-purple-100 transition-colors">
                    <i data-lucide="factory" class="h-12 w-12 mx-auto mb-3 text-purple-600"></i>
                    <h3 class="font-semibold text-gray-900">Manufacturing & Labour Force</h3>
                </div>
                <div class="bg-orange-50 rounded-xl p-6 text-center hover:bg-orange-100 transition-colors">
                    <i data-lucide="hotel" class="h-12 w-12 mx-auto mb-3 text-orange-600"></i>
                    <h3 class="font-semibold text-gray-900">Hospitality & Tourism</h3>
                </div>
                <div class="bg-cyan-50 rounded-xl p-6 text-center hover:bg-cyan-100 transition-colors">
                    <i data-lucide="stethoscope" class="h-12 w-12 mx-auto mb-3 text-cyan-600"></i>
                    <h3 class="font-semibold text-gray-900">Healthcare</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Reach -->
    <section class="py-16 bg-gradient-to-br from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl font-bold mb-6">Global Reach</h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto">
                    We connect candidates from <strong>Dar es Salaam, Tanzania</strong> with employment opportunities across <strong>Europe, the Middle East, and beyond</strong>
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <p class="text-4xl font-bold mb-2">50+</p>
                        <p class="text-blue-100">Countries</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <p class="text-4xl font-bold mb-2">2,000+</p>
                        <p class="text-blue-100">Placements</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <p class="text-4xl font-bold mb-2">500+</p>
                        <p class="text-blue-100">Employers</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-6">
                        <p class="text-4xl font-bold mb-2">95%</p>
                        <p class="text-blue-100">Success Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust / Closing CTA -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Trust Implore?</h2>
            <p class="text-lg text-gray-600 mb-8">
                We ensure every worker receives accurate job descriptions, fair contracts, and support throughout their overseas journey. Our ethical approach builds trust with both candidates and employers.
            </p>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <i data-lucide="shield-check" class="h-12 w-12 mx-auto mb-3 text-green-600"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Licensed & Compliant</h3>
                    <p class="text-sm text-gray-600">Fully registered recruitment agency</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <i data-lucide="users-round" class="h-12 w-12 mx-auto mb-3 text-blue-600"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Culturally Sensitive</h3>
                    <p class="text-sm text-gray-600">Understanding diverse worker needs</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <i data-lucide="check-circle-2" class="h-12 w-12 mx-auto mb-3 text-indigo-600"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">End-to-End Support</h3>
                    <p class="text-sm text-gray-600">From application to placement</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">ABOUT US</h2>
            </div>
            
            <div class="prose prose-lg max-w-4xl mx-auto text-gray-700 space-y-6 mb-16">
                <p>
                    At Implore, recruitment is providing the right professionals, skilled on professionalism, transparency, and trust, we specialize in delivering reliable recruitment solutions that bridge employers and skilled workers across multiple industries.
                </p>
                <p>
                    For Workers: We understand that finding overseas opportunities is more than just a job search — it's about security, growth, and building a future. That's why our approach is tailored, strategic, and research-backed. From sourcing job candidates to conducting thorough screenings and ensuring necessary placements, we streamline the hiring process to help employers find individuals that align with their goals and company culture.
                </p>
                <p>
                    For Employers: We deliver a curated talent pool that's rigorously screened and globally sourced, giving you access to professionals ready to excel in your industry.
                </p>
                <p>
                    Our team of HR and board-complete specialists is dedicated to delivering quality with each step of the hiring process, while our vision is to become a trusted global recruitment...
                </p>
                <p class="font-semibold">Professional, Transparent, Results</p>
                <p>Implore — Your trusted partner in global recruitment excellence.</p>
            </div>

            <!-- Our Vision -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">OUR VISION</h3>
                <p class="text-gray-700">
                    Our vision is to become a trusted global recruitment agency that creates meaningful connections between qualified talent and professional employers. We aim to be the leading force in connecting organizations with exceptional talent through professional, strategic, and equitable workforce solutions.
                </p>
            </div>

            <!-- Core Values -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">OUR CORE VALUES</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4 mx-auto">
                            <span class="text-2xl font-bold text-blue-600">1</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Professionalism</h4>
                        <p class="text-sm text-gray-600 text-center">
                            We maintain the highest standards in every step of the recruitment process
                        </p>
                    </div>
                    
                    <div class="bg-white border-2 border-green-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4 mx-auto">
                            <span class="text-2xl font-bold text-green-600">2</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Integrity</h4>
                        <p class="text-sm text-gray-600 text-center">
                            We operate with honesty, transparency, and accountability, ensuring trust for both employers and candidates
                        </p>
                    </div>
                    
                    <div class="bg-white border-2 border-purple-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4 mx-auto">
                            <span class="text-2xl font-bold text-purple-600">3</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Reliability</h4>
                        <p class="text-sm text-gray-600 text-center">
                            We deliver consistent results, offering ready and dependable recruitment solutions
                        </p>
                    </div>
                    
                    <div class="bg-white border-2 border-orange-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg mb-4 mx-auto">
                            <span class="text-2xl font-bold text-orange-600">4</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Partnership</h4>
                        <p class="text-sm text-gray-600 text-center">
                            We work closely with employers and appreciate to understand their needs and provide tailored workforce solutions
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Solution -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">OUR SOLUTION</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Very companies struggle to find and attract candidates for hiring purposes, leading to these vacancies remaining unfilled for months. We fix these issues with our tailored recruitment and HR functions designed for companies at every phase of growth.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Full-scale Recruitment Solutions -->
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Full-scale Recruitment Solutions</h3>
                    <p class="text-gray-600 mb-4">
                        From end-to-end specialist sourcing, screening, & onboarding to project-tie future staffing needs
                    </p>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Temporary & Contract staffing</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Placement services for mid-to-senior-level positions</span>
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Additional Services</h3>
                    <ul class="space-y-3">
                        <li>
                            <h4 class="font-semibold text-gray-900">Payroll & HR Support</h4>
                            <p class="text-sm text-gray-600">Managing salaries, benefits, and other HR-related job seekers.</p>
                        </li>
                        <li>
                            <h4 class="font-semibold text-gray-900">Training & Coaching</h4>
                            <p class="text-sm text-gray-600">Building up your workforce through customized skills training.</p>
                        </li>
                        <li>
                            <h4 class="font-semibold text-gray-900">Market & Salary Benchmarking</h4>
                            <p class="text-sm text-gray-600">Ensuring a company's pay is competitive and aligned with local norms while keeping culturally-based services in mind.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <p class="text-red-800">
                    <strong>NOTE:</strong> The solution is <strong>FREE for seekers</strong>; employers/companies cover the hiring costs such as recruiting, screening, and interviewing expenses.
                </p>
            </div>
        </div>
    </section>

    <!-- Our Recruitment Process -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Recruitment Process</h2>
                <p class="text-lg text-gray-600">A structured, 6-step approach to finding the right talent</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full mb-4 text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Needs Assessment</h3>
                    <p class="text-gray-700">Understanding your exact requirements and company culture</p>
                </div>

                <!-- Step 2 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border-2 border-green-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full mb-4 text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Candidate Sourcing</h3>
                    <p class="text-gray-700">Leveraging networks, job boards, and referrals to identify potential matches</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border-2 border-purple-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-600 text-white rounded-full mb-4 text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Screening & Verification</h3>
                    <p class="text-gray-700">Checking qualifications, references, and skills</p>
                </div>

                <!-- Step 4 -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border-2 border-yellow-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-yellow-600 text-white rounded-full mb-4 text-xl font-bold">4</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Interviews</h3>
                    <p class="text-gray-700">Organizing employer-candidate meetings to assess fit</p>
                </div>

                <!-- Step 5 -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border-2 border-indigo-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-indigo-600 text-white rounded-full mb-4 text-xl font-bold">5</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Selection & Placement</h3>
                    <p class="text-gray-700">Presenting top-choice candidates and offering support during onboarding</p>
                </div>

                <!-- Step 6 -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border-2 border-red-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-red-600 text-white rounded-full mb-4 text-xl font-bold">6</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Post-Hire Follow-up</h3>
                    <p class="text-gray-700">Monitoring performance and ensuring a smooth transition</p>
                </div>
            </div>

            <div class="mt-12 bg-blue-600 text-white rounded-2xl p-8 text-center">
                <p class="text-xl font-semibold mb-4">
                    Design should be engaging, modern, and visually appealing using bright colors that promote professionalism and compliance with all career & development standards.
                </p>
                <p class="text-blue-100">Building properly these six building blocks for your organization!</p>
            </div>
        </div>
    </section>

    <!-- Industries We Serve -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Industries We Serve</h2>
                <p class="text-lg text-gray-600">Our focus is to connect ambitious professionals with the right global job seekers with trusted employers in key industries and Hospitality / IT / other worldwide</p>
            </div>

            <!-- Construction Industry -->
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
                <div class="flex items-center mb-6">
                    <i data-lucide="hard-hat" class="h-10 w-10 text-orange-600 mr-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900">1. Construction Industry</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    We provide qualified and hardworking professionals at the construction industry for projects:
                </p>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Construction Helper</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Mason / Bricklayer</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Carpenter</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Electrician</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Steel Fixer</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Scaffolder</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Painter</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Project Helper</p>
                    </div>
                </div>
            </div>

            <!-- Hospitality Industry -->
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
                <div class="flex items-center mb-6">
                    <i data-lucide="utensils" class="h-10 w-10 text-blue-600 mr-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900">2. Hospitality Industry</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    We place professionals in restaurants, resorts, and hospitality companies worldwide:
                </p>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Housekeeping Attendant</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Laundry Attendant</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Kitchen Staff / Cook</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Food / Beverage Cook</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Waiter / Waitress</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Cleaner</p>
                    </div>
                </div>
            </div>

            <!-- Logistics & Transport -->
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
                <div class="flex items-center mb-6">
                    <i data-lucide="truck" class="h-10 w-10 text-green-600 mr-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900">3. Logistics & Transport</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    We are looking for:
                </p>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Warehouse Workers</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Warehouse Assistant</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Drivers</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Electrician - EU / VDE Driver</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Vehicle Mechanic</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">• Delivery Personnel</p>
                    </div>
                </div>
            </div>

            <!-- Agriculture Industry -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <div class="flex items-center mb-6">
                    <i data-lucide="sprout" class="h-10 w-10 text-green-700 mr-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900">4. Agriculture Industry</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    We recruit qualified and reliable workers/agricultural workers across various levels, including:
                </p>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-bold text-gray-900 mb-2">Farm Workers</h4>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-bold text-gray-900 mb-2">Machinery & Technical Roles</h4>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-bold text-gray-900 mb-2">Livestock & Animal Care</h4>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-bold text-gray-900 mb-2">Crop Production & Harvesting</h4>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-bold text-gray-900 mb-2">Greenhouse/Nursery Work</h4>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                    <p class="text-yellow-800 text-sm">
                        <strong>NOTE:</strong> In the industry (Seasonal section), the contract should be designed plus a continental deposit. USD or equivalent is usually required as deposit for farm worker or seasonal jobs.
                    </p>
                </div>

                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-bold text-gray-900 mb-3">The Industry (Job)</h4>
                    <p class="text-gray-700 mb-2">The types of work available within this industry:</p>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Factory/field-based workers or in seasonal/permanent contracts</span>
                        </li>
                    </ul>
                    <p class="text-gray-700 mt-4 font-semibold">For example:</p>
                    <ul class="space-y-2 text-gray-700 mt-2">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Construction workers seeking for a construction job.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Employers or Companies seeking skilled or unskilled workers.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Logistics - truck driver, warehouse staff, or logistics operations</span>
                        </li>
                    </ul>
                    <p class="text-gray-700 mt-4">
                        When possible, long-term listings within a single industry can fill up fast, work administered, kept open with increasing, driving, and manufacturing, will embrace all our target clients even if these workers remain employees- core stakeholders.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us? -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Us?</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 shadow-lg border-2 border-blue-200">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="users" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Experienced HR Professionals</h3>
                    <p class="text-gray-700 text-center">with industry knowledge</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 shadow-lg border-2 border-green-200">
                    <div class="flex items-center justify-center w-16 h-16 bg-green-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="globe" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">International Job Placement</h3>
                    <p class="text-gray-700 text-center">rooting (with a proven track record and client network)</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-8 shadow-lg border-2 border-purple-200">
                    <div class="flex items-center justify-center w-16 h-16 bg-purple-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="target" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Tailored Recruitment</h3>
                    <p class="text-gray-700 text-center">that matches talent with your business needs</p>
                </div>

                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-8 shadow-lg border-2 border-indigo-200">
                    <div class="flex items-center justify-center w-16 h-16 bg-indigo-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="shield-check" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Full Compliance</h3>
                    <p class="text-gray-700 text-center">with local employment law and international standards</p>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-8 shadow-lg border-2 border-orange-200">
                    <div class="flex items-center justify-center w-16 h-16 bg-orange-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="headphones" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Post-Placement Support</h3>
                    <p class="text-gray-700 text-center">to ensure successful integration</p>
                </div>
            </div>

            <div class="bg-blue-600 text-white rounded-2xl p-8 text-center">
                <p class="text-xl font-semibold mb-2">
                    <strong>NOTE:</strong> "Why Choose Us" section should be designed with clarity, simplicity, and visual appeal in mind. The layout should be easy-to-scan, with appropriate spacing and neat, allowing visitors to quickly understand Implore's value at a glance.
                </p>
            </div>
        </div>
    </section>

    <!-- Our Target Clients -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">OUR TARGET CLIENTS</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-blue-200">
                    <div class="flex items-center mb-4">
                        <i data-lucide="building-2" class="h-10 w-10 text-blue-600 mr-3"></i>
                        <h3 class="text-2xl font-bold text-gray-900">Employers & Companies</h3>
                    </div>
                    <p class="text-gray-700">seeking skilled and reliable candidates</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-green-200">
                    <div class="flex items-center mb-4">
                        <i data-lucide="briefcase" class="h-10 w-10 text-green-600 mr-3"></i>
                        <h3 class="text-2xl font-bold text-gray-900">SMEs & Corporate Organizations</h3>
                    </div>
                    <p class="text-gray-700">requiring scalable hiring (small & medium/large)</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-purple-200">
                    <div class="flex items-center mb-4">
                        <i data-lucide="hospital" class="h-10 w-10 text-purple-600 mr-3"></i>
                        <h3 class="text-2xl font-bold text-gray-900">Institutional Facilities</h3>
                    </div>
                    <p class="text-gray-700">needing verified and consistent placement solutions</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-orange-200">
                    <div class="flex items-center mb-4">
                        <i data-lucide="clock" class="h-10 w-10 text-orange-600 mr-3"></i>
                        <h3 class="text-2xl font-bold text-gray-900">Companies with Staffing Needs</h3>
                    </div>
                    <p class="text-gray-700">short-term and long-term staffing needs</p>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border-l-4 border-blue-600 p-6 rounded-lg">
                <p class="text-gray-800">
                    <strong>NOTE:</strong> On the "Target Client" section, use a design narrative that clearly explains Implore's value proposition. Sections should strategically balance "branding, content, and easy-to-understand. The layout should clearly highlight each client category with icon visuals + bold headers + supporting descriptive text that quickly signals who Implore serves and how the platform tailored workforce solutions provided will support industry.
                </p>
            </div>
        </div>
    </section>

    <!-- Target Destinations -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">TARGET DESTINATIONS</h2>
                <p class="text-lg text-gray-600">We connect talent with opportunities across key global regions</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Tanzania (East Africa) -->
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-8 shadow-lg border-2 border-orange-300">
                    <div class="flex items-center justify-center w-16 h-16 bg-orange-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="map-pin" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Tanzania (East Africa)</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Nairobi/Kisumu for casual & no-skilled placement</span>
                        </li>
                    </ul>
                </div>

                <!-- Middle East -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-8 shadow-lg border-2 border-blue-300">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="map-pin" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Middle East</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>UAE (Dubai, Abu Dhabi)</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Saudi Arabia</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Qatar</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Oman</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Kuwait</span>
                        </li>
                    </ul>
                </div>

                <!-- Europe -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-8 shadow-lg border-2 border-green-300">
                    <div class="flex items-center justify-center w-16 h-16 bg-green-600 text-white rounded-full mb-4 mx-auto">
                        <i data-lucide="map-pin" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Europe</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Germany</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Poland</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Romania</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Lithuania</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Czech Republic</span>
                        </li>
                        <li class="flex items-start">
                            <i data-lucide="check" class="h-5 w-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                            <span>Malta and UK</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-indigo-600 text-white rounded-2xl p-8 mb-8">
                <p class="text-lg text-center">
                    <strong>NOTE:</strong> Target Destinations – World Map Design Concept: The "Target Destinations" section should be designed with an attractive or vibrant world map that showcases each destination region visually appealing. The design should highlight the destinations using custom icons and global node. The visual should highlight the destination nodes on a stylized world map that shows Implore operates at a global scale and internationally recruited and Cultural context can also be incorporated overall with global.
                </p>
            </div>

            <!-- Highlighted Destinations -->
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Highlighted Destinations</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg p-6 shadow-md text-center">
                        <h4 class="text-xl font-bold text-orange-600 mb-2">Tanzania (Semi/Skilled)</h4>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md text-center">
                        <h4 class="text-xl font-bold text-blue-600 mb-2">Middle East</h4>
                        <p class="text-gray-600 text-sm">UAE (Saudi Arabia, Qatar, Oman, Kuwait)</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md text-center">
                        <h4 class="text-xl font-bold text-green-600 mb-2">Europe</h4>
                        <p class="text-gray-600 text-sm">Germany, Poland, Romania, Lithuania/Czech Republic/Malta and UK</p>
                    </div>
                </div>
            </div>
        </div>
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
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="1">
                        <span class="font-bold text-gray-900 text-lg">What services do you offer to employers?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We provide talent sourcing, screening, onboarding, temporary/contract staffing, and full-payroll HR support for both local and international placement.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="2">
                        <span class="font-bold text-gray-900 text-lg">How are you different from other agencies?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We're focused on ethical placement, cultural sensitivity, and end-to-end compliance. Our rigorous screening ensures you get candidates who match both skills and organizational fit.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="3">
                        <span class="font-bold text-gray-900 text-lg">How do you vet qualified candidates?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We evaluate by educational background, work experience, skill tests, references, and background checks to ensure both quality and safety.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="4">
                        <span class="font-bold text-gray-900 text-lg">Can you provide temporary staff for short-term needs?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">Yes, we offer temporary and contract staffing to meet immediate workforce gaps and project-based demands.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="5">
                        <span class="font-bold text-gray-900 text-lg">Can you provide payroll services for deployed staff?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">Yes, we manage payroll including workers & benefits, tax & documentation for a streamlined, beneficial administrative workload and HR compliance.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="6">
                        <span class="font-bold text-gray-900 text-lg">Do you offer candidate training?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">Yes, we are experts at preparing workers for training to enhance workforce competencies for their tasks.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="faq-item bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                    <button class="faq-button w-full px-6 py-5 text-left flex items-center justify-between hover:bg-blue-50 transition-colors" data-faq="7">
                        <span class="font-bold text-gray-900 text-lg">How do you support overseas with cultural barriers?</span>
                        <i data-lucide="chevron-down" class="h-6 w-6 text-gray-400 faq-icon transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-gray-700">We have international partnership with locals and embassies & other who help maintain a stable cultural relationship/orientation on main destinations.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border-l-4 border-blue-600 p-6 rounded-lg">
                <p class="text-gray-800">
                    <strong>NOTE:</strong> Use a modern card with layout, where each question shows as a clean card or accordion. Give. If the user/view of a user clicks on a question, there appears below them a clean, well-textured, and modern card that provides the answer/detail. The section should be visually appealing, featuring classy, neat, modern, and simplified.
                </p>
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
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-blue-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user1.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">John Doe</h3>
                    <p class="text-blue-600 font-semibold mb-2">CEO & Founder</p>
                    <p class="text-sm text-gray-600">20+ years in recruitment industry</p>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-green-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user2.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Jane Smith</h3>
                    <p class="text-green-600 font-semibold mb-2">Head of Operations</p>
                    <p class="text-sm text-gray-600">Expert in global talent placement</p>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-purple-200">
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden shadow-lg ring-4 ring-white">
                        <img src="{{ asset('user3.jpeg') }}" alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Michael Johnson</h3>
                    <p class="text-purple-600 font-semibold mb-2">HR Director</p>
                    <p class="text-sm text-gray-600">Compliance and ethical recruitment specialist</p>
                </div>

                <!-- Team Member 4 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow border-2 border-orange-200">
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

    <!-- Final CTA -->
    <section class="py-16 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 text-blue-100">Join thousands of professionals finding global opportunities</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-100 shadow-lg hover:shadow-xl transition-all">
                    Register as Job Seeker
                </a>
                <a href="{{ route('public.candidates.index') }}" class="px-8 py-4 bg-indigo-900 text-white font-semibold rounded-xl hover:bg-indigo-800 shadow-lg hover:shadow-xl transition-all">
                    Book Appointment
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transition-all">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
