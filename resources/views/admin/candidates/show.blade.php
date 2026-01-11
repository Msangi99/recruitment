@extends('layouts.admin')

@section('title', 'Candidate Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('admin.candidates.index') }}" class="hover:fb-blue flex items-center font-medium">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
            Back to Candidates
        </a>
    </div>

    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center">
                    <div class="h-20 w-20 rounded-full bg-blue-50 flex items-center justify-center border-2 border-white shadow-md ring-4 ring-blue-50">
                        <span class="text-3xl font-bold text-blue-600">{{ substr($candidate->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $candidate->name }}</h2>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i data-lucide="mail" class="w-4 h-4 mr-1"></i>
                            <span class="text-sm font-medium">{{ $candidate->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.candidates.updateStatus', $candidate) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_active" value="{{ $candidate->is_active ? 0 : 1 }}">
                        <button type="submit" class="px-6 py-2 rounded-xl font-bold transition-all shadow-sm flex items-center
                            {{ $candidate->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                            <i data-lucide="{{ $candidate->is_active ? 'user-minus' : 'user-check' }}" class="w-4 h-4 mr-2"></i>
                            {{ $candidate->is_active ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex items-center justify-between">
            <div class="flex space-x-6 text-sm">
                <span class="flex items-center text-gray-600"><i data-lucide="calendar" class="w-4 h-4 mr-1.5 text-gray-400"></i> Joined {{ $candidate->created_at->format('M d, Y') }}</span>
                <span class="flex items-center text-gray-600"><i data-lucide="map-pin" class="w-4 h-4 mr-1.5 text-gray-400"></i> {{ $candidate->country ?? 'No country' }}</span>
                <span class="flex items-center text-gray-600"><i data-lucide="phone" class="w-4 h-4 mr-1.5 text-gray-400"></i> {{ $candidate->phone ?? 'No phone' }}</span>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $candidate->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $candidate->is_active ? 'ACTIVE' : 'INACTIVE' }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Profile Details -->
        <div class="lg:col-span-2 space-y-6">
            @if($candidate->candidateProfile)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 flex items-center">
                            <i data-lucide="user" class="w-5 h-5 mr-2 fb-blue"></i>
                            Professional Profile
                        </h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Education Level</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $candidate->candidateProfile->education_level ?? 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Years of Experience</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $candidate->candidateProfile->years_of_experience ?? '0' }} years</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Verification Status</dt>
                                <dd class="mt-1">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        {{ $candidate->candidateProfile->verification_status == 'approved' ? 'bg-green-100 text-green-700' : 
                                           ($candidate->candidateProfile->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ strtoupper($candidate->candidateProfile->verification_status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Skills</dt>
                                <dd class="flex flex-wrap gap-2">
                                    @if($candidate->candidateProfile->skills)
                                        @foreach($candidate->candidateProfile->skills as $skill)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-bold border border-gray-200">{{ $skill }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-500 italic">No skills listed</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Documents -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i data-lucide="file-text" class="w-5 h-5 mr-2 fb-blue"></i>
                        Uploaded Documents
                    </h3>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-gray-100">
                        @forelse($candidate->documents as $document)
                            <li class="px-6 py-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-2 bg-gray-100 rounded-lg mr-4">
                                        <i data-lucide="file" class="w-5 h-5 text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ ucfirst($document->document_type) }}</p>
                                        <p class="text-xs text-gray-500">{{ $document->file_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full 
                                        {{ $document->verification_status == 'approved' ? 'bg-green-100 text-green-700' : 
                                           ($document->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ strtoupper($document->verification_status) }}
                                    </span>
                                    <a href="#" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-8 text-center text-gray-500 italic">No documents uploaded</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-6">
                <h3 class="font-bold text-gray-900 mb-4">Account Summary</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">User ID</span>
                        <span class="text-sm font-bold text-gray-900">#{{ $candidate->id }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Total Applications</span>
                        <span class="text-sm font-bold text-gray-900">{{ $candidate->jobApplications->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Appointments</span>
                        <span class="text-sm font-bold text-gray-900">{{ $candidate->appointments->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-500">Role</span>
                        <span class="text-sm font-bold fb-blue">CANDIDATE</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
