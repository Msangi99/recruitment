@extends('layouts.app')

@section('title', 'Browse Candidates - Employer')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('employer.partials.nav')

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="mb-8">
                <form method="GET" action="{{ route('employer.candidates.index') }}" class="relative max-w-4xl">
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

                    @if(request()->anyFilled(['country', 'target_destination', 'education_level', 'language', 'min_experience', 'max_experience', 'availability', 'gender', 'min_age', 'max_age']))
                        <div class="mt-2 flex items-center gap-2 text-sm">
                            <span class="text-gray-500">Active filters:</span>
                            <a href="{{ route('employer.candidates.index') }}" class="text-blue-600 hover:underline">Clear
                                all</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-64 space-y-6 flex-shrink-0">
                    <form method="GET" action="{{ route('employer.candidates.index') }}" id="filterForm" class="space-y-4">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="space-y-3">
                            <!-- Location (Country) -->
                            <select name="country" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Any Location</option>
                                @foreach(['Tanzania', 'Kenya', 'Uganda', 'Rwanda', 'Burundi', 'Ethiopia', 'Other'] as $country)
                                    <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Target Destination -->
                            <select name="target_destination" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Any Destination</option>
                                @foreach(['Poland', 'Finland', 'Germany', 'UAE', 'Saudi Arabia', 'Qatar', 'UK', 'USA'] as $dest)
                                    <option value="{{ $dest }}" {{ request('target_destination') == $dest ? 'selected' : '' }}>
                                        {{ $dest }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Education Level -->
                            <select name="education_level" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Any Education</option>
                                <option value="no-formal-education" {{ request('education_level') == 'no-formal-education' ? 'selected' : '' }}>No formal education</option>
                                <option value="secondary-education" {{ request('education_level') == 'secondary-education' ? 'selected' : '' }}>Secondary education</option>
                                <option value="vocational-training" {{ request('education_level') == 'vocational-training' ? 'selected' : '' }}>Vocational training</option>
                                <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>
                                    Diploma</option>
                                <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>
                                    Bachelor's Degree</option>
                                <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>Master's
                                    Degree</option>
                            </select>

                            <!-- Experience Range -->
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_experience" value="{{ request('min_experience') }}"
                                    placeholder="Min Exp"
                                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <input type="number" name="max_experience" value="{{ request('max_experience') }}"
                                    placeholder="Max Exp"
                                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            </div>

                            <!-- Age Range -->
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_age" value="{{ request('min_age') }}" placeholder="Min Age"
                                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <input type="number" name="max_age" value="{{ request('max_age') }}" placeholder="Max Age"
                                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            </div>

                            <!-- Availability -->
                            <select name="availability" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Any Availability</option>
                                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>
                                    Available Now</option>
                                <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>
                                    Not Available</option>
                            </select>

                            <!-- Gender -->
                            <select name="gender" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Any Gender</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>

                            <!-- Language -->
                            <select name="language" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                                <option value="">Any Language</option>
                                <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English
                                </option>
                                <option value="Swahili" {{ request('language') == 'Swahili' ? 'selected' : '' }}>Swahili
                                </option>
                                <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                                <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                <option value="German" {{ request('language') == 'German' ? 'selected' : '' }}>German</option>
                            </select>

                            <button type="submit"
                                class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">
                                Update Results
                            </button>
                        </div>
                    </form>
                </aside>

                <!-- Candidates Results -->
                <main class="flex-1">
                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900italic">
                            {{ $candidates->total() }} Candidates Found
                        </h2>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500 font-bold italic">Sort by:</span>
                            <select
                                class="text-sm border-none bg-transparent font-medium text-gray-900 focus:ring-0 cursor-pointer">
                                <option>Newest</option>
                                <option>Experience</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($candidates as $candidate)
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
                                <div class="p-5">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            @if($candidate->candidateProfile && $candidate->candidateProfile->profile_picture)
                                                <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                                    alt="{{ $candidate->name }}"
                                                    class="w-14 h-14 rounded-full object-cover border-2 border-blue-50">
                                            @else
                                                <div
                                                    class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-bold border-2 border-blue-50">
                                                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <h3 class="text-base font-bold text-gray-900 leading-tight">
                                                    @php
                                                        $nameParts = explode(' ', $candidate->name);
                                                        $firstName = $nameParts[0];
                                                        $lastNameInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '';
                                                    @endphp
                                                    {{ $firstName }} {{ $lastNameInitial }}
                                                </h3>
                                                @if($candidate->candidateProfile->title)
                                                    <p class="text-xs font-semibold text-blue-600 mb-0.5">
                                                        {{ is_array($candidate->candidateProfile->title) ? implode(', ', $candidate->candidateProfile->title) : $candidate->candidateProfile->title }}</p>
                                                @endif
                                                <p class="text-[10px] text-gray-500 italic">
                                                    From: {{ $candidate->country ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            @if($candidate->candidateProfile && $candidate->candidateProfile->is_available)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-50 text-green-700">
                                                    Available
                                                </span>
                                            @endif
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700">
                                                ✓ Verified
                                            </span>
                                        </div>
                                    </div>

                                    @if($candidate->candidateProfile->headline)
                                        <p class="text-[10px] text-gray-500 font-bold mb-1 italic">
                                            "{{ $candidate->candidateProfile->headline }}"
                                        </p>
                                    @endif

                                    @if($candidate->candidateProfile->description)
                                        <p class="text-xs text-gray-600 mb-4 line-clamp-3 italic leading-relaxed">
                                            {{ Str::limit(strip_tags($candidate->candidateProfile->description), 250) }}
                                        </p>
                                    @endif

                                    <div class="space-y-3 mb-5">
                                        <div class="grid grid-cols-2 gap-y-2 mb-4">
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                                {{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'N/A')) }}
                                            </div>
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $candidate->candidateProfile->years_of_experience ?? 0 }} Years Exp.
                                            </div>
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ ucfirst($candidate->candidateProfile->gender ?? 'N/A') }}
                                                @if($candidate->candidateProfile->date_of_birth)
                                                    , {{ $candidate->candidateProfile->date_of_birth->age }} yrs
                                                @endif
                                            </div>
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5h12M9 3v2m1.048 9.583a9.992 9.992 0 01-4.735-3.513M9 11c1.233 0 2.391-.308 3.4-.849L12 9s-1.108 1.99-3 1.99s-3-1.99-3-1.99l1.4-.849M12 9c.121 0 .241-.01.36-.03M12 9a9.991 9.991 0 013 1.99" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 21l-4.743-4.743L3 12l4.257-4.257L12 3l4.743 4.743L21 12l-4.257 4.257L12 21z" />
                                                </svg>
                                                @if($candidate->candidateProfile->languages->count() > 0)
                                                    {{ $candidate->candidateProfile->languages->pluck('name')->implode(', ') }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                            @if($candidate->candidateProfile && $candidate->candidateProfile->target_destination)
                                                <div class="flex items-center text-xs text-gray-600 col-span-2">
                                                    <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400 font-bold" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Destination: {{ $candidate->candidateProfile->target_destination }}
                                                </div>
                                            @endif
                                            <div class="flex items-center text-xs text-gray-600 col-span-2">
                                                <svg class="h-3.5 w-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Location:
                                                {{ $candidate->candidateProfile->location ?? ($candidate->country ?? 'N/A') }}
                                            </div>
                                        </div>

                                        @if($candidate->candidateProfile && $candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                            <div class="flex flex-wrap gap-1.5 pt-1">
                                                @foreach($candidate->candidateProfile->skills->take(4) as $skill)
                                                    <span
                                                        class="inline-block bg-gray-50 text-gray-600 px-2 py-1 text-[10px] rounded border border-gray-100">
                                                        {{ is_object($skill) ? $skill->name : $skill }}
                                                    </span>
                                                @endforeach
                                                @if($candidate->candidateProfile->skills->count() > 4)
                                                    <span
                                                        class="text-[9px] text-gray-400 flex items-center">+{{ $candidate->candidateProfile->skills->count() - 4 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 mt-auto">
                                        <a href="{{ route('employer.candidates.show', $candidate) }}"
                                            class="flex-1 py-2.5 px-4 text-center rounded-lg border border-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition-colors">
                                            View Profile
                                        </a>
                                        <a href="{{ route('employer.interviews.create', $candidate) }}"
                                            class="flex-1 py-2.5 px-4 text-center rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-sm transition-all active:scale-95">
                                            Interview
                                        </a>
                                    </div>
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
                                <p class="text-gray-500 mt-1 italic">Try broadening your search criteria.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $candidates->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection