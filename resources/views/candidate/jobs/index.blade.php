@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
    <div class="min-h-screen bg-[#F8FAFC]">
        @include('candidate.partials.nav')

        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Browse Opportunities</h1>
                    <p class="text-slate-500 font-medium mt-1">Explore and apply to verified jobs matching your profile.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Sorted by:</span>
                    <button
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 shadow-sm">
                        Latest Posted
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </button>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Left: Sidebar Filters -->
                <aside class="w-full lg:w-72 space-y-8 shrink-0">
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
                        <form action="{{ route('candidate.jobs.index') }}" method="GET" class="space-y-8">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Search
                                    Keywords</label>
                                <div class="relative">
                                    <i data-lucide="search" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Title or skill..."
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border-transparent rounded-xl text-sm font-medium focus:ring-brand-600 focus:bg-white transition-all">
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Placement</label>
                                <div class="space-y-3">
                                    @foreach(['Local', 'Abroad'] as $placement)
                                        <label class="flex items-center cursor-pointer group">
                                            <input type="checkbox" name="location_type[]" value="{{ $placement }}" {{ in_array($placement, (array) request('location_type')) ? 'checked' : '' }}
                                                class="w-5 h-5 rounded border-slate-200 text-brand-600 focus:ring-brand-50">
                                            <span
                                                class="ml-3 text-sm font-bold text-slate-600 group-hover:text-brand-600 transition-colors">{{ $placement }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Job
                                    Category</label>
                                <select name="job_category" onchange="this.form.submit()"
                                    class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-brand-600 transition-all">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}" {{ request('job_category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Location
                                    (Country)</label>
                                <select name="country" onchange="this.form.submit()"
                                    class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-brand-600 transition-all">
                                    <option value="">All Countries</option>
                                    @php
                                        $countries = \App\Models\JobListing::whereNotNull('country')->distinct()->pluck('country');
                                    @endphp
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                            {{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Contract
                                    Type</label>
                                <select name="employment_type" onchange="this.form.submit()"
                                    class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-brand-600 transition-all">
                                    <option value="">All Types</option>
                                    <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                        Contract</option>
                                    <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Working
                                    Mode</label>
                                <select name="working_mode" onchange="this.form.submit()"
                                    class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-brand-600 transition-all">
                                    <option value="">All Modes</option>
                                    <option value="on-site" {{ request('working_mode') == 'on-site' ? 'selected' : '' }}>
                                        On-site</option>
                                    <option value="remote" {{ request('working_mode') == 'remote' ? 'selected' : '' }}>Remote
                                    </option>
                                    <option value="hybrid" {{ request('working_mode') == 'hybrid' ? 'selected' : '' }}>Hybrid
                                    </option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-brand-600 text-white font-black rounded-2xl text-xs uppercase tracking-widest shadow-lg shadow-brand-100 hover:bg-brand-700 transition-all">
                                Apply Filters
                            </button>

                            @if(request()->anyFilled(['search', 'location_type', 'employment_type']))
                                <a href="{{ route('candidate.jobs.index') }}"
                                    class="block text-center text-xs font-bold text-slate-400 hover:text-brand-600 transition-colors">Clear
                                    All Filters</a>
                            @endif
                        </form>
                    </div>

                    <!-- Promo/Help Widget -->
                    <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-brand-600/20 rounded-full blur-2xl">
                        </div>
                        <h4 class="text-lg font-bold mb-4 relative z-10">Need Help?</h4>
                        <p class="text-slate-400 text-sm font-medium mb-6 relative z-10">Complete your profile to increase
                            your chances of being noticed by recruiters.</p>
                        <a href="{{ route('candidate.profile.create') }}"
                            class="inline-flex items-center text-brand-400 font-bold text-sm group">
                            Update Profile
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </aside>

                <!-- Right: Job Listings -->
                <main class="flex-1">
                    @if(session('success'))
                        <div
                            class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 mb-8">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                            <span class="text-sm font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6">
                        @forelse($jobs as $job)
                            <div
                                class="bg-white rounded-[2rem] border border-slate-100 p-8 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 group relative">
                                <!-- Applied Badge -->
                                @if(in_array($job->id, $myApplications))
                                    <div class="absolute top-8 right-8">
                                        <span
                                            class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider border border-emerald-100 flex items-center gap-2">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                            Applied
                                        </span>
                                    </div>
                                @else
                                    <div class="absolute top-8 right-8">
                                        <span
                                            class="px-4 py-1.5 rounded-full bg-brand-50 text-brand-600 text-[10px] font-black uppercase tracking-wider border border-brand-100">
                                            {{ $job->job_location_type ?? 'Local' }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex flex-col md:flex-row gap-8">
                                    <!-- Company Logo Placeholder -->
                                    <div
                                        class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center font-extrabold text-2xl shrink-0 group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors border border-slate-100">
                                        {{ substr($job->company_name, 0, 1) }}
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1 space-y-4">
                                        <div>
                                            <h3
                                                class="text-xl md:text-2xl font-extrabold text-slate-900 group-hover:text-brand-600 transition-colors mb-1">
                                                <a href="{{ route('candidate.jobs.show', $job) }}">{{ $job->title }}</a>
                                            </h3>
                                            <div class="flex items-center gap-3">
                                                <p class="text-brand-600 font-bold text-sm">{{ $job->company_name }}</p>
                                                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                                                    {{ $job->employment_type }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-y-2 gap-x-6">
                                            <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-300"></i>
                                                <span>{{ $job->location }}, {{ $job->country }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                                                <i data-lucide="banknote" class="w-4 h-4 text-slate-300"></i>
                                                <span>{{ $job->salary_currency }} {{ number_format($job->salary_min) }} -
                                                    {{ number_format($job->salary_max) }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                                                <i data-lucide="briefcase" class="w-4 h-4 text-slate-300"></i>
                                                <span>{{ $job->experience_years ? $job->experience_years . 'y exp' : 'No exp' }}</span>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap gap-2 pt-2">
                                            @foreach(array_slice($job->required_skills ?? [], 0, 3) as $skill)
                                                <span
                                                    class="px-3 py-1 bg-slate-50 rounded-lg text-xs font-bold text-slate-500 border border-slate-100 group-hover:bg-brand-50/30 transition-colors">#{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Action -->
                                    <div class="flex flex-col justify-end min-w-[160px]">
                                        <a href="{{ route('candidate.jobs.show', $job) }}"
                                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-slate-900 text-white font-black rounded-2xl text-xs uppercase tracking-[2px] hover:bg-brand-600 transition-all hover:-translate-y-1 shadow-lg shadow-slate-100">
                                            View & Apply
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-[2rem] p-16 text-center border border-slate-100">
                                <div
                                    class="w-20 h-20 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="inbox" class="w-10 h-10"></i>
                                </div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-2">No jobs found</h3>
                                <p class="text-slate-500 font-medium mb-8">Try adjusting your search or filters to find more
                                    opportunities.</p>
                                <a href="{{ route('candidate.jobs.index') }}"
                                    class="px-8 py-3 bg-brand-600 text-white font-bold rounded-xl text-sm transition-all hover:bg-brand-700">Explore
                                    all jobs</a>
                            </div>
                        @endforelse

                        <div class="mt-10">
                            {{ $jobs->links() }}
                        </div>
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