<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $candidate->name }} - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    }
                }
            }
        }
    </script>
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
                    <a href="{{ route('contact') }}"
                        class="text-gray-300 hover:text-white font-medium transition-colors text-sm">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-white bg-deep-green rounded-lg hover:bg-opacity-90 transition-colors">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 bg-deep-green text-white text-sm font-semibold rounded-xl hover:bg-opacity-90 transition-all shadow-lg">Sign
                            up</a>
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
                    <div class="p-6">
                        <div class="text-center relative">
                            <div class="relative inline-block mb-3">
                                @if($candidate->candidateProfile->profile_picture)
                                    <img src="{{ asset('profile-pictures/' . $candidate->candidateProfile->profile_picture) }}"
                                        alt="{{ $candidate->name }}"
                                        class="w-24 h-24 rounded-full object-cover border border-gray-200 mx-auto">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full bg-deep-green flex items-center justify-center text-3xl font-medium text-white mx-auto">
                                        {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="absolute bottom-0 right-0">
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-600 border border-blue-100 shadow-sm">Verified</span>
                                </div>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 mb-1">
                                {{ explode(' ', $candidate->name)[0] }}
                                {{ isset(explode(' ', $candidate->name)[1]) ? strtoupper(substr(explode(' ', $candidate->name)[1], 0, 1)) . '.' : '' }}
                            </h2>
                            @if($candidate->candidateProfile->categories->count() > 0)
                                <p class="text-sm font-bold text-emerald-600 uppercase mb-2">
                                    {{ $candidate->candidateProfile->categories->first()->name }}
                                </p>
                            @endif
                            <div class="flex items-center justify-center text-gray-500 text-xs mb-4">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $candidate->candidateProfile->location }}
                            </div>
                            <a href="{{ route('public.candidates.interview', $candidate) }}"
                                class="block w-full py-2.5 px-4 bg-deep-green hover:bg-emerald-800 text-white text-sm font-bold rounded-lg transition-colors mb-4 uppercase tracking-wide shadow-sm">
                                Request Interview
                            </a>
                        </div>

                        <div class="border-t border-gray-100 my-4"></div>

                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Relocation</span>
                                <span
                                    class="{{ $candidate->candidateProfile->willing_to_relocate ? 'text-green-600 bg-green-50' : 'text-gray-400 bg-gray-50' }} px-2 py-0.5 rounded border text-xs font-bold uppercase">
                                    {{ $candidate->candidateProfile->willing_to_relocate ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Availability</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $candidate->candidateProfile->availability_status ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Visa Status</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $candidate->candidateProfile->passport_status ?? 'N/A' }}</span>
                            </div>
                            @if($candidate->candidateProfile->preferred_destinations)
                                <div class="pt-2">
                                    <span class="text-gray-500 block mb-2">Target Markets</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($candidate->candidateProfile->preferred_destinations as $dest)
                                            <span
                                                class="text-xs text-gray-600 bg-gray-100 border border-gray-200 px-2 py-1 rounded">{{ $dest }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Main Content -->
            <div class="lg:col-span-8 space-y-6">

                <!-- 1. Headline & Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        {{ $candidate->candidateProfile->title ?? 'Professional Profile' }}
                    </h2>
                    <p class="text-gray-500 text-sm mb-6">{{ $candidate->candidateProfile->headline }}</p>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                        {!! $candidate->candidateProfile->description !!}
                    </div>
                </div>

                <!-- 2. Skills -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-emerald-600 pl-3">Expertise &
                        Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($candidate->candidateProfile->skills as $skill)
                            <span
                                class="px-4 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-sm font-medium">
                                {{ $skill->name }}
                            </span>
                        @empty
                            <span class="text-gray-400 italic">No specific skills listed.</span>
                        @endforelse
                    </div>
                </div>

                <!-- 3. Work Experience -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-l-4 border-emerald-600 pl-3">Professional
                        Experience</h2>
                    <div class="space-y-8">
                        @forelse($candidate->candidateProfile->workExperiences as $experience)
                            <div
                                class="relative pl-8 before:absolute before:inset-0 before:left-0 before:border-l-2 before:border-gray-100">
                                <div class="absolute left-[-5px] top-1.5 w-2.5 h-2.5 bg-emerald-500 rounded-full"></div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $experience->job_title }}</h3>
                                        <p class="text-sm font-medium text-emerald-600">{{ $experience->employer }}</p>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-500 bg-gray-50 px-2 py-1 rounded inline-block mt-2 sm:mt-0">
                                        {{ $experience->start_date->format('M Y') }} -
                                        {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 prose prose-sm max-w-none">
                                    {!! $experience->description !!}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 italic text-center py-4 bg-gray-50 rounded-xl">No work history provided.
                            </p>
                        @endforelse
                    </div>
                </div>

                <!-- 4. Education -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-l-4 border-emerald-600 pl-3">Education</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($candidate->candidateProfile->educations as $education)
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <h3 class="font-bold text-gray-900 text-sm">{{ $education->level }} -
                                    {{ $education->field_of_study }}
                                </h3>
                                <p class="text-xs text-emerald-600 font-medium mt-1">{{ $education->institution }}</p>
                                <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider">{{ $education->city }},
                                    {{ $education->country }}
                                </p>
                            </div>
                        @empty
                            <p class="col-span-2 text-gray-400 italic text-center py-4">No education history details
                                provided.</p>
                        @endforelse
                    </div>
                </div>

                <!-- 5. Languages -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-emerald-600 pl-3">Languages</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($candidate->candidateProfile->languages as $language)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <span class="text-sm font-bold text-gray-900">{{ $language->name }}</span>
                                <span
                                    class="text-[10px] font-bold text-emerald-600 uppercase">{{ $language->pivot->proficiency }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 6. Video Introduction -->
                @if($candidate->candidateProfile->video_cv)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-emerald-600 pl-3">Video CV</h2>
                        <div class="rounded-2xl overflow-hidden bg-black aspect-video shadow-2xl">
                            <video controls class="w-full h-full">
                                <source src="{{ asset('uploads/video_cvs/' . $candidate->candidateProfile->video_cv) }}"
                                    type="video/mp4">
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