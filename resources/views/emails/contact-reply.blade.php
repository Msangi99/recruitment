@extends('emails.layouts.base', [
    'tone' => 'brand',
    'title' => 'Reply from ' . config('app.name'),
    'preheader' => 'We have responded to your inquiry.',
    'heroTitle' => 'Message from Coyzon',
    'heroSubtitle' => 'Thank you for reaching out to us',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $recipientName }},</p>
    <p style="margin: 0 0 24px;">Thank you for contacting us. Please find our response below.</p>

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'Our Reply',
        'body' => nl2br(e($replyMessage)),
    ])

    @include('emails.partials.card-open', ['title' => 'Your Original Message'])
        @include('emails.partials.row', ['label' => 'Subject', 'value' => e($originalSubject)])
        @include('emails.partials.row', ['label' => 'Message', 'value' => nl2br(e($originalMessage))])
    @include('emails.partials.card-close')

    <p style="margin: 24px 0 0;">If you have any further questions, feel free to reply to this email.</p>

    @include('emails.partials.signoff')
@endsection
