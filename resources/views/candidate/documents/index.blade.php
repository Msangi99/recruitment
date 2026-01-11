@extends('layouts.app')

@section('title', 'Documents - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="lg:ml-64 pt-16 lg:pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">My Documents</h2>
                <p class="mt-1 text-sm text-gray-500">Upload your CV, ID, passport, and certificates</p>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Upload Form -->
            <div class="bg-white shadow-lg rounded-lg p-8 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">Upload New Document</h3>
                <form method="POST" action="{{ route('candidate.documents.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Document Type *</label>
                            <select id="document_type" name="document_type" required 
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('document_type') border-red-300 @enderror">
                                <option value="">Select Type</option>
                                <option value="cv">CV/Resume</option>
                                <option value="id">National ID</option>
                                <option value="passport">Passport</option>
                                <option value="certificate">Certificate</option>
                                <option value="other">Other</option>
                            </select>
                            @error('document_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="document" class="block text-sm font-medium text-gray-700 mb-2">File *</label>
                            <input type="file" id="document" name="document" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                                   class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-500 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('document') border-red-300 @enderror">
                            @error('document')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG (Max 10MB)</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Upload Document
                        </button>
                    </div>
                </form>
            </div>

            <!-- Documents List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verification Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($documents as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ ucfirst($document->document_type) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $document->file_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $document->file_size_human }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $document->verification_status == 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($document->verification_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($document->verification_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $document->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form method="POST" action="{{ route('candidate.documents.destroy', $document) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No documents uploaded yet. Upload your CV and other documents above.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection