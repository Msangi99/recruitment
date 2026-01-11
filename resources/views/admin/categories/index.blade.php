@extends('layouts.admin')

@section('title', 'Job Categories')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Job Categories</h2>
            <p class="text-sm text-gray-500">Manage industry categories for job listings</p>
        </div>
        
        <a href="{{ route('admin.categories.create') }}" class="px-6 py-2 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm flex items-center justify-center">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Add New Category
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jobs Count</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                <div class="text-xs text-gray-500">{{ $category->slug }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 line-clamp-1">{{ $category->description ?? 'No description' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $category->job_listings_count }} jobs</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="fb-blue hover:underline flex items-center">
                                        <i data-lucide="edit-2" class="w-4 h-4 mr-1"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline flex items-center">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="tag" class="w-12 h-12 text-gray-300 mb-2"></i>
                                    <p>No categories found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
