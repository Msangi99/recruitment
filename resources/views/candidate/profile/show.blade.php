@extends('layouts.app')

@section('title', 'My Profile - Candidate')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('candidate.partials.nav')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900">My Profile</h2>
                    <div class="flex space-x-3">
                        @if(!$profile)
                            <a href="{{ route('candidate.profile.create') }}"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Create Profile
                            </a>
                        @else
                            <a href="{{ route('candidate.profile.edit') }}"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Edit Profile
                            </a>
                        @endif
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if(!$profile)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
                        <p class="text-gray-700 mb-4">You haven't created your profile yet.</p>
                        <a href="{{ route('candidate.profile.create') }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Start Creating Your Profile
                        </a>
                    </div>
                @else
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center">
                                        @if($profile->profile_picture)
                                            @php
                                                $imageUrl = asset($profile->profile_picture);
                                                $fileExists = file_exists(public_path($profile->profile_picture));
                                            @endphp
                                            @if($fileExists)
                                                <img src="{{ $imageUrl }}?v={{ time() }}" alt="Profile Picture"
                                                    class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 mr-4"
                                                    onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            @endif
                                            <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-200 mr-4"
                                                style="{{ $fileExists ? 'display:none;' : 'display:flex;' }}">
                                                <span
                                                    class="text-gray-500 text-2xl font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                            </div>
                                        @else
                                            <div
                                                class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-200 mr-4">
                                                <span
                                                    class="text-gray-500 text-2xl font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-xl leading-6 font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                                            <p class="text-indigo-600 font-medium">{{ $profile->title ?? 'Title not set' }}</p>
                                            <p class="mt-1 text-sm text-gray-500">{{ auth()->user()->email }} |
                                                {{ auth()->user()->phone }}</p>
                                            <p class="text-sm text-gray-500">{{ $profile->location ?? 'Location not set' }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $profile->verification_status == 'approved' ? 'bg-green-100 text-green-800' :
                    ($profile->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($profile->verification_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Professional Summary
                                </h4>
                                <p class="text-gray-900">{{ $profile->description ?? 'No description provided.' }}</p>
                            </div>

                            <div class="border-t border-gray-200">
                                <dl>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Education</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span
                                                class="font-bold">{{ ucfirst(str_replace('-', ' ', $profile->education_level ?? 'N/A')) }}</span>
                                            in {{ $profile->course_studied ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <p class="font-bold mb-2">{{ $profile->years_of_experience ?? '0' }} years |
                                                {{ $profile->experienceCategory->name ?? 'N/A' }}</p>
                                            <div class="bg-gray-50 p-3 rounded border text-gray-700">
                                                {{ $profile->experience_description ?? 'No experience description provided.' }}
                                            </div>
                                        </dd>
                                    </div>
                                    @php
                                        if (!$profile->relationLoaded('skills'))
                                            $profile->load('skills');
                                        if (!$profile->relationLoaded('languages'))
                                            $profile->load('languages');
                                    @endphp
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Skills & Languages</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="mb-3">
                                                <p class="text-xs text-gray-500 mb-1">Skills</p>
                                                @forelse($profile->skills as $skill)
                                                    <span
                                                        class="inline-block bg-indigo-100 rounded-full px-3 py-1 text-xs text-indigo-700 mr-2 mb-2">{{ $skill->name }}</span>
                                                @empty
                                                    <span class="text-gray-400 italic text-sm">No skills added</span>
                                                @endforelse
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Languages</p>
                                                @forelse($profile->languages as $language)
                                                    <span
                                                        class="inline-block bg-green-100 rounded-full px-3 py-1 text-xs text-green-700 mr-2 mb-2">{{ $language->name }}</span>
                                                @empty
                                                    <span class="text-gray-400 italic text-sm">No languages added</span>
                                                @endforelse
                                            </div>
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Preferences</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs text-gray-500">Expected Salary</p>
                                                    <p>{{ $profile->expected_salary ? number_format($profile->expected_salary, 2) . ' ' . $profile->currency : 'Not specified' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Target Destination</p>
                                                    <p>{{ $profile->target_destination ?? 'Not specified' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Availability</p>
                                                    <p>{{ $profile->is_available ? 'Available for work' : 'Not currently available' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                @endif
            </div>
        </div>
    </div>
@endsection