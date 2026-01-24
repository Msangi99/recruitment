@extends('layouts.app')

@section('title', 'My Profile - Candidate')

@include('candidate.partials.nav')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        @if(!$profile)
            <div class="bg-white border border-slate-200 rounded-xl p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="user-plus" class="w-10 h-10 text-emerald-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Create Your Profile</h2>
                <p class="text-slate-600 mb-8 max-w-sm mx-auto">You haven't completed your professional profile yet. Get started
                    now to connect with employers.</p>
                <a href="{{ route('candidate.wizard.show') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-deep-green hover:bg-emerald-700 transition-colors">
                    Complete My Profile
                </a>
            </div>
        @else
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">My Profile</h2>
                    <p class="mt-1 text-slate-500 font-medium">As seen by verified employers</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                                                        {{ $profile->verification_status == 'approved' ? 'bg-green-100 text-green-800' :
                ($profile->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        <i data-lucide="{{ $profile->verification_status == 'approved' ? 'shield-check' : 'clock' }}"
                            class="w-3 h-3 mr-1"></i>
                        {{ ucfirst($profile->verification_status) }}
                    </span>
                    <a href="{{ route('candidate.profile.edit') }}"
                        class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm">
                        <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                        Manage Profile
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-8">
                <!-- Step 1 & 2: Account & Basic Info -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="user" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Basic Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-shrink-0">
                                @if($profile->profile_picture)
                                    <img src="{{ asset($profile->profile_picture) }}"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border-4 border-white shadow-md">
                                        <i data-lucide="user" class="w-12 h-12"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Full Name</dt>
                                        <dd class="mt-1 text-sm text-slate-900">{{ auth()->user()->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address
                                        </dt>
                                        <dd class="mt-1 text-sm text-slate-900">{{ auth()->user()->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nationality
                                        </dt>
                                        <dd class="mt-1 text-sm text-slate-900">{{ $profile->citizenship ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date of Birth
                                        </dt>
                                        <dd class="mt-1 text-sm text-slate-900">
                                            {{ $profile->date_of_birth ? $profile->date_of_birth->format('M d, Y') : '-' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Gender
                                        </dt>
                                        <dd class="mt-1 text-sm text-slate-900">{{ ucfirst($profile->gender ?? '-') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Current
                                            Location</dt>
                                        <dd class="mt-1 text-sm text-slate-900">{{ $profile->location }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Overview Hidden -->


                <!-- Step 3: Job Preferences -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="briefcase" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Job Preferences
                        </h3>
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Availability
                                        Status
                                    </dt>
                                    <dd class="mt-1 text-sm text-slate-900 font-medium text-emerald-700">
                                        {{ $profile->availability_status }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Expected Salary
                                    </dt>
                                    <dd class="mt-1 text-sm text-slate-900">
                                        @if($profile->expected_salary)
                                            {{ $profile->currency }} {{ number_format($profile->expected_salary) }}
                                        @else
                                            <span class="text-slate-400">Not specified</span>
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Step 4: Skills -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="zap" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Skills & Competencies
                        </h3>
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
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="history" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Work Experience
                        </h3>
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
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="graduation-cap" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Education
                        </h3>
                    </div>
                    <div class="p-6 divide-y divide-slate-100">
                        @forelse($profile->educations as $education)
                            <div class="py-4 first:pt-0 last:pb-0">
                                <h4 class="text-sm font-bold text-slate-900">{{ $education->level }} -
                                    {{ $education->field_of_study }}
                                </h4>
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
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="user-check" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Professional Summary
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm font-bold text-slate-900 mb-2">{{ $profile->headline ?? 'No headline specified' }}</p>
                        <div class="text-sm text-slate-600 prose prose-sm max-w-none">
                            {!! $profile->description ?? '<span class="italic text-slate-400">No summary added yet.</span>' !!}
                        </div>
                    </div>
                </div>

                <!-- Step 8: International Readiness -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="globe" class="w-5 h-5 mr-3 text-slate-400"></i>
                            International Readiness
                        </h3>
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
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="languages" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Languages
                        </h3>
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
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                            <i data-lucide="camera" class="w-5 h-5 mr-3 text-slate-400"></i>
                            Media & Compliance
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div>
                                <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Profile Photo
                                </dt>
                                <dd>
                                    @if($profile->profile_picture)
                                        <img src="{{ asset($profile->profile_picture) }}"
                                            class="w-32 h-32 rounded-lg object-cover border-2 border-slate-200">
                                    @else
                                        <div
                                            class="w-32 h-32 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs text-center p-4">
                                            No Photo Uploaded</div>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Video CV</dt>
                                <dd>
                                    @if($profile->video_cv)
                                        <div class="w-full h-48 bg-black rounded-lg overflow-hidden">
                                            <video controls class="w-full h-full">
                                                <source src="{{ asset($profile->video_cv) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @else
                                        <div
                                            class="aspect-video rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-sm italic">
                                            No video uploaded</div>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    </div>
    </div>
@endsection