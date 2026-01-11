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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Interview Request Details</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">ID: {{ $appointment->id }}</p>
                        </div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-800' : 
                               ($appointment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($appointment->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Candidate</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $appointment->user->name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Scheduled Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y h:i A') : 'Not scheduled' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Meeting Mode</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($appointment->meeting_mode) }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $appointment->duration_minutes }} minutes</dd>
                        </div>
                        @if($appointment->meeting_link)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Meeting Link</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ $appointment->meeting_link }}</a>
                                </dd>
                            </div>
                        @endif
                        @if($appointment->meeting_location)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Meeting Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $appointment->meeting_location }}</dd>
                            </div>
                        @endif
                        @if($appointment->notes)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $appointment->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection