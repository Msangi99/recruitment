@extends('layouts.app')

@section('title', 'Forgot Password - Coyzon Recruitment')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-white py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <div class="mb-6 text-center">
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-24 w-auto">
                    </a>
                    <h2 class="text-2xl font-bold text-deep-green tracking-tight">
                        Reset Password
                    </h2>
                    <p class="mt-2 text-gray-500 text-xs font-medium">
                        Enter your email to receive a reset link
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-100 p-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="h-4 w-4 text-green-600"></i>
                            <p class="text-[11px] font-semibold text-green-700">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                @endif

                <form class="space-y-4" action="{{ route('password.email') }}" method="POST">
                    @csrf

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
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-deep-green hover:bg-deep-green/90 focus:outline-none focus:ring-4 focus:ring-deep-green/20 shadow-lg shadow-deep-green/20 transition-all duration-200">
                            Send Reset Link
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center text-xs font-bold text-deep-green hover:text-deep-green/80 transition-colors">
                            <i data-lucide="arrow-left" class="mr-2 h-3.5 w-3.5"></i>
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection