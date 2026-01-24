<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Candidates - Coyzon Recruitment</title>
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
                            class="px-4 py-2 text-white bg-deep-green rounded-lg hover:bg-opacity-90 transition-colors">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-deep-green text-white rounded-lg hover:bg-opacity-90 transition-colors">Sign
                            up</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="mb-10 text-center max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-heading tracking-tight">
                Find Your Perfect Candidate
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                From talent sourcing to shortlisting, we help you find candidates who fit your role, culture, and
                expectations
            </p>

            <form method="GET" action="{{ route('public.candidates.index') }}" class="relative max-w-3xl mx-auto">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-gray-400 group-focus-within:text-deep-green transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, skills, or destination..."
                        class="block w-full pl-14 pr-32 py-5 bg-white border border-gray-200 rounded-full shadow-lg shadow-gray-100/50 focus:ring-4 focus:ring-deep-green/10 focus:border-deep-green text-lg transition-all duration-300 placeholder-gray-400">
                    <div class="absolute inset-y-0 right-2 flex items-center">
                        <button type="submit"
                            class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-opacity-90 transition-all shadow-md hover:shadow-lg font-bold text-sm uppercase tracking-wide transform hover:-translate-y-0.5">
                            Search
                        </button>
                    </div>
                </div>

                @if(request()->anyFilled(['target_destination', 'education_level', 'min_experience', 'max_experience', 'availability', 'gender', 'language']))
                    <div class="mt-4 flex items-center justify-center gap-2 text-sm animate-fade-in-up">
                        <span class="text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Active filters applied</span>
                        <a href="{{ route('public.candidates.index') }}"
                            class="text-deep-green hover:text-deep-blue font-medium hover:underline transition-colors">Clear
                            all</a>
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

                <div class="grid grid-cols-1 gap-6">
                    @forelse($candidates as $candidate)
                        @if(!$candidate->candidateProfile)
                            @continue
                        @endif

                        @php
                            $videoPath = $candidate->candidateProfile->video_cv ?? ($candidate->documents->where('document_type', 'video_cv')->first()?->file_path);
                            $hasVideo = !empty($videoPath);
                        @endphp

                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 group flex flex-col md:flex-row">
                            <!-- Left Side: Candidate Details -->
                            <div class="flex-1 flex flex-col p-5 {{ $hasVideo ? 'md:border-r border-gray-100' : '' }}">

                                <!-- Top: ID & Badges -->
                                <div class="flex justify-between items-start mb-4">
                                    <span
                                        class="text-[10px] font-mono text-gray-400 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                        ID: #{{ $candidate->id }}{{ rand(100, 999) }}
                                    </span>
                                    <div class="flex gap-2">
                                        @if($candidate->candidateProfile->is_available)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                                Available
                                            </span>
                                        @endif
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                            Verified
                                        </span>
                                    </div>
                                </div>

                                <!-- Profile Info -->
                                <div class="flex gap-4 mb-4">
                                    <div class="flex-shrink-0 text-center">
                                        @if($candidate->candidateProfile->profile_picture)
                                            <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                                alt="{{ $candidate->name }}"
                                                class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md mx-auto ring-2 ring-gray-100">
                                        @else
                                            <div
                                                class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-bold mx-auto ring-4 ring-blue-50">
                                                {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <span
                                                class="text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded-full whitespace-nowrap border border-gray-200">
                                                {{ $candidate->candidateProfile->years_of_experience ?? 0 }} Yrs Exp
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight">
                                            @php
                                                $nameParts = explode(' ', $candidate->name);
                                                $firstName = $nameParts[0];
                                                $lastNameInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '';
                                            @endphp
                                            {{ $firstName }} {{ $lastNameInitial }}
                                        </h3>

                                        @if($candidate->candidateProfile->categories->count() > 0)
                                            <p class="text-xs font-bold text-emerald-600 uppercase mt-1 tracking-wide">
                                                {{ $candidate->candidateProfile->categories->first()->name }}
                                            </p>
                                        @elseif($candidate->candidateProfile->title)
                                            <p class="text-xs font-bold text-blue-600 uppercase mt-1 tracking-wide">
                                                {{ $candidate->candidateProfile->title }}
                                            </p>
                                        @endif

                                        @if($candidate->candidateProfile->headline)
                                            <p
                                                class="text-sm text-gray-500 font-medium leading-snug line-clamp-2 mt-2 border-l-2 border-deep-green pl-3">
                                                {{ $candidate->candidateProfile->headline }}
                                            </p>
                                        @endif

                                        @if($candidate->candidateProfile->description)
                                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mt-2">
                                                {{ Str::limit(strip_tags($candidate->candidateProfile->description), 200) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Skills & Actions -->
                                <div
                                    class="mt-auto pt-4 border-t border-gray-50 flex flex-wrap items-center justify-between gap-4">
                                    @if($candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($candidate->candidateProfile->skills->take(4) as $skill)
                                                <span
                                                    class="inline-block bg-white text-gray-600 px-2 py-1 text-[10px] rounded border border-gray-200 shadow-sm font-medium">
                                                    {{ $skill->name }}
                                                </span>
                                            @endforeach
                                            @if($candidate->candidateProfile->skills->count() > 4)
                                                <span class="text-[10px] text-gray-400 self-center font-medium pl-1">
                                                    +{{ $candidate->candidateProfile->skills->count() - 4 }} more
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div></div>
                                    @endif

                                    <div class="flex gap-2">
                                        <a href="{{ route('public.candidates.show', $candidate) }}"
                                            class="px-4 py-2 text-xs font-bold text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors border border-gray-200">
                                            View Profile
                                        </a>
                                        <a href="{{ route('public.candidates.interview', $candidate) }}"
                                            class="px-4 py-2 text-xs font-bold text-white bg-deep-green rounded-lg hover:bg-opacity-90 transition-colors shadow-sm hover:shadow">
                                            Request This Candidate
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side: Video CV (if available) -->
                            @if($hasVideo)
                                <div
                                    class="w-full md:w-80 bg-black relative group/video flex-shrink-0 min-h-[250px] md:min-h-full">
                                    <video class="w-full h-full object-cover">
                                        <source src="{{ asset($videoPath) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover/video:bg-black/40 transition-all">
                                        <a href="{{ asset($videoPath) }}" target="_blank"
                                            class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center pl-1 border border-white/50 cursor-pointer shadow-xl hover:scale-110 hover:bg-white/30 transition-all duration-300">
                                            <svg class="w-6 h-6 text-white drop-shadow-md" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </a>
                                    </div>

                                    <div
                                        class="absolute bottom-3 right-3 bg-black/60 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded">
                                        WATCH VIDEO CV
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div
                            class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                            <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 italic mb-2">No candidates matches found</h3>
                            <p class="text-gray-500 max-w-md mx-auto">We couldn't find any candidates matching your
                                criteria. Try adjusting your filters or search terms.</p>
                            <a href="{{ route('public.candidates.index') }}"
                                class="inline-block mt-6 text-deep-green font-bold hover:underline">Clear Validation
                                Filters</a>
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