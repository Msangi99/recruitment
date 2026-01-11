@extends('layouts.app')

@section('title', 'Candidate Profile - Employer')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('employer.partials.nav')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('employer.candidates.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Candidates</a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center">
                            @if($candidate->candidateProfile && $candidate->candidateProfile->profile_picture)
                                <img src="{{ asset($candidate->candidateProfile->profile_picture) }}" alt="{{ $candidate->name }}" class="h-16 w-16 rounded-full object-cover mr-4 border-2 border-gray-200">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center mr-4 border-2 border-gray-200">
                                    <span class="text-gray-600 font-medium text-xl">{{ substr($candidate->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $candidate->name }}</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Verified Candidate</p>
                            </div>
                        </div>
                        <a href="{{ route('employer.interviews.create', $candidate) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Request Interview
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Education Level</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($candidate->candidateProfile->education_level ?? 'N/A') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Years of Experience</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $candidate->candidateProfile->years_of_experience ?? 'N/A' }} years</dd>
                        </div>
                        @php
                            $candidateSkills = $candidate->candidateProfile->skills ?? collect();
                            $candidateSkillsCollection = is_array($candidateSkills) ? collect($candidateSkills) : $candidateSkills;
                            $candidateSkillsCount = count($candidateSkillsCollection);
                            
                            $candidateLanguages = $candidate->candidateProfile->languages ?? collect();
                            $candidateLanguagesCollection = is_array($candidateLanguages) ? collect($candidateLanguages) : $candidateLanguages;
                            $candidateLanguagesCount = count($candidateLanguagesCollection);
                        @endphp
                        @if($candidate->candidateProfile && $candidateSkills && $candidateSkillsCount > 0)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Skills</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @foreach($candidateSkillsCollection as $skill)
                                        <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm text-gray-700 mr-2 mb-2">{{ is_object($skill) ? $skill->name : $skill }}</span>
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                        @if($candidate->candidateProfile && $candidateLanguages && $candidateLanguagesCount > 0)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Languages</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @foreach($candidateLanguagesCollection as $language)
                                        <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm text-blue-700 mr-2 mb-2">{{ is_object($language) ? $language->name : $language }}</span>
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $candidate->country ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Contact Information</dt>
                            <dd class="mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                                Contact details are hidden for privacy. Request an interview to connect with this candidate.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection