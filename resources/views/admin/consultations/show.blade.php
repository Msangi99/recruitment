@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
    <div class="space-y-8 max-w-7xl mx-auto">
        {{-- Top Bar / Actions --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.consultations.index') }}"
                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Booking #{{ $consultation->id }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                            @if($consultation->type == 'employer') bg-blue-50 text-blue-700 border border-blue-100
                            @elseif($consultation->type == 'partnership') bg-purple-50 text-purple-700 border border-purple-100
                            @else bg-green-50 text-green-700 border border-green-100 @endif">
                            {{ str_replace('_', ' ', $consultation->type) }}
                        </span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-medium text-slate-500 italic">Submitted
                            {{ $consultation->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    Print
                </button>
                <button
                    class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                    <i data-lucide="share-2" class="w-4 h-4"></i>
                    Share
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Information --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Contact Information --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-blue-500 text-white flex items-center justify-center">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-slate-900">Lead Contact Info</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Full
                                    Name</p>
                                <p class="text-slate-900 font-bold text-lg">{{ $consultation->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Email
                                    Address</p>
                                <a href="mailto:{{ $consultation->email }}"
                                    class="text-blue-600 font-bold flex items-center gap-2 hover:underline">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                    {{ $consultation->email }}
                                </a>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Phone
                                    Number</p>
                                <p class="text-slate-900 font-bold flex items-center gap-2">
                                    <i data-lucide="phone" class="w-4 h-4 text-slate-400"></i>
                                    {{ $consultation->phone }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Company
                                    / Organization</p>
                                <p class="text-slate-900 font-bold flex items-center gap-2">
                                    <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                                    {{ $consultation->company ?? 'Not Specified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Meta Data --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-slate-800 text-white flex items-center justify-center">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-slate-900">Additional Request Data</h3>
                    </div>
                    <div class="p-0">
                        @if(is_array($consultation->meta_data) && count($consultation->meta_data) > 0)
                            <div class="divide-y divide-slate-100">
                                @foreach($consultation->meta_data as $key => $value)
                                    <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 hover:bg-slate-50 transition-colors">
                                        <div
                                            class="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center md:justify-end md:pr-4 md:border-r md:border-slate-100">
                                            {{ str_replace('_', ' ', $key) }}
                                        </div>
                                        <div class="md:col-span-2 text-sm text-slate-800 font-medium">
                                            @if(is_array($value))
                                                <div class="p-3 bg-slate-100 rounded-lg font-mono text-xs">
                                                    {{ json_encode($value, JSON_PRETTY_PRINT) }}
                                                </div>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-12 text-center text-slate-400 italic">
                                <i data-lucide="info" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                No additional metadata provided for this request.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Status & Schedule --}}
            <div class="space-y-8">
                {{-- Status Management Card --}}
                <div
                    class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden ring-1 ring-blue-500 ring-opacity-10">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900">Process Status</h3>
                        <span class="inline-flex h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                    </div>
                    <div class="p-6 space-y-6">
                        <form action="{{ route('admin.consultations.updateStatus', $consultation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2 block">Current
                                        Status</label>
                                    <select name="status"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 font-bold text-slate-900 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm p-4 appearance-none leading-tight">
                                        <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>
                                            Pending Arrival</option>
                                        <option value="pending_review" {{ $consultation->status == 'pending_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="confirmed" {{ $consultation->status == 'confirmed' ? 'selected' : '' }}>Confirmed / Booked</option>
                                        <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Fulfilled / Finished</option>
                                        <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>Cancelled / Void</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-all scale-100 active:scale-95 shadow-blue-500/20">
                                    Update Case Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Appointment Schedule Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-orange-500 text-white flex items-center justify-center">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-slate-900">Schedule</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($consultation->requested_date)
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="text-center px-3 py-2 bg-white rounded-lg border border-slate-200 shadow-sm">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase">
                                        {{ $consultation->requested_date->format('M') }}</p>
                                    <p class="text-xl font-extrabold text-slate-900 leading-none">
                                        {{ $consultation->requested_date->format('d') }}</p>
                                </div>
                                <div class="pt-1">
                                    <p class="text-sm font-bold text-slate-900">{{ $consultation->requested_date->format('l') }}
                                    </p>
                                    <p class="text-xs font-medium text-slate-500">
                                        {{ $consultation->requested_date->format('h:i A') }}
                                        ({{ $consultation->duration_minutes ?? '45' }} min)</p>
                                </div>
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-orange-50 border border-orange-100 text-orange-800 text-center">
                                <i data-lucide="alert-circle" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                <p class="text-sm font-bold uppercase tracking-wider">No time selected</p>
                                <p class="text-xs mt-1">This request does not have a confirmed time slot yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Card (for Job Seekers) --}}
                @if($consultation->type == 'job_seeker')
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100 bg-emerald-50/50 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-slate-900">Financial Audit</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-slate-500">Amount Charged</span>
                                <span class="text-lg font-bold text-slate-900">{{ number_format($consultation->amount) }}
                                    TZS</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-slate-500">Payment Status</span>
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border
                                        {{ $consultation->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100' }}">
                                    {{ $consultation->payment_status }}
                                </span>
                            </div>
                            @if($consultation->payment_gateway)
                                <div class="pt-4 border-t border-slate-50 text-[11px] text-slate-400 font-medium">
                                    via {{ ucfirst($consultation->payment_gateway) }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection