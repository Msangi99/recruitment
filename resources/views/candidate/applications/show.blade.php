@extends('layouts.app')

@section('title', 'Application Details - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.applications.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Applications</a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $application->job->title }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $application->job->company_name }} • {{ $application->job->location }}</p>
                        </div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $application->status == 'offered' ? 'bg-green-100 text-green-800' : 
                               ($application->status == 'interview' ? 'bg-blue-100 text-blue-800' : 
                               ($application->status == 'shortlisted' ? 'bg-purple-100 text-purple-800' : 
                               ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'))) }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Job Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $application->job->description }}</dd>
                        </div>
                        @if($application->cover_letter)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Your Cover Letter</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $application->cover_letter }}</dd>
                            </div>
                        @endif
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Applied Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $application->created_at->format('M d, Y h:i A') }}</dd>
                        </div>
                        @if($application->reviewed_at)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Reviewed Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $application->reviewed_at->format('M d, Y h:i A') }}</dd>
                            </div>
                        @endif
                        @if($application->status == 'pending')
                            <div class="bg-blue-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-blue-500">Status Information</dt>
                                <dd class="mt-1 text-sm text-blue-700 sm:mt-0 sm:col-span-2">
                                    <strong>Pending:</strong> Your application has been submitted and is waiting for the employer to review it. 
                                    You will be notified via email when the status changes.
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection