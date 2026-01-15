<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Candidates - Coyzon Recruitment</title>
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
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('public.jobs.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}" class="text-blue-600 font-medium">Book Appointment</a>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Browse Verified Candidates</h2>
                <p class="mt-2 text-gray-600">Find qualified and verified candidates for your organization. No registration required to browse or request interviews.</p>
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

            <!-- Filters -->
            <form method="GET" action="{{ route('public.candidates.index') }}" class="mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Search -->
                        <div class="lg:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, skills, or destination..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <!-- Target Destination -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Target Destination</label>
                            <select name="target_destination" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Destinations</option>
                                <option value="Poland" {{ request('target_destination') == 'Poland' ? 'selected' : '' }}>Poland</option>
                                <option value="Germany" {{ request('target_destination') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option value="UAE" {{ request('target_destination') == 'UAE' ? 'selected' : '' }}>UAE</option>
                                <option value="Saudi Arabia" {{ request('target_destination') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                <option value="Qatar" {{ request('target_destination') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                <option value="Oman" {{ request('target_destination') == 'Oman' ? 'selected' : '' }}>Oman</option>
                                <option value="UK" {{ request('target_destination') == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="Europe" {{ request('target_destination') == 'Europe' ? 'selected' : '' }}>Europe</option>
                                <option value="Middle East" {{ request('target_destination') == 'Middle East' ? 'selected' : '' }}>Middle East</option>
                            </select>
                        </div>
                        
                        <!-- Education Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Education Level</label>
                            <select name="education_level" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Any Education</option>
                                <option value="no-formal-education" {{ request('education_level') == 'no-formal-education' ? 'selected' : '' }}>No formal education</option>
                                <option value="secondary-education" {{ request('education_level') == 'secondary-education' ? 'selected' : '' }}>Secondary education</option>
                                <option value="vocational-training" {{ request('education_level') == 'vocational-training' ? 'selected' : '' }}>Vocational training</option>
                                <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                            </select>
                        </div>
                        
                        <!-- Min Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Experience (years)</label>
                            <input type="number" name="min_experience" value="{{ request('min_experience') }}" min="0" placeholder="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <!-- Max Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Experience (years)</label>
                            <input type="number" name="max_experience" value="{{ request('max_experience') }}" min="0" placeholder="No limit" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <!-- Availability -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                            <select name="availability" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Any</option>
                                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available Now</option>
                                <option value="not-available" {{ request('availability') == 'not-available' ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>
                        
                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Any</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        
                        <!-- Language -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                            <select name="language" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Any Language</option>
                                <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Swahili" {{ request('language') == 'Swahili' ? 'selected' : '' }}>Swahili</option>
                                <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                                <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                <option value="German" {{ request('language') == 'German' ? 'selected' : '' }}>German</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('public.candidates.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Clear Filters</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Apply Filters</button>
                    </div>
                </div>
            </form>

            <!-- Candidates Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($candidates as $candidate)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                @if($candidate->candidateProfile->profile_picture)
                                    <img src="{{ asset($candidate->candidateProfile->profile_picture) }}" alt="{{ $candidate->name }}" class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xl font-bold">
                                        {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $candidate->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $candidate->candidateProfile->target_destination ?? 'Open to opportunities' }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                @if($candidate->candidateProfile->education_level)
                                    <p class="text-gray-600">
                                        <span class="font-medium">Education:</span> {{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level)) }}
                                    </p>
                                @endif
                                
                                @if($candidate->candidateProfile->years_of_experience)
                                    <p class="text-gray-600">
                                        <span class="font-medium">Experience:</span> {{ $candidate->candidateProfile->years_of_experience }} years
                                    </p>
                                @endif
                                
                                @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                    <div class="text-gray-600">
                                        <span class="font-medium">Skills:</span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($candidate->candidateProfile->skills->take(3) as $skill)
                                                <span class="inline-block bg-blue-50 text-blue-700 px-2 py-0.5 text-xs rounded">{{ $skill->name }}</span>
                                            @endforeach
                                            @if($candidate->candidateProfile->skills->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $candidate->candidateProfile->skills->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                @if($candidate->candidateProfile->is_available)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Not Available
                                    </span>
                                @endif
                                
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    ✓ Verified
                                </span>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('public.candidates.show', $candidate) }}" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-center rounded-lg hover:bg-gray-200 text-sm font-medium">
                                    View Profile
                                </a>
                                <a href="{{ route('public.candidates.interview', $candidate) }}" class="flex-1 px-4 py-2 bg-green-600 text-white text-center rounded-lg hover:bg-green-700 text-sm font-medium">
                                    Request Interview
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No candidates found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $candidates->links() }}
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
