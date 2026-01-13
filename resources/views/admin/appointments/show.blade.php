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

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i data-lucide="calendar" class="w-5 h-5 mr-2 fb-blue"></i>
                        {{ $appointment->appointment_type === 'interview' ? 'Interview Request' : 'Appointment' }} Details
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
                        <!-- Candidate Info -->
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Candidate</p>
                            <p class="text-sm font-bold text-gray-900">{{ $appointment->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $appointment->user->email }}</p>
                        </div>

                        <!-- Company/Employer Info -->
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Company</p>
                            <p class="text-sm font-bold text-gray-900">{{ $appointment->company_name ?? 'N/A' }}</p>
                            @if($appointment->job_title)
                                <p class="text-xs text-gray-500">Position: {{ $appointment->job_title }}</p>
                            @endif
                        </div>

                        <!-- Interviewer Contact -->
                        @if($appointment->interviewer_email)
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Interviewer Email</p>
                            <p class="text-sm text-gray-900">
                                <a href="mailto:{{ $appointment->interviewer_email }}" class="fb-blue hover:underline">
                                    {{ $appointment->interviewer_email }}
                                </a>
                            </p>
                        </div>
                        @endif

                        @if($appointment->interviewer_phone)
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Interviewer Phone</p>
                            <p class="text-sm text-gray-900">{{ $appointment->interviewer_phone }}</p>
                        </div>
                        @endif

                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Type</p>
                            <p class="text-sm font-bold text-gray-900">{{ ucfirst($appointment->appointment_type) }}</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Meeting Mode</p>
                            <p class="text-sm font-bold text-gray-900">{{ ucfirst($appointment->meeting_mode ?? 'Not specified') }}</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Scheduled At</p>
                            <p class="text-sm font-bold text-gray-900">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y h:i A') : 'Not scheduled' }}</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase">Duration</p>
                            <p class="text-sm font-bold text-gray-900">{{ $appointment->duration_minutes ?? 30 }} minutes</p>
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

                        @if($appointment->meeting_location)
                            <div class="md:col-span-2 space-y-1">
                                <p class="text-xs font-bold text-gray-500 uppercase">Meeting Location</p>
                                <p class="text-sm text-gray-900">{{ $appointment->meeting_location }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Requirements Section -->
            @if($appointment->requirements)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i data-lucide="clipboard-list" class="w-5 h-5 mr-2 fb-blue"></i>
                        Requirements
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-700">
                        {!! nl2br(e($appointment->requirements)) !!}
                    </div>
                </div>
            </div>
            @endif

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
                            {!! nl2br(e($appointment->notes)) !!}
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">No notes added for this appointment.</p>
                    @endif
                </div>
            </div>

            <!-- Cancellation Reason (if cancelled) -->
            @if($appointment->status === 'cancelled' && $appointment->cancellation_reason)
            <div class="bg-red-50 rounded-xl shadow-sm border border-red-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100">
                    <h3 class="font-bold text-red-800 flex items-center">
                        <i data-lucide="x-circle" class="w-5 h-5 mr-2"></i>
                        Cancellation Reason
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-sm text-red-700">
                        {!! nl2br(e($appointment->cancellation_reason)) !!}
                    </div>
                </div>
            </div>
            @endif
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
                            <select name="status" id="status-select" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2" id="notes-label">
                                Notes <span id="reason-hint" class="text-red-500 hidden">(Cancellation reason - required)</span>
                            </label>
                            <textarea name="notes" id="notes-textarea" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Add any details or changes..."></textarea>
                            <p class="text-xs text-gray-500 mt-1" id="notes-hint">
                                <span id="confirm-hint" class="hidden">When confirmed, emails will be sent to both candidate and employer.</span>
                                <span id="cancel-hint" class="hidden text-red-600">Please provide a reason for cancellation. An email will be sent to the employer.</span>
                            </p>
                        </div>
                        <button type="submit" class="w-full px-6 py-2.5 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 transition-colors shadow-sm">
                            Update Appointment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Email Notification Info -->
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                <h4 class="text-sm font-bold text-blue-800 mb-2">📧 Email Notifications</h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• <strong>Confirmed:</strong> Emails sent to candidate & employer</li>
                    <li>• <strong>Cancelled:</strong> Email sent to employer with reason</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status-select');
    const notesTextarea = document.getElementById('notes-textarea');
    const reasonHint = document.getElementById('reason-hint');
    const confirmHint = document.getElementById('confirm-hint');
    const cancelHint = document.getElementById('cancel-hint');
    
    function updateHints() {
        const status = statusSelect.value;
        
        // Reset all hints
        reasonHint.classList.add('hidden');
        confirmHint.classList.add('hidden');
        cancelHint.classList.add('hidden');
        notesTextarea.placeholder = 'Add any details or changes...';
        
        if (status === 'cancelled') {
            reasonHint.classList.remove('hidden');
            cancelHint.classList.remove('hidden');
            notesTextarea.placeholder = 'Enter the reason for cancellation...';
        } else if (status === 'confirmed') {
            confirmHint.classList.remove('hidden');
        }
    }
    
    statusSelect.addEventListener('change', updateHints);
    updateHints(); // Initialize on page load
});
</script>
@endsection
