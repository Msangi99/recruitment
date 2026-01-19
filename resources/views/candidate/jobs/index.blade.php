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

                <form method="GET" action="{{ route('candidate.jobs.index') }}" class="mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            <!-- Search -->
                            <div class="lg:col-span-3">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search jobs, companies..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Category -->
                            <div>
                                <select name="category_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Country -->
                            <div>
                                <select name="country"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Countries</option>
                                    <option value="Canada" {{ request('country') == 'Canada' ? 'selected' : '' }}>Canada
                                    </option>
                                    <option value="Poland" {{ request('country') == 'Poland' ? 'selected' : '' }}>Poland
                                    </option>
                                    <option value="Germany" {{ request('country') == 'Germany' ? 'selected' : '' }}>Germany
                                    </option>
                                    <option value="Romania" {{ request('country') == 'Romania' ? 'selected' : '' }}>Romania
                                    </option>
                                    <option value="Croatia" {{ request('country') == 'Croatia' ? 'selected' : '' }}>Croatia
                                    </option>
                                    <option value="OMAN" {{ request('country') == 'OMAN' ? 'selected' : '' }}>OMAN</option>
                                    <option value="Australia" {{ request('country') == 'Australia' ? 'selected' : '' }}>
                                        Australia</option>
                                    <option value="QUATAR" {{ request('country') == 'QUATAR' ? 'selected' : '' }}>QUATAR
                                    </option>
                                    <option value="Kuwait" {{ request('country') == 'Kuwait' ? 'selected' : '' }}>Kuwait
                                    </option>
                                    <option value="United Arab Emirates" {{ request('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                    <option value="Saudi Arabia" {{ request('country') == 'Saudi Arabia' ? 'selected' : '' }}>
                                        Saudi Arabia</option>
                                    <option value="Serbia" {{ request('country') == 'Serbia' ? 'selected' : '' }}>Serbia
                                    </option>
                                    <option value="Bulgaria" {{ request('country') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria
                                    </option>
                                    <option value="Ukraine" {{ request('country') == 'Ukraine' ? 'selected' : '' }}>Ukraine
                                    </option>
                                    <option value="Czech republic" {{ request('country') == 'Czech republic' ? 'selected' : '' }}>Czech republic</option>
                                    <option value="Latvia" {{ request('country') == 'Latvia' ? 'selected' : '' }}>Latvia
                                    </option>
                                    <option value="Slovakia" {{ request('country') == 'Slovakia' ? 'selected' : '' }}>Slovakia
                                    </option>
                                    <option value="Lithuania" {{ request('country') == 'Lithuania' ? 'selected' : '' }}>
                                        Lithuania</option>
                                    <option value="Other Countries" {{ request('country') == 'Other Countries' ? 'selected' : '' }}>Other Countries</option>
                                </select>
                            </div>

                            <!-- Job Type -->
                            <div>
                                <select name="employment_type"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Job Types</option>
                                    <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                        Contract</option>
                                    <option value="seasonal" {{ request('employment_type') == 'seasonal' ? 'selected' : '' }}>
                                        Seasonal</option>
                                    <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                </select>
                            </div>

                            <!-- Experience Level -->
                            <div>
                                <select name="experience_level"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Experience Levels</option>
                                    <option value="no-experience" {{ request('experience_level') == 'no-experience' ? 'selected' : '' }}>No experience</option>
                                    <option value="1-2" {{ request('experience_level') == '1-2' ? 'selected' : '' }}>1–2 years
                                    </option>
                                    <option value="3-5" {{ request('experience_level') == '3-5' ? 'selected' : '' }}>3–5 years
                                    </option>
                                    <option value="5+" {{ request('experience_level') == '5+' ? 'selected' : '' }}>5+ years
                                    </option>
                                </select>
                            </div>

                            <!-- Education Level -->
                            <div>
                                <select name="education_level"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Education Levels</option>
                                    <option value="no-formal-education" {{ request('education_level') == 'no-formal-education' ? 'selected' : '' }}>No formal education</option>
                                    <option value="secondary-school" {{ request('education_level') == 'secondary-school' ? 'selected' : '' }}>Secondary School</option>
                                    <option value="certificate" {{ request('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                    <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>
                                        Diploma</option>
                                    <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>
                                        Bachelor's Degree</option>
                                    <option value="master-plus" {{ request('education_level') == 'master-plus' ? 'selected' : '' }}>Master's Degree+</option>
                                </select>
                            </div>

                            <!-- Language Requirement -->
                            <div>
                                <select name="language"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Languages</option>
                                    <option value="no-requirement" {{ request('language') == 'no-requirement' ? 'selected' : '' }}>No language requirement</option>
                                    <option value="Basic English" {{ request('language') == 'Basic English' ? 'selected' : '' }}>Basic English</option>
                                    <option value="Intermediate English" {{ request('language') == 'Intermediate English' ? 'selected' : '' }}>Intermediate English</option>
                                    <option value="Advanced English" {{ request('language') == 'Advanced English' ? 'selected' : '' }}>Advanced English</option>
                                    <option value="Other language required" {{ request('language') == 'Other language required' ? 'selected' : '' }}>Other language required</option>
                                </select>
                            </div>

                            <!-- Salary Period -->
                            <div>
                                <select name="salary_period"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Salary Period</option>
                                    <option value="monthly" {{ request('salary_period') == 'monthly' ? 'selected' : '' }}>
                                        Monthly</option>
                                    <option value="hourly" {{ request('salary_period') == 'hourly' ? 'selected' : '' }}>Hourly
                                    </option>
                                </select>
                            </div>

                            <!-- Min Salary -->
                            <div>
                                <input type="number" name="min_salary" value="{{ request('min_salary') }}"
                                    placeholder="Min Salary" min="0"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Max Salary -->
                            <div>
                                <input type="number" name="max_salary" value="{{ request('max_salary') }}"
                                    placeholder="Max Salary" min="0"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Date Posted -->
                            <div>
                                <select name="date_posted"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Date Posted</option>
                                    <option value="48-hours" {{ request('date_posted') == '48-hours' ? 'selected' : '' }}>Last
                                        48 HR</option>
                                    <option value="7-days" {{ request('date_posted') == '7-days' ? 'selected' : '' }}>Last 7
                                        days</option>
                                    <option value="30-days" {{ request('date_posted') == '30-days' ? 'selected' : '' }}>Last
                                        30 days</option>
                                    <option value="30-plus" {{ request('date_posted') == '30-plus' ? 'selected' : '' }}>More
                                        than 30 days</option>
                                </select>
                            </div>

                            <!-- Hours of work -->
                            <div>
                                <select name="work_hours"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Hours of Work</option>
                                    <option value="full-time" {{ request('work_hours') == 'full-time' ? 'selected' : '' }}>
                                        Full time</option>
                                    <option value="part-time" {{ request('work_hours') == 'part-time' ? 'selected' : '' }}>
                                        Part time</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('candidate.jobs.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Clear
                                Filters</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Apply
                                Filters</button>
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