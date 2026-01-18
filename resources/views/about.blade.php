<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Coyzon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
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
                    <a href="{{ route('public.jobs.index') }}" class="text-blue-600 hover:text-blue-800 font-bold">Find
                        Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Find Candidate</a>
                    <a href="{{ route('public.appointments.index') }}"
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
                            At Coyzon, we believe in connecting people to the right opportunities. Built on
                            professionalism, transparency, and trust, we specialize in delivering reliable recruitment
                            solutions that bridge employers with skilled and verified talent locally and
                            internationally.
                        </p>
                        <p>
                            We understand that every organization has unique workforce needs. That's why our approach is
                            tailored, strategic, and results-oriented. From sourcing top candidates to conducting
                            thorough screenings and ensuring seamless placements, we streamline the entire recruitment
                            process with precision and integrity.
                        </p>
                        <p>
                            Beyond serving employers, Coyzon is equally committed to supporting job seekers. We guide
                            candidates through credible career opportunities, ensure fair recruitment practices, and
                            connect them with employers who value their skills and potential. Our goal is to create
                            long-term success for both talent and organizations.
                        </p>
                        <p>
                            Our team of HR and talent acquisition specialists is dedicated to delivering qualified
                            professionals who bring real value to businesses, while helping individuals access
                            meaningful employment opportunities worldwide.
                        </p>
                        <p class="text-slate-900 font-bold">
                            Professional. Transparent. Reliable.<br>
                            Coyzon — Your trusted partner in global recruitment excellence.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div
                            class="bg-blue-600 aspect-square rounded-3xl flex flex-col items-center justify-center text-white p-8 text-center shadow-2xl shadow-blue-500/20">
                            <i data-lucide="eye" class="h-12 w-12 mb-4"></i>
                            <h3 class="text-xl font-bold mb-2 uppercase tracking-wider">OUR VISION</h3>
                        </div>
                        <div class="bg-slate-100 aspect-square rounded-3xl p-8 flex flex-col justify-center">
                            <p class="text-slate-900 font-bold leading-tight">To become the leading global recruitment
                                gateway connecting organizations with exceptional talent through professionalism,
                                integrity, and an impactful workforce Solutions.</p>
                        </div>
                    </div>
                    <div class="space-y-6 pt-12">
                        <div
                            class="bg-indigo-600 aspect-square rounded-3xl flex flex-col items-center justify-center text-white p-8 text-center shadow-2xl shadow-indigo-500/20">
                            <i data-lucide="target" class="h-12 w-12 mb-4"></i>
                            <h3 class="text-xl font-bold mb-2 uppercase tracking-wider">OUR MISSION</h3>
                        </div>
                        <div class="bg-slate-100 aspect-square rounded-3xl p-8 flex flex-col justify-center">
                            <p class="text-slate-900 font-bold leading-tight">To deliver trusted, efficient, and
                                transparent recruitment services that empower employers to build strong teams and help
                                candidates access real, life-changing career opportunities across the world.</p>
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
                <div
                    class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors duration-500">
                        <i data-lucide="award"
                            class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">1. Professionalism</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We maintain the highest standards in every step of the recruitment process.
                    </p>
                </div>

                <!-- Integrity -->
                <div
                    class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div
                        class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-500">
                        <i data-lucide="shield-check"
                            class="h-8 w-8 text-emerald-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">2. Integrity</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We operate with honesty, transparency, and accountability, ensuring trust for both employers and
                        candidates.
                    </p>
                </div>

                <!-- Reliability -->
                <div
                    class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div
                        class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 transition-colors duration-500">
                        <i data-lucide="clock"
                            class="h-8 w-8 text-amber-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">3. Reliability</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We deliver consistent results, offering timely and dependable recruitment solutions.
                    </p>
                </div>

                <!-- Partnership -->
                <div
                    class="group bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 border border-slate-100">
                    <div
                        class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-500">
                        <i data-lucide="handshake"
                            class="h-8 w-8 text-indigo-600 group-hover:text-white transition-colors duration-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">4. Partnership</h3>
                    <p class="text-slate-600 leading-relaxed">
                        We work closely with employers and agencies to understand their needs and provide tailored
                        workforce solutions through matching organizations with verified, skilled, and committed
                        candidates who add real value.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-slate-900 mb-4">Our Team</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
                <p class="mt-6 text-lg text-slate-600">Meet the dedicated professionals driving COYZON's success</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-blue-100">
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white">
                        <img src="{{ asset('user1.jpg') }}" alt="John Doe" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-1">John Doe</h3>
                    <p class="text-blue-600 font-bold text-sm uppercase tracking-wider mb-2">CEO & Founder</p>
                </div>

                <!-- Team Member 2 -->
                <div
                    class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-emerald-100">
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white">
                        <img src="{{ asset('user2.jpg') }}" alt="Jane Smith" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Jane Smith</h3>
                    <p class="text-emerald-600 font-bold text-sm uppercase tracking-wider mb-2">Head of Operations</p>
                </div>

                <!-- Team Member 3 -->
                <div
                    class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-indigo-100">
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white">
                        <img src="{{ asset('user3.jpeg') }}" alt="Michael Johnson" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Michael Johnson</h3>
                    <p class="text-indigo-600 font-bold text-sm uppercase tracking-wider mb-2">HR Director</p>
                </div>

                <!-- Team Member 4 -->
                <div
                    class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-amber-100">
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white">
                        <img src="{{ asset('user1.jpg') }}" alt="Sarah Williams" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Sarah Williams</h3>
                    <p class="text-amber-600 font-bold text-sm uppercase tracking-wider mb-2">Client Relations</p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>

</html>