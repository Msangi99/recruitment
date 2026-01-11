@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Top Stats Cards (Pluto Style) -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Users -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-shadow">
            <div class="p-4 bg-orange-50 rounded-full mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="users" class="w-8 h-8 text-orange-500"></i>
            </div>
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_users'] }}</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Total Users</p>
        </div>

        <!-- Pending Verifications -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-shadow">
            <div class="p-4 bg-blue-50 rounded-full mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="shield-check" class="w-8 h-8 text-blue-500"></i>
            </div>
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['pending_verifications'] }}</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Pending</p>
        </div>

        <!-- Active Jobs -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-shadow">
            <div class="p-4 bg-green-50 rounded-full mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="briefcase" class="w-8 h-8 text-green-500"></i>
            </div>
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['active_jobs'] }}</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Active Jobs</p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-shadow">
            <div class="p-4 bg-purple-50 rounded-full mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="credit-card" class="w-8 h-8 text-purple-500"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-800">{{ number_format($stats['total_revenue'] / 1000, 1) }}k</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Revenue (TZS)</p>
        </div>
    </div>

    <!-- Social Style Analytics (Pluto Style) -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Candidates Section -->
        <div class="bg-[#3b5998] rounded-xl overflow-hidden shadow-lg group">
            <div class="p-8 flex items-center justify-center border-b border-white/10">
                <i data-lucide="user-plus" class="w-12 h-12 text-white"></i>
            </div>
            <div class="grid grid-cols-2 divide-x divide-white/10 bg-white p-4">
                <div class="text-center">
                    <p class="text-lg font-black text-gray-800">{{ $stats['total_candidates'] }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-black text-green-600">{{ $stats['verified_candidates'] }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Verified</p>
                </div>
            </div>
        </div>

        <!-- Employers Section -->
        <div class="bg-[#00acee] rounded-xl overflow-hidden shadow-lg group">
            <div class="p-8 flex items-center justify-center border-b border-white/10">
                <i data-lucide="building-2" class="w-12 h-12 text-white"></i>
            </div>
            <div class="grid grid-cols-2 divide-x divide-white/10 bg-white p-4">
                <div class="text-center">
                    <p class="text-lg font-black text-gray-800">{{ $stats['total_employers'] }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Employers</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-black text-blue-600">85%</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Active</p>
                </div>
            </div>
        </div>

        <!-- Applications Section -->
        <div class="bg-[#0e76a8] rounded-xl overflow-hidden shadow-lg group">
            <div class="p-8 flex items-center justify-center border-b border-white/10">
                <i data-lucide="file-text" class="w-12 h-12 text-white"></i>
            </div>
            <div class="grid grid-cols-2 divide-x divide-white/10 bg-white p-4">
                <div class="text-center">
                    <p class="text-lg font-black text-gray-800">{{ $stats['total_applications'] }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Apps</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-black text-orange-600">12</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">New Today</p>
                </div>
            </div>
        </div>

        <!-- System Status Section -->
        <div class="bg-[#db4a39] rounded-xl overflow-hidden shadow-lg group">
            <div class="p-8 flex items-center justify-center border-b border-white/10">
                <i data-lucide="activity" class="w-12 h-12 text-white"></i>
            </div>
            <div class="grid grid-cols-2 divide-x divide-white/10 bg-white p-4">
                <div class="text-center">
                    <p class="text-lg font-black text-gray-800">99.9%</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Uptime</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-black text-red-600">0</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Errors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra Area Chart Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter">Extra Area Chart</h3>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Dataset 1</span>
                <span class="w-3 h-3 rounded-full bg-green-500 ml-4"></span>
                <span class="text-[10px] font-bold text-gray-400 uppercase">Dataset 2</span>
            </div>
        </div>
        <div class="p-8 h-[400px] flex items-center justify-center">
            <!-- Placeholder for Chart.js -->
            <div class="w-full h-full bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                <i data-lucide="bar-chart-3" class="w-12 h-12 mb-4 opacity-20"></i>
                <p class="text-sm font-bold uppercase tracking-widest">Interactive Chart Visualization</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">Pending Verifications</h3>
                <a href="{{ route('admin.verification.pending') }}" class="text-[10px] font-bold text-orange-500 hover:underline uppercase tracking-widest">View All</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingVerifications->take(5) as $profile)
                    <div class="p-6 flex items-center hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-md mr-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($profile->user->name) }}&background=f0f2f5&color=15283c" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-gray-800 truncate uppercase">{{ $profile->user->name }}</p>
                            <p class="text-[11px] font-bold text-gray-400 truncate">{{ $profile->user->email }}</p>
                        </div>
                        <a href="{{ route('admin.verification.pending') }}" class="ml-4 px-5 py-2 pluto-orange text-white text-[10px] font-black rounded-lg uppercase shadow-sm hover:opacity-90 transition-opacity">
                            Review
                        </a>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-400 italic">
                        <i data-lucide="check-circle-2" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                        <p class="text-sm font-bold uppercase tracking-widest">No pending tasks</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">Recent Jobs</h3>
                <a href="{{ route('admin.jobs.index') }}" class="text-[10px] font-bold text-orange-500 hover:underline uppercase tracking-widest">View All</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentJobs as $job)
                    <div class="p-6 flex items-center hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 rounded-xl pluto-orange flex items-center justify-center mr-4 shadow-lg text-white font-black text-xl">
                            {{ substr($job->company_name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-gray-800 truncate uppercase tracking-tighter">{{ $job->title }}</p>
                            <p class="text-[11px] font-bold text-gray-400 truncate uppercase">{{ $job->company_name }} • {{ $job->location }}</p>
                        </div>
                        <div class="ml-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $job->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} uppercase">
                                {{ $job->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-400 italic">
                        <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                        <p class="text-sm font-bold uppercase tracking-widest">No job postings</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
