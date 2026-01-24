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

            <!-- Left Sidebar (Meta Information) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden sticky top-28">

                    <!-- Profile Info Header -->
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

                                <!-- Online/Verified Status Badge -->
                                <div class="absolute bottom-0 right-0">
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-600 border border-blue-100 shadow-sm">Verified</span>
                                </div>
                            </div>

                            <!-- Name -->
                            <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $candidate->name }}</h2>

                            <!-- Job Title (from Profile) -->
                            @if($candidate->candidateProfile->title)
                                <p class="text-sm font-medium text-blue-600 uppercase mb-2">
                                    {{ $candidate->candidateProfile->title }}
                                </p>
                            @endif

                            <!-- Location -->
                            @if($candidate->candidateProfile->location)
                                <div class="flex items-center justify-center text-gray-500 text-xs mb-4">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $candidate->candidateProfile->location }}
                                </div>
                            @endif

                            <!-- Action Button -->
                            <a href="{{ route('public.candidates.interview', $candidate) }}"
                                class="block w-full py-2.5 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-colors mb-4 uppercase tracking-wide shadow-sm">
                                Request Interview
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-100 my-4"></div>

                        <!-- Meta Details List -->
                        <div class="space-y-4 text-sm">
                            <!-- Introduction Video (Small Preview if needed, or link to main) -->
                            <!-- NOTE 4: Video displayed before/after click view profile. We show it prominently in Main Content, here we can show status -->

                            <!-- Candidate ID -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Candidate ID</span>
                                <span
                                    class="text-gray-900 font-mono font-medium">#{{ $candidate->id }}{{ rand(100, 999) }}</span>
                            </div>

                            <!-- Willing to Relocate -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Relocation</span>
                                <span
                                    class="{{ $candidate->candidateProfile->willing_to_relocate ? 'text-green-600 bg-green-50 border-green-100' : 'text-gray-400 bg-gray-50 border-gray-100' }} px-2 py-0.5 rounded border text-xs font-bold uppercase">
                                    {{ $candidate->candidateProfile->willing_to_relocate ? 'Yes' : 'No' }}
                                </span>
                            </div>

                            <!-- Availability -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Availability</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $candidate->candidateProfile->availability_status ?? 'N/A' }}</span>
                            </div>

                            <!-- Visa Status (Passport) -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Visa Status</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $candidate->candidateProfile->passport_status ?? 'N/A' }}</span>
                            </div>

                            <!-- Years of Experience -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Experience</span>
                                <span
                                    class="text-gray-900 font-bold">{{ $candidate->candidateProfile->years_of_experience ?? 0 }}
                                    Years</span>
                            </div>

                            <!-- Preferred Job Titles -->
                            @if($candidate->candidateProfile->preferred_job_titles && count($candidate->candidateProfile->preferred_job_titles) > 0)
                                <div class="pt-2">
                                    <span class="text-gray-500 block mb-2">Preferred Roles</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(array_slice($candidate->candidateProfile->preferred_job_titles, 0, 3) as $title)
                                            <span
                                                class="text-xs text-gray-600 bg-gray-100 border border-gray-200 px-2 py-1 rounded">
                                                {{ $title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Main Content (Detailed) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- 1. Professional Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Professional
                        Summary</h2>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                        {{ $candidate->candidateProfile->description ?? ($candidate->candidateProfile->headline ?? 'No professional summary provided.') }}
                    </div>
                </div>

                <!-- 2. Skills -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                            @foreach($candidate->candidateProfile->skills->take(15) as $skill)
                                <span
                                    class="px-4 py-1.5 bg-gray-50 text-gray-700 border border-gray-200 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors cursor-default">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-500 italic">No specific skills listed.</span>
                        @endif
                    </div>
                </div>

                <!-- 3. Work History -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Work History</h2>

                    @if(!empty(trim($candidate->candidateProfile->experience_description)))
                        @php
                            // Basic parsing attempt simply to display distinct blocks if user entered them with newlines
                            // Since we don't have structured data, we treat blocks separated by double newlines as distinct jobs
                            $experiences = preg_split('/\n\s*\n/', $candidate->candidateProfile->experience_description);
                        @endphp

                        <div
                            class="space-y-8 relative before:absolute before:inset-0 before:left-2 before:border-l-2 before:border-gray-100 before:content-['']">
                            @foreach($experiences as $index => $experience)
                                <div class="relative pl-8">
                                    <!-- Timeline Dot -->
                                    <div class="absolute left-0 top-1.5 w-4 h-4 bg-white border-2 border-blue-600 rounded-full">
                                    </div>

                                    <!-- Use heuristics or just display text -->
                                    <!-- Since we don't have fields, we assume the first line might be title/company if short, otherwise just text -->
                                    <div class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                                        {{ trim($experience) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-400 italic bg-gray-50 rounded-lg">
                            No work history details provided.
                        </div>
                    @endif
                </div>

                <!-- 4. Education -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Education</h2>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v5" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">
                                {{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'Education Level N/A')) }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1 font-medium">
                                {{ $candidate->candidateProfile->course_studied ?? 'Field of study not specified' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 5. Certification & Training -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Certification &
                        Training</h2>
                    <!-- Placeholder until data exists -->
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-gray-600">Available upon request (No specific data listed)</span>
                        </li>
                    </ul>
                </div>

                <!-- 6. Language -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Languages</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($candidate->candidateProfile->languages && $candidate->candidateProfile->languages->count() > 0)
                            @foreach($candidate->candidateProfile->languages as $language)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                                    <span class="font-medium text-gray-900">{{ $language->name }}</span>
                                    <span class="text-xs font-bold text-blue-600 uppercase bg-blue-50 px-2 py-1 rounded">Fluent
                                        (Default)</span>
                                </div>
                            @endforeach
                        @else
                            <span class="text-gray-500 italic">No specific languages listed.</span>
                        @endif
                    </div>
                </div>

                <!-- 7. Introduction Video -->
                @php
                    $videoCv = $candidate->candidateProfile->video_cv;
                    if (!$videoCv) {
                        $videoDoc = $candidate->documents->where('document_type', 'video_cv')->first();
                        if ($videoDoc) {
                            $videoCv = $videoDoc->file_path;
                        }
                    }
                @endphp

                @if($videoCv)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Introduction Video
                        </h2>
                        <div class="rounded-xl overflow-hidden bg-black aspect-video relative group shadow-lg">
                            <video controls class="w-full h-full object-cover">
                                <source src="{{ asset($videoCv) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>