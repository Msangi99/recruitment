@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-xl mx-auto text-center py-8">
        <div class="mb-6 inline-flex items-center justify-center h-20 w-20 rounded-full bg-emerald-100">
            <svg class="h-10 w-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Application Submitted!</h2>
        <p class="text-lg text-slate-600 mb-8">
            Thank you for completing your profile. Your information has been submitted for review.
            Employers can now view your profile.
        </p>

        <div class="flex justify-center space-x-4">
            <a href="{{ route('candidate.dashboard') }}"
                class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Go to Dashboard
            </a>
        </div>
    </div>
@endsection