@extends('emails.layouts.base', [
    'tone' => in_array($application->status, ['rejected', 'withdrawn']) ? 'danger' : (in_array($application->status, ['shortlisted', 'interview', 'offered']) ? 'success' : 'brand'),
    'title' => 'Application Status Update',
    'preheader' => 'Your application for ' . $application->job->title . ' is now ' . ucfirst($application->status) . '.',
    'heroTitle' => 'Application Update',
    'heroSubtitle' => 'There is an update on your job application',
])

@section('content')
    @php
        $statusVariant = match ($application->status) {
            'rejected', 'withdrawn' => 'danger',
            'shortlisted', 'interview', 'offered' => 'success',
            default => 'brand',
        };
    @endphp
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $application->candidate->name }},</p>
    <p style="margin: 0 0 16px;">The status of your application has been updated.</p>

    @include('emails.partials.badge', ['text' => ucfirst($application->status), 'variant' => $statusVariant])

    @include('emails.partials.card-open', ['title' => 'Application Summary'])
        @include('emails.partials.row', ['label' => 'Job Title', 'value' => e($application->job->title)])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($application->job->company_name)])
        @include('emails.partials.row', ['label' => 'Previous Status', 'value' => e(ucfirst($previousStatus))])
        @include('emails.partials.row', ['label' => 'New Status', 'value' => '<strong>' . e(ucfirst($application->status)) . '</strong>'])
    @include('emails.partials.card-close')

    @if($application->status === 'rejected')
        @include('emails.partials.callout', [
            'variant' => 'info',
            'title' => 'Keep going',
            'body' => 'Thank you for applying. We encourage you to explore other opportunities on Coyzon.',
        ])
    @elseif(in_array($application->status, ['shortlisted', 'interview', 'offered']))
        @include('emails.partials.callout', [
            'variant' => 'success',
            'title' => 'Congratulations',
            'body' => 'You are progressing in the selection process. Please check your dashboard for next steps.',
        ])
    @endif

    @include('emails.partials.button', [
        'url' => url('/candidate/applications/' . $application->id),
        'label' => 'View Application',
        'color' => '#4F46E5',
    ])

    @include('emails.partials.signoff')
@endsection
