<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50">
    @include('partials.public-nav')

    <!-- Contact Us Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <!-- Page Header -->
        <div class="text-center mb-16 relative">
            <div
                class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-12 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-60 -z-10">
            </div>
            <h1
                class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-800 to-emerald-600 mb-6 tracking-tight">
                Contact Us
            </h1>
            <div class="w-24 h-1.5 bg-gradient-to-r from-green-700 to-emerald-500 mx-auto rounded-full mb-8"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                We’re here to support your recruitment and workforce needs. Whether you are an employer seeking
                qualified talent or a job seeker looking for opportunities, our team is ready to assist you with
                professional, reliable, and timely support.
            </p>
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
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 transition-all hover:shadow-2xl duration-300">
                    <div class="bg-gradient-to-r from-green-900 to-green-800 px-5 py-3">
                        <h2 class="text-base font-bold text-white flex items-center gap-2 tracking-wide">
                            Get in Touch
                        </h2>
                    </div>

                    <div class="p-5 space-y-4">
                        <!-- Email -->
                        <div class="flex items-start space-x-3 group">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition-colors duration-200">
                                <i data-lucide="mail" class="h-4 w-4 text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-0.5">Email
                                </p>
                                <a href="mailto:info@coyzon.co.tz"
                                    class="text-gray-900 text-sm font-semibold hover:text-green-600 transition-colors block">
                                    info@coyzon.co.tz
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-3 group">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition-colors duration-200">
                                <i data-lucide="phone" class="h-4 w-4 text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-0.5">Phone
                                </p>
                                <div class="space-y-2">
                                    <a href="tel:+255712321513" class="block group/link">
                                        <span
                                            class="text-gray-900 text-sm font-semibold group-hover/link:text-green-600 transition-colors block">+255
                                            712 321 513</span>
                                        <span class="text-[10px] text-green-700 font-bold block">Job Seekers & Travel
                                            Support</span>
                                    </a>
                                    <div class="h-px bg-gray-100 w-full"></div>
                                    <a href="tel:+255746014808" class="block group/link">
                                        <span
                                            class="text-gray-900 text-sm font-semibold group-hover/link:text-green-600 transition-colors block">+255
                                            746 014 808</span>
                                        <span class="text-[10px] text-green-700 font-bold block">Employer / Partnership
                                            / Recruitment Agencies</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="flex items-start space-x-3 group">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition-colors duration-200">
                                <i data-lucide="globe" class="h-4 w-4 text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-0.5">Website
                                </p>
                                <a href="https://www.coyzon.co.tz"
                                    class="text-gray-600 text-xs font-normal hover:text-green-600 transition-colors block">
                                    www.coyzon.co.tz
                                </a>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start space-x-3 group">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition-colors duration-200">
                                <i data-lucide="map-pin" class="h-4 w-4 text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-0.5">Office
                                    Address</p>
                                <p class="text-gray-600 text-xs font-normal leading-relaxed">
                                    16103 Ubungo Riverside,<br>Dar es Salaam, Tanzania
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office Hours Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">Office Hours</h2>
                    </div>
                    <div class="p-5 space-y-2 text-sm">
                        <div class="flex justify-between items-center py-1.5 border-b border-dashed border-gray-200">
                            <span class="text-gray-600 font-medium text-xs">Monday - Saturday</span>
                            <span
                                class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wide">24
                                Hours</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5">
                            <span class="text-gray-600 font-medium text-xs">Sunday</span>
                            <span
                                class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wide">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Social Media Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">Follow Us</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex gap-3 justify-start">
                            <a href="https://www.facebook.com/61581420484559" target="_blank"
                                class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-200 hover:shadow-xl hover:scale-110 transition-all duration-300 transform">
                                <i data-lucide="facebook" class="h-5 w-5"></i>
                            </a>
                            <a href="http://tiktok.com/@coyzon" target="_blank"
                                class="flex items-center justify-center w-10 h-10 bg-black text-white rounded-lg shadow-lg shadow-gray-400 hover:shadow-xl hover:scale-110 transition-all duration-300 transform">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z">
                                    </path>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/in/james-majid-469166389" target="_blank"
                                class="flex items-center justify-center w-10 h-10 bg-[#0077b5] text-white rounded-lg shadow-lg shadow-blue-200 hover:shadow-xl hover:scale-110 transition-all duration-300 transform">
                                <i data-lucide="linkedin" class="h-5 w-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2 flex justify-start items-start">
                <div class="bg-white rounded-lg shadow-md p-4 w-full lg:w-[70%]">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Send us a Message</h2>

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-2">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-700 mb-1">Full Name *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-700 mb-1">Email Address
                                    *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-xs font-bold text-gray-700 mb-1">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-xs font-bold text-gray-700 mb-1">Subject
                                    *</label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                    class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">
                                @error('subject')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-xs font-bold text-gray-700 mb-1">Message *</label>
                            <textarea id="message" name="message" rows="2" required
                                class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors shadow-md">
                                Submit
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