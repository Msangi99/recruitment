@extends('emails.layouts.base', [
    'tone' => 'success',
    'title' => 'Subscription Activated',
    'preheader' => 'Your Coyzon subscription is now active.',
    'heroTitle' => 'Subscription Activated',
    'heroSubtitle' => 'Your premium access is ready to use',
])

@section('content')
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Dear {{ $user->name }},</p>
    <p style="margin: 0 0 24px;">Congratulations! Your subscription payment was successful and your account has been upgraded.</p>

    @include('emails.partials.badge', ['text' => 'Active', 'variant' => 'success'])

    @include('emails.partials.card-open', ['title' => 'Subscription Details'])
        @include('emails.partials.row', ['label' => 'Plan', 'value' => e($appointment->notes ?? 'Premium Plan')])
        @include('emails.partials.row', ['label' => 'Amount Paid', 'value' => e($appointment->currency . ' ' . number_format($appointment->amount, 2))])
        @include('emails.partials.row', ['label' => 'Activated', 'value' => e($appointment->confirmed_at->format('F d, Y'))])
        @if($appointment->scheduled_at)
            @include('emails.partials.row', ['label' => 'Expires', 'value' => e($appointment->scheduled_at->format('F d, Y'))])
        @endif
        @include('emails.partials.row', ['label' => 'Transaction ID', 'value' => e($appointment->transaction_id ?? $appointment->order_id)])
    @include('emails.partials.card-close')

    @include('emails.partials.callout', [
        'variant' => 'success',
        'title' => 'What happens next?',
        'body' => 'You now have access to premium features, including priority support and streamlined consultation booking.',
    ])

    @include('emails.partials.signoff')
@endsection
