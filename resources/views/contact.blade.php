<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50">
    <!-- Header/Nav -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Coyzon Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">Coyzon</span>
                    </a>
                </div>
                <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                    <a href="{{ route('about') }}" class="text-blue-600 hover:text-blue-800 font-bold">About Us</a>
                    <a href="{{ route('public.jobs.index') }}" class="text-blue-600 hover:text-blue-800 font-bold">Find
                        Job</a>
                    <a href="{{ route('public.candidates.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Find Candidate</a>
                    <a href="{{ route('candidate.consultations.create') }}"
                        class="text-blue-600 hover:text-blue-800 font-bold">Book Appointment</a>
                    <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 font-bold">Contact Us</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Contact Us Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-lg text-gray-600">Get in Touch - We'd love to hear from you!</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg flex items-center">
                <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg flex items-center">
                <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Information -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Get in Touch Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Get in Touch</h2>

                    <!-- Email -->
                    <div class="flex items-start space-x-3 mb-4">
                        <i data-lucide="mail" class="h-5 w-5 text-indigo-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Email</p>
                            <a href="mailto:info@coyzon.com"
                                class="text-indigo-600 hover:text-indigo-700">info@coyzon.com</a>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start space-x-3 mb-4">
                        <i data-lucide="phone" class="h-5 w-5 text-indigo-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Phone / For support & Sales</p>
                            <a href="tel:+255625933171" class="text-indigo-600 hover:text-indigo-700">+255 625 933
                                171</a>
                            <p class="text-sm text-gray-500 mt-1">For job seekers: +255612345678</p>
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="flex items-start space-x-3 mb-4">
                        <i data-lucide="globe" class="h-5 w-5 text-indigo-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Website</p>
                            <a href="https://www.coyzon.com"
                                class="text-indigo-600 hover:text-indigo-700">www.coyzon.com</a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex items-start space-x-3">
                        <i data-lucide="map-pin" class="h-5 w-5 text-indigo-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Address</p>
                            <p class="text-gray-600">1234 Kariakoo St, Building 10, 3rd Floor,<br>Dar es Salaam,
                                Tanzania</p>
                        </div>
                    </div>
                </div>

                <!-- Office Hours Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Office Hours</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday - Saturday:</span>
                            <span class="font-medium text-gray-900">08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday:</span>
                            <span class="font-medium text-red-600">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Social Media Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Social Media / Follow us</h2>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com/coyzon" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                            <i data-lucide="facebook" class="h-5 w-5"></i>
                        </a>
                        <a href="https://instagram.com/coyzon" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-pink-600 text-white rounded-full hover:bg-pink-700">
                            <i data-lucide="instagram" class="h-5 w-5"></i>
                        </a>
                        <a href="https://linkedin.com/company/coyzon" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-blue-700 text-white rounded-full hover:bg-blue-800">
                            <i data-lucide="linkedin" class="h-5 w-5"></i>
                        </a>
                        <a href="https://tiktok.com/@coyzon" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-black text-white rounded-full hover:bg-gray-800">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Send us a Message</h2>

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name
                                    *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required @class([
                                    'w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500',
                                    'border-red-300' => $errors->has('name'),
                                    'border-gray-300' => !$errors->has('name'),
                                ])>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address
                                    *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required @class([
                                    'w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500',
                                    'border-red-300' => $errors->has('email'),
                                    'border-gray-300' => !$errors->has('email'),
                                ])>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number
                                (Optional)</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                @class([
                                    'w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500',
                                    'border-red-300' => $errors->has('subject'),
                                    'border-gray-300' => !$errors->has('subject'),
                                ])>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea id="message" name="message" rows="6" required @class([
                                'w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500',
                                'border-red-300' => $errors->has('message'),
                                'border-gray-300' => !$errors->has('message'),
                            ])>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>
</body>

</html>