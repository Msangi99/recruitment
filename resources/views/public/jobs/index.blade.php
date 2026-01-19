<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-14 w-auto">
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

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <form method="GET" action="{{ route('public.jobs.index') }}" class="relative max-w-4xl">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search jobs, companies, or keywords..."
                        class="block w-full pl-11 pr-24 py-4 bg-white border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg transition-all duration-200">
                    <div class="absolute inset-y-0 right-2 flex items-center">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition-colors font-medium">
                            Search
                        </button>
                    </div>
                </div>

                @if(request()->anyFilled(['category_id', 'country', 'employment_type', 'experience_level', 'education_level', 'salary_period', 'date_posted']))
                    <div class="mt-2 flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Active filters:</span>
                        <a href="{{ route('public.jobs.index') }}" class="text-blue-600 hover:underline">Clear all</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 space-y-6 flex-shrink-0">
                <form method="GET" action="{{ route('public.jobs.index') }}" id="filterForm" class="space-y-4">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="space-y-3">
                        <!-- Category -->
                        <select name="category_id" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <!-- Country -->
                        <select name="country" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">All Countries</option>
                            <option value="Canada" {{ request('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Poland" {{ request('country') == 'Poland' ? 'selected' : '' }}>Poland</option>
                            <option value="Germany" {{ request('country') == 'Germany' ? 'selected' : '' }}>Germany
                            </option>
                            <option value="Romania" {{ request('country') == 'Romania' ? 'selected' : '' }}>Romania
                            </option>
                            <option value="Croatia" {{ request('country') == 'Croatia' ? 'selected' : '' }}>Croatia
                            </option>
                            <option value="OMAN" {{ request('country') == 'OMAN' ? 'selected' : '' }}>OMAN</option>
                            <option value="Australia" {{ request('country') == 'Australia' ? 'selected' : '' }}>Australia
                            </option>
                            <option value="QUATAR" {{ request('country') == 'QUATAR' ? 'selected' : '' }}>QUATAR</option>
                            <option value="Kuwait" {{ request('country') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                            <option value="United Arab Emirates" {{ request('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                            <option value="Saudi Arabia" {{ request('country') == 'Saudi Arabia' ? 'selected' : '' }}>
                                Saudi Arabia</option>
                            <option value="Europe" {{ request('country') == 'Europe' ? 'selected' : '' }}>Europe</option>
                        </select>

                        <!-- Employment Type -->
                        <select name="employment_type" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">All Job Types</option>
                            <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>
                                Full-time</option>
                            <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                Contract</option>
                            <option value="seasonal" {{ request('employment_type') == 'seasonal' ? 'selected' : '' }}>
                                Seasonal</option>
                            <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>
                                Temporary</option>
                        </select>

                        <!-- Experience Level -->
                        <select name="experience_level" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Any Experience</option>
                            <option value="no-experience" {{ request('experience_level') == 'no-experience' ? 'selected' : '' }}>No experience</option>
                            <option value="1-2" {{ request('experience_level') == '1-2' ? 'selected' : '' }}>1–2 years
                            </option>
                            <option value="3-5" {{ request('experience_level') == '3-5' ? 'selected' : '' }}>3–5 years
                            </option>
                            <option value="5+" {{ request('experience_level') == '5+' ? 'selected' : '' }}>5+ years
                            </option>
                        </select>

                        <!-- Education Level -->
                        <select name="education_level" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Any Education</option>
                            <option value="no-formal-education" {{ request('education_level') == 'no-formal-education' ? 'selected' : '' }}>No formal education</option>
                            <option value="secondary-school" {{ request('education_level') == 'secondary-school' ? 'selected' : '' }}>Secondary School</option>
                            <option value="certificate" {{ request('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                            <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>
                                Diploma</option>
                            <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>
                                Bachelor's Degree</option>
                        </select>

                        <!-- Date Posted -->
                        <select name="date_posted" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Date Posted</option>
                            <option value="48-hours" {{ request('date_posted') == '48-hours' ? 'selected' : '' }}>Last 48
                                Hours</option>
                            <option value="7-days" {{ request('date_posted') == '7-days' ? 'selected' : '' }}>Last 7 Days
                            </option>
                            <option value="30-days" {{ request('date_posted') == '30-days' ? 'selected' : '' }}>Last 30
                                Days</option>
                        </select>

                        <button type="submit"
                            class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">
                            Update Results
                        </button>
                    </div>
                </form>
            </aside>

            <!-- Jobs Results -->
            <main class="flex-1">
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $jobs->total() }} Jobs Found
                    </h2>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select
                            class="text-sm border-none bg-transparent font-medium text-gray-900 focus:ring-0 cursor-pointer">
                            <option>Newest</option>
                            <option>Salary</option>
                        </select>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <h3
                                            class="text-lg font-bold text-[#1f2937] leading-tight hover:text-[#3b82f6] transition-colors">
                                            <a href="{{ route('public.jobs.show', $job) }}">{{ $job->title }}</a>
                                        </h3>
                                        @if($job->status === 'urgent')
                                            <span
                                                class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">URGENT</span>
                                        @endif
                                        <span
                                            class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded border border-blue-100 uppercase tracking-wider">
                                            {{ str_replace('-', ' ', $job->employment_type) }}
                                        </span>
                                    </div>
                                    <p class="text-[#3b82f6] text-sm font-medium mb-2">Confidential Company</p>

                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $job->location }}, {{ $job->country }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            {{ $job->salary_currency }} {{ number_format($job->salary_min) }} -
                                            {{ number_format($job->salary_max) }} / {{ $job->salary_period }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $job->experience_required ?? 0 }} Years Exp.
                                        </span>
                                    </div>
                                    <div class="text-gray-600 text-sm line-clamp-2">
                                        {{ $job->description }}
                                    </div>
                                </div>

                                <div class="flex flex-col items-end justify-between self-stretch gap-2">
                                    <span
                                        class="text-xs text-gray-400 whitespace-nowrap">{{ $job->created_at->diffForHumans() }}</span>
                                    @auth
                                        @if(auth()->user()->role === 'candidate')
                                            <a href="{{ route('public.jobs.show', $job) }}"
                                                class="inline-flex items-center px-4 py-2 bg-[#3b82f6] text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all whitespace-nowrap">
                                                Apply Now
                                            </a>
                                        @else
                                            <a href="{{ route('public.jobs.show', $job) }}"
                                                class="inline-flex items-center px-4 py-2 bg-gray-50 text-[#3b82f6] text-sm font-bold rounded-lg border border-[#3b82f6] hover:bg-blue-50 transition-all whitespace-nowrap">
                                                View Details
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-200 transition-all whitespace-nowrap">
                                            Login to Apply
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 text-center rounded-xl border border-gray-200 shadow-sm">
                            <div class="mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No jobs found</h3>
                            <p class="mt-1 text-gray-500">Try adjusting your filters or search keywords.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            </main>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>