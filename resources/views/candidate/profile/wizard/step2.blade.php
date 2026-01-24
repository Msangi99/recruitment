@extends('candidate.profile.wizard.layout')

@section('wizard-content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Basic Personal Information</h2>
            <p class="mt-2 text-sm text-slate-600">Let's start with the basics. Where are you from and where do you live?
            </p>
        </div>

        <form action="{{ route('candidate.wizard.process', ['step' => 2]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Nationality -->
                <div>
                    <label for="citizenship" class="block text-sm font-medium text-slate-700">Nationality</label>
                    <div class="mt-1">
                        <input type="text" name="citizenship" id="citizenship"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                            value="{{ old('citizenship', $profile->citizenship) }}" placeholder="e.g. Tanzanian">
                    </div>
                    @error('citizenship')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-slate-700">Date of Birth</label>
                    <div class="mt-1">
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                            value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}">
                    </div>
                    @error('date_of_birth')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-slate-700">Country of Residence</label>
                    <div class="mt-1">
                        <input type="text" name="country" id="country"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                            value="{{ old('country', explode(',', $profile->location)[1] ?? '') }}"
                            placeholder="e.g. Tanzania">
                    </div>
                    @error('country')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-slate-700">City</label>
                    <div class="mt-1">
                        <input type="text" name="city" id="city"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                            value="{{ old('city', explode(',', $profile->location)[0] ?? '') }}"
                            placeholder="e.g. Dar es Salaam">
                    </div>
                    @error('city')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number (Read only from User) -->
                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-slate-700">Phone Number</label>
                    <div class="mt-1">
                        <input type="text" name="phone" id="phone" disabled
                            class="block w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 shadow-sm sm:text-sm"
                            value="{{ $user->phone }}">
                        <p class="mt-1 text-xs text-slate-500">Contact support to update your phone number.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-slate-200 mt-6">
                <button type="submit"
                    class="inline-flex justify-center rounded-lg border border-transparent bg-deep-green px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Save & Continue
                </button>
            </div>
        </form>
    </div>
@endsection