@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Profile Media & Compliance</h2>
            <p class="mt-2 text-sm text-slate-600">Upload a professional photo and a short introduction video.</p>
        </div>

        <div class="space-y-8">
            <!-- Profile Picture Upload -->
            <div class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Profile Picture</h3>

                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <img id="profile-preview" class="h-24 w-24 rounded-full object-cover border-2 border-slate-200"
                            src="{{ $profile->profile_picture ? asset($profile->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="Profile preview">
                    </div>
                    <div class="flex-1">
                        <div id="photo-upload-container">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Upload New Photo</label>
                            <form id="photo-form" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="block w-full text-sm text-slate-500
                                                                            file:mr-4 file:py-2 file:px-4
                                                                            file:rounded-full file:border-0
                                                                            file:text-sm file:font-semibold
                                                                            file:bg-emerald-50 file:text-emerald-700
                                                                            hover:file:bg-emerald-100
                                                                        " />
                                <p class="mt-1 text-xs text-slate-500">JPG or PNG, max 3MB. Clear face, plain background.
                                </p>
                                <button type="button" id="upload-photo-btn"
                                    class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                    style="display:none;">
                                    Upload Photo
                                </button>
                            </form>
                            <div id="photo-progress" class="hidden mt-2">
                                <div class="w-full bg-slate-200 rounded-full h-2.5">
                                    <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Introduction Video Upload -->
            <div class="bg-white border border-slate-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-2">Introduction Video</h3>
                <p class="text-sm text-slate-500 mb-4">Introduce yourself, mention your role, experience, and availability
                    (30-60 sec).</p>

                <div id="video-upload-container">
                    @if($profile->video_cv)
                        <div class="mb-4">
                            <p class="text-sm text-emerald-600 font-medium mb-2">✓ Video Uploaded</p>
                            <video controls class="w-full h-48 rounded-lg bg-black object-cover">
                                <source src="{{ asset($profile->video_cv) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif

                    <form id="video-form" enctype="multipart/form-data">
                        @csrf
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-emerald-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="video_cv"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                        <span>Upload a video</span>
                                        <input id="video_cv" name="video_cv" type="file" class="sr-only"
                                            accept="video/mp4,video/quicktime">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">MP4 up to 100MB</p>
                            </div>
                        </div>
                        <button type="button" id="upload-video-btn"
                            class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                            style="display:none;">
                            Upload Video
                        </button>
                    </form>
                    <div id="video-progress" class="hidden mt-2">
                        <div class="w-full bg-slate-200 rounded-full h-2.5">
                            <div id="video-progress-bar" class="bg-emerald-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                        <p id="video-status" class="text-xs text-center text-slate-500 mt-1">Uploading...</p>
                    </div>
                </div>
            </div>

            <!-- Privacy & Consent -->
            <form action="{{ route('candidate.wizard.process', ['step' => 10]) }}" method="POST">
                @csrf
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="consent" name="consent" type="checkbox" required
                                class="h-4 w-4 rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="consent" class="font-medium text-blue-900">I consent to sharing my profile</label>
                            <p class="text-blue-700">I agree to Coyzon sharing my photo, video, and profile details with
                                verified employers only.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                    <a href="{{ route('candidate.wizard.show', ['step' => 9]) }}"
                        class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
                    <button type="submit"
                        class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Review & Submit
                    </button>
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
                photoUploaded = false; // Reset if new file selected
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