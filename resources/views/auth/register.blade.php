@extends('layouts.app')

@section('title', 'Register - Coyzon Recruitment')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full">
            <!-- Card Container -->
            <div class="bg-gray-900 rounded-2xl shadow-2xl p-6 sm:p-10 border border-gray-800">
                <div class="mb-6 text-center">
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-14 w-auto">
                    </a>
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        Create Your Account
                    </h2>
                    <p class="mt-2 text-slate-400 text-xs font-medium">
                        Join Coyzon to find rewarding global opportunities
                    </p>
                </div>

                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <!-- Name Group -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-xs font-semibold text-slate-300 mb-1">First
                                    Name</label>
                                <input id="first_name" name="first_name" type="text" autocomplete="given-name" required
                                    class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                                    placeholder="John" value="{{ old('first_name') }}">
                            </div>
                            <div>
                                <label for="last_name" class="block text-xs font-semibold text-slate-300 mb-1">Last
                                    Name</label>
                                <input id="last_name" name="last_name" type="text" autocomplete="family-name" required
                                    class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                                    placeholder="Doe" value="{{ old('last_name') }}">
                            </div>
                            <input type="hidden" name="name" id="full_name_hidden">
                        </div>
                        @error('name')
                            <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Contact Group -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">Email
                                    Address</label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                                    placeholder="john@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-semibold text-slate-300 mb-1">Phone
                                    Number</label>
                                <input id="phone" name="phone" type="tel" autocomplete="tel" required
                                    class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('phone') border-red-500 @enderror"
                                    placeholder="+255 000 000 000" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Location and Password Info -->
                        <div>
                            <label for="country" class="block text-xs font-semibold text-slate-300 mb-1">Country of
                                Residence</label>
                            <select id="country" name="country" required
                                class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('country') border-red-500 @enderror">
                                <option value="" disabled selected>Select your country</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('country')
                                <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password"
                                    class="block text-xs font-semibold text-slate-300 mb-1">Password</label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                        required
                                        class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                                        placeholder="••••••••">
                                    <button type="button" onclick="togglePassword('password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation"
                                    class="block text-xs font-semibold text-slate-300 mb-1">Confirm Password</label>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        autocomplete="new-password" required
                                        class="appearance-none block w-full px-3 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                                        placeholder="••••••••">
                                    <button type="button" onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" onclick="combineName()"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 shadow-lg shadow-blue-500/20 transition-all duration-200">
                            Create My Account
                        </button>
                        <p class="mt-3 text-center text-[10px] text-slate-500">
                            By signing up, you agree to our Terms and Conditions.
                        </p>
                    </div>

                    <div class="text-center pt-1">
                        <p class="text-xs font-medium text-slate-500">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-bold text-blue-400 hover:text-blue-300 ml-1">
                                Sign in here
                            </a>
                        </p>
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

        function combineName() {
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            document.getElementById('full_name_hidden').value = (firstName + ' ' + lastName).trim();
        }
    </script>
@endsection