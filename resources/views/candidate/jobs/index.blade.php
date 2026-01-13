@extends('layouts.app')

@section('title', 'Browse Jobs - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Browse Jobs</h2>
            </div>

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="GET" action="{{ route('candidate.jobs.index') }}" class="mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <!-- Search -->
                        <div class="lg:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs, companies..." class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category (Job Category)</label>
                            <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Country -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location (Country)</label>
                            <select name="country" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Countries</option>
                                <option value="Poland" {{ request('country') == 'Poland' ? 'selected' : '' }}>Poland</option>
                                <option value="Finland" {{ request('country') == 'Finland' ? 'selected' : '' }}>Finland</option>
                                <option value="Germany" {{ request('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option value="Lithuania" {{ request('country') == 'Lithuania' ? 'selected' : '' }}>Lithuania</option>
                                <option value="UAE" {{ request('country') == 'UAE' ? 'selected' : '' }}>UAE</option>
                                <option value="Saudi Arabia" {{ request('country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                <option value="Oman" {{ request('country') == 'Oman' ? 'selected' : '' }}>Oman</option>
                                <option value="Qatar" {{ request('country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                <option value="United Arab Emirates" {{ request('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                <option value="Jordan" {{ request('country') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                                <option value="Bahrain" {{ request('country') == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                                <option value="Cyprus Republic" {{ request('country') == 'Cyprus Republic' ? 'selected' : '' }}>Cyprus Republic</option>
                                <option value="UK" {{ request('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="USA" {{ request('country') == 'USA' ? 'selected' : '' }}>USA</option>
                            </select>
                        </div>
                        
                        <!-- Job Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                            <select name="employment_type" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Types</option>
                                <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Full time</option>
                                <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Part time</option>
                                <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                        </div>
                        
                        <!-- Experience Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                            <select name="experience_level" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Experience</option>
                                <option value="no-experience" {{ request('experience_level') == 'no-experience' ? 'selected' : '' }}>No experience</option>
                                <option value="0-1" {{ request('experience_level') == '0-1' ? 'selected' : '' }}>0-1 years</option>
                                <option value="1-3" {{ request('experience_level') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                                <option value="3+" {{ request('experience_level') == '3+' ? 'selected' : '' }}>3+ years</option>
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
                        
                        <!-- Language Requirement -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Language Requirement</label>
                            <select name="language" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Language</option>
                                <option value="no-requirement" {{ request('language') == 'no-requirement' ? 'selected' : '' }}>No language requirement</option>
                                <option value="Basic English" {{ request('language') == 'Basic English' ? 'selected' : '' }}>Basic English</option>
                                <option value="Intermediate English" {{ request('language') == 'Intermediate English' ? 'selected' : '' }}>Intermediate English</option>
                                <option value="Advanced English" {{ request('language') == 'Advanced English' ? 'selected' : '' }}>Advanced English</option>
                                <option value="Native/Fluent English" {{ request('language') == 'Native/Fluent English' ? 'selected' : '' }}>Native/Fluent English</option>
                            </select>
                        </div>
                        
                        <!-- Salary Period -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                            <select name="salary_period" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any Period</option>
                                <option value="hourly" {{ request('salary_period') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                <option value="daily" {{ request('salary_period') == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ request('salary_period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ request('salary_period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ request('salary_period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </div>
                        
                        <!-- Min Salary -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary</label>
                            <input type="number" name="min_salary" value="{{ request('min_salary') }}" placeholder="0" min="0" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Max Salary -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary</label>
                            <input type="number" name="max_salary" value="{{ request('max_salary') }}" placeholder="No limit" min="0" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <!-- Date Posted -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Posted</label>
                            <select name="date_posted" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Anytime</option>
                                <option value="24-hours" {{ request('date_posted') == '24-hours' ? 'selected' : '' }}>Last 24 hours</option>
                                <option value="3-days" {{ request('date_posted') == '3-days' ? 'selected' : '' }}>Last 3 days</option>
                                <option value="7-days" {{ request('date_posted') == '7-days' ? 'selected' : '' }}>Last 7 days</option>
                                <option value="14-days" {{ request('date_posted') == '14-days' ? 'selected' : '' }}>Last 14 days</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('candidate.jobs.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Clear Filters</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Apply Filters</button>
                    </div>
                </div>
            </form>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('candidate.jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $job->title }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $job->company_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $job->location }}, {{ $job->country }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $job->category->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ ucfirst($job->employment_type) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $job->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(in_array($job->id, $myApplications))
                                        <span class="text-green-600">Applied</span>
                                    @else
                                        <a href="{{ route('candidate.jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No jobs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection