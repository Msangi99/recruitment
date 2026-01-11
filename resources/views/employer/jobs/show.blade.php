@extends('layouts.app')

@section('title', 'Job Details - Employer')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('employer.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('employer.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Jobs</a>
                <div class="flex space-x-2">
                    <a href="{{ route('employer.jobs.edit', $job) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Edit</a>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $job->title }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $job->company_name }} • {{ $job->location }}, {{ $job->country }}</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->category->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->description }}</dd>
                        </div>
                        @if($job->requirements)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Requirements</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->requirements }}</dd>
                            </div>
                        @endif
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($job->applications->count() > 0)
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Applications ({{ $job->applications->count() }})</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($job->applications as $application)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->candidate->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $application->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button onclick="showApplicationDetails({{ $application->id }})" class="text-indigo-600 hover:text-indigo-900">View Details</button>
                                                <a href="{{ route('employer.candidates.show', $application->candidate) }}" class="text-green-600 hover:text-green-900">Profile</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Application Details Row (Hidden by default) -->
                                    <tr id="application-{{ $application->id }}" class="hidden">
                                        <td colspan="4" class="px-6 py-4 bg-gray-50">
                                            <div class="space-y-4">
                                                @if($application->cover_letter)
                                                    <div>
                                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Cover Letter:</h4>
                                                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                                                    </div>
                                                @endif
                                                @if($application->video_path)
                                                    <div>
                                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Application Video:</h4>
                                                        <video controls class="w-full max-w-2xl rounded-lg shadow-md">
                                                            <source src="{{ asset($application->video_path) }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                @endif
                                                @if(!$application->cover_letter && !$application->video_path)
                                                    <p class="text-sm text-gray-500 italic">No additional details provided.</p>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function showApplicationDetails(applicationId) {
    const row = document.getElementById('application-' + applicationId);
    if (row.classList.contains('hidden')) {
        row.classList.remove('hidden');
    } else {
        row.classList.add('hidden');
    }
}
</script>
@endsection