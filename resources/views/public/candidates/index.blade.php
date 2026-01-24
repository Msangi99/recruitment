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

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <form method="GET" action="{{ route('public.candidates.index') }}" class="relative max-w-4xl">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, skills, or destination..."
                        class="block w-full pl-11 pr-24 py-4 bg-white border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg transition-all duration-200">
                    <div class="absolute inset-y-0 right-2 flex items-center">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition-colors font-medium">
                            Search
                        </button>
                    </div>
                </div>

                @if(request()->anyFilled(['target_destination', 'education_level', 'min_experience', 'max_experience', 'availability', 'gender', 'language']))
                    <div class="mt-2 flex items-center gap-2 text-sm">
                        <span class="text-gray-500">Active filters:</span>
                        <a href="{{ route('public.candidates.index') }}" class="text-blue-600 hover:underline">Clear all</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 space-y-6 flex-shrink-0">
                <form method="GET" action="{{ route('public.candidates.index') }}" id="filterForm" class="space-y-3">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Job Title -->
                    <div>
                        <input type="text" name="job_title" value="{{ request('job_title') }}" placeholder="Job Title"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                    </div>

                    <!-- Skills -->
                    <div>
                        <input type="text" name="skills" value="{{ request('skills') }}" placeholder="Skills"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                    </div>

                    <!-- Experience Level -->
                    <div>
                        <select name="experience_level" onchange="this.form.submit()"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                            <option value="">Experience</option>
                            <option value="Entry Level" {{ request('experience_level') == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                            <option value="Junior" {{ request('experience_level') == 'Junior' ? 'selected' : '' }}>Junior
                            </option>
                            <option value="Mid-Level" {{ request('experience_level') == 'Mid-Level' ? 'selected' : '' }}>
                                Mid-Level</option>
                            <option value="Expert" {{ request('experience_level') == 'Expert' ? 'selected' : '' }}>Expert
                            </option>
                        </select>
                    </div>

                    <!-- Current Location -->
                    <div>
                        <input type="text" name="country" value="{{ request('country') }}" placeholder="Location"
                            list="countries"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                        <datalist id="countries">
                            <option value="Tanzania">
                            <option value="Kenya">
                            <option value="Uganda">
                            <option value="UAE">
                            <option value="Saudi Arabia">
                        </datalist>
                    </div>

                    <!-- Availability -->
                    <div>
                        <select name="availability_status" onchange="this.form.submit()"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                            <option value="">Availability</option>
                            <option value="Immediately Available" {{ request('availability_status') == 'Immediately Available' ? 'selected' : '' }}>Immediately Available</option>
                            <option value="Within 2 Weeks" {{ request('availability_status') == 'Within 2 Weeks' ? 'selected' : '' }}>Within 2 Weeks</option>
                            <option value="Within 1 Month" {{ request('availability_status') == 'Within 1 Month' ? 'selected' : '' }}>Within 1 Month</option>
                            <option value="Not Available Yet" {{ request('availability_status') == 'Not Available Yet' ? 'selected' : '' }}>Not Available Yet</option>
                        </select>
                    </div>

                    <!-- Passport Status -->
                    <div>
                        <select name="passport_status" onchange="this.form.submit()"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                            <option value="">Passport Status</option>
                            <option value="Valid Passport" {{ request('passport_status') == 'Valid Passport' ? 'selected' : '' }}>Valid Passport</option>
                            <option value="Passport in Process" {{ request('passport_status') == 'Passport in Process' ? 'selected' : '' }}>Passport in Process</option>
                            <option value="No Passport" {{ request('passport_status') == 'No Passport' ? 'selected' : '' }}>No Passport</option>
                        </select>
                    </div>

                    <!-- Willing to Relocate -->
                    <div>
                        <select name="willing_to_relocate" onchange="this.form.submit()"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                            <option value="">Willing to relocate</option>
                            <option value="1" {{ request('willing_to_relocate') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ request('willing_to_relocate') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <!-- Destination Country -->
                    <div>
                        <input type="text" name="target_destination" value="{{ request('target_destination') }}"
                            placeholder="Destination Country" list="destinations"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                        <datalist id="destinations">
                            <option value="UAE">
                            <option value="Saudi Arabia">
                            <option value="Qatar">
                            <option value="Poland">
                            <option value="Canada">
                            <option value="Japan">
                        </datalist>
                    </div>

                    <!-- Language -->
                    <div>
                        <select name="language" onchange="this.form.submit()"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                            <option value="">Language</option>
                            <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English
                            </option>
                            <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                            <option value="Swahili" {{ request('language') == 'Swahili' ? 'selected' : '' }}>Swahili
                            </option>
                            <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                            <option value="German" {{ request('language') == 'German' ? 'selected' : '' }}>German</option>
                        </select>
                    </div>

                    <!-- Medical & Police Clearance -->
                    <div>
                        <select name="clearance_status" onchange="this.form.submit()"
                            class="w-full rounded border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2">
                            <option value="">Medical & Police Clearance</option>
                            <option value="Available" {{ request('clearance_status') == 'Available' ? 'selected' : '' }}>
                                Available</option>
                            <option value="In Process" {{ request('clearance_status') == 'In Process' ? 'selected' : '' }}>In Process</option>
                            <option value="Not Available" {{ request('clearance_status') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-2 rounded shadow hover:bg-gray-800 transition-colors text-xs font-bold uppercase tracking-wider mt-2">
                        Filter Candidates
                    </button>
                </form>
            </aside>

            <!-- Candidates Results -->
            <main class="flex-1">
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $candidates->total() }} Candidates Found
                    </h2>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select
                            class="text-sm border-none bg-transparent font-medium text-gray-900 focus:ring-0 cursor-pointer">
                            <option>Newest</option>
                            <option>Experience</option>
                        </select>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($candidates as $candidate)
                        <div
                            class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col h-full group">
                            <div class="p-3 flex-1 flex flex-col relative">

                                <!-- Top Bar: ID & Badges -->
                                <div class="flex justify-between items-start mb-2">
                                    <span
                                        class="text-[10px] font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100">ID:
                                        #{{ $candidate->id }}{{ rand(100, 999) }}</span>
                                    <div class="flex gap-1">
                                        @if($candidate->candidateProfile->is_available)
                                            <span
                                                class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-green-50 text-green-700 border border-green-100">Available</span>
                                        @endif
                                        <span
                                            class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-blue-50 text-blue-600 border border-blue-100">Verified</span>
                                    </div>
                                </div>

                                <!-- Introduction Video (Moved Up prominent) -->
                                @if($candidate->candidateProfile->video_cv)
                                    <div class="mb-3 rounded-md overflow-hidden bg-black h-32 relative group/video">
                                        <video class="w-full h-full object-cover">
                                            <source src="{{ asset($candidate->candidateProfile->video_cv) }}" type="video/mp4">
                                        </video>
                                        <div
                                            class="absolute inset-0 flex items-center justify-center bg-black/10 group-hover/video:bg-black/20 transition-all">
                                            <div
                                                class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center pl-1 border border-white/40 cursor-pointer shadow-lg hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="absolute bottom-1 right-1 bg-black/60 text-white text-[9px] px-1 rounded">
                                            30-60s</div>
                                    </div>
                                @endif

                                <!-- Profile Details Grid -->
                                <div class="flex gap-3 mb-2">
                                    <div class="flex-shrink-0 text-center">
                                        @if($candidate->candidateProfile->profile_picture)
                                            <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                                alt="{{ $candidate->name }}"
                                                class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm mx-auto">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mx-auto">
                                                {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="mt-1">
                                            <span
                                                class="text-[9px] font-bold text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded-full whitespace-nowrap border border-gray-200">{{ $candidate->candidateProfile->years_of_experience ?? 0 }}
                                                Yrs</span>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-gray-900 leading-tight truncate">
                                            @php
                                                $nameParts = explode(' ', $candidate->name);
                                                $firstName = $nameParts[0];
                                                $lastNameInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '';
                                            @endphp
                                            {{ $firstName }} {{ $lastNameInitial }}
                                        </h3>
                                        @if($candidate->candidateProfile->title)
                                            <p class="text-xs font-bold text-blue-600 truncate uppercase mt-0.5">
                                                {{ $candidate->candidateProfile->title }}
                                            </p>
                                        @endif

                                        @if($candidate->candidateProfile->headline)
                                            <p
                                                class="text-[10px] text-gray-500 leading-snug line-clamp-2 mt-1 border-l-2 border-gray-100 pl-2">
                                                {{ $candidate->candidateProfile->headline }}
                                            </p>
                                        @elseif($candidate->candidateProfile->description)
                                            <p
                                                class="text-[10px] text-gray-500 leading-snug line-clamp-3 mt-1 border-l-2 border-gray-100 pl-2">
                                                {{ Str::limit($candidate->candidateProfile->description, 250) }}
                                            </p>
                                        @else
                                            <p class="text-[10px] text-gray-400 italic mb-1 border-l-2 border-gray-100 pl-2">
                                                Professional Summary</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Skills -->
                                @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                    <div class="flex flex-wrap gap-1 mt-auto pt-2 border-t border-gray-50">
                                        @foreach($candidate->candidateProfile->skills->take(3) as $skill)
                                            <span
                                                class="inline-block bg-white text-gray-600 px-1.5 py-0.5 text-[9px] rounded border border-gray-200 shadow-sm">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                        @if($candidate->candidateProfile->skills->count() > 3)
                                            <span
                                                class="text-[9px] text-gray-400 self-center">+{{ $candidate->candidateProfile->skills->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @endif

                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 border-t border-gray-100 divide-x divide-gray-100 bg-gray-50">
                                <a href="{{ route('public.candidates.show', $candidate) }}"
                                    class="py-2.5 text-center text-[10px] font-bold text-gray-600 hover:text-blue-600 hover:bg-white transition-colors uppercase tracking-tight">
                                    View Profile
                                </a>
                                <a href="{{ route('public.candidates.interview', $candidate) }}"
                                    class="py-2.5 text-center text-[10px] font-bold text-green-700 hover:text-green-800 hover:bg-green-50 transition-colors uppercase tracking-tight">
                                    Request This Candidate
                                </a>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 italic">No matches found</h3>
                            <p class="text-gray-500 mt-1">Try broadening your search criteria.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $candidates->links() }}
                </div>
            </main>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>