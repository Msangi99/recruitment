@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
    <div class="min-h-screen bg-[#F8FAFC]">
        @include('candidate.partials.nav')

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="mb-8">
                <form method="GET" action="{{ route('candidate.jobs.index') }}" class="relative max-w-4xl mx-auto">
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

                    @if(request()->anyFilled(['job_category', 'country', 'employment_type', 'working_mode', 'date_posted', 'experience_level', 'salary_period', 'location_type']))
                        <div class="mt-2 flex items-center gap-2 text-sm">
                            <span class="text-gray-500">Active filters:</span>
                            <a href="{{ route('candidate.jobs.index') }}" class="text-blue-600 hover:underline">Clear all</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-64 space-y-6 flex-shrink-0">
                    <form method="GET" action="{{ route('candidate.jobs.index') }}" id="filterForm" class="space-y-4">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="space-y-3">
                            <!-- Placement Filter -->
                            <select name="location_type" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Placement</option>
                                <option value="Local" {{ request('location_type') == 'Local' ? 'selected' : '' }}>Local</option>
                                <option value="Abroad" {{ request('location_type') == 'Abroad' ? 'selected' : '' }}>Abroad</option>
                            </select>

                            <!-- Job Category Filter -->
                            <select name="job_category" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('job_category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Location (Country) Filter -->
                            <select name="country" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Location</option>
                                @php
                                    $countries = \App\Models\JobListing::whereNotNull('country')->distinct()->pluck('country');
                                @endphp
                                @foreach($countries as $country)
                                    <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Employment Type -->
                            <select name="employment_type" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Employment Type</option>
                                <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>

                            <!-- Working Mode -->
                            <select name="working_mode" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Working Mode</option>
                                <option value="on-site" {{ request('working_mode') == 'on-site' ? 'selected' : '' }}>On-site</option>
                                <option value="remote" {{ request('working_mode') == 'remote' ? 'selected' : '' }}>Remote</option>
                                <option value="hybrid" {{ request('working_mode') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>

                            <!-- Date Posted -->
                            <select name="date_posted" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Date Posted</option>
                                <option value="3-days" {{ request('date_posted') == '3-days' ? 'selected' : '' }}>Last 3 days</option>
                                <option value="7-days" {{ request('date_posted') == '7-days' ? 'selected' : '' }}>Last 7 days</option>
                                <option value="30-days" {{ request('date_posted') == '30-days' ? 'selected' : '' }}>Last 30 days</option>
                            </select>

                            <button type="submit"
                                class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">
                                Update Results
                            </button>
                        </div>
                    </form>

                    <!-- Promo/Help Widget -->
                    <div class="bg-slate-900 rounded-2xl p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-16 h-16 bg-blue-600/20 rounded-full blur-2xl"></div>
                        <h4 class="text-base font-bold mb-2 relative z-10">Need Help?</h4>
                        <p class="text-slate-400 text-xs font-medium mb-4 relative z-10">Complete your profile to increase your chances of being noticed by recruiters.</p>
                        <a href="{{ route('candidate.profile.show') }}"
                            class="inline-flex items-center text-blue-400 font-bold text-xs group">
                            Update Profile
                            <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </aside>

                <!-- Jobs Results -->
                <main class="flex-1">
                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $jobs->total() }} Jobs Found
                        </h2>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">Sort by:</span>
                            <select class="text-sm border-none bg-transparent font-medium text-gray-900 focus:ring-0 cursor-pointer">
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
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative hover:shadow-md transition-all duration-300 hover:border-blue-100 group">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                                <a href="{{ route('candidate.jobs.show', $job) }}">{{ $job->title }}</a>
                                            </h3>
                                            @if($job->status === 'urgent')
                                                <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-100 uppercase tracking-wider">URGENT</span>
                                            @endif
                                            @if(in_array($job->id, $myApplications))
                                                <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-green-100 uppercase tracking-wider">Applied</span>
                                            @else
                                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-blue-100 uppercase tracking-wider">
                                                    {{ str_replace('-', ' ', $job->employment_type) }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-blue-500 text-sm font-bold mb-3 uppercase tracking-tight">
                                            {{ $job->company_name }}
                                        </p>

                                        @if($job->application_deadline)
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-red-100 mb-4 animate-pulse">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                            </div>
                                        @endif

                                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500 mb-4">
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $job->location }}, {{ $job->country }}
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-semibold text-gray-700">{{ $job->salary_currency }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}</span>
                                                <span class="text-xs text-gray-400">/ {{ $job->salary_period }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $job->experience_years ?? $job->experience_required ?? 0 }} Years Exp.
                                            </span>
                                        </div>
                                        <div class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
                                            {{ Str::limit(strip_tags($job->description), 200) }}
                                        </div>

                                        @if(!empty($job->required_skills))
                                            <div class="flex flex-wrap gap-1.5 mt-3">
                                                @foreach(array_slice($job->required_skills, 0, 4) as $skill)
                                                    <span class="px-2.5 py-1 bg-slate-50 text-slate-600 rounded-lg text-[10px] font-bold border border-slate-200/50">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                                @if(count($job->required_skills) > 4)
                                                    <span class="text-[10px] text-slate-400 font-bold flex items-center ml-1">
                                                        +{{ count($job->required_skills) - 4 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex flex-col items-end justify-between self-stretch gap-4 min-w-[140px]">
                                        <span class="text-xs text-gray-400 whitespace-nowrap font-medium">{{ $job->created_at->diffForHumans() }}</span>

                                        <a href="{{ route('candidate.jobs.show', $job) }}"
                                            class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-12 text-center rounded-xl border border-gray-200 shadow-sm">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                lucide.createIcons();
            });
        </script>
    @endpush
@endsection