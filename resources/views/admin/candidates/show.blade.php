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
                    @if($candidate->candidateProfile && $candidate->candidateProfile->profile_picture)
                        <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-white shadow-md ring-4 ring-blue-50">
                            <img src="{{ asset($candidate->candidateProfile->profile_picture) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-20 w-20 rounded-full bg-blue-50 flex items-center justify-center border-2 border-white shadow-md ring-4 ring-blue-50">
                            <span class="text-3xl font-bold text-blue-600">{{ substr($candidate->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $candidate->name }}</h2>
                        <p class="text-blue-600 font-bold">{{ $candidate->candidateProfile->title ?? 'Candidate' }}</p>
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
                <span class="flex items-center text-gray-600"><i data-lucide="map-pin" class="w-4 h-4 mr-1.5 text-gray-400"></i> {{ $candidate->candidateProfile->location ?? ($candidate->country ?? 'No country') }}</span>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Headline</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $candidate->candidateProfile->headline ?? 'No headline provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Professional Summary</dt>
                                <dd class="text-sm text-gray-900 leading-relaxed">{!! $candidate->candidateProfile->description ?? 'No description provided' !!}</dd>
                            </div>
                        </div>

                        @if($candidate->candidateProfile->video_cv)
                            <div class="mb-8">
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Video CV</dt>
                                <dd>
                                    <div class="w-full max-w-lg">
                                        <video controls class="w-full h-48 rounded-lg shadow-lg border border-gray-200 bg-black object-cover">
                                            <source src="{{ asset($candidate->candidateProfile->video_cv) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </dd>
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <div>
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Relocation</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    {{ $candidate->candidateProfile->willing_to_relocate ? '✅ Willing to work abroad' : '❌ Local only' }}
                                </dd>
                                @if($candidate->candidateProfile->preferred_destinations)
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($candidate->candidateProfile->preferred_destinations as $dest)
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded border border-blue-100">{{ $dest }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Availability</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 rounded-full mr-2 {{ $candidate->candidateProfile->is_available ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $candidate->candidateProfile->availability_status ?? ($candidate->candidateProfile->is_available ? 'Available Now' : 'Not Available') }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Passport Status</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    <i data-lucide="book" class="w-4 h-4 inline-block mr-1 text-gray-400"></i>
                                    {{ $candidate->candidateProfile->passport_status ?? 'Not Specified' }}
                                </dd>
                            </div>
                        </div>

                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 mb-8">
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Highest Education</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('-', ' ', $candidate->candidateProfile->education_level ?? 'Not specified')) }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Experience Level</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ ucfirst($candidate->candidateProfile->experience_level ?? 'Not specified') }} ({{ $candidate->candidateProfile->years_of_experience ?? '0' }} years)</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Experience Category</dt>
                                <dd class="text-sm font-semibold text-gray-900">
                                    @if($candidate->candidateProfile->experienceCategory)
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">{{ $candidate->candidateProfile->experienceCategory->name }}</span>
                                    @else
                                        <span class="text-gray-500">Not specified</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">International Experience</dt>
                                <dd class="text-sm font-semibold text-gray-900">
                                    {{ $candidate->candidateProfile->international_experience ? 'Yes' : 'No' }}
                                </dd>
                            </div>
                        </dl>

                        <!-- Work History -->
                        <div class="mb-8">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Detailed Work History</h4>
                            <div class="space-y-4">
                                @forelse($candidate->candidateProfile->workExperiences as $work)
                                    <div class="p-4 rounded-xl border border-gray-100 bg-white shadow-sm">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h5 class="text-sm font-bold text-gray-900">{{ $work->job_title }}</h5>
                                                <p class="text-xs text-blue-600 font-medium">{{ $work->employer }}</p>
                                            </div>
                                            <span class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded">
                                                {{ $work->start_date->format('M Y') }} - {{ $work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : '') }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 prose prose-sm max-w-none">
                                            {!! $work->description !!}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic">No structured work history provided.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Education History -->
                        <div class="mb-8">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Academic History</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($candidate->candidateProfile->educations as $edu)
                                    <div class="p-4 rounded-xl border border-gray-100 bg-white shadow-sm">
                                        <h5 class="text-sm font-bold text-gray-900">{{ $edu->level }} in {{ $edu->field_of_study }}</h5>
                                        <p class="text-xs text-emerald-600 font-medium">{{ $edu->institution }}</p>
                                        <p class="text-[10px] text-gray-400 mt-2 uppercase">
                                            {{ $edu->start_date->format('Y') }} - {{ $edu->is_current ? 'Present' : ($edu->end_date ? $edu->end_date->format('Y') : '') }}
                                            • {{ $edu->city }}, {{ $edu->country }}
                                        </p>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic">No structured education history provided.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Skills</dt>
                                <dd class="flex flex-wrap gap-2">
                                    @if($candidate->candidateProfile->skills && count($candidate->candidateProfile->skills) > 0)
                                        @foreach($candidate->candidateProfile->skills as $skill)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-bold border border-gray-200">{{ is_object($skill) ? $skill->name : $skill }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-500 italic">No skills listed</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Languages</dt>
                                <dd class="flex flex-wrap gap-2">
                                    @if($candidate->candidateProfile->languages && count($candidate->candidateProfile->languages) > 0)
                                        @foreach($candidate->candidateProfile->languages as $language)
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200">{{ is_object($language) ? $language->name : $language }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-500 italic">No languages listed</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
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
                                        <p class="text-sm font-bold text-gray-900">{{ $document->document_type == 'video_cv' ? 'Video CV' : ucfirst($document->document_type) }}</p>
                                        <p class="text-xs text-gray-500">{{ $document->file_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <form action="{{ route('admin.verification.document.updateStatus', $document) }}" method="POST" class="mr-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="text-[10px] font-bold rounded-full border-none focus:ring-0 cursor-pointer py-0.5 pl-2 pr-6
                                            {{ $document->verification_status == 'approved' ? 'bg-green-100 text-green-700' : 
                                               ($document->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            <option value="pending" {{ $document->verification_status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                            <option value="approved" {{ $document->verification_status == 'approved' ? 'selected' : '' }}>APPROVED</option>
                                            <option value="rejected" {{ $document->verification_status == 'rejected' ? 'selected' : '' }}>REJECTED</option>
                                        </select>
                                    </form>
                                    <a href="{{ asset($document->file_path) }}" target="_blank" class="p-2 text-gray-400 hover:text-blue-600 transition-colors" title="View Document">
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
