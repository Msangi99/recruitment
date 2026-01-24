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
        <h2 class="text-2xl font-bold text-slate-900">Job Preferences</h2>
        <p class="mt-2 text-sm text-slate-600">Tell us what kind of work you're looking for so we can match you with the right employers.</p>
    </div>

    <form action="{{ route('candidate.wizard.process', ['step' => 3]) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Job Category -->
        <div>
            <label for="categories" class="block text-sm font-medium text-slate-700">Job Category</label>
            <p class="text-xs text-slate-500 mb-2">Select the categories that best fit your expertise.</p>
            <select name="categories[]" id="categories" multiple="multiple"
                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (collect(old('categories'))->contains($category->id) || $profile->categories->contains($category->id)) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Preferred Job Titles -->
        <div>
            <label for="preferred_job_titles" class="block text-sm font-medium text-slate-700">Preferred Job Titles</label>
            <div class="mt-1">
                <input type="text" name="preferred_job_titles" id="preferred_job_titles" 
                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                    value="{{ old('preferred_job_titles', is_array($profile->preferred_job_titles) ? implode(', ', $profile->preferred_job_titles) : $profile->preferred_job_titles) }}"
                    placeholder="e.g. Accountant, Financial Analyst (Max 5)">
            </div>
            <p class="mt-1 text-xs text-slate-500">Separate multiple titles with commas.</p>
        </div>

        <!-- Availability -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Availability</label>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input id="avail-immediate" name="availability_status" type="radio" value="Immediately"
                        {{ old('availability_status', $profile->availability_status) == 'Immediately' ? 'checked' : '' }}
                        class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="avail-immediate" class="ml-3 block text-sm font-medium text-slate-700">Immediately</label>
                </div>
                <div class="flex items-center">
                    <input id="avail-2weeks" name="availability_status" type="radio" value="Within 2 Weeks"
                        {{ old('availability_status', $profile->availability_status) == 'Within 2 Weeks' ? 'checked' : '' }}
                        class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="avail-2weeks" class="ml-3 block text-sm font-medium text-slate-700">Within 2 Weeks</label>
                </div>
                <div class="flex items-center">
                    <input id="avail-1month" name="availability_status" type="radio" value="Within 1 Month"
                        {{ old('availability_status', $profile->availability_status) == 'Within 1 Month' ? 'checked' : '' }}
                        class="h-4 w-4 border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="avail-1month" class="ml-3 block text-sm font-medium text-slate-700">Within 1 Month</label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-slate-200 mt-6">
            <a href="{{ route('candidate.wizard.show', ['step' => 2]) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
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
        $('#categories').select2({
            placeholder: "Select categories",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
@endsection
