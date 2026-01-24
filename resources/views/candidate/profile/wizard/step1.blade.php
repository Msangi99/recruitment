@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Welcome, {{ $user->name }}!</h2>
            <p class="mt-2 text-sm text-slate-600">Let's set up your profile to help you find the best opportunities. First,
                confirm your account details.</p>
        </div>

        <form action="{{ route('candidate.wizard.process', ['step' => 1]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Account Information</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Full Name</label>
                        <div class="mt-1">
                            <input type="text" disabled
                                class="block w-full rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm sm:text-sm"
                                value="{{ $user->name }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email Address</label>
                        <div class="mt-1">
                            <input type="email" disabled
                                class="block w-full rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm sm:text-sm"
                                value="{{ $user->email }}">
                        </div>
                    </div>

                    <!-- Phone (if available) -->
                    @if($user->phone)
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Phone Number</label>
                            <div class="mt-1">
                                <input type="text" disabled
                                    class="block w-full rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm sm:text-sm"
                                    value="{{ $user->phone }}">
                            </div>
                        </div>
                    @endif
                </div>
                <p class="mt-4 text-xs text-slate-500 flex items-center">
                    <i data-lucide="info" class="h-4 w-4 mr-1"></i>
                    To change these details, please contact support or go to account settings after completing your profile.
                </p>
            </div>

            <div class="flex items-center justify-end pt-6">
                <button type="submit"
                    class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Start Profile
                    <svg class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection