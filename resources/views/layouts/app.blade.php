<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Recruitment Platform')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind -->
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- App assets -->

    <style>
        :root {
            --portal-accent: #2563eb;
        }

        [x-cloak] {
            display: none !important;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 9999px;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    @hasSection('sidebar')
        <div x-data="{ mobileSidebarOpen: false }">
            <!-- Top Navbar -->
            <nav class="fixed inset-x-0 top-0 z-40 h-16 border-b border-slate-200 bg-white/80 backdrop-blur">
                <div class="flex h-full items-center px-4 sm:px-6 lg:px-8 lg:pl-80 gap-4">
                    <button @click="mobileSidebarOpen = true"
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 focus:outline-none lg:hidden">
                        <i data-lucide="menu" class="h-5 w-5"></i>
                    </button>

                    <div class="hidden lg:flex items-center gap-3">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <img src="{{ asset('logo-removed-background.png') }}" alt="COYZON Logo" class="h-14 w-auto">
                        </a>
                        <div>
                            <p class="text-xs uppercase tracking-[3px] text-slate-500 font-semibold">
                                @yield('page_label', 'Portal')</p>
                            <p class="text-lg font-semibold text-slate-900">@yield('title', 'Dashboard')</p>
                        </div>
                    </div>

                    <div class="flex-1 lg:max-w-xl">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400"></i>
                            <input type="text" placeholder="Search..."
                                class="w-full rounded-xl border border-slate-200 bg-white/70 py-2 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-2 py-1 shadow-sm hover:border-blue-200">
                                <div class="h-9 w-9 overflow-hidden rounded-full border border-slate-200">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional(auth()->user())->name ?? 'User') }}&background=2563eb&color=fff"
                                        alt="User" class="h-full w-full object-cover">
                                </div>
                                <div class="hidden text-left text-sm font-semibold text-slate-800 md:block">
                                    <p class="leading-none">{{ auth()->user()?->name ?? 'User' }}</p>
                                    <span
                                        class="text-[11px] font-medium text-slate-500">@yield('page_label', 'Portal')</span>
                                </div>
                                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400"></i>
                            </button>

                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-3 w-60 rounded-2xl border border-slate-100 bg-white shadow-xl ring-1 ring-black/5">
                                <div class="border-b border-slate-100 px-4 py-3">
                                    <p class="text-xs uppercase tracking-[2px] text-slate-400 font-semibold">Signed in</p>
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()?->email ??
                                        'user@example.com' }}</p>
                                </div>
                                <div class="py-2">
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i data-lucide="user" class="mr-3 h-4 w-4 text-slate-500"></i>
                                        Profile Settings
                                    </a>
                                </div>
                                <div class="border-t border-slate-100 px-4 py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full items-center rounded-lg px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">
                                            <i data-lucide="log-out" class="mr-3 h-4 w-4"></i> Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Sidebar -->
            <aside id="sidebar" :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-50 h-screen w-72 bg-deep-green text-slate-100 shadow-2xl transition-transform duration-300">
                <div class="flex h-full flex-col">
                    <div class="flex h-16 items-center gap-3 border-b border-white/10 px-6">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <img src="{{ asset('logo-removed-background.png') }}" alt="COYZON Logo" class="h-14 w-auto">
                        </a>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[3px] text-white/60">Coyzon</p>
                            <p class="text-base font-bold text-white leading-tight">@yield('page_label', 'Portal')</p>
                        </div>
                        <button @click="mobileSidebarOpen = false"
                            class="ml-auto flex h-10 w-10 items-center justify-center rounded-lg text-white/70 hover:bg-white/5 lg:hidden">
                            <i data-lucide="x" class="h-5 w-5"></i>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto sidebar-scroll px-4 py-6 space-y-6">
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 shadow-lg shadow-blue-900/10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-500/10 text-blue-300">
                                    <i data-lucide="sparkles" class="h-6 w-6"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">
                                        {{ auth()->user()?->name ?? 'Welcome' }}
                                    </p>
                                    <p class="text-[12px] font-medium text-white/60 truncate">@yield('page_label', 'Portal')
                                        space</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="px-2 text-[11px] font-semibold uppercase tracking-[2px] text-white/50 mb-3">Navigation
                            </p>
                            <nav class="space-y-1">
                                @yield('sidebar')
                            </nav>
                        </div>
                    </div>

                    <div class="border-t border-white/10 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center text-white">
                                <i data-lucide="zap" class="h-5 w-5"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-white">Coyzon Portal</p>
                                <p class="text-[11px] font-medium text-white/50">Built with Laravel & Tailwind</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-40 bg-slate-900/70 backdrop-blur-sm lg:hidden" x-cloak></div>

            <!-- Main Content -->
            <main class="min-h-screen pt-20 transition-all duration-300 lg:ml-72">
                <div class="px-4 pb-10 sm:px-6 lg:px-10">
                    @yield('content')
                </div>
            </main>
        </div>
    @else
        <div class="min-h-screen bg-slate-50">
            @yield('content')
        </div>
    @endif

    <!-- Flash Messages -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col space-y-3">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="min-w-[320px] rounded-xl bg-green-600 px-5 py-4 text-white shadow-2xl shadow-green-500/30 ring-1 ring-green-400/40">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <i data-lucide="check-circle" class="h-6 w-6"></i>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-white/70 hover:text-white">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="min-w-[320px] rounded-xl bg-red-600 px-5 py-4 text-white shadow-2xl shadow-red-500/30 ring-1 ring-red-400/40">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <i data-lucide="alert-triangle" class="h-6 w-6"></i>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-white/70 hover:text-white">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });

        document.addEventListener('alpine:initialized', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>

</html>