<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $candidate->name }} - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Coyzon Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">Coyzon</span>
                    </a>
                </div>
                <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                    <a href="{{ route('about') }}" class="text-blue-600 hover:text-blue-800 font-bold">About Us</a>
                    <a href="{{ route('public.jobs.index') }}" class="text-blue-600 hover:text-blue-800 font-bold">Find
                        Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Find Candidate</a>
                    <a href="{{ route('candidate.consultations.create') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Book Appointment</a>
                    <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 font-bold">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Sidebar (Profile Info) -->
            <div class="w-full lg:w-1/4 flex-shrink-0">
                <div class="bg-white shadow rounded-2xl overflow-hidden border border-gray-100 sticky top-24">
                    <div class="p-6 text-center">
                        <div class="relative inline-block mb-4">
                            @if($candidate->candidateProfile->profile_picture)
                                <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                    alt="{{ $candidate->name }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg mx-auto">
                            @else
                                <div class="w-32 h-32 rounded-full bg-blue-600 flex items-center justify-center text-4xl font-bold text-white border-4 border-white shadow-lg mx-auto">
                                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="absolute bottom-2 right-2 bg-green-500 w-5 h-5 rounded-full border-4 border-white" title="Online"></div>
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-1">
                            @php
                                $nameParts = explode(' ', $candidate->name);
                                $firstName = $nameParts[0];
                                $lastNameInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '';
                            @endphp
                            {{ $firstName }} {{ $lastNameInitial }}
                        </h1>
                        
                        <div class="flex items-center justify-center text-gray-500 text-sm mb-6">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $candidate->candidateProfile->location ?? ($candidate->country ?? 'N/A') }}
                        </div>

                        <a href="{{ route('public.candidates.interview', $candidate) }}"
                            class="block w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full transition-colors shadow-md mb-3">
                            Request Interview
                        </a>
                        
                        <div class="flex items-center justify-center gap-2 mb-6">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Verified
                             </span>
                        </div>

                        <!-- Sidebar Stats -->
                        <div class="border-t border-gray-100 pt-6 text-left space-y-4">
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Education Level</h3>
                                <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'N/A')) }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Experience</h3>
                                <p class="font-semibold text-gray-900">{{ $candidate->candidateProfile->years_of_experience ?? 0 }} Years</p>
                            </div>

                             @if($candidate->candidateProfile->birth_date || $candidate->candidateProfile->age)
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Age</h3>
                                <p class="font-semibold text-gray-900">
                                    {{ $candidate->candidateProfile->date_of_birth ? $candidate->candidateProfile->date_of_birth->age . ' Years' : 'N/A' }}
                                </p>
                            </div>
                            @endif

                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Availability</h3>
                                <p class="font-semibold {{ $candidate->candidateProfile->is_available ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $candidate->candidateProfile->is_available ? 'Available Now' : 'Currently Busy' }}
                                </p>
                            </div>

                            @if($candidate->candidateProfile->languages && $candidate->candidateProfile->languages->count() > 0)
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Languages</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($candidate->candidateProfile->languages as $language)
                                        <span class="text-sm bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                            {{ $language->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content (Details) -->
            <div class="w-full lg:w-3/4 space-y-6">
                
                <!-- Main Card -->
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $candidate->candidateProfile->title ?? 'Candidate' }}
                            </h2>
                            <div class="flex items-center text-gray-500 gap-4 text-sm font-medium">
                                @if($candidate->candidateProfile->expected_salary)
                                <span class="flex items-center text-gray-900 font-bold text-lg">
                                    {{ $candidate->candidateProfile->currency }} {{ number_format($candidate->candidateProfile->expected_salary) }}
                                    <span class="text-xs font-normal text-gray-500 ml-1">/mo</span>
                                </span>
                                @endif
                            </div>
                        </div>
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-bold border border-blue-100">
                            {{ $candidate->candidateProfile->experienceCategory->name ?? 'General' }}
                        </span>
                    </div>

                    <div class="prose max-w-none text-gray-700 mb-8 leading-relaxed">
                        {{ $candidate->candidateProfile->description }}
                    </div>

                    <!-- Skills -->
                    @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($candidate->candidateProfile->skills as $skill)
                                <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors cursor-default">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Video CV -->
                @if($candidate->candidateProfile->video_cv)
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="p-2 bg-red-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        Video Introduction
                    </h3>
                    <div class="rounded-xl overflow-hidden bg-black shadow-lg">
                        <video controls class="w-full aspect-video">
                            <source src="{{ asset($candidate->candidateProfile->video_cv) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                @endif

                <!-- Documents -->
                @if($candidate->documents && $candidate->documents->count() > 0)
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
                     <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        Verified Documents
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($candidate->documents as $document)
                            <a href="{{ asset($document->file_path) }}" target="_blank"
                                class="group flex items-center p-4 rounded-xl border border-gray-200 hover:border-blue-400 hover:shadow-md transition-all bg-gray-50 hover:bg-white">
                                <div class="p-3 bg-white rounded-lg border border-gray-100 mr-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                        @if($document->document_type == 'cv') CV / Resume
                                        @elseif($document->document_type == 'id') Identity Document
                                        @elseif($document->document_type == 'video_cv') Video Profile
                                        @else {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500 flex items-center">
                                        View File
                                        <svg class="w-3 h-3 ml-1 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Other Details (Education & Course) - Bottom Section -->
                 <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Education & Background</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         @if($candidate->candidateProfile->course_studied)
                         <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Field of Study</span>
                            <div class="text-gray-900 font-medium bg-gray-50 p-3 rounded-lg border border-gray-100">
                                {{ $candidate->candidateProfile->course_studied }}
                            </div>
                         </div>
                         @endif
                         
                         @if($candidate->candidateProfile->target_destination)
                         <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Preferred Destination</span>
                            <div class="text-gray-900 font-medium bg-gray-50 p-3 rounded-lg border border-gray-100">
                                {{ $candidate->candidateProfile->target_destination }}
                            </div>
                         </div>
                         @endif
                    </div>
                 </div>

            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>