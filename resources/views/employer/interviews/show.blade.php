@extends('layouts.app')

@section('title', 'Interview Details - Employer')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('employer.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('employer.interviews.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Interviews</a>
            </div>

            <!-- Status Banner -->
            @if($appointment->status == 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Pending Admin Approval</h3>
                            <p class="mt-1 text-sm text-yellow-700">This interview request is waiting for admin review. You will be notified once it's approved.</p>
                        </div>
                    </div>
                </div>
            @elseif($appointment->status == 'confirmed')
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Interview Confirmed!</h3>
                            <p class="mt-1 text-sm text-green-700">This interview has been confirmed. Both you and the candidate have been notified.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Interview Details Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <!-- Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $appointment->title ?? 'Interview Request' }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">Request ID: #{{ $appointment->id }}</p>
                            <p class="mt-1 text-xs text-gray-500">Submitted on {{ $appointment->created_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full shadow-sm
                                {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                   ($appointment->status == 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                                   ($appointment->status == 'completed' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-red-100 text-red-800 border border-red-200')) }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="border-t border-gray-200">
                    <dl class="divide-y divide-gray-200">
                        <!-- Candidate Information -->
                        <div class="bg-gray-50 px-6 py-4">
                            <h4 class="text-base font-semibold text-gray-900">Candidate Information</h4>
                        </div>

                        <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Candidate Name
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-medium">
                                <a href="{{ route('employer.candidates.show', $appointment->user) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $appointment->user->name }}
                                </a>
                            </dd>
                        </div>

                        <!-- Company/Employer Details -->
                        @if($appointment->company_name || $appointment->job_title || $appointment->interviewer_email)
                            <div class="bg-gray-50 px-6 py-4">
                                <h4 class="text-base font-semibold text-gray-900">Company & Interviewer Details</h4>
                            </div>

                            @if($appointment->company_name)
                                <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-medium">{{ $appointment->company_name }}</dd>
                                </div>
                            @endif

                            @if($appointment->job_title)
                                <div class="bg-gray-50 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Your Position</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $appointment->job_title }}</dd>
                                </div>
                            @endif

                            @if($appointment->interviewer_email)
                                <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Contact Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <a href="mailto:{{ $appointment->interviewer_email }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $appointment->interviewer_email }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                        @endif

                        <!-- Interview Schedule -->
                        <div class="bg-gray-50 px-6 py-4 mt-4">
                            <h4 class="text-base font-semibold text-gray-900">Interview Schedule</h4>
                        </div>

                        <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                Scheduled Date & Time
                            </dt>
                            <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                <span class="text-base font-semibold text-indigo-600">
                                    {{ $appointment->scheduled_at ? $appointment->scheduled_at->format('l, F j, Y \a\t g:i A') : 'Not scheduled' }}
                                </span>
                            </dd>
                        </div>

                        <div class="bg-gray-50 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Duration
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-medium">{{ $appointment->duration_minutes }} minutes</dd>
                        </div>

                        <!-- Meeting Method -->
                        <div class="bg-gray-50 px-6 py-4 mt-4">
                            <h4 class="text-base font-semibold text-gray-900">Meeting Details</h4>
                        </div>

                        <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Interview Method</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $appointment->meeting_mode == 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    @if($appointment->meeting_mode == 'online')
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Online Meeting
                                    @else
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        In-Person Meeting
                                    @endif
                                </span>
                            </dd>
                        </div>

                        @if($appointment->meeting_link)
                            <div class="bg-gray-50 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Meeting Link</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium">
                                        {{ $appointment->meeting_link }}
                                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
                                            <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                                        </svg>
                                    </a>
                                </dd>
                            </div>
                        @endif

                        @if($appointment->meeting_location)
                            <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Meeting Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-medium">{{ $appointment->meeting_location }}</dd>
                            </div>
                        @endif

                        <!-- Additional Information -->
                        @if($appointment->requirements || $appointment->notes)
                            <div class="bg-gray-50 px-6 py-4 mt-4">
                                <h4 class="text-base font-semibold text-gray-900">Additional Information</h4>
                            </div>

                            @if($appointment->requirements)
                                <div class="bg-white px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Candidate Requirements</dt>
                                    <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-2 whitespace-pre-line">{{ $appointment->requirements }}</dd>
                                </div>
                            @endif

                            @if($appointment->notes)
                                <div class="bg-gray-50 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Additional Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-2 whitespace-pre-line">{{ $appointment->notes }}</dd>
                                </div>
                            @endif
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection