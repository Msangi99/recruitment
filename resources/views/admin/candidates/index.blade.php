@extends('layouts.admin')

@section('title', 'Candidates')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-900">Candidates</h2>

            <form method="GET" action="{{ route('admin.candidates.index') }}" class="flex flex-wrap gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 w-full md:w-48 shadow-sm text-sm">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>

                <input type="text" name="job_title" value="{{ request('job_title') }}" placeholder="Job Title"
                    class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white text-sm w-full md:w-40">

                <select name="experience_level"
                    class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white text-sm">
                    <option value="">Experience</option>
                    <option value="Entry Level" {{ request('experience_level') == 'Entry Level' ? 'selected' : '' }}>Entry
                        Level</option>
                    <option value="Junior" {{ request('experience_level') == 'Junior' ? 'selected' : '' }}>Junior</option>
                    <option value="Mid-Level" {{ request('experience_level') == 'Mid-Level' ? 'selected' : '' }}>Mid-Level
                    </option>
                    <option value="Expert" {{ request('experience_level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                </select>

                <select name="availability_status"
                    class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white text-sm">
                    <option value="">Availability</option>
                    <option value="Immediately Available" {{ request('availability_status') == 'Immediately Available' ? 'selected' : '' }}>Immediate</option>
                    <option value="Within 2 Weeks" {{ request('availability_status') == 'Within 2 Weeks' ? 'selected' : '' }}>
                        2 Weeks</option>
                    <option value="Within 1 Month" {{ request('availability_status') == 'Within 1 Month' ? 'selected' : '' }}>
                        1 Month</option>
                </select>

                <select name="verification_status"
                    class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white text-sm">
                    <option value="">Verification</option>
                    <option value="pending" {{ request('verification_status') == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="approved" {{ request('verification_status') == 'approved' ? 'selected' : '' }}>Approved
                    </option>
                    <option value="rejected" {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected
                    </option>
                </select>

                <select name="status"
                    class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white text-sm">
                    <option value="">Account Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit"
                    class="px-6 py-2 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm text-sm">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'job_title', 'experience_level', 'availability_status', 'verification_status', 'status']))
                    <a href="{{ route('admin.candidates.index') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors shadow-sm text-sm flex items-center">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Candidate</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Verification</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Joined
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($candidates as $candidate)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <span
                                                class="text-gray-600 font-bold text-sm">{{ substr($candidate->name, 0, 1) }}</span>
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
                                                        <span
                                                            class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                                                                {{ $candidate->candidateProfile->verification_status == 'approved' ? 'bg-green-100 text-green-700' :
                                        ($candidate->candidateProfile->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                            {{ ucfirst($candidate->candidateProfile->verification_status) }}
                                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-600">
                                            No Profile
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $candidate->is_active ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $candidate->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $candidate->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                    <a href="{{ route('admin.candidates.show', $candidate) }}"
                                        class="fb-blue hover:underline">View Details</a>
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