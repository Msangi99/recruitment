@extends('layouts.app')

@section('title', 'Cancel Subscription - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.billing.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Billing</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Cancel Subscription</h2>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="mb-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Warning:</strong> Cancelling your subscription will end your access to premium features at the end of your current billing period.
                        </p>
                    </div>
                    <p class="text-gray-700 mb-4">
                        We're sorry to see you go. Please let us know why you're cancelling so we can improve our service.
                    </p>
                </div>

                <form method="POST" action="{{ route('candidate.billing.cancelConfirm') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Cancellation (Optional)</label>
                        <textarea name="reason" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="Tell us why you're cancelling..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('candidate.billing.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Keep Subscription
                        </a>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to cancel your subscription?')">
                            Cancel Subscription
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection