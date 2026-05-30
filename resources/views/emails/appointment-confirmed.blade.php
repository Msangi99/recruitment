@extends('emails.layouts.base', [
    'tone' => 'success',
    'title' => 'Appointment Confirmed',
    'preheader' => 'Your appointment on ' . $appointment->scheduled_at->format('M d, Y') . ' is confirmed.',
    'heroTitle' => 'Appointment Confirmed',
    'heroSubtitle' => 'Payment received successfully',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $user->name }},</p>
    <p style="margin: 0 0 24px;">Your appointment has been confirmed. Please review the schedule below and be ready at the agreed time.</p>

    @include('emails.partials.badge', ['text' => 'Confirmed', 'variant' => 'success'])

    @include('emails.partials.card-open', ['title' => 'Appointment Details'])
        @include('emails.partials.row', ['label' => 'Type', 'value' => e(ucfirst(str_replace('-', ' ', $appointment->appointment_type)))])
        @include('emails.partials.row', ['label' => 'Date & Time', 'value' => '<strong>' . e($appointment->scheduled_at->format('F d, Y \a\t h:i A')) . '</strong>'])
        @include('emails.partials.row', ['label' => 'Duration', 'value' => e($appointment->duration_minutes . ' minutes')])
        @include('emails.partials.row', ['label' => 'Mode', 'value' => e(ucfirst($appointment->meeting_mode))])
        @if($appointment->meeting_link)
            @include('emails.partials.row', ['label' => 'Meeting Link', 'value' => '<a href="' . e($appointment->meeting_link) . '" style="color:#059669;font-weight:600;text-decoration:none;">Join meeting</a>'])
        @endif
        @if($appointment->meeting_location)
            @include('emails.partials.row', ['label' => 'Location', 'value' => e($appointment->meeting_location)])
        @endif
    @include('emails.partials.card-close')

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'Reminder',
        'body' => 'If you need to reschedule or cancel, please contact us as early as possible.',
    ])

    @include('emails.partials.signoff')
@endsection
