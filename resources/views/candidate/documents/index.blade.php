@extends('layouts.app')

@section('title', 'Documents - Candidate')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('candidate.partials.nav')

        <div class="lg:ml-64 pt-16 lg:pt-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="px-4 py-6 sm:px-0">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">My Documents</h2>
                        <p class="mt-1 text-sm text-gray-500">Upload your CV, ID, passport, and certificates</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Video Introduction Section (Synced with Wizard Step 9) -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6 border border-slate-200">
                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center">
                                <i data-lucide="video" class="w-5 h-5 mr-2 text-emerald-600"></i>
                                Video Introduction
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                <div>
                                    <p class="text-sm text-slate-600 mb-4 font-medium">
                                        Introduce yourself to employers. Mention your name, role, years of experience, and
                                        what you're looking for.
                                    </p>

                                    <form id="video-form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="document_type" value="video_cv">
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-emerald-400 transition-colors bg-slate-50">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="video_cv"
                                                        class="relative cursor-pointer bg-transparent rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                                                        <span>Upload a video</span>
                                                        <input id="video_cv" name="document" type="file" class="sr-only"
                                                            accept="video/mp4,video/quicktime">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">MP4 or MOV up to 20MB</p>
                                            </div>
                                        </div>

                                        <button type="button" id="upload-video-btn"
                                            class="mt-4 w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent text-sm font-bold rounded-lg text-white bg-deep-green hover:bg-emerald-700 shadow-sm transition-all"
                                            style="display:none;">
                                            Upload Video
                                        </button>
                                    </form>

                                    <div id="video-progress" class="hidden mt-4">
                                        <div class="w-full bg-slate-200 rounded-full h-2">
                                            <div id="video-progress-bar" class="bg-emerald-600 h-2 rounded-full"
                                                style="width: 0%"></div>
                                        </div>
                                        <p id="video-status" class="text-xs text-center text-slate-500 mt-2 font-medium">
                                            Uploading...</p>
                                    </div>
                                </div>

                                <div
                                    class="bg-slate-900 rounded-xl overflow-hidden aspect-video flex items-center justify-center relative shadow-2xl">
                                    @php
                                        $videoCv = auth()->user()->documents()->where('document_type', 'video_cv')->first();
                                    @endphp
                                    @if($videoCv)
                                        <video controls class="w-full h-full">
                                            <source src="{{ asset($videoCv->file_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <div class="text-center p-6">
                                            <i data-lucide="video-off" class="w-12 h-12 text-slate-700 mx-auto mb-3"></i>
                                            <p class="text-slate-500 text-sm font-medium">No video introduction uploaded yet.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form (Generic Documents) -->
                    <div class="bg-white shadow rounded-lg p-6 mb-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Other Documents</h3>
                        <form method="POST" action="{{ route('candidate.documents.store') }}" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="document_type" class="block text-sm font-medium text-gray-700 mb-1">Document
                                        Type *</label>
                                    <select id="document_type" name="document_type" required
                                        class="block w-full px-3 py-2 border {{ $errors->has('document_type') ? 'border-red-300' : 'border-gray-300' }} text-gray-900 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                        <option value="">Select Type</option>
                                        <option value="cv">CV/Resume</option>
                                        <option value="id">National ID</option>
                                        <option value="passport">Passport</option>
                                        <option value="certificate">Certificate</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="document" class="block text-sm font-medium text-gray-700 mb-1">File
                                        *</label>
                                    <input type="file" id="document" name="document" required
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        class="block w-full px-3 py-2 border {{ $errors->has('document') ? 'border-red-300' : 'border-gray-300' }} text-gray-500 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="px-6 py-2 rounded-md shadow-sm text-sm font-bold text-white bg-deep-green hover:bg-emerald-700">
                                    Upload Document
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Documents List -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        File Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Size</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documents as $doc)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="px-2.5 py-1 text-xs font-bold rounded-full {{ $doc->document_type == 'cv' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800' }}">
                                                                    {{ $doc->document_type == 'video_cv' ? 'Video CV' : ucfirst($doc->document_type) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <div class="text-sm text-gray-900 truncate max-w-xs">{{ $doc->file_name }}</div>
                                                                <div class="text-xs text-gray-400">{{ $doc->created_at->format('M d, Y') }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $doc->file_size_human }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                            {{ $doc->verification_status == 'approved' ? 'bg-green-100 text-green-800' :
                                    ($doc->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                                    {{ ucfirst($doc->verification_status) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                <div class="flex items-center justify-end gap-3">
                                                                    <a href="{{ asset($doc->file_path) }}" target="_blank"
                                                                        class="text-emerald-600 hover:text-emerald-900 font-bold">View</a>
                                                                    <form method="POST" action="{{ route('candidate.documents.destroy', $doc) }}"
                                                                        onsubmit="return confirm('Delete this?');">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit"
                                                                            class="text-red-600 hover:text-red-900 font-bold">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No documents uploaded yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const videoInput = document.getElementById('video_cv');
            const videoBtn = document.getElementById('upload-video-btn');
            const videoForm = document.getElementById('video-form');
            const videoProgress = document.getElementById('video-progress');
            const videoProgressBar = document.getElementById('video-progress-bar');
            const videoStatus = document.getElementById('video-status');

            videoInput.addEventListener('change', () => {
                if (videoInput.files.length > 0) {
                    videoBtn.style.display = 'inline-flex';
                    videoBtn.innerText = 'Upload ' + videoInput.files[0].name;
                }
            });

            videoBtn.addEventListener('click', () => {
                const formData = new FormData(videoForm);
                // Re-map 'document' to what controller expects if needed, 
                // but DocumentController expects 'document' file and 'document_type' string

                videoBtn.style.display = 'none';
                videoProgress.classList.remove('hidden');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("candidate.documents.store") }}', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        const percent = (e.loaded / e.total) * 100;
                        videoProgressBar.style.width = percent + '%';
                        videoStatus.innerText = Math.round(percent) + '% Uploaded';
                    }
                };

                xhr.onload = function () {
                    if (xhr.status === 200 || xhr.status === 302) {
                        videoStatus.innerText = 'Upload Complete! Reloading...';
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert('Upload failed. Note: Max 20MB allowed.');
                        videoProgress.classList.add('hidden');
                        videoBtn.style.display = 'inline-flex';
                    }
                };

                xhr.onerror = function () {
                    alert('An error occurred during upload.');
                    videoProgress.classList.add('hidden');
                    videoBtn.style.display = 'inline-flex';
                };

                xhr.send(formData);
            });
        </script>
    @endpush
@endsection