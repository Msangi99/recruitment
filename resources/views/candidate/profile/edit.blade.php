@extends('layouts.app')

@section('title', 'Edit Profile - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="lg:ml-64 pt-16 lg:pt-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.profile.show') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Profile</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Edit Profile</h2>
                @if($profile->verification_status === 'approved')
                    <p class="mt-1 text-sm text-yellow-600">
                        <strong>Note:</strong> Editing your verified profile will reset it to pending status for admin review.
                    </p>
                @endif
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data" class="bg-white shadow-lg rounded-lg p-8">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Profile Picture</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-6">
                            @if($profile->profile_picture)
                                @php
                                    // Generate image URL - direct from public directory
                                    $imageUrl = asset($profile->profile_picture);
                                    $fileExists = file_exists(public_path($profile->profile_picture));
                                @endphp
                                @if($fileExists)
                                    <img src="{{ $imageUrl }}?v={{ time() }}" alt="Profile Picture" class="h-24 w-24 rounded-full object-cover border-2 border-gray-300"
                                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300" style="{{ $fileExists ? 'display:none;' : 'display:flex;' }}">
                                    <span class="text-gray-500 text-2xl font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @else
                                <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300">
                                    <span class="text-gray-500 text-2xl font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Upload Profile Picture</label>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/jpg,image/png,image/gif" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('profile_picture') border-red-300 @enderror"
                                   onchange="validateImageFile(this); console.log('File selected:', this.files[0]);">
                                <p class="mt-1 text-xs text-gray-500">JPEG, JPG, PNG or GIF. Max size: 2MB</p>
                                <p id="file-info" class="mt-1 text-xs text-blue-600 hidden"></p>
                                <div id="image-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <p class="text-sm text-red-600 font-medium" id="image-error-message"></p>
                                </div>
                                @error('profile_picture')
                                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                        <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
                                @if(session('error'))
                                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                        <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="mb-8 border-t pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Personal Information</h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}" required max="{{ date('Y-m-d', strtotime('-18 years')) }}" 
                                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('date_of_birth') border-red-300 @enderror">
                                @error('date_of_birth')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="citizenship" class="block text-sm font-medium text-gray-700 mb-2">Citizenship *</label>
                                <input type="text" id="citizenship" name="citizenship" value="{{ old('citizenship', $profile->citizenship) }}" required 
                                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('citizenship') border-red-300 @enderror"
                                       placeholder="e.g., Tanzanian">
                                @error('citizenship')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="residency_status" class="block text-sm font-medium text-gray-700 mb-2">Residency Status *</label>
                            <select id="residency_status" name="residency_status" required 
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('residency_status') border-red-300 @enderror">
                                <option value="">Select Status</option>
                                <option value="citizen" {{ old('residency_status', $profile->residency_status) == 'citizen' ? 'selected' : '' }}>Citizen</option>
                                <option value="permanent-resident" {{ old('residency_status', $profile->residency_status) == 'permanent-resident' ? 'selected' : '' }}>Permanent Resident</option>
                                <option value="work-permit" {{ old('residency_status', $profile->residency_status) == 'work-permit' ? 'selected' : '' }}>Work Permit</option>
                                <option value="visitor" {{ old('residency_status', $profile->residency_status) == 'visitor' ? 'selected' : '' }}>Visitor</option>
                            </select>
                            @error('residency_status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
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
                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">Marital Status *</label>
                                <select id="marital_status" name="marital_status" required 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('marital_status') border-red-300 @enderror">
                                    <option value="">Select</option>
                                    <option value="single" {{ old('marital_status', $profile->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('marital_status', $profile->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('marital_status', $profile->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('marital_status', $profile->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                @error('marital_status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Details -->
                <div class="mb-8 border-t pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Professional Details</h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">Education Level *</label>
                                <select id="education_level" name="education_level" required 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('education_level') border-red-300 @enderror">
                                    <option value="">Select</option>
                                    <option value="high-school" {{ old('education_level', $profile->education_level) == 'high-school' ? 'selected' : '' }}>High School</option>
                                    <option value="diploma" {{ old('education_level', $profile->education_level) == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="bachelor" {{ old('education_level', $profile->education_level) == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="master" {{ old('education_level', $profile->education_level) == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                    <option value="phd" {{ old('education_level', $profile->education_level) == 'phd' ? 'selected' : '' }}>PhD</option>
                                </select>
                                @error('education_level')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="years_of_experience" class="block text-sm font-medium text-gray-700 mb-2">Years of Experience *</label>
                                <input type="number" id="years_of_experience" name="years_of_experience" value="{{ old('years_of_experience', $profile->years_of_experience) }}" required min="0" max="50" 
                                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('years_of_experience') border-red-300 @enderror"
                                       placeholder="0">
                                @error('years_of_experience')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="skill-input" class="block text-sm font-medium text-gray-700 mb-2">Skills * (Press Enter after each skill)</label>
                            <div id="skills-container" class="mb-3 flex flex-wrap gap-2">
                                @php
                                    $skills = $profile->skills ?? collect();
                                    $skillsCollection = is_array($skills) ? collect($skills) : $skills;
                                @endphp
                                @if($skills && count($skillsCollection) > 0)
                                    @foreach($skillsCollection as $skill)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
                                            {{ is_object($skill) ? $skill->name : $skill }}
                                            <button type="button" onclick="removeSkill('{{ is_object($skill) ? $skill->name : $skill }}')" class="ml-2 text-indigo-600 hover:text-indigo-800">×</button>
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <input type="text" id="skill-input" placeholder="Type a skill and press Enter" 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <div id="skills-inputs-container"></div>
                            @error('skills')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="language-input" class="block text-sm font-medium text-gray-700 mb-2">Languages * (Press Enter after each language)</label>
                            <div id="languages-container" class="mb-3 flex flex-wrap gap-2">
                                @php
                                    $languages = $profile->languages ?? collect();
                                    $languagesCollection = is_array($languages) ? collect($languages) : $languages;
                                @endphp
                                @if($languages && count($languagesCollection) > 0)
                                    @foreach($languagesCollection as $language)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                            {{ is_object($language) ? $language->name : $language }}
                                            <button type="button" onclick="removeLanguage('{{ is_object($language) ? $language->name : $language }}')" class="ml-2 text-blue-600 hover:text-blue-800">×</button>
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <input type="text" id="language-input" placeholder="Type a language and press Enter" 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <div id="languages-inputs-container"></div>
                            @error('languages')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="mb-8 border-t pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Preferences</h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="expected_salary" class="block text-sm font-medium text-gray-700 mb-2">Expected Salary</label>
                                <input type="number" id="expected_salary" name="expected_salary" value="{{ old('expected_salary', $profile->expected_salary) }}" min="0" step="0.01" 
                                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('expected_salary') border-red-300 @enderror"
                                       placeholder="0.00">
                                @error('expected_salary')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                <select id="currency" name="currency" 
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('currency') border-red-300 @enderror">
                                    <option value="TZS" {{ old('currency', $profile->currency) == 'TZS' ? 'selected' : '' }}>TZS</option>
                                    <option value="USD" {{ old('currency', $profile->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                                @error('currency')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="target_destination" class="block text-sm font-medium text-gray-700 mb-2">Target Destination</label>
                            <input type="text" id="target_destination" name="target_destination" value="{{ old('target_destination', $profile->target_destination) }}" placeholder="e.g., Tanzania, Kenya, Remote" 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('target_destination') border-red-300 @enderror">
                            @error('target_destination')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $profile->is_available) ? 'checked' : '' }} 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_available" class="ml-3 block text-sm text-gray-700">
                                I am currently available for work
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('candidate.profile.show') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Client-side image validation
function validateImageFile(input) {
    const errorDiv = document.getElementById('image-error');
    const errorMessage = document.getElementById('image-error-message');
    const fileInfo = document.getElementById('file-info');
    const file = input.files[0];
    
    if (!file) {
        errorDiv.classList.add('hidden');
        fileInfo.classList.add('hidden');
        return;
    }
    
    // Show file info
    fileInfo.classList.remove('hidden');
    fileInfo.textContent = `Selected: ${file.name} (${(file.size / 1024).toFixed(2)} KB, ${file.type})`;
    
    // Check file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        errorDiv.classList.remove('hidden');
        errorMessage.textContent = 'Invalid file type. Please upload a JPEG, PNG, or GIF image.';
        input.value = '';
        fileInfo.classList.add('hidden');
        return;
    }
    
    // Check file size (2MB = 2 * 1024 * 1024 bytes)
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if (file.size > maxSize) {
        errorDiv.classList.remove('hidden');
        errorMessage.textContent = 'File size exceeds 2MB limit. Please upload a smaller image.';
        input.value = '';
        fileInfo.classList.add('hidden');
        return;
    }
    
    // Hide error if validation passes
    errorDiv.classList.add('hidden');
    console.log('File validated successfully:', {
        name: file.name,
        size: file.size,
        type: file.type
    });
}

@php
    $skillsForJs = [];
    $languagesForJs = [];
    
    if ($profile->skills) {
        $skillsCollection = is_array($profile->skills) ? collect($profile->skills) : $profile->skills;
        if (is_object($skillsCollection) && method_exists($skillsCollection, 'pluck')) {
            $skillsForJs = $skillsCollection->pluck('name')->toArray();
        } else {
            $skillsForJs = is_array($profile->skills) ? $profile->skills : [];
        }
    }
    
    if ($profile->languages) {
        $languagesCollection = is_array($profile->languages) ? collect($profile->languages) : $profile->languages;
        if (is_object($languagesCollection) && method_exists($languagesCollection, 'pluck')) {
            $languagesForJs = $languagesCollection->pluck('name')->toArray();
        } else {
            $languagesForJs = is_array($profile->languages) ? $profile->languages : [];
        }
    }
@endphp
let skills = @json(old('skills', $skillsForJs));
let languages = @json(old('languages', $languagesForJs));

// Skills input handler
document.getElementById('skill-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const skill = this.value.trim();
        if (skill && !skills.includes(skill)) {
            skills.push(skill);
            updateSkillsDisplay();
            this.value = '';
        }
    }
});

// Languages input handler
document.getElementById('language-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const language = this.value.trim();
        if (language && !languages.includes(language)) {
            languages.push(language);
            updateLanguagesDisplay();
            this.value = '';
        }
    }
});

function updateSkillsDisplay() {
    const container = document.getElementById('skills-container');
    container.innerHTML = skills.map((skill, index) => 
        `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
            ${skill.replace(/'/g, "&#39;")}
            <button type="button" onclick="removeSkillByIndex(${index})" class="ml-2 text-indigo-600 hover:text-indigo-800">×</button>
        </span>`
    ).join('');
    
    // Update hidden inputs for form submission
    updateSkillsInputs();
}

function updateSkillsInputs() {
    // Remove existing skill inputs
    const container = document.getElementById('skills-inputs-container');
    container.innerHTML = '';
    
    // Add new inputs for each skill
    skills.forEach(skill => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'skills[]';
        input.value = skill;
        container.appendChild(input);
    });
}

function updateLanguagesDisplay() {
    const container = document.getElementById('languages-container');
    container.innerHTML = languages.map((lang, index) => 
        `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
            ${lang.replace(/'/g, "&#39;")}
            <button type="button" onclick="removeLanguageByIndex(${index})" class="ml-2 text-blue-600 hover:text-blue-800">×</button>
        </span>`
    ).join('');
    
    // Update hidden inputs for form submission
    updateLanguagesInputs();
}

function updateLanguagesInputs() {
    // Remove existing language inputs
    const container = document.getElementById('languages-inputs-container');
    container.innerHTML = '';
    
    // Add new inputs for each language
    languages.forEach(language => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'languages[]';
        input.value = language;
        container.appendChild(input);
    });
}

function removeSkillByIndex(index) {
    skills.splice(index, 1);
    updateSkillsDisplay();
}

function removeLanguageByIndex(index) {
    languages.splice(index, 1);
    updateLanguagesDisplay();
}

// Initialize display on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSkillsDisplay();
    updateLanguagesDisplay();
    
    // Also update inputs when form is submitted
    document.querySelector('form').addEventListener('submit', function() {
        updateSkillsInputs();
        updateLanguagesInputs();
    });
});
</script>
@endsection