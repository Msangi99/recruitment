@extends('candidate.profile.wizard.layout')

@section('wizard-content')
<!-- Quill stylesheet -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        min-height: 150px;
    }
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-color: #e2e8f0;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-color: #e2e8f0;
    }
</style>

<div class="max-w-3xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Work Experience</h2>
        <p class="mt-2 text-sm text-slate-600">Add your relevant work experience, starting with the most recent.</p>
    </div>

    <!-- List of Added Experiences -->
    @if($profile->workExperiences->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($profile->workExperiences as $experience)
                <div class="bg-white border border-slate-200 rounded-lg p-4 flex justify-between items-start hover:border-emerald-300 transition-colors">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $experience->job_title }}</h3>
                        <p class="text-slate-600 font-medium">{{ $experience->employer }}</p>
                        <p class="text-sm text-slate-500 mt-1">
                            {{ $experience->city }}, {{ $experience->country }} • 
                            {{ $experience->start_date->format('M Y') }} - 
                            {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                        </p>
                        @if($experience->description)
                            <div class="text-sm text-slate-600 mt-2 prose prose-sm max-w-none">
                                {!! $experience->description !!}
                            </div>
                        @endif
                    </div>
                    <form action="{{ route('candidate.wizard.work-experience.destroy', $experience->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="ml-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-red-500 p-1">
                            <span class="sr-only">Delete</span>
                            <i data-lucide="trash-2" class="h-5 w-5"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Add New Experience Form -->
    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 mb-8">
        <h3 class="text-lg font-medium text-slate-900 mb-4">Add Experience</h3>
        <form action="{{ route('candidate.wizard.work-experience.store') }}" method="POST" id="experience-form" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Job Title</label>
                    <input type="text" name="job_title" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Employer</label>
                    <input type="text" name="employer" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">City</label>
                    <input type="text" name="city" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Country</label>
                    <input type="text" name="country" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Start Date</label>
                    <input type="date" name="start_date" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    <div class="flex items-center mt-2">
                        <input type="checkbox" name="is_current" id="is_current" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <label for="is_current" class="ml-2 block text-sm text-slate-700">I currently work here</label>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Key Responsibilities</label>
                    <div id="editor-container"></div>
                    <input type="hidden" name="description" id="description">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-deep-green py-2 px-6 text-sm font-bold text-white shadow-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all transform hover:scale-105 active:scale-95">
                    <i data-lucide="plus" class="h-4 w-4 mr-2"></i> Add Experience
                </button>
            </div>
        </form>
    </div>

    <!-- Continue Form -->
    <form action="{{ route('candidate.wizard.process', ['step' => 5]) }}" method="POST">
        @csrf
        <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
             <div class="flex items-start">
                <div class="flex h-5 items-center">
                    <input id="international_experience" name="international_experience" type="checkbox" value="1" 
                        {{ $profile->international_experience ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                </div>
                <div class="ml-3 text-sm">
                    <label for="international_experience" class="font-medium text-blue-900">I have international work experience</label>
                    <p class="text-blue-700">Check this if you have worked outside your home country.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-slate-200">
            <a href="{{ route('candidate.wizard.show', ['step' => 4]) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                @if($profile->workExperiences->count() == 0)
                    Skip & Continue
                @else
                    Save & Continue
                @endif
            </button>
        </div>
    </form>
</div>

@push('scripts')
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isCurrent = document.getElementById('is_current');
        const endDate = document.getElementById('end_date');

        if (isCurrent && endDate) {
            isCurrent.addEventListener('change', function() {
                if (this.checked) {
                    endDate.value = '';
                    endDate.disabled = true;
                    endDate.classList.add('bg-slate-100');
                } else {
                    endDate.disabled = false;
                    endDate.classList.remove('bg-slate-100');
                }
            });
            // Initial check
            if (isCurrent.checked) {
                endDate.disabled = true;
                endDate.classList.add('bg-slate-100');
            }
        }

        // Initialize Quill editor
        const editorEl = document.getElementById('editor-container');
        if (editorEl) {
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: '• Led a team of...\n• Increased sales by...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            // Handle form submission
            var form = document.getElementById('experience-form');
            if (form) {
                form.onsubmit = function() {
                    // Populate hidden input on submit
                    var description = document.getElementById('description');
                    if (description && typeof quill !== 'undefined') {
                        // only submit if there is actual content (not just empty tags)
                        if (quill.getText().trim().length > 0) {
                            description.value = quill.root.innerHTML;
                        } else {
                            description.value = '';
                        }
                    }
                    return true;
                };
            }
        }
    });
</script>
@endpush
@endsection
