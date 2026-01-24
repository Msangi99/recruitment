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
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-50/50">
    @include('partials.public-nav')

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <!-- Top Profile Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-6">
            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">

                <!-- Avatar -->
                <div class="relative">
                    @if($candidate->candidateProfile->profile_picture)
                        <img src="{{ asset($candidate->candidateProfile->profile_picture) }}" alt="{{ $candidate->name }}"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                    @else
                        <div
                            class="w-24 h-24 rounded-full bg-deep-green flex items-center justify-center text-3xl font-medium text-white border-4 border-white shadow-md">
                            {{ strtoupper(substr($candidate->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute bottom-1 right-1">
                        <div class="bg-gray-200 rounded-full p-1 border-2 border-white">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ explode(' ', $candidate->name)[0] }}
                                {{ isset(explode(' ', $candidate->name)[1]) ? strtoupper(substr(explode(' ', $candidate->name)[1], 0, 1)) . '.' : '' }}
                            </h1>
                            <span class="inline-flex items-center p-0.5 rounded-full bg-blue-50 text-blue-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center text-gray-500 text-sm mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $candidate->candidateProfile->location }}
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <span
                            class="flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wide">
                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                            Available now
                        </span>

                        @if($candidate->candidateProfile->categories->count() > 0)
                            <span class="text-xs font-semibold text-gray-600 border border-gray-200 px-2 py-1 rounded">
                                {{ $candidate->candidateProfile->categories->first()->name }}
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Sidebar (Navigation & Meta) -->
            <div class="lg:col-span-4 space-y-6">

                <div class="bg-white rounded-[1.5rem] shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden p-6">
                    
                    <!-- Introduction Video -->
                    @if($candidate->candidateProfile->video_cv)
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Introduction Video</h3>
                            <div class="rounded-xl overflow-hidden bg-black aspect-video shadow-sm relative group border border-gray-100">
                                <video controls class="w-full h-full object-cover">
                                    <source src="{{ asset($candidate->candidateProfile->video_cv) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <!-- Candidate ID -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Candidate ID</h3>
                            <p class="text-sm font-semibold text-gray-900">#{{ $candidate->id }}</p>
                        </div>

                        <!-- Willing to relocate -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Willing to relocate</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $candidate->candidateProfile->willing_to_relocate ? 'Yes' : 'No' }}
                            </p>
                        </div>

                        <!-- Availability -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Availability</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $candidate->candidateProfile->availability_status ?? 'Not specified' }}
                            </p>
                        </div>

                        <!-- Visa status -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Visa Status</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $candidate->candidateProfile->passport_status ?? 'Not Specified' }}
                            </p>
                        </div>

                        <!-- Years of experience -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Years of Experience</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $candidate->candidateProfile->years_of_experience ?? '0' }} Years
                            </p>
                        </div>

                        <!-- Prefer job titles max 3 -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Preferred Job Titles</h3>
                            <div class="flex flex-wrap gap-1.5">
                                @if(is_array($candidate->candidateProfile->preferred_job_titles) && count($candidate->candidateProfile->preferred_job_titles) > 0)
                                    @foreach(array_slice($candidate->candidateProfile->preferred_job_titles, 0, 3) as $title)
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">
                                            {{ $title }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-500 italic">Not specified</span>
                                @endif
                            </div>
                        </div>

                        <!-- Language -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Languages</h3>
                            <div class="space-y-1">
                                @forelse($candidate->candidateProfile->languages as $language)
                                    <div class="text-sm text-gray-900 flex justify-between">
                                        <span class="font-medium">{{ $language->name }}</span>
                                        <span class="text-gray-500 text-xs">{{ $language->pivot->proficiency }}</span>
                                    </div>
                                @empty
                                    <span class="text-sm text-gray-500 italic">No languages listed</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('public.candidates.interview', $candidate) }}"
                    class="block w-full py-3 px-4 bg-deep-green hover:bg-emerald-800 text-white text-center text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg uppercase tracking-wide">
                    Request This Candidate
                </a>

            </div>

            <!-- Right Main Content -->
            <div class="lg:col-span-8">

                <div class="bg-white rounded-[1.5rem] shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 p-6">

                    <!-- 1. Headline & Summary -->
                    <div id="summary" class="mb-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-1">
                            {{ $candidate->candidateProfile->title ?? 'Professional Profile' }}
                        </h2>
                        <p class="text-gray-500 text-sm mb-3">{{ $candidate->candidateProfile->headline }}</p>
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed font-normal">
                            {!! $candidate->candidateProfile->description !!}
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-5"></div>

                    <!-- 2. Work Experience -->
                    <div id="experience" class="mb-5">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Professional Experience</h2>
                        <div class="space-y-5">
                            @forelse($candidate->candidateProfile->workExperiences as $experience)
                                <div
                                    class="relative pl-5 before:absolute before:inset-0 before:left-0 before:border-l-2 before:border-gray-100">
                                    <div class="absolute left-[-5px] top-1.5 w-2.5 h-2.5 bg-gray-400 rounded-full"></div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1">
                                        <div>
                                            <h3 class="font-bold text-gray-900">{{ $experience->job_title }}</h3>
                                            <p class="text-sm font-medium text-emerald-600">{{ $experience->employer }}</p>
                                        </div>
                                        <span
                                            class="text-xs font-bold text-gray-500 bg-gray-50 px-2 py-1 rounded inline-block mt-1 sm:mt-0">
                                            {{ $experience->start_date->format('M Y') }} -
                                            {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 prose prose-sm max-w-none">
                                        {!! $experience->description !!}
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 italic text-center py-4 bg-gray-50 rounded-xl">No work history
                                    provided.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-5"></div>

                    <!-- 3. Skills -->
                    <div id="skills" class="mb-5">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Expertise & Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                @foreach($candidate->candidateProfile->skills as $skill)
                                    <span
                                        class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold border border-emerald-100">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400 italic text-sm">No specific skills listed.</span>
                            @endif
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-5"></div>

                    <!-- 4. Education -->
                    <div id="education">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Education</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($candidate->candidateProfile->educations as $education)
                                <div class="p-3 rounded-lg bg-gray-50 border border-gray-100">
                                    <h3 class="font-bold text-gray-900 text-sm">{{ $education->level }} -
                                        {{ $education->field_of_study }}</h3>
                                    <p class="text-xs text-emerald-600 font-medium mt-0.5">{{ $education->institution }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">
                                        {{ $education->city }}, {{ $education->country }}</p>
                                </div>
                            @empty
                                <p class="col-span-2 text-gray-400 italic text-center py-4">No education history details
                                    provided.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Total Work History (Footer) -->
                @if($candidate->candidateProfile->workExperiences->count() > 0)
                    <div class="mt-4 flex items-center justify-between px-2 text-gray-500 text-sm">
                        <span>Total jobs: <span
                                class="font-bold text-gray-900">{{ $candidate->candidateProfile->workExperiences->count() }}</span></span>
                        <span>Completed: <span
                                class="font-bold text-gray-900">{{ $candidate->candidateProfile->workExperiences->whereStrict('is_current', 0)->count() }}</span></span>
                    </div>
                @endif

            </div>
        </div>

        @include('partials.footer')
</body>

</html>