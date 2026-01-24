@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Language Skills</h2>
            <p class="mt-2 text-sm text-slate-600">Select languages you speak and your proficiency level.</p>
        </div>

        <form action="{{ route('candidate.wizard.process', ['step' => 8]) }}" method="POST" class="space-y-6">
            @csrf

            <div id="languages-container" class="space-y-4">
                @php
                    $currentLanguages = $profile->languages;
                    if ($currentLanguages->isEmpty()) {
                        $currentLanguages = [null]; // Start with one empty row
                    }
                @endphp

                @foreach($currentLanguages as $index => $lang)
                    <div class="language-row flex gap-4 items-start p-4 bg-slate-50 rounded-lg border border-slate-200">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Language</label>
                            <select name="languages[{{ $index }}][id]"
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                                <option value="">Select Language</option>
                                @foreach($allLanguages as $l)
                                    <option value="{{ $l->id }}" {{ $lang && $lang->id == $l->id ? 'selected' : '' }}>{{ $l->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Proficiency</label>
                            <select name="languages[{{ $index }}][proficiency]"
                                class="block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                                <option value="Basic" {{ $lang && $lang->pivot->proficiency == 'Basic' ? 'selected' : '' }}>Basic
                                </option>
                                <option value="Conversational" {{ $lang && $lang->pivot->proficiency == 'Conversational' ? 'selected' : '' }}>Conversational</option>
                                <option value="Fluent" {{ $lang && $lang->pivot->proficiency == 'Fluent' ? 'selected' : '' }}>
                                    Fluent</option>
                                <option value="Native" {{ $lang && $lang->pivot->proficiency == 'Native' ? 'selected' : '' }}>
                                    Native</option>
                            </select>
                        </div>
                        <button type="button" class="mt-6 text-slate-400 hover:text-red-500" onclick="removeRow(this)">
                            <span class="sr-only">Remove</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-language-btn"
                class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Another Language
            </button>

            <div class="flex items-center justify-between pt-6 border-t border-slate-200 mt-6">
                <a href="{{ route('candidate.wizard.show', ['step' => 7]) }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Save & Continue
                </button>
            </div>
        </form>
    </div>

    <template id="language-row-template">
        <div class="language-row flex gap-4 items-start p-4 bg-slate-50 rounded-lg border border-slate-200">
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Language</label>
                <select name="languages[INDEX][id]"
                    class="block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    <option value="">Select Language</option>
                    @foreach($allLanguages as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Proficiency</label>
                <select name="languages[INDEX][proficiency]"
                    class="block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    <option value="Basic">Basic</option>
                    <option value="Conversational">Conversational</option>
                    <option value="Fluent">Fluent</option>
                    <option value="Native">Native</option>
                </select>
            </div>
            <button type="button" class="mt-6 text-slate-400 hover:text-red-500" onclick="removeRow(this)">
                <span class="sr-only">Remove</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </template>

    <script>
        const container = document.getElementById('languages-container');
        const addBtn = document.getElementById('add-language-btn');
        const template = document.getElementById('language-row-template');
        let rowCount = {{ $currentLanguages instanceof \Illuminate\Database\Eloquent\Collection ? $currentLanguages->count() : 1 }};

        addBtn.addEventListener('click', () => {
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.language-row');

            // Update names with index
            row.querySelectorAll('select').forEach(select => {
                select.name = select.name.replace('INDEX', rowCount);
            });

            container.appendChild(row);
            rowCount++;
        });

        window.removeRow = function (btn) {
            if (container.children.length > 1) {
                btn.closest('.language-row').remove();
            } else {
                // Clear values instead of removing last row
                const row = btn.closest('.language-row');
                row.querySelectorAll('select').forEach(s => s.value = '');
            }
        };
    </script>
@endsection