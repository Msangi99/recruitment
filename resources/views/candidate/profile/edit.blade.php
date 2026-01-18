@extends('layouts.app')

@section('title', 'Edit Profile - Candidate')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('candidate.partials.nav')

        <div class="lg:ml-64 pt-16 lg:pt-6">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="px-4 py-6 sm:px-0">
                    <div class="mb-6">
                        <a href="{{ route('candidate.profile.show') }}" class="text-indigo-600 hover:text-indigo-900">← Back
                            to Profile</a>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900">Edit Profile</h2>
                        @if($profile->verification_status === 'approved')
                            <p class="mt-1 text-sm text-yellow-600">
                                <strong>Note:</strong> Editing your verified profile will reset it to pending status for admin
                                review.
                            </p>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data"
                        class="bg-white shadow-lg rounded-lg p-8">
                        @csrf
                        @method('PUT')

                        <!-- Profile Picture -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Profile Picture
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-6">
                                    @if($profile->profile_picture)
                                        @php
                                            $imageUrl = asset($profile->profile_picture);
                                            $fileExists = file_exists(public_path($profile->profile_picture));
                                        @endphp
                                        @if($fileExists)
                                            <img src="{{ $imageUrl }}?v={{ time() }}" alt="Profile Picture"
                                                class="h-24 w-24 rounded-full object-cover border-2 border-gray-300"
                                                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        @endif
                                        <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300"
                                            style="{{ $fileExists ? 'display:none;' : 'display:flex;' }}">
                                            <span
                                                class="text-gray-500 text-2xl font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @else
                                        <div
                                            class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300">
                                            <span
                                                class="text-gray-500 text-2xl font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <label for="profile_picture"
                                            class="block text-sm font-medium text-gray-700 mb-2">Upload Profile
                                            Picture</label>
                                        <input type="file" id="profile_picture" name="profile_picture"
                                            accept="image/jpeg,image/jpg,image/png,image/gif"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('profile_picture') border-red-300 @enderror"
                                            onchange="validateImageFile(this);">
                                        <p class="mt-1 text-xs text-gray-500">JPEG, JPG, PNG or GIF. Max 2MB</p>
                                        @error('profile_picture')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Video CV -->
                        <div class="mb-8 border-t pt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Video CV</h3>
                            <div class="space-y-4">
                                <div class="flex flex-col space-y-4">
                                    @if($profile->video_cv)
                                        <div class="w-full max-w-md">
                                            <video controls class="w-full rounded-lg border border-gray-300">
                                                <source src="{{ asset($profile->video_cv) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <p class="mt-2 text-sm text-gray-500">Current Video CV</p>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <label for="video_cv" class="block text-sm font-medium text-gray-700 mb-2">Upload
                                            Video CV</label>
                                        <input type="file" id="video_cv" name="video_cv"
                                            accept="video/mp4,video/quicktime,video/x-msvideo"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('video_cv') border-red-300 @enderror"
                                            onchange="validateVideoFile(this);">
                                        <p class="mt-1 text-xs text-gray-500">MP4, MOV, or AVI. Max 20MB</p>
                                        @error('video_cv')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="mb-8 border-t pt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Personal
                                Information</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date
                                            of Birth *</label>
                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                            value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}"
                                            required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('date_of_birth') border-red-300 @enderror">
                                        @error('date_of_birth')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender
                                            *</label>
                                        <select id="gender" name="gender" required
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('gender') border-red-300 @enderror">
                                            <option value="">Select</option>
                                            <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Current
                                        Location *</label>
                                    <input type="text" id="location" name="location"
                                        value="{{ old('location', $profile->location) }}" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('location') border-red-300 @enderror"
                                        placeholder="e.g., Dar es Salaam, Tanzania">
                                    @error('location')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Details -->
                        <div class="mb-8 border-t pt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Professional
                                Details</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">User Title
                                        *</label>
                                    <input type="text" id="title" name="title" value="{{ old('title', $profile->title) }}"
                                        required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('title') border-red-300 @enderror"
                                        placeholder="e.g., Senior Software Engineer">
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 mb-2">Professional Summary *</label>
                                    <textarea id="description" name="description" required rows="3"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('description') border-red-300 @enderror">{{ old('description', $profile->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="education_level"
                                            class="block text-sm font-medium text-gray-700 mb-2">Education Level *</label>
                                        <select id="education_level" name="education_level" required
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('education_level') border-red-300 @enderror">
                                            <option value="">Select</option>
                                            <option value="high-school" {{ old('education_level', $profile->education_level) == 'high-school' ? 'selected' : '' }}>High School
                                            </option>
                                            <option value="diploma" {{ old('education_level', $profile->education_level) == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                            <option value="bachelor" {{ old('education_level', $profile->education_level) == 'bachelor' ? 'selected' : '' }}>Bachelor's
                                                Degree</option>
                                            <option value="master" {{ old('education_level', $profile->education_level) == 'master' ? 'selected' : '' }}>Master's Degree
                                            </option>
                                            <option value="phd" {{ old('education_level', $profile->education_level) == 'phd' ? 'selected' : '' }}>PhD</option>
                                        </select>
                                        @error('education_level')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="course_studied"
                                            class="block text-sm font-medium text-gray-700 mb-2">Course/Field of Study
                                            *</label>
                                        <input type="text" id="course_studied" name="course_studied"
                                            value="{{ old('course_studied', $profile->course_studied) }}" required
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('course_studied') border-red-300 @enderror"
                                            placeholder="e.g., Computer Science, Business Administration">
                                        @error('course_studied')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="years_of_experience"
                                            class="block text-sm font-medium text-gray-700 mb-2">Years of Experience
                                            *</label>
                                        <input type="number" id="years_of_experience" name="years_of_experience"
                                            value="{{ old('years_of_experience', $profile->years_of_experience) }}" required
                                            min="0" max="50"
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('years_of_experience') border-red-300 @enderror"
                                            placeholder="0">
                                        @error('years_of_experience')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="experience_category_id"
                                            class="block text-sm font-medium text-gray-700 mb-2">Experience Category
                                            *</label>
                                        <select id="experience_category_id" name="experience_category_id" required
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('experience_category_id') border-red-300 @enderror">
                                            <option value="">Select Category</option>
                                            @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                                                <option value="{{ $category->id }}" {{ old('experience_category_id', $profile->experience_category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('experience_category_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="experience_description"
                                        class="block text-sm font-medium text-gray-700 mb-2">Experience Description
                                        *</label>
                                    <textarea id="experience_description" name="experience_description" required rows="4"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('experience_description') border-red-300 @enderror">{{ old('experience_description', $profile->experience_description) }}</textarea>
                                    @error('experience_description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                @php
                                    $existingSkills = $profile->skills->pluck('name')->toArray();
                                    $existingLanguages = $profile->languages->pluck('name')->toArray();
                                @endphp
                                <div>
                                    <label for="skills-select" class="block text-sm font-medium text-gray-700 mb-2">Skills
                                        *</label>
                                    <select id="skills-select" name="skills[]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        multiple required>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->name }}" {{ in_array($skill->name, old('skills', $existingSkills)) ? 'selected' : '' }}>
                                                {{ $skill->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd) to select multiple</p>
                                </div>
                                <div>
                                    <label for="languages-select"
                                        class="block text-sm font-medium text-gray-700 mb-2">Languages *</label>
                                    <select id="languages-select" name="languages[]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        multiple required>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->name }}" {{ in_array($language->name, old('languages', $existingLanguages)) ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd) to select multiple</p>
                                </div>
                            </div>
                        </div>

                        <!-- Preferences -->
                        <div class="mb-8 border-t pt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Preferences
                            </h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="expected_salary"
                                            class="block text-sm font-medium text-gray-700 mb-2">Expected Salary</label>
                                        <input type="number" id="expected_salary" name="expected_salary"
                                            value="{{ old('expected_salary', $profile->expected_salary) }}" min="0"
                                            step="0.01"
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('expected_salary') border-red-300 @enderror">
                                    </div>
                                    <div>
                                        <label for="currency"
                                            class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                        <select id="currency" name="currency"
                                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                            <option value="TZS" {{ old('currency', $profile->currency) == 'TZS' ? 'selected' : '' }}>TZS</option>
                                            <option value="USD" {{ old('currency', $profile->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="target_destination"
                                        class="block text-sm font-medium text-gray-700 mb-2">Target Destination</label>
                                    <input type="text" id="target_destination" name="target_destination"
                                        value="{{ old('target_destination', $profile->target_destination) }}"
                                        placeholder="e.g., Tanzania, Kenya, Remote"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <div class="flex items-center">
                                    <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $profile->is_available) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_available" class="ml-3 block text-sm text-gray-700">Available for
                                        work</label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('candidate.profile.show') }}"
                                class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                            <button type="submit"
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Update
                                Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            .select2-container--default .select2-selection--multiple {
                border-color: #d1d5db;
                border-radius: 0.375rem;
                padding: 0.25rem;
            }

            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border-color: #6366f1;
                box-shadow: 0 0 0 1px #6366f1;
            }
        </style>

        <script>
            function validateImageFile(input) {
                const file = input.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size exceeds 2MB limit.');
                    input.value = '';
                }
            }

            function validateVideoFile(input) {
                const file = input.files[0];
                if (!file) return;
                if (file.size > 20 * 1024 * 1024) {
                    alert('File size exceeds 20MB limit.');
                    input.value = '';
                }
            }

            $(document).ready(function () {
                // Initialize Select2 for Skills
                $('#skills-select').select2({
                    placeholder: "Select or type skills",
                    tags: true,
                    width: '100%',
                    tokenSeparators: [',']
                });

                // Initialize Select2 for Languages
                $('#languages-select').select2({
                    placeholder: "Select or type languages",
                    tags: true,
                    width: '100%',
                    tokenSeparators: [',']
                });
            });
        </script>
@endsection