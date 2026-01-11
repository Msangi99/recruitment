@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Appointments</h2>
            <p class="text-sm text-gray-500">Manage candidate interviews and employer meetings</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.appointments.index') }}" class="flex flex-wrap gap-2">
        <select name="status" class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white">
            <option value="">All Appointment Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <select name="payment_status" class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white">
            <option value="">All Payment Status</option>
            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
        </select>
        <button type="submit" class="px-6 py-2 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-colors shadow-sm">
            Filter
        </button>
    </form>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Employer</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Type & Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $appointment->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $appointment->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($appointment->employer)
                                    <div class="text-sm font-medium text-gray-900">{{ $appointment->employer->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $appointment->employer->email }}</div>
                                @else
                                    <span class="text-xs text-gray-400 font-medium italic">Internal / N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-bold">{{ ucfirst($appointment->appointment_type) }}</div>
                                <div class="text-xs text-gray-500">
                                    <i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i>
                                    {{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y h:i A') : 'TBD' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($appointment->amount > 0)
                                    <div class="text-sm font-bold text-gray-900 mb-1">{{ number_format($appointment->amount) }} {{ $appointment->currency }}</div>
                                    <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-full 
                                        {{ $appointment->payment_status == 'completed' ? 'bg-green-100 text-green-700' : 
                                           ($appointment->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ strtoupper($appointment->payment_status) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 font-bold">FREE</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                    {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-700' : 
                                       ($appointment->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                       ($appointment->status == 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="fb-blue hover:underline">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="calendar-x" class="w-12 h-12 text-gray-300 mb-2"></i>
                                    <p>No appointments found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
