@extends('emails.layouts.base', [
    'tone' => 'success',
    'title' => 'Interview Scheduled',
    'preheader' => 'Your interview with ' . ($companyName ?? 'an employer') . ' has been confirmed.',
    'heroTitle' => 'Interview Scheduled',
    'heroSubtitle' => 'An employer would like to interview you',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $candidateName }},</p>
    <p style="margin: 0 0 16px;">Congratulations! An employer is interested in interviewing you and your session has been confirmed.</p>

    @include('emails.partials.badge', ['text' => 'Confirmed', 'variant' => 'success'])

    @include('emails.partials.card-open', ['title' => 'Interview Details'])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($companyName)])
        @include('emails.partials.row', ['label' => 'Position', 'value' => e($jobTitle)])
        @include('emails.partials.row', ['label' => 'Date & Time', 'value' => '<strong>' . e($scheduledAt) . '</strong>'])
        @include('emails.partials.row', ['label' => 'Duration', 'value' => e($duration . ' minutes')])
        @include('emails.partials.row', ['label' => 'Interview Type', 'value' => e(ucfirst($meetingMode))])
        @if($meetingMode === 'online' && $meetingLink)
            @include('emails.partials.row', ['label' => 'Meeting Link', 'value' => '<a href="' . e($meetingLink) . '" style="color:#059669;font-weight:600;text-decoration:none;">Join meeting</a>'])
        @endif
        @if($meetingMode === 'in-person' && $meetingLocation)
            @include('emails.partials.row', ['label' => 'Location', 'value' => e($meetingLocation)])
        @endif
        @if(!empty($requirements))
            @include('emails.partials.row', ['label' => 'Requirements', 'value' => e($requirements)])
        @endif
        @if(!empty($notes))
            @include('emails.partials.row', ['label' => 'Notes', 'value' => e($notes)])
        @endif
    @include('emails.partials.card-close')

    @include('emails.partials.button', [
        'url' => url('/candidate/dashboard'),
        'label' => 'View in Dashboard',
        'color' => '#4F46E5',
    ])

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'Interview tips',
        'body' => '<ul style="margin:0;padding-left:18px;"><li>Arrive or log in 5–10 minutes early.</li><li>Dress professionally and prepare thoughtful questions.</li><li>Keep your documents ready if requested.</li>' . ($meetingMode === 'online' ? '<li>Test your camera and microphone beforehand.</li>' : '') . '</ul>',
    ])

    <p style="margin: 24px 0 0;">Good luck with your interview!</p>

    @include('emails.partials.signoff')
@endsection
