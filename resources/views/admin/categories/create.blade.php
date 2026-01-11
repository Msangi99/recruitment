@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('admin.categories.index') }}" class="hover:fb-blue flex items-center">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
            Back to Categories
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Create New Category</h2>
            <p class="text-sm text-gray-500">Define a new industry category for job seekers</p>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="p-6">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('name') border-red-300 @enderror" 
                           placeholder="e.g., Agriculture, Construction, Logistics">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-400">The slug will be generated automatically based on the name.</p>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('description') border-red-300 @enderror" 
                              placeholder="Describe what kind of jobs fall into this category...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon" class="block text-sm font-bold text-gray-700 mb-2">Icon Class (Optional)</label>
                    <div class="relative">
                        <input type="text" id="icon" name="icon" value="{{ old('icon') }}" 
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                               placeholder="e.g., fa-industry, fa-tractor">
                        <div class="absolute right-3 top-2.5 text-gray-400">
                            <i data-lucide="image" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-400">Font Awesome or Lucide icon class name.</p>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center h-5">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_active" class="font-bold text-gray-700">Set as Active</label>
                        <p class="text-gray-500">This category will be immediately available for job postings.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="w-full sm:w-auto px-8 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-colors text-center shadow-sm">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-2.5 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm flex items-center justify-center">
                        <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                        Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
