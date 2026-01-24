<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'COYZON'))</title>

    <!-- Tailwind -->
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

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    @include('partials.public-nav')

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Notifications -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col space-y-3 pointer-events-none">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                class="pointer-events-auto min-w-[320px] max-w-md rounded-2xl bg-green-600 px-6 py-4 text-white shadow-2xl shadow-green-500/30 ring-1 ring-green-400/40">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 mt-0.5">
                        <i data-lucide="check-circle" class="h-6 w-6"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold leading-tight">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                class="pointer-events-auto min-w-[320px] max-w-md rounded-2xl bg-red-600 px-6 py-4 text-white shadow-2xl shadow-red-500/30 ring-1 ring-red-400/40">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 mt-0.5">
                        <i data-lucide="alert-circle" class="h-6 w-6"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold leading-tight">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                class="pointer-events-auto min-w-[320px] max-w-md rounded-2xl bg-orange-600 px-6 py-4 text-white shadow-2xl shadow-orange-500/30 ring-1 ring-orange-400/40">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 mt-0.5">
                        <i data-lucide="info" class="h-6 w-6"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold leading-tight mb-1">Please correct the following errors:</p>
                        <ul class="text-xs list-disc list-inside opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

    @include('partials.footer')

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>

</html>