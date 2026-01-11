@extends('layouts.app')

@section('title', 'Browse Candidates - Employer')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('employer.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Browse Verified Candidates</h2>
                <p class="mt-1 text-sm text-gray-500">Only verified candidates are shown. Contact details are hidden for privacy.</p>
            </div>

            <form method="GET" action="{{ route('employer.candidates.index') }}" class="mb-4 flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or skills..." class="flex-1 rounded-md border-gray-300 shadow-sm">
                <select name="education_level" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">All Education</option>
                    <option value="high-school" {{ request('education_level') == 'high-school' ? 'selected' : '' }}>High School</option>
                    <option value="diploma" {{ request('education_level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                    <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                    <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>Master</option>
                    <option value="phd" {{ request('education_level') == 'phd' ? 'selected' : '' }}>PhD</option>
                </select>
                <select name="min_experience" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">All Experience</option>
                    <option value="0" {{ request('min_experience') == '0' ? 'selected' : '' }}>0+ years</option>
                    <option value="1" {{ request('min_experience') == '1' ? 'selected' : '' }}>1+ years</option>
                    <option value="3" {{ request('min_experience') == '3' ? 'selected' : '' }}>3+ years</option>
                    <option value="5" {{ request('min_experience') == '5' ? 'selected' : '' }}>5+ years</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Filter</button>
            </form>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Education</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skills</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($candidates as $candidate)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ substr($candidate->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $candidate->name }}</div>
                                            <div class="text-sm text-gray-500">Verified Candidate</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ ucfirst($candidate->candidateProfile->education_level ?? 'N/A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $candidate->candidateProfile->years_of_experience ?? 'N/A' }} years</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($candidate->candidateProfile && $candidate->candidateProfile->skills && $candidate->candidateProfile->skills->count() > 0)
                                            @foreach($candidate->candidateProfile->skills->take(3) as $skill)
                                                <span class="inline-block bg-gray-100 rounded-full px-2 py-1 text-xs text-gray-700 mr-1">{{ $skill->name }}</span>
                                            @endforeach
                                            @if($candidate->candidateProfile->skills->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $candidate->candidateProfile->skills->count() - 3 }} more</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $candidate->country ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('employer.candidates.show', $candidate) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('employer.interviews.create', $candidate) }}" class="text-green-600 hover:text-green-900">Request Interview</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No verified candidates found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $candidates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection