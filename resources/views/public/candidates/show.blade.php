<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $candidate->name }} - Implore Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Implore Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">Implore</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('public.jobs.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}" class="text-blue-600 font-medium">Find Candidate</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 font-medium">Contact Us</a>
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('public.candidates.index') }}" class="text-blue-600 hover:text-blue-900">← Back to Candidates</a>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8 text-white">
                    <div class="flex items-center">
                        @if($candidate->candidateProfile->profile_picture)
                            <img src="{{ asset($candidate->candidateProfile->profile_picture) }}" alt="{{ $candidate->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-white/30">
                        @else
                            <div class="w-24 h-24 rounded-full bg-white/20 flex items-center justify-center text-3xl font-bold">
                                {{ strtoupper(substr($candidate->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="ml-6">
                            <h1 class="text-3xl font-bold">{{ $candidate->name }}</h1>
                            <p class="text-blue-100 mt-1">{{ $candidate->candidateProfile->target_destination ?? 'Open to opportunities' }}</p>
                            <div class="flex flex-wrap gap-3 mt-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                                    ✓ Verified Candidate
                                </span>
                                @if($candidate->candidateProfile->is_available)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-500/30 text-sm">
                                        Available Now
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-500/30 text-sm">
                                        Not Available
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Personal Information -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Personal Information
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @if($candidate->candidateProfile->date_of_birth)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Age</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ $candidate->candidateProfile->date_of_birth->age }} years</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->gender)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Gender</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($candidate->candidateProfile->gender) }}</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->citizenship)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Citizenship</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ $candidate->candidateProfile->citizenship }}</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->marital_status)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Marital Status</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($candidate->candidateProfile->marital_status) }}</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->residency_status)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Residency Status</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->residency_status)) }}</p>
                                </div>
                            @endif

                            @if($candidate->country)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Country</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ $candidate->country }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Education & Professional Info -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                            Education & Professional Background
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @if($candidate->candidateProfile->education_level)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Education Level</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level)) }}</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->course_studied)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Course/Field of Study</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ $candidate->candidateProfile->course_studied }}</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->years_of_experience !== null)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Years of Experience</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ $candidate->candidateProfile->years_of_experience }} years</p>
                                </div>
                            @endif

                            @if($candidate->candidateProfile->experienceCategory)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Experience Category</h3>
                                    <p class="text-lg font-semibold text-blue-600">{{ $candidate->candidateProfile->experienceCategory->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Skills -->
                    @php
                        $skills = $candidate->candidateProfile->skills ?? collect();
                        $skillsCollection = is_array($skills) ? collect($skills) : $skills;
                    @endphp
                    @if($skillsCollection && count($skillsCollection) > 0)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Skills & Expertise
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($skillsCollection as $skill)
                                    <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                                        {{ is_object($skill) ? $skill->name : $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Languages -->
                    @php
                        $languages = $candidate->candidateProfile->languages ?? collect();
                        $languagesCollection = is_array($languages) ? collect($languages) : $languages;
                    @endphp
                    @if($languagesCollection && count($languagesCollection) > 0)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                Languages
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($languagesCollection as $language)
                                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        {{ is_object($language) ? $language->name : $language }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Salary Expectation -->
                    @if($candidate->candidateProfile->expected_salary)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Salary Expectation
                            </h2>
                            <div class="bg-green-50 rounded-lg p-4 inline-block">
                                <p class="text-2xl font-bold text-green-700">
                                    {{ $candidate->candidateProfile->currency ?? 'TZS' }} {{ number_format($candidate->candidateProfile->expected_salary) }}
                                    <span class="text-sm font-normal text-green-600">/month</span>
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Target Destinations -->
                    @if($candidate->candidateProfile->target_destination)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Preferred Work Destinations
                            </h2>
                            <p class="text-gray-700 bg-gray-50 rounded-lg p-4">{{ $candidate->candidateProfile->target_destination }}</p>
                        </div>
                    @endif

                    <!-- Privacy Notice -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800">Contact Information Protected</h3>
                                <p class="mt-1 text-sm text-yellow-700">
                                    Phone and email are hidden for privacy. To contact this candidate, please submit an interview request below.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Request Interview CTA -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Interested in This Candidate?</h3>
                        <p class="text-gray-600 mb-4">Request an interview to discuss potential opportunities. No registration required!</p>
                        <a href="{{ route('public.candidates.interview', $candidate) }}" class="inline-block px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                            Request Interview
                        </a>
                    </div>

                    <!-- Contact Note -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">How It Works</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Submit an interview request with your company details</li>
                                        <li>Our admin team will review your request</li>
                                        <li>Once approved, the candidate will be notified</li>
                                        <li>You'll receive a confirmation email with next steps</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
