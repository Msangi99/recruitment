@extends('layouts.app')

@section('title', 'Candidate Dashboard')
@section('page_label', 'Candidate')

@include('candidate.partials.nav')

@section('content')
<div class="space-y-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i data-lucide="files" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total Applications</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $stats['total_applications'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <i data-lucide="clock-3" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Pending</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $stats['pending_applications'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Shortlisted</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $stats['shortlisted_applications'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <i data-lucide="user-check" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Profile Status</p>
                        <p class="text-xl font-semibold text-slate-900">
                            @if($stats['profile_verified'])
                                <span class="text-emerald-600">Verified</span>
                            @elseif($stats['profile_complete'])
                                <span class="text-amber-600">Pending</span>
                            @else
                                <span class="text-rose-600">Incomplete</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$stats['profile_complete'])
        <div class="rounded-2xl border border-amber-100 bg-amber-50 px-6 py-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                    <i data-lucide="alert-circle" class="h-5 w-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-amber-800">Complete Your Profile</h3>
                    <p class="mt-1 text-sm text-amber-700">You need to complete your profile before applying to jobs. <a href="{{ route('candidate.profile.create') }}" class="font-semibold underline">Start here</a></p>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Applications -->
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="px-6 py-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Recent Applications</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        <strong>Pending:</strong> Waiting for review • 
                        <strong>Shortlisted:</strong> Under consideration • 
                        <strong>Interview:</strong> Interview scheduled • 
                        <strong>Offered:</strong> Job offer received
                    </p>
                </div>
                <a href="{{ route('candidate.applications.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
            </div>
            @if($recentApplications->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Job</th>
                                <th class="px-6 py-3 text-left font-semibold">Company</th>
                                <th class="px-6 py-3 text-left font-semibold">Status</th>
                                <th class="px-6 py-3 text-left font-semibold">Applied</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentApplications as $application)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 font-semibold text-blue-700">
                                        <a href="{{ route('candidate.applications.show', $application) }}" class="hover:underline">{{ $application->job->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-slate-800">{{ $application->job->company_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $application->status == 'offered' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 
                                               ($application->status == 'interview' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-100' : 
                                               ($application->status == 'shortlisted' ? 'bg-purple-50 text-purple-700 ring-1 ring-purple-100' : 
                                               ($application->status == 'rejected' ? 'bg-rose-50 text-rose-700 ring-1 ring-rose-100' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-100'))) }}"
                                            title="{{ $application->status == 'pending' ? 'Waiting for employer to review your application' : '' }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $application->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-500">No applications yet. <a href="{{ route('candidate.jobs.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Browse jobs</a></p>
            @endif
        </div>
    </div>

    <!-- Upcoming Appointments -->
    @if($upcomingAppointments->count() > 0)
        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="px-6 py-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Upcoming Appointments</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Type</th>
                                <th class="px-6 py-3 text-left font-semibold">Scheduled</th>
                                <th class="px-6 py-3 text-left font-semibold">Meeting Link</th>
                                <th class="px-6 py-3 text-left font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($upcomingAppointments as $appointment)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 text-slate-800">{{ ucfirst($appointment->appointment_type) }}</td>
                                    <td class="px-6 py-4 text-slate-800">{{ $appointment->scheduled_at->format('M d, Y h:i A') }}</td>
                                    <td class="px-6 py-4">
                                        @if($appointment->meeting_link)
                                            <a href="{{ $appointment->meeting_link }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold underline">Join Meeting</a>
                                        @else
                                            <span class="text-slate-400">Not available</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection