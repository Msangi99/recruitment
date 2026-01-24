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
            <h2 class="text-2xl font-bold text-slate-900">Skills & Competencies</h2>
            <p class="mt-2 text-sm text-slate-600">Highlight your top skills (max 15). This helps employers find you based
                on what you can do.</p>
        </div>

        <form action="{{ route('candidate.wizard.process', ['step' => 4]) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Skills Input -->
            <div>
                <label for="skills" class="block text-sm font-medium text-slate-700">Add Skills</label>
                <p class="text-xs text-slate-500 mb-2">Select from the list or type to add new skills.</p>
                <select name="skills[]" id="skills" multiple="multiple"
                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    @foreach($allSkills as $skill)
                        <option value="{{ $skill->name }}" {{ (collect(old('skills'))->contains($skill->name) || $profile->skills->contains('name', $skill->name)) ? 'selected' : '' }}>
                            {{ $skill->name }}
                        </option>
                    @endforeach
                    {{-- Handle existing skills that might not be in the allSkills list (custom ones) --}}
                    @foreach($profile->skills as $skill)
                        @if(!$allSkills->contains('name', $skill->name))
                            <option value="{{ $skill->name }}" selected>{{ $skill->name }}</option>
                        @endif
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-slate-500">You can add up to 15 skills.</p>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-200 mt-6">
                <a href="{{ route('candidate.wizard.show', ['step' => 3]) }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Save & Continue
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#skills').select2({
                    placeholder: "Select or type skills",
                    tags: true, // Allow creating new options
                    tokenSeparators: [','],
                    maximumSelectionLength: 15,
                    width: '100%'
                });
            });
        </script>
    @endpush
@endsection