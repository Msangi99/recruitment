@extends('layouts.admin')

@section('title', 'Post New Job')

@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border-radius: 1rem !important;
            padding: 8px 12px !important;
            border-color: #e2e8f0 !important;
            min-height: 45px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6 !important;
            ring: 2px #dbeafe !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #eff6ff !important;
            border: 1px solid #dbeafe !important;
            color: #1d4ed8 !important;
            border-radius: 0.75rem !important;
            padding: 2px 8px !important;
            font-weight: 700 !important;
            font-size: 0.75rem !important;
            margin-top: 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #3b82f6 !important;
            margin-right: 5px !important;
            border-right: none !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: transparent !important;
            color: #1d4ed8 !important;
        }

        .select2-dropdown {
            border-radius: 1rem !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            padding: 8px !important;
        }

        .select2-results__option {
            background-color: transparent !important;
            color: #475569 !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            border-radius: 0.75rem !important;
            padding: 8px 12px !important;
            margin-bottom: 2px !important;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: #f1f5f9 !important;
            color: #2563eb !important;
        }

        .select2-results__option[aria-selected=true] {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }
    </style>

    <div class="max-w-4xl mx-auto mb-12" x-data="jobWizard()">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-3">
                <a href="{{ route('admin.jobs.index') }}" class="hover:text-blue-600 flex items-center font-medium">
                    <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                    Back to Jobs
                </a>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Post a New Job</h1>
            {{-- <p class="text-gray-500 mt-1">Follow the steps below to create and publish a new job listing.</p> --}}
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold text-blue-600 uppercase tracking-wider"
                    x-text="'Step ' + step + ' of 4'"></span>
                <span class="text-sm font-bold text-gray-900" x-text="stepTitle()"></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 shadow-sm overflow-hidden">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500 ease-out"
                    :style="'width: ' + (step * 25) + '%'"></div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow-xl border border-gray-100 rounded-3xl overflow-hidden">
            <form action="{{ route('admin.jobs.store') }}" method="POST" id="jobForm">
                @csrf

                <!-- Step 1: Job Description -->
                <div x-show="step === 1" x-cloak class="p-6 md:p-8 space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Step 1: Job Description</h2>
                        <p class="text-gray-500 mt-1">Provide clear and accurate job information to attract candidates.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Job Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-1.5">Job Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                placeholder="e.g., Senior Software Engineer">
                        </div>

                        <!-- Job Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700 mb-1.5">Job Category <span
                                    class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" required
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Employment Type -->
                        <div>
                            <label for="employment_type" class="block text-sm font-bold text-gray-700 mb-1.5">Employment
                                Type
                                <span class="text-red-500">*</span></label>
                            <select name="employment_type" id="employment_type" required
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                <option value="full-time">Full-time</option>
                                <option value="contract">Contract</option>
                                <option value="temporary">Temporary</option>
                            </select>
                        </div>

                        <!-- Job Location Type -->
                        <div>
                            <label for="job_location_type" class="block text-sm font-bold text-gray-700 mb-1.5">Job Location
                                <span class="text-red-500">*</span></label>
                            <select name="job_location_type" id="job_location_type" required
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                <option value="Local">Local</option>
                                <option value="Abroad">Abroad</option>
                            </select>
                        </div>

                        <!-- Contract Duration -->
                        <div>
                            <label for="contract_duration" class="block text-sm font-bold text-gray-700 mb-1.5">Contract
                                Duration</label>
                            <input type="text" name="contract_duration" id="contract_duration"
                                value="{{ old('contract_duration') }}"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                placeholder="e.g. 2 Years, Indefinite">
                        </div>

                        <!-- Working Mode -->
                        <div>
                            <label for="working_mode" class="block text-sm font-bold text-gray-700 mb-1.5">Working
                                Mode</label>
                            <select name="working_mode" id="working_mode"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                <option value="On-site">On-site</option>
                                <option value="Remote">Remote</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                        </div>

                        <!-- Application Deadline -->
                        <div>
                            <label for="application_deadline"
                                class="block text-sm font-bold text-gray-700 mb-1.5">Application
                                Deadline</label>
                            <input type="date" name="application_deadline" id="application_deadline"
                                value="{{ old('application_deadline') }}"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all">
                        </div>

                        <!-- Detailed Location & Company -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5 pt-4">
                            <div>
                                <label for="company_name" class="block text-sm font-bold text-gray-700 mb-1.5">Company Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="company_name" id="company_name" required
                                    value="{{ old('company_name') }}"
                                    class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                    placeholder="Coyzon Ltd">
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-bold text-gray-700 mb-1.5">Country <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="country" id="country" required value="{{ old('country') }}"
                                    class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                    placeholder="e.g., Tanzania">
                            </div>
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-bold text-gray-700 mb-1.5">City/Region <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="location" id="location" required
                                    value="{{ old('location', 'Dar es Salaam') }}"
                                    class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                    placeholder="e.g., Masaki, Dar es Salaam">
                            </div>
                        </div>

                        <!-- Salary Range -->
                        <div class="md:col-span-2 pt-6 border-t border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Salary Range</h3>
                            <p class="text-sm text-gray-500 mb-4">Specify the salary details. Visible to candidates.</p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label for="salary_min" class="block text-sm font-bold text-gray-700 mb-1.5">Min
                                        Salary</label>
                                    <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min') }}"
                                        class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label for="salary_max" class="block text-sm font-bold text-gray-700 mb-1.5">Max
                                        Salary</label>
                                    <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max') }}"
                                        class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label for="salary_period" class="block text-sm font-bold text-gray-700 mb-1.5">Pay
                                        Type</label>
                                    <select name="salary_period" id="salary_period"
                                        class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                        <option value="hourly">Hourly</option>
                                        <option value="monthly" selected>Monthly</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="annual">Annual</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="salary_currency"
                                        class="block text-sm font-bold text-gray-700 mb-1.5">Currency</label>
                                    <div class="relative" x-data="{ otherCurrency: false }">
                                        <select name="salary_currency" id="salary_currency" x-show="!otherCurrency"
                                            class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                            <option value="TZS">TZS – Tanzanian Shilling</option>
                                            <option value="USD" selected>USD – US Dollar</option>
                                            <option value="EUR">EUR – Euro</option>
                                            <option value="GBP">GBP – British Pound</option>
                                            <option value="CAD">CAD – Canadian Dollar</option>
                                            <option value="AUD">AUD – Australian Dollar</option>
                                            <option value="SAR">SAR – Saudi Riyal</option>
                                            <option value="AED">AED – UAE Dirham</option>
                                            <option value="QAR">QAR – Qatari Riyal</option>
                                            <option value="KWD">KWD – Kuwaiti Dinar</option>
                                            <option value="OMR">OMR – Omani Rial</option>
                                            <option value="ZAR">ZAR – South African Rand</option>
                                            <option value="OTHER">Other Currency</option>
                                        </select>
                                        {{-- <div class="mt-1.5 text-right">
                                            <button type="button" @click="otherCurrency = !otherCurrency"
                                                class="text-xs text-blue-600 font-bold hover:underline"
                                                x-text="otherCurrency ? 'Select from list' : 'Other currency?'"></button>
                                        </div>
                                        <input type="text" name="custom_currency" x-show="otherCurrency" x-cloak
                                            class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                            placeholder="Enter Currency Code (e.g. JPY, CNY)"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Job Description Editor -->
                        <div class="md:col-span-2 pt-6 border-t border-gray-100">
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-1.5">Job Description
                                <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="8"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Candidate Requirements -->
                <div x-show="step === 2" x-cloak class="p-6 md:p-8 space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Step 2: Candidate Requirements</h2>
                        <p class="text-gray-500 mt-1">Define the qualifications and conditions required for this position.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Required Skills (Select2 Multiselect) -->
                        <div class="md:col-span-2">
                            <label for="skills_select" class="block text-sm font-bold text-gray-700 mb-2">Required
                                Skills</label>
                            <select id="skills_select" multiple="multiple" class="w-full">
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-[10px] text-slate-400 font-medium italic">Select skills from the list or
                                type to search. These are predefined in Admin settings.</p>
                            <input type="hidden" name="required_skills" id="required_skills_input">
                        </div>

                        <!-- Experience Level -->
                        <div>
                            <label for="experience_years" class="block text-sm font-bold text-gray-700 mb-1.5">Experience
                                (Years)</label>
                            <input type="number" name="experience_years" id="experience_years"
                                value="{{ old('experience_years') }}"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                placeholder="e.g. 3">
                        </div>

                        <!-- Education Level -->
                        <div>
                            <label for="education_level"
                                class="block text-sm font-bold text-gray-700 mb-1.5">Education</label>
                            <select name="education_level" id="education_level"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all bg-white">
                                <option value="">Select Level</option>
                                <option value="No Formal Education">No Formal Education</option>
                                <option value="Secondary Education">Secondary Education</option>
                                <option value="Certificate">Certificate</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Advanced Diploma">Advanced Diploma</option>
                                <option value="Bachelor’s Degree">Bachelor’s Degree</option>
                                <option value="Postgraduate Diploma">Postgraduate Diploma</option>
                                <option value="Master’s Degree">Master’s Degree</option>
                            </select>
                        </div>

                        <!-- Language Requirements -->
                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-3xl border border-gray-100" x-data="{
                                        languages: [],
                                        currentLang: 'English',
                                        currentProf: 'Fluent',
                                        addLang() {
                                            this.languages.push({ name: this.currentLang, proficiency: this.currentProf });
                                        },
                                        removeLang(index) {
                                            this.languages.splice(index, 1);
                                        }
                                    }">
                            <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Language Requirements
                            </h3>

                            <div class="space-y-2 mb-4">
                                <template x-for="(lang, index) in languages" :key="index">
                                    <div
                                        class="flex items-center justify-between bg-white p-2.5 px-4 rounded-2xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center gap-4">
                                            <span class="font-bold text-gray-900" x-text="lang.name"></span>
                                            <span
                                                class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-lg font-bold"
                                                x-text="lang.proficiency"></span>
                                        </div>
                                        <button type="button" @click="removeLang(index)"
                                            class="text-red-400 hover:text-red-600">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 items-end">
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-500 mb-1.5 uppercase">Language</label>
                                    <select x-model="currentLang"
                                        class="w-full border-gray-200 rounded-xl px-4 py-2 bg-white text-sm">
                                        <option value="English">English</option>
                                        <option value="Swahili">Swahili</option>
                                        <option value="Arabic">Arabic</option>
                                        <option value="French">French</option>
                                        <option value="German">German</option>
                                        <option value="Italian">Italian</option>
                                        <option value="Spanish">Spanish</option>
                                        <option value="Portuguese">Portuguese</option>
                                        <option value="Chinese">Chinese</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-500 mb-1.5 uppercase">Proficiency</label>
                                    <select x-model="currentProf"
                                        class="w-full border-gray-200 rounded-xl px-4 py-2 bg-white text-sm">
                                        <option value="Basic">Basic</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Fluent">Fluent</option>
                                        <option value="Professional">Professional</option>
                                        <option value="Native">Native</option>
                                    </select>
                                </div>
                                <button type="button" @click="addLang()"
                                    class="bg-blue-600 text-white rounded-xl px-4 py-2 font-bold hover:bg-blue-700 transition-all text-sm">Add</button>
                            </div>
                            <input type="hidden" name="languages" :value="JSON.stringify(languages)">
                        </div>

                        <!-- Clearances & Options -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-gray-100">
                            <div
                                class="flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                                <span class="text-sm font-bold text-gray-700">Willing to Relocate</span>
                                <div class="flex items-center gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="willing_to_relocate" value="1" class="text-blue-600">
                                        <span class="ml-1.5 text-xs font-medium">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="willing_to_relocate" value="0" checked
                                            class="text-blue-600">
                                        <span class="ml-1.5 text-xs font-medium">No</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm"
                                x-data="{ required: false }">
                                <div>
                                    <span class="text-sm font-bold text-gray-700 block">Valid Passport</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="required_passport" value="1" x-model="required"
                                            @change="required = true" class="text-blue-600">
                                        <span class="ml-1.5 text-xs font-medium">Required</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="required_passport" value="0" x-model="required"
                                            @change="required = false" checked class="text-blue-600">
                                        <span class="ml-1.5 text-xs font-medium">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Job Benefits -->
                <div x-show="step === 3" x-cloak class="p-6 md:p-8 space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Step 3: Requirements & Benefits</h2>
                        <p class="text-gray-500 mt-1">Provide clear job requirements and the benefits offered.</p>
                    </div>

                    <div class="pb-6 border-b border-gray-100">
                        <label for="requirements" class="block text-sm font-bold text-gray-700 mb-1.5">Job
                            Requirement</label>
                        <textarea name="requirements" id="requirements" rows="6"
                            class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all">{{ old('requirements') }}</textarea>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Select Benefits</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @php
                                $availableBenefits = [
                                    'Competitive Salary',
                                    'Overtime Pay',
                                    'Free Accommodation',
                                    'Transport Provided',
                                    'Meals Provided',
                                    'Health Insurance',
                                    'Work Visa Sponsorship',
                                    'Annual Leave',
                                    'Paid Holidays',
                                    'End of Service Benefits',
                                    'Training Provided',
                                    'Performance Bonus',
                                    'Air Ticket Provided',
                                    'Contract Renewal',
                                    'Family Sponsorship',
                                    'Tax-Free Salary'
                                ];
                            @endphp

                            @foreach($availableBenefits as $benefit)
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-2xl border border-transparent hover:border-blue-200 hover:bg-blue-50 transition-all cursor-pointer group">
                                    <input type="checkbox" name="benefits[]" value="{{ $benefit }}"
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span
                                        class="ml-2.5 text-xs font-bold text-gray-700 group-hover:text-blue-700">{{ $benefit }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label for="other_benefits" class="block text-sm font-bold text-gray-700 mb-1.5">Other
                                Benefits</label>
                            <textarea name="other_benefits" id="other_benefits" rows="3"
                                class="w-full border-gray-200 rounded-2xl px-5 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all"
                                placeholder="Optional..."></textarea>
                        </div>
                    </div>

                    <!-- Step 4: Review & Publish -->
                    <div x-show="step === 4" x-cloak class="p-6 md:p-8 space-y-8">
                        <div class="text-center max-w-xl mx-auto">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-600 mb-4 font-extrabold text-2xl">
                                4</div>
                            <h2 class="text-2xl font-bold text-gray-900">Review & Publish Job</h2>
                            <p class="text-slate-500 mt-1 text-sm font-medium">Review your job post before publishing to
                                ensure accuracy and professionalism.</p>
                        </div>

                        <div class="bg-gray-50 rounded-[2rem] p-6 md:p-8 border border-gray-100">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[3px] mb-3">Final
                                        Checks
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5"></i>
                                            <p class="ml-2.5 text-xs text-gray-600 font-bold">Content is clear and accurate.
                                            </p>
                                        </li>
                                    </ul>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                                    <button type="button" @click="step = 1"
                                        class="flex-1 px-6 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-bold hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm text-sm">
                                        Edit Details
                                    </button>
                                    <button type="button" @click="previewJob()"
                                        class="flex-1 px-6 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-bold hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm text-sm">
                                        Preview Post
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row items-center gap-6 pt-4">
                            <div class="flex items-center gap-3">
                                <input id="is_draft_cb" name="is_draft_cb" type="checkbox" value="1"
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-md">
                                <label for="is_draft_cb"
                                    class="text-xs font-bold text-gray-700 uppercase tracking-widest">Save
                                    as Draft</label>
                            </div>

                            <div class="ml-auto w-full md:w-auto flex flex-col md:flex-row gap-4">
                                <button type="button" @click="submitAsDraft()"
                                    class="px-8 py-4 bg-gray-100 text-gray-700 rounded-2xl font-black hover:bg-gray-200 transition-all text-xs uppercase tracking-widest">
                                    Save Draft
                                </button>
                                <button type="submit"
                                    class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black hover:bg-blue-700 transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2 text-xs uppercase tracking-widest">
                                    Publish Job
                                    <i data-lucide="rocket" class="w-4 h-4"></i>
                                </button>
                            </div>
                            <input id="is_draft" name="is_draft" type="hidden" value="0">
                        </div>
                    </div>

                    <!-- Footer Navigation -->
                    <div class="p-6 border-t border-gray-50 bg-gray-50/50 flex items-center justify-between">
                        <button type="button" @click="prevStep()" x-show="step > 1"
                            class="px-6 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-600 font-bold hover:bg-gray-50 transition-all flex items-center gap-2 shadow-sm text-sm">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Previous
                        </button>
                        <div x-show="step === 1"></div>

                        <button type="button" @click="nextStep()" x-show="step < 4"
                            class="px-8 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all flex items-center gap-2 shadow-lg shadow-blue-100 text-sm">
                            Next Step
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <!-- JQuery & Select2 JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
        <script>
            function jobWizard() {
                return {
                    step: 1,
                    stepTitle() {
                        switch (this.step) {
                            case 1: return 'Job Description';
                            case 2: return 'Candidate Requirements';
                            case 3: return 'Job Benefits';
                            case 4: return 'Review & Publish';
                            default: return '';
                        }
                    },
                    nextStep() {
                        if (this.step < 4) this.step++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },
                    prevStep() {
                        if (this.step > 1) this.step--;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },
                    previewJob() {
                        alert('Job Preview functionality would open here.');
                    },
                    submitAsDraft() {
                        document.getElementById('is_draft').value = '1';
                        document.getElementById('jobForm').submit();
                    }
                }
            }

            $(document).ready(function () {
                $('#skills_select').select2({
                    placeholder: "Select skills...",
                    allowClear: true,
                    width: '100%',
                    tags: true // Allow adding custom skills if not in DB
                });

                // Update hidden input on change
                $('#skills_select').on('change', function () {
                    const selected = $(this).val();
                    $('#required_skills_input').val(JSON.stringify(selected));
                });

                tinymce.init({
                    selector: '#description, #other_benefits, #requirements',
                    height: 300,
                    menubar: false,
                    plugins: 'lists link',
                    toolbar: 'undo redo | bold italic | bullist numlist | link',
                    statusbar: false,
                    content_style: 'body { font-family: Plus Jakarta Sans, sans-serif; font-size: 14px; color: #374151; }'
                });
            });
        </script>
    @endpush
@endsection