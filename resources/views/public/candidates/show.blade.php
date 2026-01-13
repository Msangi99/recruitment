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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Quick Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @if($candidate->candidateProfile->education_level)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Education Level</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level)) }}</p>
                            </div>
                        @endif

                        @if($candidate->candidateProfile->years_of_experience)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Years of Experience</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ $candidate->candidateProfile->years_of_experience }} years</p>
                            </div>
                        @endif

                        @if($candidate->candidateProfile->gender)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Gender</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ ucfirst($candidate->candidateProfile->gender) }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Skills -->
                    @if($candidate->candidateProfile->skills)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Skills & Expertise</h2>
                            <p class="text-gray-700">{{ $candidate->candidateProfile->skills }}</p>
                        </div>
                    @endif

                    <!-- Languages -->
                    @if($candidate->candidateProfile->languages && count($candidate->candidateProfile->languages) > 0)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Languages</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($candidate->candidateProfile->languages as $language)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $language }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Work Experience -->
                    @if($candidate->candidateProfile->work_experience)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Work Experience</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($candidate->candidateProfile->work_experience)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Target Destinations -->
                    @if($candidate->candidateProfile->target_destination)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Preferred Work Destinations</h2>
                            <p class="text-gray-700">{{ $candidate->candidateProfile->target_destination }}</p>
                        </div>
                    @endif

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
