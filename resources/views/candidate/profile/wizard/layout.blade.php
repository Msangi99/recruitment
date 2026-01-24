@extends('layouts.app')

@section('title', 'Complete Your Profile')
@section('page_label', 'Profile Wizard')

@include('candidate.partials.nav')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="relative pt-1">
                <div class="flex mb-2 items-center justify-between">
                    <div>
                        <span
                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-emerald-600 bg-emerald-100">
                            Step {{ $step ?? 1 }} of 12
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold inline-block text-emerald-600">
                            {{ round((($step ?? 1) / 12) * 100) }}%
                        </span>
                    </div>
                </div>
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-100">
                    <div style="width:{{ (($step ?? 1) / 12) * 100 }}%"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-deep-green transition-all duration-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Wizard Content -->
        <div class="bg-white shadow-sm ring-1 ring-slate-200 sm:rounded-xl">
            <div class="px-4 py-5 sm:p-6">
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ session('error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('wizard-content')
            </div>
        </div>
    </div>
@endsection