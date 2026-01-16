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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search jobs, companies..."
                                    class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category (Job Category)</label>
                                <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Country -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location (Country)</label>
                                <select name="country" class="w-full rounded-md border-gray-300 shadow-sm">
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                                <select name="employment_type" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Types</option>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                                <select name="experience_level" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Any Experience</option>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Education Level</label>
                                <select name="education_level" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Any Education</option>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Language Requirement</label>
                                <select name="language" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Any Language</option>
                                    <option value="no-requirement" {{ request('language') == 'no-requirement' ? 'selected' : '' }}>No language requirement</option>
                                    <option value="Basic English" {{ request('language') == 'Basic English' ? 'selected' : '' }}>Basic English</option>
                                    <option value="Intermediate English" {{ request('language') == 'Intermediate English' ? 'selected' : '' }}>Intermediate English</option>
                                    <option value="Advanced English" {{ request('language') == 'Advanced English' ? 'selected' : '' }}>Advanced English</option>
                                    <option value="Other language required" {{ request('language') == 'Other language required' ? 'selected' : '' }}>Other language required</option>
                                </select>
                            </div>

                            <!-- Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                                <select name="salary_period" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Any Salary</option>
                                    <option value="monthly" {{ request('salary_period') == 'monthly' ? 'selected' : '' }}>
                                        Monthly</option>
                                    <option value="hourly" {{ request('salary_period') == 'hourly' ? 'selected' : '' }}>Hourly
                                    </option>
                                </select>
                            </div>

                            <!-- Min Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary</label>
                                <input type="number" name="min_salary" value="{{ request('min_salary') }}" placeholder="0"
                                    min="0" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Max Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary</label>
                                <input type="number" name="max_salary" value="{{ request('max_salary') }}"
                                    placeholder="No limit" min="0" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Date Posted -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Posted</label>
                                <select name="date_posted" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Anytime</option>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hours of Work</label>
                                <select name="work_hours" class="w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Any Hours</option>
                                    <option value="full-time" {{ request('work_hours') == 'full-time' ? 'selected' : '' }}>
                                        Full time</option>
                                    <option value="part-time" {{ request('work_hours') == 'part-time' ? 'selected' : '' }}>
                                        Part time</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('candidate.jobs.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Clear
                                Filters</a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Apply Filters</button>
                        </div>
                    </div>
                </form>

                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 p-7 relative hover:shadow-md transition-shadow">
                            <div class="absolute top-7 right-7 flex items-center gap-2">
                                @if(in_array($job->id, $myApplications))
                                    <span
                                        class="bg-green-100 text-green-700 text-[10px] font-bold px-3 py-1 rounded border border-green-200 uppercase tracking-wider">APPLIED</span>
                                @endif
                                <span
                                    class="bg-white text-[#3b82f6] text-[10px] font-bold px-3 py-1 rounded border border-[#3b82f6] uppercase tracking-wider">
                                    {{ str_replace('-', ' ', $job->employment_type) }}
                                </span>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-[#1f2937] mb-1.5 line-clamp-1">
                                    <a href="{{ route('candidate.jobs.show', $job) }}"
                                        class="hover:text-[#3b82f6] transition-colors">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <p class="text-[#3b82f6] text-lg font-medium">{{ $job->company_name ?? 'Confidential' }}</p>
                            </div>

                            <div class="mb-6">
                                <p class="text-2xl font-bold text-[#1f2937]">
                                    {{ $job->salary_currency }} {{ number_format($job->salary_min) }} -
                                    {{ number_format($job->salary_max) }} <span
                                        class="text-lg font-normal text-gray-500 lowercase">per {{ $job->salary_period }}</span>
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg flex flex-col justify-center">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 leading-none">EMPLOYMENT
                                        TYPE</span>
                                    <span
                                        class="text-[15px] font-bold text-[#1f2937]">{{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</span>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg flex flex-col justify-center">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 leading-none">MINIMUM
                                        WORK EXPERIENCE</span>
                                    <span class="text-[15px] font-bold text-[#1f2937]">{{ $job->experience_required ?? 0 }}
                                        Years</span>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg flex flex-col justify-center">
                                    <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 leading-none">MINIMUM
                                        EDUCATION LEVEL</span>
                                    <span
                                        class="text-[15px] font-bold text-[#1f2937]">{{ $job->education_level ? ucfirst(str_replace('-', ' ', $job->education_level)) : 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                                <div class="flex items-center gap-5 text-[15px] text-gray-400">
                                    <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-gray-900 font-medium">{{ $job->location }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('candidate.jobs.show', $job) }}"
                                    class="inline-flex items-center px-8 py-2.5 bg-[#3b82f6] text-white font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all hover:shadow-md">
                                    @if(in_array($job->id, $myApplications))
                                        View Application
                                    @else
                                        View Details
                                    @endif
                                </a>
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