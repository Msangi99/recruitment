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
            <p class="text-sm text-gray-500">Update details for: <span class="fb-blue font-bold">{{ $job->title }}</span></p>
        </div>

        <form method="POST" action="{{ route('admin.jobs.update', $job) }}" class="p-6 md:p-8">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Job Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" required 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('title') border-red-300 @enderror">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="employment_type" class="block text-sm font-bold text-gray-700 mb-2">Employment Type <span class="text-red-500">*</span></label>
                            <select id="employment_type" name="employment_type" required 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                <option value="full-time" {{ old('employment_type', $job->employment_type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ old('employment_type', $job->employment_type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ old('employment_type', $job->employment_type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Company & Location -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Company & Location</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label for="company_name" class="block text-sm font-bold text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $job->company_name) }}" required 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div class="md:col-span-1">
                            <label for="location" class="block text-sm font-bold text-gray-700 mb-2">City/Region <span class="text-red-500">*</span></label>
                            <input type="text" id="location" name="location" value="{{ old('location', $job->location) }}" required 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div class="md:col-span-1">
                            <label for="country" class="block text-sm font-bold text-gray-700 mb-2">Country <span class="text-red-500">*</span></label>
                            <input type="text" id="country" name="country" value="{{ old('country', $job->country) }}" required 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Job Content -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Job Content</h3>
                    <div class="space-y-6">
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Full Job Description <span class="text-red-500">*</span></label>
                            <textarea id="description" name="description" rows="8" required 
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('description', $job->description) }}</textarea>
                        </div>

                        <div>
                            <label for="requirements" class="block text-sm font-bold text-gray-700 mb-2">Requirements & Qualifications</label>
                            <textarea id="requirements" name="requirements" rows="6" 
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('requirements', $job->requirements) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Salary & Status -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Salary & Visibility</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="salary_min" class="block text-sm font-bold text-gray-700 mb-2">Min Salary</label>
                            <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div>
                            <label for="salary_max" class="block text-sm font-bold text-gray-700 mb-2">Max Salary</label>
                            <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div>
                            <label for="salary_currency" class="block text-sm font-bold text-gray-700 mb-2">Currency</label>
                            <select id="salary_currency" name="salary_currency" 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                                <option value="TZS" {{ old('salary_currency', $job->salary_currency) == 'TZS' ? 'selected' : '' }}>TZS</option>
                                <option value="USD" {{ old('salary_currency', $job->salary_currency) == 'USD' ? 'selected' : '' }}>USD</option>
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
