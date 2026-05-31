@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('admin.payments.index') }}" class="hover:fb-blue flex items-center font-medium">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
            Back to Payments
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Payment Transaction Details</h3>
                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">Transaction #{{ $transaction->transaction_id ?? $transaction->order_id ?? 'PENDING' }}</p>
                </div>
                <span class="px-4 py-1.5 rounded-full text-xs font-bold 
                    {{ $transaction->payment_status == 'completed' ? 'bg-green-100 text-green-700' : 
                       ($transaction->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ strtoupper($transaction->payment_status) }}
                </span>
            </div>
            
            <div class="p-8">
                <div class="flex flex-col items-center justify-center py-8 border-b border-gray-100 mb-8">
                    <span class="text-gray-400 text-sm font-bold uppercase tracking-widest mb-2">Total Amount</span>
                    <h2 class="text-4xl font-black text-gray-900">{{ number_format($transaction->amount) }} <span class="text-lg font-bold text-gray-400">{{ $transaction->currency }}</span></h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Customer Information</p>
                        <p class="text-sm font-bold text-gray-900">{{ $transaction->customer_name }}</p>
                        <p class="text-xs text-gray-500">{{ $transaction->customer_email }}</p>
                        @if($transaction->phone)
                            <p class="text-xs text-gray-500">{{ $transaction->phone }}</p>
                        @endif
                    </div>
                    
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Payment Method</p>
                        <p class="text-sm font-bold text-gray-900">{{ $transaction->payment_gateway ? ucfirst($transaction->payment_gateway) : 'Platform Gateway' }}</p>
                        <p class="text-xs text-gray-500">{{ $source === 'consultation' ? 'Public booking payment' : 'Mobile Money / Card' }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Transaction Type</p>
                        <p class="text-sm font-bold text-gray-900">{{ $transaction->type_label }}</p>
                        <p class="text-xs text-gray-500">Internal Reference ID: #{{ $transaction->id }}</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Transaction Date</p>
                        <p class="text-sm font-bold text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('h:i:s A') }}</p>
                    </div>

                    @if($transaction->order_id)
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Order ID</p>
                            <p class="text-sm font-mono font-bold text-blue-600">{{ $transaction->order_id }}</p>
                        </div>
                    @endif

                    @if($transaction->transaction_id)
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Gateway Reference</p>
                            <p class="text-sm font-mono font-bold text-blue-600">{{ $transaction->transaction_id }}</p>
                        </div>
                    @endif

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Raw Status</p>
                        <p class="text-sm font-bold text-gray-900">{{ strtoupper($transaction->raw_payment_status) }}</p>
                    </div>

                    @if($source === 'consultation' && !empty($record->requested_date))
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Scheduled Date</p>
                            <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($record->requested_date)->format('M d, Y @ H:i') }}</p>
                        </div>
                    @endif

                    @if($source === 'appointment' && !empty($record->scheduled_at))
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Scheduled Date</p>
                            <p class="text-sm font-bold text-gray-900">{{ $record->scheduled_at->format('M d, Y @ H:i') }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-center">
                    <button onclick="window.print()" class="flex items-center text-sm font-bold text-gray-500 hover:fb-blue transition-colors">
                        <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
