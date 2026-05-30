@extends('emails.layouts.base', [
    'tone' => 'success',
    'title' => 'Application Received',
    'preheader' => 'We received your application for ' . $application->job->title . '.',
    'heroTitle' => 'Application Received',
    'heroSubtitle' => 'Thank you for applying through Coyzon',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $application->candidate->name }},</p>
    <p style="margin: 0 0 16px;">Thank you for your interest. We have successfully received your application.</p>

    @include('emails.partials.badge', ['text' => 'Pending Review', 'variant' => 'neutral'])

    @include('emails.partials.card-open', ['title' => 'Application Summary'])
        @include('emails.partials.row', ['label' => 'Job Title', 'value' => e($application->job->title)])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($application->job->company_name)])
        @include('emails.partials.row', ['label' => 'Location', 'value' => e($application->job->location . ', ' . $application->job->country)])
        @include('emails.partials.row', ['label' => 'Submitted', 'value' => e($application->created_at->format('F d, Y \a\t h:i A'))])
    @include('emails.partials.card-close')

    @include('emails.partials.button', [
        'url' => url('/candidate/applications'),
        'label' => 'Track Application',
        'color' => '#059669',
    ])

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'What happens next?',
        'body' => 'Our team or the employer will review your application and update you when there is progress.',
    ])

    @include('emails.partials.signoff')
@endsection
