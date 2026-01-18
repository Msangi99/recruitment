@extends('layouts.app')

@section('title', 'Appointment Confirmed - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8 text-center">
                <div
                    class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Confirmed!</h1>
                <p class="text-gray-600 mb-8">Your appointment has been successfully scheduled.</p>

                <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left border border-gray-100">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider mb-2">Appointment Details</p>
                    <div class="space-y-2">
                        <p class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span
                                class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-600">Time:</span>
                            <span
                                class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($request->requested_date)->format('H:i') }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span
                                class="font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $request->type) }}</span>
                        </p>
                    </div>
                </div>

                <p class="text-sm text-gray-500 mb-8">
                    We have sent a confirmation email with the meeting link (Zoom/Google Meet) to
                    <strong>{{ $request->email }}</strong>.
                </p>

                <a href="{{ route('home') }}"
                    class="block w-full py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl transition-colors shadow-lg">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
@endsection