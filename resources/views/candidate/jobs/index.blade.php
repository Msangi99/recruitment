@extends('layouts.app')

@section('title', 'Browse Jobs - Candidate')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('candidate.partials.nav')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Browse Jobs</h2>
                </div>

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('candidate.jobs.index') }}" id="filterForm" class="mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search jobs, companies, or keywords..."
                                    class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base transition-all duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
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

                            <!-- Salary Frequency -->
                            <select name="salary_period" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Salary Frequency</option>
                                <option value="monthly" {{ request('salary_period') == 'monthly' ? 'selected' : '' }}>
                                    Monthly</option>
                                <option value="hourly" {{ request('salary_period') == 'hourly' ? 'selected' : '' }}>Hourly
                                </option>
                            </select>

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

                            <!-- Salary Range -->
                            <div class="lg:col-span-2">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="salary_min" value="{{ request('salary_min') }}"
                                        placeholder="Min Salary"
                                        class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                    <input type="number" name="salary_max" value="{{ request('salary_max') }}"
                                        placeholder="Max Salary"
                                        class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            @if(request()->anyFilled(['job_category', 'country', 'employment_type', 'working_mode', 'experience_level', 'education_level', 'salary_period', 'industry', 'visa_sponsorship', 'language', 'date_posted', 'salary_min', 'salary_max', 'search']))
                                <a href="{{ route('candidate.jobs.index') }}"
                                    class="text-sm text-blue-600 hover:underline">Clear all filters</a>
                            @else
                                <span></span>
                            @endif
                            <button type="submit"
                                class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">
                                Update Results
                            </button>
                        </div>
                    </div>
                </form>

                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <h3
                                            class="text-lg font-bold text-[#1f2937] leading-tight hover:text-[#3b82f6] transition-colors">
                                            <a href="{{ route('candidate.jobs.show', $job) }}">{{ $job->title }}</a>
                                        </h3>
                                        @if($job->status === 'urgent')
                                            <span
                                                class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">URGENT</span>
                                        @endif
                                        <span
                                            class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded border border-blue-100 uppercase tracking-wider">
                                            {{ str_replace('-', ' ', $job->employment_type) }}
                                        </span>
                                        @if(in_array($job->id, $myApplications))
                                            <span
                                                class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded border border-green-200 uppercase tracking-wider">APPLIED</span>
                                        @endif
                                    </div>
                                    <p class="text-[#3b82f6] text-sm font-medium mb-2">
                                        {{ $job->company_name ?? 'Confidential' }}
                                    </p>

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
                                    <a href="{{ route('candidate.jobs.show', $job) }}"
                                        class="inline-flex items-center px-4 py-2 bg-[#3b82f6] text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all whitespace-nowrap">
                                        @if(in_array($job->id, $myApplications))
                                            View Application
                                        @else
                                            Apply Now
                                        @endif
                                    </a>
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

                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection