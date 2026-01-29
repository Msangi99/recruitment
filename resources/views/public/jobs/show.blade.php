<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - {{ config('app.name') }}</title>
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
            min-height: 250px;
            border-bottom-left-radius: 12px !important;
            border-bottom-right-radius: 12px !important;
        }

        .ck-toolbar {
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }
    </style>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
</head>

<body class="bg-gray-50">
    @include('partials.public-nav')

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('public.jobs.index') }}" class="text-blue-600 hover:text-blue-900 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Jobs
                </a>
            </div>

            @if(session('success'))
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8 transform transition-all">
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Application Submitted Successfully</h2>
                        <p class="text-lg text-gray-600 mb-8">Thank you for applying. Your application has been received and
                            is under review. We will contact you if you are shortlisted.</p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('candidate.applications.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-deep-green hover:bg-opacity-90 transition-all shadow-lg">
                                View My Applications
                            </a>
                            <a href="{{ route('public.jobs.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all shadow-sm">
                                Browse More Jobs
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Step 1: Job Details -->
            <div id="step-1" class="step-transition @if(session('success')) hidden @endif">
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
                    <!-- Job Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                        <h1 class="text-3xl font-bold">{{ $job->title }}</h1>
                        <p class="text-blue-100 mt-2">{{ $job->company_name }}</p>
                        <div class="flex flex-wrap gap-4 mt-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                                📍 {{ $job->location }}, {{ $job->country }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                                💼 {{ ucfirst($job->employment_type) }}
                            </span>
                            @if($job->category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                                    🏷️ {{ $job->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <!-- Key Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Salary</h3>
                                <p class="text-lg font-semibold text-gray-900">
                                    @if($job->salary_min && $job->salary_max)
                                        {{ $job->salary_currency ?? 'USD' }} {{ number_format($job->salary_min) }} -
                                        {{ number_format($job->salary_max) }}
                                        @if($job->salary_period)
                                            / {{ $job->salary_period }}
                                        @endif
                                    @elseif($job->salary_min)
                                        {{ $job->salary_currency ?? 'USD' }} {{ number_format($job->salary_min) }}+
                                    @else
                                        Competitive salary
                                    @endif
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Experience Required</h3>
                                <p class="text-lg font-semibold text-gray-900">
                                    @php
                                        $exp = $job->experience_years ?? $job->experience_required ?? 0;
                                    @endphp
                                    @if($exp == 0)
                                        No experience required
                                    @else
                                        {{ $exp }}+ years
                                    @endif
                                </p>
                            </div>

                            @if($job->education_level)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Education Level</h3>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ ucfirst(str_replace('-', ' ', $job->education_level)) }}
                                    </p>
                                </div>
                            @endif

                            @if($job->contract_duration)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Contract Duration</h3>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $job->contract_duration }}
                                    </p>
                                </div>
                            @endif

                            @if($job->working_mode)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Working Mode</h3>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ ucfirst($job->working_mode) }}
                                    </p>
                                </div>
                            @endif

                            @if(!empty($job->languages))
                                                        <div class="bg-gray-50 rounded-lg p-4">
                                                            <h3 class="text-sm font-medium text-gray-500 mb-2">Language Requirements</h3>
                                                            <p class="text-lg font-semibold text-gray-900">
                                                                {{ collect($job->languages)->map(function ($lang) {
                                    if (is_array($lang)) {
                                        $name = $lang['name'] ?? $lang['language'] ?? '';
                                        $prof = $lang['proficiency'] ?? $lang['level'] ?? '';
                                        return $name . ($prof ? ' (' . $prof . ')' : '');
                                    }
                                    return $lang;
                                })->filter()->implode(', ') }}
                                                            </p>
                                                        </div>
                            @endif
                        </div>

                        <!-- Job Description -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Job Description</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! $job->description !!}
                            </div>
                        </div>

                        <!-- Requirements -->
                        @if($job->requirements)
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Job Requirement</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $job->requirements !!}
                                </div>
                            </div>
                        @endif

                        <!-- Skills -->
                        @if(!empty($job->required_skills))
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Required Skills</h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($job->required_skills as $skill)
                                        <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Benefits -->
                        @if($job->benefits || $job->other_benefits)
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Job Benefits</h2>
                                <div class="prose max-w-none text-gray-700">
                                    @if(is_array($job->benefits) && count($job->benefits) > 0)
                                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                            @foreach($job->benefits as $benefit)
                                                <li>{{ $benefit }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($job->other_benefits)
                                        <div class="mt-4">
                                            {!! $job->other_benefits !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Application Deadline -->
                        @if($job->application_deadline)
                            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700 font-bold">
                                            Deadline:
                                            {{ \Carbon\Carbon::parse($job->application_deadline)->format('F d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Video Requirement Notice -->
                        @if($job->requires_video)
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Note:</strong> This job requires a video introduction when applying.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Apply Button -->
                        <div class="border-t border-gray-200 pt-6">
                            @if($isCandidate)
                                @if($hasApplied)
                                    <div class="bg-green-50 border border-green-100 rounded-xl p-6 text-center">
                                        <div
                                            class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="text-green-800 font-semibold text-lg mb-2">You have already applied for this
                                            job</p>
                                        <a href="{{ route('candidate.applications.index') }}"
                                            class="text-green-600 hover:text-green-800 font-medium inline-flex items-center">
                                            View your applications
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <button type="button" onclick="showStep2()"
                                        class="w-full px-8 py-4 bg-deep-green text-white font-bold rounded-xl hover:bg-opacity-90 transform active:scale-95 transition-all shadow-lg text-lg">
                                        Apply now
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}"
                                    class="block w-full text-center px-8 py-4 bg-deep-green text-white font-bold rounded-xl hover:bg-opacity-90 transform active:scale-95 transition-all shadow-lg text-lg">
                                    Apply now
                                </a>
                            @endif
                        </div>

                        <!-- Job Meta -->
                        <div class="border-t border-gray-200 pt-6 text-sm text-gray-400 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Posted on {{ $job->created_at->format('F d, Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Application Form -->
            <div id="step-2" class="step-transition hidden">
                <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
                    <div class="bg-deep-green px-8 py-6 text-white">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-2xl font-bold">Submit Your Application</h2>
                            <span
                                class="text-green-100 text-sm font-medium bg-white/10 px-3 py-1 rounded-full border border-white/20">Step
                                2 of 2</span>
                        </div>
                        <p class="text-green-100 opacity-90">Application Details</p>
                    </div>

                    <form method="POST" action="{{ route('candidate.jobs.apply', $job) }}" enctype="multipart/form-data"
                        class="p-8 space-y-8">
                        @csrf

                        <!-- Section 1: Cover Letter -->
                        <div class="space-y-3">
                            <label for="cover_letter" class="block text-sm font-bold text-gray-700">Cover
                                Letter</label>
                            <textarea name="cover_letter" id="cover_letter" rows="8"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-deep-green focus:ring-deep-green transition-all"
                                placeholder="Briefly explain why you are suitable for this position. Highlight your experience, skills, and availability.">{{ old('cover_letter') }}</textarea>
                            <div class="flex justify-between text-xs text-gray-400">
                                <span>Text area (maximum 1,000 words)</span>
                                <span id="word-count">0 words</span>
                            </div>
                        </div>

                        <!-- Section 2: Upload CV -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-gray-700">Upload Your CV / Resume</label>
                            <div class="relative group">
                                <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx" class="hidden"
                                    required onchange="updateFileName(this)">
                                <label for="cv_file"
                                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-2xl p-8 hover:border-deep-green hover:bg-green-50 transition-all cursor-pointer">
                                    <div
                                        class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-deep-green group-hover:text-white transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </div>
                                    <span id="file-name" class="text-gray-600 font-medium">Click to upload or drag
                                        and drop</span>
                                    <div class="flex items-center gap-3 mt-4">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs">PDF,
                                            DOC, DOCX</span>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs">MAX
                                            5MB</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Section 3: Auto-Filled Information -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 space-y-4">
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Your Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Full Name</label>
                                    <input type="text" value="{{ auth()->user()->name ?? '-' }}" disabled
                                        class="w-full bg-white border-none rounded-lg text-gray-500 font-medium px-4 py-2 opacity-75">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Email
                                        Address</label>
                                    <input type="text" value="{{ auth()->user()->email ?? '-' }}" disabled
                                        class="w-full bg-white border-none rounded-lg text-gray-500 font-medium px-4 py-2 opacity-75">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Phone Number</label>
                                    <input type="text" value="{{ auth()->user()->phone ?? '-' }}" disabled
                                        class="w-full bg-white border-none rounded-lg text-gray-500 font-medium px-4 py-2 opacity-75">
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 italic mt-4 text-center">Information is
                                automatically pulled from your user profile.</p>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" onclick="showStep1()"
                                class="flex-1 px-8 py-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all">
                                Back
                            </button>
                            <button type="submit"
                                class="flex-[2] px-8 py-4 bg-deep-green text-white font-bold rounded-xl hover:bg-opacity-90 transform active:scale-95 transition-all shadow-lg text-lg">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showStep2() {
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showStep1() {
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Click to upload or drag and drop';
            document.getElementById('file-name').textContent = fileName;
        }

        const coverLetter = document.getElementById('cover_letter');
        const wordCountDisplay = document.getElementById('word-count');

        if (coverLetter) {
            ClassicEditor
                .create(coverLetter, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                    placeholder: 'Briefly explain why you are suitable for this position. Highlight your experience, skills, and availability.'
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        const text = data.replace(/<[^>]*>/g, '').trim();
                        const words = text.split(/\s+/).filter(word => word.length > 0);
                        const count = words.length;
                        wordCountDisplay.textContent = `${count} words`;

                        if (count > 1000) {
                            wordCountDisplay.classList.add('text-red-500');
                            wordCountDisplay.classList.remove('text-gray-400');
                        } else {
                            wordCountDisplay.classList.remove('text-red-500');
                            wordCountDisplay.classList.add('text-gray-400');
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>

    @include('partials.footer')
</body>

</html>