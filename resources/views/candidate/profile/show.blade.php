@extends('layouts.app')

@section('title', 'My Profile - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">My Profile</h2>
                <div class="flex space-x-3">
                    @if(!$profile)
                        <a href="{{ route('candidate.profile.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Create Profile
                        </a>
                    @else
                        <a href="{{ route('candidate.profile.edit') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Edit Profile
                        </a>
                    @endif
                </div>
            </div>

            @if(!$profile)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
                    <p class="text-gray-700 mb-4">You haven't created your profile yet.</p>
                    <a href="{{ route('candidate.profile.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Start Creating Your Profile
                    </a>
                </div>
            @else
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $profile->verification_status == 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($profile->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($profile->verification_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Education Level</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($profile->education_level ?? 'N/A') }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $profile->years_of_experience ?? 'N/A' }} years</dd>
                            </div>
                            @if($profile->skills && $profile->skills->count() > 0)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Skills</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @foreach($profile->skills as $skill)
                                            <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm text-gray-700 mr-2 mb-2">{{ $skill->name }}</span>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                            @if($profile->languages && $profile->languages->count() > 0)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Languages</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @foreach($profile->languages as $language)
                                            <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm text-blue-700 mr-2 mb-2">{{ $language->name }}</span>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection