@extends('emails.layouts.base', [
    'tone' => 'danger',
    'title' => 'Interview Cancelled',
    'preheader' => 'Your scheduled interview has been cancelled.',
    'heroTitle' => 'Interview Cancelled',
    'heroSubtitle' => 'Your scheduled interview will no longer take place',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $candidateName }},</p>
    <p style="margin: 0 0 16px;">We regret to inform you that your scheduled interview has been cancelled.</p>

    @include('emails.partials.badge', ['text' => 'Cancelled', 'variant' => 'danger'])

    @include('emails.partials.card-open', ['title' => 'Interview Details'])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($companyName)])
        @include('emails.partials.row', ['label' => 'Position', 'value' => e($jobTitle)])
        @include('emails.partials.row', ['label' => 'Scheduled Date', 'value' => e($scheduledAt)])
    @include('emails.partials.card-close')

    @if(!empty($cancellationReason))
        @include('emails.partials.callout', [
            'variant' => 'danger',
            'title' => 'Reason',
            'body' => e($cancellationReason),
        ])
    @endif

    <p style="margin: 24px 0 0;">If you have questions, contact us at <a href="mailto:{{ $hrEmail ?? 'hr@coyzon.co.tz' }}" style="color:#4F46E5;text-decoration:none;font-weight:600;">{{ $hrEmail ?? 'hr@coyzon.co.tz' }}</a>.</p>

    @include('emails.partials.signoff')
@endsection
