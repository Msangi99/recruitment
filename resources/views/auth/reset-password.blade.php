@extends('layouts.app')

@section('title', 'Reset Password - Coyzon Recruitment')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-white py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <div class="mb-6 text-center">
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-14 w-auto">
                    </a>
                    <h2 class="text-2xl font-bold text-deep-green tracking-tight">
                        Set New Password
                    </h2>
                    <p class="mt-2 text-gray-500 text-xs font-medium">
                        Please provide your new login credentials
                    </p>
                </div>

                <form class="space-y-4" action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" disabled
                                class="appearance-none block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-500 cursor-not-allowed"
                                value="{{ $email }}">
                            <p class="mt-1 text-[10px] text-gray-400">Email cannot be changed during reset</p>
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">New
                                Password</label>
                            <div class="relative group">
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                    class="appearance-none block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-green/20 focus:border-deep-green transition-all duration-200 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i data-lucide="eye" id="eye-icon-password" class="h-4 w-4"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-semibold text-gray-700 mb-1">Confirm New Password</label>
                            <div class="relative group">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password" required
                                    class="appearance-none block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-green/20 focus:border-deep-green transition-all duration-200"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i data-lucide="eye" id="eye-icon-confirmation" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    @error('email')
                        <div class="rounded-lg bg-red-50 border border-red-100 p-3 mt-4">
                            <p class="text-xs font-semibold text-red-600">{{ $message }}</p>
                        </div>
                    @enderror

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-deep-green hover:bg-deep-green/90 focus:outline-none focus:ring-4 focus:ring-deep-green/20 shadow-lg shadow-deep-green/20 transition-all duration-200">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection