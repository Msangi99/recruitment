@extends('layouts.app')

@section('title', 'Create Profile - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="lg:ml-64 pt-16 lg:pt-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Complete Your Profile</h2>
                <p class="mt-1 text-sm text-gray-500">Follow the 5-step process to create your professional profile</p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex items-center text-indigo-600" data-step="1">
                        <div class="flex items-center justify-center w-10 h-10 border-2 border-indigo-600 rounded-full">
                            <span class="text-indigo-600 font-semibold">1</span>
                        </div>
                        <span class="ml-2 text-sm font-medium">Personal Info</span>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400" data-step="2">
                        <div class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                            <span class="text-gray-400 font-semibold">2</span>
                        </div>
                        <span class="ml-2 text-sm font-medium">Professional</span>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400" data-step="3">
                        <div class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                            <span class="text-gray-400 font-semibold">3</span>
                        </div>
                        <span class="ml-2 text-sm font-medium">Preferences</span>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400" data-step="4">
                        <div class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                            <span class="text-gray-400 font-semibold">4</span>
                        </div>
                        <span class="ml-2 text-sm font-medium">Documents</span>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400" data-step="5">
                        <div class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                            <span class="text-gray-400 font-semibold">5</span>
                        </div>
                        <span class="ml-2 text-sm font-medium">Submit</span>
                    </div>
                </div>
            </div>

            <!-- Step 1: Personal Information -->
            <div id="step1" class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Step 1: Personal Information</h3>
                <form id="form-step1" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                            <input type="date" name="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Citizenship *</label>
                            <input type="text" name="citizenship" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="e.g., Tanzanian">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Residency Status *</label>
                        <select name="residency_status" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="">Select Status</option>
                            <option value="citizen">Citizen</option>
                            <option value="permanent-resident">Permanent Resident</option>
                            <option value="work-permit">Work Permit</option>
                            <option value="visitor">Visitor</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender *</label>
                            <select name="gender" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Marital Status *</label>
                            <select name="marital_status" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                <option value="">Select</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="nextStep(2)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Next Step</button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Professional Details -->
            <div id="step2" class="bg-white shadow rounded-lg p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Step 2: Professional Details</h3>
                <form id="form-step2" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Education Level *</label>
                        <select name="education_level" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="">Select</option>
                            <option value="high-school">High School</option>
                            <option value="diploma">Diploma</option>
                            <option value="bachelor">Bachelor's Degree</option>
                            <option value="master">Master's Degree</option>
                            <option value="phd">PhD</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Years of Experience *</label>
                        <input type="number" name="years_of_experience" required min="0" max="50" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Skills * (Press Enter after each skill)</label>
                        <div id="skills-container" class="mt-2 flex flex-wrap gap-2 mb-2"></div>
                        <input type="text" id="skill-input" placeholder="Type a skill and press Enter" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <input type="hidden" name="skills" id="skills-hidden">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Languages * (Press Enter after each language)</label>
                        <div id="languages-container" class="mt-2 flex flex-wrap gap-2 mb-2"></div>
                        <input type="text" id="language-input" placeholder="Type a language and press Enter" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <input type="hidden" name="languages" id="languages-hidden">
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(1)" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                        <button type="button" onclick="nextStep(3)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Next Step</button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Preferences -->
            <div id="step3" class="bg-white shadow rounded-lg p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Step 3: Preferences</h3>
                <form id="form-step3" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expected Salary</label>
                            <input type="number" name="expected_salary" min="0" step="0.01" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Currency</label>
                            <select name="currency" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                <option value="TZS">TZS</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Target Destination</label>
                        <input type="text" name="target_destination" placeholder="e.g., Tanzania, Kenya, Remote" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_available" value="1" checked class="rounded border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">I am currently available for work</span>
                        </label>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(2)" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                        <button type="button" onclick="nextStep(4)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Next Step</button>
                    </div>
                </form>
            </div>

            <!-- Step 4: Documents -->
            <div id="step4" class="bg-white shadow rounded-lg p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Step 4: Upload Documents</h3>
                <p class="text-sm text-gray-500 mb-4">Upload your CV and identification documents. You can add more documents later.</p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CV/Resume *</label>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">PDF, DOC, or DOCX (Max 10MB)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID/Passport</label>
                        <input type="file" name="id" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(3)" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                        <button type="button" onclick="nextStep(5)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Continue to Review</button>
                    </div>
                </div>
            </div>

            <!-- Step 5: Submit -->
            <div id="step5" class="bg-white shadow rounded-lg p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Step 5: Review & Submit</h3>
                <p class="text-sm text-gray-500 mb-4">Review your information and submit for admin verification.</p>
                <div class="bg-gray-50 rounded-md p-4 mb-4">
                    <p class="text-sm text-gray-700">
                        <strong>Note:</strong> Your profile will be reviewed by our admin team. You will be notified once it's verified. Only verified profiles are visible to employers.
                    </p>
                </div>
                <form method="POST" action="{{ route('candidate.profile.submit') }}">
                    @csrf
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(4)" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Submit for Verification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let currentStep = 1;
let skills = [];
let languages = [];

function showStep(step) {
    for (let i = 1; i <= 5; i++) {
        document.getElementById('step' + i).classList.add('hidden');
    }
    document.getElementById('step' + step).classList.remove('hidden');
}

function nextStep(step) {
    if (step === 2) {
        submitStep1();
    } else if (step === 3) {
        submitStep2();
    } else if (step === 4) {
        submitStep3();
    } else if (step === 5) {
        // Step 4 to 5 doesn't need server call, just show next step
        showStep(step);
        currentStep = step;
        updateProgressIndicator(5);
    } else {
        showStep(step);
        currentStep = step;
        updateProgressIndicator(step);
    }
}

function prevStep(step) {
    showStep(step);
    currentStep = step;
    updateProgressIndicator(step);
}

function submitStep1() {
    const form = document.getElementById('form-step1');
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const formData = new FormData(form);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="button"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    fetch('{{ route("candidate.profile.storeStep1") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showStep(2);
            currentStep = 2;
            updateProgressIndicator(2);
        } else {
            alert(data.message || 'An error occurred. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            let errorMsg = 'Validation errors:\n';
            for (let field in error.errors) {
                errorMsg += error.errors[field][0] + '\n';
            }
            alert(errorMsg);
        } else {
            alert(error.message || 'An error occurred. Please try again.');
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}

function submitStep2() {
    const form = document.getElementById('form-step2');
    
    // Validate skills and languages
    if (skills.length === 0) {
        alert('Please add at least one skill.');
        document.getElementById('skill-input').focus();
        return;
    }
    
    if (languages.length === 0) {
        alert('Please add at least one language.');
        document.getElementById('language-input').focus();
        return;
    }
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const formData = new FormData(form);
    formData.set('skills', JSON.stringify(skills));
    formData.set('languages', JSON.stringify(languages));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="button"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    fetch('{{ route("candidate.profile.storeStep2") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showStep(3);
            currentStep = 3;
            updateProgressIndicator(3);
        } else {
            alert(data.message || 'An error occurred. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            let errorMsg = 'Validation errors:\n';
            for (let field in error.errors) {
                errorMsg += error.errors[field][0] + '\n';
            }
            alert(errorMsg);
        } else {
            alert(error.message || 'An error occurred. Please try again.');
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}

function submitStep3() {
    const form = document.getElementById('form-step3');
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const formData = new FormData(form);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="button"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    fetch('{{ route("candidate.profile.storeStep3") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showStep(4);
            currentStep = 4;
            updateProgressIndicator(4);
        } else {
            alert(data.message || 'An error occurred. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            let errorMsg = 'Validation errors:\n';
            for (let field in error.errors) {
                errorMsg += error.errors[field][0] + '\n';
            }
            alert(errorMsg);
        } else {
            alert(error.message || 'An error occurred. Please try again.');
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}

function updateProgressIndicator(activeStep) {
    // Update progress indicators
    for (let i = 1; i <= 5; i++) {
        const stepEl = document.querySelector(`[data-step="${i}"]`);
        if (!stepEl) continue;
        
        const circle = stepEl.querySelector('div');
        const number = stepEl.querySelector('span');
        const label = stepEl.querySelector('.ml-2');
        
        if (i <= activeStep) {
            stepEl.classList.remove('text-gray-400');
            stepEl.classList.add('text-indigo-600');
            if (circle) {
                circle.classList.remove('border-gray-300');
                circle.classList.add('border-indigo-600');
            }
            if (number) {
                number.classList.remove('text-gray-400');
                number.classList.add('text-indigo-600');
            }
        } else {
            stepEl.classList.remove('text-indigo-600');
            stepEl.classList.add('text-gray-400');
            if (circle) {
                circle.classList.remove('border-indigo-600');
                circle.classList.add('border-gray-300');
            }
            if (number) {
                number.classList.remove('text-indigo-600');
                number.classList.add('text-gray-400');
            }
        }
    }
}

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
    container.innerHTML = skills.map(skill => 
        `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
            ${skill}
            <button type="button" onclick="removeSkill('${skill}')" class="ml-2 text-indigo-600 hover:text-indigo-800">×</button>
        </span>`
    ).join('');
    document.getElementById('skills-hidden').value = JSON.stringify(skills);
}

function updateLanguagesDisplay() {
    const container = document.getElementById('languages-container');
    container.innerHTML = languages.map(lang => 
        `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
            ${lang}
            <button type="button" onclick="removeLanguage('${lang}')" class="ml-2 text-blue-600 hover:text-blue-800">×</button>
        </span>`
    ).join('');
    document.getElementById('languages-hidden').value = JSON.stringify(languages);
}

function removeSkill(skill) {
    skills = skills.filter(s => s !== skill);
    updateSkillsDisplay();
}

function removeLanguage(language) {
    languages = languages.filter(l => l !== language);
    updateLanguagesDisplay();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateProgressIndicator(1);
    
    // Ensure skills and languages arrays are initialized
    if (typeof skills === 'undefined') {
        skills = [];
    }
    if (typeof languages === 'undefined') {
        languages = [];
    }
});
</script>
        </div>
    </div>
    </div>
</div>
@endsection