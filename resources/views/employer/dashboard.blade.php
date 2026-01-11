@extends('layouts.app')

@section('title', 'Employer Dashboard')
@section('page_label', 'Employer')

@include('employer.partials.nav')

@section('content')
<div class="space-y-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-50 text-slate-700">
                        <i data-lucide="briefcase" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total Jobs</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $stats['total_jobs'] }}</p>
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
                        <p class="text-sm text-slate-500">Active Jobs</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $stats['active_jobs'] }}</p>
                    </div>
                </div>
            </div>
        </div>

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
                        <p class="text-sm text-slate-500">Pending Applications</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $stats['pending_applications'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Jobs -->
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="px-6 py-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Recent Jobs</h3>
                <a href="{{ route('employer.jobs.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
            </div>
            @if($recentJobs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Title</th>
                                <th class="px-6 py-3 text-left font-semibold">Applications</th>
                                <th class="px-6 py-3 text-left font-semibold">Status</th>
                                <th class="px-6 py-3 text-left font-semibold">Posted</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentJobs as $job)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 font-semibold text-blue-700">
                                        <a href="{{ route('employer.jobs.show', $job) }}" class="hover:underline">{{ $job->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-slate-800">{{ $job->applications->count() }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->is_active ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'bg-slate-50 text-slate-700 ring-1 ring-slate-100' }}">
                                            {{ $job->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $job->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-500">No jobs posted yet. <a href="{{ route('employer.jobs.create') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Post your first job</a></p>
            @endif
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="px-6 py-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Recent Applications</h3>
                <a href="{{ route('employer.jobs.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
            </div>
            @if($recentApplications->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Candidate</th>
                                <th class="px-6 py-3 text-left font-semibold">Job</th>
                                <th class="px-6 py-3 text-left font-semibold">Status</th>
                                <th class="px-6 py-3 text-left font-semibold">Applied</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentApplications as $application)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 text-slate-800">{{ $application->candidate->name }}</td>
                                    <td class="px-6 py-4 text-slate-800">{{ $application->job->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-50 text-amber-700 ring-1 ring-amber-100">
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
                <p class="text-sm text-slate-500">No applications yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection