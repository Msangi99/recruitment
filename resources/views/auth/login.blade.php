@extends('layouts.app')

@section('title', 'Login - Coyzon Recruitment')

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
                        Welcome Back
                    </h2>
                    <p class="mt-2 text-gray-500 text-xs font-medium">
                        You’re one step closer to your next opportunity.
                    </p>
                </div>

                <form class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email Address</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="appearance-none block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-green/20 focus:border-deep-green transition-all duration-200 @error('email') border-red-500 @enderror"
                                placeholder="name@company.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-xs font-semibold text-gray-700">Password</label>
                                <a href="{{ route('password.request') }}"
                                    class="text-[10px] font-bold text-deep-green hover:text-deep-green/80">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="relative group">
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="appearance-none block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-deep-green/20 focus:border-deep-green transition-all duration-200 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
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
                            class="h-3.5 w-3.5 text-deep-green focus:ring-deep-green/20 bg-white border-gray-300 rounded transition-all">
                        <label for="remember-me" class="ml-2 block text-xs font-medium text-gray-500">
                            Stay signed in
                        </label>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-deep-green hover:bg-deep-green/90 focus:outline-none focus:ring-4 focus:ring-deep-green/20 shadow-lg shadow-deep-green/20 transition-all duration-200">
                            Log in
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <p class="text-xs font-medium text-slate-500">
                            <span class="text-deep-green">Don’t have an account.</span>
                            <a href="{{ route('register') }}"
                                class="font-bold text-white bg-deep-green hover:bg-deep-green/90 px-3 py-1 rounded ml-1 transition-colors text-[10px] inline-block">
                                Sign up
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