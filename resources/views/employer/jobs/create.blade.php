@extends('layouts.app')

@section('title', 'Post Job - Employer')

@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('employer.partials.nav')

        <div class="lg:ml-64 pt-16 lg:pt-6">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="px-4 py-6 sm:px-0">
                    <div class="mb-6">
                        <a href="{{ route('employer.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to
                            Jobs</a>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900">Post New Job</h2>
                    </div>

                    <form method="POST" action="{{ route('employer.jobs.store') }}"
                        class="bg-white shadow-lg rounded-lg p-8">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('title') border-red-300 @enderror"
                                    placeholder="e.g., Senior Software Developer">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category
                                        *</label>
                                    <select id="category_id" name="category_id" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('category_id') border-red-300 @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="employment_type"
                                        class="block text-sm font-medium text-gray-700 mb-2">Employment Type *</label>
                                    <select id="employment_type" name="employment_type" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('employment_type') border-red-300 @enderror">
                                        <option value="">Select Type</option>
                                        <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>
                                            Contract</option>
                                        <option value="temporary" {{ old('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                        <option value="seasonal" {{ old('employment_type') == 'seasonal' ? 'selected' : '' }}>
                                            Seasonal</option>
                                    </select>
                                    @error('employment_type')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="working_mode" class="block text-sm font-medium text-gray-700 mb-2">Working
                                        Mode</label>
                                    <select id="working_mode" name="working_mode"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select Working Mode</option>
                                        <option value="on-site" {{ old('working_mode') == 'on-site' ? 'selected' : '' }}>
                                            On-site</option>
                                        <option value="remote" {{ old('working_mode') == 'remote' ? 'selected' : '' }}>Remote
                                        </option>
                                        <option value="hybrid" {{ old('working_mode') == 'hybrid' ? 'selected' : '' }}>Hybrid
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="industry"
                                        class="block text-sm font-medium text-gray-700 mb-2">Industry</label>
                                    <select id="industry" name="industry"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select Industry</option>
                                        <option value="Construction" {{ old('industry') == 'Construction' ? 'selected' : '' }}>Construction</option>
                                        <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>
                                            Healthcare</option>
                                        <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="Agriculture" {{ old('industry') == 'Agriculture' ? 'selected' : '' }}>
                                            Agriculture</option>
                                        <option value="Transport & Logistics" {{ old('industry') == 'Transport & Logistics' ? 'selected' : '' }}>Transport & Logistics</option>
                                        <option value="Hospitality" {{ old('industry') == 'Hospitality' ? 'selected' : '' }}>
                                            Hospitality</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="experience_level"
                                        class="block text-sm font-medium text-gray-700 mb-2">Experience Level</label>
                                    <select id="experience_level" name="experience_level"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select Experience Level</option>
                                        <option value="no-experience" {{ old('experience_level') == 'no-experience' ? 'selected' : '' }}>No Experience</option>
                                        <option value="mid-level" {{ old('experience_level') == 'mid-level' ? 'selected' : '' }}>Mid-level</option>
                                        <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>
                                            Senior</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="education_level"
                                        class="block text-sm font-medium text-gray-700 mb-2">Education Level</label>
                                    <select id="education_level" name="education_level"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="">Select Education Level</option>
                                        <option value="no-education" {{ old('education_level') == 'no-education' ? 'selected' : '' }}>No Education</option>
                                        <option value="certificate" {{ old('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                        <option value="diploma" {{ old('education_level') == 'diploma' ? 'selected' : '' }}>
                                            Diploma</option>
                                        <option value="degree" {{ old('education_level') == 'degree' ? 'selected' : '' }}>
                                            Degree</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="visa_sponsorship" class="block text-sm font-medium text-gray-700 mb-2">Visa
                                        Sponsorship</label>
                                    <select id="visa_sponsorship" name="visa_sponsorship"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="0" {{ old('visa_sponsorship') == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('visa_sponsorship') == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="languages" class="block text-sm font-medium text-gray-700 mb-2">Language
                                        Requirements</label>
                                    <select id="languages" name="languages[]" multiple
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm h-24">
                                        <option value="English" {{ (is_array(old('languages')) && in_array('English', old('languages'))) ? 'selected' : '' }}>English</option>
                                        <option value="Arabic" {{ (is_array(old('languages')) && in_array('Arabic', old('languages'))) ? 'selected' : '' }}>Arabic</option>
                                        <option value="French" {{ (is_array(old('languages')) && in_array('French', old('languages'))) ? 'selected' : '' }}>French</option>
                                        <option value="Swahili" {{ (is_array(old('languages')) && in_array('Swahili', old('languages'))) ? 'selected' : '' }}>Swahili</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd) to select multiple</p>
                                </div>
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name
                                    *</label>
                                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                    required
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('company_name') border-red-300 @enderror"
                                    placeholder="Your company name">
                                @error('company_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location
                                        *</label>
                                    <input type="text" id="location" name="location" value="{{ old('location') }}" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('location') border-red-300 @enderror"
                                        placeholder="e.g., Dar es Salaam">
                                    @error('location')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country
                                        *</label>
                                    <input type="text" id="country" name="country" value="{{ old('country') }}" required
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('country') border-red-300 @enderror"
                                        placeholder="e.g., Tanzania">
                                    @error('country')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job
                                    Description *</label>
                                <textarea id="description" name="description" rows="6" required
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('description') border-red-300 @enderror"
                                    placeholder="Describe the job role, responsibilities, and what you're looking for...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="requirements"
                                    class="block text-sm font-medium text-gray-700 mb-2">Requirements</label>
                                <textarea id="requirements" name="requirements" rows="4"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="List the required qualifications, skills, and experience...">{{ old('requirements') }}</textarea>
                            </div>

                            <div>
                                <label for="other_benefits" class="block text-sm font-medium text-gray-700 mb-2">Benefits &
                                    Perks</label>
                                <textarea id="other_benefits" name="other_benefits" rows="4"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    placeholder="List additional benefits, insurance, accommodation, etc...">{{ old('other_benefits') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-2">Salary
                                        Min</label>
                                    <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min') }}"
                                        step="0.01"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-2">Salary
                                        Max</label>
                                    <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max') }}"
                                        step="0.01"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label for="salary_currency"
                                        class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                    <select id="salary_currency" name="salary_currency"
                                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        <option value="TZS" {{ old('salary_currency') == 'TZS' ? 'selected' : '' }}>TZS
                                        </option>
                                        <option value="USD" {{ old('salary_currency') == 'USD' ? 'selected' : '' }}>USD
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active') ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-3 block text-sm text-gray-700">
                                        Active (Job will be visible to candidates)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="requires_video" name="requires_video" type="checkbox" value="1" {{ old('requires_video') ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="requires_video" class="ml-3 block text-sm text-gray-700">
                                        Require video application (Candidates must upload a video when applying)
                                    </label>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('employer.jobs.index') }}"
                                    class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Post Job
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection