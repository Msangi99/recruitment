@extends('layouts.admin')

@section('title', 'Job Listings')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Job Listings</h2>
            <p class="text-sm text-gray-500">Manage all job postings across the platform</p>
        </div>
        
        <a href="{{ route('admin.jobs.create') }}" class="px-6 py-2 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm flex items-center justify-center">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Post New Job
        </a>
    </div>

    <form method="GET" action="{{ route('admin.jobs.index') }}" class="flex flex-wrap gap-2">
        <div class="relative flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or company..." 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <i data-lucide="search" class="w-5 h-5"></i>
            </div>
        </div>
        <select name="status" class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="px-6 py-2 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-colors shadow-sm">
            Filter
        </button>
    </form>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Job Information</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category & Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Apps</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Posted</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mr-3 text-blue-600 font-bold border border-blue-100">
                                        {{ substr($job->company_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">
                                            <a href="{{ route('admin.jobs.show', $job) }}" class="hover:fb-blue">{{ $job->title }}</a>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $job->company_name }} • {{ $job->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $job->category->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($job->employment_type) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $job->applications->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $job->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ $job->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="fb-blue hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.jobs.toggleStatus', $job) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-gray-900 hover:underline">
                                            {{ $job->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="briefcase" class="w-12 h-12 text-gray-300 mb-2"></i>
                                    <p>No job listings found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jobs->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
