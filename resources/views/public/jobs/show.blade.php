<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .step-transition {
            transition: all 0.3s ease-in-out;
        }

        .ck-editor__editable {
            min-height: 180px !important;
            border-bottom-left-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
            font-size: 0.875rem !important;
        }

        .ck-toolbar {
            border-top-left-radius: 8px !important;
            border-top-right-radius: 8px !important;
            padding: 6px 8px !important;
            min-height: 36px !important;
        }

        .ck-toolbar__items {
            height: 24px !important;
        }

        .ck-button {
            height: 24px !important;
            width: 24px !important;
            min-height: 24px !important;
            min-width: 24px !important;
        }

        .ck.ck-icon {
            width: 14px !important;
            height: 14px !important;
        }
    </style>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
</head>

<body class="bg-gray-50">
    @include('partials.public-nav')

    <div class="max-w-3xl mx-auto py-4 px-3">
        @if(session('success'))
        <div class="bg-white shadow-sm rounded-xl mb-6">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Application Submitted</h2>
                <p class="text-gray-600 mb-6 text-sm">Thank you for applying. We will contact you if shortlisted.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('candidate.applications.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-deep-green hover:bg-opacity-90 transition-all">
                        View Applications
                    </a>
                    <a href="{{ route('public.jobs.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all">
                        Browse Jobs
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-3 bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded-lg flex items-center text-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <!-- Step 1: Job Details -->
        <div id="step-1" class="step-transition @if(session('success')) hidden @endif">
            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
                <div class="px-5 py-4 space-y-5">
                    <a href="{{ route('public.jobs.index') }}"
                        class="text-blue-600 hover:text-blue-900 flex items-center text-sm">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Jobs
                    </a>

                    <!-- Job Header -->
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $job->title }}</h1>
                        <p class="text-gray-600 text-sm mt-0.5">{{ $job->company_name }}</p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-xs">
                                📍 {{ $job->location }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-xs">
                                💼 {{ ucfirst($job->employment_type) }}
                            </span>
                            @if($job->category)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-xs">
                                🏷️ {{ $job->category->name }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Details -->
                    <div class="grid grid-cols-2 gap-3">
                        @if($job->salary_min || $job->salary_max)
                        <div class="bg-gray-50 rounded p-2">
                            <h3 class="text-xs font-medium text-gray-500">Salary</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                @if($job->salary_min && $job->salary_max)
                                {{ $job->salary_currency ?? 'USD' }} {{ number_format($job->salary_min) }} -
                                {{ number_format($job->salary_max) }}
                                @elseif($job->salary_min)
                                {{ $job->salary_currency ?? 'USD' }} {{ number_format($job->salary_min) }}+
                                @else
                                Competitive
                                @endif
                            </p>
                        </div>
                        @endif

                        @php
                        $exp = $job->experience_years ?? $job->experience_required ?? 0;
                        @endphp
                        <div class="bg-gray-50 rounded p-2">
                            <h3 class="text-xs font-medium text-gray-500">Experience</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                @if($exp == 0)
                                No experience
                                @else
                                {{ $exp }}+ years
                                @endif
                            </p>
                        </div>

                        @if($job->education_level)
                        <div class="bg-gray-50 rounded p-2">
                            <h3 class="text-xs font-medium text-gray-500">Education</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ ucfirst(str_replace('-', ' ', $job->education_level)) }}
                            </p>
                        </div>
                        @endif

                        @if($job->working_mode)
                        <div class="bg-gray-50 rounded p-2">
                            <h3 class="text-xs font-medium text-gray-500">Mode</h3>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ ucfirst($job->working_mode) }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Job Description -->
                    <div>
                        <h2 class="text-base font-bold text-gray-900 mb-2">Job Description</h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! $job->description !!}
                        </div>
                    </div>

                    @if($job->requirements)
                    <div>
                        <h2 class="text-base font-bold text-gray-900 mb-2">Requirements</h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! $job->requirements !!}
                        </div>
                    </div>
                    @endif

                    @if(!empty($job->required_skills))
                    <div>
                        <h2 class="text-base font-bold text-gray-900 mb-2">Skills</h2>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($job->required_skills as $skill)
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                {{ $skill }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($job->benefits || $job->other_benefits)
                    <div>
                        <h2 class="text-base font-bold text-gray-900 mb-2">Benefits</h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            @if(is_array($job->benefits) && count($job->benefits) > 0)
                            <ul class="space-y-1">
                                @foreach($job->benefits as $benefit)
                                <li class="text-sm">{{ $benefit }}</li>
                                @endforeach
                            </ul>
                            @endif
                            @if($job->other_benefits)
                            <div class="mt-2">
                                {!! $job->other_benefits !!}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($job->application_deadline)
                    <div class="bg-red-50 border-l-3 border-red-400 p-2">
                        <p class="text-xs text-red-700 font-medium">
                            Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                        </p>
                    </div>
                    @endif

                    @if($job->requires_video)
                    <div class="bg-blue-50 border-l-3 border-blue-400 p-2">
                        <p class="text-xs text-blue-700">
                            <strong>Note:</strong> Video introduction required
                        </p>
                    </div>
                    @endif

                    <!-- Apply Button -->
                    <div class="pt-4 border-t border-gray-200">
                        @if($isCandidate)
                        @if($hasApplied)
                        <div class="bg-green-50 border border-green-100 rounded-lg p-4 text-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-green-800 font-semibold text-sm mb-1">Already Applied</p>
                            <a href="{{ route('candidate.applications.index') }}"
                                class="text-green-600 hover:text-green-800 font-medium inline-flex items-center text-xs">
                                View applications
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @else
                        <button type="button" onclick="showStep2()"
                            class="w-full px-4 py-2.5 bg-deep-green text-white font-bold rounded-lg hover:bg-opacity-90 transition-all text-sm">
                            Apply Now
                        </button>
                        @endif
                        @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}"
                            class="block w-full text-center px-4 py-2.5 bg-deep-green text-white font-bold rounded-lg hover:bg-opacity-90 transition-all text-sm">
                            Apply Now
                        </a>
                        @endif
                    </div>

                    <div class="text-xs text-gray-400 flex items-center pt-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Posted {{ $job->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Application Form (MINIMIZED) -->
        <div id="step-2" class="step-transition hidden">
            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100 max-w-lg mx-auto">
                <div class="bg-deep-green px-4 py-3 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-sm font-bold">Submit Application</h2>
                            <p class="text-green-100 opacity-90 text-xs mt-0.5">{{ $job->title }}</p>
                        </div>
                        <span class="text-xs bg-white/10 px-2 py-0.5 rounded-full">Step 2</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('candidate.jobs.apply', $job) }}" enctype="multipart/form-data"
                    class="p-4 space-y-4">
                    @csrf

                    <!-- Cover Letter -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-700">Cover Letter</label>
                        <div class="relative">
                            <textarea name="cover_letter" id="cover_editor"
                                class="hidden">{{ old('cover_letter') }}</textarea>
                            <div id="editor-container" class="min-h-[150px] border border-gray-200 rounded-lg"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-gray-400">
                            <span>Max 1,000 words</span>
                            <span id="word-count">0 words</span>
                        </div>
                    </div>

                    <!-- CV Upload -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-700">Upload CV/Resume</label>
                        <div class="relative">
                            <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx" class="hidden"
                                required onchange="updateFileName(this)">
                            <label for="cv_file"
                                class="flex items-center justify-between border border-dashed border-gray-200 rounded-lg p-3 hover:border-deep-green hover:bg-green-50 transition-all cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span id="file-name" class="text-gray-600 font-medium text-sm">Choose file</span>
                                        <div class="flex items-center gap-1 mt-0.5">
                                            <span class="text-gray-400 text-xs">PDF, DOC, DOCX</span>
                                            <span class="text-gray-400 text-xs">•</span>
                                            <span class="text-gray-400 text-xs">Max 5MB</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-deep-green font-medium text-xs">Browse</span>
                            </label>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 space-y-2">
                        <h3 class="text-xs font-bold text-gray-700">Your Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] text-gray-500 mb-0.5">Full Name</label>
                                <div class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500 mb-0.5">Email</label>
                                <div class="text-sm font-medium text-gray-700">{{ auth()->user()->email ?? '-' }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] text-gray-500 mb-0.5">Phone</label>
                                <div class="text-sm font-medium text-gray-700">{{ auth()->user()->phone ?? '-' }}</div>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400 italic text-center mt-1">Automatically filled from your
                            profile</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="showStep1()"
                            class="flex-1 px-3 py-2 border border-gray-200 text-gray-600 font-medium rounded-lg hover:bg-gray-50 transition-all text-sm">
                            Back
                        </button>
                        <button type="submit"
                            class="flex-[2] px-3 py-2 bg-deep-green text-white font-bold rounded-lg hover:bg-opacity-90 transition-all text-sm">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let editor;

        function showStep2() {
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // Initialize editor if not already initialized
            if (!editor) {
                ClassicEditor
                    .create(document.querySelector('#editor-container'), {
                        placeholder: 'Briefly explain why you are suitable for this position...',
                        toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList'],
                        removePlugins: ['Heading', 'Link', 'BlockQuote'],
                        height: '150px'
                    })
                    .then(newEditor => {
                        editor = newEditor;
                        editor.model.document.on('change:data', () => {
                            const data = editor.getData();
                            const text = data.replace(/<[^>]*>/g, '').trim();
                            const words = text.split(/\s+/).filter(word => word.length > 0);
                            const count = words.length;
                            document.getElementById('word-count').textContent = `${count} words`;
                            document.getElementById('cover_editor').value = data;
                            
                            if (count > 1000) {
                                document.getElementById('word-count').classList.add('text-red-500');
                                document.getElementById('word-count').classList.remove('text-gray-400');
                            } else {
                                document.getElementById('word-count').classList.remove('text-red-500');
                                document.getElementById('word-count').classList.add('text-gray-400');
                            }
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }

        function showStep1() {
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Choose file';
            document.getElementById('file-name').textContent = fileName;
        }
    </script>

    @include('partials.footer')
</body>

</html>