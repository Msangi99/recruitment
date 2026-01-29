<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-removed-background.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</head>

<body class="bg-white text-gray-900">
    @include('partials.public-nav')

    <!-- About Us Section -->
    <section id="about" class="pt-24 pb-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-8 text-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">ABOUT US</h2>
                    <div class="w-24 h-1.5 bg-blue-600 mx-auto rounded-full mb-8"></div>
                </div>

                <div class="space-y-6 text-lg text-slate-600 leading-relaxed text-justify">
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
                    <p class="text-slate-900 font-bold text-center mt-8 text-xl">
                        Professional. Transparent. Reliable.<br>
                        <span class="text-black font-serif text-2xl">Coyzon</span> — Your trusted partner in global
                        recruitment
                        excellence.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section (Copied from Home) -->
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

    <!-- Our Team -->

                           <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-slate-900 mb-4">Our Team</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
                <p class
=                       "mt-6 text-lg text-slate-600 max-w-4xl mx-auto">

                                        Our 
t                       eam consists of skilled, reliable, and well-coordinated recruitment professionals committed to
                    delivering high-quality recruitment and candidate placement services. We work closely with employers
                    and partners to ensure the right talent is sourced, screened, and placed efficiently for long-term success.
                    Beyond work, our team members enjoy reading, sports and fitness activities, travel, and continuous
                    learning—strengthening teamwork, adaptability, and strong professional relationships with our c
l                       ients and
                    partners.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-slate-900 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-slate-800 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white/10 relative z-10">
                        <img src="{{ asset('user2.jpg') }}" alt="James Majid" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-outfit font-extrabold text-white mb-2 relative z-10 tracking-tight">James Majid</h3>
                    <p class="text-green-400 font-outfit font-medium text-base mb-2 relative z-10">Chief Executive Officer & Founder</p>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-slate-900 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-slate-800 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white/10 relative z-10">
                        <img src="{{ asset('user1.jpg') }}" alt="Edgar Mwandiga" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-outfit font-extrabold text-white mb-2 relative z-10 tracking-tight">Edgar Mwandiga</h3>
                    <p class="text-green-400 font-outfit font-medium text-base mb-2 relative z-10">Marketing Manager</p>
                </div>

                <!-- Team Member 3 -->
                <div
                    class="bg-slate-900 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-slate-800 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white/10 relative z-10">
                        <img src="{{ asset('user3.jpeg') }}" alt="Arica Gonzalez" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-outfit font-extrabold text-white mb-2 relative z-10 tracking-tight">Arica Gonzalez</h3>
                    <p class="text-green-400 font-outfit font-medium text-base mb-2 relative z-10">Human resource Manager</p>
                </div>

                <!-- Team Member 4 -->
                <div
                    class="bg-slate-900 rounded-3xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-slate-800 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="w-32 h-32 rounded-full mx-auto mb-6 overflow-hidden shadow-xl ring-4 ring-white/10 relative z-10">
                        <img src="{{ asset('green_mwimbage.jpg') }}" alt="Green Mwimbage" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-outfit font-extrabold text-white mb-2 relative z-10 tracking-tight">Green Mwimbage</h3>
                    <p class="text-green-400 font-outfit font-medium text-base mb-2 relative z-10">Talent Acquisition Specialist</p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>

</html>