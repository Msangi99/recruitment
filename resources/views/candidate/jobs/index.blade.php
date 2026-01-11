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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}" placeholder="City, Country" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Education Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Education Level</label>
                            <select name="education_level" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any</option>
                                <option value="high-school" {{ request('education_level') == 'high-school' ? 'selected' : '' }}>High School</option>
                                <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                <option value="phd" {{ request('education_level') == 'phd' ? 'selected' : '' }}>PhD</option>
                            </select>
                        </div>
                        
                        <!-- Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Experience (Years)</label>
                            <input type="number" name="min_experience" value="{{ request('min_experience') }}" placeholder="0" min="0" max="50" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <!-- Language -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                            <select name="language" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Any</option>
                                <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Swahili" {{ request('language') == 'Swahili' ? 'selected' : '' }}>Swahili</option>
                                <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                                <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                <option value="Spanish" {{ request('language') == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                            </select>
                        </div>
                        
                        <!-- Salary Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary</label>
                            <input type="number" name="min_salary" value="{{ request('min_salary') }}" placeholder="0" min="0" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary</label>
                            <input type="number" name="max_salary" value="{{ request('max_salary') }}" placeholder="No limit" min="0" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('candidate.jobs.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Clear</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
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