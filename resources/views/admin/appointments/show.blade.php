@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('admin.appointments.index') }}" class="hover:fb-blue flex items-center font-medium">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
            Back to Appointments
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i data-lucide="calendar" class="w-5 h-5 mr-2 fb-blue"></i>
                        Appointment Information
                    </h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                        {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-700' : 
                           ($appointment->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                           ($appointment->status == 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                        {{ strtoupper($appointment->status) }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Candidate</p>
                            <p class="text-sm font-bold text-gray-900">{{ $appointment->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $appointment->user->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Employer</p>
                            @if($appointment->employer)
                                <p class="text-sm font-bold text-gray-900">{{ $appointment->employer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $appointment->employer->email }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic font-medium">Internal / N/A</p>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Type</p>
                            <p class="text-sm font-bold text-gray-900">{{ ucfirst($appointment->appointment_type) }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Scheduled At</p>
                            <p class="text-sm font-bold text-gray-900">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y h:i A') : 'Not scheduled' }}</p>
                        </div>
                        @if($appointment->amount > 0)
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-gray-500 uppercase">Amount</p>
                                <p class="text-sm font-bold text-gray-900">{{ number_format($appointment->amount) }} {{ $appointment->currency }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-gray-500 uppercase">Payment Status</p>
                                <span class="px-2 py-0.5 inline-flex text-[10px] font-bold rounded-full 
                                    {{ $appointment->payment_status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ strtoupper($appointment->payment_status) }}
                                </span>
                            </div>
                        @endif
                        @if($appointment->meeting_link)
                            <div class="md:col-span-2 space-y-1">
                                <p class="text-xs font-bold text-gray-500 uppercase">Meeting Link</p>
                                <a href="{{ $appointment->meeting_link }}" target="_blank" class="text-sm fb-blue font-bold hover:underline flex items-center">
                                    <i data-lucide="video" class="w-4 h-4 mr-1"></i>
                                    Join Meeting
                                </a>
                                <p class="text-[10px] text-gray-400 break-all">{{ $appointment->meeting_link }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i data-lucide="sticky-note" class="w-5 h-5 mr-2 fb-blue"></i>
                        Appointment Notes
                    </h3>
                </div>
                <div class="p-6">
                    @if($appointment->notes)
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-700">
                            {{ $appointment->notes }}
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">No notes added for this appointment.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">Update Status</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">New Status</label>
                            <select name="status" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Update Notes</label>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Add any details or changes...">{{ old('notes', $appointment->notes) }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-2.5 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm">
                            Update Appointment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
