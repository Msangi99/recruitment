@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <!-- Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            min-height: 200px;
            font-size: 16px;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            border-color: #e2e8f0;
            background: #f8fafc;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            border-color: #e2e8f0;
        }
    </style>

    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Professional Summary</h2>
            <p class="mt-2 text-sm text-slate-600">Give employers a quick overview of your expertise and what you can bring
                to their team.</p>
        </div>

        <form action="{{ route('candidate.wizard.process', ['step' => 7]) }}" method="POST" id="summary-form"
            class="space-y-6">
            @csrf

            <div>
                <label for="headline" class="block text-sm font-semibold text-slate-700 mb-1">Professional Headline</label>
                <input type="text" name="headline" id="headline" value="{{ old('headline', $profile->headline) }}"
                    placeholder="e.g. Senior Civil Engineer with 10+ years of experience"
                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-deep-green focus:ring-deep-green sm:text-sm"
                    required>
                <p class="mt-1 text-xs text-slate-500">A short, catchy phrase summarizing your professional identity.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Professional Description</label>
                <div id="editor-container">{!! old('description', $profile->description) !!}</div>
                <input type="hidden" name="description" id="description_input">
                <p class="mt-2 text-xs text-slate-500">Detailed summary of your career highlights, key skills, and
                    professional goals.</p>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                <a href="{{ route('candidate.wizard.show', ['step' => 6]) }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Save & Continue
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <!-- Include the Quill library -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            // Initialize Quill editor
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Tell us more about your professional background and achievements...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            // Handle form submission
            var form = document.getElementById('summary-form');
            form.onsubmit = function () {
                var description = document.getElementById('description_input');
                if (quill.root.innerText.trim().length > 0) {
                    description.value = quill.root.innerHTML;
                } else {
                    description.value = '';
                }
            };
        </script>
    @endpush
@endsection