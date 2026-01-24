@extends('candidate.profile.wizard.layout')

@section('wizard-content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Tailwind-ish styling for Select2 */
    .select2-container .select2-selection--multiple {
        border-color: #e2e8f0;
        border-radius: 0.5rem;
        min-height: 42px;
        padding: 4px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #10b981;
        box-shadow: 0 0 0 1px #10b981;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 0.25rem;
        padding-left: 6px;
        padding-right: 6px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #065f46;
        margin-right: 6px;
        border-right: 1px solid #a7f3d0;
    }
</style>

<div class="max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900">International Readiness</h2>
        <p class="mt-2 text-sm text-slate-600">Are you interested in opportunities abroad? Let employers know.</p>
    </div>

    <form action="{{ route('candidate.wizard.process', ['step' => 7]) }}" method="POST" class="space-y-8">
        @csrf

        <!-- Willing to Work Abroad -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-3">Willing to Work Abroad?</label>
            <div class="flex items-center space-x-6">
                <div class="flex items-center">
                    <input id="relocate-yes" name="willing_to_relocate" type="radio" value="1"
                        {{ $profile->willing_to_relocate ? 'checked' : '' }}
                        class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="relocate-yes" class="ml-3 block text-sm font-medium text-slate-700">Yes</label>
                </div>
                <div class="flex items-center">
                    <input id="relocate-no" name="willing_to_relocate" type="radio" value="0"
                        {{ !$profile->willing_to_relocate && !is_null($profile->willing_to_relocate) ? 'checked' : '' }}
                        class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="relocate-no" class="ml-3 block text-sm font-medium text-slate-700">No</label>
                </div>
            </div>
        </div>

        <!-- Preferred Destination Countries -->
        <div>
            <label for="preferred_destinations" class="block text-sm font-medium text-slate-700">Preferred Destination Countries</label>
            <p class="text-xs text-slate-500 mb-2">Select countries you'd like to work in (Max 7).</p>
            <select name="preferred_destinations[]" id="preferred_destinations" multiple="multiple"
                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                @if(is_array($profile->preferred_destinations))
                    @foreach($profile->preferred_destinations as $country)
                        <option value="{{ $country }}" selected>{{ $country }}</option>
                    @endforeach
                @endif
                {{-- Add some common options if needed, or just let users type --}}
                <option value="UAE">UAE</option>
                <option value="Qatar">Qatar</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Oman">Oman</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Germany">Germany</option>
                <option value="Canada">Canada</option>
                <option value="UK">UK</option>
                <option value="USA">USA</option>
            </select>
        </div>

        <!-- Passport Status -->
        <div>
            <label for="passport_status" class="block text-sm font-medium text-slate-700">Passport Status</label>
            <select name="passport_status" id="passport_status"
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                <option value="">Select Status</option>
                <option value="Valid" {{ $profile->passport_status == 'Valid' ? 'selected' : '' }}>Valid</option>
                <option value="In Process" {{ $profile->passport_status == 'In Process' ? 'selected' : '' }}>In Process</option>
                <option value="Not Available" {{ $profile->passport_status == 'Not Available' ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-slate-200 mt-6">
            <a href="{{ route('candidate.wizard.show', ['step' => 6]) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Save & Continue
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#preferred_destinations').select2({
            placeholder: "Select or type countries",
            tags: true,
            maximumSelectionLength: 7,
            width: '100%'
        });
    });
</script>
@endpush
@endsection
