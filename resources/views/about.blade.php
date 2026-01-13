<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - {{ config('app.name', 'COYZON') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="COYZON Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">COYZON</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-gray-900">Contact</a>
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">About COYZON</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Connecting African talent with global opportunities
            </p>
        </div>

        <!-- About Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
                <p class="text-gray-600 mb-4">
                    COYZON is a professional recruitment platform dedicated to bridging the gap between talented African job seekers and international employers. We provide verified overseas job opportunities and comprehensive career development services.
                </p>
                <p class="text-gray-600">
                    Our platform ensures transparency, security, and professionalism throughout the entire recruitment process, from profile verification to job placement.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">What We Offer</h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-500 mr-2 flex-shrink-0"></i>
                        <span class="text-gray-600"><strong>Verified Job Listings</strong> - All jobs are verified for authenticity</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-500 mr-2 flex-shrink-0"></i>
                        <span class="text-gray-600"><strong>Profile Verification</strong> - Professional vetting process</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-500 mr-2 flex-shrink-0"></i>
                        <span class="text-gray-600"><strong>Career Consultations</strong> - Expert guidance on overseas careers</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-500 mr-2 flex-shrink-0"></i>
                        <span class="text-gray-600"><strong>Interview Coordination</strong> - Seamless interview scheduling</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-500 mr-2 flex-shrink-0"></i>
                        <span class="text-gray-600"><strong>Document Management</strong> - Secure storage and verification</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mx-auto mb-4">
                    <i data-lucide="users" class="h-8 w-8 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">For Candidates</h3>
                <p class="text-gray-600 text-sm">
                    Browse verified overseas jobs, get career consultations, and connect with international employers.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mx-auto mb-4">
                    <i data-lucide="briefcase" class="h-8 w-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">For Employers</h3>
                <p class="text-gray-600 text-sm">
                    Access verified talent pool, post jobs, and request interviews with qualified candidates.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4">
                    <i data-lucide="shield-check" class="h-8 w-8 text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Trust & Safety</h3>
                <p class="text-gray-600 text-sm">
                    Admin-verified profiles, secure payments, and privacy-protected contact information.
                </p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-lg shadow-xl p-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-6 text-indigo-100">Join thousands of job seekers finding opportunities abroad</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    Register Now
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg hover:bg-indigo-800 transition-colors border-2 border-white">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
