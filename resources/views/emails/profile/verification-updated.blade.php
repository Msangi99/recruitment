@extends('emails.layouts.base', [
    'tone' => $profile->verification_status === 'approved' ? 'success' : 'danger',
    'title' => 'Profile ' . ucfirst($profile->verification_status),
    'preheader' => 'Your candidate profile verification status has been updated.',
    'heroTitle' => 'Profile ' . ucfirst($profile->verification_status),
    'heroSubtitle' => $profile->verification_status === 'approved'
        ? 'You can now apply for jobs on Coyzon'
        : 'Your profile requires updates before approval',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $profile->user->name }},</p>

    @if($profile->verification_status === 'approved')
        <p style="margin: 0 0 16px;">Great news! Your candidate profile has been verified and approved.</p>
        @include('emails.partials.badge', ['text' => 'Verified', 'variant' => 'success'])
        @include('emails.partials.callout', [
            'variant' => 'success',
            'title' => 'You are ready to apply',
            'body' => 'Your profile is now eligible for job applications. Browse open roles and submit your applications from your dashboard.',
        ])
        @include('emails.partials.button', [
            'url' => url('/candidate/jobs'),
            'label' => 'Browse Jobs',
            'color' => '#059669',
        ])
    @else
        <p style="margin: 0 0 16px;">Your candidate profile verification was not approved at this time.</p>
        @include('emails.partials.badge', ['text' => 'Not Approved', 'variant' => 'danger'])
        @if($reason)
            @include('emails.partials.callout', [
                'variant' => 'danger',
                'title' => 'Reason for rejection',
                'body' => e($reason),
            ])
        @endif
        @include('emails.partials.callout', [
            'variant' => 'info',
            'title' => 'Next steps',
            'body' => 'Please update your profile and documents, then submit again for review.',
        ])
        @include('emails.partials.button', [
            'url' => url('/candidate/profile'),
            'label' => 'Update Profile',
            'color' => '#4F46E5',
        ])
    @endif

    @include('emails.partials.signoff')
@endsection
