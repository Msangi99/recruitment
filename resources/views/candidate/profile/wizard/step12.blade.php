@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-emerald-600 px-8 py-12 text-center text-white">
                <div
                    class="mb-4 inline-flex items-center justify-center h-20 w-20 rounded-full bg-white/20 backdrop-blur-sm">
                    <i data-lucide="check-circle-2" class="h-10 w-10 text-white"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2">Application Submitted!</h2>
                <p class="text-emerald-50 opacity-90">Thank you for completing your profile. Your information has been
                    submitted for review.</p>
            </div>

            <div class="p-8">
                <!-- Profile Completion -->
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-bold text-slate-700 uppercase tracking-wider">Profile Completion</span>
                        <span class="text-sm font-bold text-emerald-600">85% / 100%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3">
                        <div class="bg-emerald-500 h-3 rounded-full transition-all duration-1000" style="width: 85%"></div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500 italic text-center">Tip: Adding a video CV increases your chances
                        by 40%!</p>
                </div>

                <!-- Status Tracking -->
                <div class="mb-10">
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-6">Application Status</h3>

                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute left-[15px] top-0 h-full w-0.5 bg-slate-100"></div>

                        <div class="space-y-8">
                            <!-- Status: Under Review -->
                            <div class="relative flex items-start group">
                                <div
                                    class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full {{ $profile->verification_status == 'pending' ? 'bg-emerald-500 ring-4 ring-emerald-50' : 'bg-emerald-500' }} z-10 transition-all">
                                    <i data-lucide="clock" class="w-4 h-4 text-white"></i>
                                </div>
                                <div class="ml-12">
                                    <h4
                                        class="text-sm font-bold {{ $profile->verification_status == 'pending' ? 'text-emerald-700' : 'text-slate-900' }}">
                                        Under Review</h4>
                                    <p class="text-xs text-slate-500 mt-1">“Your profile is being reviewed by our
                                        recruitment team.”</p>
                                </div>
                            </div>

                            <!-- Status: Approved -->
                            <div class="relative flex items-start group">
                                <div
                                    class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full {{ $profile->isVerified() ? 'bg-emerald-500' : 'bg-slate-200' }} z-10">
                                    <i data-lucide="check" class="w-4 h-4 text-white"></i>
                                </div>
                                <div class="ml-12">
                                    <h4
                                        class="text-sm font-bold {{ $profile->isVerified() ? 'text-emerald-700' : 'text-slate-400' }}">
                                        Approved</h4>
                                    <p class="text-xs text-slate-400 mt-1">Verification of skills and documents completed.
                                    </p>
                                </div>
                            </div>

                            <!-- Status: Live -->
                            <div class="relative flex items-start group">
                                <div
                                    class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full {{ $profile->is_public ? 'bg-emerald-500 ring-4 ring-emerald-50' : 'bg-slate-200' }} z-10">
                                    <i data-lucide="globe" class="w-4 h-4 text-white"></i>
                                </div>
                                <div class="ml-12">
                                    <h4
                                        class="text-sm font-bold {{ $profile->is_public ? 'text-emerald-700' : 'text-slate-400' }}">
                                        Live</h4>
                                    <p class="text-xs text-slate-400 mt-1">Visible to Employers across the platform.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('candidate.dashboard') }}"
                        class="flex-1 inline-flex justify-center items-center rounded-xl bg-deep-green px-8 py-4 text-base font-bold text-white shadow-xl hover:bg-emerald-700 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-2"></i>
                        Go to Dashboard
                    </a>
                    <a href="{{ route('candidate.profile.show') }}"
                        class="flex-1 inline-flex justify-center items-center rounded-xl bg-white border-2 border-slate-200 px-8 py-4 text-base font-bold text-slate-700 hover:bg-slate-50 transition-all">
                        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                        View My Profile
                    </a>
                </div>
            </div>
        </div>

        <p class="mt-8 text-center text-sm text-slate-500 pb-12">
            Have questions? <a href="#" class="text-emerald-600 font-bold hover:underline">Contact Support</a>
        </p>
    </div>
@endsection