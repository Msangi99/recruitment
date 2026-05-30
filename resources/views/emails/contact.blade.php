@extends('emails.layouts.base', [
    'tone' => 'dark',
    'title' => 'New Contact Form Submission',
    'preheader' => 'New message from ' . $name . ': ' . $subject,
    'heroTitle' => 'New Contact Message',
    'heroSubtitle' => 'A visitor submitted the contact form on your website',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Hello team,</p>
    <p style="margin: 0 0 24px;">You have received a new inquiry through the contact form. Details are below.</p>

    @include('emails.partials.card-open', ['title' => 'Contact Details'])
        @include('emails.partials.row', ['label' => 'Name', 'value' => e($name)])
        @include('emails.partials.row', ['label' => 'Email', 'value' => '<a href="mailto:' . e($email) . '" style="color:#4F46E5;text-decoration:none;font-weight:600;">' . e($email) . '</a>'])
        @if(!empty($phone))
            @include('emails.partials.row', ['label' => 'Phone', 'value' => e($phone)])
        @endif
        @include('emails.partials.row', ['label' => 'Subject', 'value' => e($subject)])
    @include('emails.partials.card-close')

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'Message',
        'body' => nl2br(e($contactBody)),
    ])

    @include('emails.partials.button', [
        'url' => 'mailto:' . $email,
        'label' => 'Reply to ' . $name,
        'color' => '#4F46E5',
    ])
@endsection

@section('footer_note')
    Received via the contact form on {{ date('F d, Y \a\t h:i A') }}.
@endsection
