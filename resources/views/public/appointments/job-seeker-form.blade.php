@extends('layouts.app')

@section('title', 'Consultation Form - Coyzon')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('public.appointments.jobSeeker') }}" class="text-blue-600 hover:text-blue-800 font-bold flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Details
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-slate-900 px-8 py-6 border-b border-slate-800">
                <h1 class="text-2xl font-bold text-white">Career & Overseas Work Consultation</h1>
                <p class="text-slate-400 mt-2">Complete this form to book your paid consultation session.</p>
            </div>
            
            <form action="{{ route('public.appointments.jobSeeker.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
                @csrf
                
                <!-- A. Personal Information -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">A. Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone / WhatsApp Number</label>
                            <input type="text" name="phone" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                            <input type="text" name="nationality" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Country of Residence</label>
                            <input type="text" name="residence" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                        </div>
                    </div>
                </div>

                <!-- B. Work Background -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">B. Work Background</h2>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Job Title / Occupation</label>
                                <input type="text" name="job_title" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Main Skills / Field of Experience</label>
                                <input type="text" name="skills" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Years of Work Experience</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="experience_years" value="0-1" required class="form-radio text-blue-600">
                                    <span class="ml-2">0–1 year</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="experience_years" value="2-4" class="form-radio text-blue-600">
                                    <span class="ml-2">2–4 years</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="experience_years" value="5+" class="form-radio text-blue-600">
                                    <span class="ml-2">5+ years</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Highest Level of Education</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(['Secondary', 'Certificate', 'Diploma', 'Bachelor', 'Master+'] as $edu)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="education" value="{{ $edu }}" required class="form-radio text-blue-600">
                                    <span class="ml-2">{{ $edu }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- C. Overseas Work Goals -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">C. Overseas Work Goals</h2>
                    <div class="space-y-6">
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Country / Region</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(['Canada', 'Europe', 'Middle East', 'Any suitable option'] as $region)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="preferred_region" value="{{ $region }}" required class="form-radio text-blue-600">
                                    <span class="ml-2">{{ $region }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Job Type / Sector</label>
                            <input type="text" name="preferred_job_type" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Briefly explain your goal for working abroad</label>
                            <textarea name="goal_description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border"></textarea>
                        </div>
                    </div>
                </div>

                <!-- D. Eligibility Information -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">D. Eligibility Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Do you have a valid passport?</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center"><input type="radio" name="has_passport" value="Yes" required class="form-radio text-blue-600"><span class="ml-2">Yes</span></label>
                                <label class="inline-flex items-center"><input type="radio" name="has_passport" value="No" class="form-radio text-blue-600"><span class="ml-2">No</span></label>
                                <label class="inline-flex items-center"><input type="radio" name="has_passport" value="In process" class="form-radio text-blue-600"><span class="ml-2">In process</span></label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Have you ever applied for a visa before?</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center"><input type="radio" name="visa_history" value="Yes" required class="form-radio text-blue-600"><span class="ml-2">Yes</span></label>
                                <label class="inline-flex items-center"><input type="radio" name="visa_history" value="No" class="form-radio text-blue-600"><span class="ml-2">No</span></label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">English Proficiency Level</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center"><input type="radio" name="english_level" value="Basic" required class="form-radio text-blue-600"><span class="ml-2">Basic</span></label>
                                <label class="inline-flex items-center"><input type="radio" name="english_level" value="Intermediate" class="form-radio text-blue-600"><span class="ml-2">Intermediate</span></label>
                                <label class="inline-flex items-center"><input type="radio" name="english_level" value="Advanced" class="form-radio text-blue-600"><span class="ml-2">Advanced</span></label>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- E. Services Required -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">E. Services Required</h2>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Which services do you need? (Select all that apply)</label>
                    <div class="space-y-2">
                        @foreach([
                            'Overseas career & country suitability consultation',
                            'Job options assessment based on my profile',
                            'CV review & professional optimization',
                            'Job board guidance & profile optimization'
                        ] as $service)
                        <label class="flex items-center">
                            <input type="checkbox" name="services[]" value="{{ $service }}" class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300">
                            <span class="ml-3 text-gray-700">{{ $service }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- F. Document Upload -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">F. Document Upload (Optional)</h2>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload your CV (PDF / DOC)</label>
                    <input type="file" name="cv_file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100 mb-2
                    ">
                    <p class="text-xs text-gray-500">Other documents can be shared during the consultation.</p>
                </div>

                <!-- H. Payment -->
                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                    <h2 class="text-xl font-bold text-blue-900 mb-4">Payment Selection</h2>
                    <p class="mb-4 text-blue-800">Consultation Fee: <span class="font-bold">TZS 30,000 / $12</span></p>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Payment Gateway *</label>
                        <select name="payment_gateway" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm p-3 border">
                            <option value="">Choose Payment Method</option>
                            <option value="selcom">Selcom (M-Pesa, Tigo Pesa, Airtel, HaloPesa, Card)</option>
                            <option value="azampay">AzamPay (M-Pesa, Tigo Pesa, Airtel, AzamPesa, Bank)</option>
                        </select>
                    </div>

                    <label class="flex items-start mt-4">
                        <input type="checkbox" required class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 mt-1">
                        <span class="ml-3 text-sm text-gray-700">
                            I understand that this is a paid career consultation service and does not guarantee employment, job placement, or visa approval.
                        </span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-lg font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        Pay & Book Consultation
                    </button>
                    <p class="mt-4 text-center text-sm text-gray-500">
                        You will be redirected to the secure payment page.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
