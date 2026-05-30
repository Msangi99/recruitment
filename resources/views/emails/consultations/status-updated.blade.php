@extends('emails.layouts.base', [
    'tone' => $consultation->status === 'cancelled' ? 'danger' : ($consultation->status === 'confirmed' ? 'success' : 'brand'),
    'title' => 'Consultation Status Update',
    'preheader' => 'Your consultation status is now ' . ucwords(str_replace('_', ' ', $consultation->status)) . '.',
    'heroTitle' => 'Consultation Update',
    'heroSubtitle' => 'The status of your request has changed',
])

@section('content')
    @php
        $statusVariant = match ($consultation->status) {
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default => 'brand',
        };
        $statusText = ucwords(str_replace('_', ' ', $consultation->status));
    @endphp
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $consultation->name }},</p>
    <p style="margin: 0 0 16px;">The status of your consultation request with Coyzon has been updated.</p>

    @include('emails.partials.badge', ['text' => $statusText, 'variant' => $statusVariant])

    @include('emails.partials.card-open', ['title' => 'Request Summary'])
        @include('emails.partials.row', ['label' => 'Current Status', 'value' => '<strong>' . e($statusText) . '</strong>'])
        @if($consultation->requested_date)
            @include('emails.partials.row', ['label' => 'Scheduled Date', 'value' => e($consultation->requested_date->format('F d, Y h:i A'))])
        @endif
    @include('emails.partials.card-close')

    @if($consultation->status == 'confirmed')
        @include('emails.partials.callout', [
            'variant' => 'success',
            'title' => 'You are all set',
            'body' => 'Your appointment is confirmed. We look forward to meeting with you.',
        ])
    @elseif($consultation->status == 'cancelled')
        @include('emails.partials.callout', [
            'variant' => 'danger',
            'title' => 'Appointment cancelled',
            'body' => 'Your appointment has been cancelled. Please contact us if you have any questions.',
        ])
    @else
        @include('emails.partials.callout', [
            'variant' => 'info',
            'title' => 'Stay tuned',
            'body' => 'We will keep you updated on any further changes to your request.',
        ])
    @endif

    @include('emails.partials.signoff')
@endsection
