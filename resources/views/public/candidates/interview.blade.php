<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Interview with {{ $candidate->name }} - Coyzon Recruitment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Coyzon Logo" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">Coyzon</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('public.jobs.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Find Job</a>
                    <a href="{{ route('public.candidates.index') }}" class="text-blue-600 font-medium">Book Appointment</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 font-medium">Contact Us</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('public.candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900">← Back to Candidate Profile</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Request Interview with {{ $candidate->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">No registration required. Fill out the form below and our team will process your request.</p>
            </div>

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('public.candidates.interview.store', $candidate) }}" class="bg-white shadow-lg rounded-lg overflow-hidden">
                @csrf

                <!-- Form Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <h3 class="text-xl font-semibold text-white">Interview Request Form</h3>
                    <p class="text-green-100 text-sm mt-1">Please fill out all required fields marked with *</p>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Interview Details Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Interview Details</h4>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Position / Interview Title *
                                    <span class="text-gray-500 font-normal">(e.g., "Construction Worker Interview")</span>
                                </label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                                       placeholder="Enter the position or interview title" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('title') border-red-300 @enderror">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Preferred Interview Date & Time *</label>
                                    <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" required min="{{ date('Y-m-d\TH:i') }}" 
                                           class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('scheduled_at') border-red-300 @enderror">
                                    @error('scheduled_at')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">Duration *</label>
                                    <select id="duration_minutes" name="duration_minutes" required 
                                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('duration_minutes') border-red-300 @enderror">
                                        <option value="30" {{ old('duration_minutes', 60) == '30' ? 'selected' : '' }}>30 minutes</option>
                                        <option value="45" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                                        <option value="60" {{ old('duration_minutes', 60) == '60' ? 'selected' : '' }}>1 hour</option>
                                        <option value="90" {{ old('duration_minutes') == '90' ? 'selected' : '' }}>1.5 hours</option>
                                        <option value="120" {{ old('duration_minutes') == '120' ? 'selected' : '' }}>2 hours</option>
                                    </select>
                                    @error('duration_minutes')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company/Employer Details Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Your Company & Contact Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required 
                                       placeholder="Your company name" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('company_name') border-red-300 @enderror">
                                @error('company_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Your Job Title *
                                    <span class="text-gray-500 font-normal">(Your position)</span>
                                </label>
                                <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}" required 
                                       placeholder="e.g., HR Manager, Operations Manager" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('job_title') border-red-300 @enderror">
                                @error('job_title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="interviewer_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email *</label>
                                <input type="email" id="interviewer_email" name="interviewer_email" value="{{ old('interviewer_email') }}" required 
                                       placeholder="your.email@company.com" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('interviewer_email') border-red-300 @enderror">
                                @error('interviewer_email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="interviewer_phone" class="block text-sm font-medium text-gray-700 mb-2">Contact Phone (Optional)</label>
                                <input type="tel" id="interviewer_phone" name="interviewer_phone" value="{{ old('interviewer_phone') }}" 
                                       placeholder="+255 XXX XXX XXX" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('interviewer_phone') border-red-300 @enderror">
                                @error('interviewer_phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Meeting Method Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Meeting Method</h4>
                        <div class="space-y-6">
                            <div>
                                <label for="meeting_mode" class="block text-sm font-medium text-gray-700 mb-2">Interview Method *</label>
                                <select id="meeting_mode" name="meeting_mode" required 
                                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('meeting_mode') border-red-300 @enderror">
                                    <option value="">Select Interview Method</option>
                                    <option value="online" {{ old('meeting_mode') == 'online' ? 'selected' : '' }}>Online (Zoom/Google Meet/Microsoft Teams)</option>
                                    <option value="in-person" {{ old('meeting_mode') == 'in-person' ? 'selected' : '' }}>In-Person Meeting</option>
                                </select>
                                @error('meeting_mode')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="meeting_link_field" style="display: none;">
                                <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">
                                    Online Meeting Link *
                                </label>
                                <input type="url" id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}" 
                                       placeholder="https://zoom.us/j/123456789 or https://meet.google.com/xyz" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('meeting_link') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Provide a Zoom, Google Meet, or Microsoft Teams link</p>
                                @error('meeting_link')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="meeting_location_field" style="display: none;">
                                <label for="meeting_location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Meeting Location *
                                </label>
                                <input type="text" id="meeting_location" name="meeting_location" value="{{ old('meeting_location') }}" 
                                       placeholder="Full office address with floor/room number" 
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('meeting_location') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Include full address with city, building name, floor, and room number</p>
                                @error('meeting_location')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h4>
                        <div class="space-y-6">
                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">
                                    What should the candidate prepare? (Optional)
                                </label>
                                <textarea id="requirements" name="requirements" rows="4" 
                                          placeholder="Example: Please bring copies of your certificates, be ready to discuss your work experience..."
                                          class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('requirements') border-red-300 @enderror">{{ old('requirements') }}</textarea>
                                @error('requirements')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" 
                                          placeholder="Any other information about the interview process..." 
                                          class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Important Notice -->
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">What happens next?</h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>This interview request is <strong>free of charge</strong></li>
                                        <li>Our admin team will <strong>review your request</strong> within 24-48 hours</li>
                                        <li>You will be <strong>notified via email</strong> once approved</li>
                                        <li>The candidate will then receive the interview invitation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('public.candidates.show', $candidate) }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                            Submit Interview Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
    document.getElementById('meeting_mode').addEventListener('change', function() {
        const meetingLinkField = document.getElementById('meeting_link_field');
        const meetingLocationField = document.getElementById('meeting_location_field');
        
        if (this.value === 'online') {
            meetingLinkField.style.display = 'block';
            meetingLocationField.style.display = 'none';
            meetingLinkField.querySelector('input').required = true;
            meetingLocationField.querySelector('input').required = false;
        } else if (this.value === 'in-person') {
            meetingLinkField.style.display = 'none';
            meetingLocationField.style.display = 'block';
            meetingLinkField.querySelector('input').required = false;
            meetingLocationField.querySelector('input').required = true;
        } else {
            meetingLinkField.style.display = 'none';
            meetingLocationField.style.display = 'none';
            meetingLinkField.querySelector('input').required = false;
            meetingLocationField.querySelector('input').required = false;
        }
    });

    // Trigger on page load if value is already set
    if (document.getElementById('meeting_mode').value) {
        document.getElementById('meeting_mode').dispatchEvent(new Event('change'));
    }
    </script>
</body>
</html>
