@extends('layouts.admin')

@section('title', 'Job Details')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('admin.jobs.index') }}" class="hover:fb-blue flex items-center font-medium">
                <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                Back to Jobs
            </a>
        </div>

        <!-- Job Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                    <div class="flex items-start">
                        <div
                            class="h-16 w-16 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100 text-blue-600 shadow-sm flex-shrink-0">
                            <i data-lucide="briefcase" class="w-8 h-8"></i>
                        </div>
                        <div class="ml-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h2>
                            <div class="mt-2 flex flex-wrap gap-4 text-sm font-medium text-gray-500">
                                <span class="flex items-center"><i data-lucide="building-2"
                                        class="w-4 h-4 mr-1.5 text-gray-400"></i> {{ $job->company_name }}</span>
                                <span class="flex items-center"><i data-lucide="map-pin"
                                        class="w-4 h-4 mr-1.5 text-gray-400"></i> {{ $job->location }},
                                    {{ $job->country }}</span>
                                <span class="flex items-center"><i data-lucide="tag"
                                        class="w-4 h-4 mr-1.5 text-gray-400"></i>
                                    {{ $job->category->name ?? 'Uncategorized' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.jobs.edit', $job) }}"
                            class="px-6 py-2 bg-gray-100 text-gray-800 font-bold rounded-xl hover:bg-gray-200 transition-colors border border-gray-200 shadow-sm flex items-center">
                            <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.jobs.toggleStatus', $job) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-6 py-2 rounded-xl font-bold transition-all shadow-sm flex items-center
                                                {{ $job->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                <i data-lucide="{{ $job->is_active ? 'eye-off' : 'eye' }}" class="w-4 h-4 mr-2"></i>
                                {{ $job->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Experience</span>
                    <span
                        class="text-sm font-bold text-gray-700">{{ $job->experience_years ?? $job->experience_required ?? 0 }}
                        Years</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Min Education</span>
                    <span
                        class="text-sm font-bold text-gray-700">{{ $job->education_level ? ucfirst(str_replace('-', ' ', $job->education_level)) : 'Any' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Type</span>
                    <span class="text-sm font-bold text-gray-700">{{ ucfirst($job->employment_type) }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Salary</span>
                    <span class="text-sm font-bold text-gray-700">{{ $job->salary_range ?? 'Not specified' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Posted On</span>
                    <span class="text-sm font-bold text-gray-700">{{ $job->created_at->format('M d, Y') }}</span>
                </div>
                <span
                    class="px-3 py-1 rounded-full text-xs font-bold {{ $job->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                    {{ $job->is_active ? 'ACTIVE' : 'INACTIVE' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Job Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="align-left" class="w-5 h-5 mr-2 fb-blue"></i>
                        Job Description
                    </h3>
                    <div class="prose max-w-none text-gray-700 text-sm leading-relaxed">
                        {!! $job->description !!}
                    </div>

                    @if($job->requirements)
                        <h3 class="font-bold text-gray-900 mt-8 mb-4 flex items-center">
                            <i data-lucide="list-checks" class="w-5 h-5 mr-2 fb-blue"></i>
                            Key Requirements
                        </h3>
                        <div class="prose max-w-none text-gray-700 text-sm leading-relaxed">
                            {!! $job->requirements !!}
                        </div>
                    @endif
                </div>

                <!-- Applications -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900 flex items-center">
                            <i data-lucide="users" class="w-5 h-5 mr-2 fb-blue"></i>
                            Recent Applications
                        </h3>
                        <span class="text-xs font-bold text-gray-500">{{ $job->applications->count() }} total</span>
                    </div>
                    <div class="p-0">
                        <ul class="divide-y divide-gray-100">
                            @forelse($job->applications as $application)
                                <li class="px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600 border border-gray-200">
                                                {{ substr($application->candidate->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-bold text-gray-900">{{ $application->candidate->name }}
                                                </p>
                                                <p class="text-xs text-gray-500">{{ $application->candidate->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @if($application->video_path)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                                    <i data-lucide="video" class="w-3 h-3 mr-1"></i> Video
                                                </span>
                                            @endif
                                            {{-- Status Dropdown --}}
                                            <div x-data="{ open: false }" class="relative">
                                                <button @click="open = !open"
                                                    class="px-2 py-1 rounded-full text-xs font-bold cursor-pointer hover:opacity-80 flex items-center gap-1
                                                                                        {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                                                        {{ $application->status === 'reviewed' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                                        {{ $application->status === 'shortlisted' ? 'bg-purple-100 text-purple-700' : '' }}
                                                                                        {{ $application->status === 'interview' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                                                                        {{ $application->status === 'offered' ? 'bg-green-100 text-green-700' : '' }}
                                                                                        {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                                                                        {{ $application->status === 'withdrawn' ? 'bg-gray-100 text-gray-700' : '' }}">
                                                    {{ ucfirst($application->status) }}
                                                    <i data-lucide="chevron-down" class="w-3 h-3"></i>
                                                </button>
                                                <div x-show="open" @click.away="open = false" x-cloak
                                                    class="absolute right-0 mt-1 w-36 bg-white rounded-lg shadow-lg border border-gray-200 z-10 py-1">
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-yellow-50 flex items-center gap-2 {{ $application->status === 'pending' ? 'bg-yellow-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Pending
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="reviewed">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-blue-50 flex items-center gap-2 {{ $application->status === 'reviewed' ? 'bg-blue-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Reviewed
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="shortlisted">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-purple-50 flex items-center gap-2 {{ $application->status === 'shortlisted' ? 'bg-purple-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-purple-500"></span> Shortlisted
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="interview">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-indigo-50 flex items-center gap-2 {{ $application->status === 'interview' ? 'bg-indigo-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Interview
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="offered">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-green-50 flex items-center gap-2 {{ $application->status === 'offered' ? 'bg-green-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Offered
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-red-50 flex items-center gap-2 {{ $application->status === 'rejected' ? 'bg-red-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected
                                                        </button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.applications.updateStatus', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="withdrawn">
                                                        <button type="submit"
                                                            class="w-full px-3 py-2 text-left text-sm hover:bg-gray-50 flex items-center gap-2 {{ $application->status === 'withdrawn' ? 'bg-gray-50' : '' }}">
                                                            <span class="w-2 h-2 rounded-full bg-gray-500"></span> Withdrawn
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <span
                                                class="text-[11px] font-bold text-gray-400">{{ $application->created_at->diffForHumans() }}</span>
                                            <a href="{{ route('admin.candidates.show', $application->candidate) }}"
                                                class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Application Details --}}
                                    <div class="mt-3 ml-14 space-y-2">
                                        @if($application->cover_letter)
                                            <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                                                <p class="font-medium text-gray-700 mb-1">Cover Letter:</p>
                                                <p class="text-gray-600">{{ Str::limit($application->cover_letter, 200) }}</p>
                                            </div>
                                        @endif

                                        @if($application->video_path)
                                            <div class="bg-purple-50 rounded-lg p-3" x-data="{ showVideo: false }">
                                                <button @click="showVideo = !showVideo"
                                                    class="w-full font-medium text-purple-700 flex items-center justify-between">
                                                    <span class="flex items-center">
                                                        <i data-lucide="video" class="w-4 h-4 mr-2"></i> Application Video
                                                    </span>
                                                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"
                                                        :class="{ 'rotate-180': showVideo }"></i>
                                                </button>
                                                <div x-show="showVideo" x-collapse class="mt-2">
                                                    <video controls class="w-full h-48 rounded-lg shadow-sm object-cover"
                                                        preload="metadata">
                                                        <source src="{{ asset($application->video_path) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                    <a href="{{ asset($application->video_path) }}" target="_blank"
                                                        class="inline-flex items-center mt-2 text-sm text-purple-600 hover:text-purple-800">
                                                        <i data-lucide="external-link" class="w-4 h-4 mr-1"></i> Open in new tab
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="px-6 py-12 text-center text-gray-500 italic">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="users-2" class="w-10 h-10 text-gray-200 mb-2"></i>
                                        <p>No applications received for this job yet.</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Job Summary</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">ID</span>
                            <span class="text-sm font-bold text-gray-900">#{{ $job->id }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Views</span>
                            <span class="text-sm font-bold text-gray-900">{{ $job->views_count ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Employment</span>
                            <span class="text-sm font-bold text-gray-900 uppercase">{{ $job->employment_type }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Work Hours</span>
                            <span class="text-sm font-bold text-gray-900 capitalize">{{ $job->work_hours ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Languages</span>
                            <span class="text-sm font-bold text-gray-900">
                                {{ collect($job->languages)->map(function ($lang) {
        if (is_array($lang)) {
            $name = $lang['name'] ?? $lang['language'] ?? '';
            $prof = $lang['proficiency'] ?? $lang['level'] ?? '';
            return $name . ($prof ? '-' . $prof : '');
        }
        return $lang;
    })->filter()->implode(', ') ?: 'No requirement' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Visibility</span>
                            <span class="text-sm font-bold {{ $job->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $job->is_active ? 'Public' : 'Hidden' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500">Video Required</span>
                            <span
                                class="text-sm font-bold {{ $job->requires_video ? 'text-purple-600' : 'text-gray-500' }}">
                                {{ $job->requires_video ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection