<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs - Coyzon Recruitment</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('partials.public-nav')

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Information Banner -->
        <div class="mb-6 max-w-5xl mx-auto">
            <div
                class="bg-slate-900 rounded-2xl p-5 md:p-6 shadow-xl border border-slate-800 relative overflow-hidden group">
                <!-- Decorative Elements -->
                <div
                    class="absolute top-0 right-0 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 group-hover:bg-blue-500/20 transition-all duration-700">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-48 h-48 bg-purple-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 group-hover:bg-purple-500/20 transition-all duration-700">
                </div>

                <div class="relative z-10 flex items-center gap-5">
                    <!-- Icon -->
                    <div class="flex-shrink-0 hidden md:block">
                        <div
                            class="w-12 h-12 bg-white/5 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/10 shadow-inner group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-white mb-2 tracking-tight leading-tight">
                                    Verified Overseas Job Opportunities
                                </h2>
                                <p class="text-sm text-white leading-relaxed font-light max-w-3xl">
                                    Explore available overseas job opportunities and apply through our <span
                                        class="font-medium">licensed recruitment agency</span>.
                                    All jobs listed on this platform are <span class="font-medium">verified,
                                        ethical, and processed through our agency</span> to ensure safety, transparency,
                                    and compliance.
                                </p>
                            </div>

                            <!-- Trust Badges -->
                            <div class="flex flex-wrap gap-2 items-center flex-shrink-0">
                                <div
                                    class="flex items-center gap-1.5 bg-slate-800/50 backdrop-blur-sm px-3 py-1.5 rounded-full border border-slate-700/50 hover:bg-slate-800 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-slate-200">Verified</span>
                                </div>
                                <div
                                    class="flex items-center gap-1.5 bg-slate-800/50 backdrop-blur-sm px-3 py-1.5 rounded-full border border-slate-700/50 hover:bg-slate-800 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                        </path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-slate-200">Licensed</span>
                                </div>
                                <div
                                    class="flex items-center gap-1.5 bg-slate-800/50 backdrop-blur-sm px-3 py-1.5 rounded-full border border-slate-700/50 hover:bg-slate-800 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-slate-200">Ethical</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Header -->
        <div class="mb-8">
            <form method="GET" action="{{ route('public.jobs.index') }}" class="relative max-w-4xl mx-auto">
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
                        <!-- Job Category Filter -->
                        <select name="job_category" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Category</option>
                            <option value="Agriculture" {{ request('job_category') == 'Agriculture' ? 'selected' : '' }}>
                                Agriculture</option>
                            <option value="Hospitality" {{ request('job_category') == 'Hospitality' ? 'selected' : '' }}>
                                Hospitality</option>
                            <option value="Healthcare" {{ request('job_category') == 'Healthcare' ? 'selected' : '' }}>
                                Healthcare</option>
                            <option value="Logistics & Transport" {{ request('job_category') == 'Logistics & Transport' ? 'selected' : '' }}>Logistics & Transport</option>
                            <option value="Construction" {{ request('job_category') == 'Construction' ? 'selected' : '' }}>Construction</option>
                        </select>

                        <!-- Location (Country) Filter -->
                        <select name="country" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Location</option>
                            <option value="Canada" {{ request('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Poland" {{ request('country') == 'Poland' ? 'selected' : '' }}>Poland</option>
                            <option value="Germany" {{ request('country') == 'Germany' ? 'selected' : '' }}>Germany
                            </option>
                            <option value="Romania" {{ request('country') == 'Romania' ? 'selected' : '' }}>Romania
                            </option>
                            <option value="Croatia" {{ request('country') == 'Croatia' ? 'selected' : '' }}>Croatia
                            </option>
                            <option value="Spain" {{ request('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                            <option value="Italy" {{ request('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                            <option value="France" {{ request('country') == 'France' ? 'selected' : '' }}>France</option>
                            <option value="United Kingdom" {{ request('country') == 'United Kingdom' ? 'selected' : '' }}>
                                United Kingdom</option>
                            <option value="Netherlands" {{ request('country') == 'Netherlands' ? 'selected' : '' }}>
                                Netherlands</option>
                            <option value="Belgium" {{ request('country') == 'Belgium' ? 'selected' : '' }}>Belgium
                            </option>
                            <option value="Switzerland" {{ request('country') == 'Switzerland' ? 'selected' : '' }}>
                                Switzerland</option>
                            <option value="Austria" {{ request('country') == 'Austria' ? 'selected' : '' }}>Austria
                            </option>
                            <option value="Oman" {{ request('country') == 'Oman' ? 'selected' : '' }}>Oman</option>
                            <option value="Australia" {{ request('country') == 'Australia' ? 'selected' : '' }}>Australia
                            </option>
                            <option value="Qatar" {{ request('country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                            <option value="Kuwait" {{ request('country') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                            <option value="United Arab Emirates" {{ request('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                            <option value="Saudi Arabia" {{ request('country') == 'Saudi Arabia' ? 'selected' : '' }}>
                                Saudi Arabia</option>
                            <option value="Bahrain" {{ request('country') == 'Bahrain' ? 'selected' : '' }}>Bahrain
                            </option>
                            <option value="Jordan" {{ request('country') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                            <option value="Lebanon" {{ request('country') == 'Lebanon' ? 'selected' : '' }}>Lebanon
                            </option>
                            <option value="Egypt" {{ request('country') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                            <option value="South Africa" {{ request('country') == 'South Africa' ? 'selected' : '' }}>
                                South Africa</option>
                            <option value="Kenya" {{ request('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                            <option value="Tanzania" {{ request('country') == 'Tanzania' ? 'selected' : '' }}>Tanzania
                            </option>
                            <option value="Uganda" {{ request('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                            <option value="Rwanda" {{ request('country') == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                            <option value="United States" {{ request('country') == 'United States' ? 'selected' : '' }}>
                                United States</option>
                            <option value="Singapore" {{ request('country') == 'Singapore' ? 'selected' : '' }}>Singapore
                            </option>
                            <option value="Malaysia" {{ request('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia
                            </option>
                            <option value="Japan" {{ request('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                            <option value="South Korea" {{ request('country') == 'South Korea' ? 'selected' : '' }}>South
                                Korea</option>
                            <option value="China" {{ request('country') == 'China' ? 'selected' : '' }}>China</option>
                            <option value="India" {{ request('country') == 'India' ? 'selected' : '' }}>India</option>
                        </select>

                        <!-- Employment Type -->
                        <select name="employment_type" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Employment Type</option>
                            <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>
                                Full-time</option>
                            <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>
                                Part-time</option>
                            <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                Contract</option>
                            <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>
                                Temporary</option>
                            <option value="seasonal" {{ request('employment_type') == 'seasonal' ? 'selected' : '' }}>
                                Seasonal</option>
                        </select>

                        <!-- Working Mode -->
                        <select name="working_mode" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Working Mode</option>
                            <option value="on-site" {{ request('working_mode') == 'on-site' ? 'selected' : '' }}>On-site
                            </option>
                            <option value="remote" {{ request('working_mode') == 'remote' ? 'selected' : '' }}>Remote
                            </option>
                            <option value="hybrid" {{ request('working_mode') == 'hybrid' ? 'selected' : '' }}>Hybrid
                            </option>
                        </select>

                        <!-- Date Posted -->
                        <select name="date_posted" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Date Posted</option>
                            <option value="3-days" {{ request('date_posted') == '3-days' ? 'selected' : '' }}>Last 3 days
                            </option>
                            <option value="7-days" {{ request('date_posted') == '7-days' ? 'selected' : '' }}>Last 7 days
                            </option>
                            <option value="30-days" {{ request('date_posted') == '30-days' ? 'selected' : '' }}>Last 30
                                days</option>
                        </select>

                        <!-- Experience Level -->
                        <select name="experience_level" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Experience Level</option>
                            <option value="no-experience" {{ request('experience_level') == 'no-experience' ? 'selected' : '' }}>No Experience</option>
                            <option value="mid-level" {{ request('experience_level') == 'mid-level' ? 'selected' : '' }}>
                                Mid-level</option>
                            <option value="senior" {{ request('experience_level') == 'senior' ? 'selected' : '' }}>Senior
                            </option>
                        </select>

                        <!-- Salary Range -->
                        <div class="space-y-2">
                            <select name="salary_period" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Salary Frequency</option>
                                <option value="monthly" {{ request('salary_period') == 'monthly' ? 'selected' : '' }}>
                                    Monthly</option>
                                <option value="hourly" {{ request('salary_period') == 'hourly' ? 'selected' : '' }}>Hourly
                                </option>
                            </select>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="salary_min" value="{{ request('salary_min') }}"
                                    placeholder="Min Salary"
                                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <input type="number" name="salary_max" value="{{ request('salary_max') }}"
                                    placeholder="Max Salary"
                                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            </div>
                        </div>

                        <!-- Education Level -->
                        <select name="education_level" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Education Level</option>
                            <option value="no-education" {{ request('education_level') == 'no-education' ? 'selected' : '' }}>No Education</option>
                            <option value="certificate" {{ request('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                            <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>
                                Diploma</option>
                            <option value="degree" {{ request('education_level') == 'degree' ? 'selected' : '' }}>Degree
                            </option>
                        </select>

                        <!-- Industry -->
                        <select name="industry" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Industry</option>
                            <option value="Construction" {{ request('industry') == 'Construction' ? 'selected' : '' }}>
                                Construction</option>
                            <option value="Healthcare" {{ request('industry') == 'Healthcare' ? 'selected' : '' }}>
                                Healthcare</option>
                            <option value="Manufacturing" {{ request('industry') == 'Manufacturing' ? 'selected' : '' }}>
                                Manufacturing</option>
                            <option value="Agriculture" {{ request('industry') == 'Agriculture' ? 'selected' : '' }}>
                                Agriculture</option>
                            <option value="Transport & Logistics" {{ request('industry') == 'Transport & Logistics' ? 'selected' : '' }}>Transport & Logistics</option>
                            <option value="Hospitality" {{ request('industry') == 'Hospitality' ? 'selected' : '' }}>
                                Hospitality</option>
                        </select>

                        <!-- Visa Sponsorship -->
                        <select name="visa_sponsorship" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Visa Sponsorship</option>
                            <option value="yes" {{ request('visa_sponsorship') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ request('visa_sponsorship') == 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        <!-- Language -->
                        <select name="language" onchange="this.form.submit()"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="">Language</option>
                            <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English
                            </option>
                            <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                            <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                            <option value="Swahili" {{ request('language') == 'Swahili' ? 'selected' : '' }}>Swahili
                            </option>
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
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative hover:shadow-md transition-all duration-300 hover:border-blue-100 group">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <h3
                                            class="text-xl font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                            <a href="{{ route('public.jobs.show', $job) }}">{{ $job->title }}</a>
                                        </h3>
                                        @if($job->status === 'urgent')
                                            <span
                                                class="bg-red-50 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-100 uppercase tracking-wider">URGENT</span>
                                        @endif
                                        <span
                                            class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-blue-100 uppercase tracking-wider">
                                            {{ str_replace('-', ' ', $job->employment_type) }}
                                        </span>
                                    </div>
                                    <p class="text-blue-500 text-sm font-medium mb-3">Confidential Company</p>

                                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500 mb-4">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $job->location }}, {{ $job->country }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span class="font-semibold text-gray-700">{{ $job->salary_currency }}
                                                {{ number_format($job->salary_min) }} -
                                                {{ number_format($job->salary_max) }}</span> <span
                                                class="text-xs text-gray-400">/ {{ $job->salary_period }}</span>
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $job->experience_required ?? 0 }} Years Exp.
                                        </span>
                                    </div>
                                    <div class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
                                        {{ Str::limit(strip_tags($job->description), 200) }}
                                    </div>
                                </div>

                                <div class="flex flex-col items-end justify-between self-stretch gap-4 min-w-[140px]">
                                    <span
                                        class="text-xs text-gray-400 whitespace-nowrap font-medium">{{ $job->created_at->diffForHumans() }}</span>

                                    @auth
                                        @if(auth()->user()->role === 'candidate')
                                            <a href="{{ route('public.jobs.show', $job) }}"
                                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                                                View Details
                                            </a>
                                        @else
                                            <a href="{{ route('public.jobs.show', $job) }}"
                                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-white text-blue-600 border border-blue-100 text-sm font-bold rounded-xl hover:bg-blue-50 transition-all whitespace-nowrap">
                                                View Details
                                            </a>
                                        @endif
                                    @else
                                        <div class="flex flex-col gap-2 w-full">
                                            <a href="{{ route('public.jobs.show', $job) }}"
                                                class="inline-flex justify-center items-center px-4 py-2 bg-white text-gray-700 border border-gray-200 text-sm font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all whitespace-nowrap">
                                                View Details
                                            </a>
                                            <a href="{{ route('login') }}"
                                                class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                                                Apply Now
                                            </a>
                                        </div>
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