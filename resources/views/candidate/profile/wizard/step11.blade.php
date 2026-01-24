@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">Review Your Profile</h2>
            <p class="mt-2 text-slate-600 font-medium">Please verify your information before final submission.</p>
        </div>

        <div class="space-y-8">
            <!-- Step 1 & 2: Account & Basic Info -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">1-2</span>
                        Basic Information
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 2]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Full Name</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nationality</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $profile->citizenship ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-slate-900">
                                {{ $profile->date_of_birth ? $profile->date_of_birth->format('M d, Y') : '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Current Location</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $profile->location }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Step 3: Job Preferences -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">3</span>
                        Job Preferences
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 3]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Job Categories</dt>
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
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Preferred Job Titles
                            </dt>
                            <dd class="mt-1 text-sm text-slate-900">
                                {{ is_array($profile->preferred_job_titles) ? implode(', ', $profile->preferred_job_titles) : ($profile->preferred_job_titles ?? 'Open to suggestions') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Availability Status
                            </dt>
                            <dd class="mt-1 text-sm text-slate-900 font-medium text-emerald-700">
                                {{ $profile->availability_status }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Step 4: Skills -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">4</span>
                        Skills & Competencies
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 4]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @forelse($profile->skills as $skill)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ $skill->name }}
                            </span>
                        @empty
                            <span class="text-sm text-slate-400 italic">No skills added yet.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Step 5: Work Experience -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">5</span>
                        Work Experience
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 5]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6 divide-y divide-slate-100">
                    @forelse($profile->workExperiences as $experience)
                        <div class="py-4 first:pt-0 last:pb-0">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $experience->job_title }}</h4>
                                    <p class="text-sm font-medium text-slate-600">{{ $experience->employer }}</p>
                                </div>
                                <span class="text-xs font-medium text-slate-500 px-2 py-1 bg-slate-100 rounded">
                                    {{ $experience->start_date->format('M Y') }} -
                                    {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                                </span>
                            </div>
                            @if($experience->description)
                                <div class="text-xs text-slate-600 prose prose-sm max-w-none">
                                    {!! $experience->description !!}
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 italic">No work experience added.</p>
                    @endforelse
                </div>
            </div>

            <!-- Step 6: Education -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">6</span>
                        Education
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 6]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6 divide-y divide-slate-100">
                    @forelse($profile->educations as $education)
                        <div class="py-4 first:pt-0 last:pb-0">
                            <h4 class="text-sm font-bold text-slate-900">{{ $education->level }} -
                                {{ $education->field_of_study }}</h4>
                            <p class="text-sm font-medium text-slate-600">{{ $education->institution }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $education->city }}, {{ $education->country }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 italic">No education history added.</p>
                    @endforelse
                </div>
            </div>

            <!-- Step 7: Professional Summary -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">7</span>
                        Professional Summary
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 7]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Headline</dt>
                    <dd class="text-sm text-slate-900 font-bold mb-4">{{ $profile->headline ?? 'Not specified' }}</dd>
                    
                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Summary</dt>
                    <dd class="text-sm text-slate-700 prose prose-sm max-w-none">
                        {!! $profile->description ?? '<span class="text-slate-400 italic">No summary provided</span>' !!}
                    </dd>
                </div>
            </div>

            <!-- Step 8: International Readiness -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">8</span>
                        International Readiness
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 8]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Willing to Relocate
                            </dt>
                            <dd class="mt-1 text-sm text-slate-900 font-medium whitespace-nowrap">
                                @if($profile->willing_to_relocate === true)
                                    <span class="text-emerald-600 flex items-center"><i data-lucide="check"
                                             class="w-4 h-4 mr-1"></i> Yes</span>
                                @else
                                    <span class="text-slate-500 whitespace-nowrap flex items-center"><i data-lucide="x"
                                             class="w-4 h-4 mr-1"></i> No</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Passport Status</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $profile->passport_status ?? 'Not Specified' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Preferred Destinations
                            </dt>
                            <dd class="mt-1 flex flex-wrap gap-2">
                                @forelse($profile->preferred_destinations ?? [] as $destination)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $destination }}
                                    </span>
                                @empty
                                    <span class="text-sm text-slate-400">None selected</span>
                                @endforelse
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Step 9: Languages -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">9</span>
                        Languages
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 9]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @forelse($profile->languages as $language)
                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                <p class="text-sm font-bold text-slate-900">{{ $language->name }}</p>
                                <p class="text-xs text-slate-500">{{ $language->pivot->proficiency }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic">No languages added.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Step 10: Media & Compliance -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 text-sm">10</span>
                        Media & Compliance
                    </h3>
                    <a href="{{ route('candidate.wizard.show', ['step' => 10]) }}"
                        class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Profile Photo
                            </dt>
                            <dd>
                                @if($profile->profile_picture)
                                    <img src="{{ asset('profile-pictures/' . $profile->profile_picture) }}"
                                        class="w-32 h-32 rounded-lg object-cover border-2 border-slate-200">
                                @else
                                    <div
                                        class="w-32 h-32 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                        No Photo</div>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Video CV</dt>
                            <dd>
                                @if($profile->video_cv)
                                    <div class="flex items-center text-sm text-emerald-600 font-medium">
                                        <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i> Document Uploaded
                                    </div>
                                @else
                                    <div class="text-sm text-slate-400 italic">No video uploaded</div>
                                @endif
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('candidate.wizard.process', ['step' => 11]) }}" method="POST">
            @csrf
            <div class="flex items-center justify-between pt-10 border-t border-slate-200 mt-10">
                <a href="{{ route('candidate.wizard.show', ['step' => 10]) }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900 flex items-center">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Back to Media
                </a>
                <button type="submit"
                    class="inline-flex justify-center items-center rounded-xl border border-transparent bg-deep-green px-8 py-3 text-base font-bold text-white shadow-xl hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all transform hover:scale-105 active:scale-95">
                    Complete & Submit Profile
                    <i data-lucide="check-circle" class="w-5 h-5 ml-2"></i>
                </button>
            </div>
        </form>
    </div>
@endsection