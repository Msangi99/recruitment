@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">Compliance & Documents</h2>
            <p class="mt-2 text-base text-slate-600 font-medium">Upload a professional photo and a short introduction video to increase your chances with employers.</p>
        </div>

        <div class="space-y-8">
            <!-- Compliance Documents Upload -->
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Compliance Documents</h3>
                </div>
                <div class="p-6">
                    <!-- List of Added Documents -->
                    @if($complianceDocuments->count() > 0)
                        <div class="space-y-3 mb-6">
                            @foreach($complianceDocuments as $doc)
                                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded bg-emerald-100 flex items-center justify-center mr-3">
                                            <i data-lucide="file-text" class="w-4 h-4 text-emerald-600"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center">
                                                <p class="text-sm font-bold text-slate-900">{{ $doc->document_type }}</p>
                                                @if($doc->verification_status == 'approved')
                                                    <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-100 text-emerald-700 uppercase">
                                                        <i data-lucide="check" class="w-2.5 h-2.5 mr-0.5"></i> Verified
                                                    </span>
                                                @elseif($doc->verification_status == 'rejected')
                                                    <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-rose-100 text-rose-700 uppercase" title="{{ $doc->rejection_reason }}">
                                                        <i data-lucide="x" class="w-2.5 h-2.5 mr-0.5"></i> Rejected
                                                    </span>
                                                @else
                                                    <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-700 uppercase">
                                                        <i data-lucide="clock" class="w-2.5 h-2.5 mr-0.5"></i> Pending
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-[10px] text-slate-500">
                                                {{ $doc->file_name }} ({{ $doc->file_size_human }}) 
                                                <span class="mx-1">•</span> 
                                                Uploaded on {{ $doc->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ asset($doc->file_path) }}" target="_blank" class="text-slate-400 hover:text-emerald-600 p-1">
                                            <i data-lucide="eye" class="h-4 w-4"></i>
                                        </a>
                                        <form action="{{ route('candidate.wizard.compliance-document.destroy', $doc->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to remove this document?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500 p-1">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Add New Document Form -->
                    <form action="{{ route('candidate.wizard.compliance-document.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Document Type</label>
                                <select name="document_type" required
                                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                    <option value="">Select Type</option>
                                    <option value="Medical Fitness Status">Medical Fitness Status</option>
                                    <option value="Police Clearance Status">Police Clearance Status</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Upload PDF (Max 5MB)</label>
                                <input type="file" name="document" accept="application/pdf" required
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" />
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                                <i data-lucide="upload-cloud" class="w-4 h-4 mr-2"></i> Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Medical & Police Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ 
                medical: '{{ $profile->medical_clearance ?? 'Pending' }}',
                police: '{{ $profile->police_clearance ?? 'Pending' }}'
            }">
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <label class="block text-sm font-bold text-slate-900 mb-4 flex items-center">
                        <i data-lucide="heart-pulse" class="w-5 h-5 mr-2 text-rose-500"></i>
                        Medical Fitness Status
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['Fit', 'Pending', 'Unfit'] as $status)
                            <label class="relative flex cursor-pointer rounded-lg border p-3 shadow-sm focus:outline-none transition-all"
                                :class="medical === '{{ $status }}' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <input type="radio" name="medical_clearance" value="{{ $status }}" form="main-form"
                                    x-model="medical" class="sr-only">
                                <span class="flex flex-1 items-center justify-center text-sm font-bold"
                                    :class="medical === '{{ $status }}' ? 'text-emerald-700' : 'text-slate-600'">
                                    {{ $status }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <label class="block text-sm font-bold text-slate-900 mb-4 flex items-center">
                        <i data-lucide="shield-check" class="w-5 h-5 mr-2 text-blue-500"></i>
                        Police Clearance Status
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['Cleared', 'Pending', 'Disqualified'] as $status)
                            <label class="relative flex cursor-pointer rounded-lg border p-3 shadow-sm focus:outline-none transition-all"
                                :class="police === '{{ $status }}' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <input type="radio" name="police_clearance" value="{{ $status }}" form="main-form"
                                    x-model="police" class="sr-only">
                                <span class="flex flex-1 items-center justify-center text-sm font-bold"
                                    :class="police === '{{ $status }}' ? 'text-emerald-700' : 'text-slate-600'">
                                    {{ $status }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Profile Picture Upload -->
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900">Profile Picture</h3>
                    @if($profile->profile_picture_verified)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                             <i data-lucide="badge-check" class="w-3 h-3 mr-1"></i> Verified
                        </span>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                <img id="profile-preview" class="h-40 w-40 rounded-2xl object-cover border-4 border-white shadow-lg ring-1 ring-slate-200"
                                    src="{{ $profile->profile_picture ? asset($profile->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF&size=160' }}"
                                    alt="Profile preview">
                                @if(!$profile->profile_picture)
                                    <div class="absolute inset-0 flex items-center justify-center bg-slate-100 rounded-2xl">
                                        <i data-lucide="user" class="w-16 h-16 text-slate-300"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 w-full">
                            <div id="photo-upload-container">
                                <form id="photo-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="profile_picture" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i data-lucide="camera" class="w-8 h-8 text-slate-400 mb-2"></i>
                                                <p class="text-sm text-slate-500 font-medium">Click to select or drag and drop</p>
                                                <p class="text-xs text-slate-400">JPG, PNG (max 3MB)</p>
                                            </div>
                                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden" />
                                        </label>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 mb-4">
                                        <div class="flex items-center text-xs text-slate-600">
                                            <i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i> Clear face, front-facing
                                        </div>
                                        <div class="flex items-center text-xs text-slate-600">
                                            <i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i> Professional attire
                                        </div>
                                        <div class="flex items-center text-xs text-slate-600">
                                            <i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i> Plain background
                                        </div>
                                        <div class="flex items-center text-xs text-slate-600">
                                            <i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i> Neutral expression
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-center gap-3">
                                        <button type="button" id="upload-photo-btn"
                                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-colors shadow-sm"
                                            style="display:none;">
                                            Upload Profile Photo
                                        </button>
                                        <p class="text-xs text-slate-400 italic">"You can change this photo later if needed."</p>
                                    </div>
                                </form>
                                <div id="photo-progress" class="hidden mt-4">
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Introduction Video Upload -->
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Introduction Video</h3>
                        <p class="text-xs text-slate-500">Highlight your communication skills and personality.</p>
                    </div>
                    @if($profile->video_cv_verified)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                             <i data-lucide="badge-check" class="w-3 h-3 mr-1"></i> Verified
                        </span>
                    @endif
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="space-y-4">
                                <div class="bg-indigo-50 rounded-lg p-4 relative group">
                                    <div class="flex items-start">
                                        <i data-lucide="message-square" class="w-5 h-5 text-indigo-600 mt-1 mr-3"></i>
                                        <div>
                                            <h4 class="text-sm font-bold text-indigo-900">Suggested Script</h4>
                                            <p class="text-xs text-indigo-700 mt-1 leading-relaxed">
                                                “Introduce yourself, mention your job role, experience, and availability.”
                                            </p>
                                            <div class="mt-3 p-2 bg-white rounded border border-indigo-100 text-[11px] text-slate-600">
                                                <strong>Example:</strong> “My name is..., I am a warehouse assistant with 3 years of experience. I am available immediately and willing to work abroad.”
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tooltip logic can be added if needed, but script is clear here -->
                                </div>

                                <ul class="space-y-2">
                                    <li class="flex items-center text-xs text-slate-600">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 mr-2 text-slate-400"></i> Duration: 30–60 seconds
                                    </li>
                                    <li class="flex items-center text-xs text-slate-600">
                                        <i data-lucide="languages" class="w-3.5 h-3.5 mr-2 text-slate-400"></i> Language: English
                                    </li>
                                    <li class="flex items-center text-xs text-slate-600">
                                        <i data-lucide="sun" class="w-3.5 h-3.5 mr-2 text-slate-400"></i> Clear audio & lighting
                                    </li>
                                    <li class="flex items-center text-xs text-slate-600">
                                        <i data-lucide="image" class="w-3.5 h-3.5 mr-2 text-slate-400"></i> Plain background, no filters
                                    </li>
                                    <li class="flex items-center text-xs text-slate-600">
                                        <i data-lucide="file-type" class="w-3.5 h-3.5 mr-2 text-slate-400"></i> MP4 (max 100 MB)
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <div id="video-upload-container" class="h-full flex flex-col">
                                @if($profile->video_cv)
                                    <div class="mb-4 relative">
                                        <video controls class="w-full aspect-video rounded-lg bg-black object-cover shadow-sm">
                                            <source src="{{ asset($profile->video_cv) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class="absolute top-2 left-2 px-2 py-1 bg-emerald-500 text-white text-[10px] font-bold rounded shadow-sm flex items-center">
                                            <i data-lucide="check" class="w-3 h-3 mr-1"></i> CURRENT VIDEO
                                        </div>
                                    </div>
                                @endif

                                <form id="video-form" enctype="multipart/form-data" class="flex-1 flex flex-col">
                                    @csrf
                                    <label for="video_cv" class="flex-1 flex flex-col items-center justify-center border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors min-h-[140px]">
                                        <div class="text-center p-4">
                                            <i data-lucide="video" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                                            <p class="text-sm text-slate-500 font-medium">Upload Introduction Video</p>
                                            <p class="text-xs text-slate-400">Drag & drop or click</p>
                                        </div>
                                        <input id="video_cv" name="video_cv" type="file" class="hidden" accept="video/mp4,video/quicktime">
                                    </label>
                                    
                                    <button type="button" id="upload-video-btn"
                                        class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-colors shadow-sm"
                                        style="display:none;">
                                        Upload Video
                                    </button>
                                     <p class="mt-2 text-[10px] text-slate-400 text-center">Video is optional but highly recommended.</p>
                                </form>

                                <div id="video-progress" class="hidden mt-4">
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div id="video-progress-bar" class="bg-emerald-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <p id="video-status" class="text-[10px] text-center text-slate-500 mt-1 uppercase tracking-wider font-bold">Uploading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy & Consent -->
            <form id="main-form" action="{{ route('candidate.wizard.process', ['step' => 10]) }}" method="POST">
                @csrf
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-5 mb-8">
                    <div class="flex items-start">
                        <div class="flex h-6 items-center">
                            <input id="consent" name="consent" type="checkbox" required
                                class="h-5 w-5 rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500 transition-all cursor-pointer">
                        </div>
                        <div class="ml-4 text-sm">
                            <label for="consent" class="font-bold text-emerald-900 block mb-1">Privacy & Consent</label>
                            <p class="text-emerald-700 leading-relaxed">I consent to Coyzon sharing my photo and video with verified employers only.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-8 border-t border-slate-200">
                    <a href="{{ route('candidate.wizard.show', ['step' => 9]) }}"
                        class="text-sm font-bold text-slate-500 hover:text-slate-900 flex items-center transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Back
                    </a>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('candidate.wizard.show', ['step' => 11]) }}"
                            class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                            Skip for Now
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center items-center rounded-xl bg-deep-green px-8 py-3 text-sm font-bold text-white shadow-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            Save & Continue
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo Upload Logic
        const photoInput = document.getElementById('profile_picture');
        const photoBtn = document.getElementById('upload-photo-btn');
        const photoForm = document.getElementById('photo-form');
        const photoProgress = document.getElementById('photo-progress');

        let photoUploaded = {{ $profile->profile_picture ? 'true' : 'false' }};

        photoInput.addEventListener('change', () => {
            if (photoInput.files.length > 0) {
                photoBtn.style.display = 'inline-flex';
                photoBtn.innerText = 'Upload ' + photoInput.files[0].name;
                photoUploaded = false; // Reset if new file selected

                // Simple preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('profile-preview').src = e.target.result;
                    document.getElementById('profile-preview').parentElement.querySelector('.absolute')?.remove();
                };
                reader.readAsDataURL(photoInput.files[0]);
            }
        });

        const uploadPhoto = () => {
            return new Promise((resolve, reject) => {
                if (photoInput.files.length === 0) {
                    resolve(true); // No file to upload
                    return;
                }

                const formData = new FormData(photoForm);
                const btn = photoBtn;
                const originalText = btn.innerText;

                btn.disabled = true;
                btn.innerText = 'Uploading...';
                photoProgress.classList.remove('hidden');
                const progressBar = photoProgress.querySelector('.bg-emerald-600');
                progressBar.style.width = '10%';

                fetch('{{ route("candidate.wizard.upload.photo") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('profile-preview').src = data.path;
                            btn.innerText = 'Uploaded!';
                            btn.classList.add('bg-gray-400');
                            photoUploaded = true;
                            setTimeout(() => {
                                btn.style.display = 'none';
                                btn.disabled = false;
                                btn.innerText = originalText;
                                btn.classList.remove('bg-gray-400');
                                photoProgress.classList.add('hidden');
                            }, 2000);
                            resolve(true);
                        } else {
                            alert('Photo upload failed: ' + (data.message || 'Unknown error'));
                            btn.disabled = false;
                            btn.innerText = originalText;
                            photoProgress.classList.add('hidden');
                            resolve(false);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Photo upload error');
                        btn.disabled = false;
                        btn.innerText = originalText;
                        photoProgress.classList.add('hidden');
                        resolve(false);
                    });
            });
        };

        photoBtn.addEventListener('click', () => {
            uploadPhoto();
        });

        // Video Upload Logic
        const videoInput = document.getElementById('video_cv');
        const videoBtn = document.getElementById('upload-video-btn');
        const videoForm = document.getElementById('video-form');
        const videoProgress = document.getElementById('video-progress');
        const videoProgressBar = document.getElementById('video-progress-bar');

        let videoUploaded = {{ $profile->video_cv ? 'true' : 'false' }};

        videoInput.addEventListener('change', () => {
            if (videoInput.files.length > 0) {
                videoBtn.style.display = 'inline-flex';
                videoBtn.innerText = 'Upload ' + videoInput.files[0].name;
                videoUploaded = false;
            }
        });

        const uploadVideo = () => {
            return new Promise((resolve, reject) => {
                if (videoInput.files.length === 0) {
                    resolve(true);
                    return;
                }

                const formData = new FormData(videoForm);
                videoBtn.style.display = 'none';
                videoProgress.classList.remove('hidden');
                document.getElementById('video-status').innerText = 'Starting upload...';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("candidate.wizard.upload.video") }}', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        videoProgressBar.style.width = percentComplete + '%';
                        document.getElementById('video-status').innerText = Math.round(percentComplete) + '% Uploaded';
                    }
                };

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        try {
                            const data = JSON.parse(xhr.responseText);
                            if (data.success) {
                                document.getElementById('video-status').innerText = 'Upload Complete!';
                                videoUploaded = true;
                                setTimeout(() => {
                                    // location.reload(); // Don't reload, just resolve
                                }, 1000);
                                resolve(true);
                            } else {
                                alert('Video upload failed: ' + (data.message || 'Unknown error'));
                                videoProgress.classList.add('hidden');
                                videoBtn.style.display = 'inline-flex';
                                resolve(false);
                            }
                        } catch (e) {
                            alert('Video upload error: Invalid response');
                            resolve(false);
                        }
                    } else {
                        alert('Video upload error: ' + xhr.statusText);
                        videoProgress.classList.add('hidden');
                        videoBtn.style.display = 'inline-flex';
                        resolve(false);
                    }
                };

                xhr.onerror = function () {
                    alert('Video upload network error');
                    resolve(false);
                };

                xhr.send(formData);
            });
        };

        videoBtn.addEventListener('click', () => {
            uploadVideo().then(success => {
                if (success) location.reload();
            });
        });

        // Main Form Submission Intercept
        const mainForm = document.querySelector('form[action*="wizard/process"]');
        const submitBtn = mainForm.querySelector('button[type="submit"]');

        mainForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Check if files are selected but not uploaded
            const photoPending = photoInput.files.length > 0 && !photoUploaded;
            const videoPending = videoInput.files.length > 0 && !videoUploaded;

            if (photoPending || videoPending) {
                const originalBtnText = submitBtn.innerText;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Uploading media...';

                if (photoPending) {
                    const pSuccess = await uploadPhoto();
                    if (!pSuccess) {
                        submitBtn.disabled = false;
                        submitBtn.innerText = originalBtnText;
                        return;
                    }
                }

                if (videoPending) {
                    const vSuccess = await uploadVideo();
                    if (!vSuccess) {
                        submitBtn.disabled = false;
                        submitBtn.innerText = originalBtnText;
                        return;
                    }
                }
            }

            // Allow form submission to proceed
            mainForm.submit();
        });
    </script>
@endsection