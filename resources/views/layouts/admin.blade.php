<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} Admin - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-removed-background.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --admin-accent: #2563eb;
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

        /* Custom button styles */
        .fb-blue-bg {
            background-color: #2563eb;
        }

        .fb-blue {
            color: #2563eb;
        }

        .hover\:fb-blue:hover {
            color: #2563eb;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased" x-data="{ 
    mobileSidebarOpen: false, 
    bookingsOpen: {{ request()->routeIs('admin.consultations.*') ? 'true' : 'false' }} 
}">
    <!-- Top Navbar -->
    <nav class="fixed inset-x-0 top-0 z-40 h-16 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="flex h-full items-center px-4 sm:px-6 lg:px-8 lg:pl-80 gap-4">
            <button @click="mobileSidebarOpen = true"
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 focus:outline-none lg:hidden">
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>

            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-14 w-auto">
                </a>
                <div>
                    <p class="text-xs uppercase tracking-[3px] text-slate-500 font-semibold">Admin</p>
                    <p class="text-lg font-semibold text-slate-900">@yield('title', 'Dashboard')</p>
                </div>
            </div>

            <div class="flex-1 lg:max-w-xl">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400"></i>
                    <input type="text" placeholder="Search anything..."
                        class="w-full rounded-xl border border-slate-200 bg-white/70 py-2 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="hidden h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm hover:text-blue-600 focus:outline-none md:flex">
                    <i data-lucide="bell" class="h-4 w-4"></i>
                </button>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-2 py-1 shadow-sm hover:border-blue-200">
                        <div class="h-9 w-9 overflow-hidden rounded-full border border-slate-200">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff"
                                alt="User" class="h-full w-full object-cover">
                        </div>
                        <div class="hidden text-left text-sm font-semibold text-slate-800 md:block">
                            <p class="leading-none">{{ auth()->user()->name }}</p>
                            <span class="text-[11px] font-medium text-slate-500">Administrator</span>
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
                            <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-2">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
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
        class="fixed inset-y-0 left-0 z-50 h-screen w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-slate-100 shadow-2xl transition-transform duration-300">
        <div class="flex h-full flex-col">
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-6">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('logo-removed-background.png') }}" alt="Coyzon Logo" class="h-14 w-auto">
                </a>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[3px] text-white/60">Coyzon</p>
                    <p class="text-base font-bold text-white leading-tight">Admin Console</p>
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
                            <i data-lucide="shield-check" class="h-6 w-6"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[12px] font-medium text-white/60 truncate">Welcome back</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="px-2 text-[11px] font-semibold uppercase tracking-[2px] text-white/50 mb-3">General</p>
                    <nav class="space-y-1">
                        <x-admin-sidebar-item href="{{ route('admin.dashboard') }}" icon="layout-dashboard"
                            label="Dashboard" :active="request()->routeIs('admin.dashboard')" />
                        <x-admin-sidebar-item href="{{ route('admin.candidates.index') }}" icon="users"
                            label="Candidates" :active="request()->routeIs('admin.candidates.*')" />
                        <x-admin-sidebar-item href="{{ route('admin.verification.pending') }}" icon="shield-check"
                            label="Verifications" :active="request()->routeIs('admin.verification.*')" />
                        <x-admin-sidebar-item href="{{ route('admin.categories.index') }}" icon="tag" label="Categories"
                            :active="request()->routeIs('admin.categories.*')" />
                        <x-admin-sidebar-item href="{{ route('admin.jobs.index') }}" icon="briefcase" label="Jobs"
                            :active="request()->routeIs('admin.jobs.*')" />
                        {{-- <x-admin-sidebar-item href="{{ route('admin.appointments.index') }}" icon="calendar"
                            label="Candidate Requests" :active="request()->routeIs('admin.appointments.*')" /> --}}

                        <div class="space-y-1">
                            <button @click="bookingsOpen = !bookingsOpen"
                                class="flex w-full items-center px-4 py-3.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.consultations.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                                <div
                                    class="mr-4 flex items-center justify-center transition-transform duration-200 group-hover:scale-110">
                                    <i data-lucide="calendar-check"
                                        class="w-5 h-5 {{ request()->routeIs('admin.consultations.*') ? 'text-white' : 'text-orange-500' }}"></i>
                                </div>
                                <span class="text-[14px] font-bold tracking-wide">Bookings</span>
                                <i data-lucide="chevron-down" class="ml-auto w-4 h-4 transition-transform duration-200"
                                    :class="bookingsOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="bookingsOpen" x-cloak x-collapse class="pl-12 space-y-1">
                                <a href="{{ route('admin.consultations.index', ['type' => 'employer']) }}"
                                    class="block py-2 text-sm font-bold transition-colors {{ request('type') == 'employer' ? 'text-white' : 'text-white/50 hover:text-white' }}">
                                    Book Employer Meeting
                                </a>
                                <a href="{{ route('admin.consultations.index', ['type' => 'partnership']) }}"
                                    class="block py-2 text-sm font-bold transition-colors {{ request('type') == 'partnership' ? 'text-white' : 'text-white/50 hover:text-white' }}">
                                    Schedule Partnership Call
                                </a>
                                <a href="{{ route('admin.consultations.index', ['type' => 'job_seeker']) }}"
                                    class="block py-2 text-sm font-bold transition-colors {{ request('type') == 'job_seeker' ? 'text-white' : 'text-white/50 hover:text-white' }}">
                                    Book Career Consultation
                                </a>
                            </div>
                        </div>
                        <x-admin-sidebar-item href="{{ route('admin.calendar') }}" icon="calendar-range"
                            label="Calendar" :active="request()->routeIs('admin.calendar')" />
                        <x-admin-sidebar-item href="{{ route('admin.payments.index') }}" icon="credit-card"
                            label="Payments" :active="request()->routeIs('admin.payments.*')" />
                        @php $unreadEmails = \App\Models\ContactMessage::unread()->count(); @endphp
                        <x-admin-sidebar-item href="{{ route('admin.contact-messages.index') }}" icon="mail"
                            label="Emails" :active="request()->routeIs('admin.contact-messages.*')"
                            :badge="$unreadEmails > 0 ? $unreadEmails : null" />
                        <x-admin-sidebar-item href="{{ route('admin.settings.index') }}" icon="settings"
                            label="Settings" :active="request()->routeIs('admin.settings.*')" />
                    </nav>
                </div>
            </div>

            <div class="border-t border-white/10 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center text-white">
                        <i data-lucide="zap" class="h-5 w-5"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white">Coyzon Admin</p>
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
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
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