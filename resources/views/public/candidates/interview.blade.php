<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Candidate: {{ $candidate->name }} - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-green': '#105e46',
                        'deep-blue': '#0a2540',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .step-gradient {
            background: linear-gradient(135deg, #105e46 0%, #0a2540 100%);
        }

        .input-focus {
            transition: all 0.2s ease;
        }

        .input-focus:focus {
            border-color: #105e46;
            box-shadow: 0 0 0 4px rgba(16, 94, 70, 0.1);
        }

        .read-only-bg {
            background-color: #f9fafb;
        }

        .tooltip {
            visibility: hidden;
            position: absolute;
            z-index: 50;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            transition: opacity 0.3s;
        }

        .has-tooltip:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
        
        /* Radio button focus styles */
        input[type="radio"]:focus + label {
            outline: 2px solid #059669;
            outline-offset: 2px;
        }

        input[type="radio"]:active + label {
            transform: scale(0.98);
        }
    </style>
</head>

<body class="bg-gray-50/50">
    @include('partials.public-nav')

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Navigation Back -->
        <div class="mb-8">
            <a href="{{ route('public.candidates.show', $candidate) }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-deep-green transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Candidate Profile
            </a>
        </div>

        @if(session('success'))
            <div
                class="mb-8 p-6 bg-white rounded-2xl shadow-sm border border-emerald-100 flex items-start gap-4 animate-in fade-in duration-500">
                <div class="p-2 bg-emerald-100 rounded-full text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Request Submitted Successfully!</h3>
                    <p class="text-gray-600 mt-1">Thank you for your request. Our team will review it and contact you within
                        24 hours.</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-6 step-gradient text-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">Request Candidate: {{ $candidate->name }}
                        </h1>
                        <p class="mt-1 text-emerald-100 text-sm opacity-90">No registration needed. Complete details below.</p>
                    </div>
                    <!-- Candidate Quick View -->
                    <div
                        class="flex items-center gap-3 bg-white/10 p-3 rounded-xl backdrop-blur-sm border border-white/20 min-w-fit">
                        @if($candidate->candidateProfile->profile_picture)
                            <img src="{{ asset($candidate->candidateProfile->profile_picture) }}"
                                alt="{{ $candidate->name }}"
                                class="w-10 h-10 rounded-lg flex-shrink-0 object-cover border-2 border-white/30 shadow-md">
                        @else
                            <div
                                class="w-10 h-10 rounded-lg flex-shrink-0 bg-deep-green flex items-center justify-center text-sm font-bold border-2 border-white/30 shadow-md">
                                {{ strtoupper(substr($candidate->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex flex-col justify-center">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-200 whitespace-nowrap">Candidate ID</p>
                            <p class="text-sm font-mono font-bold whitespace-nowrap">#{{ str_pad($candidate->id, 7, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('public.candidates.interview.store', $candidate) }}"
                class="p-6 md:p-8" id="request-form">
                @csrf

                <div class="space-y-6">
                    <!-- Step 1: Candidate Info (Auto-Filled) -->
                    <section class="relative">
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="flex-shrink-0 w-6 h-6 text-sm rounded-full bg-deep-green text-white flex items-center justify-center font-bold">1</span>
                            <h2 class="text-base font-bold text-gray-900">Candidate Info (Auto-Filled)</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-9">
                            <div class="has-tooltip relative">
                                <span
                                    class="tooltip bg-gray-900 text-white text-xs py-1 px-3 rounded-lg opacity-0 transition-opacity">Candidate
                                    info is auto-filled from profile</span>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Candidate Name</label>
                                <input type="text" value="{{ $candidate->name }}" readonly
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 read-only-bg text-gray-500 font-medium focus:outline-none cursor-not-allowed">
                            </div>
                            <div class="has-tooltip relative">
                                <span
                                    class="tooltip bg-gray-900 text-white text-xs py-1 px-3 rounded-lg opacity-0 transition-opacity">Candidate
                                    info is auto-filled from profile</span>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Profile ID</label>
                                <input type="text" value="{{ str_pad($candidate->id, 7, '0', STR_PAD_LEFT) }}" readonly
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 read-only-bg text-gray-500 font-medium font-mono focus:outline-none cursor-not-allowed">
                            </div>
                        </div>
                    </section>

                    <!-- Step 2: Request Type -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="flex-shrink-0 w-6 h-6 text-sm rounded-full bg-deep-green text-white flex items-center justify-center font-bold">2</span>
                            <h2 class="text-base font-bold text-gray-900">Request Type</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-9">
                            <!-- Interview Option -->
                            <div class="relative">
                                <input type="radio" id="type_interview" name="appointment_type" value="interview"
                                    class="peer sr-only" 
                                    @if(old('appointment_type', 'interview') == 'interview') checked @endif
                                    required>
                                <label for="type_interview"
                                    class="flex items-center p-3 cursor-pointer rounded-xl border-2 border-gray-100 transition-all peer-checked:border-deep-green peer-checked:bg-emerald-50/50 hover:border-gray-200 hover:shadow-md h-full">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-deep-green shadow-sm border border-gray-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm">Interview</p>
                                            <p class="text-xs text-gray-500">Schedule one-on-one</p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <div
                                            class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-deep-green flex items-center justify-center">
                                            <div
                                                class="w-2 h-2 rounded-full bg-deep-green hidden peer-checked:block">
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Placement Option -->
                            <div class="relative">
                                <input type="radio" id="type_placement" name="appointment_type" value="placement"
                                    class="peer sr-only" 
                                    @if(old('appointment_type', 'interview') == 'placement') checked @endif
                                    required>
                                <label for="type_placement"
                                    class="flex items-center p-3 cursor-pointer rounded-xl border-2 border-gray-100 transition-all peer-checked:border-deep-green peer-checked:bg-emerald-50/50 hover:border-gray-200 hover:shadow-md h-full">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-deep-green shadow-sm border border-gray-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm">Placement / Hire</p>
                                            <p class="text-xs text-gray-500">Start onboarding</p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <div
                                            class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-deep-green flex items-center justify-center">
                                            <div
                                                class="w-2 h-2 rounded-full bg-deep-green hidden peer-checked:block">
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('appointment_type')
                            <p class="mt-2 text-xs text-red-600 ml-9">{{ $message }}</p>
                        @enderror
                    </section>

                    <!-- Step 3: Employer Details -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="flex-shrink-0 w-6 h-6 text-sm rounded-full bg-deep-green text-white flex items-center justify-center font-bold">3</span>
                            <h2 class="text-base font-bold text-gray-900">Employer Details</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-9">
                            <div>
                                <label for="company_name" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Company
                                    Name *</label>
                                <input type="text" id="company_name" name="company_name"
                                    value="{{ old('company_name') }}" required placeholder="Enter company name"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 input-focus @error('company_name') border-red-300 @enderror">
                                @error('company_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="job_title" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Contact Person
                                    *</label>
                                <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}"
                                    required placeholder="Full name of contact person"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 input-focus @error('job_title') border-red-300 @enderror">
                                @error('job_title')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="interviewer_email" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Email
                                    *</label>
                                <input type="email" id="interviewer_email" name="interviewer_email"
                                    value="{{ old('interviewer_email') }}" required placeholder="your.email@company.com"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 input-focus @error('interviewer_email') border-red-300 @enderror">
                                @error('interviewer_email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="interviewer_phone" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Phone
                                    *</label>
                                <input type="tel" id="interviewer_phone" name="interviewer_phone"
                                    value="{{ old('interviewer_phone') }}" required placeholder="+255 XXX XXX XXX"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 input-focus @error('interviewer_phone') border-red-300 @enderror">
                                @error('interviewer_phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Step 4: Request Details -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="flex-shrink-0 w-6 h-6 text-sm rounded-full bg-deep-green text-white flex items-center justify-center font-bold">4</span>
                            <h2 class="text-base font-bold text-gray-900">Request Details</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-9">
                            <div>
                                <label for="scheduled_at" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Preferred
                                    Date & Time *</label>
                                <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                                    value="{{ old('scheduled_at') }}" required min="{{ date('Y-m-d\TH:i') }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 input-focus @error('scheduled_at') border-red-300 @enderror">
                                @error('scheduled_at')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="title" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Job Role /
                                    Position *</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                    placeholder="e.g. Sales Executive, Driver, etc."
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 input-focus @error('title') border-red-300 @enderror">
                                @error('title')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Additional Notes
                                    (Optional)</label>
                                <div class="rounded-lg border border-gray-200 overflow-hidden">
                                    <textarea id="notes" name="notes" rows="4"
                                        placeholder="Any other specific requirements or details about the request..."
                                        class="w-full input-focus text-sm @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                                </div>
                                @error('notes')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Step 5: Submit -->
                    <section class="pt-4">
                        <div class="pl-9">
                            <button type="submit"
                                class="w-full md:w-auto px-8 py-2.5 bg-deep-green hover:bg-emerald-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-900/10 transition-all hover:-translate-y-1 active:scale-[0.98] tracking-wide">
                                Submit Request
                            </button>
                            <p class="mt-3 text-xs text-gray-500 text-center md:text-left">
                                By submitting, you agree to our <a href="{{ route('terms') }}"
                                    class="text-deep-green underline decoration-emerald-200 underline-offset-4">Terms
                                    and Conditions</a>.
                            </p>
                        </div>
                    </section>
                </div>
            </form>
        </div>

        <!-- Support Info -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">Need help? Contact our support team at <a href="mailto:support@coyzon.com"
                    class="text-deep-green font-bold">support@coyzon.com</a> or call <span
                    class="text-deep-green font-bold">+255 (0) 123 456 789</span></p>
        </div>
    </div>

    @include('partials.footer')

    <script>
        ClassicEditor
            .create(document.querySelector('#notes'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            })
            .catch(error => {
                console.error(error);
            });
            
        // Ensure radio buttons work properly and add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="appointment_type"]');
            const form = document.getElementById('request-form');
            
            // Add click logging for debugging
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    console.log('Selected appointment type:', this.value);
                    // You could add conditional logic here based on selection
                    if (this.value === 'placement') {
                        // Example: Change placeholder text based on selection
                        const jobTitleInput = document.getElementById('title');
                        if (jobTitleInput) {
                            jobTitleInput.placeholder = "e.g. Full-time Sales Executive, Permanent Driver, etc.";
                        }
                    } else if (this.value === 'interview') {
                        const jobTitleInput = document.getElementById('title');
                        if (jobTitleInput) {
                            jobTitleInput.placeholder = "e.g. Sales Executive, Driver, etc.";
                        }
                    }
                });
            });
            
            // Form validation before submit
            form.addEventListener('submit', function(e) {
                const selectedRadio = document.querySelector('input[name="appointment_type"]:checked');
                if (!selectedRadio) {
                    e.preventDefault();
                    alert('Please select a request type (Interview or Placement)');
                    return false;
                }
                
                // Additional validation if needed
                const dateInput = document.getElementById('scheduled_at');
                if (dateInput && new Date(dateInput.value) < new Date()) {
                    e.preventDefault();
                    alert('Please select a future date and time');
                    dateInput.focus();
                    return false;
                }
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = 'Submitting...';
                    submitBtn.disabled = true;
                }
            });
        });
    </script>
    <style>
        .ck-editor__editable {
            min-height: 120px;
            border-radius: 0 0 8px 8px !important;
        }

        .ck-toolbar {
            border-radius: 8px 8px 0 0 !important;
            border-color: #e5e7eb !important;
        }

        .ck-content {
            border-color: #e5e7eb !important;
            font-size: 0.875rem !important;
        }

        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #e5e7eb !important;
        }

        .ck.ck-editor__main>.ck-editor__editable.ck-focused {
            border-color: #105e46 !important;
            box-shadow: 0 0 0 4px rgba(16, 94, 70, 0.1) !important;
        }
        
        /* Ensure radio button labels are fully clickable */
        .relative input[type="radio"] + label {
            cursor: pointer;
            user-select: none;
        }
        
        /* Smooth transitions for radio button states */
        .peer-checked\:border-deep-green {
            transition: border-color 0.2s ease;
        }
        
        .peer-checked\:bg-emerald-50\/50 {
            transition: background-color 0.2s ease;
        }
    </style>
</body>

</html>