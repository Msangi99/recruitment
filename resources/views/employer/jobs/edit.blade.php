@extends('layouts.app')

@section('title', 'Edit Job - Employer')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('employer.partials.nav')

    <div class="lg:ml-64 pt-16 lg:pt-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('employer.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Jobs</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Edit Job</h2>
            </div>

            <form method="POST" action="{{ route('employer.jobs.update', $job) }}" class="bg-white shadow-lg rounded-lg p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('title') border-red-300 @enderror"
                               placeholder="e.g., Senior Software Developer">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select id="category_id" name="category_id" required 
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('category_id') border-red-300 @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-2">Employment Type *</label>
                            <select id="employment_type" name="employment_type" required 
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('employment_type') border-red-300 @enderror">
                                <option value="">Select Type</option>
                                <option value="full-time" {{ old('employment_type', $job->employment_type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part-time" {{ old('employment_type', $job->employment_type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="temporary" {{ old('employment_type', $job->employment_type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
                            </select>
                            @error('employment_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $job->company_name) }}" required 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('company_name') border-red-300 @enderror"
                               placeholder="Company name">
                        @error('company_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $job->location) }}" required 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('location') border-red-300 @enderror"
                                   placeholder="e.g., Dar es Salaam">
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                            <input type="text" id="country" name="country" value="{{ old('country', $job->country) }}" required 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('country') border-red-300 @enderror"
                                   placeholder="e.g., Tanzania">
                            @error('country')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                        <textarea id="description" name="description" rows="6" required 
                                  class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('description') border-red-300 @enderror"
                                  placeholder="Describe the job role, responsibilities, and requirements...">{{ old('description', $job->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">Requirements</label>
                        <textarea id="requirements" name="requirements" rows="4" 
                                  class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                  placeholder="List required qualifications, skills, and experience...">{{ old('requirements', $job->requirements) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-2">Salary Min</label>
                            <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" step="0.01" 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="0.00">
                        </div>
                        <div>
                            <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-2">Salary Max</label>
                            <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" step="0.01" 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="0.00">
                        </div>
                        <div>
                            <label for="salary_currency" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                            <select id="salary_currency" name="salary_currency" 
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                <option value="TZS" {{ old('salary_currency', $job->salary_currency) == 'TZS' ? 'selected' : '' }}>TZS</option>
                                <option value="USD" {{ old('salary_currency', $job->salary_currency) == 'USD' ? 'selected' : '' }}>USD</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $job->is_active) ? 'checked' : '' }} 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-3 block text-sm text-gray-700">
                            Active (Job will be visible to candidates)
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('employer.jobs.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Job
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection