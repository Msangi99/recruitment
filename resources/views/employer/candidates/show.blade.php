@extends('layouts.app')

@section('title', 'Candidate Profile - Employer')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('employer.partials.nav')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6">
                    <a href="{{ route('employer.candidates.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back
                        to Candidates</a>
                </div>

                <!-- Profile Header Card -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($candidate->candidateProfile && $candidate->candidateProfile->profile_picture)
                                        <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                            alt="{{ $candidate->name }}"
                                            class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div
                                            class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center border-4 border-white shadow-lg">
                                            <span
                                                class="text-white font-bold text-2xl">{{ substr($candidate->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $candidate->name }}</h3>
                                @if($candidate->candidateProfile && $candidate->candidateProfile->title)
                                    <p class="text-lg text-indigo-600 font-medium">{{ $candidate->candidateProfile->title }}</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Verified Candidate
                                    </p>
                                    @if($candidate->candidateProfile && $candidate->candidateProfile->is_available)
                                        <span
                                            class="mt-2 inline-block px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">Available
                                            for Work</span>
                                    @else
                                        <span
                                            class="mt-2 inline-block px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-full">Not
                                            Currently Available</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('employer.interviews.create', $candidate) }}"
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md hover:shadow-lg transition-all duration-200 font-medium">
                                    Request Interview
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details -->
                <div class="border-t border-gray-200">
                    <!-- Professional Summary -->
                    @if($candidate->candidateProfile && $candidate->candidateProfile->description)
                        <div class="bg-white px-6 py-6 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Professional Summary</h4>
                            <div class="text-gray-600 leading-relaxed">{!! $candidate->candidateProfile->description !!}</div>
                        </div>
                    @endif

                    @if($candidate->candidateProfile && $candidate->candidateProfile->video_cv)
                        <div class="bg-white px-6 py-6 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Video CV</h4>
                            <div class="w-full max-w-2xl">
                                <video controls class="w-full h-48 rounded-lg shadow-lg border border-gray-200 object-cover">
                                    <source src="{{ asset($candidate->candidateProfile->video_cv) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    @endif

                    <dl class="divide-y divide-gray-200">
                        <!-- Personal Information Section -->
                        <div class="bg-gray-50 px-6 py-4">
                            <h4 class="text-lg font-semibold text-gray-900">Personal Information</h4>
                        </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $candidate->name }}</dd>
                            </div>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $candidate->email }}</dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $candidate->phone ?? 'Not provided' }}</dd>
                            </div>

                            @if($candidate->candidateProfile && $candidate->candidateProfile->gender)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ ucfirst($candidate->candidateProfile->gender) }}</dd>
                                </div>
                            @endif

                            @if($candidate->candidateProfile && $candidate->candidateProfile->date_of_birth)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Age</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ \Carbon\Carbon::parse($candidate->candidateProfile->date_of_birth)->age }} years old
                                    </dd>
                                </div>
                            @endif

                            @if($candidate->candidateProfile && $candidate->candidateProfile->marital_status)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Marital Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ ucfirst($candidate->candidateProfile->marital_status) }}</dd>
                                </div>
                            @endif

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Current Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $candidate->country ?? 'N/A' }}</dd>
                            </div>

                            @if($candidate->candidateProfile && $candidate->candidateProfile->citizenship)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Citizenship</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $candidate->candidateProfile->citizenship }}</dd>
                                </div>
                            @endif

                            @if($candidate->candidateProfile && $candidate->candidateProfile->target_destination)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Target Destination</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $candidate->candidateProfile->target_destination }}
                                        </span>
                                    </dd>
                                </div>
                            @endif

                            <!-- Professional Information Section -->
                            <div class="bg-gray-50 px-6 py-4 mt-4">
                                <h4 class="text-lg font-semibold text-gray-900">Professional Information</h4>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Education Level</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        {{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'N/A')) }}
                                    </span>
                                </dd>
                            </div>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Years of Experience</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span
                                        class="text-lg font-semibold text-indigo-600">{{ $candidate->candidateProfile->years_of_experience ?? '0' }}</span>
                                    years
                                </dd>
                            </div>

                            @if($candidate->candidateProfile && $candidate->candidateProfile->skills)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Skills</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($candidate->candidateProfile->skills as $skill)
                                                <span
                                                    class="inline-block bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg px-3 py-2 text-sm text-blue-700 font-medium">
                                                    {{ is_object($skill) ? $skill->name : $skill }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </dd>
                                </div>
                            @endif

                            @if($candidate->candidateProfile && $candidate->candidateProfile->languages)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Languages</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($candidate->candidateProfile->languages as $language)
                                                <span
                                                    class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-green-100 text-green-700 border border-green-200">
                                                    <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.188-.196-.373-.396-.554-.6a19.098 19.098 0 01-3.107 3.567 1 1 0 01-1.334-1.49 17.087 17.087 0 003.13-3.733 18.992 18.992 0 01-1.487-2.494 1 1 0 111.79-.89c.234.47.489.928.764 1.372.417-.934.752-1.913.997-2.927H3a1 1 0 110-2h3V3a1 1 0 011-1zm6 6a1 1 0 01.894.553l2.991 5.982a.869.869 0 01.02.037l.99 1.98a1 1 0 11-1.79.895L15.383 16h-4.764l-.724 1.447a1 1 0 11-1.788-.894l.99-1.98.019-.038 2.99-5.982A1 1 0 0113 8zm-1.382 6h2.764L13 11.236 11.618 14z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ is_object($language) ? $language->name : $language }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </dd>
                                </div>
                            @endif

                            @if($candidate->candidateProfile && $candidate->candidateProfile->expected_salary)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Expected Salary</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span class="text-lg font-semibold text-green-600">
                                            {{ number_format($candidate->candidateProfile->expected_salary, 0) }}
                                            {{ $candidate->candidateProfile->currency ?? 'TZS' }}
                                        </span>
                                        <span class="text-gray-500 text-sm ml-2">per month</span>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                        
                        <!-- Uploaded Documents (For Employer) -->
                        <div class="bg-gray-50 px-6 py-4 mt-4 border-t border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900">Uploaded Documents</h4>
                        </div>
                        <div class="bg-white px-4 py-5 sm:px-6">
                            <ul class="divide-y divide-gray-200">
                                @forelse($candidate->documents as $document)
                                    @if($document->verification_status == 'approved')
                                    <li class="py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $document->document_type == 'video_cv' ? 'Video CV' : ucfirst($document->document_type) }}</p>
                                                    <p class="text-sm text-gray-500">{{ $document->file_name }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <a href="{{ asset($document->file_path) }}" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                    View <span class="sr-only">{{ $document->file_name }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        @if($document->document_type == 'video_cv')
                                            <div class="mt-4 w-full max-w-lg mx-auto">
                                                <video controls class="w-full h-48 rounded-lg shadow-sm border border-gray-200 object-cover">
                                                    <source src="{{ asset($document->file_path) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @endif
                                    </li>
                                    @endif
                                @empty
                                    <li class="py-4 text-center text-sm text-gray-500">No documents available</li>
                                @endforelse
                            </ul>
                        </div>
                </div>
            </div>
        </div>
@endsection