@extends('layouts.app')

@section('title', 'Forgot Password - COYZON')

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
                        Reset Password
                    </h2>
                    <p class="mt-3 text-slate-400 text-sm font-medium">
                        Enter your email to receive a reset link
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-xl bg-green-900/30 border border-green-800 p-4">
                        <div class="flex items-center gap-3">
                            <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
                            <p class="text-sm font-semibold text-green-400">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-4 py-3.5 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                            placeholder="name@company.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 shadow-lg shadow-blue-500/20 transition-all duration-200">
                            Send Reset Link
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center text-sm font-bold text-blue-400 hover:text-blue-300">
                            <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection