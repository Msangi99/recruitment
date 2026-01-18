<nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('logo.jpg') }}" alt="Coyzon Logo" class="h-12 w-auto">
                    <span class="ml-3 text-2xl font-bold text-gray-900">Coyzon</span>
                </a>
            </div>
            <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                <a href="{{ route('about') }}" class="text-blue-600 hover:text-blue-800 font-bold text-base">About
                    Us</a>
                <a href="{{ route('public.jobs.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-bold text-base">Find Job</a>
                <a href="{{ route('public.candidates.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-bold text-base">Find Candidate</a>
                <a href="{{ route('public.appointments.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-bold text-base">Book Appointment</a>
                <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 font-bold text-base">Contact
                    Us</a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 font-semibold">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Register</a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Dashboard</a>
                @endguest
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('about') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">About
                Us</a>
            <a href="{{ route('public.jobs.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Find
                Job</a>
            <a href="{{ route('public.candidates.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Find
                Candidate</a>
            <a href="{{ route('public.appointments.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Book
                Appointment</a>
            <a href="{{ route('contact') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Contact
                Us</a>
            @guest
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Login</a>
                <a href="{{ route('register') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Register</a>
            @else
                <a href="{{ route('dashboard') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Dashboard</a>
            @endguest
        </div>
    </div>
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</nav>