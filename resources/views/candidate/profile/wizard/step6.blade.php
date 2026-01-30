@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Education & Training</h2>
            <p class="mt-2 text-sm text-slate-600">List your academic qualifications and certifications.</p>
        </div>

        <!-- List of Added Educations -->
        @if($profile->educations->count() > 0)
            <div class="space-y-4 mb-8">
                @foreach($profile->educations as $education)
                    <div
                        class="bg-white border border-slate-200 rounded-lg p-4 flex justify-between items-start hover:border-emerald-300 transition-colors">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $education->level }} in
                                {{ $education->field_of_study }}
                            </h3>
                            <p class="text-slate-600 font-medium">{{ $education->institution }}</p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $education->city }}, {{ $education->country }} •
                                {{ $education->start_date->format('M Y') }} -
                                {{ $education->is_current ? 'Present' : ($education->end_date ? $education->end_date->format('M Y') : '') }}
                            </p>
                        </div>
                        <form action="{{ route('candidate.wizard.education.destroy', $education->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
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

        <!-- Add New Education Form -->
        <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 mb-8">
            <h3 class="text-lg font-medium text-slate-900 mb-4">Education</h3>
            <form action="{{ route('candidate.wizard.education.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Education Level</label>
                        <select name="level" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            <option value="">Select Level</option>
                            <option value="No Formal Education">No Formal Education</option>
                            <option value="Primary Education">Primary Education</option>
                            <option value="Secondary Education">Secondary Education</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                            <option value="Master's Degree">Master's Degree</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Field of Study</label>
                        <input type="text" name="field_of_study" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                            placeholder="e.g. Computer Science">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Institution / University</label>
                        <input type="text" name="institution" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">City</label>
                        <input type="text" name="city" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Country</label>
                        <input type="text" name="country" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">From</label>
                        <input type="date" name="start_date" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">To</label>
                        <input type="date" name="end_date" id="end_date"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        <div class="flex items-center mt-2">
                            <input type="checkbox" name="is_current" id="is_current" value="1"
                                class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <label for="is_current" class="ml-2 block text-sm text-slate-700">I am currently studying
                                here</label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-deep-green py-2 px-6 text-sm font-bold text-white shadow-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all transform hover:scale-105 active:scale-95">
                        <i data-lucide="plus" class="h-4 w-4 mr-2"></i> Save
                    </button>
                </div>
            </form>
        </div>

        <!-- List of Added Trainings -->
        @if($profile->trainings->count() > 0)
            <div class="space-y-4 mb-8">
                <h3 class="text-lg font-medium text-slate-900">Training & Certifications</h3>
                @foreach($profile->trainings as $training)
                    <div
                        class="bg-white border border-slate-200 rounded-lg p-4 flex justify-between items-start hover:border-emerald-300 transition-colors">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $training->name }}</h3>
                            <p class="text-slate-600 font-medium">{{ $training->institution }}</p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $training->start_date->format('M Y') }} -
                                {{ $training->end_date ? $training->end_date->format('M Y') : '' }}
                            </p>
                        </div>
                        <form action="{{ route('candidate.wizard.training.destroy', $training->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
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

        <!-- Add New Training Form -->
        <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 mb-8">
            <h3 class="text-lg font-medium text-slate-900 mb-4">Add Training & Certification</h3>
            <form action="{{ route('candidate.wizard.training.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Field of Training</label>
                        <input type="text" name="name" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                            placeholder="e.g. Project Management">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Institute</label>
                        <input type="text" name="institution" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">From</label>
                        <input type="date" name="start_date" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">To</label>
                        <input type="date" name="end_date"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-deep-green py-2 px-6 text-sm font-bold text-white shadow-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all transform hover:scale-105 active:scale-95">
                        <i data-lucide="plus" class="h-4 w-4 mr-2"></i> Save Training
                    </button>
                </div>
            </form>
        </div>

        <!-- Continue Form -->
        <form action="{{ route('candidate.wizard.process', ['step' => 6]) }}" method="POST">
            @csrf
            <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                <a href="{{ route('candidate.wizard.show', ['step' => 5]) }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900">Back</a>
                <button type="submit"
                    class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    @if($profile->educations->count() == 0)
                        Skip & Continue
                    @else
                        Save & Continue
                    @endif
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isCurrent = document.getElementById('is_current');
            const endDate = document.getElementById('end_date');

            if (isCurrent && endDate) {
                isCurrent.addEventListener('change', function () {
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
        });
    </script>
@endsection