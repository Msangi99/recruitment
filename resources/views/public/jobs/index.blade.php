<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs - Coyzon Recruitment</title>
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
                    <a href="{{ route('public.jobs.index') }}" class="text-blue-600 font-medium">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium">Book Appointment</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 font-medium">Contact
                        Us</a>
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Browse Available Jobs</h2>
                <p class="mt-2 text-gray-600">Find your next opportunity abroad. Register or login to apply.</p>
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

            <form method="GET" action="{{ route('public.jobs.index') }}" class="mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <!-- Search -->
                        <div class="lg:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search jobs, companies..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Country -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location (Country)</label>
                            <select name="country"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Countries</option>
                                <option value="Poland" {{ request('country') == 'Poland' ? 'selected' : '' }}>Poland
                                </option>
                                <option value="Finland" {{ request('country') == 'Finland' ? 'selected' : '' }}>Finland
                                </option>
                                <option value="Germany" {{ request('country') == 'Germany' ? 'selected' : '' }}>Germany
                                </option>
                                <option value="Lithuania" {{ request('country') == 'Lithuania' ? 'selected' : '' }}>
                                    Lithuania</option>
                                <option value="UAE" {{ request('country') == 'UAE' ? 'selected' : '' }}>UAE</option>
                                <option value="Saudi Arabia" {{ request('country') == 'Saudi Arabia' ? 'selected' : '' }}>
                                    Saudi Arabia</option>
                                <option value="Oman" {{ request('country') == 'Oman' ? 'selected' : '' }}>Oman</option>
                                <option value="Qatar" {{ request('country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                <option value="United Arab Emirates" {{ request('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                <option value="Jordan" {{ request('country') == 'Jordan' ? 'selected' : '' }}>Jordan
                                </option>
                                <option value="Bahrain" {{ request('country') == 'Bahrain' ? 'selected' : '' }}>Bahrain
                                </option>
                                <option value="Cyprus Republic" {{ request('country') == 'Cyprus Republic' ? 'selected' : '' }}>Cyprus Republic</option>
                                <option value="UK" {{ request('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="USA" {{ request('country') == 'USA' ? 'selected' : '' }}>USA</option>
                            </select>
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                            <select name="employment_type"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Types</option>
                                <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Full time</option>
                                <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                    Contract</option>
                                <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Part time</option>
                                <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                        </div>

                        <!-- Experience Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                            <select name="experience_level"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Any Experience</option>
                                <option value="no-experience" {{ request('experience_level') == 'no-experience' ? 'selected' : '' }}>No experience</option>
                                <option value="0-1" {{ request('experience_level') == '0-1' ? 'selected' : '' }}>0-1 years
                                </option>
                                <option value="1-3" {{ request('experience_level') == '1-3' ? 'selected' : '' }}>1-3 years
                                </option>
                                <option value="3+" {{ request('experience_level') == '3+' ? 'selected' : '' }}>3+ years
                                </option>
                            </select>
                        </div>

                        <!-- Education Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Education Level</label>
                            <select name="education_level"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Any Education</option>
                                <option value="no-formal-education" {{ request('education_level') == 'no-formal-education' ? 'selected' : '' }}>No formal education</option>
                                <option value="secondary-education" {{ request('education_level') == 'secondary-education' ? 'selected' : '' }}>Secondary education</option>
                                <option value="vocational-training" {{ request('education_level') == 'vocational-training' ? 'selected' : '' }}>Vocational training</option>
                                <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>
                                    Diploma</option>
                                <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>
                                    Bachelor's Degree</option>
                                <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>
                                    Master's Degree</option>
                                <option value="phd" {{ request('education_level') == 'phd' ? 'selected' : '' }}>PhD
                                </option>
                            </select>
                        </div>

                        <!-- Date Posted -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Posted</label>
                            <select name="date_posted"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Anytime</option>
                                <option value="24-hours" {{ request('date_posted') == '24-hours' ? 'selected' : '' }}>Last
                                    24 hours</option>
                                <option value="3-days" {{ request('date_posted') == '3-days' ? 'selected' : '' }}>Last 3
                                    days</option>
                                <option value="7-days" {{ request('date_posted') == '7-days' ? 'selected' : '' }}>Last 7
                                    days</option>
                                <option value="14-days" {{ request('date_posted') == '14-days' ? 'selected' : '' }}>Last
                                    14 days</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('public.jobs.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Clear
                            Filters</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Apply Filters</button>
                    </div>
                </div>
            </form>

            <div class="space-y-4">
                @forelse($jobs as $job)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all relative">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                    <a href="{{ route('public.jobs.show', $job) }}"
                                        class="hover:text-blue-600 transition-colors">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <p class="text-blue-600 font-medium">{{ $job->company_name }}</p>
                            </div>
                            @if($job->is_active)
                                <span class="bg-[#3B82F6] text-white text-[10px] font-bold px-3 py-1 rounded uppercase tracking-wider shadow-sm">Featured</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-900 font-bold">
                                @if($job->salary_min && $job->salary_max)
                                    {{ $job->salary_currency }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                    <span class="text-gray-400 font-normal text-sm ml-1">per {{ $job->salary_period }}</span>
                                @else
                                    <span class="text-gray-900">Negotiable</span>
                                @endif
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3 mb-4">
                            <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-50 flex-1 min-w-[140px]">
                                <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">EMPLOYMENT TYPE</p>
                                <p class="text-sm font-bold text-gray-700">{{ ucfirst($job->employment_type) }}</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-50 flex-1 min-w-[140px]">
                                <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">MINIMUM WORK EXPERIENCE</p>
                                <p class="text-sm font-bold text-gray-700">{{ $job->experience_required }}-{{ $job->experience_required + 1 }} Years</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-50 flex-1 min-w-[140px]">
                                <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">MINIMUM EDUCATION LEVEL</p>
                                <p class="text-sm font-bold text-gray-700">{{ $job->education_level ?: 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center text-gray-400 text-xs gap-4">
                            <div class="flex items-center gap-1">
                                <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $job->location }}, {{ $job->country }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-lg font-medium">No jobs found matching your criteria.</p>
                        <p class="mt-1">Try adjusting your filters or search terms.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>