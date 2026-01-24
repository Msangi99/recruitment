@extends('layouts.app')

@section('title', 'Job Details - Candidate')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('candidate.partials.nav')

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6">
                    <a href="{{ route('candidate.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to
                        Jobs</a>
                </div>

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $job->title }}</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $job->company_name }} •
                                    {{ $job->location }}, {{ $job->country }}</p>
                            </div>
                            @if($hasApplied)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Already
                                    Applied</span>
                            @endif
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $job->category->name ?? 'N/A' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ ucfirst($job->employment_type) }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{!! $job->description !!}</dd>
                            </div>
                            @if($job->requirements)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Requirements</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->requirements }}</dd>
                                </div>
                            @endif
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $job->salary_range }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                @if(!$hasApplied && auth()->user()->candidateProfile && auth()->user()->candidateProfile->verification_status === 'approved')
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Apply for this Job</h3>
                        @if($job->requires_video)
                            <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-blue-800 text-sm">
                                    <strong>Video Required:</strong> This job requires a video application. Please upload a video
                                    introducing yourself and explaining why you're a good fit for this position.
                                </p>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('candidate.jobs.apply', $job) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cover Letter (Optional)</label>
                                <textarea name="cover_letter" rows="5"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Tell the employer why you're a good fit..."></textarea>
                            </div>
                            @php
                                $uploadMax = min(
                                    (int) ini_get('upload_max_filesize') * (stripos(ini_get('upload_max_filesize'), 'M') ? 1 : (stripos(ini_get('upload_max_filesize'), 'G') ? 1024 : 0.001)),
                                    (int) ini_get('post_max_size') * (stripos(ini_get('post_max_size'), 'M') ? 1 : (stripos(ini_get('post_max_size'), 'G') ? 1024 : 0.001))
                                );
                            @endphp
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Application Video {{ $job->requires_video ? '*' : '(Optional)' }}
                                </label>
                                <input type="file" name="application_video" id="application_video"
                                    accept="video/mp4,video/mov,video/avi,video/wmv"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('application_video') border-red-300 @enderror"
                                    data-max-size="{{ $uploadMax * 1024 * 1024 }}">
                                <p class="mt-1 text-xs text-gray-500">MP4, MOV, AVI or WMV. Max size: {{ $uploadMax }}MB</p>
                                <p id="video-size-warning" class="mt-2 text-sm text-red-600 hidden"></p>
                                @error('application_video')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="upload-progress" class="mb-4 hidden">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-indigo-700">Uploading video...</span>
                                    <span id="progress-percent" class="text-sm font-medium text-indigo-700">0%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div id="progress-bar" class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                            <button type="submit" id="submit-btn"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Submit Application
                            </button>
                        </form>
                    </div>
                @elseif(!auth()->user()->candidateProfile || auth()->user()->candidateProfile->verification_status !== 'approved')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <p class="text-yellow-800">
                            <strong>Profile Verification Required:</strong> Your profile must be verified before applying to
                            jobs.
                            <a href="{{ route('candidate.profile.create') }}" class="underline">Complete your profile</a> and
                            wait for admin verification.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videoInput = document.getElementById('application_video');
            const warningEl = document.getElementById('video-size-warning');
            const form = videoInput ? videoInput.closest('form') : null;
            const submitBtn = document.getElementById('submit-btn');
            const progressDiv = document.getElementById('upload-progress');
            const progressBar = document.getElementById('progress-bar');
            const progressPercent = document.getElementById('progress-percent');

            if (videoInput) {
                const maxSize = parseInt(videoInput.dataset.maxSize) || (2 * 1024 * 1024); // Default 2MB
                const maxSizeMB = (maxSize / (1024 * 1024)).toFixed(0);

                videoInput.addEventListener('change', function () {
                    // Reset warning styles
                    warningEl.classList.remove('text-green-600');
                    warningEl.classList.add('text-red-600');

                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);

                        if (file.size > maxSize) {
                            warningEl.textContent = `File size (${fileSizeMB}MB) exceeds the ${maxSizeMB}MB server limit. Please choose a smaller video.`;
                            warningEl.classList.remove('hidden');
                            this.value = ''; // Clear the input
                        } else {
                            warningEl.textContent = `Video selected: ${file.name} (${fileSizeMB}MB) ✓`;
                            warningEl.classList.remove('hidden');
                            warningEl.classList.remove('text-red-600');
                            warningEl.classList.add('text-green-600');
                        }
                    }
                });

                if (form) {
                    form.addEventListener('submit', function (e) {
                        // Check file size first
                        if (videoInput.files && videoInput.files[0]) {
                            const file = videoInput.files[0];
                            if (file.size > maxSize) {
                                e.preventDefault();
                                alert(`Video file is too large. Maximum size is ${maxSizeMB}MB.`);
                                return false;
                            }

                            // Show progress bar for video uploads
                            e.preventDefault();

                            const formData = new FormData(form);
                            const xhr = new XMLHttpRequest();

                            // Show progress UI
                            progressDiv.classList.remove('hidden');
                            submitBtn.disabled = true;
                            submitBtn.textContent = 'Uploading...';

                            xhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    const percent = Math.round((e.loaded / e.total) * 100);
                                    progressBar.style.width = percent + '%';
                                    progressPercent.textContent = percent + '%';
                                }
                            });

                            xhr.addEventListener('load', function () {
                                if (xhr.status >= 200 && xhr.status < 300) {
                                    // Success - redirect to applications page
                                    progressBar.style.width = '100%';
                                    progressPercent.textContent = '100%';
                                    submitBtn.textContent = 'Success! Redirecting...';

                                    // Parse redirect URL from response or redirect to applications
                                    window.location.href = '{{ route("candidate.applications.index") }}';
                                } else {
                                    // Error
                                    progressDiv.classList.add('hidden');
                                    submitBtn.disabled = false;
                                    submitBtn.textContent = 'Submit Application';

                                    // Try to parse error message
                                    try {
                                        const response = JSON.parse(xhr.responseText);
                                        alert(response.message || 'Upload failed. Please try again.');
                                    } catch {
                                        alert('Upload failed. Please try again.');
                                    }
                                }
                            });

                            xhr.addEventListener('error', function () {
                                progressDiv.classList.add('hidden');
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Submit Application';
                                alert('Upload failed. Please check your connection and try again.');
                            });

                            xhr.open('POST', form.action);
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                            xhr.send(formData);
                        }
                    });
                }
            }
        });
    </script>
@endpush