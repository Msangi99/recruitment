<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-gray-900 shadow-lg">
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
                        class="text-white hover:text-blue-400 font-medium transition-colors">About Us</a>
                    <a href="{{ route('public.jobs.index') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Find Candidate</a>
                    <a href="{{ route('public.appointments.index') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Book Appointment</a>
                    <a href="{{ route('contact') }}"
                        class="text-white hover:text-blue-400 font-medium transition-colors">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-white border border-white/30 rounded-lg hover:bg-white/10 transition-colors">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('public.jobs.index') }}" class="text-blue-600 hover:text-blue-900">← Back to Jobs</a>
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

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Job Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                    <h1 class="text-3xl font-bold">{{ $job->title }}</h1>
                    <p class="text-blue-100 mt-2">{{ $job->company_name }}</p>
                    <div class="flex flex-wrap gap-4 mt-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                            📍 {{ $job->location }}, {{ $job->country }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                            💼 {{ ucfirst($job->employment_type) }}
                        </span>
                        @if($job->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                                🏷️ {{ $job->category->name }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Key Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Salary</h3>
                            <p class="text-lg font-semibold text-gray-900">
                                @if($job->salary_min && $job->salary_max)
                                    {{ $job->currency ?? 'USD' }} {{ number_format($job->salary_min) }} -
                                    {{ number_format($job->salary_max) }}
                                    @if($job->salary_period)
                                        / {{ $job->salary_period }}
                                    @endif
                                @elseif($job->salary_min)
                                    {{ $job->currency ?? 'USD' }} {{ number_format($job->salary_min) }}+
                                @else
                                    Competitive salary
                                @endif
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Experience Required</h3>
                            <p class="text-lg font-semibold text-gray-900">
                                @if($job->experience_required == 0)
                                    No experience required
                                @else
                                    {{ $job->experience_required }}+ years
                                @endif
                            </p>
                        </div>

                        @if($job->education_level)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Education Level</h3>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ ucfirst(str_replace('-', ' ', $job->education_level)) }}
                                </p>
                            </div>
                        @endif

                        @if($job->languages && count($job->languages) > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Language Requirements</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ implode(', ', $job->languages) }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Job Description -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Job Description</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Requirements</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($job->requirements)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Benefits -->
                    @if($job->benefits)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Benefits</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($job->benefits)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Application Deadline -->
                    @if($job->deadline)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Application Deadline:</strong>
                                        {{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Video Requirement Notice -->
                    @if($job->requires_video)
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Note:</strong> This job requires a video introduction when applying.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Apply Button -->
                    <div class="border-t border-gray-200 pt-6">
                        @if($isCandidate)
                            @if($hasApplied)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                    <p class="text-green-800 font-medium">✓ You have already applied for this job</p>
                                    <a href="{{ route('candidate.applications.index') }}"
                                        class="text-green-600 hover:text-green-800 text-sm">View your applications →</a>
                                </div>
                            @else
                                <form method="POST" action="{{ route('candidate.jobs.apply', $job) }}"
                                    enctype="multipart/form-data" class="space-y-4">
                                    @csrf

                                    <div>
                                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">Cover
                                            Letter (Optional)</label>
                                        <textarea name="cover_letter" id="cover_letter" rows="4"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Tell the employer why you're a great fit for this role...">{{ old('cover_letter') }}</textarea>
                                    </div>

                                    @if($job->requires_video)
                                        <div>
                                            <label for="application_video"
                                                class="block text-sm font-medium text-gray-700 mb-2">Video Introduction
                                                (Required)</label>
                                            <input type="file" name="application_video" id="application_video"
                                                accept="video/mp4,video/mov,video/avi,video/wmv" class="w-full" required>
                                            <p class="mt-1 text-sm text-gray-500">Max 100MB. Accepted formats: MP4, MOV, AVI, WMV
                                            </p>
                                        </div>
                                    @endif

                                    <button type="submit"
                                        class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                        Apply for This Job
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}"
                                class="block w-full text-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                Apply for This Job
                            </a>
                        @endif
                    </div>

                    <!-- Job Meta -->
                    <div class="border-t border-gray-200 pt-6 text-sm text-gray-500">
                        <p>Posted on {{ $job->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>