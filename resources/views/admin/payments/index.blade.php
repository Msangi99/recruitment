@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Payment Transactions</h2>
            <p class="text-sm text-gray-500">Track all revenue and payment statuses</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_revenue']) }} <span class="text-xs font-normal">TZS</span></p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm font-medium text-gray-500">Completed</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['completed_payments'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm font-medium text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pending_payments'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm font-medium text-gray-500">Failed</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['failed_payments'] }}</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-wrap gap-2">
        <select name="payment_status" class="border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2 bg-white">
            <option value="">All Payment Status</option>
            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
        </select>
        <div class="flex items-center gap-2">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="border border-gray-300 rounded-xl shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
            <span class="text-gray-400">to</span>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border border-gray-300 rounded-xl shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="px-6 py-2 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-colors shadow-sm">
            Filter
        </button>
    </form>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Appointment Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $payment->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">{{ ucfirst($payment->appointment_type) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ number_format($payment->amount) }} {{ $payment->currency }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                    {{ $payment->payment_status == 'completed' ? 'bg-green-100 text-green-700' : 
                                       ($payment->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ strtoupper($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-gray-500">
                                {{ $payment->transaction_id ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ $payment->created_at->format('M d, Y') }}
                                <div class="text-[10px] text-gray-400">{{ $payment->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="fb-blue hover:underline">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="banknote" class="w-12 h-12 text-gray-300 mb-2"></i>
                                    <p>No payment records found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
