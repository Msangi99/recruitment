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
                            class="flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold tracking-wide">
                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                            Available
                        </span>

                        @if($candidate->candidateProfile->headline)
                            <span class="text-xs font-semibold text-gray-600 border border-gray-200 px-2 py-1 rounded">
                                {{ $candidate->candidateProfile->headline }}
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Sidebar (Navigation & Meta) -->
            <div class="lg:col-span-4 space-y-6">

                <div
                    class="bg-white rounded-[1.5rem] shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden p-6">

                    <!-- Introduction Video -->
                    @if($candidate->candidateProfile->video_cv)
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-gray-900 mb-2">Introduction video</h3>
                            <div
                                class="rounded-xl overflow-hidden bg-black w-full h-48 shadow-sm relative group border border-gray-100">
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
                            <h3 class="text-xs font-bold text-gray-900 mb-1">Candidate ID</h3>
                            <p class="text-sm font-semibold text-gray-500">#{{ $candidate->id }}</p>
                        </div>

                        <!-- Willing to relocate -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 mb-1">Willing to relocate</h3>
                            <p class="text-sm font-semibold text-gray-500">
                                {{ $candidate->candidateProfile->willing_to_relocate ? 'Yes' : 'No' }}
                            </p>
                        </div>

                        <!-- Availability -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 mb-1">Availability</h3>
                            <p class="text-sm font-semibold text-gray-500">
                                {{ $candidate->candidateProfile->availability_status ?? 'Not specified' }}
                            </p>
                        </div>

                        <!-- Visa status -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 mb-1">Passport status</h3>
                            <p class="text-sm font-semibold text-gray-500">
                                {{ $candidate->candidateProfile->passport_status ?? 'Not Specified' }}
                            </p>
                        </div>

                        <!-- Years of experience -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 mb-1">Years of experience</h3>
                            <p class="text-sm font-semibold text-gray-500">
                                {{ $candidate->candidateProfile->years_of_experience ?? '0' }} Years
                            </p>
                        </div>

                        <!-- Preferred job titles max 3 -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 mb-1">Preferred job titles</h3>
                            <div class="flex flex-wrap gap-1.5">
                                @if(is_array($candidate->candidateProfile->preferred_job_titles) && count($candidate->candidateProfile->preferred_job_titles) > 0)
                                    @foreach(array_slice($candidate->candidateProfile->preferred_job_titles, 0, 3) as $title)
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-gray-50 text-gray-500 text-xs font-medium rounded border border-gray-100">
                                            {{ $title }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-400 italic">Not specified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('public.candidates.interview', $candidate) }}"
                    class="block w-full py-3 px-4 bg-deep-green hover:bg-emerald-800 text-white text-center text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg tracking-wide">
                    Request This Candidate
                </a>

            </div>

            <!-- Right Main Content -->
            <div class="lg:col-span-8">

                <div
                    class="bg-white rounded-[1.5rem] shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 p-6 overflow-hidden">

                    <!-- 1. Professional summary -->
                    <div id="summary" class="mb-6">
                        @if($candidate->candidateProfile->title || $candidate->candidateProfile->headline)
                            <div class="mb-4">
                                <h3 class="text-base font-bold text-deep-green">
                                    {{ $candidate->candidateProfile->headline }}
                                    {{-- {{ $candidate->candidateProfile->title ?? 'Candidate' }} --}}
                                </h3>
                            </div>
                        @endif
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed font-normal break-words">
                            {!! $candidate->candidateProfile->description !!}
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-6"></div>

                    <!-- 2. Skills -->
                    <div id="skills" class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                @foreach($candidate->candidateProfile->skills as $skill)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            @else
                                <p class="text-gray-400 italic text-sm">No specific skills listed.</p>
                            @endif
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-6"></div>

                    <!-- 3. Working history -->
                    <div id="experience" class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Working history</h2>
                        <div class="space-y-5">
                            @forelse($candidate->candidateProfile->workExperiences as $experience)
                                <div class="relative pl-6">
                                    <div class="absolute left-0 top-1.5 w-2 h-2 bg-deep-green rounded-full"></div>
                                    <div class="space-y-2">
                                        <p class="text-sm font-bold text-gray-900">Job title: <span
                                                class="font-medium text-gray-700 break-words">{{ $experience->job_title }}</span>
                                        </p>
                                        <p class="text-sm font-bold text-gray-900">Organization: <span
                                                class="font-medium text-gray-700 break-words">{{ $experience->employer }}</span>
                                        </p>
                                        <p class="text-sm font-bold text-gray-900">Location: <span
                                                class="font-medium text-gray-700">{{ $experience->city }},
                                                {{ $experience->country }}</span></p>
                                        <p class="text-sm font-bold text-gray-900">From: <span
                                                class="font-medium text-gray-700">
                                                {{ $experience->start_date->format('M Y') }} -

                                            </span> To: <span
                                                class="font-medium text-gray-700">{{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : 'N/A') }}</span>
                                        </p>
                                        <p class="text-sm font-bold text-gray-900">Roles & responsibilities:</p>
                                        <div class="text-sm text-gray-600 prose prose-sm max-w-none mt-2 ml-4 break-words">
                                            {!! $experience->description !!}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 italic text-center py-4 bg-gray-50 rounded-xl">No work history
                                    provided.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-6"></div>

                    <!-- 4. Education -->
                    <div id="education" class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Education</h2>
                        <div class="space-y-5">
                            @forelse($candidate->candidateProfile->educations->whereNotIn('level', ['Certificate']) as $education)
                                <div class="relative pl-6">
                                    <div class="absolute left-0 top-1.5 w-2 h-2 bg-deep-green rounded-full"></div>
                                    <div class="space-y-2">
                                        <p class="text-sm font-bold text-gray-900">Education level: <span
                                                class="font-medium text-gray-700">{{ $education->level }}</span></p>
                                        <p class="text-sm font-bold text-gray-900">Course: <span
                                                class="font-medium text-gray-700">{{ $education->field_of_study }}</span>
                                        </p>
                                        <p class="text-sm font-bold text-gray-900">Institute: <span
                                                class="font-medium text-gray-700">{{ $education->institution }}</span></p>
                                        <p class="text-sm font-bold text-gray-900">Location: <span
                                                class="font-medium text-gray-700">{{ $education->city }},
                                                {{ $education->country }}</span></p>
                                        <p class="text-sm font-bold text-gray-900">Year: <span
                                                class="font-medium text-gray-700">
                                                {{ $education->start_date->format('Y') }} -
                                                {{ $education->is_current ? 'Present' : ($education->end_date ? $education->end_date->format('Y') : '') }}
                                            </span></p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 italic text-center py-4 bg-gray-50 rounded-xl w-full">No education
                                    history details provided.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-6"></div>

                    <!-- 5. Certification & Training -->
                    <div id="certifications" class="mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Certification & Training</h2>
                        <div class="grid grid-cols-1 gap-4">
                            @php
                                $certifications = $candidate->candidateProfile->educations->where('level', 'Certificate');
                                $complianceDocs = $candidate->documents->whereIn('document_type', ['Medical Fitness Status', 'Police Clearance Status']);
                            @endphp
                            @forelse($certifications as $cert)
                                <div class="p-4 rounded-xl bg-indigo-50/50 border border-indigo-100">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="font-bold text-gray-900 text-sm break-words">
                                                {{ $cert->field_of_study }}</h3>
                                            <p class="text-xs text-indigo-600 font-bold mt-0.5 break-words">
                                                {{ $cert->institution }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @if($complianceDocs->isEmpty())
                                    <p class="text-gray-400 italic text-center py-4 bg-gray-50 rounded-xl w-full">No
                                        certifications or trainings listed.</p>
                                @endif
                            @endforelse

                            @foreach($complianceDocs as $doc)
                                <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100">
                                    <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-4">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <h3 class="font-bold text-gray-900 text-sm break-words">
                                                    {{ $doc->document_type }}</h3>
                                                <p class="text-xs text-emerald-600 font-bold mt-0.5">Verified PDF Document
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ asset($doc->file_path) }}" target="_blank"
                                            class="inline-flex items-center px-3 py-1 bg-white border border-emerald-200 text-emerald-700 text-xs font-bold rounded-lg hover:bg-emerald-50 transition-colors flex-shrink-0 whitespace-nowrap">
                                            View Document
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 w-full mb-6"></div>

                    <!-- 6. Language (na level zake) -->
                    <div id="languages">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Language</h2>
                        <div class="space-y-3">
                            @forelse($candidate->candidateProfile->languages as $language)
                                <div class="flex items-center gap-1">
                                    <span class="text-base font-medium text-gray-900">{{ $language->name }}:</span>
                                    <span class="text-base text-gray-500">{{ $language->pivot->proficiency }}</span>
                                </div>
                            @empty
                                <p class="text-gray-400 italic text-center py-2 bg-gray-50 rounded-xl w-full">No languages
                                    listed.</p>
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