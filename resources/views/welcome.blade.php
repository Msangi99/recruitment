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
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white text-lg font-extrabold shadow-lg">CZ</div>
                    <div>
                        <p class="text-xs uppercase tracking-[3px] text-slate-500 font-semibold">Coyzon</p>
                        <p class="text-lg font-bold text-slate-900">Recruitment Platform</p>
                    </div>
                </div>

                <div class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                    <a href="#how-it-works" class="hover:text-slate-900">How it works</a>
                    <a href="#solutions" class="hover:text-slate-900">Solutions</a>
                    <a href="#testimonials" class="hover:text-slate-900">Stories</a>
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
            <!-- Hero -->
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
                    <div class="rounded-3xl border border-white/80 bg-white/70 p-6 shadow-2xl backdrop-blur">
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
        });
    </script>
</body>
</html>
