@extends('emails.layouts.base', [
    'tone' => 'dark',
    'title' => 'New Job Application',
    'preheader' => $application->candidate->name . ' applied for ' . $application->job->title . '.',
    'heroTitle' => 'New Application',
    'heroSubtitle' => 'A candidate has applied for a job listing',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Hello,</p>
    <p style="margin: 0 0 16px;">A new application requires your review.</p>

    @include('emails.partials.badge', ['text' => 'New Application', 'variant' => 'brand'])

    @include('emails.partials.card-open', ['title' => 'Candidate Details'])
        @include('emails.partials.row', ['label' => 'Candidate', 'value' => e($application->candidate->name)])
        @include('emails.partials.row', ['label' => 'Email', 'value' => '<a href="mailto:' . e($application->candidate->email) . '" style="color:#2563EB;text-decoration:none;font-weight:600;">' . e($application->candidate->email) . '</a>'])
        @include('emails.partials.row', ['label' => 'Job Title', 'value' => e($application->job->title)])
        @include('emails.partials.row', ['label' => 'Company', 'value' => e($application->job->company_name)])
        @include('emails.partials.row', ['label' => 'Applied On', 'value' => e($application->created_at->format('F d, Y \a\t h:i A'))])
    @include('emails.partials.card-close')

    @include('emails.partials.button', [
        'url' => url('/admin/jobs/' . $application->job_id),
        'label' => 'Review Application',
        'color' => '#2563EB',
    ])

    @include('emails.partials.signoff')
@endsection

@section('footer_note')
    Automated notification from the Coyzon recruitment platform.
@endsection
