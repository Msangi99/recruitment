@extends('layouts.app')

@section('title', 'Job Details')

@section('content')
<div class="min-h-screen bg-[#F8FAFC]">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('candidate.dashboard') }}" class="text-slate-500 hover:text-brand-600 text-xs font-bold uppercase tracking-widest">Dashboard</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        <a href="{{ route('candidate.jobs.index') }}" class="ml-1 text-slate-500 hover:text-brand-600 text-xs font-bold uppercase tracking-widest md:ml-2">Jobs</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        <span class="ml-1 text-slate-900 text-xs font-black uppercase tracking-widest md:ml-2">{{ $job->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Job Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Card -->
                <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-brand-50 opacity-50 rounded-bl-full -mr-12 -mt-12"></div>
                    
                    <div class="relative z-10">
                        <div class="flex flex-wrap gap-3 mb-4">
                            <span class="px-4 py-1 rounded-full bg-brand-50 text-brand-600 text-[10px] font-black uppercase tracking-wider border border-brand-100">
                                {{ $job->category->name ?? 'General' }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3 tracking-tight">{{ $job->title }}</h1>
                        <div class="flex flex-wrap items-center gap-y-3 gap-x-6 text-slate-500 text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <i data-lucide="building-2" class="w-4 h-4 text-slate-300"></i>
                                <span class="text-slate-900 font-bold">{{ $job->company_name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-300"></i>
                                <span>{{ $job->location }}, {{ $job->country }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-6 border-t border-slate-50">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Salary</p>
                                <p class="text-sm font-bold text-slate-900">{{ $job->salary_currency }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Type</p>
                                <p class="text-sm font-bold text-slate-900 capitalize">{{ $job->employment_type }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Experience</p>
                                <p class="text-sm font-bold text-slate-900">{{ $job->experience_years ? $job->experience_years . 'y+' : 'Entry' }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Location</p>
                                <p class="text-sm font-bold text-slate-900">{{ $job->job_location_type }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Requirements -->
                <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-100 shadow-sm space-y-8">
                     <section>
                        <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                            <i data-lucide="file-text" class="w-5 h-5 text-brand-600"></i>
                            About the role
                        </h2>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium text-sm">
                            {!! $job->description !!}
                        </div>
                    </section>

                    <section class="pt-6 border-t border-slate-50">
                        <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                            <i data-lucide="list-checks" class="w-5 h-5 text-brand-600"></i>
                            Requirements
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                @if($job->education_level)
                                <div>
                                    <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Education</h4>
                                    <p class="text-sm font-bold text-slate-900">{{ $job->education_level }}</p>
                                </div>
                                @endif

                                @if($job->languages)
                                <div>
                                    <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Languages</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($job->languages as $lang)
                                            <span class="px-2.5 py-1 bg-slate-50 text-slate-900 text-[10px] font-bold rounded-lg border border-slate-100">
                                                {{ $lang['name'] ?? $lang }} ({{ $lang['proficiency'] ?? 'Fluent' }})
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                @if($job->required_skills)
                                <div>
                                    <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Key Skills</h4>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($job->required_skills as $skill)
                                            <span class="px-2 py-0.5 bg-slate-50 text-slate-500 text-[10px] font-bold rounded-md border border-slate-100">#{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="space-y-3">
                                @foreach([
                                    ['relocate', 'Relocation', 'willing_to_relocate'],
                                    ['passport', 'Passport', 'required_passport'],
                                    ['medical', 'Medical', 'medical_clearance'],
                                    ['police', 'Police', 'police_clearance']
                                ] as $check)
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">{{ $check[1] }}</span>
                                    @if($job->{$check[2]})
                                        <span class="text-[9px] font-black text-emerald-600 uppercase bg-emerald-100/50 px-2 py-0.5 rounded-lg border border-emerald-200">Required</span>
                                    @else
                                        <span class="text-[9px] font-black text-slate-400 uppercase">Not Required</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    @if($job->benefits)
                    <section class="pt-6 border-t border-slate-50">
                        <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                            <i data-lucide="gift" class="w-5 h-5 text-brand-600"></i>
                            Key Benefits
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
                            @foreach($job->benefits as $benefit)
                                <div class="flex items-center gap-2 p-2.5 bg-brand-50/50 rounded-xl border border-brand-100/50">
                                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-brand-600"></i>
                                    <span class="text-[11px] font-bold text-slate-700 leading-none">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if($job->other_benefits)
                        <div class="mt-5 p-4 bg-slate-50/50 rounded-2xl border border-slate-100 prose prose-slate prose-sm max-w-none text-slate-600 font-medium">
                            <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Additional Perks</h4>
                            {!! $job->other_benefits !!}
                        </div>
                        @endif
                    </section>
                    @endif
                </div>
            </div>

            <!-- Right: Application Card -->
            <div class="space-y-6">
                <!-- Apply Form -->
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-xl shadow-slate-200/50 sticky top-24">
                    @if($hasApplied)
                        <div class="text-center py-4">
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="check-check" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">Applied!</h3>
                            <p class="text-slate-500 text-xs font-medium mb-6">Your application is under review.</p>
                            <a href="{{ route('candidate.applications.index') }}" class="inline-flex items-center text-brand-600 font-black text-[10px] uppercase tracking-widest hover:underline">
                                View status
                                <i data-lucide="arrow-right" class="w-3 h-3 ml-2"></i>
                            </a>
                        </div>
                    @else
                        @if(auth()->user()->candidateProfile && auth()->user()->candidateProfile->verification_status === 'approved')
                            <h3 class="text-xl font-black text-slate-900 mb-4">Apply Now</h3>
                            <form action="{{ route('candidate.jobs.apply', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[2px] mb-2">Short Bio</label>
                                    <textarea name="cover_letter" rows="3" class="w-full border-slate-100 bg-slate-50 rounded-xl px-4 py-2.5 focus:ring-brand-600 focus:border-brand-600 text-sm font-medium" placeholder="Describe your fit..."></textarea>
                                </div>

                                @if($job->requires_video)
                                <div class="p-4 bg-brand-50 rounded-xl border border-brand-100">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i data-lucide="video" class="w-4 h-4 text-brand-600"></i>
                                        <span class="text-[9px] font-black text-brand-900 uppercase tracking-widest">Video CV required</span>
                                    </div>
                                    <input type="file" name="application_video" required accept="video/*" class="w-full text-[10px] text-slate-500 file:mr-3 file:py-1 file:px-2.5 file:rounded-full file:border-0 file:text-[9px] file:font-black file:bg-brand-600 file:text-white">
                                </div>
                                @endif

                                <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-black rounded-2xl shadow-lg transition-all text-xs uppercase tracking-widest">
                                    Submit Application
                                </button>
                            </form>
                        @else
                            <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100 text-center">
                                <i data-lucide="alert-octagon" class="w-8 h-8 text-amber-500 mx-auto mb-3"></i>
                                <h4 class="font-bold text-amber-900 mb-1 text-sm">Action Required</h4>
                                <p class="text-amber-700 text-[11px] font-medium mb-4 leading-tight">Your profile must be approved by coyzon to apply.</p>
                                <a href="{{ route('candidate.profile.create') }}" class="inline-flex items-center px-5 py-2.5 bg-amber-600 text-white font-black rounded-xl text-[10px] uppercase tracking-widest">
                                    Complete Profile
                                </a>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Job Quick Info -->
                <div class="bg-slate-900 rounded-[2rem] p-6 text-white shadow-xl">
                    <h4 class="font-bold mb-4 text-white/40 uppercase text-[9px] tracking-[3px]">Quick Details</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center">
                                <i data-lucide="calendar" class="w-4 h-4 text-brand-400"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-medium text-white/40 uppercase tracking-widest">Post Date</p>
                                <p class="text-xs font-bold">{{ $job->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center">
                                <i data-lucide="clock-3" class="w-4 h-4 text-brand-400"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-medium text-white/40 uppercase tracking-widest">Contract</p>
                                <p class="text-xs font-bold">{{ $job->contract_duration ?? 'Full-time' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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