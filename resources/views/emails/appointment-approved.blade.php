@extends('emails.layouts.base', [
    'tone' => 'success',
    'title' => 'Interview Request Approved',
    'preheader' => 'Your interview request for ' . ($candidateName ?? 'a candidate') . ' has been approved.',
    'heroTitle' => 'Interview Approved',
    'heroSubtitle' => 'Your interview request has been confirmed',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $employerName ?? 'Employer' }},</p>
    <p style="margin: 0 0 16px;">Great news! Your interview request has been reviewed and approved by our team.</p>

    @include('emails.partials.badge', ['text' => 'Approved', 'variant' => 'success'])

    @include('emails.partials.card-open', ['title' => 'Interview Details'])
        @include('emails.partials.row', ['label' => 'Candidate', 'value' => e($candidateName)])
        @include('emails.partials.row', ['label' => 'Position', 'value' => e($jobTitle)])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($companyName)])
        @include('emails.partials.row', ['label' => 'Date & Time', 'value' => '<strong>' . e($scheduledAt) . '</strong>'])
        @include('emails.partials.row', ['label' => 'Duration', 'value' => e($duration . ' minutes')])
        @include('emails.partials.row', ['label' => 'Meeting Mode', 'value' => e(ucfirst($meetingMode))])
        @if($meetingMode === 'online' && $meetingLink)
            @include('emails.partials.row', ['label' => 'Meeting Link', 'value' => '<a href="' . e($meetingLink) . '" style="color:#059669;font-weight:600;text-decoration:none;">Join meeting</a>'])
        @endif
        @if($meetingMode === 'in-person' && $meetingLocation)
            @include('emails.partials.row', ['label' => 'Location', 'value' => e($meetingLocation)])
        @endif
    @include('emails.partials.card-close')

    @include('emails.partials.callout', [
        'variant' => 'success',
        'title' => 'Next steps',
        'body' => '<ul style="margin:0;padding-left:18px;"><li>The candidate has been notified.</li><li>Please be available at the scheduled time.</li><li>Prepare your interview questions in advance.</li></ul>',
    ])

    <p style="margin: 24px 0 0;">Questions? Contact us at <a href="mailto:{{ $hrEmail ?? 'hr@coyzon.co.tz' }}" style="color:#4F46E5;text-decoration:none;font-weight:600;">{{ $hrEmail ?? 'hr@coyzon.co.tz' }}</a>.</p>

    @include('emails.partials.signoff')
@endsection
