<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $candidate->name }} - 100X Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50/50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-gray-900 border-b border-gray-800 shadow-xl backdrop-blur-lg bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-16 w-auto">
                        <span class="ml-3 text-xl font-bold text-white">Coyzon</span>
                    </a>
                </div>
                <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                    <a href="{{ route('about') }}"
                        class="text-gray-300 hover:text-white font-medium transition-colors text-sm">About Us</a>
                    <a href="{{ route('public.jobs.index') }}"
                        class="text-gray-300 hover:text-white font-medium transition-colors text-sm">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-white hover:text-blue-400 font-semibold transition-colors text-sm">Find
                        Candidate</a>
                    <a href="{{ route('public.appointments.index') }}"
                        class="text-gray-300 hover:text-white font-medium transition-colors text-sm">Book
                        Appointment</a>
                    <a href="{{ route('contact') }}"
                        class="text-gray-300 hover:text-white font-medium transition-colors text-sm">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}"
                            class="text-gray-300 hover:text-white font-medium text-sm transition-colors">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-all border border-gray-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Sidebar (Upwork-style Compact) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Main Profile & Video Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden sticky top-28">

                    <!-- Video Section -->
                    @if($candidate->candidateProfile->video_cv)
                        <div class="relative bg-black aspect-video group cursor-pointer">
                            <video controls
                                class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                                <source src="{{ asset($candidate->candidateProfile->video_cv) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div
                                class="absolute top-2 right-2 bg-black/70 text-white text-[10px] font-medium px-2 py-0.5 rounded backdrop-blur-sm">
                                Video Intro
                            </div>
                        </div>
                    @endif

                    <!-- Profile Info -->
                    <div class="p-6">
                        <div class="text-center relative">
                            <!-- Avatar -->
                            <div class="relative inline-block mb-3">
                                @if($candidate->candidateProfile->profile_picture)
                                    <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                        alt="{{ $candidate->name }}"
                                        class="w-24 h-24 rounded-full object-cover border border-gray-200 mx-auto">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full bg-green-600 flex items-center justify-center text-3xl font-medium text-white mx-auto">
                                        {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                    </div>
                                @endif

                                <!-- Online/Verified Status Dot -->
                                <div class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"
                                    title="Verification Status"></div>
                            </div>

                            <!-- Name -->
                            <h2 class="text-xl font-medium text-gray-900 mb-1">{{ $candidate->name }}</h2>

                            @if($candidate->candidateProfile->headline)
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                                    {{ $candidate->candidateProfile->headline }}
                                </p>
                            @endif

                            <!-- Action Button -->
                            <a href="{{ route('public.candidates.interview', $candidate) }}"
                                class="block w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-full transition-colors mb-4">
                                Request Interview
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 my-4"></div>

                        <!-- Compact Details List -->
                        <div class="space-y-3 text-sm">
                            <!-- Candidate ID -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">ID</span>
                                <span class="text-gray-900 font-medium">#{{ $candidate->id }}{{ rand(100, 999) }}</span>
                            </div>

                            <!-- Location -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">From</span>
                                <span
                                    class="text-gray-900 font-medium text-right">{{ $candidate->candidateProfile->location ?? 'N/A' }}</span>
                            </div>

                            <!-- Experience -->
                            @if($candidate->candidateProfile->years_of_experience > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Experience</span>
                                <span class="text-gray-900 font-medium text-right">
                                    {{ $candidate->candidateProfile->years_of_experience }} Years
                                    @if($candidate->candidateProfile->experience_level)
                                        <span
                                            class="text-gray-400 text-xs">({{ $candidate->candidateProfile->experience_level }})</span>
                                    @endif
                                </span>
                            </div>
                            @endif

                            <!-- Relocation -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">Relocation</span>
                                <span
                                    class="{{ $candidate->candidateProfile->willing_to_relocate ? 'text-green-600' : 'text-gray-400' }} font-medium">
                                    {{ $candidate->candidateProfile->willing_to_relocate ? 'Yes' : 'No' }}
                                </span>
                            </div>

                            <!-- Verification Items -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">Passport</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $candidate->candidateProfile->passport_status ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Clearance</span>
                                <div class="text-right">
                                    @if($candidate->candidateProfile->police_clearance === 'Cleared' || $candidate->candidateProfile->medical_clearance === 'Cleared')
                                        <div class="flex items-center text-green-600 font-medium">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Verified
                                        </div>
                                    @else
                                        <span class="text-gray-400">Standard</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 my-4"></div>

                        <!-- Languages -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Languages</h3>
                            <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                @if($candidate->candidateProfile->languages && $candidate->candidateProfile->languages->count() > 0)
                                    @foreach($candidate->candidateProfile->languages as $language)
                                        <span>{{ $language->name }}@if(!$loop->last),@endif</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Content (Upwork-style Main Card) -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200">

                    <!-- Header Section -->
                    <div class="p-8 border-b border-gray-200">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-full">
                                <h1 class="text-2xl font-medium text-gray-900 mb-2">
                                    {{ $candidate->candidateProfile->title ?? 'No Title Provided' }}
                                </h1>
                                @if($candidate->candidateProfile->preferred_job_titles && count($candidate->candidateProfile->preferred_job_titles) > 0)
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        @foreach($candidate->candidateProfile->preferred_job_titles as $title)
                                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                                {{ $title }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <!-- Rate (Optional Placement) -->
                            @if($candidate->candidateProfile->expected_salary)
                                <div class="flex-shrink-0 text-right ml-4">
                                    <span class="block text-xl font-medium text-gray-900 whitespace-nowrap">
                                        {{ $candidate->candidateProfile->currency }}
                                        {{ number_format($candidate->candidateProfile->expected_salary) }}
                                    </span>
                                    <span class="text-xs text-gray-500">/ month</span>
                                </div>
                            @endif
                        </div>

                        <!-- Overview -->
                        <div>
                            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed text-[15px]">
                                {{ $candidate->candidateProfile->description ?? 'No overview provided.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Work History Section -->
                    @if(!empty(trim($candidate->candidateProfile->experience_description)))
                    <div class="p-8 border-b border-gray-200">
                        <h2 class="text-xl font-medium text-gray-900 mb-6">Work History</h2>
                        
                        @php
                            $experiences = array_filter(explode("\n", $candidate->candidateProfile->experience_description), 'trim');
                        @endphp

                        @if(count($experiences) > 1)
                            <div class="space-y-6">
                                @foreach($experiences as $experience)
                                    <div class="group">
                                        <div class="flex justify-between mb-1">
                                            <h3 class="text-base font-semibold text-gray-900">
                                                {{ Str::limit($experience, 100) }}
                                            </h3>
                                        </div>
                                        <div class="flex items-center space-x-2 mb-2 text-sm text-gray-500">
                                            <div class="flex text-green-600">
                                                @for($i=0; $i<5; $i++)
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                            <span>5.00</span>
                                            <span>•</span>
                                            <span class="text-green-600">Completed</span>
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $experience }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="group">
                                <div class="flex justify-between mb-1">
                                    <h3 class="text-base font-semibold text-green-600 group-hover:underline cursor-pointer">
                                        Summary of Experience
                                    </h3>
                                    <span class="text-sm text-gray-500">
                                        {{ $candidate->candidateProfile->years_of_experience }} Years Exp
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                    {{ $candidate->candidateProfile->experience_description }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Skills Section -->
                    <div class="p-8 border-b border-gray-200">
                        <h2 class="text-xl font-medium text-gray-900 mb-6">Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                @foreach($candidate->candidateProfile->skills as $skill)
                                    <span
                                        class="px-4 py-1.5 bg-gray-100 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors cursor-default">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-500">No skills listed.</span>
                            @endif
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="p-8">
                        <h2 class="text-xl font-medium text-gray-900 mb-6">Education</h2>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">
                                {{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'N/A')) }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $candidate->candidateProfile->course_studied ?? 'Major/Field N/A' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>