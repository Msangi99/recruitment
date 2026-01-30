@extends('layouts.app')

@section('title', 'Profile Settings')

@include('candidate.partials.nav')

@section('content')
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <a href="{{ route('candidate.dashboard') }}"
                class="text-sm font-medium text-slate-500 hover:text-emerald-600 flex items-center transition-colors mb-4">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                Back to Dashboard
            </a>
            <h2 class="text-3xl font-bold text-slate-900">Account Settings</h2>
            <p class="mt-2 text-sm text-slate-600">Manage your password, email, and phone number</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-emerald-600"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Change Password Section -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <i data-lucide="lock" class="w-5 h-5 mr-3 text-slate-400"></i>
                        Change Password
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" id="current_password" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                            <input type="password" name="password" id="password" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Must be at least 8 characters</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Email Section -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <i data-lucide="mail" class="w-5 h-5 mr-3 text-slate-400"></i>
                        Change Email Address
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('settings.email.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Current Email</label>
                            <input type="text" disabled
                                class="block w-full rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm sm:text-sm"
                                value="{{ $user->email }}">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">New Email Address</label>
                            <input type="email" name="email" id="email" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('email') border-red-500 @enderror"
                                value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email_current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" id="email_current_password" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Confirm your password to change email</p>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Phone Section -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                        <i data-lucide="phone" class="w-5 h-5 mr-3 text-slate-400"></i>
                        Change Phone Number
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('settings.phone.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Current Phone</label>
                            <input type="text" disabled
                                class="block w-full rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm sm:text-sm"
                                value="{{ $user->phone ?? 'Not set' }}">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">New Phone Number</label>
                            <input type="tel" name="phone" id="phone" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('phone') border-red-500 @enderror"
                                value="{{ old('phone') }}"
                                placeholder="+255 123 456 789">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone_current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" id="phone_current_password" required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Confirm your password to change phone number</p>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Phone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
