@extends('layouts.app')

@section('title', 'Reset Password - COYZON')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full">
            <!-- Card Container -->
            <div class="bg-gray-900 rounded-3xl shadow-2xl p-8 sm:p-10 border border-gray-800">
                <div class="mb-10 text-center">
                    <a href="{{ route('home') }}" class="inline-block mb-6">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-20 w-auto">
                    </a>
                    <h2 class="text-3xl font-bold text-white tracking-tight">
                        Set New Password
                    </h2>
                    <p class="mt-3 text-slate-400 text-sm font-medium">
                        Please provide your new login credentials
                    </p>
                </div>

                <form class="space-y-6" action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-2">Email Address</label>
                            <input type="email" disabled
                                class="appearance-none block w-full px-4 py-3.5 bg-gray-800/50 border border-gray-700 rounded-xl text-slate-400 cursor-not-allowed"
                                value="{{ $email }}">
                            <p class="mt-1.5 text-xs text-slate-500">Email cannot be changed during reset</p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">New
                                Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                    class="appearance-none block w-full px-4 py-3.5 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-semibold text-slate-300 mb-2">Confirm New Password</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password" required
                                    class="appearance-none block w-full px-4 py-3.5 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    @error('email')
                        <div class="rounded-xl bg-red-900/30 border border-red-800 p-4">
                            <p class="text-sm font-semibold text-red-400">{{ $message }}</p>
                        </div>
                    @enderror

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 shadow-lg shadow-blue-500/20 transition-all duration-200">
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