@extends('layouts.admin')

@section('title', 'Edit Job')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('admin.jobs.index') }}" class="hover:fb-blue flex items-center font-medium">
                <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                Back to Jobs
            </a>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xl font-bold text-gray-900">Edit Job Listing</h2>
                <p class="text-sm text-gray-500">Update details for: <span
                        class="fb-blue font-bold">{{ $job->title }}</span></p>
            </div>

            <form method="POST" action="{{ route('admin.jobs.update', $job) }}" class="p-6 md:p-8">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">
                            Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Job Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" required
                                    class="w-full border rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm {{ $errors->has('title') ? 'border-red-300' : 'border-gray-300' }}">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Category <span
                                        class="text-red-500">*</span></label>
                                <select id="category_id" name="category_id" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="employment_type" class="block text-sm font-bold text-gray-700 mb-2">Employment
                                    Type <span class="text-red-500">*</span></label>
                                <select id="employment_type" name="employment_type" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="full-time" {{ old('employment_type', $job->employment_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="seasonal" {{ old('employment_type', $job->employment_type) == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                                    <option value="temporary" {{ old('employment_type', $job->employment_type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                </select>
                            </div>

                            <div>
                                <label for="experience_required" class="block text-sm font-bold text-gray-700 mb-2">Work
                                    Experience (Years)</label>
                                <input type="number" id="experience_required" name="experience_required"
                                    value="{{ old('experience_required', $job->experience_required) }}" min="0"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            </div>

                            <div>
                                <label for="work_hours" class="block text-sm font-bold text-gray-700 mb-2">Hours of
                                    Work</label>
                                <select id="work_hours" name="work_hours"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="">Select Hours</option>
                                    <option value="full-time" {{ old('work_hours', $job->work_hours) == 'full-time' ? 'selected' : '' }}>Full time</option>
                                    <option value="part-time" {{ old('work_hours', $job->work_hours) == 'part-time' ? 'selected' : '' }}>Part time</option>
                                </select>
                            </div>

                            <div>
                                <label for="education_level" class="block text-sm font-bold text-gray-700 mb-2">Education
                                    Level</label>
                                <select id="education_level" name="education_level"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="">Any Education</option>
                                    <option value="no-formal-education" {{ old('education_level', $job->education_level) == 'no-formal-education' ? 'selected' : '' }}>No formal
                                        education</option>
                                    <option value="secondary-school" {{ old('education_level', $job->education_level) == 'secondary-school' ? 'selected' : '' }}>Secondary School
                                    </option>
                                    <option value="certificate" {{ old('education_level', $job->education_level) == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                    <option value="diploma" {{ old('education_level', $job->education_level) == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="bachelor" {{ old('education_level', $job->education_level) == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="master-plus" {{ old('education_level', $job->education_level) == 'master-plus' ? 'selected' : '' }}>Master's Degree+</option>
                                </select>
                            </div>

                            <div>
                                <label for="languages" class="block text-sm font-bold text-gray-700 mb-2">Language
                                    Requirement</label>
                                <select id="languages" name="languages"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="">Select Language</option>
                                    <option value="English" {{ old('languages', $job->languages) == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Arabic" {{ old('languages', $job->languages) == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                    <option value="French" {{ old('languages', $job->languages) == 'French' ? 'selected' : '' }}>French</option>
                                    <option value="Swahili" {{ old('languages', $job->languages) == 'Swahili' ? 'selected' : '' }}>Swahili</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Company & Location -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">
                            Company & Location</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1">
                                <label for="company_name" class="block text-sm font-bold text-gray-700 mb-2">Company Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="company_name" name="company_name"
                                    value="{{ old('company_name', $job->company_name) }}" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            </div>
                            <div class="md:col-span-1">
                                <label for="location" class="block text-sm font-bold text-gray-700 mb-2">City/Region <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="location" name="location"
                                    value="{{ old('location', $job->location) }}" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            </div>
                            <div class="md:col-span-1">
                                <label for="country" class="block text-sm font-bold text-gray-700 mb-2">Country <span
                                        class="text-red-500">*</span></label>
                                <select id="country" name="country" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="">Select Country</option>
                                    <option value="Canada" {{ old('country', $job->country) == 'Canada' ? 'selected' : '' }}>
                                        Canada</option>
                                    <option value="Poland" {{ old('country', $job->country) == 'Poland' ? 'selected' : '' }}>
                                        Poland</option>
                                    <option value="Germany" {{ old('country', $job->country) == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="Romania" {{ old('country', $job->country) == 'Romania' ? 'selected' : '' }}>Romania</option>
                                    <option value="Croatia" {{ old('country', $job->country) == 'Croatia' ? 'selected' : '' }}>Croatia</option>
                                    <option value="OMAN" {{ old('country', $job->country) == 'OMAN' ? 'selected' : '' }}>OMAN
                                    </option>
                                    <option value="Australia" {{ old('country', $job->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="QUATAR" {{ old('country', $job->country) == 'QUATAR' ? 'selected' : '' }}>
                                        QUATAR</option>
                                    <option value="Kuwait" {{ old('country', $job->country) == 'Kuwait' ? 'selected' : '' }}>
                                        Kuwait</option>
                                    <option value="United Arab Emirates" {{ old('country', $job->country) == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                    <option value="Saudi Arabia" {{ old('country', $job->country) == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                    <option value="Serbia" {{ old('country', $job->country) == 'Serbia' ? 'selected' : '' }}>
                                        Serbia</option>
                                    <option value="Bulgaria" {{ old('country', $job->country) == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                    <option value="Ukraine" {{ old('country', $job->country) == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                    <option value="Czech republic" {{ old('country', $job->country) == 'Czech republic' ? 'selected' : '' }}>Czech republic</option>
                                    <option value="Latvia" {{ old('country', $job->country) == 'Latvia' ? 'selected' : '' }}>
                                        Latvia</option>
                                    <option value="Slovakia" {{ old('country', $job->country) == 'Slovakia' ? 'selected' : '' }}>Slovakia</option>
                                    <option value="Lithuania" {{ old('country', $job->country) == 'Lithuania' ? 'selected' : '' }}>Lithuania</option>
                                    <option value="Other Countries" {{ old('country', $job->country) == 'Other Countries' ? 'selected' : '' }}>Other Countries</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Job Content -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">
                            Job Content</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Full Job
                                    Description <span class="text-red-500">*</span></label>
                                <textarea id="description" name="description" rows="8" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('description', $job->description) }}</textarea>
                            </div>

                            <div>
                                <label for="requirements" class="block text-sm font-bold text-gray-700 mb-2">Requirements &
                                    Qualifications</label>
                                <textarea id="requirements" name="requirements" rows="6"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('requirements', $job->requirements) }}</textarea>
                            </div>

                            <div>
                                <label for="benefits" class="block text-sm font-bold text-gray-700 mb-2">Benefits &
                                    Perks</label>
                                <textarea id="benefits" name="benefits" rows="6"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('benefits', $job->benefits) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
                    <script>
                        tinymce.init({
                            selector: '#description, #requirements, #benefits',
                            height: 300,
                            menubar: false,
                            plugins: 'lists link',
                            toolbar: 'undo redo | bold italic underline | bullist numlist | link',
                            statusbar: false
                        });
                    </script>

                    <!-- Salary & Status -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">
                            Salary & Visibility</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="salary_min" class="block text-sm font-bold text-gray-700 mb-2">Min
                                    Salary</label>
                                <input type="number" id="salary_min" name="salary_min"
                                    value="{{ old('salary_min', $job->salary_min) }}"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            </div>
                            <div>
                                <label for="salary_max" class="block text-sm font-bold text-gray-700 mb-2">Max
                                    Salary</label>
                                <input type="number" id="salary_max" name="salary_max"
                                    value="{{ old('salary_max', $job->salary_max) }}"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            </div>
                            <div>
                                <label for="salary_currency"
                                    class="block text-sm font-bold text-gray-700 mb-2">Currency</label>
                                <select id="salary_currency" name="salary_currency"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="TZS" {{ old('salary_currency', $job->salary_currency) == 'TZS' ? 'selected' : '' }}>TZS</option>
                                    <option value="USD" {{ old('salary_currency', $job->salary_currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('salary_currency', $job->salary_currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                </select>
                            </div>
                            <div>
                                <label for="salary_period" class="block text-sm font-bold text-gray-700 mb-2">Salary
                                    Period</label>
                                <select id="salary_period" name="salary_period"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                    <option value="monthly" {{ old('salary_period', $job->salary_period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="hourly" {{ old('salary_period', $job->salary_period) == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100 mt-6">
                            <div class="flex items-center h-5">
                                <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $job->is_active) ? 'checked' : '' }}
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <div class="ml-3 text-sm font-medium">
                                <label for="is_active" class="font-bold text-gray-700">Publish Listing</label>
                                <p class="text-gray-500">Uncheck to hide this job from candidates without deleting it.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-8 border-t border-gray-200">
                        <a href="{{ route('admin.jobs.show', $job) }}"
                            class="w-full sm:w-auto px-10 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-colors text-center shadow-sm">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-10 py-3 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm flex items-center justify-center text-base">
                            <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                            Update Job Listing
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection