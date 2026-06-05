@extends('emails.layouts.base', [
    'tone' => 'brand',
    'title' => 'Reply from ' . config('app.name'),
    'preheader' => 'We have responded to your inquiry.',
    'heroTitle' => 'Message from Coyzon Company limited',
    'heroSubtitle' => '',
    'hideHeaderBrand' => true,
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $recipientName }},</p>
    <p style="margin: 0 0 24px;">Thank you for reaching out to Coyzon. We appreciate your inquiry and are pleased to provide our response below.</p>

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'Official Response',
        'body' => nl2br(e($replyMessage)),
    ])

    @include('emails.partials.card-open', ['title' => 'Your Original Message'])
        @include('emails.partials.row', ['label' => 'Subject', 'value' => e($originalSubject)])
        @include('emails.partials.row', ['label' => 'Message', 'value' => nl2br(e($originalMessage))])
    @include('emails.partials.card-close')

    <p style="margin: 24px 0 0;">Should you require any additional information or assistance, please feel free to reply to this email. Our team will be happy to assist you.</p>

    @include('emails.partials.signoff')
@endsection
