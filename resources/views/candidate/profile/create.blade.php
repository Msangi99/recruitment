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
                        <p class="mt-1 text-sm text-gray-500">Follow the 4-step process to create your professional profile
                        </p>
                    </div>

                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center text-indigo-600" data-step="1">
                                <div
                                    class="flex items-center justify-center w-10 h-10 border-2 border-indigo-600 rounded-full">
                                    <span class="text-indigo-600 font-semibold">1</span>
                                </div>
                                <span class="ml-2 text-sm font-medium">Personal Info</span>
                            </div>
                            <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                            <div class="flex items-center text-gray-400" data-step="2">
                                <div
                                    class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                                    <span class="text-gray-400 font-semibold">2</span>
                                </div>
                                <span class="ml-2 text-sm font-medium">Professional</span>
                            </div>
                            <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                            <div class="flex items-center text-gray-400" data-step="3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                                    <span class="text-gray-400 font-semibold">3</span>
                                </div>
                                <span class="ml-2 text-sm font-medium">Preferences</span>
                            </div>
                            <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                            <div class="flex items-center text-gray-400" data-step="4">
                                <div
                                    class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full">
                                    <span class="text-gray-400 font-semibold">4</span>
                                </div>
                                <span class="ml-2 text-sm font-medium">Review</span>
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
                                    <input type="date" name="date_of_birth" required
                                        max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gender *</label>
                                    <select name="gender" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Current Location *</label>
                                <input type="text" name="location" required
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="e.g., Dar es Salaam, Tanzania">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="nextStep(2)"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Next
                                    Step</button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 2: Professional Details -->
                    <div id="step2" class="bg-white shadow rounded-lg p-6 hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Step 2: Professional Details</h3>
                        <form id="form-step2" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">User Title *</label>
                                <input type="text" name="title" required
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="e.g., Senior Software Engineer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Professional Summary *</label>
                                <textarea name="description" required rows="3"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Briefly describe your professional background"></textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Education Level *</label>
                                    <select name="education_level" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select</option>
                                        <option value="high-school">High School</option>
                                        <option value="diploma">Diploma</option>
                                        <option value="bachelor">Bachelor's Degree</option>
                                        <option value="master">Master's Degree</option>
                                        <option value="phd">PhD</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Course/Field of Study *</label>
                                    <input type="text" name="course_studied" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="e.g., Computer Science, Business Administration">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Years of Experience *</label>
                                    <input type="number" name="years_of_experience" required min="0" max="50"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Experience Category *</label>
                                    <select name="experience_category_id" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select Category</option>
                                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Experience Description *</label>
                                <textarea name="experience_description" required rows="4"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="Describe your work experience in detail"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Skills *</label>
                                <select id="skills-select"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-32"
                                    multiple>
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd) to select multiple</p>
                                <input type="hidden" name="skills" id="skills-hidden">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Languages *</label>
                                <select id="languages-select"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-32"
                                    multiple>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->name }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd) to select multiple</p>
                                <input type="hidden" name="languages" id="languages-hidden">
                            </div>
                            <div class="flex justify-between">
                                <button type="button" onclick="prevStep(1)"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                                <button type="button" onclick="nextStep(3)"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Next
                                    Step</button>
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
                                    <input type="number" name="expected_salary" min="0" step="0.01"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Currency</label>
                                    <select name="currency"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="TZS">TZS</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target Destination</label>
                                <input type="text" name="target_destination" placeholder="e.g., Tanzania, Kenya, Remote"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_available" value="1" checked
                                        class="rounded border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">I am currently available for work</span>
                                </label>
                            </div>
                            <div class="flex justify-between">
                                <button type="button" onclick="prevStep(2)"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                                <button type="button" onclick="nextStep(4)"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Next
                                    Step</button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 4: Review & Submit -->
                    <div id="step4" class="bg-white shadow rounded-lg p-6 hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Step 4: Review & Submit</h3>

                        <div id="review-content" class="space-y-6 mb-6">
                            <!-- Review content will be populated by JS -->
                        </div>

                        <div class="bg-gray-50 rounded-md p-4 mb-4">
                            <p class="text-sm text-gray-700">
                                <strong>Note:</strong> Your profile will be reviewed by our admin team. You will be notified
                                once it's verified. Only verified profiles are visible to employers.
                            </p>
                        </div>
                        <form method="POST" action="{{ route('candidate.profile.submit') }}">
                            @csrf
                            <div class="flex justify-between">
                                <button type="button" onclick="prevStep(3)"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Previous</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Submit for
                                    Verification</button>
                            </div>
                        </form>
                    </div>
                </div>
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
        let currentStep = 1;
        let totalSteps = 4;
        let skills = [];
        let languages = [];

        function showStep(step) {
            for (let i = 1; i <= totalSteps; i++) {
                const el = document.getElementById('step' + i);
                if (el) el.classList.add('hidden');
            }
            const currentEl = document.getElementById('step' + step);
            if (currentEl) currentEl.classList.remove('hidden');

            if (step === 4) {
                populateReview();
            }
        }

        function nextStep(step) {
            if (step === 2) {
                submitStep1();
            } else if (step === 3) {
                submitStep2();
            } else if (step === 4) {
                submitStep3();
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
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

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
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showStep(2);
                        currentStep = 2;
                        updateProgressIndicator(2);
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                })
                .catch(error => alert('An error occurred. Please try again.'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        }

        function submitStep2() {
            const form = document.getElementById('form-step2');

            // Get values from Select2
            skills = $('#skills-select').val() || [];
            languages = $('#languages-select').val() || [];

            if (skills.length === 0) {
                alert('Please select at least one skill');
                $('#skills-select').select2('open');
                return;
            }
            if (languages.length === 0) {
                alert('Please select at least one language');
                $('#languages-select').select2('open');
                return;
            }

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            formData.set('skills', JSON.stringify(skills));
            formData.set('languages', JSON.stringify(languages));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

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
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showStep(3);
                        currentStep = 3;
                        updateProgressIndicator(3);
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                })
                .catch(error => alert('An error occurred. Please try again.'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        }

        function submitStep3() {
            const form = document.getElementById('form-step3');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

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
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showStep(4);
                        currentStep = 4;
                        updateProgressIndicator(4);
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                })
                .catch(error => alert('An error occurred. Please try again.'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        }

        function populateReview() {
            const step1Form = new FormData(document.getElementById('form-step1'));
            const step2Form = new FormData(document.getElementById('form-step2'));
            const step3Form = new FormData(document.getElementById('form-step3'));

            let html = `
                        <div class="border-b pb-4">
                            <h4 class="font-bold text-gray-900 mb-2">Personal Information</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <span class="text-gray-500">Date of Birth:</span> <span class="font-medium">${step1Form.get('date_of_birth')}</span>
                                <span class="text-gray-500">Gender:</span> <span class="font-medium">${step1Form.get('gender')}</span>
                                <span class="text-gray-500">Location:</span> <span class="font-medium">${step1Form.get('location')}</span>
                            </div>
                        </div>
                        <div class="border-b pb-4">
                            <h4 class="font-bold text-gray-900 mb-2">Professional Details</h4>
                            <div class="space-y-2 text-sm">
                                <div><span class="text-gray-500">Title:</span> <span class="font-medium">${step2Form.get('title')}</span></div>
                                <div><span class="text-gray-500">Summary:</span> <p class="mt-1">${step2Form.get('description')}</p></div>
                                <div class="grid grid-cols-2 gap-2">
                                    <span class="text-gray-500">Education:</span> <span class="font-medium">${step2Form.get('education_level')}</span>
                                    <span class="text-gray-500">Field:</span> <span class="font-medium">${step2Form.get('course_studied')}</span>
                                    <span class="text-gray-500">Experience:</span> <span class="font-medium">${step2Form.get('years_of_experience')} years</span>
                                </div>
                                <div><span class="text-gray-500">Experience Description:</span> <p class="mt-1">${step2Form.get('experience_description')}</p></div>
                                <div><span class="text-gray-500">Skills:</span> <span class="font-medium">${skills.join(', ')}</span></div>
                                <div><span class="text-gray-500">Languages:</span> <span class="font-medium">${languages.join(', ')}</span></div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">Preferences</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <span class="text-gray-500">Expected Salary:</span> <span class="font-medium">${step3Form.get('expected_salary')} ${step3Form.get('currency')}</span>
                                <span class="text-gray-500">Target Destination:</span> <span class="font-medium">${step3Form.get('target_destination') || 'Not specified'}</span>
                                <span class="text-gray-500">Available:</span> <span class="font-medium">${step3Form.get('is_available') ? 'Yes' : 'No'}</span>
                            </div>
                        </div>
                    `;

            document.getElementById('review-content').innerHTML = html;
        }

        function updateProgressIndicator(activeStep) {
            for (let i = 1; i <= totalSteps; i++) {
                const stepEl = document.querySelector(`[data-step="${i}"]`);
                if (!stepEl) continue;

                const circle = stepEl.querySelector('div');
                const number = stepEl.querySelector('span');

                if (i <= activeStep) {
                    stepEl.classList.remove('text-gray-400');
                    stepEl.classList.add('text-indigo-600');
                    if (circle) circle.classList.replace('border-gray-300', 'border-indigo-600');
                    if (number) number.classList.replace('text-gray-400', 'text-indigo-600');
                } else {
                    stepEl.classList.replace('text-indigo-600', 'text-gray-400');
                    if (circle) circle.classList.replace('border-indigo-600', 'border-gray-300');
                    if (number) number.classList.replace('text-indigo-600', 'text-gray-400');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateProgressIndicator(1);

            // Initialize Select2
            $('#skills-select').select2({
                placeholder: "Select or type skills",
                tags: true,
                width: '100%',
                tokenSeparators: [',']
            });

            $('#languages-select').select2({
                placeholder: "Select or type languages",
                tags: true,
                width: '100%',
                tokenSeparators: [',']
            });
        });
    </script>
@endsection