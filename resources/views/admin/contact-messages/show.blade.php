@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.contact-messages.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                ← Back to Messages
            </a>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">Contact Message</h2>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Message Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message Card -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">{{ $contactMessage->subject }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Received on {{ $contactMessage->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none">
                        {!! nl2br(e($contactMessage->message)) !!}
                    </div>
                </div>
            </div>

            <!-- Reply Form -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-green-50 px-6 py-4 border-b border-green-200">
                    <h3 class="text-lg font-bold text-gray-900">
                        @if($contactMessage->replied_at)
                            Send Another Reply
                        @else
                            Reply to {{ $contactMessage->name }}
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Email will be sent to: <strong>{{ $contactMessage->email }}</strong>
                    </p>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.contact-messages.reply', $contactMessage) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="reply_subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <input type="text" id="reply_subject" name="reply_subject" 
                                       value="{{ old('reply_subject', 'Re: ' . $contactMessage->subject) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('reply_subject') border-red-300 @enderror"
                                       required>
                                @error('reply_subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea id="reply_message" name="reply_message" rows="6" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('reply_message') border-red-300 @enderror"
                                          placeholder="Type your reply message here..."
                                          required>{{ old('reply_message') }}</textarea>
                                @error('reply_message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700">
                                    Send Reply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Admin Notes</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.contact-messages.notes', $contactMessage) }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="admin_notes" rows="6" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Add internal notes about this message...">{{ $contactMessage->admin_notes }}</textarea>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                                Save Notes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Sender Info -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Sender Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="text-gray-900 font-medium">{{ $contactMessage->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="text-blue-600">{{ $contactMessage->email }}</p>
                    </div>
                    @if($contactMessage->phone)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone</p>
                            <p class="text-gray-900">{{ $contactMessage->phone }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Info -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Status</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Read Status</span>
                        @if($contactMessage->is_read)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700">
                                Read
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700">
                                Unread
                            </span>
                        @endif
                    </div>
                    @if($contactMessage->read_at)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Read At</p>
                            <p class="text-gray-900 text-sm">{{ $contactMessage->read_at->format('M d, Y h:i A') }}</p>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Replied</span>
                        @if($contactMessage->replied_at)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700">
                                Yes
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        @endif
                    </div>
                    @if($contactMessage->replied_at)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Replied At</p>
                            <p class="text-gray-900 text-sm">{{ $contactMessage->replied_at->format('M d, Y h:i A') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
