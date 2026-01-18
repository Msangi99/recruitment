@extends('layouts.public')

@section('title', 'Schedule Appointment - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Payment Successful</h1>
                    <p class="text-gray-600 mt-2">Please select a time for your consultation.</p>
                </div>

                <form action="{{ route('public.appointments.storeSchedule', ['id' => $request->id]) }}" method="POST"
                    class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Date</label>
                        <input type="date" name="scheduled_date" required min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Time</label>
                        <select name="scheduled_time" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                            <option value="">Select Time Slot</option>
                            @foreach(['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'] as $time)
                                <option value="{{ $time }}">{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Confirm Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection