@extends('emails.layouts.base', [
    'tone' => 'brand',
    'title' => 'New Appointment Scheduled',
    'preheader' => 'A new appointment has been scheduled with ' . ($appointment->user->name ?? 'a candidate') . '.',
    'heroTitle' => 'New Appointment',
    'heroSubtitle' => 'A candidate session has been scheduled',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $employer->name }},</p>
    <p style="margin: 0 0 24px;">A new appointment has been scheduled. Please review the details below and confirm your availability.</p>

    @include('emails.partials.card-open', ['title' => 'Appointment Details'])
        @include('emails.partials.row', ['label' => 'Candidate', 'value' => e($appointment->user->name)])
        @include('emails.partials.row', ['label' => 'Type', 'value' => e(ucfirst(str_replace('-', ' ', $appointment->appointment_type)))])
        @include('emails.partials.row', ['label' => 'Date & Time', 'value' => '<strong>' . e($appointment->scheduled_at->format('F d, Y \a\t h:i A')) . '</strong>'])
        @include('emails.partials.row', ['label' => 'Duration', 'value' => e($appointment->duration_minutes . ' minutes')])
        @include('emails.partials.row', ['label' => 'Mode', 'value' => e(ucfirst($appointment->meeting_mode))])
        @if($appointment->meeting_link)
            @include('emails.partials.row', ['label' => 'Meeting Link', 'value' => '<a href="' . e($appointment->meeting_link) . '" style="color:#4F46E5;font-weight:600;text-decoration:none;">Join meeting</a>'])
        @endif
        @if($appointment->meeting_location)
            @include('emails.partials.row', ['label' => 'Location', 'value' => e($appointment->meeting_location)])
        @endif
        @if($appointment->notes)
            @include('emails.partials.row', ['label' => 'Notes', 'value' => e($appointment->notes)])
        @endif
    @include('emails.partials.card-close')

    @include('emails.partials.signoff')
@endsection
