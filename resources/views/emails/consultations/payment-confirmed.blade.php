@extends('emails.layouts.base', [
    'tone' => 'success',
    'title' => 'Consultation Confirmed',
    'preheader' => 'Your consultation payment was successful and your booking is confirmed.',
    'heroTitle' => 'Consultation Confirmed',
    'heroSubtitle' => 'Payment received successfully',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $consultation->name }},</p>
    <p style="margin: 0 0 16px;">Thank you for your payment. Your consultation request is now confirmed.</p>

    @include('emails.partials.badge', ['text' => 'Confirmed', 'variant' => 'success'])

    @include('emails.partials.card-open', ['title' => 'Consultation Details'])
        @include('emails.partials.row', ['label' => 'Type', 'value' => e(ucfirst(str_replace('_', ' ', $consultation->type ?? 'consultation')))])
        @if(!empty($consultation->requested_date))
            @include('emails.partials.row', ['label' => 'Scheduled Date', 'value' => '<strong>' . e(\Carbon\Carbon::parse($consultation->requested_date)->format('F d, Y \a\t h:i A')) . '</strong>'])
        @endif
        @if(!empty($consultation->duration_minutes))
            @include('emails.partials.row', ['label' => 'Duration', 'value' => e($consultation->duration_minutes . ' minutes')])
        @endif
        @if(!empty($consultation->amount))
            @include('emails.partials.row', ['label' => 'Amount Paid', 'value' => e(number_format((float) $consultation->amount) . ' TZS')])
        @endif
    @include('emails.partials.card-close')

    @include('emails.partials.callout', [
        'variant' => 'info',
        'title' => 'Before your session',
        'body' => 'Please be available at the scheduled time. Contact us early if you need to reschedule.',
    ])

    @include('emails.partials.signoff')
@endsection
