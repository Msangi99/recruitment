@extends('layouts.admin')

@section('title', 'Consultation Bookings')

@section('content')
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    @if(request('type') == 'employer') Book Employer Meeting
                    @elseif(request('type') == 'partnership') Schedule Partnership Call
                    @elseif(request('type') == 'job_seeker') Book Career Consultation
                    @else Consultation Requests @endif
                </h2>
                <p class="text-slate-500 mt-1">Manage and track all incoming consultation and meeting bookings.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                    @foreach($consultations->take(5) as $c)
                        <img class="h-8 w-8 rounded-full border-2 border-white shadow-sm" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($c->name) }}&background=random&color=fff" 
                             alt="{{ $c->name }}">
                    @endforeach
                </div>
                <span class="text-sm font-medium text-slate-600">+{{ max(0, $consultations->total() - 5) }} recent requests</span>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Bookings</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $consultations->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Pending</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $consultations->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Confirmed</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $consultations->where('status', 'confirmed')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">This Month</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $consultations->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-slate-700 uppercase tracking-wider">Active Bookings</span>
                    <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold">{{ $consultations->total() }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    {{-- Quick Filters could be added here --}}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-[2px]">Booking Type</th>
                            <th scope="col" class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-[2px]">Contact Information</th>
                            <th scope="col" class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-[2px]">Scheduled Date</th>
                            <th scope="col" class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-[2px]">Current Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-[11px] font-extrabold text-slate-500 uppercase tracking-[2px]">Management</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($consultations as $consultation)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-xl flex items-center justify-center
                                            @if($consultation->type == 'employer') bg-blue-100 text-blue-600 
                                            @elseif($consultation->type == 'partnership') bg-purple-100 text-purple-600 
                                            @else bg-green-100 text-green-600 @endif">
                                            <i data-lucide="{{ $consultation->type == 'employer' ? 'building-2' : ($consultation->type == 'partnership' ? 'handshake' : 'graduation-cap') }}" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                @if($consultation->type == 'employer') bg-blue-50 text-blue-700 border border-blue-100
                                                @elseif($consultation->type == 'partnership') bg-purple-50 text-purple-700 border border-purple-100
                                                @else bg-green-50 text-green-700 border border-green-100 @endif">
                                                {{ str_replace('_', ' ', $consultation->type) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900">{{ $consultation->name }}</span>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($consultation->company)
                                                <span class="text-[12px] text-slate-500 font-medium flex items-center">
                                                    <i data-lucide="briefcase" class="w-3 h-3 mr-1 opacity-60"></i>
                                                    {{ $consultation->company }}
                                                </span>
                                            @endif
                                            <span class="text-[12px] text-slate-400">•</span>
                                            <span class="text-[12px] text-slate-500 font-medium">{{ $consultation->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($consultation->requested_date)
                                        <div class="flex flex-col">
                                            <div class="flex items-center text-sm font-semibold text-slate-800">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-blue-500"></i>
                                                {{ $consultation->requested_date->format('M d, Y') }}
                                            </div>
                                            <div class="flex items-center text-[11px] text-slate-400 mt-1 uppercase font-bold tracking-wider">
                                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                                {{ $consultation->requested_date->format('h:i A') }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center text-[11px] font-bold text-slate-400 uppercase tracking-wider italic">
                                            <i data-lucide="calendar-x" class="w-3 h-3 mr-1"></i> Not set
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <form action="{{ route('admin.consultations.updateStatus', $consultation->id) }}" method="POST" id="statusForm-{{ $consultation->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="document.getElementById('statusForm-{{ $consultation->id }}').submit()" 
                                            class="appearance-none text-[11px] font-bold uppercase tracking-wider rounded-xl border-0 ring-1 ring-inset px-3 py-1.5 focus:ring-2 focus:ring-blue-500
                                                @if($consultation->status == 'pending') bg-yellow-50 text-yellow-700 ring-yellow-200
                                                @elseif($consultation->status == 'pending_review') bg-orange-50 text-orange-700 ring-orange-200
                                                @elseif($consultation->status == 'confirmed') bg-green-50 text-green-700 ring-green-200
                                                @elseif($consultation->status == 'completed') bg-slate-100 text-slate-700 ring-slate-200
                                                @elseif($consultation->status == 'cancelled') bg-red-50 text-red-700 ring-red-200
                                                @else bg-slate-50 text-slate-600 ring-slate-100 @endif">
                                            <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="pending_review" {{ $consultation->status == 'pending_review' ? 'selected' : '' }}>Reviewing</option>
                                            <option value="confirmed" {{ $consultation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.consultations.show', $consultation->id) }}"
                                            class="inline-flex items-center justify-center h-9 w-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <button class="inline-flex items-center justify-center h-9 w-9 rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-200 transition-all shadow-sm">
                                            <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center max-w-xs mx-auto">
                                        <div class="h-20 w-20 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-10 h-10 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">No requests found</h3>
                                        <p class="text-sm text-slate-500 mt-1 text-center">We couldn't find any consultation requests matching your current filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($consultations->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection