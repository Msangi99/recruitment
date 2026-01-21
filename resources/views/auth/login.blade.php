@extends('layouts.app')

@section('title', 'Login - Coyzon Recruitment')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full">
            <!-- Card Container -->
            <div class="bg-gray-900 rounded-2xl shadow-2xl p-6 sm:p-8 border border-gray-800">
                <div class="mb-6 text-center">
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-14 w-auto">
                    </a>
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        Welcome Back
                    </h2>
                    <p class="mt-2 text-slate-400 text-xs font-medium">
                        Log in to access your recruitment portal
                    </p>
                </div>

                <form class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">Email Address</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                                placeholder="name@company.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-xs font-semibold text-slate-300">Password</label>
                                <a href="{{ route('password.request') }}"
                                    class="text-[10px] font-bold text-blue-400 hover:text-blue-300">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="relative group">
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                                    <i data-lucide="eye" id="eye-icon" class="h-4 w-4"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-3.5 w-3.5 text-blue-600 focus:ring-blue-500/20 bg-gray-800 border-gray-700 rounded transition-all">
                        <label for="remember-me" class="ml-2 block text-xs font-medium text-slate-400">
                            Stay signed in
                        </label>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 shadow-lg shadow-blue-500/20 transition-all duration-200">
                            Sign In to Account
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <p class="text-xs font-medium text-slate-500">
                            New to Coyzon?
                            <a href="{{ route('register') }}" class="font-bold text-blue-400 hover:text-blue-300 ml-1">
                                Create an account
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
@endsection