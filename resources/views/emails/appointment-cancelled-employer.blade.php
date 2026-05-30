@extends('emails.layouts.base', [
    'tone' => 'danger',
    'title' => 'Interview Request Cancelled',
    'preheader' => 'Your interview request has been cancelled.',
    'heroTitle' => 'Interview Cancelled',
    'heroSubtitle' => 'Your interview request could not be approved',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $employerName ?? 'Employer' }},</p>
    <p style="margin: 0 0 16px;">We regret to inform you that the following interview request has been cancelled.</p>

    @include('emails.partials.badge', ['text' => 'Cancelled', 'variant' => 'danger'])

    @include('emails.partials.card-open', ['title' => 'Interview Details'])
        @include('emails.partials.row', ['label' => 'Candidate', 'value' => e($candidateName)])
        @include('emails.partials.row', ['label' => 'Position', 'value' => e($jobTitle)])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($companyName)])
        @include('emails.partials.row', ['label' => 'Scheduled Date', 'value' => e($scheduledAt)])
    @include('emails.partials.card-close')

    @if(!empty($cancellationReason))
        @include('emails.partials.callout', [
            'variant' => 'danger',
            'title' => 'Reason for cancellation',
            'body' => e($cancellationReason),
        ])
    @endif

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'What you can do next',
        'body' => '<ul style="margin:0;padding-left:18px;"><li>Submit a new interview request for another candidate.</li><li>Browse candidates at <a href="' . url('/candidates') . '" style="color:#4F46E5;text-decoration:none;">' . url('/candidates') . '</a>.</li><li>Contact our HR team if you need clarification.</li></ul>',
    ])

    <p style="margin: 24px 0 0;">Contact: <a href="mailto:{{ $hrEmail ?? 'hr@coyzon.co.tz' }}" style="color:#4F46E5;text-decoration:none;font-weight:600;">{{ $hrEmail ?? 'hr@coyzon.co.tz' }}</a></p>

    @include('emails.partials.signoff')
@endsection
