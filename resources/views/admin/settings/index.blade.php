@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Settings</h2>
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

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <!-- Email Notification Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Notification Settings
                </h3>
                <p class="text-sm text-gray-500 mt-1">Configure email addresses for system notifications</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Enable Email Notifications -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" id="email_notifications_enabled" name="email_notifications_enabled" value="1"
                               {{ \App\Models\Setting::get('email_notifications_enabled', '1') == '1' ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    </div>
                    <div class="ml-3">
                        <label for="email_notifications_enabled" class="text-sm font-medium text-gray-700">Enable Email Notifications</label>
                        <p class="text-xs text-gray-500">Enable or disable all email notifications from the system</p>
                    </div>
                </div>

                <!-- HR Email -->
                <div>
                    <label for="hr_email" class="block text-sm font-medium text-gray-700 mb-2">
                        HR Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="hr_email" name="hr_email" 
                           value="{{ old('hr_email', \App\Models\Setting::get('hr_email')) }}"
                           placeholder="hr@yourcompany.com"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('hr_email') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">
                        This email will receive all interview requests submitted by employers. 
                        When an employer requests an interview with a candidate, a notification will be sent to this address.
                    </p>
                    @error('hr_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notification Email -->
                <div>
                    <label for="notification_email" class="block text-sm font-medium text-gray-700 mb-2">
                        General Notification Email
                    </label>
                    <input type="email" id="notification_email" name="notification_email" 
                           value="{{ old('notification_email', \App\Models\Setting::get('notification_email')) }}"
                           placeholder="notifications@yourcompany.com"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notification_email') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">
                        This email will receive general system notifications (optional).
                    </p>
                    @error('notification_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Package Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Package Settings
                </h3>
                <p class="text-sm text-gray-500 mt-1">Manage subscription plan prices (TZS)</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Basic Plan Price -->
                <div>
                    <label for="package_basic_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Basic Plan Price (TZS)
                    </label>
                    <input type="number" id="package_basic_price" name="package_basic_price" 
                           value="{{ old('package_basic_price', \App\Models\Setting::get('package_basic_price', '50000')) }}"
                           placeholder="50000"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('package_basic_price') border-red-300 @enderror">
                    @error('package_basic_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Premium Plan Price -->
                <div>
                    <label for="package_premium_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Premium Plan Price (TZS)
                    </label>
                    <input type="number" id="package_premium_price" name="package_premium_price" 
                           value="{{ old('package_premium_price', \App\Models\Setting::get('package_premium_price', '100000')) }}"
                           placeholder="100000"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('package_premium_price') border-red-300 @enderror">
                    @error('package_premium_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800">Email Notification Info</h4>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>HR Email:</strong> Receives employer interview requests</li>
                            <li><strong>Candidate Notifications:</strong> Candidates receive emails when appointments are confirmed or cancelled</li>
                            <li><strong>Employer Notifications:</strong> Employers receive emails when their interview requests are approved or cancelled (with reason)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                Save Settings
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
        <!-- Skills Management -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Skills List
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.skills.store') }}" method="POST" class="mb-6 flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Add new skill..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Add</button>
                </form>

                <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                    @forelse($skills as $skill)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg group">
                            <span class="text-sm font-medium text-gray-700">{{ $skill->name }}</span>
                            <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm italic">No skills added yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Languages Management -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5a18.022 18.022 0 01-3.827-5.802M10.5 13.5c-.2-.5-.4-1.15-.4-1.5H12M8.11 9c.703 2.052 1.758 3.871 2.968 5.356m1.11 1.644l-.445.891a1 1 0 01-1.789 0l-.445-.891m.948-2.614l-.445-.891a1 1 0 011.789 0l.445.891"></path>
                    </svg>
                    Languages List
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.languages.store') }}" method="POST" class="mb-6 flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Add new language..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Add</button>
                </form>

                <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                    @forelse($languages as $language)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg group">
                            <span class="text-sm font-medium text-gray-700">{{ $language->name }}</span>
                            <form action="{{ route('admin.languages.destroy', $language) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm italic">No languages added yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
