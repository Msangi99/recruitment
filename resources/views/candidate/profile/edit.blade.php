@extends('layouts.app')

@section('title', 'Manage Profile - Candidate')

@include('candidate.partials.nav')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <div class="mb-10 flex items-center justify-between">
                    <div>
                        <a href="{{ route('candidate.profile.show') }}"
                            class="text-sm font-medium text-slate-500 hover:text-emerald-600 flex items-center transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                            Back to Profile
                        </a>
                        <h2 class="mt-2 text-3xl font-bold text-slate-900">Manage Your Profile</h2>
                    </div>
                    @if($profile->verification_status === 'approved')
                        <div
                            class="flex items-center px-4 py-2 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm font-medium">
                            <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-amber-500"></i>
                            Editing will reset your verification status
                        </div>
                    @endif
                </div>

                <div class="space-y-8">
                    <!-- Step 1 & 2: Account & Basic Info -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">1-2</span>
                                Basic Information
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 2]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nationality
                                    </dt>
                                    <dd class="mt-1 text-sm text-slate-900">{{ $profile->citizenship ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date of Birth
                                    </dt>
                                    <dd class="mt-1 text-sm text-slate-900">
                                        {{ $profile->date_of_birth ? $profile->date_of_birth->format('M d, Y') : '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Current
                                        Location</dt>
                                    <dd class="mt-1 text-sm text-slate-900">{{ $profile->location }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Step 3: Job Preferences -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">3</span>
                                Job Preferences
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 3]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Job Categories
                                    </dt>
                                    <dd class="mt-1 flex flex-wrap gap-2">
                                        @forelse($profile->categories as $category)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                                {{ $category->name }}
                                            </span>
                                        @empty
                                            <span class="text-sm text-slate-400">Not specified</span>
                                        @endforelse
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Preferred Job
                                        Titles</dt>
                                    <dd class="mt-1 text-sm text-slate-900">
                                        {{ is_array($profile->preferred_job_titles) ? implode(', ', $profile->preferred_job_titles) : ($profile->preferred_job_titles ?? 'Open to suggestions') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Step 4: Skills -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">4</span>
                                Skills & Competencies
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 4]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 text-sm text-slate-600">
                                @forelse($profile->skills as $skill)
                                    <span
                                        class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-medium border border-emerald-100">
                                        {{ $skill->name }}
                                    </span>
                                @empty
                                    <span class="italic text-slate-400">No skills added.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Work Experience -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">5</span>
                                Work Experience
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 5]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            @forelse($profile->workExperiences as $experience)
                                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b border-slate-100 last:border-0">
                                    <p class="text-sm font-bold text-slate-900">{{ $experience->job_title }} at
                                        {{ $experience->employer }}</p>
                                    <p class="text-xs text-slate-500">{{ $experience->start_date->format('M Y') }} -
                                        {{ $experience->is_current ? 'Present' : optional($experience->end_date)->format('M Y') }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">No history added.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Step 6: Education -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">6</span>
                                Education
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 6]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            @forelse($profile->educations as $education)
                                <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b border-slate-100 last:border-0">
                                    <p class="text-sm font-bold text-slate-900">{{ $education->level }} -
                                        {{ $education->field_of_study }}</p>
                                    <p class="text-xs text-slate-500">{{ $education->institution }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">No history added.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Step 7: Professional Summary -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">7</span>
                                Professional Summary
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 7]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <p class="text-sm font-bold text-slate-900 mb-2">{{ $profile->headline ?? 'No headline specified' }}</p>
                            <div class="text-sm text-slate-600 prose prose-sm max-w-none">
                                {!! $profile->description ?? '<span class="italic text-slate-400">No summary added yet.</span>' !!}
                            </div>
                        </div>
                    </div>

                    <!-- Step 8: International Readiness -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">8</span>
                                International Readiness
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 8]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Passport
                                        Status</dt>
                                    <dd class="mt-1 text-sm text-slate-900 font-medium">
                                        {{ $profile->passport_status ?? 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Willing to
                                        Relocate</dt>
                                    <dd class="mt-1 text-sm text-slate-900 font-medium">
                                        {{ $profile->willing_to_relocate ? 'Yes' : 'No' }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 9: Languages -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">9</span>
                                Languages
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 9]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-1"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2">
                                @forelse($profile->languages as $language)
                                    <span
                                        class="px-3 py-1 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200">
                                        {{ $language->name }} ({{ $language->pivot->proficiency }})
                                    </span>
                                @empty
                                    <span class="italic text-slate-400 text-sm">No languages added.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Step 10: Media & Compliance -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden group hover:border-emerald-300 transition-all">
                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center group-hover:bg-emerald-50/30 transition-all">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <span
                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-xs">10</span>
                                Media & Compliance
                            </h3>
                            <a href="{{ route('candidate.wizard.show', ['step' => 10]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Edit Section
                            </a>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center space-x-6">
                                <div
                                    class="flex items-center space-x-2 text-sm {{ $profile->profile_picture ? 'text-emerald-600' : 'text-slate-400' }}">
                                    <i data-lucide="{{ $profile->profile_picture ? 'check-circle' : 'circle' }}"
                                        class="w-5 h-5"></i>
                                    <span class="font-bold">Photo Uploaded</span>
                                </div>
                                <div
                                    class="flex items-center space-x-2 text-sm {{ $profile->video_cv ? 'text-emerald-600' : 'text-slate-400' }}">
                                    <i data-lucide="{{ $profile->video_cv ? 'check-circle' : 'circle' }}"
                                        class="w-5 h-5"></i>
                                    <span class="font-bold">Video CV Uploaded</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center text-slate-500 text-sm">
                    <p>Coyzon Recruitment &copy; {{ date('Y') }} | Quality Talent, Global Reach</p>
                </div>
            </div>
        </div>
    </div>
@endsection