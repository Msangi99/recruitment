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

        <!-- Email server (SMTP) configuration -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                    Email server (SMTP)
                </h3>
                <p class="text-sm text-gray-500 mt-1">Override <code class="text-xs bg-gray-100 px-1 rounded">.env</code> mail settings at runtime. Uses values below only when &ldquo;Use these mail settings&rdquo; is enabled and saved.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" id="mail_config_enabled" name="mail_config_enabled" value="1"
                               {{ \App\Models\Setting::get('mail_config_enabled', '0') == '1' ? 'checked' : '' }}
                               class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                    </div>
                    <div class="ml-3">
                        <label for="mail_config_enabled" class="text-sm font-medium text-gray-700">Use these mail settings (disable to rely on <code class="text-xs">.env</code> / server config only)</label>
                        <p class="text-xs text-gray-500">Applies the mailer, SMTP, and from-address fields below to Laravel&rsquo;s mail configuration after save.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_mailer" class="block text-sm font-medium text-gray-700 mb-2">Default mailer</label>
                        <select id="mail_mailer" name="mail_mailer"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_mailer') border-red-300 @enderror">
                            <option value="smtp" {{ old('mail_mailer', \App\Models\Setting::get('mail_mailer', 'smtp')) == 'smtp' ? 'selected' : '' }}>smtp</option>
                            <option value="log" {{ old('mail_mailer', \App\Models\Setting::get('mail_mailer', 'smtp')) == 'log' ? 'selected' : '' }}>log (for debugging)</option>
                            <option value="array" {{ old('mail_mailer', \App\Models\Setting::get('mail_mailer', 'smtp')) == 'array' ? 'selected' : '' }}>array (tests)</option>
                        </select>
                        @error('mail_mailer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                        <select id="mail_encryption" name="mail_encryption"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_encryption') border-red-300 @enderror">
                            <option value="tls" {{ old('mail_encryption', \App\Models\Setting::get('mail_encryption', 'tls')) == 'tls' ? 'selected' : '' }}>TLS (STARTTLS)</option>
                            <option value="ssl" {{ old('mail_encryption', \App\Models\Setting::get('mail_encryption', 'tls')) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="none" {{ old('mail_encryption', \App\Models\Setting::get('mail_encryption', 'tls')) == 'none' ? 'selected' : '' }}>None</option>
                        </select>
                        @error('mail_encryption')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-2">SMTP host <span class="text-red-500">*</span> <span class="text-gray-400 font-normal">(if enabled above)</span></label>
                        <input type="text" id="mail_host" name="mail_host" autocomplete="off"
                               value="{{ old('mail_host', \App\Models\Setting::get('mail_host')) }}"
                               placeholder="smtp.example.com"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_host') border-red-300 @enderror">
                        @error('mail_host')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-2">SMTP port</label>
                        <input type="number" id="mail_port" name="mail_port" min="1" max="65535"
                               value="{{ old('mail_port', \App\Models\Setting::get('mail_port', '587')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_port') border-red-300 @enderror">
                        @error('mail_port')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-2">SMTP username</label>
                        <input type="text" id="mail_username" name="mail_username" autocomplete="off"
                               value="{{ old('mail_username', \App\Models\Setting::get('mail_username')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_username') border-red-300 @enderror">
                        @error('mail_username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-2">SMTP password</label>
                        <input type="password" id="mail_password" name="mail_password" autocomplete="new-password"
                               placeholder="Leave blank to keep current"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_password') border-red-300 @enderror">
                        @if(\App\Models\Setting::get('mail_password'))
                            <p class="mt-1 text-xs text-amber-700">A password is already stored (encrypted). Enter a new value to replace it.</p>
                        @endif
                        <div class="mt-2 flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="mail_clear_password" name="mail_clear_password" value="1" class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                            </div>
                            <label for="mail_clear_password" class="ml-2 text-sm text-gray-600">Remove stored password</label>
                        </div>
                        @error('mail_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-2">From address <span class="text-red-500">*</span> <span class="text-gray-400 font-normal">(if enabled above)</span></label>
                        <input type="email" id="mail_from_address" name="mail_from_address"
                               value="{{ old('mail_from_address', \App\Models\Setting::get('mail_from_address')) }}"
                               placeholder="no-reply@example.com"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_from_address') border-red-300 @enderror">
                        @error('mail_from_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-2">From name</label>
                        <input type="text" id="mail_from_name" name="mail_from_name"
                               value="{{ old('mail_from_name', \App\Models\Setting::get('mail_from_name')) }}"
                               placeholder="{{ config('app.name', 'Recruitment') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('mail_from_name') border-red-300 @enderror">
                        @error('mail_from_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
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
                
                <!-- Consultation Price -->
                <div>
                    <label for="consultation_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Consultation Price (TZS)
                    </label>
                    <input type="number" id="consultation_price" name="consultation_price" 
                           value="{{ old('consultation_price', \App\Models\Setting::get('consultation_price', '30000')) }}"
                           placeholder="30000"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('consultation_price') border-red-300 @enderror">
                    @error('consultation_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- AzamPesa Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    AzamPesa Settings
                </h3>
                <p class="text-sm text-gray-500 mt-1">Configure AzamPesa API credentials for checkout</p>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label for="azampesa_appname" class="block text-sm font-medium text-gray-700 mb-2">App Name</label>
                    <input type="text" id="azampesa_appname" name="azampesa_appname"
                           value="{{ old('azampesa_appname', $azamPesaSetting?->app_name) }}"
                           placeholder="My Application"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('azampesa_appname') border-red-300 @enderror">
                    @error('azampesa_appname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="azampesa_client_id" class="block text-sm font-medium text-gray-700 mb-2">Client ID</label>
                    <input type="text" id="azampesa_client_id" name="azampesa_client_id"
                           value="{{ old('azampesa_client_id', $azamPesaSetting?->client_id) }}"
                           placeholder="Client ID"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('azampesa_client_id') border-red-300 @enderror">
                    @error('azampesa_client_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="azampesa_secret_id" class="block text-sm font-medium text-gray-700 mb-2">Secret ID</label>
                    <input type="text" id="azampesa_secret_id" name="azampesa_secret_id"
                           value="{{ old('azampesa_secret_id', $azamPesaSetting?->secret_id) }}"
                           placeholder="Secret ID"
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('azampesa_secret_id') border-red-300 @enderror">
                    @error('azampesa_secret_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="azampesa_mode" class="block text-sm font-medium text-gray-700 mb-2">Mode</label>
                    <select id="azampesa_mode" name="azampesa_mode"
                            class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('azampesa_mode') border-red-300 @enderror">
                        <option value="sandbox" {{ old('azampesa_mode', $azamPesaSetting?->mode ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                        <option value="live" {{ old('azampesa_mode', $azamPesaSetting?->mode ?? 'sandbox') === 'live' ? 'selected' : '' }}>Live</option>
                    </select>
                    @error('azampesa_mode')
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

        <!-- Job Titles Management -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Job Titles List
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.job-titles.store') }}" method="POST" class="mb-6 flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Add new job title..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Add</button>
                </form>

                <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                    @forelse($jobTitles as $jobTitle)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg group">
                            <span class="text-sm font-medium text-gray-700">{{ $jobTitle->name }}</span>
                            <form action="{{ route('admin.job-titles.destroy', $jobTitle) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                        <p class="text-center text-gray-500 text-sm italic">No job titles added yet</p>
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
        
        <!-- Currencies Management -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden md:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Currency Management
                </h3>
                <form action="{{ route('admin.settings.currencies.update-rates') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-1 rounded-md shadow-sm transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Update Rates from API
                    </button>
                </form>
            </div>
            <div class="p-6">
                <!-- Add Currency Form -->
                <form action="{{ route('admin.settings.currencies.store') }}" method="POST" class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Code (e.g. USD)</label>
                            <input type="text" name="code" required maxlength="3" placeholder="USD" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 uppercase">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Name</label>
                            <input type="text" name="name" required placeholder="US Dollar" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Symbol</label>
                            <input type="text" name="symbol" placeholder="$" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Rate (vs Base)</label>
                            <input type="number" step="0.00000001" name="exchange_rate" required placeholder="1.0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 transition-colors">
                                Add
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Currencies Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symbol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exchange Rate</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Default</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($currencies as $currency)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $currency->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $currency->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $currency->symbol }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <form action="{{ route('admin.settings.currencies.rate', $currency) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" step="0.00000001" name="exchange_rate" value="{{ $currency->exchange_rate }}" 
                                                   class="w-24 px-2 py-1 text-xs border border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500">
                                            <button type="submit" class="text-blue-600 hover:text-blue-900 text-xs">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($currency->is_default)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Default
                                            </span>
                                        @else
                                            <form action="{{ route('admin.settings.currencies.default', $currency) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-900 underline">Set Default</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if(!$currency->is_default)
                                            <form action="{{ route('admin.settings.currencies.destroy', $currency) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this currency?')" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed">Delete</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No currencies found</td>
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
