@extends('layouts.app')

@section('title', 'Job Details - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Jobs</a>
            </div>

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $job->title }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $job->company_name }} • {{ $job->location }}, {{ $job->country }}</p>
                        </div>
                        @if($hasApplied)
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Already Applied</span>
                        @endif
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->category->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($job->employment_type) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->description }}</dd>
                        </div>
                        @if($job->requirements)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Requirements</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->requirements }}</dd>
                            </div>
                        @endif
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->salary_range }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if(!$hasApplied && auth()->user()->candidateProfile && auth()->user()->candidateProfile->verification_status === 'approved')
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Apply for this Job</h3>
                    <form method="POST" action="{{ route('candidate.jobs.apply', $job) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Cover Letter (Optional)</label>
                            <textarea name="cover_letter" rows="5" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Tell the employer why you're a good fit..."></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Submit Application
                        </button>
                    </form>
                </div>
            @elseif(!auth()->user()->candidateProfile || auth()->user()->candidateProfile->verification_status !== 'approved')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <p class="text-yellow-800">
                        <strong>Profile Verification Required:</strong> Your profile must be verified before applying to jobs. 
                        <a href="{{ route('candidate.profile.create') }}" class="underline">Complete your profile</a> and wait for admin verification.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection