@extends('layouts.admin')

@section('title', 'Candidates')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-900">Candidates</h2>
        
        <form method="GET" action="{{ route('admin.candidates.index') }}" class="flex flex-wrap gap-2">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidates..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 w-full md:w-64 shadow-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
            </div>
            <select name="verification_status" class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white">
                <option value="">All Verification</option>
                <option value="pending" {{ request('verification_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('verification_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="px-6 py-2 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm">
                Filter
            </button>
        </form>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Verification</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($candidates as $candidate)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <span class="text-gray-600 font-bold text-sm">{{ substr($candidate->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $candidate->name }}</div>
                                        <div class="text-xs text-gray-500">ID: #{{ $candidate->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="text-gray-900 font-medium">{{ $candidate->email }}</div>
                                <div class="text-gray-500">{{ $candidate->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($candidate->candidateProfile)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                        {{ $candidate->candidateProfile->verification_status == 'approved' ? 'bg-green-100 text-green-700' : 
                                           ($candidate->candidateProfile->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($candidate->candidateProfile->verification_status) }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-600">
                                        No Profile
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $candidate->is_active ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $candidate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $candidate->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                <a href="{{ route('admin.candidates.show', $candidate) }}" class="fb-blue hover:underline">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="users-2" class="w-12 h-12 text-gray-300 mb-2"></i>
                                    <p>No candidates found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($candidates->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $candidates->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
