@extends('layouts.app')

@section('title', 'Book Consultation - Candidate')

@section('content')
<div class="min-h-screen bg-gray-50">
    @include('candidate.partials.nav')

    <div class="lg:ml-64 pt-16 lg:pt-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('candidate.consultations.index') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Consultations</a>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Book Career Consultation</h2>
                <p class="mt-1 text-sm text-gray-500">Schedule a paid consultation with our career advisors (TZS 30,000 or $12)</p>
            </div>

            <form method="POST" action="{{ route('candidate.consultations.store') }}" class="bg-white shadow-lg rounded-lg p-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="meeting_mode" class="block text-sm font-medium text-gray-700 mb-2">Meeting Mode *</label>
                        <select id="meeting_mode" name="meeting_mode" required 
                                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('meeting_mode') border-red-300 @enderror">
                            <option value="">Select Mode</option>
                            <option value="online" {{ old('meeting_mode') == 'online' ? 'selected' : '' }}>Online (Zoom/Google Meet)</option>
                            <option value="in-person" {{ old('meeting_mode') == 'in-person' ? 'selected' : '' }}>In-Person</option>
                        </select>
                        @error('meeting_mode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Preferred Date & Time *</label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" required min="{{ date('Y-m-d\TH:i') }}" 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('scheduled_at') border-red-300 @enderror">
                        @error('scheduled_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes) *</label>
                        <select id="duration_minutes" name="duration_minutes" required 
                                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('duration_minutes') border-red-300 @enderror">
                            <option value="30" {{ old('duration_minutes') == '30' ? 'selected' : '' }}>30 minutes</option>
                            <option value="45" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                            <option value="60" {{ old('duration_minutes') == '60' ? 'selected' : '' }}>1 hour</option>
                        </select>
                        @error('duration_minutes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="meeting_link_field" style="display: none;">
                        <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">Meeting Link (if available)</label>
                        <input type="url" id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/..." 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('meeting_link') border-red-300 @enderror">
                        @error('meeting_link')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="meeting_location_field" style="display: none;">
                        <label for="meeting_location" class="block text-sm font-medium text-gray-700 mb-2">Preferred Location</label>
                        <input type="text" id="meeting_location" name="meeting_location" value="{{ old('meeting_location') }}" placeholder="Office address..." 
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('meeting_location') border-red-300 @enderror">
                        @error('meeting_location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="What would you like to discuss?" 
                                  class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-indigo-50 border border-indigo-200 rounded-md p-4">
                        <p class="text-sm text-indigo-800">
                            <strong>Payment Required:</strong> This consultation costs TZS 30,000 (or $12). You will be redirected to payment after submitting this form.
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('candidate.consultations.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Proceed to Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('meeting_mode').addEventListener('change', function() {
    const meetingLinkField = document.getElementById('meeting_link_field');
    const meetingLocationField = document.getElementById('meeting_location_field');
    
    if (this.value === 'online') {
        meetingLinkField.style.display = 'block';
        meetingLocationField.style.display = 'none';
    } else if (this.value === 'in-person') {
        meetingLinkField.style.display = 'none';
        meetingLocationField.style.display = 'block';
    } else {
        meetingLinkField.style.display = 'none';
        meetingLocationField.style.display = 'none';
    }
});

if (document.getElementById('meeting_mode').value) {
    document.getElementById('meeting_mode').dispatchEvent(new Event('change'));
}
</script>
        </div>
    </div>
    </div>
</div>
@endsection