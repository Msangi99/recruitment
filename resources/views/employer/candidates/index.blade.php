@extends('layouts.app')

@section('title', 'Browse Candidates - Employer')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('employer.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Browse Verified Candidates</h2>
                <p class="mt-1 text-sm text-gray-500">Only verified candidates are shown. Contact details are hidden for privacy.</p>
            </div>

            <form method="GET" action="{{ route('employer.candidates.index') }}" class="mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <!-- Search -->
                        <div class="lg:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, skills, destination..." class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Country (Candidate's Location) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location (Candidate Country)</label>
                            <select name="country" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Countries</option>
                                <option value="Tanzania" {{ request('country') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                <option value="Kenya" {{ request('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                <option value="Uganda" {{ request('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                <option value="Rwanda" {{ request('country') == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                                <option value="Burundi" {{ request('country') == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                                <option value="Ethiopia" {{ request('country') == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                                <option value="Other" {{ request('country') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <!-- Target Destination -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Target Destination</label>
                            <select name="target_destination" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Destination</option>
                                <option value="Poland" {{ request('target_destination') == 'Poland' ? 'selected' : '' }}>Poland</option>
                                <option value="Finland" {{ request('target_destination') == 'Finland' ? 'selected' : '' }}>Finland</option>
                                <option value="Germany" {{ request('target_destination') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option value="UAE" {{ request('target_destination') == 'UAE' ? 'selected' : '' }}>UAE</option>
                                <option value="Saudi Arabia" {{ request('target_destination') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                <option value="Qatar" {{ request('target_destination') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                <option value="UK" {{ request('target_destination') == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="USA" {{ request('target_destination') == 'USA' ? 'selected' : '' }}>USA</option>
                            </select>
                        </div>
                        
                        <!-- Education Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Education Level</label>
                            <select name="education_level" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Education</option>
                                <option value="no-formal-education" {{ request('education_level') == 'no-formal-education' ? 'selected' : '' }}>No formal education</option>
                                <option value="secondary-education" {{ request('education_level') == 'secondary-education' ? 'selected' : '' }}>Secondary education</option>
                                <option value="vocational-training" {{ request('education_level') == 'vocational-training' ? 'selected' : '' }}>Vocational training</option>
                                <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                <option value="phd" {{ request('education_level') == 'phd' ? 'selected' : '' }}>PhD</option>
                            </select>
                        </div>
                        
                        <!-- Language Spoken -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Language Spoken</label>
                            <select name="language" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Language</option>
                                <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Swahili" {{ request('language') == 'Swahili' ? 'selected' : '' }}>Swahili</option>
                                <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                                <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                <option value="German" {{ request('language') == 'German' ? 'selected' : '' }}>German</option>
                                <option value="Spanish" {{ request('language') == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                <option value="Polish" {{ request('language') == 'Polish' ? 'selected' : '' }}>Polish</option>
                            </select>
                        </div>
                        
                        <!-- Min Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Experience (Years)</label>
                            <input type="number" name="min_experience" value="{{ request('min_experience') }}" placeholder="0" min="0" max="50" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Max Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Experience (Years)</label>
                            <input type="number" name="max_experience" value="{{ request('max_experience') }}" placeholder="No limit" min="0" max="50" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Availability Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Availability Status</label>
                            <select name="availability" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Status</option>
                                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>
                        
                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Gender</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <!-- Min Age -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Age</label>
                            <input type="number" name="min_age" value="{{ request('min_age') }}" placeholder="18" min="18" max="100" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Max Age -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Age</label>
                            <input type="number" name="max_age" value="{{ request('max_age') }}" placeholder="65" min="18" max="100" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('employer.candidates.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Clear Filters</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Apply Filters</button>
                    </div>
                </div>
            </form>

            <!-- Candidate Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($candidates as $candidate)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden">
                        <!-- Profile Header -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($candidate->candidateProfile && $candidate->candidateProfile->profile_picture)
                                        <img src="{{ asset($candidate->candidateProfile->profile_picture) }}" alt="{{ $candidate->name }}" class="h-16 w-16 rounded-full object-cover border-2 border-blue-100">
                                    @else
                                        <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-2 border-blue-100">
                                            <span class="text-white font-bold text-xl">{{ substr($candidate->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $candidate->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $candidate->country ?? 'N/A' }}</p>
                                    @if($candidate->candidateProfile && $candidate->candidateProfile->is_available)
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">Available</span>
                                    @else
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">Not Available</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="p-6 space-y-3">
                            <!-- Education -->
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500">Education</p>
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'N/A')) }}</p>
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500">Work Experience</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $candidate->candidateProfile->years_of_experience ?? '0' }} years</p>
                                </div>
                            </div>

                            <!-- Skills -->
                            @if($candidate->candidateProfile && $candidate->candidateProfile->skills)
                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Skills</p>
                                    <div class="flex flex-wrap gap-1">
                                        @php
                                            $skills = $candidate->candidateProfile->skills;
                                            $skillsCollection = is_array($skills) ? collect($skills) : $skills;
                                        @endphp
                                        @foreach($skillsCollection->take(4) as $skill)
                                            <span class="inline-block bg-blue-50 text-blue-700 px-2 py-1 text-xs rounded-full">{{ is_object($skill) ? $skill->name : $skill }}</span>
                                        @endforeach
                                        @if(count($skillsCollection) > 4)
                                            <span class="inline-block text-xs text-gray-500 px-2 py-1">+{{ count($skillsCollection) - 4 }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Languages -->
                            @if($candidate->candidateProfile && $candidate->candidateProfile->languages)
                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Languages</p>
                                    <div class="flex flex-wrap gap-1">
                                        @php
                                            $languages = $candidate->candidateProfile->languages;
                                            $languagesCollection = is_array($languages) ? collect($languages) : $languages;
                                        @endphp
                                        @foreach($languagesCollection->take(3) as $language)
                                            <span class="inline-block bg-green-50 text-green-700 px-2 py-1 text-xs rounded-full">{{ is_object($language) ? $language->name : $language }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Target Destination -->
                            @if($candidate->candidateProfile && $candidate->candidateProfile->target_destination)
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-500">Target Destination</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $candidate->candidateProfile->target_destination }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-2">
                            <a href="{{ route('employer.candidates.show', $candidate) }}" class="flex-1 text-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                View Profile
                            </a>
                            <a href="{{ route('employer.interviews.create', $candidate) }}" class="flex-1 text-center px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 transition-colors">
                                Request Interview
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12 bg-white rounded-lg shadow">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No candidates found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters to find candidates.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $candidates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection